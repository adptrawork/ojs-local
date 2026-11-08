# Prototype → OJS 3.3 — Pemetaan Per Halaman

Dokumentasi ini memetakan setiap halaman prototype JRDC Modern ke implementasi
di OJS 3.3 (`plugins/themes/sangulineModern/`).

## Sumber Kebenaran (Source of Truth)

| Sumber | URL / Path |
|--------|-----------|
| Prototype live | <https://adptrawork.github.io/build-OJS/index.html> |
| Repo prototype-pages | <https://github.com/adptrawork/build-OJS/tree/prototype-pages> |
| Tema OJS lokal | `plugins/themes/sangulineModern/` |

## Legenda Status

| Ikon | Arti |
|------|------|
| 🟢 | Native OJS 3.3 — sudah tersedia, tinggal styling |
| 🟡 | Bisa dicapai via setting jurnal, Custom Block, atau Static Page |
| 🔴 | Perlu pengembangan kustom (plugin / kode tambahan) |

## Cara Pakai

1. Baca `00-design-system.md` untuk token desain global.
2. Baca `01-global-shell.md` untuk header, footer, sidebar, breadcrumb.
3. Baca `02-dynamic-data-gaps.md` untuk elemen yang bukan bawaan OJS.
4. (Akan datang) Baca `pages/<nama>.md` untuk detail implementasi tiap halaman.

Setiap file mandiri — bisa dibaca langsung tanpa urutan khusus.
