# Daftar / Register (`register.html`)

> Dokumentasi pemetaan halaman prototype → implementasi OJS 3.3.0-24 untuk JRDC (`journal_id=1`).

## 1. Referensi Prototype

- **File prototype:** [`register.html`](https://adptrawork.github.io/build-OJS/register.html)
- **Repo:** `prototype-pages` branch — [lihat sumber](https://github.com/adptrawork/build-OJS/tree/prototype-pages)
- **Desain:** Tailwind + Geist, primary `#c2410c`
- **Layout:** Card registrasi terpusat dengan form lengkap (nama, email, username, password, locale, privacy consent, role selection)

## 2. Route OJS & File Implementasi

| Aspek | Detail |
|---|---|
| **Route OJS** | `/index.php/jrdc/user/register` |
| **Template core (halaman)** | `lib/pkp/templates/frontend/pages/userRegister.tpl` |
| **Template core (form)** | `lib/pkp/templates/frontend/components/registrationForm.tpl` |
| **Child theme override** | `plugins/themes/sangulineModern/templates/frontend/pages/userRegister.tpl` |
| **CSS** | `plugins/themes/sangulineModern/styles/index.less` atau `docs/JRDC-MODERN/jrdc-custom.css` |

## 3. Variabel / Hook Kritis

> ⚠️ **KRITIS KEAMANAN:** Halaman ini berisi form registrasi pengguna. **JANGAN** memodifikasi field, action, validasi, atau CSRF token. **HANYA** styling yang diizinkan.

| Variabel / Elemen | Keterangan | ⚠️ Jangan Ubah |
|---|---|---|
| `<form>` action + method | Form POST ke handler registrasi OJS | ✅ Pertahankan |
| `name="givenName"` | Field nama depan | ✅ Pertahankan |
| `name="familyName"` | Field nama belakang | ✅ Pertahankan |
| `name="email"` | Field email | ✅ Pertahankan |
| `name="username"` | Field username | ✅ Pertahankan |
| `name="password"` | Field password | ✅ Pertahankan |
| `name="password2"` | Field konfirmasi password | ✅ Pertahankan |
| `name="country"` | Dropdown negara | ✅ Pertahankan |
| `name="affiliation"` | Field afiliasi | ✅ Pertahankan |
| Hidden CSRF token | Token keamanan dalam form | ✅ Pertahankan |
| `{$privacyStatement}` | Pernyataan privasi + consent checkbox | ✅ Pertahankan |
| Role checkboxes (Reader, Author, Reviewer) | Pilihan peran pengguna | ✅ Pertahankan |
| Validasi client-side | Atribut `required`, `pattern`, dll. | ✅ Pertahankan |
| reCAPTCHA / captcha (jika dikonfigurasi) | Proteksi spam | ✅ Pertahankan |

## 4. Pemetaan Konten

| Elemen Prototype | Sumber Data OJS | Modifikasi yang Diizinkan |
|---|---|---|
| Card wrapper registrasi | Markup `<div>` pembungkus | ✅ Tambah class CSS, ubah styling |
| Judul "Daftar" / heading | `<h1>` atau heading template | ✅ Ubah teks/heading level, styling |
| Semua input field | `<input>`, `<select>`, `<textarea>` native | ✅ Styling only (class, placeholder) |
| Checkbox privacy consent | `{$privacyStatement}` + checkbox | ✅ Styling only |
| Checkbox roles | Reader/Author/Reviewer checkboxes | ✅ Styling only |
| Tombol "Daftar" | `<button type="submit">` | ✅ Styling only (class, teks label) |
| Link "Sudah punya akun? Masuk" | `{url page="login"}` | ✅ Styling only |
| Pesan error validasi | Error messages dari server | ✅ Styling only |

## 5. Gap Analysis (🟢🟡🔴)

| Komponen | Status | Catatan |
|---|---|---|
| Form registrasi lengkap | 🟢 Native | Semua field native OJS |
| CSRF token | 🟢 Native | Otomatis dari OJS |
| Validasi server-side | 🟢 Native | Bawaan OJS, jangan ubah |
| Privacy consent | 🟢 Native | Dari setting privasi |
| Role selection | 🟢 Native | Dari konfigurasi journal |
| reCAPTCHA (jika aktif) | 🟢 Native | Dari konfigurasi site |
| Email verifikasi | 🟢 Native | Dari konfigurasi site |
| Card wrapper styling | 🟡 Setting | CSS override |
| Input field styling | 🟡 Setting | CSS override |
| Button styling | 🟡 Setting | CSS override |
| Form layout (grid/flex) | 🟡 Setting | CSS override atau template override ringan |

**Halaman ini sepenuhnya native (🟢).** Gap hanya di styling (🟡).

## 6. Checklist Visual QA

- [ ] Halaman diakses via `/index.php/jrdc/user/register`
- [ ] Form registrasi tampil terpusat dalam card
- [ ] Semua field wajib tampil: nama depan, nama belakang, email, username, password, konfirmasi password
- [ ] Field opsional tampil: afiliasi, negara
- [ ] Dropdown negara terisi dengan daftar negara
- [ ] Checkbox privacy consent tampil (jika privacy statement diisi)
- [ ] Checkbox role selection tampil (Reader, Author, Reviewer — tergantung konfigurasi)
- [ ] Tombol "Daftar" tampil dengan styling yang menonjol (warna `#c2410c`)
- [ ] **Registrasi berfungsi:** isi form → submit → akun terbuat / email verifikasi terkirim
- [ ] **Validasi berfungsi:** submit form kosong → pesan error tampil per field
- [ ] **CSRF token ada** dalam form (inspect HTML: cari hidden input)
- [ ] Link "Sudah punya akun? Masuk" mengarah ke `/login`
- [ ] reCAPTCHA tampil jika dikonfigurasi
- [ ] Focus state terlihat pada semua input dan tombol
- [ ] Tab order logis: nama → email → username → password → confirm → consent → roles → submit
- [ ] Responsif: form menyesuaikan pada mobile, tidak ada overflow
- [ ] Styling konsisten dengan prototype (card, shadow, tipografi, spacing)
- [ ] **Tidak ada perubahan pada fungsionalitas form** — hanya styling wrapper
