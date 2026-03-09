<?php
// Safety check: if no files, don't render anything
$files = isset($attributes['files']) ? $attributes['files'] : [];
if (empty($files)) return '';

// Helper for icons inside the same file to ensure it's defined
if (!function_exists('mdb_get_icon')) {
    function mdb_get_icon($label) {
        $ext = strtolower($label);
        // Using a very simple path for testing first
        $path = '<path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2z"/>';
        
        if ($ext === 'pdf') $path = '<path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>';
        // (Add your other elseif's back here once the base works)
        
        return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">' . $path . '</svg>';
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