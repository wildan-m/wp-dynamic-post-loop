# WordPress Static-to-Dynamic Post Loop

A WordPress child theme that demonstrates converting a static HTML team/portfolio page into a fully dynamic Custom Post Type archive with pagination.

## What This Demonstrates

- **Static-to-dynamic conversion** — replaces hardcoded HTML markup with a `WP_Query` loop that automatically displays new content as it's published.
- **Child theme architecture** — all changes live in a child theme, leaving the parent theme untouched and update-safe.
- **Custom Post Type registration** — `team_member` CPT with proper labels, REST API support, and custom image sizes.
- **Pagination** — uses `paginate_links()` with the main query for clean, SEO-friendly paged URLs (`/team/page/2/`).
- **Production-ready code** — proper escaping (`esc_html()`, `esc_url()`, `esc_attr()`), translation-ready strings, accessible markup, and responsive CSS grid.

## File Overview

| File | Purpose |
|------|---------|
| `functions.php` | CPT registration, enqueue styles, image sizes, archive query |
| `archive-team_member.php` | Card grid loop with pagination and no-results fallback |
| `single-team_member.php` | Individual member profile page |
| `style.css` | Child theme header + responsive card grid styles |

## Usage

1. Place this folder inside `wp-content/themes/`.
2. Activate **Flavor Child - Team Dynamic** in Appearance > Themes.
3. Add team members under the **Team** menu in wp-admin.
4. Visit `/team/` to see the dynamic archive.
