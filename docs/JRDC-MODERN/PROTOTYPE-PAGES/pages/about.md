# 📖 Tentang Jurnal / About

> **Prototype:** [`about.html`](https://adptrawork.github.io/build-OJS/about.html)
> **Route OJS:** `/index.php/jrdc/about`
> **File implementasi (core):** `lib/pkp/templates/frontend/pages/about.tpl`
> **File override (child theme):** `plugins/themes/sangulineModern/templates/frontend/pages/about.tpl` *(belum ada, perlu dibuat)*

---

## 1. Referensi Prototype

Layout 2-kolom dalam `max-w-7xl`:
- **Kiri (3 col):** Sidebar navigasi vertikal (7 item menu), item aktif di-highlight
- **Kanan (9 col):** Card konten utama (`rounded-2xl`, `shadow`) dengan sections prosa

**Komponen kunci:**
- Breadcrumb di atas
- Left sidebar nav (bukan sidebar OJS bawaan)
- Main card dengan heading `h1` + prose sections dipisah `border-t`
- Warna aksen `primary #c2410c` untuk link/nav aktif

---

## 2. Route OJS & File Implementasi

### Template Core (PKP)

```
lib/pkp/templates/frontend/pages/about.tpl
```

Isi core (OJS 3.3):
```smarty
{include file="frontend/components/header.tpl" pageTitle="about.aboutContext"}
<div class="page page_about">
  {include file="frontend/components/breadcrumbs.tpl" currentTitleKey="about.aboutContext"}
  <h1>{translate key="about.aboutContext"}</h1>
  {include file="frontend/components/editLink.tpl" ...}
  {$currentContext->getLocalizedData('about')}
</div>
{include file="frontend/components/footer.tpl"}
```

### Override yang Perlu Dibuat

```
plugins/themes/sangulineModern/templates/frontend/pages/about.tpl
```

Override ini akan menambahkan:
- Wrapper grid 2-kolom (left nav + main)
- Left sidebar navigasi "Tentang" sub-halaman
- Styling card pada konten utama

---

## 3. Variabel & Hook Kritis

### Variabel Smarty

| Variabel | Tipe | Sumber |
|----------|------|--------|
| `$currentContext` | `Journal` | Core OJS — konteks jurnal aktif |
| `$currentContext->getLocalizedData('about')` | `string` (HTML) | Journal Settings → Masthead → About the Journal |

### Hook

| Hook | Catatan |
|------|---------|
| _Tidak ada hook khusus di `about.tpl`_ | Template ini sangat sederhana. Hook sidebar global (`Templates::Common::Sidebar`) di-render oleh footer/layout, bukan di body halaman about |

### Edit Link (Backend)

```smarty
{include file="frontend/components/editLink.tpl"
  page="management" op="settings" path="context" anchor="masthead"
  sectionTitleKey="about.aboutContext"}
```
Jangan hapus — ini memberikan tombol edit cepat bagi admin yang login.

---

## 4. Pemetaan Konten (Prototype → OJS)

### 4.1. Breadcrumb

| Elemen Prototype | Sumber OJS | Label |
|-----------------|------------|-------|
| Breadcrumb (Beranda > Tentang Jurnal) | `{include file="frontend/components/breadcrumbs.tpl" currentTitleKey="about.aboutContext"}` | 🟢 |

### 4.2. Left Sidebar Navigasi

| Elemen Prototype | Sumber OJS | Label |
|-----------------|------------|-------|
| Menu navigasi vertikal (7 item): Tentang Jurnal, Dewan Redaksi, Pedoman Penulis, Etika Publikasi, Kebijakan Privasi, Fokus & Cakupan, Kontak | **Tidak ada** di template OJS default — OJS meletakkan sidebar di kanan via block plugin | 🔴 |

**Opsi implementasi:**

| Opsi | Pendekatan | Kelebihan | Kekurangan |
|------|-----------|-----------|------------|
| **(a) Override template + nav hardcode** | Tambah `<nav>` kiri di override `about.tpl` dengan link ke sub-halaman | Kontrol penuh layout, sesuai prototype | Perlu update manual jika halaman berubah |
| **(b) Override template + Navigation Menu API** | Buat Navigation Menu baru "About Sidebar", render via `{load_menu name="about-sidebar"}` | Bisa dikelola via UI | Lebih kompleks, OJS 3.3 Navigation Menu API terbatas |
| **(c) CSS reposition sidebar OJS** | Pindah sidebar bawaan ke kiri via CSS | Tanpa ubah template | Sidebar OJS berisi SEMUA blok, bukan hanya nav about |

**Rekomendasi:** Opsi **(a)** — override template dengan nav kiri hardcode. Konten menu "Tentang" jarang berubah, dan memberikan kontrol layout 1:1 dengan prototype. Link-link mengarah ke:

| Nav Item | Target URL |
|----------|-----------|
| Tentang Jurnal | `/index.php/jrdc/about` |
| Dewan Redaksi | `/index.php/jrdc/about/editorialTeam` |
| Pedoman Penulis | `/index.php/jrdc/about/submissions` |
| Etika Publikasi | `/index.php/jrdc/pages/view/ethics` (Static Page) |
| Kebijakan Privasi | `/index.php/jrdc/pages/view/privacy` (Static Page) |
| Fokus & Cakupan | Anchor `#fokus` di halaman about atau Static Page |
| Kontak | `/index.php/jrdc/about/contact` |

### 4.3. Main Card — Konten Prosa

| Section Prototype | Sumber OJS | Label |
|------------------|------------|-------|
| Tentang JRDC (paragraf utama) | `{$currentContext->getLocalizedData('about')}` | 🟢 |
| Fokus & Cakupan | Bagian dari konten `about` setting **ATAU** field terpisah yang tidak ada di 3.3 | 🟡 |
| Frekuensi Penerbitan | Bagian dari konten `about` setting | 🟡 |
| Kebijakan Open Access | Bagian dari konten `about` setting | 🟡 |
| Hak Cipta & Lisensi | Bagian dari konten `about`, atau Distribution Settings (copyright/license) | 🟡 |

**Catatan konten:**
- Semua section di prototype bisa dijadikan **satu blok HTML** di field "About the Journal" pada Journal Settings → Masthead.
- Gunakan heading `<h2>` atau `<h3>` dalam HTML untuk tiap sub-section, dipisah `<hr>` atau `border-t` via CSS.
- CSS child theme menambahkan styling `.jrdc-prose h2`, `.jrdc-prose hr`, dll.

### 4.4. Separator (`border-t`)

| Elemen | Implementasi | Label |
|--------|-------------|-------|
| Garis pemisah antar section | CSS pada `<hr>` atau heading di dalam konten `about` | 🟡 |

---

## 5. Gap & Keputusan

| # | Gap | Opsi | Rekomendasi | Prioritas |
|---|-----|------|-------------|-----------|
| G1 | Left sidebar nav tidak ada di OJS default | (a) Override TPL + hardcode nav (b) Navigation Menu API (c) CSS reposition | **(a)** Override template | Tinggi |
| G2 | Sub-sections (Fokus, Frekuensi, OA, Lisensi) sebagai bagian terpisah | (a) Satu field `about` dengan heading HTML (b) Static Pages terpisah | **(a)** Satu field, heading `<h2>` + CSS | Sedang |
| G3 | Override file `about.tpl` belum ada di child theme | Buat file | Buat dari core template + tambah grid wrapper + left nav | Tinggi |
| G4 | Pola left nav harus konsisten di about, editorialTeam, submissions, contact | Buat partial `about_nav.tpl` atau include snippet | Buat partial reusable | Sedang |
| G5 | Static Pages (Etika, Privasi) harus sudah dibuat | Periksa via admin panel | Verifikasi dan buat jika belum ada | Sedang |

---

## 6. Sketsa Struktur Override

```smarty
{* plugins/themes/sangulineModern/templates/frontend/pages/about.tpl *}
{include file="frontend/components/header.tpl" pageTitle="about.aboutContext"}

<div class="page page_about jrdc-about-layout">
  {include file="frontend/components/breadcrumbs.tpl" currentTitleKey="about.aboutContext"}

  <div class="jrdc-about-grid">
    {* Left navigation *}
    <nav class="jrdc-about-nav" aria-label="Navigasi Tentang">
      <ul>
        <li class="active"><a href="{url page="about"}">{translate key="about.aboutContext"}</a></li>
        <li><a href="{url page="about" op="editorialTeam"}">{translate key="about.editorialTeam"}</a></li>
        <li><a href="{url page="about" op="submissions"}">{translate key="about.submissions"}</a></li>
        {* Static pages — hardcode path *}
        <li><a href="{url page="pages" op="view" path="ethics"}">Etika Publikasi</a></li>
        <li><a href="{url page="pages" op="view" path="privacy"}">Kebijakan Privasi</a></li>
        <li><a href="{url page="about" op="contact"}">{translate key="about.contact"}</a></li>
      </ul>
    </nav>

    {* Main content *}
    <main class="jrdc-about-main jrdc-card">
      <h1>{translate key="about.aboutContext"}</h1>
      {include file="frontend/components/editLink.tpl" page="management" op="settings" path="context" anchor="masthead" sectionTitleKey="about.aboutContext"}
      <div class="jrdc-prose">
        {$currentContext->getLocalizedData('about')}
      </div>
    </main>
  </div>
</div>

{include file="frontend/components/footer.tpl"}
```

> **Catatan:** Sketsa di atas adalah panduan, bukan kode final. Class CSS prefix `jrdc-` harus didefinisikan di stylesheet kustom atau LESS tema.

---

## 7. Checklist Visual QA

- [ ] Breadcrumb tampil: Beranda > Tentang Jurnal
- [ ] Left sidebar nav 7 item, "Tentang Jurnal" dalam state aktif (highlight `primary #c2410c` atau bold)
- [ ] Main card dengan `rounded-2xl`, shadow, background putih
- [ ] Konten prosa: heading, paragraf, list ter-format dengan `jrdc-prose`
- [ ] Separator `border-t` antar sub-section
- [ ] Layout 2-kolom (3+9) di desktop, stack 1-kolom di mobile (nav di atas konten)
- [ ] Link nav mengarah ke halaman yang benar (cek 404 untuk Static Pages)
- [ ] Edit link (pensil) muncul bagi admin yang login
- [ ] Tidak ada konten terpotong di viewport sempit
