# Halaman Issue / Terbitan

> **Prototype:** [`issue.html`](https://adptrawork.github.io/build-OJS/issue.html)
> **Route OJS:** `/index.php/jrdc/issue/view/<id>`
> **Template inti:** `templates/frontend/pages/issue.tpl` → `{include file="frontend/objects/issue_toc.tpl"}` → `{include file="frontend/objects/article_summary.tpl"}`
> **Override:**
> - `plugins/themes/sangulineModern/templates/frontend/pages/issue.tpl` (baru — perlu dibuat)
> - `plugins/themes/sangulineModern/templates/frontend/objects/issue_toc.tpl` (baru — perlu dibuat jika ingin ubah layout ToC)
> - `plugins/themes/sangulineModern/templates/frontend/objects/article_summary.tpl` ✅ (sudah ada)

---

## 1. Referensi Prototype

| Komponen Prototype | Deskripsi |
|---|---|
| Breadcrumb | Beranda > Arsip Terbitan > Vol X No Y (Tahun) |
| Header card edisi | Cover image + identifikasi issue (Vol/No/Tahun) + editorial note |
| Editorial note | Catatan redaksi statis |
| Daftar artikel per section | Dikelompokkan berdasarkan section jurnal |
| Kartu artikel | Badge tipe, judul (link), penulis+afiliasi, DOI, tombol abstrak/PDF/detail, statistik views/downloads |
| Issue galleys | Link unduh full issue (jika ada) |

## 2. Route OJS & File Implementasi

```
Route:    /index.php/jrdc/issue/view/{$issue->getBestIssueId()}
Handler:  IssueHandler::view()

Halaman:  templates/frontend/pages/issue.tpl
  └─ Override: plugins/themes/sangulineModern/templates/frontend/pages/issue.tpl (BARU)

ToC:      templates/frontend/objects/issue_toc.tpl
  └─ Override: plugins/themes/sangulineModern/templates/frontend/objects/issue_toc.tpl (BARU, opsional)

Kartu:    templates/frontend/objects/article_summary.tpl
  └─ Override: plugins/themes/sangulineModern/templates/frontend/objects/article_summary.tpl ✅
```

### Hierarki Include

```
issue.tpl
  ├── frontend/components/header.tpl
  ├── frontend/components/breadcrumbs_issue.tpl
  ├── frontend/objects/issue_toc.tpl
  │     ├── cover image + description
  │     ├── issue galleys (full issue download)
  │     └── sections loop
  │           └── frontend/objects/article_summary.tpl (per artikel)
  └── frontend/components/footer.tpl
```

## 3. Variabel & Hook Kritis (Smarty)

### Variabel Utama

| Variabel | Sumber | Kegunaan |
|---|---|---|
| `$issue` | `Issue` | Objek issue yang ditampilkan |
| `$issueIdentification` | `string` | Label issue (Vol/No/Tahun/Judul) — digunakan di `<h1>` |
| `$issueTitle` | via `$issue->getLocalizedTitle()` | Judul issue (jika `showTitle` aktif) |
| `$issueSeries` | via `$issue->getIssueSeries()` | String Vol/No/Year |
| `$issueGalleys` | `array` | Galley untuk seluruh issue |
| `$publishedSubmissions` | `array` | Array artikel per section: `[{title, articles: [...]}]` |
| `$hasAccess` | `bool` | Akses galley user saat ini |
| `$primaryGenreIds` | `array` | Genre ID file primer |

### Akses Data Spesifik

```smarty
{* Cover image *}
{assign var=issueCover value=$issue->getLocalizedCoverImageUrl()}
{$issue->getLocalizedCoverImageAltText()|escape}

{* Identifikasi issue *}
{$issue->getIssueIdentification()}
{$issue->getVolume()} / {$issue->getNumber()} / {$issue->getYear()}

{* Deskripsi issue *}
{$issue->getLocalizedDescription()|strip_unsafe_html}

{* Tanggal terbit *}
{$issue->getDatePublished()|date_format:$dateFormatShort}

{* DOI issue *}
{foreach from=$pubIdPlugins item=pubIdPlugin}
    {assign var=pubId value=$issue->getStoredPubId($pubIdPlugin->getPubIdType())}
{/foreach}

{* Issue galleys (full issue) *}
{foreach from=$issueGalleys item=galley}
    {include file="frontend/objects/galley_link.tpl" parent=$issue ...}
{/foreach}

{* Sections & articles loop *}
{foreach from=$publishedSubmissions item=section}
    {$section.title|escape}
    {foreach from=$section.articles item=article}
        {include file="frontend/objects/article_summary.tpl" heading=$articleHeading}
    {/foreach}
{/foreach}
```

### Hook Kritis

| Hook | Lokasi | Kegunaan |
|---|---|---|
| `Templates::Issue::Issue::Article` | Dalam `article_summary.tpl` | Konten tambahan per kartu artikel |

## 4. Pemetaan Konten: Prototype → OJS

| Elemen Prototype | Implementasi OJS | Status |
|---|---|---|
| Breadcrumb | `{include file="frontend/components/breadcrumbs_issue.tpl"}` | 🟢 Native |
| Header card: cover image | `$issue->getLocalizedCoverImageUrl()` | 🟢 Native (di `issue_toc.tpl`) |
| Header card: Vol/No/Tahun | `$issue->getIssueIdentification()` atau `$issueIdentification` | 🟢 Native |
| Header card: editorial note | Tidak ada field native khusus "editorial note" | 🟡 Bisa pakai `$issue->getLocalizedDescription()` — isi di backend Issue → Description |
| Daftar artikel per section | `$publishedSubmissions` foreach loop → `article_summary.tpl` | 🟢 Native |
| Kartu: badge tipe | Berdasarkan `$section.title` | 🟡 Perlu conditional CSS class |
| Kartu: judul + link | `$publication->getLocalizedTitle()` + `{url page="article" op="view"}` | 🟢 Native (di `article_summary.tpl`) |
| Kartu: penulis + afiliasi | Loop `$publication->getData('authors')` | 🟢 Native (sudah di override `article_summary.tpl`) |
| Kartu: DOI | `$article->getStoredPubId('doi')` via `$pubIdPlugins` | 🟢 Native (sudah di override `article_summary.tpl`) |
| Kartu: tombol abstrak | Toggle JS expand/collapse | 🟢 Native (sudah di override `article_summary.tpl`) |
| Kartu: tombol PDF | `{include file="frontend/objects/galley_link.tpl"}` | 🟢 Native |
| Kartu: tombol detail | Link ke `{url page="article" op="view"}` | 🟢 Native |
| Kartu: views/downloads | `$article->getViews()` + galley `->getViews()` | 🟢 Sudah di override `article_summary.tpl` |
| Issue galleys (full issue) | `$issueGalleys` foreach | 🟢 Native (di `issue_toc.tpl`) |

## 5. Gap & Keputusan

### 🟢 Native (langsung berfungsi)
- Breadcrumb, cover image, identifikasi issue, daftar artikel per section, judul/penulis/DOI/galley di kartu artikel, pagination issue galleys, tanggal terbit

### 🟡 Perlu Penyesuaian Tema
- **Editorial note:** Gunakan `$issue->getLocalizedDescription()` — field "Description" di form Issue backend. Pastikan konten diisi saat membuat/mengedit issue
- **Badge tipe artikel:** Tambah conditional class berdasarkan `$section.title` di `article_summary.tpl` (sudah ada override)
- **Layout header card:** Override `issue_toc.tpl` untuk mengubah markup `.heading` menjadi card layout yang sesuai prototype

### 🔴 Custom Development
- **Views/downloads per artikel di ToC:** Data sudah tersedia lewat `$article->getViews()` dan sudah diimplementasi di `article_summary.tpl` override — pastikan plugin usageStats aktif
- **Editorial note terstruktur:** Jika prototype menampilkan editorial note yang berbeda dari deskripsi issue, perlu custom field atau static block

### ⚠️ Catatan Implementasi
- Override `issue.tpl` hanya perlu jika ingin mengubah wrapper/breadcrumb — logika utama ada di `issue_toc.tpl`
- `article_summary.tpl` sudah di-override dan berisi kartu modern (badge, tooltip author, DOI, stats) — **tidak perlu diubah lagi** untuk keperluan halaman issue
- Heading level cascade: `issue.tpl` set `heading="h3"` → `issue_toc.tpl` set `$articleHeading="h4"` → `article_summary.tpl` menerima level heading

## 6. Checklist Visual QA

- [ ] Breadcrumb menampilkan jalur: Beranda > Arsip > Vol X No Y (Tahun)
- [ ] Cover image issue tampil di header (jika diunggah)
- [ ] Identifikasi issue (Vol/No/Tahun) tampil lengkap
- [ ] Deskripsi/editorial note tampil di bawah header (jika diisi)
- [ ] Artikel dikelompokkan per section dengan heading section
- [ ] Kartu artikel: judul bisa diklik, menuju halaman detail
- [ ] Kartu artikel: penulis tampil dengan afiliasi (tooltip)
- [ ] Kartu artikel: DOI tampil sebagai link
- [ ] Kartu artikel: tombol abstrak expand/collapse berfungsi
- [ ] Kartu artikel: link galley PDF berfungsi
- [ ] Statistik views/downloads tampil per artikel
- [ ] Issue galleys (full issue download) tampil jika ada
- [ ] Layout responsif di layar kecil
