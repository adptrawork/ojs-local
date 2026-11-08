# Halaman Arsip Terbitan

> **Prototype:** [`archive.html`](https://adptrawork.github.io/build-OJS/archive.html)
> **Route OJS:** `/index.php/jrdc/issue/archive`
> **Template inti:** `templates/frontend/pages/issueArchive.tpl` → `{include file="frontend/objects/issue_summary.tpl"}`
> **Override:**
> - `plugins/themes/sangulineModern/templates/frontend/pages/issueArchive.tpl` (baru — perlu dibuat)
> - `plugins/themes/sangulineModern/templates/frontend/objects/issue_summary.tpl` (baru — perlu dibuat)

---

## 1. Referensi Prototype

| Komponen Prototype | Deskripsi |
|---|---|
| Breadcrumb | Beranda > Repositori Arsip |
| Header card | "Repositori Arsip" — judul + deskripsi |
| Filter tahun | Dropdown/button group filter per tahun (client-side JS) |
| Grid issue cards | 3-kolom per tahun, tiap card: cover, Vol/No/tanggal, jumlah artikel, deskripsi, ISSN, tombol "Lihat Terbitan" |
| Pengelompokan tahun | Issue dikelompokkan per tahun (heading) |
| Call for Papers | Status terbuka untuk issue berikutnya (opsional) |

## 2. Route OJS & File Implementasi

```
Route:    /index.php/jrdc/issue/archive
          /index.php/jrdc/issue/archive/<page>  (pagination)
Handler:  IssueHandler::archive()

Halaman:  templates/frontend/pages/issueArchive.tpl
  └─ Override: plugins/themes/sangulineModern/templates/frontend/pages/issueArchive.tpl (BARU)

Kartu:    templates/frontend/objects/issue_summary.tpl
  └─ Override: plugins/themes/sangulineModern/templates/frontend/objects/issue_summary.tpl (BARU)

Pagination: frontend/components/pagination.tpl (native, tidak perlu override)
```

## 3. Variabel & Hook Kritis (Smarty)

### Variabel Utama

| Variabel | Sumber | Kegunaan |
|---|---|---|
| `$issues` | `array/iterator` | Koleksi objek Issue yang dipublikasikan |
| `$prevPage` | `int` | Nomor halaman sebelumnya (pagination) |
| `$nextPage` | `int` | Nomor halaman berikutnya |
| `$showingStart` | `int` | Nomor item pertama di halaman ini |
| `$showingEnd` | `int` | Nomor item terakhir di halaman ini |
| `$total` | `int` | Jumlah total issue |

### Akses Data Per Issue (dalam loop)

```smarty
{foreach from=$issues item="issue"}
    {* Judul (jika showTitle aktif) *}
    {if $issue->getShowTitle()}
        {$issue->getLocalizedTitle()}
    {/if}

    {* Seri: Vol X, No Y *}
    {$issue->getIssueSeries()}
    {$issue->getVolume()}
    {$issue->getNumber()}
    {$issue->getYear()}

    {* Cover *}
    {$issue->getLocalizedCoverImageUrl()}
    {$issue->getLocalizedCoverImageAltText()}

    {* Deskripsi *}
    {$issue->getLocalizedDescription()|strip_unsafe_html}

    {* Tanggal terbit *}
    {$issue->getDatePublished()|date_format:$dateFormatShort}

    {* Link ke halaman issue *}
    {url op="view" path=$issue->getBestIssueId()}

    {* ID terbaik untuk URL *}
    {$issue->getBestIssueId()}
{/foreach}
```

### Pagination Native

```smarty
{* Pagination URL generation *}
{if $prevPage > 1}
    {capture assign=prevUrl}{url router=$smarty.const.ROUTE_PAGE page="issue" op="archive" path=$prevPage}{/capture}
{elseif $prevPage === 1}
    {capture assign=prevUrl}{url router=$smarty.const.ROUTE_PAGE page="issue" op="archive"}{/capture}
{/if}
{if $nextPage}
    {capture assign=nextUrl}{url router=$smarty.const.ROUTE_PAGE page="issue" op="archive" path=$nextPage}{/capture}
{/if}
{include file="frontend/components/pagination.tpl" ...}
```

### Hook

Halaman arsip **tidak memiliki hook khusus**. Customisasi sepenuhnya via template override.

## 4. Pemetaan Konten: Prototype → OJS

| Elemen Prototype | Implementasi OJS | Status |
|---|---|---|
| Breadcrumb | `{include file="frontend/components/breadcrumbs.tpl"}` | 🟢 Native |
| Header "Repositori Arsip" | `{$pageTitle}` — terjemahan `archive.archives` | 🟢 Native (locale key) |
| Filter tahun (button group) | Tidak ada native | 🟡 JS kustom tema — filter DOM berdasarkan `data-year` attribute |
| Grid 3-kolom | `<ul class="issues_archive">` di core → override ke `<div>` grid | 🟡 Override markup + CSS grid |
| Card: cover image | `$issue->getLocalizedCoverImageUrl()` | 🟢 Native |
| Card: Vol/No/Tanggal | `$issue->getIssueSeries()` + `$issue->getDatePublished()` | 🟢 Native |
| Card: jumlah artikel | Tidak ada getter langsung di template | 🔴 Perlu custom — `count()` pada `publishedSubmissions` atau tambah data di handler |
| Card: deskripsi | `$issue->getLocalizedDescription()` | 🟢 Native (harus diisi di backend) |
| Card: ISSN | Tidak tersedia per-issue di template | 🟡 ISSN ada di level jurnal: `$currentJournal->getData('printIssn')` / `$currentJournal->getData('onlineIssn')` |
| Card: tombol "Lihat Terbitan" | `{url op="view" path=$issue->getBestIssueId()}` | 🟢 Native |
| Pengelompokan per tahun | Tidak ada native grouping | 🟡 Logic di template: bandingkan `$issue->getYear()` dengan issue sebelumnya |
| Pagination | `{include file="frontend/components/pagination.tpl"}` | 🟢 Native |
| Call for Papers | Tidak ada native | 🔴 Static block atau sidebar block |

## 5. Gap & Keputusan

### 🟢 Native (langsung berfungsi)
- Breadcrumb, judul halaman, cover image, seri issue, deskripsi, tanggal terbit, link ke issue, pagination

### 🟡 Perlu Penyesuaian Tema
- **Filter tahun:** Implementasi client-side JS di tema. Teknik:
  1. Tambahkan `data-year="{$issue->getYear()}"` pada setiap card
  2. Render daftar tahun unik sebagai button group
  3. JS toggle `display` berdasarkan tahun aktif
  4. **Bukan** filter server-side — semua issue tetap di DOM
  - ⚠️ Jika jumlah issue sangat banyak dan pagination aktif, filter hanya berlaku untuk issue di halaman tersebut
- **Pengelompokan tahun:** Di template override, gunakan variabel `$lastYear` untuk mendeteksi pergantian tahun dan tambah heading
- **Grid 3-kolom:** Override markup dari `<ul><li>` ke CSS grid/flexbox
- **ISSN:** Tampilkan dari `$currentJournal->getData('onlineIssn')` atau `printIssn` — sama untuk semua card
- **Deskripsi issue:** Bergantung pada pengisian field Description di backend per issue

### 🔴 Custom Development
- **Jumlah artikel per issue:** Tidak ada getter sederhana di template Smarty. Opsi:
  - (a) Custom template plugin Smarty
  - (b) Override handler untuk inject data
  - (c) Tampilkan tanpa jumlah artikel — paling pragmatis
- **Call for Papers:** Static block di atas/bawah grid. Bisa via:
  - Sidebar custom block plugin
  - Hardcode di template override
  - Custom static page link

### ⚠️ Catatan Implementasi
- `issueArchive.tpl` menggunakan `{foreach}` — **bukan** `{iterate}` — karena `$issues` sudah berupa array/collection
- Pagination native OJS menggunakan `$prevPage`/`$nextPage`, bukan offset — pertahankan logika ini
- Jika override `issue_summary.tpl`, pastikan tetap memiliki `<a>` link ke `{url op="view" path=$issue->getBestIssueId()}`

## 6. Checklist Visual QA

- [ ] Breadcrumb menampilkan: Beranda > Arsip Terbitan
- [ ] Judul halaman "Arsip Terbitan" atau equivalent tampil
- [ ] Issue cards tampil dalam grid (idealnya 3-kolom di desktop)
- [ ] Cover image tampil per card (jika diunggah)
- [ ] Identifikasi issue (Vol/No/Tahun) tampil jelas
- [ ] Deskripsi issue tampil jika ada
- [ ] Tombol "Lihat Terbitan" menuju halaman issue yang benar
- [ ] Filter tahun berfungsi (jika diimplementasi) — memfilter cards
- [ ] Pengelompokan per tahun memiliki heading yang jelas
- [ ] Pagination berfungsi jika issue lebih dari satu halaman
- [ ] Layout responsif: grid collapse ke 2-kolom (tablet) dan 1-kolom (mobile)
- [ ] Issue terbaru tampil pertama (urutan default OJS)
