# 👥 Dewan Redaksi / Editorial Team

> **Prototype:** [`editorial-team.html`](https://adptrawork.github.io/build-OJS/editorial-team.html)
> **Route OJS:** `/index.php/jrdc/about/editorialTeam`
> **File implementasi (core):** `lib/pkp/templates/frontend/pages/editorialTeam.tpl`
> **File override (child theme):** `plugins/themes/sangulineModern/templates/frontend/pages/editorialTeam.tpl` *(belum ada, perlu dibuat)*

---

## 1. Referensi Prototype

Layout identik dengan halaman About (2-kolom: left nav + main card).

**Komponen kunci:**
- Breadcrumb (Beranda > Tentang > Dewan Redaksi)
- Left sidebar nav (sama persis dengan `about.html`), item "Dewan Redaksi" aktif
- Main card berisi daftar anggota redaksi dengan:
  - Nama lengkap + gelar
  - Peran (Editor-in-Chief, Managing Editor, Section Editor, Reviewer, dll.)
  - Afiliasi institusi
  - Badge visual per peran ("Editor" warna biru, "Reviewer" warna hijau, dll.)
- Grid card atau list terstruktur per kategori peran

---

## 2. Route OJS & File Implementasi

### Template Core (PKP)

```
lib/pkp/templates/frontend/pages/editorialTeam.tpl
```

Isi core (OJS 3.3):
```smarty
{include file="frontend/components/header.tpl" pageTitle="about.editorialTeam"}
<div class="page page_editorial_team">
  {include file="frontend/components/breadcrumbs.tpl" currentTitleKey="about.editorialTeam"}
  <h1>{translate key="about.editorialTeam"}</h1>
  {include file="frontend/components/editLink.tpl"
    page="management" op="settings" path="context" anchor="masthead"
    sectionTitleKey="about.editorialTeam"}
  {$currentContext->getLocalizedData('editorialTeam')}
</div>
{include file="frontend/components/footer.tpl"}
```

### Override yang Perlu Dibuat

```
plugins/themes/sangulineModern/templates/frontend/pages/editorialTeam.tpl
```

---

## 3. Variabel & Hook Kritis

### Variabel Smarty

| Variabel | Tipe | Sumber |
|----------|------|--------|
| `$currentContext` | `Journal` | Core OJS |
| `$currentContext->getLocalizedData('editorialTeam')` | `string` (HTML) | Journal Settings → Masthead → Editorial Team |

### Hook

| Hook | Catatan |
|------|---------|
| _Tidak ada hook khusus di `editorialTeam.tpl`_ | Sama seperti `about.tpl` — template sangat sederhana |

### Edit Link (Backend)

```smarty
{include file="frontend/components/editLink.tpl"
  page="management" op="settings" path="context" anchor="masthead"
  sectionTitleKey="about.editorialTeam"}
```
Jangan hapus — tombol edit cepat bagi admin.

---

## 4. Pemetaan Konten (Prototype → OJS)

### 4.1. Breadcrumb

| Elemen Prototype | Sumber OJS | Label |
|-----------------|------------|-------|
| Beranda > Tentang > Dewan Redaksi | `{include file="frontend/components/breadcrumbs.tpl" currentTitleKey="about.editorialTeam"}` | 🟢 |

### 4.2. Left Sidebar Navigasi

| Elemen Prototype | Sumber OJS | Label |
|-----------------|------------|-------|
| Menu navigasi vertikal (sama dengan about), "Dewan Redaksi" aktif | Override template — reuse pola dari `about.tpl` | 🔴 |

**Implementasi:** Gunakan partial/snippet yang sama dengan `about.tpl` (lihat `about.md` Gap G4). Perbedaannya hanya item mana yang mendapat class `active`.

**Pendekatan yang disarankan:** Buat file partial reusable:
```
plugins/themes/sangulineModern/templates/frontend/components/aboutNav.tpl
```

Dengan parameter `$activeItem` untuk menentukan item aktif:
```smarty
{* aboutNav.tpl — reusable left nav untuk halaman-halaman "Tentang" *}
<nav class="jrdc-about-nav" aria-label="Navigasi Tentang">
  <ul>
    <li{if $activeItem == 'about'} class="active"{/if}>
      <a href="{url page="about"}">{translate key="about.aboutContext"}</a>
    </li>
    <li{if $activeItem == 'editorialTeam'} class="active"{/if}>
      <a href="{url page="about" op="editorialTeam"}">{translate key="about.editorialTeam"}</a>
    </li>
    {* ... item lainnya ... *}
  </ul>
</nav>
```

### 4.3. Main Card — Daftar Redaksi

| Elemen Prototype | Sumber OJS | Label |
|------------------|------------|-------|
| Heading "Dewan Redaksi" | `{translate key="about.editorialTeam"}` | 🟢 |
| Daftar anggota (nama, peran, afiliasi) | `{$currentContext->getLocalizedData('editorialTeam')}` — konten HTML dari Masthead setting | 🟢 |
| Badge peran (Editor / Reviewer) | **Styling CSS** pada elemen HTML di konten setting | 🟡 |
| Foto anggota (jika ada) | Embed `<img>` di konten HTML setting, atau tidak ada (opsional) | 🟡 |

**Bagaimana data masuk:**

OJS 3.3 menyimpan data editorial team sebagai **satu blok HTML** di field Masthead → Editorial Team. Artinya:
- Semua nama, peran, afiliasi diketik sebagai HTML oleh admin
- Tidak ada database relasional per-anggota (bukan dari tabel `users`/`user_groups`)
- Badge "Editor"/"Reviewer" harus di-encode dalam HTML konten (misal `<span class="badge badge-editor">Editor</span>`)

**Contoh konten HTML yang perlu diisi admin:**
```html
<div class="jrdc-team-section">
  <h2>Editor-in-Chief</h2>
  <div class="jrdc-team-member">
    <h3>Dr. Nama Lengkap, M.Si.</h3>
    <span class="jrdc-badge jrdc-badge--editor">Editor</span>
    <p class="jrdc-team-affiliation">Universitas XYZ, Indonesia</p>
  </div>
</div>

<div class="jrdc-team-section">
  <h2>Reviewers</h2>
  <div class="jrdc-team-member">
    <h3>Prof. Dr. Nama Lain</h3>
    <span class="jrdc-badge jrdc-badge--reviewer">Reviewer</span>
    <p class="jrdc-team-affiliation">University of ABC, Malaysia</p>
  </div>
  <!-- ... anggota lainnya ... -->
</div>
```

CSS kustom mendefinisikan styling `.jrdc-badge`, `.jrdc-team-member`, dll.

---

## 5. Gap & Keputusan

| # | Gap | Opsi | Rekomendasi | Prioritas |
|---|-----|------|-------------|-----------|
| G1 | Override `editorialTeam.tpl` belum ada | Buat file override | Buat dari core + grid wrapper + left nav | Tinggi |
| G2 | Left nav harus konsisten dengan `about.tpl` | (a) Copy-paste nav (b) Partial reusable `aboutNav.tpl` | **(b)** Partial reusable — DRY, satu tempat update | Tinggi |
| G3 | Badge per peran (Editor/Reviewer) | (a) CSS class di konten HTML admin (b) Plugin parsing tabel `users` | **(a)** CSS class — data sudah HTML, cukup styling | Sedang |
| G4 | Konten Masthead harus diisi ulang dengan HTML terstruktur | Guide admin untuk format HTML yang benar | Sediakan template HTML + dokumentasi | Sedang |
| G5 | Foto anggota redaksi | (a) Embed `<img>` di HTML konten (b) Ambil dari Gravatar/user profile | **(a)** Embed manual — paling sederhana untuk 3.3 | Rendah |

---

## 6. Sketsa Struktur Override

```smarty
{* plugins/themes/sangulineModern/templates/frontend/pages/editorialTeam.tpl *}
{include file="frontend/components/header.tpl" pageTitle="about.editorialTeam"}

<div class="page page_editorial_team jrdc-about-layout">
  {include file="frontend/components/breadcrumbs.tpl" currentTitleKey="about.editorialTeam"}

  <div class="jrdc-about-grid">
    {* Left navigation — reuse partial *}
    {include file="frontend/components/aboutNav.tpl" activeItem="editorialTeam"}

    {* Main content *}
    <main class="jrdc-about-main jrdc-card">
      <h1>{translate key="about.editorialTeam"}</h1>
      {include file="frontend/components/editLink.tpl"
        page="management" op="settings" path="context" anchor="masthead"
        sectionTitleKey="about.editorialTeam"}
      <div class="jrdc-prose jrdc-team-list">
        {$currentContext->getLocalizedData('editorialTeam')}
      </div>
    </main>
  </div>
</div>

{include file="frontend/components/footer.tpl"}
```

---

## 7. Checklist Visual QA

- [ ] Breadcrumb tampil: Beranda > Tentang > Dewan Redaksi
- [ ] Left sidebar nav konsisten dengan halaman About, "Dewan Redaksi" dalam state aktif
- [ ] Main card (`rounded-2xl`, shadow) menampilkan daftar anggota
- [ ] Nama, peran, dan afiliasi tiap anggota terbaca jelas
- [ ] Badge peran (Editor/Reviewer) tampil dengan warna berbeda sesuai prototype
- [ ] Anggota dikelompokkan per kategori peran (heading `<h2>` per section)
- [ ] Layout 2-kolom (3+9) di desktop, stack 1-kolom di mobile
- [ ] Edit link (pensil) muncul bagi admin yang login
- [ ] Konten HTML dari Masthead setting ter-render dengan benar (tidak ada raw HTML terlihat)
