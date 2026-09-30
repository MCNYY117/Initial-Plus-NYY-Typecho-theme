# Initial Plus NYY — a Typecho theme

**A maintained continuation of the Initial Plus theme for Typecho, brought up to Typecho 1.3.0.**

Initial Plus had not been updated since 2021–2022 and could not run correctly on Typecho 1.3.0. This fork fixes what broke and adds a few things that were missing. It is a **derivative work**, not an original theme — see [Credits and licensing](#credits-and-licensing) before you redistribute it.

**English** · [中文](README.zh-CN.md)

---

## Lineage

```
jielive/initial   →   Initial Plus (阵雨兄, blog.alttt.com)   →   this repo
   (2023, stopped)        (2021–2022, stopped)                      (maintained)
```

Upstream attribution is kept in the source file headers (`@author 阵雨兄`, `@link http://blog.alttt.com/`).

> **On the use of AI:** the fixes in this fork were written by DeepSeek and reviewed by hand. If that is not something you want in a theme, this is your warning.

---

## Environment

| | |
|---|---|
| Typecho | 1.3.0 |
| PHP | 8.4.23 |
| Node.js | 24.18.0 — development only; **the theme has no build step** |
| Web server | Nginx 1.30.4 |
| Database | MySQL 8.0.45 |

There is no `composer.json` or `package.json`: every front-end library is vendored under `initial_plus/jscss/`.

---

## Install

1. Upload the whole `initial_plus` directory to Typecho's `usr/themes/`.
   **Keep the directory named `initial_plus`** — a few paths inside `functions.php` are hardcoded to `/usr/themes/initial_plus/lib/…` and will break if you rename it.
2. In the admin, go to **Console → Appearance** and activate *Initial Plus NYY*.
3. Open the theme options and turn on what you want (weather, background music, dynamic background).
   **The weather features need outbound network access** — they call `wttr.in` for the forecast and `myip.ipip.net` for IP geolocation.
4. The two plugins in `plugins/` can be uploaded separately to `usr/plugins/`.
   **`PartiallyPassword` (per-post encryption) is effectively bundled**: the theme's `[password]` shortcode depends on it.

---

## Layout

```
initial_plus/              the theme itself — upload to usr/themes/
├── index.php              home / post list
├── archive.php            category, tag, date and search archives
├── post.php               single post
├── page.php               404.php  comments.php
├── page-archives.php      custom template: archives
├── page-links.php         custom template: links
├── page-whisper.php       custom template: whispers
├── category/photos.php    category template: photos (masonry gallery)
├── header.php  footer.php  sidebar.php
├── page-parts/            partials (post meta, etc.)
├── functions.php          theme options and all theme logic
├── shortcode.php          shortcode engine
├── qrcode.php             QR endpoints (including donation codes)
├── lib/                   bundled PHP libraries and data files
├── jscss/                 front-end assets (jQuery, Bootstrap, Fancybox, Prism, icon fonts — all vendored)
└── img/                   images
plugins/
├── PartiallyPassword/     per-post encryption (by wuxianucw) — required by the theme
└── Sticky/                sticky posts (by willin kan)
```

---

## What this fork changed

1. **Fixed the appearance-settings select boxes**, which silently failed to save.
2. **Added Cravatar** as an avatar source. The other three sources are dead upstream; Cravatar is the one that works.
3. **Background music plays on any click.** For cross-page playback, enable *Ajax paging* and *site-wide Pjax*.
4. **Weather in the navbar.**
5. **Dynamic weather background.**
6. **Weather and background are linked** — the background rotates every 5 minutes. The toggle lives with the background-music settings.
7. **Fixed the volume control**, now a 0–100 range.
8. **Fixed the encryption plugin**, including the way it was breaking Markdown in the post body.
9. **Reworked the appearance settings page**: added a section nav and a floating save button.
10. **Updated the ICP filing link** to `https://beian.miit.gov.cn`.
11. **Fixed how the admin editor page is reached** — served locally instead of over HTTPS, which errors in some setups.
12. **Added a field for the public-security filing number** (公安备案).

The encryption plugin cannot be used standalone; if you want it on its own, [get it here](https://ucw.moe/archives/typecho-partially-password.html).
For everything the original theme does, [read the upstream description](https://github.com/jielive/initial).

---

## Features

- Two skins (white / dark) with a cookie-remembered toggle
- Rounded styling, plus a custom-CSS field
- Sticky posts, breadcrumbs
- Section navigation and a floating save button in the theme options
- Pjax and Ajax "load more"
- Fancybox lightbox, lazy-loaded images, Prism syntax highlighting
- Four avatar sources (only Cravatar still works)
- Sidebar widgets: visitor stats, site stats, whispers
- Standalone page templates: archives, links, whispers
- Social links (QQ, WeChat, Weibo, GitHub, Gitee, CSDN, Zhihu, Bilibili, Steam, …)
- WeChat and Alipay donation QR codes
- Background music player
- Live navbar weather and a weather-linked dynamic background
- Click-to-pop text effect
- ICP and public-security filing numbers in the footer
- A shortcode set: buttons, panels, toggles, highlighted blocks, QR codes, WeChat

---

## Known issues

- **Version numbers disagree**: `index.php` says `3.7.4`, `functions.php` defines `INITIAL_VERSION_NUMBER = '3.7.5'`.
- **The theme directory cannot be renamed** — see the install note above.
- **`error_reporting(0)`** at the top of `functions.php` suppresses PHP errors site-wide. Comment it out while debugging.
- Four `.bak` files were committed early on; one of them (`Plugin.php.bak.20260729`) is byte-identical to the live file.

---

## Credits and licensing

The [MIT LICENSE](LICENSE) in this repository covers **NYY's modifications on top of Initial Plus**.

**About the upstream licence — please read before redistributing.** This theme is a second-generation derivative:

```
jielive/initial → Initial Plus (阵雨兄) → this repository
```

Upstream authorship is preserved in the source headers and in the README above, **but the upstream theme's own licence file is not included in this repository, and its terms are unknown.** If you are an upstream author and object to this, or if you intend to redistribute this theme, establish the upstream licence first.

Several third-party components are also vendored here (phpqrcode, Fancybox, Bootstrap, jQuery, Prism and others). Their authors and licences are listed in [NOTICE](NOTICE).

---

## Links

- Upstream `initial`: https://github.com/jielive/initial
- Initial Plus: http://blog.alttt.com
- The encryption plugin, standalone: https://ucw.moe/archives/typecho-partially-password.html
