# Halaman Detail Artikel

> **Prototype:** [`article.html`](https://adptrawork.github.io/build-OJS/article.html)
> **Route OJS:** `/index.php/jrdc/article/view/<id>`
> **Template inti:** `templates/frontend/pages/article.tpl` → `{include file="frontend/objects/article_details.tpl"}`
> **Override:** `plugins/themes/sangulineModern/templates/frontend/objects/article_details.tpl` (sudah ada)

---

## 1. Referensi Prototype

| Komponen Prototype | Deskripsi |
|---|---|
| Breadcrumb | Beranda > Arsip > Vol X No Y > Judul Artikel |
| Grid 12-kolom | Main 8-col + Sidebar 4-col |
| Badge | Tipe artikel, akses terbuka, peer-review |
| Judul (h1) | Judul artikel lengkap |
| Penulis + Afiliasi | Nama dengan superscript afiliasi |
| Grid Metadata | DOI, tanggal diterima/disetujui/terbit |
| Abstrak terstruktur | Tujuan, Metodologi, Temuan, Implikasi, Keaslian |
| Keywords chip | Tag keyword dalam bentuk chip/badge |
| Klasifikasi JEL | Kode JEL (jika ada) |
| Unduh Naskah Lengkap | Embed iframe PDF + tombol unduh |
| Daftar Pustaka | Expand/collapse referensi |
| Sidebar: Issue info | Thumbnail cover + identifikasi issue |
| Sidebar: LoA card | Letter of Acceptance |
| Sidebar: Statistik | Views & downloads per artikel |
| Sidebar: Bagikan | WhatsApp, X, Facebook, LinkedIn, salin tautan |
| Sidebar: Lisensi | Hak cipta & lisensi CC |
| Sidebar: Artikel Terkait | Rekomendasi artikel serupa |

## 2. Route OJS & File Implementasi

```
Route:    /index.php/jrdc/article/view/{$article->getBestId()}
Handler:  ArticleHandler::view()

Halaman:  templates/frontend/pages/article.tpl
  └─ Override tema: TIDAK PERLU (halaman hanya {include} article_details.tpl)

Detail:   templates/frontend/objects/article_details.tpl
  └─ Override: plugins/themes/sangulineModern/templates/frontend/objects/article_details.tpl ✅ (sudah ada)
```

## 3. Variabel & Hook Kritis (Smarty)

### Variabel Utama

| Variabel | Sumber | Kegunaan |
|---|---|---|
| `$article` | `Submission` | Objek submission utama |
| `$publication` | `Publication` | Versi publikasi yang ditampilkan |
| `$firstPublication` | `Publication` | Versi pertama (tanggal publikasi awal) |
| `$currentPublication` | `Publication` | Versi terbaru |
| `$issue` | `Issue` | Issue tempat artikel dimuat |
| `$section` | `Section` | Seksi jurnal |
| `$journal` | `Journal` | Jurnal saat ini |
| `$primaryGalleys` | `array` | Galley utama (PDF, HTML) |
| `$supplementaryGalleys` | `array` | Galley tambahan |
| `$pubIdPlugins` | `array` | Plugin PubId (DOI, dll.) |
| `$keywords` | `array` | Kata kunci (via `$publication->getLocalizedData('keywords')`) |
| `$parsedCitations` | `array` | Sitasi yang sudah diparsing |
| `$ccLicenseBadge` | `string` | Badge lisensi CC |
| `$licenseUrl` | `string` | URL lisensi |

### Akses Data Spesifik

```smarty
{* Judul *}
{$publication->getLocalizedTitle()|strip_unsafe_html}

{* Penulis *}
{foreach from=$publication->getData('authors') item=author}
    {$author->getFullName()|escape}
    {$author->getLocalizedData('affiliation')|escape}
{/foreach}

{* DOI *}
{assign var=pubId value=$article->getStoredPubId($pubIdPlugin->getPubIdType())}
{assign var="doiUrl" value=$pubIdPlugin->getResolvingURL($currentJournal->getId(), $pubId)|escape}

{* Abstrak *}
{$publication->getLocalizedData('abstract')|strip_unsafe_html}

{* Keywords *}
{foreach from=$publication->getLocalizedData('keywords') item="keyword"}
    {$keyword|escape}
{/foreach}

{* Tanggal terbit *}
{$firstPublication->getData('datePublished')|date_format:$dateFormatShort}

{* PDF galley URL *}
{foreach from=$primaryGalleys item=galley}
    {url page="article" op="download" path=$articlePath|to_array:$galley->getBestGalleyId()}
{/foreach}

{* Sitasi / Referensi *}
{foreach from=$parsedCitations item="parsedCitation"}
    {$parsedCitation->getCitationWithLinks()|strip_unsafe_html}
{/foreach}

{* Statistik views *}
{$article->getViews()}
```

### Hook Kritis

| Hook | Lokasi | Kegunaan |
|---|---|---|
| `Templates::Article::Main` | Akhir `.main_entry` | Konten tambahan di area utama (setelah keywords) |
| `Templates::Article::Details` | Akhir `.entry_details` | Konten tambahan di sidebar |
| `Templates::Article::Details::Reference` | Per sitasi | Plugin sitasi (Crossref, dll.) |
| `Templates::Article::Footer::PageFooter` | Di `article.tpl` | Konten footer halaman artikel |

## 4. Pemetaan Konten: Prototype → OJS

| Elemen Prototype | Implementasi OJS | Status |
|---|---|---|
| Breadcrumb | `{include file="frontend/components/breadcrumbs_article.tpl"}` | 🟢 Native |
| Badge tipe/akses/peer-review | Custom markup berdasarkan `$section->getLocalizedTitle()` dan `$publication->getData('accessStatus')` | 🟡 Perlu CSS + logic tambahan di template |
| h1 judul | `{$publication->getLocalizedTitle()\|strip_unsafe_html}` | 🟢 Native |
| Penulis + afiliasi superscript | Loop `$publication->getData('authors')` — override existing sudah pakai `.name` + `.affiliation` | 🟡 Perlu modifikasi markup untuk superscript style |
| Grid metadata (DOI/tanggal) | DOI via `$pubIdPlugins` loop; tanggal via `$publication->getData('datePublished')` | 🟡 Tanggal diterima/disetujui tidak ada di OJS 3.3 default — perlu custom field atau plugin |
| Abstrak terstruktur | `$publication->getLocalizedData('abstract')` — satu blok HTML | 🟡 Struktur tujuan/metodologi/temuan bergantung pada format teks yang dimasukkan di backend |
| Keywords chip | `$publication->getLocalizedData('keywords')` foreach loop | 🟡 Perlu styling chip (CSS), data sudah ada |
| Klasifikasi JEL | Tidak ada field native | 🔴 Perlu custom metadata field atau input di abstrak |
| Embed PDF iframe | `{url page="article" op="download" path=...}` dalam `<iframe>` | 🟡 Perlu markup iframe custom di template |
| Tombol unduh PDF | `{include file="frontend/objects/galley_link.tpl"}` | 🟢 Native |
| Daftar Pustaka expand/collapse | `$parsedCitations` atau `$publication->getData('citationsRaw')` | 🟡 Data native, expand/collapse perlu JS tema |
| Sidebar: Issue thumbnail | `$issue->getLocalizedCoverImageUrl()` + `$issue->getIssueIdentification()` | 🟢 Native (sudah di `article_details.tpl`) |
| Sidebar: LoA card | Tidak ada di OJS | 🔴 Custom dev — file upload kustom atau static block |
| Sidebar: Statistik | `$article->getViews()` + galley `->getViews()` | 🟡 Data ada via usageStats plugin, tampilan perlu override |
| Sidebar: Bagikan (WA/X/FB/LinkedIn/salin) | Tidak ada native | 🔴 Custom JS share links atau plugin AddThis/ShareThis |
| Sidebar: Lisensi & Hak Cipta | `$ccLicenseBadge`, `$licenseUrl`, `copyrightHolder/Year` | 🟢 Native (sudah di `article_details.tpl`) |
| Sidebar: Artikel Terkait | Tidak ada native | 🔴 Custom dev — query artikel lain di section/issue yang sama |

## 5. Gap & Keputusan

### 🟢 Native (tidak perlu custom dev)
- Breadcrumb, judul, subjudul, penulis dasar, DOI, abstrak, keywords, tanggal terbit, galley link, cover issue, lisensi/hak cipta, referensi, versi publikasi

### 🟡 Perlu Penyesuaian Tema
- **Badge tipe/akses:** Tambah markup conditional di template berdasarkan `$section` dan `accessStatus`
- **Penulis superscript:** Modifikasi loop author untuk afiliasi superscript (CSS + markup)
- **Keywords chip:** CSS styling, data sudah tersedia
- **PDF embed iframe:** Tambah `<iframe>` dengan URL galley download
- **Referensi expand/collapse:** Tambah JS toggle, data sudah tersedia
- **Statistik per artikel:** Sudah ada di `article_details.tpl` via chart usageStats; perlu versi ringkas angka di sidebar
- **Tanggal diterima/disetujui:** OJS 3.3 tidak menyimpan ini secara publik — bisa ditambah via plugin metadata atau dicatat manual di abstrak

### 🔴 Custom Development
- **LoA card:** Tidak ada konsep LoA di frontend OJS. Opsi: (a) static HTML block via hook, (b) custom galley type, (c) sidebar block plugin
- **Artikel Terkait:** Perlu query custom — saran: artikel lain dari section/issue yang sama. Implementasi via hook `Templates::Article::Details` atau custom template include
- **Bagikan canggih:** Implementasi JS untuk generate share URL ke WA/X/FB/LinkedIn. Bisa juga via plugin ShareThis/AddThis
- **JEL classification:** Tidak ada field native — perlu custom metadata plugin atau masukkan di keywords

### ⚠️ JANGAN Diubah
- **Form/CSRF:** Halaman artikel tidak punya form publik — tetapi jangan ubah galley access routing
- **Galley routing:** `{include file="frontend/objects/galley_link.tpl"}` harus tetap utuh
- **Akses galley:** Logic `purchaseFee`, `hasAccess`, `publishingMode` harus dipertahankan

## 6. Checklist Visual QA

- [ ] Breadcrumb menampilkan jalur navigasi lengkap (Beranda > Arsip > Issue > Artikel)
- [ ] Judul artikel (h1) dan subjudul tampil lengkap tanpa truncation
- [ ] Daftar penulis tampil dengan afiliasi, ORCID, dan negara (jika ada)
- [ ] DOI tampil sebagai tautan yang bisa diklik ke doi.org
- [ ] Abstrak tampil lengkap, formatting HTML dipertahankan
- [ ] Keywords tampil sebagai chip/tag yang terbaca
- [ ] Galley PDF bisa dibuka/diunduh — tautan berfungsi
- [ ] Sidebar: cover issue tampil, tautan ke halaman issue benar
- [ ] Sidebar: lisensi CC tampil dengan badge yang benar
- [ ] Statistik views/downloads tampil (jika usageStats plugin aktif)
- [ ] Layout responsif: sidebar collapse ke bawah di mobile
- [ ] Referensi tampil lengkap (expand jika menggunakan toggle)
- [ ] Tidak ada error PHP di log saat memuat halaman
