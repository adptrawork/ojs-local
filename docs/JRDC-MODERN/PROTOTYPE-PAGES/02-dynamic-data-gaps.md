# Elemen Dinamis Non-Native OJS 3.3

Inventaris elemen prototype yang **bukan bawaan** OJS 3.3 dan memerlukan
Custom Block, plugin, atau pengembangan kustom.

---

## Tabel Inventaris

| # | Elemen | Status | Implementasi di OJS 3.3 | Prioritas | Catatan |
|---|--------|--------|------------------------|-----------|---------|
| 1 | **Peta koroplet SVG** distribusi penulis + KPI (total penulis, negara, top share) | 🔴 | Custom Block HTML dengan SVG statis + angka hardcode, **atau** plugin kustom yang query data penulis | P3 | Data statis cukup untuk launch; plugin dinamis sebagai fase lanjutan |
| 2 | **Chart statistik bulanan** (views/downloads bar chart) | 🔴 | Custom Block HTML statis (gambar/SVG), **atau** plugin yang ambil data dari `usageStats` + render chart (Chart.js) | P2 | Plugin usageStats sudah simpan data; yang kurang hanya visualisasi chart |
| 3 | **Keyword cloud** dengan jumlah/count | 🟡/🔴 | 🟡 Statis: Custom Block HTML dengan tag cloud hardcode. 🔴 Dinamis: plugin yang query keyword dari artikel published | P2 | Versi statis mudah; update manual per periode |
| 4 | **Logo/badge indexing** (Crossref, Google Scholar, Garuda, SINTA, DOAJ) | 🟡 | Custom Block Manager → blok HTML berisi gambar/logo | P1 | Siap implementasi, hanya perlu aset gambar + HTML |
| 5 | **Logo tools** (Mendeley, Zotero, Turnitin, Grammarly, VOSviewer) | 🟡 | Custom Block Manager → blok HTML berisi gambar/logo | P1 | Sama seperti #4, konten statis |
| 6 | **Statistik naskah** (views/downloads per artikel di sidebar) | 🟢 | Plugin `usageStats` bawaan OJS — sudah tersedia; perlu enable + styling tampilan counter | P1 | Aktifkan plugin, styling counter di LESS |
| 7 | **Artikel Terkait** (sidebar di halaman artikel) | 🔴 | Plugin kustom yang query artikel dgn keyword/section sama, **atau** manual HTML di Custom Block per artikel (tidak praktis) | P3 | Belum ada plugin OJS 3.3 yang mature; tunda |
| 8 | **LoA (Surat Penerimaan)** card/section | 🔴 | Custom dev: Static Page dengan HTML, **atau** plugin kustom yang generate LoA dari submission data | P3 | Bisa pakai Static Pages plugin untuk versi manual |
| 9 | **Share article** (WhatsApp, X, Facebook, LinkedIn, salin tautan) | 🟡 | Plugin AddThis / ShareIt (Generic Plugin), **atau** Custom Block HTML dengan share URL API (`https://wa.me/?text=...`, `https://twitter.com/intent/tweet?url=...`) | P2 | Custom Block HTML lebih ringan daripada plugin external |
| 10 | **Dark mode toggle** | 🟡 | JS kustom di tema: toggle class `dark` pada `<html>`, simpan preferensi di `localStorage` | P3 | Keputusan: tunda ke fase terpisah (lihat `00-design-system.md`) |
| 11 | **Filter tahun arsip** (client-side dropdown/button) | 🟡 | JS kustom di tema: filter `<li>` berdasar tahun, tanpa server request | P2 | OJS archive page sudah list per tahun; JS hanya show/hide |
| 12 | **Tabel/daftar per halaman statis** (dewan redaksi, pedoman penulis, kebijakan) | 🟢 | Konten via Journal Settings (Editorial Team, Author Guidelines, dsb.) atau Static Pages plugin | P1 | Native OJS — hanya perlu isi konten + styling |

---

## Ringkasan Per Prioritas

### P1 — Siap Implementasi (konfigurasi + styling)

| # | Elemen | Cara |
|---|--------|------|
| 4 | Logo indexing | Custom Block HTML |
| 5 | Logo tools | Custom Block HTML |
| 6 | Statistik naskah | Enable plugin `usageStats` + LESS styling |
| 12 | Halaman statis (redaksi, pedoman, kebijakan) | Journal Settings / Static Pages |

### P2 — Perlu Sedikit Kustomisasi

| # | Elemen | Cara |
|---|--------|------|
| 2 | Chart statistik | Custom Block statis untuk awal; plugin chart nanti |
| 3 | Keyword cloud | Custom Block HTML statis |
| 9 | Share article | Custom Block HTML (share URL) |
| 11 | Filter tahun arsip | JS kecil di tema |

### P3 — Memerlukan Pengembangan / Ditunda

| # | Elemen | Cara |
|---|--------|------|
| 1 | Peta koroplet | Custom Block statis; plugin dinamis nanti |
| 7 | Artikel terkait | Plugin kustom — scope besar |
| 8 | LoA card | Static Page manual atau plugin kustom |
| 10 | Dark mode | JS kustom tema — fase terpisah |

---

## Contoh Implementasi Custom Block

Custom Block Manager (plugin bawaan OJS) memungkinkan blok HTML di sidebar.
Aktifkan via Dashboard → Settings → Website → Plugins → Custom Block Manager.

### Contoh: Logo Pengindeksan (#4)

Buat blok baru bernama `indexing`, isi HTML:

```html
<div class="jrdc-indexing-logos">
  <h3>Terindeks di</h3>
  <div class="jrdc-logo-grid">
    <img src="/public/site/images/indexing/crossref.png" alt="Crossref" loading="lazy">
    <img src="/public/site/images/indexing/google-scholar.png" alt="Google Scholar" loading="lazy">
    <img src="/public/site/images/indexing/garuda.png" alt="Garuda" loading="lazy">
    <img src="/public/site/images/indexing/sinta.png" alt="SINTA" loading="lazy">
    <img src="/public/site/images/indexing/doaj.png" alt="DOAJ" loading="lazy">
  </div>
</div>
```

LESS:

```less
.jrdc-logo-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    img {
        max-height: 40px;
        width: auto;
        object-fit: contain;
    }
}
```

### Contoh: Share Article (#9)

```html
<div class="jrdc-share">
  <h3>Bagikan</h3>
  <div class="jrdc-share__buttons">
    <a href="https://wa.me/?text={$currentUrl}" target="_blank" rel="noopener" aria-label="WhatsApp">WA</a>
    <a href="https://twitter.com/intent/tweet?url={$currentUrl}" target="_blank" rel="noopener" aria-label="X">X</a>
    <a href="https://www.facebook.com/sharer/sharer.php?u={$currentUrl}" target="_blank" rel="noopener" aria-label="Facebook">FB</a>
    <a href="https://www.linkedin.com/sharing/share-offsite/?url={$currentUrl}" target="_blank" rel="noopener" aria-label="LinkedIn">LI</a>
    <button onclick="navigator.clipboard.writeText(window.location.href)" aria-label="Salin tautan">📋</button>
  </div>
</div>
```

> **Catatan:** `{$currentUrl}` tidak tersedia di Custom Block. Untuk share
> dinamis, pakai JS: `window.location.href` sebagai URL, atau implementasikan
> sebagai Smarty snippet di template artikel (`article_details.tpl`).
