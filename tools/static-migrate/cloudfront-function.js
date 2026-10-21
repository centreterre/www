// Généré par tools/static-migrate/migrate.php — ne pas éditer à la main.
// Fonction CloudFront (viewer request) assurant la continuité des URLs legacy.

var PAGE_TARGETS   = {"centre-terre-asso":"centre-terre-asso.html","centre-terre-expe":"centre-terre-expe.html","centre-terre-orga":"centre-terre-orga.html","espacio-escolar-chile-presentation":"espacio-escolar-chile-presentation.html","espacio-escolar-chile-recursos-datos-científicos-brutos":"espacio-escolar-chile-recursos-datos-científicos-brutos.html","espacio-escolar-chile-recursos-fichas-c2":"espacio-escolar-chile-recursos-fichas-c2.html","espacio-escolar-chile-recursos-fichas-c3":"espacio-escolar-chile-recursos-fichas-c3.html","espacio-escolar-chile-recursos-fichas-c4":"espacio-escolar-chile-recursos-fichas-c4.html","espacio-escolar-chile-recursos-fichas-logísticas":"espacio-escolar-chile-recursos-fichas-logísticas.html","espacio-escolar-chile-recursos-fotos":"espacio-escolar-chile-recursos-fotos.html","espacio-escolar-chile-recursos-mapas":"espacio-escolar-chile-recursos-mapas.html","espacio-escolar-chile-recursos-presentaciones":"espacio-escolar-chile-recursos-presentaciones.html","espacio-escolar-chile-recursos-sobre-las-fichas-pedagógicas":"espacio-escolar-chile-recursos-sobre-las-fichas-pedagógicas.html","gallery-up2010":"gallery-up2010.html","index":"index.html","mayang2026-blog":"mayang2026-blog.html","mayang2026-donateurs":"mayang2026-donateurs.html","mayang2026-equipe":"mayang2026-equipe.html","mayang2026-partenaires":"mayang2026-partenaires.html","mayang2026-plaquette":"mayang2026-plaquette.html","mayang2026-pressbook":"mayang2026-pressbook.html","mayang2026-print":"mayang2026-print.html","mayang2026-projet-scientifique":"mayang2026-projet-scientifique.html","projet-scolaire-forum":"projet-scolaire-forum.html","projet-scolaire-ressources-cartographies":"projet-scolaire-ressources-cartographies.html","projet-scolaire-ressources-fiches-a-propos":"projet-scolaire-ressources-fiches-a-propos.html","projet-scolaire-ressources-fiches-cycle2":"projet-scolaire-ressources-fiches-cycle2.html","projet-scolaire-ressources-fiches-cycle3":"projet-scolaire-ressources-fiches-cycle3.html","projet-scolaire-ressources-fiches-cycle4":"projet-scolaire-ressources-fiches-cycle4.html","projet-scolaire-ressources-fiches-donnees-brutes-sciences":"projet-scolaire-ressources-fiches-donnees-brutes-sciences.html","projet-scolaire-ressources-fiches-logistique":"projet-scolaire-ressources-fiches-logistique.html","projet-scolaire-ressources-fiches-propositions-pedagogiques-litteraires":"projet-scolaire-ressources-fiches-propositions-pedagogiques-litteraires.html","projet-scolaire-ressources-photographies":"projet-scolaire-ressources-photographies.html","projet-scolaire-sommaire":"projet-scolaire-sommaire.html","projet-scolaire-up2017-bilan":"projet-scolaire-up2017-bilan.html","projet-scolaire-up2017-realisations-laureates":"projet-scolaire-up2017-realisations-laureates.html","projet-scolaire-up2019-bilan":"projet-scolaire-up2019-bilan.html","projet-scolaire-up2019-realisations-laureates":"projet-scolaire-up2019-realisations-laureates.html","projet-scolaire-up2023-bilan":"projet-scolaire-up2023-bilan.html","projet-scolaire-up2023-lien-avec-les-programmes":"projet-scolaire-up2023-lien-avec-les-programmes.html","projet-scolaire-up2023-modalites-suivi":"projet-scolaire-up2023-modalites-suivi.html","projet-scolaire-up2023-pourquoi-retourner-en-patagonie":"projet-scolaire-up2023-pourquoi-retourner-en-patagonie.html","projet-scolaire-up2023-presentation":"projet-scolaire-up2023-presentation.html","projet-scolaire-up2023-realisations-laureates":"projet-scolaire-up2023-realisations-laureates.html","projet-scolaire-up2023-responsabilite":"projet-scolaire-up2023-responsabilite.html","projet-scolaire-up2023-valeurs-educatives":"projet-scolaire-up2023-valeurs-educatives.html","shop":"shop.html","up2017-blog":"up2017-blog.html","up2017-booklet":"up2017-booklet.html","up2017-com":"up2017-com.html","up2017-downloads":"up2017-downloads.html","up2017-jose":"up2017-jose.html","up2017-lucas":"up2017-lucas.html","up2017-partenaires-institutionnels":"up2017-partenaires-institutionnels.html","up2017-partenaires-participatif":"up2017-partenaires-participatif.html","up2017-pressbook":"up2017-pressbook.html","up2017-print":"up2017-print.html","up2017-project-base":"up2017-project-base.html","up2017-project-main":"up2017-project-main.html","up2017-project-scientific":"up2017-project-scientific.html","up2017-team":"up2017-team.html","up2019-appel-dons":"up2019-appel-dons.html","up2019-blog":"up2019-blog.html","up2019-com":"up2019-com.html","up2019-donateurs":"up2019-donateurs.html","up2019-partenaires":"up2019-partenaires.html","up2019-plaquette":"up2019-plaquette.html","up2019-print":"up2019-print.html","up2019-project-main":"up2019-project-main.html","up2019-projet-scientifique":"up2019-projet-scientifique.html","up2019-team":"up2019-team.html","up2023-appel-dons":"up2023-appel-dons.html","up2023-blog":"up2023-blog.html","up2023-donateurs":"up2023-donateurs.html","up2023-equipe":"up2023-equipe.html","up2023-partenaires":"up2023-partenaires.html","up2023-plaquette":"up2023-plaquette.html","up2023-pressbook":"up2023-pressbook.html","up2023-print":"up2023-print.html","up2023-projet-scientifique":"up2023-projet-scientifique.html"};
var PAGE_LANGS     = {"centre-terre-asso":["fr","es"],"centre-terre-expe":["fr","es"],"centre-terre-orga":["fr","es"],"espacio-escolar-chile-presentation":["fr","es"],"espacio-escolar-chile-recursos-datos-científicos-brutos":["fr","es"],"espacio-escolar-chile-recursos-fichas-c2":["fr","es"],"espacio-escolar-chile-recursos-fichas-c3":["fr","es"],"espacio-escolar-chile-recursos-fichas-c4":["fr","es"],"espacio-escolar-chile-recursos-fichas-logísticas":["fr","es"],"espacio-escolar-chile-recursos-fotos":["fr","es"],"espacio-escolar-chile-recursos-mapas":["fr","es"],"espacio-escolar-chile-recursos-presentaciones":["fr","es"],"espacio-escolar-chile-recursos-sobre-las-fichas-pedagógicas":["fr","es"],"gallery-up2010":["fr","es"],"index":["fr","en"],"mayang2026-blog":["fr","en"],"mayang2026-donateurs":["fr","en"],"mayang2026-equipe":["fr","en"],"mayang2026-partenaires":["fr","en"],"mayang2026-plaquette":["fr","en"],"mayang2026-pressbook":["fr","en"],"mayang2026-print":["fr","en"],"mayang2026-projet-scientifique":["fr","en"],"projet-scolaire-forum":["fr","es"],"projet-scolaire-ressources-cartographies":["fr","es"],"projet-scolaire-ressources-fiches-a-propos":["fr","es"],"projet-scolaire-ressources-fiches-cycle2":["fr","es"],"projet-scolaire-ressources-fiches-cycle3":["fr","es"],"projet-scolaire-ressources-fiches-cycle4":["fr","es"],"projet-scolaire-ressources-fiches-donnees-brutes-sciences":["fr","es"],"projet-scolaire-ressources-fiches-logistique":["fr","es"],"projet-scolaire-ressources-fiches-propositions-pedagogiques-litteraires":["fr","es"],"projet-scolaire-ressources-photographies":["fr","es"],"projet-scolaire-sommaire":["fr","es"],"projet-scolaire-up2017-bilan":["fr","es"],"projet-scolaire-up2017-realisations-laureates":["fr","es"],"projet-scolaire-up2019-bilan":["fr","es"],"projet-scolaire-up2019-realisations-laureates":["fr","es"],"projet-scolaire-up2023-bilan":["fr","es"],"projet-scolaire-up2023-lien-avec-les-programmes":["fr","es"],"projet-scolaire-up2023-modalites-suivi":["fr","es"],"projet-scolaire-up2023-pourquoi-retourner-en-patagonie":["fr","es"],"projet-scolaire-up2023-presentation":["fr","es"],"projet-scolaire-up2023-realisations-laureates":["fr","es"],"projet-scolaire-up2023-responsabilite":["fr","es"],"projet-scolaire-up2023-valeurs-educatives":["fr","es"],"shop":["fr","es"],"up2017-blog":["fr","es"],"up2017-booklet":["fr","es"],"up2017-com":["fr","es"],"up2017-downloads":["fr","es"],"up2017-jose":["fr","es"],"up2017-lucas":["fr","es"],"up2017-partenaires-institutionnels":["fr","es"],"up2017-partenaires-participatif":["fr","es"],"up2017-pressbook":["fr","es"],"up2017-print":["fr","es"],"up2017-project-base":["fr","es"],"up2017-project-main":["fr","es"],"up2017-project-scientific":["fr","es"],"up2017-team":["fr","es"],"up2019-appel-dons":["fr","es"],"up2019-blog":["fr","es"],"up2019-com":["fr","es"],"up2019-donateurs":["fr","es"],"up2019-partenaires":["fr","es"],"up2019-plaquette":["fr","es"],"up2019-print":["fr","es"],"up2019-project-main":["fr","es"],"up2019-projet-scientifique":["fr","es"],"up2019-team":["fr","es"],"up2023-appel-dons":["fr","es"],"up2023-blog":["fr","es"],"up2023-donateurs":["fr","es"],"up2023-equipe":["fr","es"],"up2023-partenaires":["fr","es"],"up2023-plaquette":["fr","es"],"up2023-pressbook":["fr","es"],"up2023-print":["fr","es"],"up2023-projet-scientifique":["fr","es"]};
var BLOG_ALIAS     = {"index":"mayang2026-blog","mayang2026-blog":"mayang2026-blog","up2017-blog":"up2017-blog","up2019-blog":"up2019-blog","up2023-blog":"up2023-blog","up2017-lucas":"up2017-lucas"};
var BLOG_POSTS     = {"mayang2026-blog":{"001":"mayang2026-blog-001.html","002":"mayang2026-blog-002.html","003":"mayang2026-blog-003.html","004":"mayang2026-blog-004.html","005":"mayang2026-blog-005.html","006":"mayang2026-blog-006.html","007":"mayang2026-blog-007.html","008":"mayang2026-blog-008.html"},"up2017-blog":{"018":"up2017-blog-018.html","019":"up2017-blog-019.html","020":"up2017-blog-020.html","021":"up2017-blog-021.html","022":"up2017-blog-022.html","023":"up2017-blog-023.html","024":"up2017-blog-024.html","025":"up2017-blog-025.html","026":"up2017-blog-026.html","027":"up2017-blog-027.html","028":"up2017-blog-028.html","029":"up2017-blog-029.html","030":"up2017-blog-030.html","031":"up2017-blog-031.html","032":"up2017-blog-032.html","033":"up2017-blog-033.html","034":"up2017-blog-034.html","035":"up2017-blog-035.html","036":"up2017-blog-036.html"},"up2019-blog":{"001":"up2019-blog-001.html","002":"up2019-blog-002.html","003":"up2019-blog-003.html","004":"up2019-blog-004.html","005":"up2019-blog-005.html","006":"up2019-blog-006.html","007":"up2019-blog-007.html","008":"up2019-blog-008.html","009":"up2019-blog-009.html","010":"up2019-blog-010.html","011":"up2019-blog-011.html","012":"up2019-blog-012.html","013":"up2019-blog-013.html","014":"up2019-blog-014.html","015":"up2019-blog-015.html","016":"up2019-blog-016.html","017":"up2019-blog-017.html","018":"up2019-blog-018.html","019":"up2019-blog-019.html","020":"up2019-blog-020.html"},"up2023-blog":{"001":"up2023-blog-001.html","002":"up2023-blog-002.html","003":"up2023-blog-003.html","004":"up2023-blog-004.html","005":"up2023-blog-005.html","006":"up2023-blog-006.html","007":"up2023-blog-007.html","008":"up2023-blog-008.html","009":"up2023-blog-009.html","010":"up2023-blog-010.html","011":"up2023-blog-011.html","012":"up2023-blog-012.html","013":"up2023-blog-013.html","014":"up2023-blog-014.html","015":"up2023-blog-015.html","016":"up2023-blog-016.html","017":"up2023-blog-017.html","018":"up2023-blog-018.html","019":"up2023-blog-019.html","020":"up2023-blog-020.html","021":"up2023-blog-021.html","022":"up2023-blog-022.html","023":"up2023-blog-023.html"},"up2017-lucas":{"004":"up2017-lucas-004.html"}};
var POSTS_BY_INDEX = {"mayang2026-blog":["mayang2026-blog-008.html","mayang2026-blog-007.html","mayang2026-blog-006.html","mayang2026-blog-005.html","mayang2026-blog-004.html","mayang2026-blog-003.html","mayang2026-blog-002.html","mayang2026-blog-001.html"],"up2017-blog":["up2017-blog-036.html","up2017-blog-035.html","up2017-blog-034.html","up2017-blog-033.html","up2017-blog-032.html","up2017-blog-031.html","up2017-blog-030.html","up2017-blog-029.html","up2017-blog-028.html","up2017-blog-027.html","up2017-blog-026.html","up2017-blog-025.html","up2017-blog-024.html","up2017-blog-023.html","up2017-blog-022.html","up2017-blog-021.html","up2017-blog-020.html","up2017-blog-019.html","up2017-blog-018.html"],"up2019-blog":["up2019-blog-020.html","up2019-blog-019.html","up2019-blog-018.html","up2019-blog-017.html","up2019-blog-016.html","up2019-blog-015.html","up2019-blog-014.html","up2019-blog-013.html","up2019-blog-012.html","up2019-blog-011.html","up2019-blog-010.html","up2019-blog-009.html","up2019-blog-008.html","up2019-blog-007.html","up2019-blog-006.html","up2019-blog-005.html","up2019-blog-004.html","up2019-blog-003.html","up2019-blog-002.html","up2019-blog-001.html"],"up2023-blog":["up2023-blog-023.html","up2023-blog-022.html","up2023-blog-021.html","up2023-blog-020.html","up2023-blog-019.html","up2023-blog-018.html","up2023-blog-017.html","up2023-blog-016.html","up2023-blog-015.html","up2023-blog-014.html","up2023-blog-013.html","up2023-blog-012.html","up2023-blog-011.html","up2023-blog-010.html","up2023-blog-009.html","up2023-blog-008.html","up2023-blog-007.html","up2023-blog-006.html","up2023-blog-005.html","up2023-blog-004.html","up2023-blog-003.html","up2023-blog-002.html","up2023-blog-001.html"],"up2017-lucas":["up2017-lucas-004.html"]};

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
    var m = uri.match(/^\/(.*)\.php$/);
    if (m) {
        name = m[1];
        isPhp = true;
    } else if (uri === '/') {
        name = 'index';
    } else {
        var n = uri.replace(/^\/+|\/+$/g, '');
        if (n && !/\.[a-z0-9]+$/i.test(n)) { name = n; }
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