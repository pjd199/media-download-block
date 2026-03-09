# Media Download Block

A lightweight, professional Gutenberg block that allows users to select files from the WordPress Media Library and display them as a stylized download row.

## ✨ Features
* **Wide File Support:** Automatically identifies and labels icons for all [WordPress.com accepted filetypes](https://wordpress.com/support/accepted-filetypes/) (Images, PDF, ZIP, Office Docs, Video, and Audio).
* **Custom Display Names:** Override the default Media Library title with a custom name directly in the editor.
* **Smart Metadata:** Automatically displays the human-readable file size (e.g., 1.2 MB).
* **Stylized UI:** Features a high-visibility yellow file-type icon and a clear blue "DOWNLOAD" action button.
* **Zero-Bloat Production:** The automated build process ensures only necessary files are included in the final plugin zip.

## 📂 File Structure
```text
media-download-block/
├── .github/workflows/
│   └── release.yml        # GitHub Action for automated ZIP releases
├── src/                   # Development Source (JSX, SCSS)
│   ├── index.js
│   ├── edit.js
│   ├── save.js
│   └── style.scss
├── build/                 # Compiled Production Files (Auto-generated)
├── media-download-block.php # Main Plugin Entry Point
├── package.json           # Build scripts & dependencies
└── README.md              # This file
