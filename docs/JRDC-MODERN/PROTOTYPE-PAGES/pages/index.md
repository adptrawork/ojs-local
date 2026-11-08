# 🏠 Beranda / Homepage

> **Prototype:** [`index.html`](https://adptrawork.github.io/build-OJS/)
> **Route OJS:** `/index.php/jrdc`
> **File implementasi:** `plugins/themes/sangulineModern/templates/frontend/pages/indexJournal.tpl`

---

## 1. Referensi Prototype

Halaman utama jurnal JRDC. Layout full-width, konten utama + sidebar kanan.

**Komponen kunci prototype:**
- Hero card navy (`bg-navy-hero #0b2038`, `rounded-2xl`)
- Grid `max-w-7xl`, 12 kolom
- Warna aksen `primary #c2410c`
- Font Geist

---

## 2. Sections Prototype → Sumber OJS

### 2.1. Header (Global)

| Elemen | Implementasi OJS | Label |
|--------|-----------------|-------|
| Header/navigasi | `{include file="frontend/components/header.tpl"}` | 🟢 |
| Logo, menu utama | Navigation Menu Manager + Journal Settings | 🟢 |

Lihat `01-global-shell.md` untuk detail.

### 2.2. Hero Card Navy

| Elemen Prototype | Sumber OJS | Label |
|-----------------|------------|-------|
| Eyebrow "JURNAL ILMIAH • EKONOMI DAN BISNIS" | Hardcode di template atau setting kustom | 🟡 |
| Judul `h1` (nama jurnal) | `$currentJournal->getLocalizedName()` (via `pageTitleTranslated` di header include) | 🟢 |
| Deskripsi jurnal | `$currentContext->getLocalizedData('description')` / `$journalDescription` | 🟢 |
| Meta info (Frekuensi, Penerbit) | Tidak ada variabel Smarty native → hardcode atau `$additionalHomeContent` | 🟡 |
| Cover image (kanan) | `$homepageImage` → `{$publicFilesDir}/{$homepageImage.uploadName}` | 🟢 |

**Implementasi saat ini di template:**
```smarty
{if ($activeTheme && !$activeTheme->getOption('useHomepageImageAsHeader') && $homepageImage)
  || ($activeTheme && $activeTheme->getOption('showDescriptionInJournalIndex'))}
  <section class="homepage_hero jrdc-hero">
    {* image *}
    {* description *}
  </section>
{/if}
```

**Gap:** Prototype punya layout 2-kolom (teks kiri, cover kanan) dalam card navy `rounded-2xl`. Template saat ini sudah ada, tapi styling hero navy + responsive stack (mobile) perlu CSS kustom di `jrdc-custom.css` atau LESS tema.

### 2.3. Section "Tentang Jurnal" (4 Info-Card)

| Elemen Prototype | Sumber OJS | Label |
|-----------------|------------|-------|
| Kartu Fokus & Cakupan | Link ke `/about` atau konten dari `$additionalHomeContent` | 🟡 |
| Kartu Dewan Redaksi | Link ke `/about/editorialTeam` | 🟡 |
| Kartu Pedoman Penulis | Link ke halaman Submissions atau Static Page | 🟡 |
| Kartu Etika Publikasi | Link ke Static Page | 🟡 |

**Gap:** OJS tidak punya section "4 info-card" native. Opsi:
- **(a)** Tambah HTML di `$additionalHomeContent` (Settings → Website → Appearance → Additional Content) — 🟡 setting
- **(b)** Buat section baru di override `indexJournal.tpl` dengan link hardcode — 🔴 custom dev

**Rekomendasi:** Opsi (a) untuk konten, dengan styling dari CSS kustom (class `.jrdc-info-cards`).

### 2.4. "Terbitan Jurnal Terbaru"

| Elemen Prototype | Sumber OJS | Label |
|-----------------|------------|-------|
| Section header + identifikasi issue | `$issue->getIssueIdentification()` | 🟢 |
| Kartu artikel (judul, penulis, afiliasi) | `{include file="frontend/objects/issue_toc.tpl"}` → `article_summary.tpl` | 🟢 |
| Aksi: Abstrak / Unduh PDF / Detail | Galley links + article view URL di `article_summary.tpl` | 🟢 |
| Link "Lihat Semua Terbitan" (arsip) | `{url router=$smarty.const.ROUTE_PAGE page="issue" op="archive"}` | 🟢 |

**Implementasi saat ini:**
```smarty
{if $issue}
  <section class="current_issue jrdc-section jrdc-issue jrdc-card">
    {include file="frontend/objects/issue_toc.tpl" heading="h3"}
    <a href="{url ...page='issue' op='archive'}" class="jrdc-button jrdc-button--secondary">
      {translate key="journal.viewAllIssues"}
    </a>
  </section>
{/if}
```

**Catatan:** `article_summary.tpl` sudah di-override di child theme (`plugins/themes/sangulineModern/templates/frontend/objects/article_summary.tpl`). Pastikan kartu artikel menyertakan hover state sesuai prototype.

### 2.5. "DISTRIBUSI GEOGRAFIS PENULIS" (Peta)

| Elemen Prototype | Sumber OJS | Label |
|-----------------|------------|-------|
| Peta koroplet SVG | Tidak ada di OJS core | 🔴 |
| KPI (total penulis, negara, dll.) | Tidak ada API native | 🔴 |
| Top negara list | Tidak ada | 🔴 |

**Gap:** Fitur sepenuhnya custom. Opsi:
- **(a)** Custom Block + JavaScript/SVG statis — 🔴  
- **(b)** Plugin kustom yang query `author_settings` → generate data — 🔴

Lihat `02-dynamic-data-gaps.md` untuk detail.

### 2.6. "Pengumuman"

| Elemen Prototype | Sumber OJS | Label |
|-----------------|------------|-------|
| List pengumuman + date badge | `{include file="frontend/objects/announcements_list.tpl" numAnnouncements=$numAnnouncementsHomepage}` | 🟢 |
| Date badge styling | CSS kustom pada `.obj_announcement_summary .date` | 🟡 |

**Implementasi saat ini:**
```smarty
{if $announcements && $numAnnouncementsHomepage}
  <section class="jrdc-section jrdc-announcements">
    {include file="frontend/objects/announcements_list.tpl" numAnnouncements=$numAnnouncementsHomepage}
  </section>
{/if}
```

**Catatan:** `announcements_list.tpl` sudah di-override di child theme.

### 2.7. Sidebar Kanan

| Widget Prototype | Sumber OJS | Label |
|-----------------|------------|-------|
| Informasi Jurnal | Custom Block Manager plugin → blok HTML | 🟡 |
| Untuk Penulis | Custom Block Manager → link ke Submissions | 🟡 |
| Templat Artikel | Custom Block Manager → link unduh | 🟡 |
| Kata Kunci Populer | Custom Block → tag cloud statis atau plugin | 🟡/🔴 |
| Pengindeksan (DOAJ, Crossref, dll.) | Custom Block → gambar/logo | 🟡 |
| Rekomendasi Tools | Custom Block → link Mendeley/Zotero | 🟡 |
| Arsip | Block plugin bawaan `DevelopedByBlockPlugin` area atau Custom Block | 🟡 |
| Statistik Artikel | Usage Stats plugin block atau Custom Block | 🟡 |

**Mekanisme OJS:**
```smarty
{call_hook name="Templates::Common::Sidebar"}
```
Blok sidebar dikelola di **Settings → Website → Appearance → Sidebar Management** dan **Custom Block Manager** plugin.

### 2.8. Footer (Global)

| Elemen | Implementasi OJS | Label |
|--------|-----------------|-------|
| Footer 4 kolom | `{include file="frontend/components/footer.tpl"}` — override di child theme | 🟢/🟡 |

Lihat `01-global-shell.md` untuk detail.

---

## 3. Variabel & Hook Kritis

### Variabel Smarty

| Variabel | Tipe | Sumber |
|----------|------|--------|
| `$currentJournal` / `$currentContext` | `Journal` | Core OJS |
| `$homepageImage` | `object` (uploadName, width, height, altText) | Journal Settings → Homepage Image |
| `$journalDescription` | `string` (HTML) | `$currentContext->getLocalizedData('description')` |
| `$additionalHomeContent` | `string` (HTML) | Journal Settings → Appearance → Additional Content |
| `$announcements` | `array` | Announcements DAO |
| `$numAnnouncementsHomepage` | `int` | Journal Settings |
| `$issue` | `Issue` | Current published issue |

### Hook yang Tidak Boleh Dihapus

| Hook | Lokasi | Fungsi |
|------|--------|--------|
| `{call_hook name="Templates::Index::journal"}` | Awal `.page_index_journal` | Plugin injection point (e.g. Custom Header, dsb.) |
| `{call_hook name="Templates::Common::Sidebar"}` | Sidebar area | Render semua blok sidebar aktif |

### JavaScript Kritis

| Fitur | Selector/Class | Catatan |
|-------|---------------|---------|
| Toggle abstrak | `.abstract_toggle` atau sejenisnya | Jangan rename class tanpa update JS |
| Galley link routing | `.obj_galley_link` | URL harus tetap ikuti `{url ...}` Smarty |

---

## 4. Gap & Keputusan

| # | Gap | Opsi | Rekomendasi | Prioritas |
|---|-----|------|-------------|-----------|
| G1 | Hero navy layout (teks+cover 2 kolom) | CSS kustom class `.jrdc-hero` | Sudah ada class, tambah styling navy + responsive | Tinggi |
| G2 | Eyebrow text + meta info | (a) Hardcode template (b) Setting kustom | (a) Hardcode — konten jarang berubah | Sedang |
| G3 | 4 info-card section | (a) `$additionalHomeContent` (b) Override TPL | (a) via Additional Content + CSS class | Sedang |
| G4 | Peta distribusi penulis | Custom Block + JS/SVG | Phase 2 — lihat `02-dynamic-data-gaps.md` | Rendah |
| G5 | Keyword cloud sidebar | Custom Block statis atau plugin | Custom Block statis dulu | Rendah |
| G6 | Statistik artikel sidebar | Usage Stats block plugin | Aktifkan plugin jika belum | Sedang |

---

## 5. Checklist Visual QA

- [ ] Hero card navy (`#0b2038`) dengan cover image di kanan, responsive stack ke vertikal di mobile
- [ ] Eyebrow text + judul + deskripsi terbaca di atas background navy (kontras WCAG AA)
- [ ] 4 info-card grid 2×2 (desktop), stack 1 kolom (mobile)
- [ ] Kartu artikel terbitan terbaru: judul, penulis, afiliasi, aksi (Abstrak/PDF/Detail), hover state
- [ ] Link "Lihat Semua Terbitan" mengarah ke `/index.php/jrdc/issue/archive`
- [ ] Pengumuman tampil dengan date badge, urut terbaru
- [ ] Sidebar kanan: semua blok terstyling konsisten (border, spacing, heading)
- [ ] Footer 4 kolom responsive
- [ ] Tidak ada horizontal scroll di viewport ≤ 375px
- [ ] Hook `Templates::Index::journal` dan `Templates::Common::Sidebar` tetap berfungsi (test: aktifkan Custom Block → muncul)
