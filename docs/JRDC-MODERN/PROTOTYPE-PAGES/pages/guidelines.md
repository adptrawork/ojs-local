# Pedoman Penulis (`guidelines.html`)

> Dokumentasi pemetaan halaman prototype → implementasi OJS 3.3.0-24 untuk JRDC (`journal_id=1`).

## 1. Referensi Prototype

- **File prototype:** [`guidelines.html`](https://adptrawork.github.io/build-OJS/guidelines.html)
- **Repo:** `prototype-pages` branch — [lihat sumber](https://github.com/adptrawork/build-OJS/tree/prototype-pages)
- **Desain:** Tailwind + Geist, primary `#c2410c`
- **Layout:** Left navigation sidebar + main content card berisi persyaratan naskah, format penulisan, template yang dapat diunduh, dan checklist pengiriman

## 2. Route OJS & File Implementasi

| Aspek | Detail |
|---|---|
| **Route OJS (opsi 1)** | `/index.php/jrdc/about/submissions` — section pedoman penulis |
| **Route OJS (opsi 2)** | Static Page plugin, path custom mis. `/index.php/jrdc/author-guidelines` |
| **Template core** | `lib/pkp/templates/frontend/pages/submissions.tpl` (opsi 1) |
| **Static Page plugin** | `plugins/generic/staticPages/` (opsi 2) |
| **Child theme override** | `plugins/themes/sangulineModern/templates/frontend/pages/` |
| **CSS** | `plugins/themes/sangulineModern/styles/index.less` atau `docs/JRDC-MODERN/jrdc-custom.css` |

**Rekomendasi:** Gunakan **Static Page plugin** (opsi 2) agar konten pedoman penulis terpisah dari halaman submissions dan lebih fleksibel untuk layout kustom.

## 3. Variabel / Hook Kritis

| Variabel / Hook | Keterangan |
|---|---|
| `{$currentContext->getLocalizedData('authorGuidelines')}` | Pedoman penulis dari setting (jika pakai route `about/submissions`) |
| `{$submissionChecklist}` | Checklist pengiriman (jika pakai route `about/submissions`) |
| Static Page content (HTML blob) | Konten pedoman diisi manual (jika pakai Static Page) |
| `{url page="libraryFiles" op="downloadPublic" path=...}` | URL download file dari Library (Publisher Library) |

**File template download:** Upload file `.docx`/`.doc` template naskah ke **Publisher Library** (Settings → Workflow → Publisher Library) atau sebagai aset statis, lalu link dalam konten HTML.

## 4. Pemetaan Konten

| Elemen Prototype | Sumber Data OJS | Cara Isi |
|---|---|---|
| Judul "Pedoman Penulis" | Static Page title atau `<h1>` konten | Admin → Static Pages / pengaturan |
| Left nav (Persyaratan, Format, Template, Checklist, dll.) | HTML anchor link dalam konten | Tulis `<nav>` dengan `<a href="#seksi">` |
| Persyaratan naskah | HTML dalam konten | Tulis di editor Static Page / author guidelines |
| Format penulisan (margin, font, spasi, dll.) | HTML dalam konten | Tulis di editor |
| Template download (.docx) | File di Publisher Library atau aset statis | Upload file, buat link `<a href="...">Unduh Template</a>` |
| Checklist pengiriman | HTML list / `{$submissionChecklist}` | Tulis di editor atau ambil dari setting |

## 5. Gap Analysis (🟢🟡🔴)

| Komponen | Status | Catatan |
|---|---|---|
| Halaman pedoman penulis (konten teks) | 🟢 Native | Via `about/submissions` (author guidelines) atau Static Page |
| Konten persyaratan, format, checklist | 🟡 Setting | Diisi manual sebagai HTML via admin |
| Template download (.docx) | 🟡 Setting | Upload ke Publisher Library, buat link download |
| Left navigation sidebar dalam halaman | 🔴 Custom | Sama seperti `policies.md` — OJS tidak punya left nav in-page native |
| Styling card/section sesuai prototype | 🟡 Setting | CSS override |

### Detail Gap 🔴 — Left Navigation

Identik dengan halaman Kebijakan. Solusi:
1. **HTML-in-content:** Tulis `<nav>` dengan anchor link di dalam konten Static Page, posisikan dengan CSS flex/grid.
2. **Template override:** Buat template khusus di child theme dengan layout 2-kolom.

Rekomendasi: konsistenkan pendekatan dengan `policies.md` — gunakan pola yang sama agar maintainable.

### File Template Download

1. Upload file `.docx` ke **Settings → Workflow → Publisher Library**.
2. Catat URL publik file (klik kanan → salin link, atau gunakan pattern `{url page="libraryFiles" op="downloadPublic" path=$fileId}`).
3. Sisipkan link `<a href="URL">Unduh Template Naskah (.docx)</a>` dalam konten HTML.

## 6. Checklist Visual QA

- [ ] Halaman dapat diakses via URL (Static Page path atau `about/submissions`)
- [ ] Judul halaman tampil benar "Pedoman Penulis" (atau sesuai)
- [ ] Left nav tampil dan anchor link berfungsi scroll ke seksi terkait
- [ ] Semua seksi konten tampil: Persyaratan Naskah, Format Penulisan, Template, Checklist
- [ ] Link download template (.docx) berfungsi dan file terunduh
- [ ] File template yang terunduh dapat dibuka tanpa error
- [ ] Styling konsisten dengan prototype (card, spacing, tipografi, warna `#c2410c`)
- [ ] Responsif: pada mobile, left nav collapse atau stack di atas konten
- [ ] Navigasi keyboard (Tab) berfungsi pada semua link termasuk link download
- [ ] Tidak ada overflow horizontal pada viewport sempit
- [ ] Breadcrumb / navigation menu OJS masih tampil benar di header
