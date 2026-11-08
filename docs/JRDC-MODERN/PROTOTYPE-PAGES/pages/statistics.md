# Statistik Jurnal (`statistics.html`)

> Dokumentasi pemetaan halaman prototype → implementasi OJS 3.3.0-24 untuk JRDC (`journal_id=1`).

## 1. Referensi Prototype

- **File prototype:** [`statistics.html`](https://adptrawork.github.io/build-OJS/statistics.html)
- **Repo:** `prototype-pages` branch — [lihat sumber](https://github.com/adptrawork/build-OJS/tree/prototype-pages)
- **Desain:** Tailwind + Geist, primary `#c2410c`
- **Layout:** Left navigation sidebar + main content card berisi chart bar (views/downloads), tabel status indeksasi, dan KPI jurnal

## 2. Route OJS & File Implementasi

| Aspek | Detail |
|---|---|
| **Route OJS** | **Tidak ada route publik native** untuk statistik jurnal lengkap |
| **Solusi** | Static Page plugin, path custom mis. `/index.php/jrdc/statistics` |
| **Static Page plugin** | `plugins/generic/staticPages/` |
| **Plugin statistik (opsional)** | `plugins/generic/usageStats/` — hanya menyediakan data internal, bukan halaman publik |
| **Child theme override** | `plugins/themes/sangulineModern/templates/frontend/pages/` (jika buat template khusus) |
| **CSS** | `plugins/themes/sangulineModern/styles/index.less` atau `docs/JRDC-MODERN/jrdc-custom.css` |

## 3. Variabel / Hook Kritis

| Variabel / Hook | Keterangan |
|---|---|
| **Tidak ada variabel native** | OJS 3.3 tidak meng-expose statistik jurnal ke frontend publik secara lengkap |
| Sanguline `displayStats` setting | Menampilkan bar statistik per artikel (jika diaktifkan), bukan halaman statistik jurnal |
| Static Page content (HTML blob) | Konten statistik diisi manual atau dengan HTML statis |
| Chart library (opsional) | Chart.js / embed gambar untuk visualisasi |

> **Catatan penting:** OJS 3.3 menyimpan data statistik (usage stats) di database, tetapi **tidak menyediakan halaman publik** yang menampilkan statistik agregat jurnal. Data yang dilihat admin di dashboard tidak otomatis tersedia di frontend.

## 4. Pemetaan Konten

| Elemen Prototype | Sumber Data OJS | Cara Isi |
|---|---|---|
| Judul "Statistik Jurnal" | Static Page title | Admin → Static Pages |
| Left nav (Overview, Indeksasi, KPI, dll.) | HTML anchor link dalam konten | Tulis `<nav>` dengan `<a href="#seksi">` |
| Chart bar views/downloads | **Tidak ada sumber native** | HTML/CSS statis, gambar, atau Chart.js dengan data hardcode |
| Tabel status indeksasi (SINTA, DOAJ, Garuda, dll.) | **Tidak ada sumber native** | Tabel HTML statis, data diisi manual |
| KPI jurnal (total artikel, total penulis, dll.) | **Tidak ada sumber native** | Angka HTML statis, diperbarui manual secara berkala |
| Grafik tren tahunan | **Tidak ada sumber native** | Gambar statis atau Chart.js hardcode |

## 5. Gap Analysis (🟢🟡🔴)

| Komponen | Status | Catatan |
|---|---|---|
| Halaman statistik publik | 🔴 Custom | OJS tidak punya halaman statistik publik; perlu Static Page |
| Chart bar views/downloads | 🔴 Custom | Data tidak ter-expose ke frontend; perlu hardcode atau custom plugin |
| Tabel indeksasi (SINTA, DOAJ, dll.) | 🔴 Custom | Data non-OJS, perlu tulis HTML manual |
| KPI jurnal (total artikel, penulis, dll.) | 🔴 Custom | Bisa diekstrak dari DB tapi perlu custom query atau manual update |
| Left navigation sidebar | 🔴 Custom | Sama seperti halaman lain — non-native |
| Styling card/section | 🟡 Setting | CSS override |

### Detail Gap 🔴 — Halaman ini paling banyak gap

Ini adalah halaman dengan gap terbesar karena OJS 3.3 **tidak menyediakan infrastruktur** untuk menampilkan statistik jurnal secara publik.

**Strategi implementasi bertahap:**

1. **Fase 1 (statis, minimal effort):**
   - Buat Static Page dengan konten HTML statis.
   - Tabel indeksasi: tulis tabel HTML manual dengan status (✅ Terindeks / ⏳ Proses).
   - KPI: angka hardcode dalam HTML, update manual tiap kuartal/semester.
   - Chart: gambar statis (screenshot) atau bar chart CSS-only sederhana.

2. **Fase 2 (semi-dinamis, effort sedang):**
   - Buat custom block plugin yang query DB untuk total artikel published, total authors, dll.
   - Embed output block di Static Page atau sidebar.

3. **Fase 3 (dinamis penuh, effort tinggi):**
   - Buat custom plugin `statisticsPage` yang:
     - Query `metrics` / `usage_stats` table
     - Render chart dengan Chart.js
     - Expose sebagai halaman publik khusus
   - **Tidak direkomendasikan** untuk fase awal karena effort tinggi dan risiko upgrade.

**Rekomendasi:** Mulai dengan **Fase 1**. Data indeksasi dan KPI jarang berubah; update manual kuartalan sudah memadai.

## 6. Checklist Visual QA

- [ ] Halaman dapat diakses via URL Static Page (mis. `/index.php/jrdc/statistics`)
- [ ] Judul halaman tampil benar "Statistik Jurnal"
- [ ] Left nav tampil dan anchor link berfungsi (jika diimplementasikan)
- [ ] Konten KPI tampil: total artikel, total penulis, total sitasi (jika ada data)
- [ ] Tabel indeksasi tampil: SINTA, DOAJ, Google Scholar, Garuda, dll. dengan status
- [ ] Chart/visualisasi tampil (gambar statis atau chart interaktif)
- [ ] Data yang ditampilkan akurat dan sudah diverifikasi manual
- [ ] Styling konsisten dengan prototype (card, spacing, tipografi, warna `#c2410c`)
- [ ] Responsif: chart/tabel menyesuaikan pada mobile (scroll horizontal jika perlu)
- [ ] Tidak ada error JavaScript pada console (jika pakai Chart.js)
- [ ] Breadcrumb / navigation menu OJS masih tampil benar di header
- [ ] Konten statis ditandai dengan catatan tanggal terakhir update (mis. "Data per Oktober 2026")
