# Changelog

Semua perubahan penting pada theme ini dicatat di file ini.

## [2.0.0] - 2026-02-28

### Added
- Customizer child native WordPress (tanpa ketergantungan Kirki).
- Repeater native untuk `layanan_repeater`.
- Helper icon Bootstrap (`inc/icons.php`) dari `bootstrap-icons.json` parent.
- Helper media thumbnail fallback (`inc/media.php`) dengan `img/no-image.webp`.
- Asset repeater customizer (`css/customizer-repeater.css`, `js/customizer-repeater.js`).
- Default settings child lewat filter `justg_theme_default_settings`.

### Changed
- Template home (`page-home.php`) disesuaikan memakai helper/repeater baru.
- Thumbnail artikel, listing, dan widget shortcode property memakai fallback image.
- Output icon Font Awesome pada listing/property/header diganti ke Bootstrap Icons/SVG.
- Search form disesuaikan ke struktur Bootstrap 5.
- Enqueue CSS child pakai `filemtime` untuk cache busting.
- Class BS4 lama dibersihkan (`pr-md-0`, `pl-1`, `pr-1`) dan disesuaikan BS5.
- Bullet list icon font di CSS diganti marker SVG.
- Override hardcoded background body di child dihapus agar ikut parent.

### Removed
- Ketergantungan Kirki di child customizer.
- Shortcode `resize-thumbnail`.
- Pemanggilan `aq_resize`.
- Fungsi hit counter post meta `hit` di child.
