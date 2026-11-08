# Token Desain — JRDC Modern

Diambil dari prototype DESIGN.md dan halaman live, **bukan** dari `styles.css`
yang sudah berbeda versi.

---

## 1. Warna

| Token | Hex | Pakai |
|-------|-----|-------|
| `primary` | `#c2410c` | CTA, link aktif, badge, accent |
| `primary-hover` | `#9a3412` | Hover state tombol/link |
| `navy-hero` | `#0b2038` | Hero background, heading besar |
| `navy-dark` | `#071424` | Footer, overlay gelap |
| `background-light` | `#f8fafc` | Body background (light mode) |
| `background-dark` | `#090d16` | Body background (dark mode, fase 2) |
| `slate-50` | `#f8fafc` | Card background |
| `slate-100` | `#f1f5f9` | Hover state ringan |
| `slate-200` | `#e2e8f0` | Border card, divider |
| `slate-400` | `#94a3b8` | Teks sekunder |
| `slate-600` | `#475569` | Teks body |
| `slate-700` | `#334155` | Heading kecil |
| `slate-800` | `#1e293b` | Heading utama |
| `slate-900` | `#0f172a` | Teks terkuat |
| `slate-950` | `#020617` | Footer bg |

Terjemahan ke LESS (`styles/modern.less`):

```less
// Token warna prototype JRDC Modern
@primary:           #c2410c;
@primary-hover:     #9a3412;
@navy-hero:         #0b2038;
@navy-dark:         #071424;
@bg-light:          #f8fafc;
@slate-200:         #e2e8f0;
@slate-600:         #475569;
@slate-800:         #1e293b;
@slate-950:         #020617;
```

## 2. Font

| Peran | Font | Fallback | Pakai |
|-------|------|----------|-------|
| Sans utama | Geist | `system-ui, -apple-system, sans-serif` | Body, nav, label, tombol |
| Serif aksesori | Merriweather | `Georgia, serif` | Abstrak, kutipan, judul artikel opsional |
| Display | Cinzel | `serif` | Hero heading, brand |
| Ikon | Material Symbols Outlined | — | Ikon navigasi, fitur |

Loading via Google Fonts di `headerHead.tpl` override atau `addStyle()` di plugin:

```smarty
{* di headerHead.tpl — sebelum </head> *}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Geist:wght@400;500;600;700&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
```

Alternatif via PHP plugin (`init()`):

```php
$this->addStyle('googleFonts',
    'https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Geist:wght@400;500;600;700&family=Merriweather:wght@400;700&display=swap',
    ['baseUrl' => '']
);
```

## 3. Layout

| Token | Nilai | Keterangan |
|-------|-------|-----------|
| Max-width konten | `1280px` (`max-w-7xl`) | Container utama |
| Grid | 12 kolom | Main 8 + sidebar 4 |
| Border radius | `16px` (`rounded-2xl`) | Card, panel |
| Shadow | `shadow-sm` (~`0 1px 2px rgba(0,0,0,.05)`) | Card |
| Border | `1px solid @slate-200` | Separator card |
| Spacing base | `4px` unit (Tailwind scale) | `p-4` = 16px, `p-6` = 24px |

Terjemahan LESS:

```less
@max-content:    1280px;
@radius-card:    16px;
@border-card:    1px solid @slate-200;
@shadow-card:    0 1px 2px rgba(0, 0, 0, 0.05);
```

## 4. Strategi Aset

| Opsi | Deskripsi | Pro | Kontra |
|------|-----------|-----|--------|
| **A — LESS (rekomendasi)** | Terjemahkan token ke variabel LESS di `modern.less`, OJS compile otomatis | Stabil, terintegrasi build OJS, mudah override parent | Perlu terjemahan manual Tailwind → LESS |
| B — Tailwind build statis | Compile Tailwind → `modern.css`, load sebagai stylesheet tambahan | Fidelity tinggi ke prototype | File CSS besar, tidak ikut build OJS, duplikasi rule |

**Rekomendasi: Opsi A.** Pakai LESS variable + mixin, biarkan OJS compile.
Tailwind hanya sebagai referensi visual, bukan sebagai deliverable.

## 5. Dark Mode

**Keputusan: tunda — implementasi sebagai fase terpisah.**

- Scope: toggle `<html class="dark">`, variabel warna alternatif, `prefers-color-scheme`.
- Alasan tunda: prototype dark mode belum final, interaksi dgn parent theme Sanguline belum diuji.
- Saat implementasi: tambah `@media (prefers-color-scheme: dark)` di LESS + JS toggle tema.

## 6. Aksesibilitas

| Aturan | Target |
|--------|--------|
| Kontras teks/latar | ≥ 4.5:1 (WCAG AA) |
| Focus indicator | `outline: 2px solid @primary; outline-offset: 2px` (`focus-visible`) |
| Target sentuh | Minimum `44×44px` |
| Animasi | Hormati `prefers-reduced-motion: reduce` |
| Skip links | Pertahankan `{include file="frontend/components/skipLinks.tpl"}` |

Contoh LESS:

```less
*:focus-visible {
    outline: 2px solid @primary;
    outline-offset: 2px;
}

@media (prefers-reduced-motion: reduce) {
    *, *::before, *::after {
        animation-duration: 0.01ms !important;
        transition-duration: 0.01ms !important;
    }
}
```
