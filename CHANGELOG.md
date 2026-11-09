# Changelog - JRDC OJS 3.3 Modernization (SangulineModern Theme)

All notable changes to this project will be documented in this file.

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
