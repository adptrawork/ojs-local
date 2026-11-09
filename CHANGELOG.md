# Changelog - JRDC OJS 3.3 Modernization (SangulineModern Theme)

All notable changes to this project will be documented in this file.

## [1.4.0] - 2026-11-10

### Fixed
- **Article Page Grid Collapse (P0):** Parent `.row` clearfix `::before/::after` became CSS Grid items and parent `.main_entry` kept `float:left; width:calc(100% - 305px)`, collapsing the main column to 0px and the abstract to 60px. Pseudo-elements are now hidden inside `.jrdc-article__row` and both grid children reset to `float:none; width:auto; min-width:0`. Verified at 1440/1280/1024/768/390/320: main 467px, abstract 467px, sidebar 234px at 1440.
- **Giant ✕ on Mobile Panel (P1):** Parent `.pkp_site_nav_toggle--transform > span::before/::after` rotated 100%-wide bars by ±405° across the header. Parent pseudo-elements are now disabled; the three child bars animate into a tidy X instead.
- **Duplicate Search at 768/1024 (P1):** `.jrdc-nav__search { display:flex !important }` (later in cascade) beat `.jrdc-header__search { display:none !important }` at equal specificity. Header search is now hidden ≤1199px with `.pkp_head_wrapper.jrdc-header__inner` specificity. Exactly one visible search form when the panel is open.
- **Mobile Panel 7px Gap:** `#jrdcSiteNav` used hardcoded `top:80px` while the mobile header is 73px. Changed to `top:calc(100% + 1px)`; measured gap is now 0.
- **Search Page Button:** Parent `button.submit::before/::after` icon overlay covered the "Search" label. Both pseudo-elements are now disabled.
- **Dark Toggle Double Border:** Global `.jrdc-theme-toggle` border overrode the mobile rule. Border is now `none` inside the bordered controls box ≤1199px.
- **Toggle aria-expanded:** Parent handler toggles classes but never sets `aria-expanded`; child now mirrors the state on the next tick so screen readers stay in sync.
- **Header Search Button Pseudo:** `.jrdc-search__button::before/::after` (parent default icon) are now disabled for consistency, matching the search-page fix.
- **Duplicate PDF CTA:** The primary galley block in the article sidebar is hidden because the same download is already shown above the fold in the main column; supplementary galleys remain visible.

### Changed
- **Sidebar Blocks Cleaned:** Removed `sinta`, `in-collaboration-with`, and `template` from the Custom Block Manager list (duplicate "Sejarah Jurnal" link, partner placeholders, missing template URL). `journal-profile` now shows only verified data (name, abbreviation, publisher); dummy "Visitor counter" label and mailing-address bracket placeholders removed. The core Web Feed block (misleadingly titled "Current Issue", showing only Atom/RSS icons) is hidden from the sidebar; feeds remain in `<head>`.
- **CHANGELOG/Version Sync:** Entries ordered newest-first; `version.xml` release updated to `1.4.0.0`.

## [1.3.0] - 2026-11-09

### Changed
- **Mobile Header Layout:** First row on screens ≤1199px now contains only brand (left) and bordered toggle box (hamburger + light/dark, right). Search form, navigation, and user/admin menu (Daftar/Masuk) moved into the dropdown panel (`#jrdcSiteNav`) so the first row stays clean and overflow-free.
- **Desktop Header Order:** `brand → search (flexible, 170px basis; 240px basis ≥1360px, shrinks to fit) → primary nav → actions`. Brand text hidden ≤1360px (logo only) to fit the 1280px container without overflow; nav link padding tightened to 0.65rem.

### Fixed
- **Hamburger Position:** Parent Sanguline sets `.pkp_site_nav_toggle { position: absolute }` which threw the toggle out of the controls box on mobile — neutralized with `position: static !important`.
- **User Menu Visibility:** Mobile hide rule for `.jrdc-nav__user` moved after the base rule with higher specificity so Daftar/Masuk no longer shows in the first row on phones.
- **Panel Block Cascade:** Mobile search/user blocks inside the nav panel now override the desktop `display: none` via EOF media rule, so the panel actually shows Search → Navigation → Daftar/Masuk.

### Added
- **Mobile Panel Blocks:** Second search form (`#jrdc-search-query-mobile`) and second user menu (`#navigationUserMobile`) inside `#jrdcSiteNav` for mobile only; desktop keeps the original header search/user menu. All Smarty `{load_menu}`, `{url}`, and `{translate}` logic preserved; no core/parent files modified.

## [1.2.0] - 2026-11-09

### Added
- **Page-level Styling (CSS-only, no template overrides):** `.page_about` (editorial sections), `.page_issue` / `.obj_issue_toc` (cover + section headings), `.page_announcement` / `.obj_announcement`, and `.page_login` / `.page_register` (minimal modern forms) in `modern.less`.
- **QA (Tahap 7):** All 9 public routes return 200; desktop 1440px and mobile 390px show no horizontal overflow.

### Notes
- About/issue/archive/search/announcement/login/register templates remain core OJS (verified by sub-agent audit: hooks, routing, galley/TOC/pagination includes intact). They are styled via the shared `.pkp_structure_main > .page` card + new page sections, so OJS workflow and plugins are untouched.

## [1.1.0] - 2026-11-09

### Added
- **Design System Tokens:** CSS custom properties (`:root` --jrdc-*) in `modern.less` alongside LESS variables for runtime theming and dark mode.
- **Child JS Bundle:** `js/jrdc.js` (hamburger sync + Escape/click-outside, dark-mode localStorage persistence, DOI copy button, abstract-toggle fallback, article reading-progress bar) registered via `addScript()` with forward-slash URL.
- **Homepage Hero CTAs:** "Lihat Edisi Terbaru" and "Panduan Penulis" buttons; larger cover (260px) with accessible placeholder.
- **Article Improvements:** DOI copy button, prominent PDF download area above the fold in `article_details.tpl`, reading-progress bar, primary/secondary button hierarchy.
- **Zero Inline Styles:** Removed all `style="..."` from theme templates (header, footer, homepage, article cards) — presentation now fully in `modern.less`.

### Fixed
- **Sidebar Hook Duplication:** Removed `Templates::Common::Sidebar` hook call from `indexJournal.tpl`; `footer.tpl` is now the single renderer so Block Manager plugins run once.
- **Open-Access Badge:** `article_summary.tpl` now shows "Akses Terbuka" only when `publishingMode` or article `accessStatus` is open; removed static "Peer-Reviewed" badge.
- **Announcement Slider A11y:** Prev/next buttons use localized labels; dots use concise `Slide N` labels.
- **Script URL Backslash:** Child `jrdc.js` also registered with `$base` absolute URL to avoid Windows `DIRECTORY_SEPARATOR` 404.

### Changed
- **Article Summary Hierarchy:** PDF primary, Detail secondary, Abstract ghost; title uses `clamp()` for fluid type.
- **Announcement Slider:** Renders as vertical list on ≤640px; `prefers-reduced-motion` disables smooth scroll and reading-progress bar.
