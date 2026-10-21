# Migration PHP → HTML statique (option A : crawl du site rendu)

Génère une version 100 % statique du site à partir du code PHP actuel, **sans
refonte** : le site est servi par Apache+PHP (même image que la production,
PHP 5.6), puis chaque page est crawlée dans chaque langue disponible et
sauvegardée en HTML. Les liens internes sont réécrits vers les nouvelles URLs.

## Usage

```bash
./tools/static-migrate/run.sh
```

Prérequis : Docker et l'image `ct-webserver:latest` (php:5.6-apache + mod_rewrite).
Variables optionnelles : `IMAGE`, `PORT`, `CONTAINER`.

## Sorties

| Sortie | Contenu |
|---|---|
| `dist/` | Le site statique : HTML + assets, prêt pour S3 |
| `tools/static-migrate/report.txt` | Rapport : échecs, liens cassés, notes |
| `tools/static-migrate/cloudfront-function.js` | Fonction CloudFront (viewer request) : continuité des URLs legacy |

## Schéma d'URL

| Contenu | Ancienne URL (PHP) | Nouvelle URL (statique) |
|---|---|---|
| Page FR | `/centre-terre-asso` ou `.php` | `/centre-terre-asso.html` |
| Page EN (mayang*, index) | `...php?lang=en` | `/en/...html` |
| Page ES (autres pages) | `...php?lang=es` | `/es/...html` |
| Billet de blog | `/mayang2026-blog?page=004` | `/mayang2026-blog-004.html` |
| Accueil | `/` | `/` (index.html) |

Les liens internes des variantes `/en/` et `/es/` sont réécrits en chemins
racine-absolus (`/images/...`, `/assets/...`) — les chemins relatifs du PHP ne
pouvant pas survivre à un sous-dossier.

## Corrections appliquées en post-traitement

Le code PHP d'origine et les contenus précompilés (`.txt`/`.smd`) ne sont **pas
modifiés** : les corrections demandées explicitement sont appliquées par
`rewriteHtml()` au moment de la génération. Bilan : 28 liens internes cassés
détectés au premier run → 0.

| Groupe | Problème | Correction |
|---|---|---|
| A (12) | Légende collée aux chemins d'images (`/@…`) | Coupe au `/@` dans `resolveAttr()` si le chemin tronqué existe |
| B (7) | Coquille `008-07.jpg` — l'image du billet 008 EN est nommée `008-007.jpg` | Remplacement du nom de fichier |
| B (3) | Coquille `im007.jpg` — la news 021 ES référence `img007.jpg` (comme la version FR) | Remplacement du nom de fichier |
| C (2) | `SponsorsManager.php` déduit `james.png` du dossier `broadley-james` (bug `explode("-")`) alors que le logo est `broadley-james.png` | Remplacement du chemin |
| C (2) | `asskool.png` : logo jamais fourni dans le dépôt | `<img>` cassée et son ancre retirées (décision explicite ; le texte du sponsor reste) |
| D (2) | Bloc « team-member » fantôme sur les pages équipe (35ᵉ entrée vide de `equipe1.txt`, bug `feof` de `TeamManager`) | Suppression du bloc (img vers dossier + h4/p vides) |

Blindage associé : la copie d'assets n'inclut jamais de `.html` — un fichier
parasite à la racine du dépôt ne peut pas écraser une page crawlée.

## Rôles de la fonction CloudFront (`cloudfront-function.js`)

À associer en *viewer request* sur la distribution :

1. **URLs extensionless** (`/centre-terre-asso`) : réécriture interne vers
   `.html` (200, l'URL affichée ne change pas).
2. **URLs `.php`** : 301 vers l'équivalent `.html` (+ variante de langue si
   `?lang=`, en appliquant les coercitions historiques : `es`→`en` sur les
   pages mayang/index, `en`→`fr` ailleurs).
3. **URLs à paramètres** (`/?page=004`, `?pageIndex=n`) : 301 vers le fichier
   du billet correspondant.
4. **Alias historiques** : `/fr` → `/`, `/en` → `/en/index.html`,
   `/es` → `/es/index.html` (corrige le bug historique : `/es` affichait
   l'accueil *anglais*), `/boutique` → Etsy.

## À synchroniser manuellement depuis le serveur actuel

Ces répertoires sont **gitignorés** (absents du dépôt) mais référencés par le site :

- `documents/` — les PDFs (plaquettes, rapports, fiches…) : copier tels quels dans `dist/`.
- `forum/` — le forum embarqué (`projet-scolaire-forum` charge
  `https://www.centre-terre.fr/forum/js/embed.js`) : service dynamique séparé,
  à conserver derrière une origine CloudFront dédiée.
- `backoffice/`, `resources/` — non référencés par le code migré : à vérifier
  séparément.

## Non migré (code mort)

- `common/stream.php` + player projekktor : plus référencés par aucune page
  (l'uid de session n'était jamais défini).
- `news-h1.php` / `news-h2.php` : incluent un dossier `news/` inexistant
  (pages déjà cassées en production), exclues du site statique.

## Hébergement (S3 + CloudFront)

- Bucket S3 avec les objets de `dist/`, `index.html` en document racine.
- La fonction `cloudfront-function.js` en viewer request.
- Les pages imprimables (`*-print.html`) restent exclues du sitemap
  (`robots.txt` : `Disallow /*print*`, conservé tel quel).
- `sitemap.xml` est régénéré avec les nouvelles URLs + alternates
  `hreflang` (fr/en/es).
