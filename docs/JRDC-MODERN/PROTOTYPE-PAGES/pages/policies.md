# Kebijakan Etika (`policies.html`)

> Dokumentasi pemetaan halaman prototype → implementasi OJS 3.3.0-24 untuk JRDC (`journal_id=1`).

## 1. Referensi Prototype

- **File prototype:** [`policies.html`](https://adptrawork.github.io/build-OJS/policies.html)
- **Repo:** `prototype-pages` branch — [lihat sumber](https://github.com/adptrawork/build-OJS/tree/prototype-pages)
- **Desain:** Tailwind + Geist, primary `#c2410c`
- **Layout:** Left navigation sidebar + main content card berisi seksi etika publikasi, peer review, anti-plagiarisme, open access, dll.

## 2. Route OJS & File Implementasi

| Aspek | Detail |
|---|---|
| **Route OJS** | `/index.php/jrdc/about/submissions` (section kebijakan) **atau** Static Page plugin (path custom, mis. `/index.php/jrdc/policies`) |
| **Template core** | `lib/pkp/templates/frontend/pages/submissions.tpl` (jika memakai route `about/submissions`) |
| **Static Page (alternatif)** | Plugin `plugins/generic/staticPages/` — buat halaman dengan path `policies` |
| **Child theme override** | `plugins/themes/sangulineModern/templates/frontend/pages/` (jika perlu override template) |
| **CSS** | `plugins/themes/sangulineModern/styles/index.less` atau `docs/JRDC-MODERN/jrdc-custom.css` |

**Rekomendasi:** Gunakan **Static Page plugin** untuk konten kebijakan lengkap agar terpisah dari halaman submissions. Konten diisi sebagai HTML via UI admin (Website → Static Pages).

## 3. Variabel / Hook Kritis

| Variabel / Hook | Keterangan |
|---|---|
| `{$currentContext->getLocalizedData('authorGuidelines')}` | Pedoman penulis (jika pakai route `about/submissions`) |
| `{$currentContext->getLocalizedSetting('information', 'forAuthors')}` | Info untuk penulis |
| Static Page content (HTML blob) | Konten kebijakan diisi manual via admin |
| `TemplateManager::display` hook | Untuk inject CSS/JS tambahan (jarang diperlukan) |

## 4. Pemetaan Konten

| Elemen Prototype | Sumber Data OJS | Cara Isi |
|---|---|---|
| Judul halaman "Kebijakan Etika" | Static Page title / `<h1>` dalam konten | Admin → Static Pages → judul |
| Left nav (Etika Publikasi, Peer Review, Anti-Plagiarisme, Open Access, dll.) | HTML dalam konten Static Page | Tulis sebagai anchor link `<a href="#seksi">` dalam body HTML |
| Konten tiap seksi | HTML dalam konten Static Page | Tulis lengkap di editor HTML admin |
| Link/referensi eksternal (COPE, dll.) | Hardcode dalam konten HTML | Sisipkan `<a>` di body |

## 5. Gap Analysis (🟢🟡🔴)

| Komponen | Status | Catatan |
|---|---|---|
| Halaman statis dengan konten kebijakan | 🟢 Native | Static Page plugin bawaan OJS |
| Konten teks kebijakan (etika, peer review, dll.) | 🟡 Setting | Diisi manual via admin, HTML blob |
| Left navigation sidebar dalam halaman | 🔴 Custom | OJS tidak punya left nav in-page native; perlu **CSS/HTML manual** dalam konten Static Page atau override template |
| Styling card/section sesuai prototype | 🟡 Setting | CSS override di child theme atau journal stylesheet |
| Anchor scroll antar seksi | 🟡 Setting | HTML anchor `id` + smooth scroll CSS, ditulis dalam konten |

### Detail Gap 🔴 — Left Navigation

Prototype menampilkan sidebar navigasi kiri yang sticky untuk berpindah antar seksi kebijakan. OJS tidak menyediakan komponen ini secara native.

**Solusi:**
1. **HTML-in-content:** Tulis `<nav>` dengan anchor link di dalam konten Static Page, posisikan dengan CSS (`float`/`flex`/`grid`). Paling sederhana, tidak butuh override template.
2. **Template override:** Buat template khusus `staticPages/content.tpl` di child theme dengan layout 2-kolom. Lebih bersih tapi butuh file template.

Rekomendasi: opsi 1 (HTML-in-content) untuk minimisasi kode custom.

## 6. Checklist Visual QA

- [ ] Halaman dapat diakses via URL (Static Page path atau `about/submissions`)
- [ ] Judul halaman tampil benar "Kebijakan Etika" (atau sesuai)
- [ ] Left nav tampil dan anchor link berfungsi scroll ke seksi terkait
- [ ] Semua seksi konten tampil: Etika Publikasi, Kebijakan Peer Review, Anti-Plagiarisme, Kebijakan Akses Terbuka (sesuai prototype)
- [ ] Styling konsisten dengan prototype (card, spacing, tipografi Geist, warna `#c2410c`)
- [ ] Responsif: pada mobile, left nav collapse atau stack di atas konten
- [ ] Link eksternal (COPE, dll.) terbuka di tab baru
- [ ] Navigasi keyboard (Tab) berfungsi pada semua link
- [ ] Tidak ada overflow horizontal pada viewport sempit
- [ ] Breadcrumb / navigation menu OJS masih tampil benar di header
