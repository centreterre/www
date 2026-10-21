// Test de la fonction CloudFront générée (outillage de vérification, pas déployé)
const fs = require('fs');
const fnSrc = fs.readFileSync(__dirname + '/cloudfront-function.js', 'utf8');
eval(fnSrc); // définit handler, PAGE_TARGETS, ...

let pass = 0, fail = 0;
function call(uri, qs) {
    const querystring = {};
    for (const [k, v] of Object.entries(qs || {})) querystring[k] = { value: v };
    return handler({ request: { uri, querystring: Object.keys(querystring).length ? querystring : undefined } });
}
function expect(uri, qs, want) {
    const r = call(uri, qs);
    let got;
    if (r.statusCode === 301) got = '301:' + r.headers.location.value;
    else if (r.uri !== uri) got = 'rewrite:' + r.uri;
    else got = 'passthrough';
    if (got === want) { pass++; }
    else { fail++; console.log(`ÉCHEC  ${uri}${qs ? '?' + new URLSearchParams(qs).toString() : ''}\n  attendu: ${want}\n  obtenu : ${got}`); }
}

// --- alias historiques (.htaccess) ---
expect('/fr', {}, '301:/');
expect('/en', {}, '301:/en/index.html');
expect('/es', {}, '301:/');  // pas d'accueil ES (index fr/en) : accueil FR, comme pour toute langue inconnue
expect('/boutique', {}, '301:https://www.etsy.com/fr/shop/CentreTerre');

// --- extensionless → réécriture interne (200) ---
expect('/centre-terre-asso', {}, 'rewrite:/centre-terre-asso.html');
expect('/mayang2026-blog', {}, 'rewrite:/mayang2026-blog.html');
expect('/', {}, 'rewrite:/index.html');
expect('/espacio-escolar-chile-recursos-fichas-log%C3%ADsticas', {}, 'rewrite:/espacio-escolar-chile-recursos-fichas-log%C3%ADsticas.html');

// --- .php → 301 vers .html ---
expect('/centre-terre-asso.php', {}, '301:/centre-terre-asso.html');
expect('/index.php', {}, '301:/');
expect('/index.php', { lang: 'en' }, '301:/en/index.html');
expect('/mayang2026-blog.php', { lang: 'en' }, '301:/en/mayang2026-blog.html');
expect('/centre-terre-asso.php', { lang: 'es' }, '301:/es/centre-terre-asso.html');

// --- coercitions historiques ---
expect('/mayang2026-blog.php', { lang: 'es' }, '301:/en/mayang2026-blog.html'); // es coercé en (comme la prod)
expect('/gallery-up2010.php', { lang: 'en' }, '301:/gallery-up2010.html');     // en coercé en fr (comme la prod)
expect('/index.php', { lang: 'es' }, '301:/en/index.html');                    // idem index

// --- URLs de billets ---
expect('/mayang2026-blog.php', { page: '004' }, '301:/mayang2026-blog-004.html');
expect('/mayang2026-blog.php', { page: '004', lang: 'en' }, '301:/en/mayang2026-blog-004.html');
expect('/up2017-blog.php', { page: '018', lang: 'es' }, '301:/es/up2017-blog-018.html');
expect('/', { page: '008' }, '301:/mayang2026-blog-008.html');                 // /?page=008 (ancienne sidebar)
expect('/index.php', { pageIndex: '1' }, '301:/mayang2026-blog-007.html');     // pageIndex → billet
expect('/up2017-blog.php', { pageIndex: '17' }, '301:/up2017-blog-019.html');

// --- assets & inconnus → passthrough ---
expect('/images/common/logo-icon.png', {}, 'passthrough');
expect('/assets/css/bootstrap.min.css', {}, 'passthrough');
expect('/mayang2026/blog/pages/004/mayang-2026-blog-004-001.jpg', {}, 'passthrough');
expect('/documents/EXPEDITIONS/UP2019/APPEL-DONS/CT-UP2019-APPEL-DONS-FR.pdf', {}, 'passthrough');
expect('/en/mayang2026-blog-004.html', {}, 'passthrough');  // nouvelle URL statique : rien à faire
expect('/inconnu', {}, 'passthrough');
expect('/inconnu.php', {}, 'passthrough');

console.log(`\n${pass} OK, ${fail} échecs`);
process.exit(fail ? 1 : 0);
