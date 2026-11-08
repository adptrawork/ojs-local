# Sanguline Theme for OJS 3.3

Sanguline is a modern, elegant, and customizable theme for Open Journal Systems (OJS) 3.3.

Created by Thoha Firdaus for the academic community.

Developed by [Sangu Ilmu](https://sanguilmu.com/)

## Status

This theme has been adjusted to run on OJS 3.3.

Current compatibility notes:
- Theme bootstrap and locale loading have been adapted for OJS 3.3.
- Frontend template overrides have been aligned with OJS 3.3 article, issue, and homepage rendering.
- Usage statistics chart rendering from the OJS 3.4 variant is disabled gracefully on OJS 3.3.

## Features

- Customizable primary color
- Multiple typography choices
- Responsive header and navigation
- Homepage announcement slider
- Homepage image placement options
- Homepage image width control
- Header logo size control
- Custom article summary presentation
- Cleaner article detail layout
- Sidebar menu area support

## Installation

1. Place the theme in `plugins/themes/Sanguline/`.
2. Clear OJS caches after copying or updating the theme.
3. Open `Settings > Website > Appearance`.
4. Activate `Sanguline`.
5. Save the theme settings.

## Recommended Cache Clear

After updating the theme, clear these directories before testing:

```text
cache/t_compile/
cache/t_cache/
cache/_db/
```

If locale strings or old templates still appear, clear the locale cache as well.

## Theme Options

- Primary colour
- Typography
- Journal summary on homepage
- Move homepage image to header
- Homepage image width
- Header logo size
- Usage statistics display option

Note: On OJS 3.3, the usage statistics chart option is kept for compatibility, but chart rendering is intentionally disabled because the OJS 3.4 integration is not available in this branch.

## Directory Notes

Key files:

- `SangulineThemePlugin.inc.php`: OJS 3.3 theme bootstrap
- `index.php`: plugin wrapper
- `version.xml`: plugin version metadata
- `settings.xml`: default enabled setting
- `templates/frontend/`: frontend overrides
- `styles/`: LESS and CSS assets
- `js/`: theme scripts
- `locale/`: translation files

## Support

Website: [https://sanguilmu.com/](https://sanguilmu.com/)

## License

GNU General Public License v3.0

## Version

Current theme version: `1.1.0.1`
