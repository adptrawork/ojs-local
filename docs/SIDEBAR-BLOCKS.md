# Blok Sidebar ala JEKI — HTML siap tempel

Cara membuat tiap blok:

1. **Settings → Website → Plugins** → cari **Custom Block Manager** → klik **Add Block**
2. Isi **Title** sesuai judul di bawah, centang **Show block title**
3. Di editor konten, klik tombol **source / `<>`** (tampilan HTML), lalu tempel kode HTML-nya
4. **Save**
5. Setelah semua blok dibuat: **Settings → Website → Appearance → Setup → Sidebar** → tambahkan blok dan atur urutannya

Semua tautan memakai `/index.php/jrdc/...` supaya tidak 404.
Ganti placeholder bertanda `[...]` (email, ISSN, alamat, ID Scholar, dsb) dengan data asli.

Urutan sidebar yang disarankan (mengikuti JEKI):
SINTA 2 → Journal Information → Information for Author → AI Usage Policy → Information for Reviewer → Template → Journal Profile → Tools → Citations Analysis → In Collaboration With → Web Statistics → Google Scholar Citation → ISSN

---

## 1. SINTA 2

```html
<div style="border:2px solid #b30000;border-radius:6px;padding:10px;text-align:center">
  <div style="color:#b30000;font-size:22px;font-weight:bold;line-height:1.1">SINTA 2</div>
  <div style="font-size:12px;margin-top:4px">
    <a href="https://sinta.kemdikbud.go.id/journals" target="_blank" rel="noopener">Lihat profil di SINTA</a>
  </div>
</div>
```

Catatan: ganti tautan dengan URL profil jurnal Anda di SINTA setelah terakreditasi.

---

## 2. Information for Author

```html
<ul>
  <li><a href="/index.php/jrdc/author-guidelines">Author Guidelines</a></li>
  <li><a href="/index.php/jrdc/focus-and-scope">Focus and Scope</a></li>
  <li><a href="/index.php/jrdc/article-processing-charges">Article Processing Charge</a></li>
  <li><a href="/index.php/jrdc/copyright-and-license">Copyright and License</a></li>
  <li><a href="/index.php/jrdc/user/register">Register as Author</a></li>
</ul>
```

---

## 3. AI Usage Policy

```html
<p>
  Penulis wajib mengungkapkan penggunaan alat kecerdasan artifisial (AI) generatif
  dalam proses penulisan. AI tidak dapat dicantumkan sebagai penulis, dan penulis
  tetap bertanggung jawab penuh atas isi naskah, termasuk ketepatan referensi.
</p>
<p><a href="/index.php/jrdc/publication-ethics">Baca selengkapnya: Publication Ethics</a></p>
```

---

## 4. Information for Reviewer

```html
<ul>
  <li><a href="/index.php/jrdc/reviewer-board">Reviewer Board</a></li>
  <li><a href="/index.php/jrdc/publication-ethics">Publication Ethics</a></li>
  <li><a href="/index.php/jrdc/plagiarism-policy">Plagiarism Policy</a></li>
  <li><a href="/index.php/jrdc/retraction-and-withdrawal">Retraction and Withdrawal</a></li>
  <li><a href="/index.php/jrdc/copyright-and-license">Copyright and License</a></li>
</ul>
```

---

## 5. Template

```html
<p style="text-align:center">
  <a href="[URL_FILE_TEMPLATE_DOCX]" target="_blank" rel="noopener"
     style="display:inline-block;padding:8px 14px;background:#1a5276;color:#fff;border-radius:4px;text-decoration:none">
    Download Article Template (.docx)
  </a>
</p>
<p style="font-size:12px;text-align:center">
  Naskah wajib mengikuti format template ini.
</p>
```

Pilihan tempat menyimpan file template:
- paling cepat: unggah ke Google Drive dan pakai link share-nya, atau
- taruh file di folder `D:\Projects\ojs-3.3.0-24\public\journals\1\` lalu pakai URL
  `http://ojs-3.3.0-24.test/public/journals/1/template.docx`

---

## 6. Journal Profile

```html
<ul style="list-style:none;padding:0;margin:0">
  <li><strong>Journal Name:</strong> Jurnal Ratu Dirgantara Cendikiawan</li>
  <li><strong>Abbreviation:</strong> JRDC</li>
  <li><strong>Print ISSN:</strong> [XXXX-XXXX]</li>
  <li><strong>Online ISSN:</strong> [XXXX-XXXX]</li>
  <li><strong>Publisher:</strong> [Nama Penerbit]</li>
  <li><strong>Address:</strong> [Alamat lengkap]</li>
  <li><strong>Email:</strong> <a href="mailto:[email@domain.ac.id]">[email@domain.ac.id]</a></li>
  <li><strong>Publication Frequency:</strong> [2 kali setahun]</li>
</ul>
```

---

## 7. Tools

```html
<ul>
  <li><a href="https://www.grammarly.com" target="_blank" rel="noopener">Grammarly</a></li>
  <li><a href="https://www.turnitin.com" target="_blank" rel="noopener">Turnitin</a></li>
  <li><a href="https://www.mendeley.com" target="_blank" rel="noopener">Mendeley</a></li>
  <li><a href="https://www.zotero.org" target="_blank" rel="noopener">Zotero</a></li>
  <li><a href="https://www.doi.org" target="_blank" rel="noopener">DOI / Crossref</a></li>
</ul>
```

---

## 8. Citations Analysis

```html
<ul>
  <li><a href="https://scholar.google.com" target="_blank" rel="noopener">Google Scholar</a></li>
  <li><a href="https://www.scopus.com" target="_blank" rel="noopener">Scopus</a></li>
  <li><a href="https://app.dimensions.ai" target="_blank" rel="noopener">Dimensions</a></li>
  <li><a href="https://garuda.kemdikbud.go.id" target="_blank" rel="noopener">Garuda</a></li>
  <li><a href="https://search.crossref.org" target="_blank" rel="noopener">Crossref</a></li>
</ul>
```

---

## 9. In Collaboration With

```html
<p style="text-align:center;font-size:13px">
  [Nama Mitra 1] &middot; [Nama Mitra 2] &middot; [Nama Mitra 3]
</p>
<p style="text-align:center;font-size:12px">
  <a href="/index.php/jrdc/about/contact">Hubungi kami untuk kerja sama</a>
</p>
```

Kalau mau pakai logo: taruh file gambar di
`D:\Projects\ojs-3.3.0-24\public\journals\1\`, lalu ganti isi blok dengan:

```html
<p style="text-align:center">
  <img src="/public/journals/1/mitra1.png" alt="Mitra 1" style="max-width:100%;height:auto">
  <img src="/public/journals/1/mitra2.png" alt="Mitra 2" style="max-width:100%;height:auto">
</p>
```

---

## 10. Web Statistics

OJS tidak punya penghitung pengunjung bawaan. Daftar gratis di
[histats.com](https://www.histats.com), ambil kode counter, lalu tempel di blok ini:

```html
<!-- Tempel kode counter dari Histats di baris ini -->
<div style="text-align:center;min-height:40px">
  <small>Visitor counter</small>
</div>
```

Kalau kode `<script>` tidak tersimpan (editor OJS kadang membuang script), pakai varian
`<img>` / `<a>` yang disediakan Histats.

---

## 11. Google Scholar Citation

```html
<p style="text-align:center">
  <a href="[URL_PROFIL_GOOGLE_SCHOLAR_JURNAL]" target="_blank" rel="noopener">
    Google Scholar Profile
  </a>
</p>
<p style="text-align:center;font-size:12px">
  Citations: <strong>[0]</strong> &middot; h-index: <strong>[0]</strong>
</p>
```

Angka sitasi diisi manual, atau pakai badge dari
[scholar.google.com/citations](https://scholar.google.com/citations?view_op=search_venues)
setelah jurnal punya profil.

---

## 12. ISSN

```html
<div style="text-align:center">
  <div style="font-size:11px;letter-spacing:1px;text-transform:uppercase">ISSN</div>
  <div style="font-size:20px;font-weight:bold;letter-spacing:1px">[XXXX-XXXX]</div>
  <div style="font-size:12px;margin-top:4px">
    <a href="https://issn.brin.go.id" target="_blank" rel="noopener">Terbitkan di portal ISSN</a>
  </div>
</div>
```

---

## Setelah semua blok dibuat

1. **Settings → Website → Appearance → Setup → Sidebar**
2. Tambahkan semua blok baru, lalu urutkan sesuai daftar di atas
3. **Save**
4. Buka homepage, refresh, cek semua tautan tidak ada yang 404
