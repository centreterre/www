<?php
/*
 * Centre Terre — migration du site PHP vers HTML statique (option A : crawl du site rendu).
 *
 * À exécuter DANS le conteneur web (cf. run.sh) : il interroge le site servi par
 * Apache sur http://127.0.0.1:80 et utilise l'interpréteur PHP de l'image.
 *
 * Sorties :
 *   - dist/                       : le site statique (HTML + assets)
 *   - cloudfront-function.js      : fonction CloudFront (redirections URLs legacy)
 *   - report.txt                  : rapport de migration
 *
 * Schéma d'URL cible :
 *   FR : /<page>.html                (langue par défaut, à la racine)
 *   EN : /en/<page>.html             (pages mayang* + index uniquement)
 *   ES : /es/<page>.html             (toutes les autres pages)
 *   Billets : /<blog>-<id>.html + variante langue  (ex: /mayang2026-blog-004.html)
 */

$SITE = '/var/www/html';            // racine du dépôt dans le conteneur
$BASE = 'http://127.0.0.1:80';      // Apache dans le conteneur
$HOST = 'www.centre-terre.fr';      // Host envoyé (fidélité de $_SERVER['SERVER_NAME'])
$OUT  = $SITE . '/dist';
$TOOL = dirname(__FILE__);

/* Pages d'entrée volontairement exclues (cassées : incluent un dossier news/ inexistant). */
$SKIP_PAGES = array('news-h1', 'news-h2');

/* Blogs : page d'entrée => (dossier des billets, langues disponibles). */
$BLOGS = array(
    'mayang2026-blog' => array('dir' => 'mayang2026/blog', 'langs' => array('fr', 'en')),
    'up2017-blog'     => array('dir' => 'up2017/news',    'langs' => array('fr', 'es')),
    'up2019-blog'     => array('dir' => 'up2019/news',    'langs' => array('fr', 'es')),
    'up2023-blog'     => array('dir' => 'up2023/news',    'langs' => array('fr', 'es')),
    'up2017-lucas'    => array('dir' => 'up2017/lucas',   'langs' => array('fr', 'es')),
);

/* Pages acceptant ?page= / ?pageIndex= (miroir des entrées qui instancient un BlogManager). */
$PAGE_BLOG = array(
    'index'           => 'mayang2026-blog',
    'mayang2026-blog' => 'mayang2026-blog',
    'up2017-blog'     => 'up2017-blog',
    'up2019-blog'     => 'up2019-blog',
    'up2023-blog'     => 'up2023-blog',
    'up2017-lucas'    => 'up2017-lucas',
);

/* ------------------------------------------------------------------ */
/* Utilitaires                                                         */
/* ------------------------------------------------------------------ */

function rrmdir($dir) {
    if (!is_dir($dir)) return;
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($it as $f) {
        if ($f->isDir()) rmdir($f->getPathname());
        else unlink($f->getPathname());
    }
    rmdir($dir);
}

function fetchUrl($url) {
    global $BASE, $HOST;
    $ctx = stream_context_create(array('http' => array(
        'method'         => 'GET',
        'header'         => "Host: $HOST\r\n",
        'ignore_errors'  => true,
        'timeout'        => 60,
    )));
    $body = @file_get_contents($BASE . $url, false, $ctx);
    $status = 0;
    if (isset($http_response_header) && isset($http_response_header[0])
        && preg_match('/^HTTP\/[\d.]+\s+(\d+)/', $http_response_header[0], $m)) {
        $status = (int)$m[1];
    }
    return array($status, $body === false ? '' : $body);
}

/* ------------------------------------------------------------------ */
/* 1. Inventaire                                                       */
/* ------------------------------------------------------------------ */

$entries = array();
foreach (scandir($SITE) as $f) {
    if (substr($f, -4) !== '.php') continue;
    $name = substr($f, 0, -4);
    if ($name === '' || $name[0] === '.') continue;
    if (in_array($name, $SKIP_PAGES, true)) continue;
    $entries[] = $name;
}
sort($entries);

/*
 * Langues par page — miroir de Utils::init_lang() :
 *   - index et pages mayang* : fr + en (l'espagnol y est coercé vers l'anglais)
 *   - toutes les autres      : fr + es (l'anglais y est coercé vers le français)
 */
$pageLangs = array();
foreach ($entries as $name) {
    $pageLangs[$name] = ($name === 'index' || strpos($name, 'mayang') === 0)
        ? array('fr', 'en')
        : array('fr', 'es');
}

/* Billets par blog, tri croissant (comme scandir dans BlogManager). */
$postsAsc = array();
foreach ($BLOGS as $entry => $conf) {
    $ids = array();
    foreach (scandir($SITE . '/' . $conf['dir'] . '/pages') as $d) {
        if ($d === '.' || $d === '..') continue;
        $ids[] = $d;
    }
    sort($ids);
    $postsAsc[$entry] = $ids;
}

/* pageIndex -> id de billet (BlogManager : array_reverse(scandir), index 0 = plus récent). */
function postByIndex($blog, $idx) {
    global $postsAsc;
    $desc = array_reverse($postsAsc[$blog]);
    return isset($desc[$idx]) ? $desc[$idx] : null;
}

/* ------------------------------------------------------------------ */
/* 2. Cibles (fichiers dist)                                           */
/* ------------------------------------------------------------------ */

/* page => lang => chemin racine ('' pour l'accueil fr). */
$pageTarget = array();
foreach ($pageLangs as $name => $langs) {
    foreach ($langs as $lang) {
        $pageTarget[$name][$lang] = ($lang === 'fr')
            ? (($name === 'index') ? '/' : '/' . $name . '.html')
            : '/' . $lang . '/' . $name . '.html';
    }
}

/* blog => id => lang => chemin racine. */
$postTarget = array();
foreach ($BLOGS as $entry => $conf) {
    foreach ($postsAsc[$entry] as $id) {
        foreach ($conf['langs'] as $lang) {
            $postTarget[$entry][$id][$lang] = ($lang === 'fr')
                ? '/' . $entry . '-' . $id . '.html'
                : '/' . $lang . '/' . $entry . '-' . $id . '.html';
        }
    }
}

/* Langue effective (miroir de la coercition de Utils::init_lang). */
function effLang($lang, $targetLangs) {
    if (in_array($lang, $targetLangs, true)) return $lang;
    if ($lang === 'es' && in_array('en', $targetLangs, true)) return 'en';
    return 'fr';
}

/* ------------------------------------------------------------------ */
/* 3. Plan de crawl                                                    */
/* ------------------------------------------------------------------ */

$crawls = array();
foreach ($pageLangs as $name => $langs) {
    foreach ($langs as $lang) {
        $crawls[] = array(
            'url'  => '/' . rawurlencode($name) . '.php' . ($lang === 'fr' ? '' : '?lang=' . $lang),
            'out'  => ($lang === 'fr' ? '' : $lang . '/') . $name . '.html',
            'page' => $name,
            'lang' => $lang,
            'blog' => isset($PAGE_BLOG[$name]) ? $PAGE_BLOG[$name] : null,
            'post' => null,
        );
    }
}
foreach ($BLOGS as $entry => $conf) {
    foreach ($postsAsc[$entry] as $id) {
        foreach ($conf['langs'] as $lang) {
            $crawls[] = array(
                'url'  => '/' . $entry . '.php?page=' . rawurlencode($id)
                         . ($lang === 'fr' ? '' : '&lang=' . $lang),
                'out'  => ($lang === 'fr' ? '' : $lang . '/') . $entry . '-' . $id . '.html',
                'page' => $entry,
                'lang' => $lang,
                'blog' => $entry,
                'post' => $id,
            );
        }
    }
}

/* ------------------------------------------------------------------ */
/* 4. Réécriture des liens                                             */
/* ------------------------------------------------------------------ */

$GLOBALS['logUnresolved'] = array();
$GLOBALS['logDead']       = array();
$GLOBALS['logNoScheme']   = array();

/*
 * Résout un href/src en URL statique racine-absolute.
 * $ctx : page, lang, blog, post de la page courante.
 * Retourne la nouvelle valeur, ou null pour "garder tel quel".
 */
function resolveAttr($value, $ctx) {
    global $pageLangs, $pageTarget, $postTarget, $PAGE_BLOG, $BLOGS, $SITE;

    $v = trim($value);
    if ($v === '') return null;
    if (preg_match('/^(https?:)?\/\//i', $v)) return null;                            // externe / absolu prod : inchangé
    if (preg_match('/^(#|mailto:|tel:|javascript:|data:)/i', $v)) return null;      // non-URL

    /* Découpage path?query#fragment */
    $path = $v; $query = ''; $frag = '';
    if (preg_match('/^([^?#]*)(?:\?([^#]*))?(?:#(.*))?$/', $v, $m)) {
        $path  = $m[1];
        $query = isset($m[2]) ? $m[2] : '';
        $frag  = isset($m[3]) ? $m[3] : '';
    }
    $params = array();
    if ($query !== '') parse_str($query, $params);

    $p = ltrim($path, '/');
    while (strpos($p, '../') === 0) $p = substr($p, 3);
    /* Les hrefs des pages accentuées sont percent-encodés (via get_flag_href) : décodage. */
    $p = urldecode($p);

    /* Bug de la précompilation .smd : légende collée au chemin de l'image
       (« up2019/…/2019-02-26-36.jpg/@Le collecteur est une rivière de 20 litres »).
       L'URL complète est 404 (en production comme ici) ; le fichier existe au
       chemin tronqué : on coupe au « /@ » dans ce cas seulement. */
    $at = strpos($p, '/@');
    if ($at !== false && is_file($SITE . '/' . substr($p, 0, $at))) {
        $p = substr($p, 0, $at);
    }

    /* Code mort (player projekktor / stream.php) : neutralisé. */
    if (strpos($p, 'stream/') === 0) {
        $GLOBALS['logDead'][] = $v;
        return '#';
    }

    /* Détermination de la cible */
    $targetPage = null;
    if ($p === '') {
        /* "?lang=xx" ou "?pageIndex=n" : la page courante */
        $targetPage = $ctx['page'];
    } elseif ($p === 'index.php' || $p === 'index' || $p === '/') {
        $targetPage = 'index';
    } else {
        $n = preg_replace('/\.php$/', '', $p);
        if (isset($pageLangs[$n])) {
            $targetPage = $n;
        }
    }

    if ($targetPage === null) {
        /* Asset (image, css, js, pdf...) : chemin racine-absolute, query conservée.
           Répertoires hébergés côté serveur mais absents du dépôt git : préfixés
           quand même (ils existeront après synchronisation). */
        global $SITE;
        $serverOnly = (strpos($p, 'documents/') === 0 || strpos($p, 'forum/') === 0);
        if (!$serverOnly && !is_file($SITE . '/' . $p) && !is_dir($SITE . '/' . $p)) {
            /* Fichier absent : on ne touche pas au lien (lien déjà cassé en
               production, ex. "www.orioncs.fr" sans schéma, image manquante) :
               journalisé pour le rapport. */
            $GLOBALS['logUnresolved'][] = $value;
            return null;
        }
        return '/' . $p . ($query !== '' ? '?' . $query : '') . ($frag !== '' ? '#' . $frag : '');
    }

    /* Billet cible ? (?page= prioritaire sur ?pageIndex=)
       Sur une page billet, un lien relatif sans page/pageIndex désigne le billet courant
       (drapeaux de langue) ; un paramètre page/pageIndex le surcharge (pagination). */
    $targetBlog  = null;
    $targetPost  = null;
    if ($p === '' && $ctx['post'] !== null) {
        $targetBlog = $ctx['blog'];
        $targetPost = $ctx['post'];
    }
    if (isset($params['page']) || isset($params['pageIndex'])) {
        if ($targetBlog === null) {
            $targetBlog = isset($PAGE_BLOG[$targetPage]) ? $PAGE_BLOG[$targetPage] : $ctx['blog'];
        }
        if (isset($params['page'])) {
            $targetPost = $params['page'];
        } elseif (isset($params['pageIndex'])) {
            $targetPost = postByIndex($targetBlog, (int)$params['pageIndex']);
        }
    }

    /* Langue cible : paramètre explicite, sinon langue de la page courante
       (miroir du comportement par session PHP : les liens "nus" conservent la langue). */
    $lang = isset($params['lang']) ? $params['lang'] : $ctx['lang'];

    if ($targetPost !== null && $targetBlog !== null) {
        if (!isset($postTarget[$targetBlog][$targetPost])) {
            $GLOBALS['logUnresolved'][] = $value . ' (billet inconnu)';
            return null;
        }
        $targetLangs = $BLOGS[$targetBlog]['langs'];
        $eff = effLang($lang, $targetLangs);
        $u = $postTarget[$targetBlog][$targetPost][$eff];
    } else {
        $targetLangs = $pageLangs[$targetPage];
        $eff = effLang($lang, $targetLangs);
        $u = $pageTarget[$targetPage][$eff];
    }

    return $u . ($frag !== '' ? '#' . $frag : '');
}

function rewriteHtml($html, $ctx) {
    /* Groupe B : coquilles dans les contenus précompilés (.txt/.smd, hors
       périmètre), corrigées en post-traitement sur le seul nom de fichier —
       couvre href (fancybox) et src (img), quel que soit le préfixe du chemin :
       - billet 008 EN : l'image mayang-2026-blog-008-007.jpg (numérotation à 3
         chiffres) est référencée -07.jpg ;
       - news 021 ES : img007.jpg est référencée im007.jpg, sans le « g »
         (série img001…img011 ; la version FR, même photo, référence bien
         img007.jpg). */
    $html = str_replace('mayang-2026-blog-008-07.jpg', 'mayang-2026-blog-008-007.jpg', $html);
    $html = str_replace('im007.jpg', 'img007.jpg', $html);

    /* Groupe C : bugs sponsors.
       - SponsorsManager.php déduit le nom du logo en supprimant tout ce qui
         précède le premier tiret du dossier — incorrect pour les sponsors
         multi-mots sans préfixe numérique : broadley-james → james.png alors
         que le logo fourni est broadley-james.png (convention des dossiers
         up2019 sans préfixe, nommé comme le dossier).
       - asskool.png n'existe nulle part (logo jamais fourni) : sur décision
         explicite, l'image cassée et son ancre (qui ne l'enveloppe que pour
         l'image, href javascript:void(0);) sont retirées ; le bloc texte du
         sponsor reste. */
    $html = str_replace('broadley-james/james.png', 'broadley-james/broadley-james.png', $html);
    $html = str_replace(
        '<a href="javascript:void(0);"> <img class="img-responsive img-hover" src="up2023/sponsors/0420-asskool/asskool.png" alt=""></a>',
        '',
        $html
    );

    /* Groupe D : bloc « team-member » fantôme — bug feof de TeamManager.renderPage()
       + ligne vide finale de mayang2026/equipe1/equipe1.txt (171 = 34*5 + 1) → 35e
       entrée vide : <img> pointant vers le dossier equipe1/, nom et rôle vides.
       Triple condition (src finissant par "/", h4 vide, p vide) : aucun membre réel
       ne peut matcher (h4/p toujours renseignés). */
    $html = preg_replace(
        '~<div class="team-member">\s*<img\b[^>]*\bsrc="[^"]*/"[^>]*>\s*<h4[^>]*>\s*</h4>\s*<p[^>]*>\s*</p>\s*</div>~',
        '',
        $html
    );

    $attrRe = '/\s(href|src|action|data-original|data-href)\s*=\s*("([^"]*)"|\'([^\']*)\')/i';
    $html = preg_replace_callback($attrRe, function ($m) use ($ctx) {
        $quote = ($m[2][0] === '"') ? '"' : "'";
        $val   = ($quote === '"') ? $m[3] : $m[4];
        $new   = resolveAttr($val, $ctx);
        if ($new === null) return $m[0];
        return ' ' . $m[1] . '=' . $quote . $new . $quote;
    }, $html);

    /* url(...) dans les attributs style (bannières). */
    $styleRe = '/\bstyle\s*=\s*("([^"]*)"|\'([^\']*)\')/i';
    $html = preg_replace_callback($styleRe, function ($m) {
        $quote = ($m[1][0] === '"') ? '"' : "'";
        $inner = ($quote === '"') ? $m[2] : $m[3];
        $inner = preg_replace_callback('/url\((["\']?)([^)"\']+)\1/i', function ($u) {
            $path = trim($u[2]);
            if ($path === '' || preg_match('/^(https?:)?\/\//i', $path) || $path[0] === '/') return $u[0];
            return 'url(' . $u[1] . '/' . $path . $u[1];
        }, $inner);
        return 'style=' . $quote . $inner . $quote;
    }, $html);

    return $html;
}

/* ------------------------------------------------------------------ */
/* 5. Exécution du crawl                                               */
/* ------------------------------------------------------------------ */

rrmdir($OUT);
if (!mkdir($OUT, 0755, true)) die("Impossible de créer $OUT\n");
mkdir($OUT . '/en', 0755, true);
mkdir($OUT . '/es', 0755, true);

echo "Migration : " . count($crawls) . " pages à générer\n";

$failures  = array();
$generated = 0;
$t0 = microtime(true);
foreach ($crawls as $i => $c) {
    list($status, $body) = fetchUrl($c['url']);
    if ($status !== 200 || $body === '') {
        $failures[] = sprintf('HTTP %s pour %s (attendu: %s)', $status, $c['url'], $c['out']);
        continue;
    }
    $ctx = array('page' => $c['page'], 'lang' => $c['lang'], 'blog' => $c['blog'], 'post' => $c['post']);
    $html = rewriteHtml($body, $ctx);

    $dest = $OUT . '/' . $c['out'];
    @mkdir(dirname($dest), 0755, true);
    file_put_contents($dest, $html);
    $generated++;
    if (($i + 1) % 25 === 0) echo '  ... ' . ($i + 1) . '/' . count($crawls) . "\n";
}
$elapsed = round(microtime(true) - $t0, 1);
echo "  $generated pages générées en ${elapsed}s\n";

/* ------------------------------------------------------------------ */
/* 6. Copie des assets                                                 */
/* ------------------------------------------------------------------ */

$exclDirPrefixes = array('dist/', '.git/', '.idea/', 'target/', 'src/', 'tools/', 'classes/', 'common/');
/* .html exclus : les pages de dist/ viennent exclusivement du crawl. Un .html
   parasite posé à la racine du dépôt (sonde, essai...) serait sinon recopié
   par-dessus la page crawlée correspondante — incident réel : un .html résiduel
   a écrasé dist/mayang2026-equipe.html en cours de run (mtime = fin de copie). */
$exclFileRe      = '~\.(php|smd|txt|log|iml|class|html)$~';
$exclRootFiles   = array('pom.xml', '.htaccess', '.gitattributes', '.gitignore', 'sitemap.xml');

$it = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($SITE, FilesystemIterator::SKIP_DOTS)
);
$copied = 0;
foreach ($it as $f) {
    if (!$f->isFile()) continue;
    $rel = str_replace('\\', '/', substr($f->getPathname(), strlen($SITE) + 1));
    $skip = false;
    foreach ($exclDirPrefixes as $pfx) {
        if (strpos($rel, $pfx) === 0) { $skip = true; break; }
    }
    if ($skip) continue;
    if (strpos($rel, '/') === false && in_array($rel, $exclRootFiles, true)) continue; // fichiers racine exclus
    if ($rel === 'robots.txt') { /* conservé */ }
    elseif (preg_match($exclFileRe, $rel)) continue;

    $dest = $OUT . '/' . $rel;
    @mkdir(dirname($dest), 0755, true);
    copy($f->getPathname(), $dest);
    $copied++;
}
echo "  $copied assets copiés\n";

/* ------------------------------------------------------------------ */
/* 7. Sitemap                                                          */
/* ------------------------------------------------------------------ */

/* Groupes : une page (ou un billet) = un ensemble de variantes de langue. */
$groups = array();
foreach ($pageLangs as $name => $langs) {
    if (strpos($name, '-print') !== false) continue; // pages imprimables : hors sitemap (cf. robots.txt)
    $variants = array();
    foreach ($langs as $lang) $variants[$lang] = $pageTarget[$name][$lang];
    $groups[] = $variants;
}
foreach ($BLOGS as $entry => $conf) {
    foreach ($postsAsc[$entry] as $id) {
        $variants = array();
        foreach ($conf['langs'] as $lang) $variants[$lang] = $postTarget[$entry][$id][$lang];
        $groups[] = $variants;
    }
}

$sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
$sitemap .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";
foreach ($groups as $variants) {
    foreach ($variants as $lang => $path) {
        $sitemap .= "    <url>\n";
        $sitemap .= '        <loc>https://' . $HOST . ($path === '/' ? '/' : $path) . "</loc>\n";
        foreach ($variants as $l2 => $p2) {
            $sitemap .= '        <xhtml:link rel="alternate" hreflang="' . $l2 . '"'
                . ' href="https://' . $HOST . ($p2 === '/' ? '/' : $p2) . '"/>' . "\n";
        }
        $sitemap .= "    </url>\n";
    }
}
$sitemap .= '</urlset>' . "\n";
file_put_contents($OUT . '/sitemap.xml', $sitemap);
echo '  sitemap.xml : ' . count($groups) . " groupes\n";

/* ------------------------------------------------------------------ */
/* 8. Fonction CloudFront (redirections URLs legacy)                   */
/* ------------------------------------------------------------------ */

$fnPages   = array(); // page => cible fr (fichier)
$fnLangs   = array(); // page => langues
foreach ($pageLangs as $name => $langs) {
    $fnPages[$name] = ($name === 'index') ? 'index.html' : $name . '.html';
    $fnLangs[$name] = $langs;
}
$fnPosts  = array();  // blog => id => cible fr
$fnByIndex = array(); // blog => pageIndex => cible fr
foreach ($BLOGS as $entry => $conf) {
    $fnPosts[$entry] = array();
    foreach ($postsAsc[$entry] as $id) {
        $fnPosts[$entry][$id] = $entry . '-' . $id . '.html';
    }
    $desc = array_reverse($postsAsc[$entry]);
    foreach ($desc as $idx => $id) {
        $fnByIndex[$entry][(string)$idx] = $entry . '-' . $id . '.html';
    }
}
$fnAlias = $PAGE_BLOG;

$je = defined('JSON_UNESCAPED_SLASHES') ? (JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : 0;
$js = <<<EOT
// Généré par tools/static-migrate/migrate.php — ne pas éditer à la main.
// Fonction CloudFront (viewer request) assurant la continuité des URLs legacy.

var PAGE_TARGETS   = __PAGES__;
var PAGE_LANGS     = __LANGS__;
var BLOG_ALIAS     = __ALIAS__;
var BLOG_POSTS     = __POSTS__;
var POSTS_BY_INDEX = __BYINDEX__;

function handler(event) {
    var request = event.request;
    var uri = request.uri;
    var params = {};
    var qs = request.querystring;
    if (qs) {
        for (var k in qs) { params[k] = qs[k].value; }
    }

    // Alias historiques (.htaccess)
    if (uri === '/fr')        { return redirect301('/'); }
    if (uri === '/en')        { return redirect301('/en/index.html'); }
    if (uri === '/es')        { return redirect301('/es/index.html'); }
    if (uri === '/boutique')  { return redirect301('https://www.etsy.com/fr/shop/CentreTerre'); }

    var name = null;
    var isPhp = false;
    var m = uri.match(/^\\/(.*)\\.php$/);
    if (m) {
        name = m[1];
        isPhp = true;
    } else if (uri === '/') {
        name = 'index';
    } else {
        var n = uri.replace(/^\\/+|\\/+$/g, '');
        if (n && !/\\.[a-z0-9]+$/i.test(n)) { name = n; }
    }
    if (!name) { return request; }
    try { name = decodeURIComponent(name); } catch (e) {}

    if (!PAGE_TARGETS[name]) { return request; }

    var hasLegacyQuery = !!(params.page || params.pageIndex !== undefined || params.lang);

    // URL extensionless sans paramètre : servir directement le .html (200, URL inchangée)
    if (!isPhp && !hasLegacyQuery) {
        request.uri = encodeURI('/' + PAGE_TARGETS[name]);
        return request;
    }

    // URL legacy (.php ou avec paramètres) : 301 vers la cible canonique
    var target = PAGE_TARGETS[name];
    var blog = BLOG_ALIAS[name];
    if (blog && (params.page || params.pageIndex !== undefined)) {
        var post = null;
        if (params.page) {
            post = BLOG_POSTS[blog][params.page];
        } else {
            post = POSTS_BY_INDEX[blog][String(parseInt(params.pageIndex, 10))];
        }
        if (post) { target = post; }
    }

    var lang = params.lang || 'fr';
    var langs = PAGE_LANGS[name];
    var eff = (langs.indexOf(lang) !== -1) ? lang : (lang === 'es' ? 'en' : 'fr');

    var path = (eff === 'fr' ? '' : '/' + eff) + '/' + target;
    if (path === '/index.html') { path = '/'; }
    return redirect301(path);
}

function redirect301(location) {
    return {
        statusCode: 301,
        statusDescription: 'Moved Permanently',
        headers: { location: { value: encodeURI(location) } }
    };
}
EOT;
$js = str_replace(
    array('__PAGES__', '__LANGS__', '__ALIAS__', '__POSTS__', '__BYINDEX__'),
    array(
        json_encode($fnPages, $je),
        json_encode($fnLangs, $je),
        json_encode($fnAlias, $je),
        json_encode($fnPosts, $je),
        json_encode($fnByIndex, $je),
    ),
    $js
);
file_put_contents($TOOL . '/cloudfront-function.js', $js);
echo "  cloudfront-function.js généré\n";

/* ------------------------------------------------------------------ */
/* 9. Vérification des liens                                           */
/* ------------------------------------------------------------------ */

$broken = array();
$warnDoc = array();
$attrRe = '/\s(href|src|action|data-original|data-href)\s*=\s*("([^"]*)"|\'([^\']*)\')/i';

$dit = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($OUT, FilesystemIterator::SKIP_DOTS)
);
foreach ($dit as $f) {
    if (!$f->isFile() || substr($f->getPathname(), -5) !== '.html') continue;
    $html = file_get_contents($f->getPathname());
    if (!preg_match_all($attrRe, $html, $matches, PREG_SET_ORDER)) continue;
    foreach ($matches as $m) {
        $val = ($m[2][0] === '"') ? $m[3] : $m[4];
        $v = trim($val);
        if ($v === '' || $v[0] === '#') continue;
        if (preg_match('/^(https?:)?\/\//i', $v)) continue;
        if (preg_match('/^(mailto:|tel:|javascript:|data:)/i', $v)) continue;
        $pathOnly = preg_replace('/[?#].*$/', '', $v);
        if ($pathOnly === '') continue;
        /* Liens externes sans schéma (ex. "www.orioncs.fr") : cassés en production,
           conservés tels quels — signalés à part, sans préfixage. */
        if (preg_match('~^([a-z0-9-]+\.)?[a-z0-9-]+\.[a-z]{2,}(/|$)~i', $pathOnly)) {
            $GLOBALS['logNoScheme'][] = $pathOnly;
            continue;
        }
        if ($pathOnly === '/') $pathOnly = '/index.html'; /* lien logo -> accueil */
        $target = $OUT . '/' . ltrim($pathOnly, '/');
        if (is_file($target)) continue;
        if (strpos($pathOnly, '/documents/') === 0 || strpos($pathOnly, '/forum/') === 0) {
            $warnDoc[$pathOnly] = true; // à synchroniser depuis le serveur (hors dépôt git)
        } else {
            $broken[] = substr($f->getPathname(), strlen($OUT) + 1) . ' -> ' . $v;
        }
    }
}
echo '  liens internes cassés : ' . count($broken) . "\n";

/* ------------------------------------------------------------------ */
/* 9b. Garde-fou : erreurs PHP injectées dans le HTML généré           */
/* ------------------------------------------------------------------ */

/* run.sh éteint display_errors dans le conteneur de crawl. La production, elle, l'a
   activé : les mêmes warnings y sont émis, mais ils tombent dans des attributs
   class="..." (invisibles pour le visiteur). On génère un HTML propre (rendu identique).
   Toute erreur PHP visible dans le HTML signifie une régression de ce réglage
   (ou une nouvelle erreur latente) : on la détecte et on fait échouer la migration.
   Filtre "on line" / "/var/www/" pour éviter les faux positifs (mot "Warning" dans le
   contenu réel des pages). */
$phpErrors = array();
$errRe = '~(?:<b>\s*)?(Warning|Notice|Deprecated|Strict Standards|Fatal error|Parse error)(?:\s*</b>)?\s*:[^<]{0,400}~i';
$hit = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($OUT, FilesystemIterator::SKIP_DOTS)
);
foreach ($hit as $f) {
    if (!$f->isFile() || substr($f->getPathname(), -5) !== '.html') continue;
    $html = file_get_contents($f->getPathname());
    if (!preg_match_all($errRe, $html, $mm, PREG_SET_ORDER)) continue;
    foreach ($mm as $x) {
        if (strpos($x[0], 'on line') === false && strpos($x[0], '/var/www/') === false) continue;
        $msg = preg_replace('/\s+/', ' ', trim(strip_tags($x[0])));
        $phpErrors[] = substr($f->getPathname(), strlen($OUT) + 1) . ' : ' . substr($msg, 0, 160);
    }
}
echo '  erreurs PHP injectées : ' . count($phpErrors) . "\n";

/* ------------------------------------------------------------------ */
/* 10. Rapport                                                         */
/* ------------------------------------------------------------------ */

$dirSize = 0;
$rit = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($OUT, FilesystemIterator::SKIP_DOTS));
foreach ($rit as $f) { if ($f->isFile()) $dirSize += $f->getSize(); }

$r = array();
date_default_timezone_set('Europe/Paris');
$r[] = "RAPPORT DE MIGRATION PHP -> STATIQUE";
$r[] = "Date : " . date('Y-m-d H:i:s');
$r[] = "";
$r[] = "Pages générées : $generated / " . count($crawls) . " (FR racine, /en/, /es/, billets inclus)";
$r[] = "Assets copiés   : $copied";
$r[] = "Taille dist/   : " . round($dirSize / 1048576, 1) . " Mo";
$r[] = "";
$r[] = "ÉCHECS (" . count($failures) . ") :";
foreach ($failures as $f) $r[] = "  - $f";
$r[] = "";
$r[] = "ERREURS PHP INJECTÉES DANS LE HTML (" . count($phpErrors) . ") :";
foreach ($phpErrors as $e) $r[] = "  - $e";
$r[] = "";
$r[] = "LIENS INTERNES CASSÉS (" . count($broken) . ") :";
foreach ($broken as $b) $r[] = "  - $b";
$r[] = "";
$r[] = "LIENS VERS documents/ ou forum/ (" . count($warnDoc) . " cibles distinctes — à synchroniser depuis le serveur, hors dépôt git) :";
foreach (array_keys($warnDoc) as $w) $r[] = "  - $w";
$r[] = "";
$r[] = "LIENS NON RÉSOLUS (conservés tels quels) (" . count($GLOBALS['logUnresolved']) . ") :";
foreach ($GLOBALS['logUnresolved'] as $u) $r[] = "  - $u";
$r[] = "";
$r[] = "LIENS MORTS NEUTRALISÉS (" . count($GLOBALS['logDead']) . ") :";
foreach ($GLOBALS['logDead'] as $d) $r[] = "  - $d";
$r[] = "";
$r[] = "LIENS EXTERNES SANS SCHÉMA (déjà cassés en production, conservés tels quels) (" . count($GLOBALS['logNoScheme']) . ") :";
foreach (array_unique($GLOBALS['logNoScheme']) as $d) $r[] = "  - $d";
$r[] = "";
$r[] = "NOTES :";
$r[] = "  - Pages exclues (cassées) : " . implode(', ', $SKIP_PAGES);
$r[] = "  - Warnings PHP : la production a display_errors=On, mais tous ces warnings tombent dans";
$r[] = "    des attributs class=\"...\" du menu (invisibles pour le visiteur). Le HTML statique est";
$r[] = "    généré propre (display_errors=Off dans le conteneur de crawl, cf. run.sh) : rendu identique.";
$r[] = "  - Découverte : la distribution CloudFront actuelle de la prod ignore les query strings dans";
$r[] = "    sa clé de cache — les URLs ?lang=xx servent la langue remplie en dernier dans le cache";
$r[] = "    (langues non déterministes en ligne ; l'origine, elle, sert la bonne langue). Le site";
$r[] = "    statique (/es/, /en/ + fonction CF) corrige ce problème.";
$r[] = "  - L'accueil n'a pas de variante espagnole : le blog mayang2026 n'existe qu'en fr/en";
$r[] = "    (comportement fidèle à la production où ?lang=es sur /index.php est coercé en anglais).";
$r[] = "  - Les pages *-print restent exclues du sitemap (robots.txt : Disallow /*print*).";
$r[] = "  - documents/ (PDFs), forum/ (service à part), backoffice/ (admin) ne sont pas dans le dépôt git :";
$r[] = "    documents/ et forum/ doivent être synchronisés depuis le serveur actuel.";
$r[] = "  - ATTENTION : plusieurs PDFs sous documents/ renvoient 404 sur la production actuelle";
$r[] = "    (ex. CT-UP2017-PLAQUETTE-6P-LIGHT-FR.pdf) : liens déjà cassés avant migration, à vérifier";
$r[] = "    côté serveur (arborescence documents/ éventuellement différente) avant synchronisation.";
$r[] = "  - Le player projekktor et common/stream.php sont du code mort : non migrés.";
file_put_contents($TOOL . '/report.txt', implode("\n", $r) . "\n");

echo "\nRapport : $TOOL/report.txt\n";
if ($failures) { echo "ATTENTION : " . count($failures) . " échecs\n"; exit(1); }
if ($phpErrors) { echo "ERREUR : " . count($phpErrors) . " erreurs PHP injectées dans le HTML — vérifier display_errors dans le conteneur (cf. run.sh)\n"; exit(1); }
if ($broken)   { echo "ATTENTION : " . count($broken) . " liens cassés\n"; }
exit(0);
