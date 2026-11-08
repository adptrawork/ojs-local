# Masuk / Login (`login.html`)

> Dokumentasi pemetaan halaman prototype → implementasi OJS 3.3.0-24 untuk JRDC (`journal_id=1`).

## 1. Referensi Prototype

- **File prototype:** [`login.html`](https://adptrawork.github.io/build-OJS/login.html)
- **Repo:** `prototype-pages` branch — [lihat sumber](https://github.com/adptrawork/build-OJS/tree/prototype-pages)
- **Desain:** Tailwind + Geist, primary `#c2410c`
- **Layout:** Card login terpusat dengan form username/password, link "Lupa Password", link "Daftar"

## 2. Route OJS & File Implementasi

| Aspek | Detail |
|---|---|
| **Route OJS** | `/index.php/jrdc/login` |
| **Route lupa password** | `/index.php/jrdc/login/lostPassword` |
| **Template core** | `lib/pkp/templates/frontend/pages/userLogin.tpl` |
| **Child theme override** | `plugins/themes/sangulineModern/templates/frontend/pages/userLogin.tpl` |
| **CSS** | `plugins/themes/sangulineModern/styles/index.less` atau `docs/JRDC-MODERN/jrdc-custom.css` |

## 3. Variabel / Hook Kritis

> ⚠️ **KRITIS KEAMANAN:** Halaman ini berisi form autentikasi. **HANYA** modifikasi styling wrapper/card. **Pertahankan semua** elemen form berikut tanpa perubahan.

| Variabel / Elemen | Keterangan | ⚠️ Jangan Ubah |
|---|---|---|
| `<form>` action + method | Form POST ke handler login OJS | ✅ Pertahankan |
| `name="username"` field | Field input username | ✅ Pertahankan name, type |
| `name="password"` field | Field input password | ✅ Pertahankan name, type |
| `{$loginMessage}` | Pesan error/info login (mis. "Invalid credentials") | ✅ Pertahankan |
| `{$username}` | Prefill username (setelah gagal login) | ✅ Pertahankan |
| Hidden CSRF token | Token keamanan dalam form | ✅ Pertahankan |
| `{block name=loginFields}` | Block Smarty untuk field login tambahan (plugin SSO, dll.) | ✅ Pertahankan |
| `{url page="login" op="lostPassword"}` | Link lupa password | ✅ Pertahankan |
| `{url page="user" op="register"}` | Link daftar akun baru | ✅ Pertahankan |
| `name="remember"` checkbox | Opsi "Ingat saya" | ✅ Pertahankan (jika ada) |
| `{$source}` hidden field | Redirect setelah login | ✅ Pertahankan |

## 4. Pemetaan Konten

| Elemen Prototype | Sumber Data OJS | Modifikasi yang Diizinkan |
|---|---|---|
| Card wrapper login | Markup `<div>` pembungkus | ✅ Tambah class CSS, ubah styling |
| Judul "Masuk" / heading | `<h1>` atau heading template | ✅ Ubah teks/heading level, styling |
| Input username | `<input name="username">` | ✅ Styling only (class, placeholder text) |
| Input password | `<input name="password">` | ✅ Styling only (class, placeholder text) |
| Tombol "Masuk" | `<button type="submit">` | ✅ Styling only (class, teks label) |
| Link "Lupa Password?" | `{url page="login" op="lostPassword"}` | ✅ Styling only |
| Link "Daftar" | `{url page="user" op="register"}` | ✅ Styling only |
| Pesan error | `{$loginMessage}` | ✅ Styling only |

## 5. Gap Analysis (🟢🟡🔴)

| Komponen | Status | Catatan |
|---|---|---|
| Form login (username/password) | 🟢 Native | Sepenuhnya native, jangan ubah fungsionalitas |
| CSRF token | 🟢 Native | Otomatis dari OJS |
| Pesan error login | 🟢 Native | `{$loginMessage}` |
| Link lupa password | 🟢 Native | `{url page="login" op="lostPassword"}` |
| Link daftar | 🟢 Native | `{url page="user" op="register"}` |
| Card wrapper styling | 🟡 Setting | CSS override untuk card center, shadow, border-radius |
| Input field styling | 🟡 Setting | CSS override untuk border, focus state, padding |
| Button styling | 🟡 Setting | CSS override untuk warna `#c2410c`, hover, focus |

**Halaman ini sepenuhnya native (🟢).** Gap hanya di styling (🟡).

## 6. Checklist Visual QA

- [ ] Halaman diakses via `/index.php/jrdc/login`
- [ ] Form login tampil terpusat dalam card
- [ ] Input username tampil dan dapat diisi
- [ ] Input password tampil dan dapat diisi
- [ ] Tombol "Masuk" tampil dengan styling yang menonjol (warna `#c2410c`)
- [ ] **Login berfungsi:** username + password valid → redirect ke dashboard
- [ ] **Login gagal:** pesan error tampil jelas (`{$loginMessage}`)
- [ ] Link "Lupa Password?" tampil dan mengarah ke `/login/lostPassword`
- [ ] Link "Daftar" tampil dan mengarah ke `/user/register`
- [ ] **CSRF token ada** dalam form (inspect HTML: cari hidden input)
- [ ] Focus state terlihat pada input dan tombol (navigasi keyboard)
- [ ] Tab order benar: username → password → remember (jika ada) → submit → link
- [ ] Responsif: card menyesuaikan pada mobile
- [ ] Styling konsisten dengan prototype (card, shadow, tipografi, spacing)
- [ ] **Tidak ada perubahan pada fungsionalitas form** — hanya styling wrapper
