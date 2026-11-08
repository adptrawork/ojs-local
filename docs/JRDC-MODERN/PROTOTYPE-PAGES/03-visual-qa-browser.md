# 03 — Panduan Verifikasi Visual (QA Browser)

> Memastikan tampilan OJS mendekati prototype — bukan pixel-perfect, tapi **paritas komponen & rasa visual**.

---

## 1. Tujuan

Setiap halaman OJS yang sudah diimplementasi harus dibandingkan secara visual dengan prototype HTML statis. Fokus pada:

- Struktur komponen ada dan posisinya benar
- Tipografi, spacing, dan warna selaras dengan design token
- Layout responsif tidak pecah di semua breakpoint
- Interaksi dasar (hover, focus, dropdown, link) berfungsi

**Bukan** tujuan: kesamaan piksel 1:1 — OJS punya markup dinamis yang berbeda dari HTML statis.

---

## 2. URL Referensi

| Sumber | Base URL |
|--------|----------|
| Prototype | `https://adptrawork.github.io/build-OJS/<page>.html` |
| OJS lokal | `http://ojs-3.3.0-24.test/index.php/jrdc/...` |

---

## 3. Prosedur Manual (Tanpa Browser Agent)

### 3.1 Persiapan

1. Buka **2 tab** browser berdampingan (atau 2 window split-screen)
2. Tab 1: prototype — misal `https://adptrawork.github.io/build-OJS/index.html`
3. Tab 2: OJS — misal `http://ojs-3.3.0-24.test/index.php/jrdc`

### 3.2 Bandingkan per Breakpoint

Gunakan DevTools → Device Toolbar (Ctrl+Shift+M) untuk set viewport:

| Breakpoint | Lebar | Tinggi | Keterangan |
|------------|-------|--------|------------|
| Mobile | 360px | 800px | Smartphone standar |
| Tablet | 768px | 1024px | iPad portrait |
| Desktop | 1280px | 900px | Laptop umum |
| Large | 1440px | 900px | Monitor eksternal |

### 3.3 Fokus Perbandingan

Per breakpoint, periksa area berikut:

1. **Header/Nav** — logo posisi, menu items, search bar, tombol Masuk/Login
2. **Hero/Card shape** — form card, aspect ratio gambar, shadow/border
3. **Tipografi & spacing** — ukuran heading/body, line-height, margin/padding antar elemen
4. **Warna & kontras** — primer/aksen/netral sesuai token di `00-design-system.md`
5. **Sidebar** — blok hadir, urutan benar, konten terisi
6. **Footer** — struktur 4-kolom, background color, link lengkap
7. **State hover/focus** — efek hover pada card/link, focus-visible pada elemen interaktif

### 3.4 Ambil Screenshot

1. DevTools → Device Toolbar → **set viewport** sesuai breakpoint
2. Klik ⋮ (menu) di Device Toolbar → **Capture full-size screenshot**
3. Simpan ke:
   ```
   docs/JRDC-MODERN/QA-SCREENSHOTS/<halaman>-<sumber>-<lebar>px.png
   ```
   Contoh: `index-proto-360px.png`, `index-ojs-360px.png`

---

## 4. Prosedur Otomatis (Playwright)

Jika Playwright tersedia, gunakan skrip berikut untuk batch screenshot:

```js
const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch();
  const viewports = [
    { w: 360, h: 800 },
    { w: 768, h: 1024 },
    { w: 1280, h: 900 },
    { w: 1440, h: 900 },
  ];

  const pages = [
    { name: 'index', proto: 'index.html', ojs: '' },
    { name: 'archive', proto: 'archive.html', ojs: 'issue/archive' },
    { name: 'article', proto: 'article.html', ojs: 'article/view/1' },
    // Tambah halaman lain sesuai kebutuhan
  ];

  const protoBase = 'https://adptrawork.github.io/build-OJS/';
  const ojsBase = 'http://ojs-3.3.0-24.test/index.php/jrdc/';
  const outDir = 'docs/JRDC-MODERN/QA-SCREENSHOTS';

  for (const vp of viewports) {
    for (const pg of pages) {
      const ctx = await browser.newContext({
        viewport: { width: vp.w, height: vp.h },
      });
      const page = await ctx.newPage();

      // Prototype
      await page.goto(`${protoBase}${pg.proto}`, { waitUntil: 'networkidle' });
      await page.screenshot({
        path: `${outDir}/${pg.name}-proto-${vp.w}px.png`,
        fullPage: true,
      });

      // OJS
      await page.goto(`${ojsBase}${pg.ojs}`, { waitUntil: 'networkidle' });
      await page.screenshot({
        path: `${outDir}/${pg.name}-ojs-${vp.w}px.png`,
        fullPage: true,
      });

      await ctx.close();
    }
  }

  await browser.close();
  console.log('Screenshot selesai.');
})();
```

Jalankan: `npx playwright install chromium && node qa-screenshot.js`

---

## 5. Checklist per Halaman

Gunakan template ini untuk setiap halaman. Salin ke file `pages/<halaman>.md` bagian "QA Visual".

```markdown
### QA Visual — [Nama Halaman]

- [ ] **Header:** logo/posisi, nav items, search, tombol Masuk — paritas
- [ ] **Konten utama:** layout grid/card, spacing, tipografi heading/body
- [ ] **Warna:** primer/aksen/netral selaras token
- [ ] **Sidebar:** blok ada & posisi benar
- [ ] **Footer:** struktur 4-kolom, warna bg, links
- [ ] **Responsive:** tidak ada overflow/broken layout di mobile (360px)
- [ ] **Aksesibilitas:** focus-visible, kontras cukup (≥4.5:1 teks, ≥3:1 UI)
- [ ] **Fungsionalitas:** menu dropdown, search, galley/PDF link, login — bekerja
```

---

## 6. Issue Tracking

Gunakan tabel ini untuk melacak gap visual yang perlu diperbaiki:

| Halaman | Komponen | Breakpoint | Status | Catatan |
|---------|----------|------------|--------|---------|
| index | Hero card | 360px | 🔴 Gap | Card tidak stack vertikal |
| index | Footer | 1280px | 🟢 OK | — |
| article | Sidebar | 768px | 🟡 Minor | Spacing terlalu rapat |
| ... | ... | ... | ... | ... |

**Legend:** 🟢 OK — 🟡 Minor (bisa ditoleransi) — 🔴 Gap (harus diperbaiki)

---

## 7. Kapan Melakukan Review

- ✅ Setelah setiap batch implementasi template/CSS baru
- ✅ Sebelum merge perubahan tema ke branch utama
- ✅ Sebelum deploy ke staging/production
- ✅ Setelah update OJS core atau plugin yang mempengaruhi frontend

---

## 8. Folder Screenshot

```
docs/JRDC-MODERN/QA-SCREENSHOTS/
├── index-proto-360px.png
├── index-ojs-360px.png
├── index-proto-768px.png
├── index-ojs-768px.png
├── ...
└── README.md          ← (opsional) catatan tanggal capture
```

> **Tip:** jangan commit screenshot ke Git — tambahkan `docs/JRDC-MODERN/QA-SCREENSHOTS/*.png` ke `.gitignore` jika repo terlalu besar. Simpan di shared drive atau artifact CI.
