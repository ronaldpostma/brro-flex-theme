## V1.2.1 - Release TBD
- [x] 2026-09-10 - **License**: GPLv2 or later; theme header `License URI` points at the GitHub `LICENSE` file. Files: `brro-flex-theme/style.css`, `LICENSE`, `README.md`.
- [x] 2026-11-26 - **Editor admin CSS**: editors are now detected by role via brro-core's `brro_is_brro_editor()`, replacing the removed `brro_editors` option (which fell back to user IDs 2–5). Files: `brro-flex-theme/inc/admin/wp-admin-brro-ux.php`.
- [x] 2026-11-26 - **Posts page title**: the hidden H1 in `home.php` shows the posts page title (was the first post's title), or the site name when the blog is the front page. Files: `brro-flex-theme/home.php`.
- [x] 2026-11-26 - **Comments and README**: rule references in theme comments point to `.claude/rules/*.md`; README names `assets/css/utilities.css`. Files: `functions.php`, `header.php`, `templates/main-header.php`, `style.css`, `README.md`.

## V1.1.1 - Released 2026-03-17