// Genere par tools/static-migrate/migrate.php - ne pas editer a la main.
// Fonction CloudFront (viewer request) : continuite des URLs legacy.
// Code ES 5.1, 100% ASCII : compatible cloudfront-js-1.0 et cloudfront-js-2.0.
//
// REPRESENTATION COMPACTE (limite AWS : 10 Ko de code, "FunctionSizeLimitExceeded"
// au-dela - les "UnknownError" de la console venaient de la) :
//   PAGES  : noms valides separes par '|'. Cible d'une page = nom + '.html'.
//   ALIAS  : page -> blog, pour les pages acceptant ?page= / ?pageIndex=
//   RANGES : plage [min, max] des billets par blog (IDs a 3 chiffres contigus)
//   Langues : index et mayang* -> fr/en ; les autres -> fr/es.
//   ?page=PID    -> billet PID si la forme a 3 chiffres est exacte
//   ?pageIndex=n -> billet (max - n), ordre chronologique inverse
// Invariants verifies au build (section 8 de migrate.php) : le pipeline
// echoue si une page ou un billet ne respecte plus ces regles.

var PAGES  = "|centre-terre-asso|centre-terre-expe|centre-terre-orga|espacio-escolar-chile-presentation|espacio-escolar-chile-recursos-datos-cient\u00edficos-brutos|espacio-escolar-chile-recursos-fichas-c2|espacio-escolar-chile-recursos-fichas-c3|espacio-escolar-chile-recursos-fichas-c4|espacio-escolar-chile-recursos-fichas-log\u00edsticas|espacio-escolar-chile-recursos-fotos|espacio-escolar-chile-recursos-mapas|espacio-escolar-chile-recursos-presentaciones|espacio-escolar-chile-recursos-sobre-las-fichas-pedag\u00f3gicas|gallery-up2010|index|mayang2026-blog|mayang2026-donateurs|mayang2026-equipe|mayang2026-partenaires|mayang2026-plaquette|mayang2026-pressbook|mayang2026-print|mayang2026-projet-scientifique|projet-scolaire-forum|projet-scolaire-ressources-cartographies|projet-scolaire-ressources-fiches-a-propos|projet-scolaire-ressources-fiches-cycle2|projet-scolaire-ressources-fiches-cycle3|projet-scolaire-ressources-fiches-cycle4|projet-scolaire-ressources-fiches-donnees-brutes-sciences|projet-scolaire-ressources-fiches-logistique|projet-scolaire-ressources-fiches-propositions-pedagogiques-litteraires|projet-scolaire-ressources-photographies|projet-scolaire-sommaire|projet-scolaire-up2017-bilan|projet-scolaire-up2017-realisations-laureates|projet-scolaire-up2019-bilan|projet-scolaire-up2019-realisations-laureates|projet-scolaire-up2023-bilan|projet-scolaire-up2023-lien-avec-les-programmes|projet-scolaire-up2023-modalites-suivi|projet-scolaire-up2023-pourquoi-retourner-en-patagonie|projet-scolaire-up2023-presentation|projet-scolaire-up2023-realisations-laureates|projet-scolaire-up2023-responsabilite|projet-scolaire-up2023-valeurs-educatives|shop|up2017-blog|up2017-booklet|up2017-com|up2017-downloads|up2017-jose|up2017-lucas|up2017-partenaires-institutionnels|up2017-partenaires-participatif|up2017-pressbook|up2017-print|up2017-project-base|up2017-project-main|up2017-project-scientific|up2017-team|up2019-appel-dons|up2019-blog|up2019-com|up2019-donateurs|up2019-partenaires|up2019-plaquette|up2019-print|up2019-project-main|up2019-projet-scientifique|up2019-team|up2023-appel-dons|up2023-blog|up2023-donateurs|up2023-equipe|up2023-partenaires|up2023-plaquette|up2023-pressbook|up2023-print|up2023-projet-scientifique|";
var ALIAS  = {"index":"mayang2026-blog","mayang2026-blog":"mayang2026-blog","up2017-blog":"up2017-blog","up2019-blog":"up2019-blog","up2023-blog":"up2023-blog","up2017-lucas":"up2017-lucas"};
var RANGES = {"mayang2026-blog":[1,8],"up2017-blog":[18,36],"up2019-blog":[1,20],"up2023-blog":[1,23],"up2017-lucas":[4,4]};

function pad3(n) {
    var s = String(n);
    while (s.length < 3) { s = '0' + s; }
    return s;
}

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
    if (uri === '/es')        { return redirect301('/'); }
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

    if (PAGES.indexOf('|' + name + '|') === -1) { return request; }

    var hasLegacyQuery = !!(params.page || params.pageIndex !== undefined || params.lang);

    // URL extensionless sans parametre : servir le .html (200, URL inchangee)
    if (!isPhp && !hasLegacyQuery) {
        request.uri = encodeURI('/' + name + '.html');
        return request;
    }

    // URL legacy (.php ou avec parametres) : 301 vers la cible canonique
    var target = name + '.html';
    var blog = ALIAS[name];
    if (blog && (params.page || params.pageIndex !== undefined)) {
        var r = RANGES[blog];
        var post = null;
        if (params.page) {
            var pi = parseInt(params.page, 10);
            if (params.page === pad3(pi) && pi >= r[0] && pi <= r[1]) { post = pi; }
        } else {
            var xi = parseInt(params.pageIndex, 10);
            if (xi >= 0 && xi <= r[1] - r[0]) { post = r[1] - xi; }
        }
        if (post !== null) { target = blog + '-' + pad3(post) + '.html'; }
    }

    var lang = params.lang || 'fr';
    var hasEn = (name === 'index' || name.indexOf('mayang') === 0);
    var eff = (lang === 'fr' || (lang === 'en' && hasEn) || (lang === 'es' && !hasEn))
        ? lang
        : (hasEn && lang === 'es' ? 'en' : 'fr');

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