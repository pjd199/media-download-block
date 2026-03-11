<?php
// Safety check: if no files, don't render anything
$files = isset($attributes['files']) ? $attributes['files'] : [];
if (empty($files)) return '';

// Helper for icons inside the same file to ensure it's defined
if (!function_exists('mdb_get_icon')) {
    function mdb_get_icon($label) {
        $ext = strtolower(trim($label));
        
        // Define paths for top Bootstrap Filetype Icons
        // All paths are taken directly from the Bootstrap Icons SVG set
        switch ($ext) {
            case 'pdf':
                $path = '<path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5zM4.5 12.5a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zm0-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zm0-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1z"/>';
                break;
            case 'doc':
            case 'docx':
                $path = '<path d="M13.5 1h-11a.5.5 0 0 0-.5.5V11h12V1.5a.5.5 0 0 0-.5-.5zM4.5 12.5a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zm0-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1z"/>';
                break;
            case 'xls':
            case 'xlsx':
            case 'csv':
                $path = '<path d="M5.184 12.14l1.671-2.621-1.455-2.12h1.143l.857 1.481.847-1.481h1.13l-1.427 2.14 1.667 2.601h-1.19l-1.037-1.745-1.027 1.745zM14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5z"/>';
                break;
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
            case 'svg':
                $path = '<path d="M10.648 7.646a.5.5 0 0 1 .577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71zM14 3H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1z"/>';
                break;
            case 'zip':
            case 'rar':
            case '7z':
                $path = '<path d="M6.5 7.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2m1 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2m-4 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>';
                break;
            case 'mp4':
            case 'mov':
                $path = '<path d="M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm4 0v6h8V1zm8 8H4v6h8z"/>';
                break;
            case 'mp3':
            case 'wav':
                $path = '<path d="M9 13c0 1.105-1.12 2-2.5 2S4 14.105 4 13s1.12-2 2.5-2 2.5.895 2.5 2"/> <path fill-rule="evenodd" d="M9 3v10H8V3z"/> <path d="M8 2.82a1 1 0 0 1 .804-.98l3-.6A1 1 0 0 1 13 2.22V4L8 5z"/>';
                break;
            default: // Generic File
                $path = '<path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5L9.5 1z"/>';
                break;
        }
        
        return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-filetype-' . esc_attr($ext) . '" viewBox="0 0 16 16">' . $path . '</svg>';
    }
}

$header_text = $attributes['headerText'] ?? '';
$header_level = $attributes['headerLevel'] ?? 2;
$layout_style = $attributes['layoutStyle'] ?? 'row';
$show_all = $attributes['showDownloadAll'] ?? false;

// Get standard block classes (alignments, etc)
$wrapper_attributes = get_block_wrapper_attributes([
    'class' => "mdb-container mdb-style-$layout_style"
]);
?>

<div <?php echo $wrapper_attributes; ?>>
    <?php if ($header_text): ?>
        <h<?php echo (int)$header_level; ?> class="mdb-front-header"><?php echo esc_html($header_text); ?></h<?php echo (int)$header_level; ?>>
    <?php endif; ?>

    <?php if ($show_all && count($files) > 1): ?>
        <button class="mdb-download-all-btn" data-files='<?php echo json_encode($files); ?>' data-zipname="downloads">
            Download All (.zip)
        </button>
    <?php endif; ?>

    <div class="mdb-list-wrapper">
        <?php foreach ($files as $file): ?>
            <div class="mdb-download-row">
                <div class="mdb-file-icon"><?php echo mdb_get_icon($file['fileLabel']); ?></div>
                <div class="mdb-download-details">
                    <span class="mdb-download-title"><?php echo esc_html($file['displayName']); ?></span>
                    <span class="mdb-download-size"><?php echo esc_html($file['fileSize']); ?></span>
                </div>
                <a href="<?php echo esc_url($file['url']); ?>" class="mdb-clean-link" download>Download</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>