# Pengumuman (`announcements.html`)

> Dokumentasi pemetaan halaman prototype → implementasi OJS 3.3.0-24 untuk JRDC (`journal_id=1`).

## 1. Referensi Prototype

- **File prototype:** [`announcements.html`](https://adptrawork.github.io/build-OJS/announcements.html)
- **Repo:** `prototype-pages` branch — [lihat sumber](https://github.com/adptrawork/build-OJS/tree/prototype-pages)
- **Desain:** Tailwind + Geist, primary `#c2410c`
- **Layout:** List card pengumuman dengan date badge, judul, cuplikan teks, dan pagination

## 2. Route OJS & File Implementasi

| Aspek | Detail |
|---|---|
| **Route OJS** | `/index.php/jrdc/announcement` |
| **Route detail** | `/index.php/jrdc/announcement/view/{id}` |
| **Template core (list)** | `lib/pkp/templates/frontend/pages/announcements.tpl` |
| **Template core (detail)** | `lib/pkp/templates/frontend/pages/announcement.tpl` |
| **Child theme override** | `plugins/themes/sangulineModern/templates/frontend/pages/announcements.tpl` dan `announcement.tpl` |
| **CSS** | `plugins/themes/sangulineModern/styles/index.less` atau `docs/JRDC-MODERN/jrdc-custom.css` |

## 3. Variabel / Hook Kritis

| Variabel / Objek | Keterangan |
|---|---|
| `{$announcements}` | Array/iterator objek pengumuman |
| `{$announcement->getLocalizedTitle()}` | Judul pengumuman (per item dalam loop) |
| `{$announcement->getDatePosted()}` | Tanggal posting |
| `{$announcement->getLocalizedDescriptionShort()}` | Cuplikan/ringkasan singkat |
| `{$announcement->getLocalizedDescription()}` | Konten lengkap (halaman detail) |
| `{url page="announcement" op="view" path=$announcement->getId()}` | URL halaman detail |
| `{$announcementsIntroduction}` | Teks pengantar (opsional, dari setting) |

**Pengaturan terkait:**
- Settings → Website → Setup → Announcements → aktifkan fitur pengumuman.
- Buat pengumuman via Tools → Announcements.

## 4. Pemetaan Konten

| Elemen Prototype | Sumber Data OJS | Cara Isi |
|---|---|---|
| Judul pengumuman | `{$announcement->getLocalizedTitle()}` | Tools → Announcements → tambah/edit |
| Tanggal posting (date badge) | `{$announcement->getDatePosted()}` | Otomatis saat membuat pengumuman |
| Cuplikan teks | `{$announcement->getLocalizedDescriptionShort()}` | Field "Short Description" saat membuat pengumuman |
| Link "Baca selengkapnya" | `{url page="announcement" op="view" path=$announcement->getId()}` | Otomatis |
| Pagination | Bawaan template OJS | Otomatis dari jumlah item |
| Pengantar halaman | `{$announcementsIntroduction}` | Settings → Website → Setup → Announcements |

## 5. Gap Analysis (🟢🟡🔴)

| Komponen | Status | Catatan |
|---|---|---|
| Halaman daftar pengumuman | 🟢 Native | Route, template, dan data sepenuhnya native |
| Loop data pengumuman (judul, tanggal, cuplikan) | 🟢 Native | Dari database via Announcement DAO |
| Halaman detail pengumuman | 🟢 Native | Route `announcement/view/{id}` |
| Pagination | 🟢 Native | Bawaan template |
| Date badge styling | 🟡 Setting | CSS override untuk styling badge tanggal sesuai prototype |
| Card layout per item | 🟡 Setting | CSS override atau template override ringan untuk markup card |
| Teks pengantar | 🟢 Native | Setting announcements introduction |

**Halaman ini sepenuhnya dapat diimplementasi secara native (🟢).** Hanya styling (CSS) yang perlu disesuaikan agar cocok dengan desain prototype.

## 6. Checklist Visual QA

- [ ] Halaman daftar diakses via `/index.php/jrdc/announcement`
- [ ] Fitur pengumuman sudah diaktifkan (Settings → Website → Setup → Announcements)
- [ ] Minimal 1 pengumuman sudah dibuat untuk pengujian
- [ ] Judul pengumuman tampil benar
- [ ] Tanggal posting tampil sebagai badge/label sesuai prototype
- [ ] Cuplikan teks (short description) tampil
- [ ] Link ke halaman detail berfungsi
- [ ] Halaman detail menampilkan konten lengkap
- [ ] Pagination berfungsi jika ada banyak pengumuman
- [ ] Card layout konsisten dengan prototype (spacing, shadow, border, warna)
- [ ] Responsif: card stack vertikal pada mobile
- [ ] Navigasi keyboard (Tab) berfungsi pada semua link
- [ ] Breadcrumb / header navigasi OJS tetap tampil
