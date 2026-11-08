# Komponen Global (Shell)

Komponen yang muncul di **semua halaman** — header, footer, breadcrumb, sidebar.

---

## 1. Header

**Prototype:** sticky `h-20`, background putih, `border-b`, logo SVG + teks jurnal,
nav [Beranda / Arsip / Tentang (dropdown) / Pengumuman], search pill, tombol
"Masuk", dark mode toggle.

**File OJS:** `sangulineModern/templates/frontend/components/header.tpl`

### Hook & Variabel Wajib Dipertahankan

| Item | Fungsi | Baris |
|------|--------|-------|
| `{include file="frontend/components/headerHead.tpl"}` | `<head>`, meta, CSS, JS | 15 |
| `{include file="frontend/components/skipLinks.tpl"}` | Aksesibilitas skip-nav | 23 |
| `{load_menu name="primary" ...}` | Menu utama dari Navigation Menu OJS | 77 |
| `{load_menu name="user" ...}` | Menu login/register/profil | 112 |
| `{url page="search" op="search"}` | Action form pencarian | 100 |
| `$displayPageHeaderLogo` | Logo jurnal dari setting | 8, 44–46 |
| `$currentLocale` | Atribut `lang` di `<html>` | 13 |
| `body class="pkp_page_*/pkp_op_*"` | Selector OJS per halaman | 16 |
| `$displayPageHeaderTitle` | Judul jurnal fallback jika logo kosong | 34, 48–49 |
| `$currentContext->getData('printIssn')` / `onlineIssn` | ISSN display | 60–61 |

### Pemetaan Elemen Prototype → OJS

| Elemen Prototype | Implementasi OJS | Status |
|-----------------|------------------|--------|
| Logo SVG + teks | `$displayPageHeaderLogo` / `$displayPageHeaderTitle` — upload logo via Journal Settings → Appearance | 🟢 |
| Nav: Beranda | Link home `{url page="index"}` — sudah ada di template | 🟢 |
| Nav: Arsip | Item di Navigation Menu "primary" — konfigurasi via Dashboard → Settings → Website → Navigation | 🟢 |
| Nav: Tentang (dropdown + submenu) | Submenu di Navigation Menu primary OJS — buat parent "Tentang" lalu child items | 🟢 |
| Nav: Pengumuman | Item Navigation Menu type "Announcements" | 🟢 |
| Search pill | Form `{url page="search" op="search"}` — sudah ada | 🟢 |
| Tombol "Masuk" | `{load_menu name="user"}` → link `{url page="login"}` | 🟢 |
| Dark mode toggle | JS kustom tema — **fase terpisah** | 🟡 |
| ISSN display | Sudah ada di template (`jrdc-issn`) dari data setting jurnal | 🟢 |

### Styling

Kelas CSS prototype (`sticky`, `h-20`, border-bottom) diterjemahkan ke LESS:

```less
.jrdc-header {
    position: sticky;
    top: 0;
    z-index: 100;
    height: 80px; // h-20
    background: #fff;
    border-bottom: @border-card;
}
```

---

## 2. Footer

**Prototype:** `bg-slate-950`, full-width, 4 kolom grid:
1. Brand + deskripsi jurnal
2. Untuk Penulis (link)
3. Navigasi & Arsip (link)
4. Kontak & Sekretariat + ikon medsos

**File OJS:** `sangulineModern/templates/frontend/components/footer.tpl`

### Hook Wajib Dipertahankan

| Item | Fungsi | Baris |
|------|--------|-------|
| `{call_hook name="Templates::Common::Sidebar"}` | Render sidebar blocks | 10 |
| `{call_hook name="Templates::Common::Footer::PageFooter"}` | Plugin hook footer | 50 |
| `{load_script context="frontend"}` | Load JS OJS | 48 |
| `{$pageFooter}` | Konten footer dari Journal Settings → Appearance → Footer | 34 |
| Tag penutup `</div>` untuk `pkp_structure_main`, sidebar, `pkp_structure_content` | Struktur layout OJS | 6, 22–25 |
| Sanguline theme credit | Di-protect oleh parent theme | 39–42 |

### Pemetaan Elemen Prototype → OJS

| Elemen Prototype | Implementasi OJS | Status |
|-----------------|------------------|--------|
| 4-kolom konten footer | HTML di `$pageFooter` (Journal Settings → Appearance → Footer) | 🟡 |
| Link "Untuk Penulis" | Link ke Static Pages atau Navigation Menu items | 🟢 |
| Link navigasi | `{load_menu}` atau hardcode di `$pageFooter` | 🟡 |
| Ikon medsos | HTML/SVG di `$pageFooter` atau custom block | 🟡 |
| Copyright / credit Sanguline | Sudah di template, jangan hapus | 🟢 |

### Catatan Implementasi

Konten 4 kolom footer paling praktis dimasukkan sebagai HTML langsung di
setting **Journal Footer** (`$pageFooter`). Template footer.tpl sudah me-render
`{$pageFooter}` di dalam `div.jrdc-footer__content`.

```html
<!-- Contoh isi $pageFooter (di Journal Settings → Appearance → Footer) -->
<div class="jrdc-footer-grid">
  <div class="jrdc-footer-col">
    <h3>JRDC</h3>
    <p>Journal of Research in Dental Clinics...</p>
  </div>
  <div class="jrdc-footer-col">
    <h3>Untuk Penulis</h3>
    <ul>
      <li><a href="/submissions">Kirim Naskah</a></li>
      <!-- ... -->
    </ul>
  </div>
  <!-- kolom 3 & 4 -->
</div>
```

Layout grid di-style via LESS:

```less
.jrdc-footer-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 32px;
    max-width: @max-content;
    margin: 0 auto;
    padding: 48px 24px;
}
```

---

## 3. Breadcrumb

**Prototype:** `Beranda / [Nama Halaman]`, teks kecil abu-abu di atas konten.

**File OJS:** `{include file="frontend/components/breadcrumbs.tpl"}` (dipanggil
dari setiap page template).

| Varian | Dipakai di |
|--------|-----------|
| `breadcrumbs.tpl` | Halaman umum |
| `breadcrumbs_article.tpl` | Detail artikel |
| `breadcrumbs_issue.tpl` | Detail issue (jika ada) |

**Status:** 🟢 — native OJS. Styling saja di LESS:

```less
.pkp_breadcrumb {
    font-size: 0.8125rem; // ~13px
    color: @slate-400;
    a { color: @slate-600; }
}
```

---

## 4. Sidebar

**Prototype:**
- Halaman internal: sidebar **kiri**, card dengan 7 item navigasi (Beranda,
  Arsip, Tentang, dll.) + blok konten (Kata Kunci Populer, Pengindeksan,
  Tools, dsb.)
- Beranda: sidebar **kanan** (trending, statistik, dsb.)

**File OJS:** Sidebar dirender di `footer.tpl` via hook:

```smarty
{capture assign="sidebarCode"}{call_hook name="Templates::Common::Sidebar"}{/capture}
{if $sidebarCode}
    <div class="pkp_structure_sidebar left jrdc-sidebar" ...>
        {* Sidebar nav menu *}
        {load_menu name="sidebar" ...}
        {$sidebarCode}
    </div>
{/if}
```

### Blok Sidebar

| Blok Prototype | Implementasi OJS | Status |
|---------------|------------------|--------|
| Navigasi 7-item (Beranda, Arsip, Tentang, dst.) | `{load_menu name="sidebar"}` — konfigurasi Navigation Menu "sidebar" | 🟢 |
| Kata Kunci Populer | Custom Block Manager → blok HTML dengan tag cloud statis | 🟡 |
| Pengindeksan (Crossref, Google Scholar, Garuda, SINTA, DOAJ) | Custom Block Manager → logo/badge HTML | 🟡 |
| Rekomendasi Tools (Mendeley, Zotero, Turnitin, dsb.) | Custom Block Manager → logo HTML | 🟡 |
| Arsip (daftar volume) | Plugin bawaan "Archive" sidebar block | 🟢 |
| Statistik Artikel (views/downloads) | Custom Block HTML statis atau plugin usageStats | 🟡 |

### Posisi Sidebar (Kiri vs Kanan)

Template saat ini memakai `class="left"` untuk sidebar. Posisi diatur via CSS:

```less
// Default: sidebar kiri (halaman internal)
.pkp_structure_content.has_sidebar {
    display: grid;
    grid-template-columns: 280px 1fr;
}

// Beranda: sidebar kanan
.pkp_page_index .pkp_structure_content.has_sidebar {
    grid-template-columns: 1fr 300px;
    .jrdc-sidebar { order: 2; }
    .jrdc-main { order: 1; }
}
```

---

## Ringkasan Status Shell

| Komponen | File Template | Status Mayoritas |
|----------|--------------|-----------------|
| Header | `header.tpl` | 🟢 (dark toggle 🟡) |
| Footer | `footer.tpl` | 🟡 (konten via setting) |
| Breadcrumb | `breadcrumbs.tpl` | 🟢 |
| Sidebar | `footer.tpl` (hook) | 🟡 (blok custom) |
