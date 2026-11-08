# Kirim Naskah (`submissions.html`)

> Dokumentasi pemetaan halaman prototype → implementasi OJS 3.3.0-24 untuk JRDC (`journal_id=1`).

## 1. Referensi Prototype

- **File prototype:** [`submissions.html`](https://adptrawork.github.io/build-OJS/submissions.html)
- **Repo:** `prototype-pages` branch — [lihat sumber](https://github.com/adptrawork/build-OJS/tree/prototype-pages)
- **Desain:** Tailwind + Geist, primary `#c2410c`
- **Layout:** Informasi checklist persyaratan pengiriman + tombol CTA "Akses Sistem Pengiriman Online" yang mengarah ke wizard submission

## 2. Route OJS & File Implementasi

| Aspek | Detail |
|---|---|
| **Route OJS (info)** | `/index.php/jrdc/about/submissions` |
| **Route OJS (wizard)** | `/index.php/jrdc/submission/wizard` (memerlukan login) |
| **Template core** | `lib/pkp/templates/frontend/pages/submissions.tpl` |
| **Child theme override** | `plugins/themes/sangulineModern/templates/frontend/pages/submissions.tpl` |
| **CSS** | `plugins/themes/sangulineModern/styles/index.less` atau `docs/JRDC-MODERN/jrdc-custom.css` |

## 3. Variabel / Hook Kritis

| Variabel | Keterangan |
|---|---|
| `{$submissionChecklist}` | Array checklist item pengiriman (dari Settings → Workflow → Submission) |
| `{$currentContext->getLocalizedData('authorGuidelines')}` | Pedoman penulis (HTML) |
| `{$currentContext->getLocalizedData('copyrightNotice')}` | Pemberitahuan hak cipta |
| `{$currentContext->getLocalizedData('privacyStatement')}` | Pernyataan privasi |
| `{url page="submission" op="wizard"}` | **URL wizard submission — JANGAN hardcode** |
| `{url page="login"}` | URL login (redirect jika belum login) |

> ⚠️ **KRITIS:** Jangan pernah mengubah atau memodifikasi **wizard submission** (`/submission/wizard`). Wizard ini berisi form multi-step dengan CSRF token, validasi server-side, dan logika OJS internal. Halaman ini hanya men-styling **halaman informasi** (`about/submissions`) dan mengarahkan CTA ke wizard.

## 4. Pemetaan Konten

| Elemen Prototype | Sumber Data OJS | Cara Isi |
|---|---|---|
| Judul "Kirim Naskah" | Template heading | Override template atau CSS |
| Checklist persyaratan | `{$submissionChecklist}` | Settings → Workflow → Submission → Preparation Checklist |
| Pedoman penulis (ringkasan) | `{$currentContext->getLocalizedData('authorGuidelines')}` | Settings → Workflow → Submission → Author Guidelines |
| Pemberitahuan hak cipta | `{$currentContext->getLocalizedData('copyrightNotice')}` | Settings → Distribution → Permissions → Copyright Notice |
| Pernyataan privasi | `{$currentContext->getLocalizedData('privacyStatement')}` | Settings → Workflow → Submission → Privacy Statement |
| Tombol CTA "Akses Sistem Pengiriman Online" | `{url page="submission" op="wizard"}` | Link di template (bawaan atau override) |

## 5. Gap Analysis (🟢🟡🔴)

| Komponen | Status | Catatan |
|---|---|---|
| Halaman info submissions | 🟢 Native | Route + template + data semua native |
| Checklist persyaratan | 🟢 Native | Dari setting workflow |
| Pedoman penulis | 🟢 Native | Dari setting workflow |
| Hak cipta & privasi | 🟢 Native | Dari setting distribution/workflow |
| Link ke wizard submission | 🟢 Native | `{url page="submission" op="wizard"}` |
| Styling CTA button | 🟡 Setting | CSS override untuk styling tombol sesuai prototype |
| Card layout keseluruhan | 🟡 Setting | CSS/template override ringan |

**Halaman ini hampir sepenuhnya native (🟢).** Hanya CSS styling yang perlu disesuaikan.

### Catatan Penting — URL Wizard

Pastikan tombol CTA menggunakan Smarty URL builder:
```smarty
<a href="{url page="submission" op="wizard"}" class="...">
    Akses Sistem Pengiriman Online
</a>
```

**Jangan** hardcode URL sebagai `/index.php/jrdc/submission/wizard` — gunakan `{url}` agar kompatibel dengan konfigurasi path dan locale.

## 6. Checklist Visual QA

- [ ] Halaman info diakses via `/index.php/jrdc/about/submissions`
- [ ] Checklist persyaratan tampil lengkap (sesuai isi di Settings → Workflow)
- [ ] Pedoman penulis tampil
- [ ] Pemberitahuan hak cipta tampil (jika sudah diisi)
- [ ] Tombol CTA "Akses Sistem Pengiriman Online" tampil dengan styling yang menonjol
- [ ] Klik tombol CTA mengarah ke wizard submission (`/submission/wizard`)
- [ ] Jika belum login, CTA redirect ke halaman login terlebih dahulu
- [ ] **Wizard submission berfungsi normal** (form, step, upload, CSRF — tidak terganggu styling)
- [ ] Styling konsisten dengan prototype (card, spacing, tipografi, warna `#c2410c`)
- [ ] Responsif: tombol CTA dan konten menyesuaikan pada mobile
- [ ] Navigasi keyboard (Tab) berfungsi, tombol CTA dapat diakses via keyboard
- [ ] Breadcrumb / navigation menu OJS masih tampil benar di header
