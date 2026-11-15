# Third-Party Notices

**Inventory reviewed:** 15 November 2026.

The root [0BSD license](LICENSE) applies to Hasan Halabi's original repository material. It does not replace the licenses of third-party source, packages, fonts, or icons.

## Installed foundation

| Component | Installed version | Source | License and repository use |
| --- | ---: | --- | --- |
| Laravel application skeleton | 12.12.2 | `laravel/laravel` through Packagist | MIT; generated foundation files are under `apps/web/` |
| Laravel Framework | 12.72.0 | `laravel/framework` through Packagist | MIT; installed under ignored `apps/web/vendor/` |
| Bootstrap | 5.3.9 | `bootstrap` through npm | MIT; source is under ignored `apps/web/node_modules/` and compiled output remains ignored |
| Font Awesome Free | 7.3.1 | `@fortawesome/fontawesome-free` through npm | CC BY 4.0, SIL OFL 1.1, and MIT as declared by the package; source is under ignored `apps/web/node_modules/` and compiled output remains ignored |

Exact PHP dependency versions and metadata are recorded in `apps/web/composer.lock`. Exact JavaScript and build dependency versions are recorded in `apps/web/package-lock.json`. Composer and npm dependency directories are not committed. The generated Laravel skeleton remains subject to its upstream MIT terms; project-authored changes remain covered by the repository's 0BSD license where those rights are separable.

Before adding or redistributing another dependency or asset, record its exact version, source, license, included paths, and any required notice here. The repository license does not determine reuse rights for YouTube videos, music, stock media, or other material published outside this repository.
