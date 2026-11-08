# Mapping Summary — 16 Halaman Prototype → OJS 3.3

> Ringkasan pemetaan seluruh halaman prototype HTML statis ke route, template, dan mekanisme override di OJS 3.3.0-24 (jurnal JRDC).

---

## Tabel Utama

| # | Halaman Prototype | File Prototype | Route OJS (JRDC) | File Template/Override | Tipe | Status |
|---|---|---|---|---|---|---|
| 1 | Beranda | `index.html` | `/index.php/jrdc` | `sangulineModern/.../indexJournal.tpl` | Theme override | 🔧 |
| 2 | Arsip | `archive.html` | `/index.php/jrdc/issue/archive` | `sangulineModern/.../issueArchive.tpl` | Theme override | 📋 |
| 3 | Issue/Terbitan | `issue.html` | `/index.php/jrdc/issue/view/{id}` | `sangulineModern/.../issue.tpl` | Theme override | 📋 |
| 4 | Detail Artikel | `article.html` | `/index.php/jrdc/article/view/{id}` | `sangulineModern/.../article_details.tpl` | Theme override | 🔧 |
| 5 | Pencarian | `search.html` | `/index.php/jrdc/search/search` | `sangulineModern/.../search.tpl` | Theme override | 📋 |
| 6 | Tentang | `about.html` | `/index.php/jrdc/about` | `sangulineModern/.../about.tpl` | Theme override | 📋 |
| 7 | Dewan Redaksi | `editorial-team.html` | `/index.php/jrdc/about/editorialTeam` | `sangulineModern/.../editorialTeam.tpl` | Theme override | 📋 |
| 8 | Kebijakan Etika | `policies.html` | Static Page / `about/submissions` | Static Page + styling | 🟡 |
| 9 | Kontak | `contact.html` | `/index.php/jrdc/about/contact` | `sangulineModern/.../contact.tpl` / core | Theme override | 📋 |
| 10 | Pengumuman | `announcements.html` | `/index.php/jrdc/announcement` | `sangulineModern/.../announcements.tpl` | Theme override | 📋 |
| 11 | Pedoman Penulis | `guidelines.html` | Static Page | Static Page + styling | 🟡 |
| 12 | Statistik | `statistics.html` | Static Page | Static Page + custom block | 🔴 |
| 13 | Kirim Naskah | `submissions.html` | `/index.php/jrdc/about/submissions` | `sangulineModern/.../submissions.tpl` | Theme override | 📋 |
| 14 | Login | `login.html` | `/index.php/jrdc/login` | `sangulineModern/.../userLogin.tpl` | Theme override (styling only) | 📋 |
| 15 | Register | `register.html` | `/index.php/jrdc/user/register` | `sangulineModern/.../userRegister.tpl` | Theme override (styling only) | 📋 |
| 16 | (script.js) | `script.js` | N/A | `sangulineModern/js/jrdc.js` | JS tema | 📋 |

### Legend Status

| Ikon | Arti |
|------|------|
| 🟢 | Selesai — sudah diimplementasi dan lolos QA |
| 🔧 | Ada tapi perlu refinement |
| 📋 | Belum mulai |
| 🟡 | Mekanisme berbeda (Static Page / plugin) — perlu pendekatan khusus |
| 🔴 | Butuh custom development |

---

## Detail: Dependencies, Prioritas & Dokumentasi

| # | Halaman | Dependencies | Prioritas | Doc File |
|---|---------|-------------|-----------|----------|
| 1 | Beranda | — | **P1** | [pages/index.md](pages/index.md) |
| 2 | Arsip | — | **P1** | [pages/archive.md](pages/archive.md) |
| 3 | Issue/Terbitan | — | **P1** | [pages/issue.md](pages/issue.md) |
| 4 | Detail Artikel | Plugin: PDF.js Viewer / HTML Article Galley | **P1** | [pages/article.md](pages/article.md) |
| 5 | Pencarian | — | **P1** | [pages/search.md](pages/search.md) |
| 6 | Tentang | — | **P2** | [pages/about.md](pages/about.md) |
| 7 | Dewan Redaksi | — | **P2** | [pages/editorial-team.md](pages/editorial-team.md) |
| 8 | Kebijakan Etika | Plugin: Static Pages | **P2** | [pages/policies.md](pages/policies.md) |
| 9 | Kontak | — | **P2** | [pages/contact.md](pages/contact.md) |
| 10 | Pengumuman | — | **P2** | [pages/announcements.md](pages/announcements.md) |
| 11 | Pedoman Penulis | Plugin: Static Pages | **P2** | [pages/guidelines.md](pages/guidelines.md) |
| 12 | Statistik | Plugin: Static Pages + Custom Block / custom dev | **P3** | [pages/statistics.md](pages/statistics.md) |
| 13 | Kirim Naskah | — | **P2** | [pages/submissions.md](pages/submissions.md) |
| 14 | Login | — | **P3** | [pages/login.md](pages/login.md) |
| 15 | Register | — | **P3** | [pages/register.md](pages/register.md) |
| 16 | script.js | — | **P1** | `01-global-shell.md` / `jrdc.js` |

---

## Ringkasan Prioritas

| Prioritas | Halaman | Jumlah | Catatan |
|-----------|---------|--------|---------|
| **P1** | Beranda, Arsip, Issue, Detail Artikel, Pencarian, Header/Footer (global shell), script.js | 6 + shell | Inti jurnal — harus selesai pertama |
| **P2** | Tentang, Dewan Redaksi, Kebijakan Etika, Kontak, Pengumuman, Pedoman Penulis, Kirim Naskah | 7 | Halaman informasi — penting tapi bukan alur utama pembaca |
| **P3** | Statistik, Login, Register | 3 | Styling-only atau butuh custom block — bisa ditunda |

---

## Tipe Implementasi

| Tipe | Keterangan | Halaman |
|------|------------|---------|
| **Theme override** | Template `.tpl` di folder tema `sangulineModern/templates/` — cara standar OJS | 1–7, 9–10, 13–15 |
| **Static Page + styling** | Konten dikelola via plugin Static Pages, styling via CSS tema | 8, 11 |
| **Custom block/dev** | Butuh custom block plugin atau development khusus | 12 |
| **JS tema** | File JavaScript di folder tema | 16 |
| **Styling only** | Template core dipakai apa adanya, hanya CSS yang di-override | 14, 15 |

---

## Catatan

- Header & footer (global shell) didokumentasikan di [01-global-shell.md](01-global-shell.md), bukan sebagai halaman terpisah
- Design token & variabel CSS ada di [00-design-system.md](00-design-system.md)
- Gap data dinamis OJS vs konten statis prototype ada di [02-dynamic-data-gaps.md](02-dynamic-data-gaps.md)
- Panduan QA visual ada di [03-visual-qa-browser.md](03-visual-qa-browser.md)
