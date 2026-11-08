# Kontak (`contact.html`)

> Dokumentasi pemetaan halaman prototype → implementasi OJS 3.3.0-24 untuk JRDC (`journal_id=1`).

## 1. Referensi Prototype

- **File prototype:** [`contact.html`](https://adptrawork.github.io/build-OJS/contact.html)
- **Repo:** `prototype-pages` branch — [lihat sumber](https://github.com/adptrawork/build-OJS/tree/prototype-pages)
- **Desain:** Tailwind + Geist, primary `#c2410c`
- **Layout:** Informasi kontak (alamat, email, telepon, jam layanan) + peta lokasi (embed/statis)

## 2. Route OJS & File Implementasi

| Aspek | Detail |
|---|---|
| **Route OJS** | `/index.php/jrdc/about/contact` |
| **Template core** | `lib/pkp/templates/frontend/pages/contact.tpl` |
| **Child theme override** | `plugins/themes/sangulineModern/templates/frontend/pages/contact.tpl` |
| **CSS** | `plugins/themes/sangulineModern/styles/index.less` atau `docs/JRDC-MODERN/jrdc-custom.css` |

## 3. Variabel / Hook Kritis

| Variabel | Keterangan |
|---|---|
| `{$mailingAddress}` | Alamat surat jurnal (Settings → Journal → Contact) |
| `{$contactName}` | Nama kontak utama |
| `{$contactTitle}` | Jabatan kontak utama |
| `{$contactAffiliation}` | Afiliasi kontak utama |
| `{$contactPhone}` | Telepon kontak utama |
| `{$contactEmail}` | Email kontak utama |
| `{$supportName}` | Nama kontak dukungan teknis |
| `{$supportPhone}` | Telepon dukungan teknis |
| `{$supportEmail}` | Email dukungan teknis |

Semua variabel diisi melalui **Settings → Journal → Contact**.

## 4. Pemetaan Konten

| Elemen Prototype | Sumber Data OJS | Cara Isi |
|---|---|---|
| Alamat kantor redaksi | `{$mailingAddress}` | Settings → Journal → Contact → Mailing Address |
| Nama & jabatan kontak | `{$contactName}`, `{$contactTitle}` | Settings → Journal → Contact → Principal Contact |
| Email kontak | `{$contactEmail}` | Settings → Journal → Contact → Principal Contact |
| Telepon kontak | `{$contactPhone}` | Settings → Journal → Contact → Principal Contact |
| Dukungan teknis | `{$supportName}`, `{$supportEmail}`, `{$supportPhone}` | Settings → Journal → Contact → Technical Support |
| Jam layanan | **Tidak ada variabel native** | HTML statis dalam template override atau Static Page |
| Peta lokasi (Google Maps) | **Tidak ada variabel native** | Iframe embed atau gambar statis |

## 5. Gap Analysis (🟢🟡🔴)

| Komponen | Status | Catatan |
|---|---|---|
| Halaman kontak dengan data utama | 🟢 Native | Route + template + variabel sudah tersedia |
| Alamat, nama, email, telepon | 🟢 Native | Dari setting jurnal |
| Dukungan teknis (nama, email, telepon) | 🟢 Native | Dari setting jurnal |
| Jam layanan (mis. "Senin–Jumat, 08.00–16.00 WIB") | 🟡 Setting | Tambahkan sebagai HTML statis di template override atau di `mailingAddress` |
| Peta lokasi (Google Maps embed) | 🟡 Setting | Iframe `<iframe src="https://maps.google.com/...">` di template override, atau gambar statis PNG |
| Styling card layout sesuai prototype | 🟡 Setting | CSS override |

### Detail Gap — Jam Layanan & Peta

**Jam layanan:** Tidak ada field native OJS untuk ini. Solusi:
1. Sisipkan di field `mailingAddress` (paling mudah, tanpa ubah template).
2. Override template `contact.tpl` di child theme dan tambahkan blok HTML statis setelah data kontak.

**Peta lokasi:**
1. **Iframe Google Maps:** Override template, sisipkan `<iframe>` embed. Gratis, interaktif.
2. **Gambar statis:** Screenshot peta, upload sebagai aset, tampilkan `<img>`. Lebih ringan.

Rekomendasi: override template `contact.tpl` di child theme untuk menambahkan jam layanan + peta di posisi yang sesuai prototype.

## 6. Checklist Visual QA

- [ ] Halaman diakses via `/index.php/jrdc/about/contact`
- [ ] Nama kontak utama, jabatan, afiliasi tampil benar
- [ ] Email kontak ditampilkan dan dapat diklik (`mailto:`)
- [ ] Telepon kontak tampil
- [ ] Alamat surat (mailing address) tampil lengkap
- [ ] Informasi dukungan teknis tampil (nama, email, telepon)
- [ ] Jam layanan tampil (jika sudah ditambahkan)
- [ ] Peta lokasi tampil (iframe interaktif atau gambar statis)
- [ ] Styling konsisten dengan prototype (card layout, spacing, warna `#c2410c`)
- [ ] Responsif: layout menyesuaikan pada mobile, peta tidak overflow
- [ ] Link email dan telepon berfungsi
- [ ] Navigasi keyboard (Tab) berfungsi pada semua elemen interaktif
