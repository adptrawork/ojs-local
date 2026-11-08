# Pencarian Artikel (`search.html`)

> **Route OJS (JRDC):** `/index.php/jrdc/search/search`  
> **File Template Core:** `templates/frontend/pages/search.tpl`  
> **Target Override:** `plugins/themes/sangulineModern/templates/frontend/pages/search.tpl`  
> **Status Paritas:** 📋 Perlu Override & Styling

---

## 1. Analisis Halaman Prototype (`search.html`)

Halaman pencarian prototype mengadopsi layout editorial modern 2 kolom (`grid-cols-12`, gap 8):
1. **Breadcrumbs:** `Beranda / Pencarian Artikel`
2. **Kolom Kiri (Filter Pencarian - `lg:col-span-4`):**
   - Header kartu: ikon filter + "Filter Pencarian"
   - Input: **Kata Kunci** (`name="q"`, text input)
   - Input: **Penulis** (`name="author"`, text input)
   - Dropdown: **Tahun Terbit** (`name="year"`, select: Semua Tahun, 2026, 2025, 2024, 2023)
   - Dropdown: **Urutkan Berdasarkan** (`name="sort"`, select: Relevansi, Terbaru, Paling Sering Dilihat)
   - Tombol CTA: "Terapkan Filter" (oranye primer `#c2410c`, w-full, rounded-lg)
3. **Kolom Kanan (Hasil Pencarian - `lg:col-span-8`):**
   - Header hasil: "Hasil Pencarian: [kata kunci]" + jumlah hasil (badge counter)
   - List kartu artikel hasil pencarian (border slate-200, rounded-2xl, hover border oranye):
     - Meta atas: Volume, Nomor, Tahun, DOI badge, Nomor Halaman
     - Judul artikel (hover ke primary)
     - Penulis
     - Snippet/cuplikan abstrak (`line-clamp-3`)
     - Footer kartu: counter statistik (Dilihat & Diunduh), tombol "Lihat Detail" dan tombol "Unduh PDF"

---

## 2. Pemetaan Komponen ke OJS 3.3

| Elemen Prototype | Sumber Data di OJS 3.3 | Mekanisme / Variabel Smarty | Status |
|---|---|---|---|
| Input Kata Kunci | Parameter query OJS | `<input name="query" value="{$query\|escape}">` | 🟢 Native |
| Input Penulis | Parameter authors OJS | `<input name="authors" value="{$authors\|escape}">` | 🟢 Native |
| Filter Tanggal/Tahun | Parameter date range | `html_select_date_a11y` (`dateFrom`, `dateTo`, `yearStart`, `yearEnd`) | 🟢 Native (styling disesuaikan) |
| Dropdown Sort | Tidak ada sort parameter bawaan di query string frontend | OJS default mengurutkan berdasarkan relevansi/date internal | 🟡 Modifikasi UI / Dev |
| Header Total Hasil | Hitungan DAO Result | `{$results->count}` | 🟢 Native |
| List Hasil Artikel | Iterator hasil pencarian | `{iterate from=results item=result}` | 🟢 Native |
| Kartu Hasil Artikel | Objek summary artikel | `{include file="frontend/objects/article_summary.tpl" article=$result.publishedSubmission journal=$result.journal showDatePublished=true}` | 🟢 Native |
| Pagination | Komponen pagination OJS | `{page_links anchor="results" iterator=$results ...}` | 🟢 Native |

---

## 3. Variabel Smarty & Hook Kritis (DILARANG MERUSAK)

Form pencarian OJS memiliki binding PHP & validasi internal yang ketat. Saat melakukan template override, perhatikan aturan berikut:

```smarty
{* 1. Form Action & Method *}
<form class="cmp_form" method="get" action="{$smarty.capture.searchFormUrl|strtok:"?"|escape}">
    {foreach from=$formUrlParameters key=paramKey item=paramValue}
        <input type="hidden" name="{$paramKey|escape}" value="{$paramValue|escape}"/>
    {/foreach}

    {* 2. Input Query Utama *}
    {block name=searchQuery}
        <input type="text" id="query" name="query" value="{$query|escape}" class="query">
    {/block}

    {* 3. Input Author *}
    {block name=searchAuthors}
        <input type="text" id="authors" name="authors" value="{$authors|escape}">
    {/block}

    {* 4. Hook Filter Tambahan (Plugin Dublin Core / Lucene / dll) *}
    {call_hook name="Templates::Search::SearchResults::AdditionalFilters"}

    {* 5. Hook Pre-Results *}
    {call_hook name="Templates::Search::SearchResults::PreResults"}

    {* 6. Iterator Hasil & Pagination *}
    {iterate from=results item=result}
        ...
    {/iterate}
    {page_links anchor="results" iterator=$results ...}
</form>
```

> ⚠️ **Penting:** Parameter query utama di OJS bernilai `name="query"`, BUKAN `name="q"` seperti di prototype HTML statis. Jika diubah menjadi `q`, backend search OJS tidak akan menerima kata kunci pencarian.

---

## 4. Rencana Implementasi

1. **Struktur Grid 12 Kolom:**
   Bungkus `search.tpl` dalam container `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8` dengan grid 12 kolom (`lg:grid-cols-12 gap-8`).
2. **Form Filter Kiri (`lg:col-span-4`):**
   - Bungkus form dalam kartu putih rounded-2xl dengan border slate-200.
   - Sederhanakan kontrol tanggal OJS (`html_select_date_a11y`) agar tampil bersih seperti input/select modern.
   - Tombol submit dengan class `.jrdc-btn-primary`.
3. **Hasil Pencarian Kanan (`lg:col-span-8`):**
   - Header badge total hasil: `Hasil Pencarian: "{$query}" (Ditemukan {$results->count} artikel)`.
   - Menggunakan `article_summary.tpl` modern yang sudah disesuaikan agar tampilan kartu hasil pencarian identik dengan kartu artikel di Beranda dan Issue.
4. **State Kosong (No Results Found):**
   - Tampilkan kartu notifikasi ramah pengguna jika `{$results->wasEmpty()}` bernilai `true`.

---

## 5. Checklist Verifikasi (Visual QA)

- [ ] Form submit mengirim query dengan benar (`GET ?query=...`)
- [ ] Filter penulis berfungsi (`authors=...`)
- [ ] Filter tanggal dari/sampai berfungsi tanpa error SQL
- [ ] Tampilan 2 kolom rapi di desktop (Filter 4 kolom, Hasil 8 kolom)
- [ ] Responsif di layar mobile/tablet: Filter otomatis berada di atas atau collapsible
- [ ] Kartu artikel hasil pencarian menampilkan judul, penulis, DOI, dan tombol aksi
- [ ] Pagination berfungsi jika hasil melebihi limit per halaman
- [ ] Tidak ada warning/error di `D:\laragon\tmp\php_errors.log`
