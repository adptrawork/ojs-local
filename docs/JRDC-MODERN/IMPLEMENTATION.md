# JRDC Modern — Panduan Implementasi (OJS 3.3.0-24)

Dokumen ini menjelaskan deliverable modernisasi tampilan JRDC (journal `jrdc`, `journal_id=1`) pada **OJS 3.3.0-24**, beserta langkah aktivasi, verifikasi, rollback, dan troubleshooting.

> **Penting (kompatibilitas 3.3):** Semua komponen di sini ditujukan untuk **OJS 3.3.x**. **Jangan** memakai tema/override yang dibuat untuk **OJS 3.4+**, dan **jangan** menggunakan namespace gaya `APP\...`/pola plugin 3.4 pada kode 3.3 kecuali benar-benar sesuai struktur 3.3. Tema inti (`plugins/themes/default`, `bootstrap3`, dll.) dan **Sanguline inti** (`plugins/themes/sanguline`) **tidak boleh dimodifikasi**.

## 1. Ringkasan Deliverable

| Deliverable | Lokasi | Fungsi |
|---|---|---|
| Journal Stylesheet kustom | `docs/JRDC-MODERN/jrdc-custom.css` | Override CSS konservatif & aksesibel yang **diunggah** melalui UI OJS (Appearance → Advanced). Cocok sebagai *quick win* tanpa mengganti tema. |
| Child theme Sanguline Modern | `plugins/themes/sangulineModern/` | Tema anak 3.3-compatible yang mewarisi Sanguline (`setParent('sanguline')`). Menambah penyempurnaan ringan (spacing/fokus/reduced motion) dan opsi `modernAccent`. |

**Tema aktif saat ini (DB, journal 1):** `themePluginPath = sanguline`. **Tidak diubah** oleh proses ini — pemilihan tema dilakukan melalui UI.

**Status DB (diperiksa, idempoten, konservatif):**
- `plugin_settings` (context 1, `sangulinethemeplugin`): `showDescriptionInJournalIndex = true` (sudah benar), `displayStats = bar` (konsisten), `enabled = 1`. **Tidak ada perubahan** karena nilai sudah masuk akal.
- `journal_settings`: `themePluginPath = sanguline`, tidak ada `styleSheet` (unggah stylesheet dilakukan via UI). **Tidak ada perubahan**.

## 2. Opsi A — Aktivasi Journal Stylesheet (Quick Win)

Gunakan ini jika ingin perbaikan tampilan cepat **tanpa** mengganti tema.

### Langkah
1. Masuk sebagai **Journal Manager / Site Admin**.
2. Buka **Settings → Website → Appearance → Advanced** (atau *Tampilan Situs → Lanjutan*).
3. Pada bagian **Journal style sheet** / *Stylesheet Jurnal*, unggah file:
   - `D:\Projects\ojs-3.3.0-24\docs\JRDC-MODERN\jrdc-custom.css`
4. Simpan.
5. **Bersihkan cache** (lihat bagian Cache di bawah), lalu muat ulang situs publik dengan *hard refresh* (Ctrl+F5).

### Uji cepat
- Beranda jurnal, halaman issue/arsip, halaman artikel + galley PDF, pencarian, menu About/People, halaman statis, login/register.
- Cek mobile (lebar sempit) dan navigasi keyboard (Tab, fokus terlihat).
- Jika tampilan tidak berubah: pastikan file terunggah, cache dibersihkan, dan tidak ada CSS tema/stylesheet lain yang menimpa secara spesifik.

### Rollback (Stylesheet)
- Hapus/reset unggahan **Journal style sheet** di Appearance → Advanced, simpan, lalu bersihkan cache.

## 3. Opsi B — Aktivasi Child Theme `sangulineModern`

Gunakan ini untuk perubahan tema terstruktur yang tetap mewarisi Sanguline.

### Prasyarat
- Plugin Sanguline inti tersedia di `plugins/themes/sanguline` (jangan dimodifikasi).
- Folder child theme ada: `plugins/themes/sangulineModern/` (berisi `index.php`, `SangulineModernThemePlugin.inc.php`, `version.xml`, `settings.xml`, `styles/index.less`).

### Langkah aktivasi
1. Masuk sebagai **Site Admin / Journal Manager** (akses Plugins sesuai peran).
2. Buka **Website → Plugins → Theme Plugins** (atau *Plugin Tema*).
3. Temukan **Sanguline Modern Theme** → **Enable** / aktifkan.
4. Buka **Settings → Website → Appearance → Theme**.
5. Pilih **Sanguline Modern Theme**, simpan.
6. (Opsional) Atur opsi tema (mis. *modern accent color*) jika tersedia, simpan.
7. **Bersihkan cache** + *hard refresh*.

### Catatan
- Journal Stylesheet (Opsi A) tetap bisa digunakan bersama tema, tetapi uji bentrok gaya setelah mengaktifkan keduanya.
- Child theme **bergantung** pada parent `sanguline`. Jika parent bermasalah/dinonaktifkan, perilaku bisa terganggu.

### Rollback (Child Theme)
1. Kembali ke **Settings → Website → Appearance → Theme** → pilih **Sanguline** (parent), simpan.
2. (Opsional) Nonaktifkan **Sanguline Modern Theme** di Plugins → Theme Plugins.
3. Bersihkan cache + *hard refresh*.

## 4. Bersihkan Cache (Windows/Laragon)

Lakukan setelah ganti tema, unggah stylesheet, atau ubah pengaturan tampilan:

- **Via UI (disarankan bila tersedia):** Administration → **Clear Data Caches** dan **Clear Template Cache** (serta *Clear Scheduled Task Execution Logs* jika perlu; tidak wajib untuk tampilan).
- **Via filesystem (aman untuk cache kompilasi):** hapus isi folder (bukan foldernya) bila diperlukan:
  - `D:\Projects\ojs-3.3.0-24\cache\t_compile\*`
  - `D:\Projects\ojs-3.3.0-24\cache\t_cache\*`
- **Isu Windows/Smarty:** jika muncul error tulis template/cache (race), ulangi aksi, bersihkan cache, dan cek log.

> Setelah clear cache, gunakan *hard refresh* browser. Jika memakai OPcache/FastCGI, restart PHP/Laragon bila perubahan file tidak terbaca.

## 5. Checklist Verifikasi

Jalankan pada konteks JRDC (`/jrdc`) setelah aktivasi + clear cache:

- [ ] **Beranda** jurnal: header/logo, deskripsi jurnal, navigasi, blok samping.
- [ ] **Current Issue / Arsip Issue**: daftar issue, TOC, metadata.
- [ ] **Halaman artikel + galley PDF**: judul, abstrak, author, tombol galley/PDF terbuka benar.
- [ ] **Pencarian**: hasil tampil dan tautan berfungsi.
- [ ] **Menu About / Editorial Team (People)**: konten statis/halaman kustom tampil.
- [ ] **Halaman statis** lain (kebijakan, panduan, dll.).
- [ ] **Login / Register**: form tampil, fokus keyboard terlihat, tidak ada elemen tertutup.
- [ ] **Mobile/responsif**: tanpa overflow horizontal parah, menu dapat dipakai.
- [ ] **Aksesibilitas dasar**: navigasi Tab, fokus terlihat, tautan/ikon bermakna, kontras teks wajar.
- [ ] **Log PHP**: periksa `D:\laragon\tmp\php_errors.log` untuk error baru (fatal/warning berulang) saat memuat halaman di atas.

## 6. Troubleshooting Singkat

| Gejala | Kemungkinan | Tindakan |
|---|---|---|
| Tampilan tidak berubah | Cache belum bersih / stylesheet tidak terunggah / tema belum aktif | Clear data+template cache, hapus `cache/t_compile/*` & `t_cache/*`, hard refresh, pastikan tema/stylesheet tersimpan. |
| Halaman putih / error 500 | Error PHP/Smarty/plugin | Cek `D:\laragon\tmp\php_errors.log`; rollback ke tema **Sanguline**; nonaktifkan child theme; clear cache. |
| Galley/PDF bermasalah | Bukan masalah CSS; konfigurasi galley/file | Uji dengan stylesheet nonaktif; periksa galley di issue/artikel; cek log. |
| Menu/blok hilang | Perbedaan area menu/setting tema | Cek Navigation Menus/Sidebar di Appearance; bandingkan dengan Sanguline; rollback bila perlu. |
| Race write Smarty (Windows) | Penulisan cache bersamaan | Ulangi request, clear cache, pastikan `cache/` writable; patch race (jika ada) tetap dipertahankan. |
| Konflik gaya | Stylesheet + child theme saling menimpa | Uji satu per satu (nonaktifkan stylesheet atau kembali ke Sanguline) untuk isolasi. |

## 7. Lingkungan Teknis (referensi)

- OJS **3.3.0-24**, path `D:\Projects\ojs-3.3.0-24`, JRDC `journal_id=1`.
- Tema inti aktif sebelumnya: `sanguline`.
- PHP CLI OJS (Laragon): `D:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe` (gunakan bila perlu tool CLI OJS; bukan untuk aktivasi tema/stylesheet UI).
- DB: MySQL `root` tanpa password, database `ojs-3.3.0-24`.
- Log PHP: `D:\laragon\tmp\php_errors.log`.

## 8. Batasan & Keamanan Perubahan

- **Tidak** mengubah tema inti/Sanguline.
- **Tidak** mengubah `themePluginPath` / konten kustom pengguna secara otomatis.
- Perubahan DB (jika dilakukan) harus **konservatif, idempoten**, dan dicatat. Pada pemeriksaan saat ini: **tidak ada perubahan DB**.
- Aktivasi tema dan unggah stylesheet **wajib melalui UI OJS** (audit trail/validasi OJS).
