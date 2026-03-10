<?php
/**
 * PHP Render Template for the Media Download Block.
 */

function mdb_get_file_icon_path($label) {
    $ext = strtolower($label);
    
    // Default Icon (Generic File)
    $path = '<path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5L9.5 1z"/>';

    // Image Icons (jpg, jpeg, png, gif, svg)
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg'])) {
        $path = '<path d="M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM10.648 7.646a.5.5 0 0 1 .577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71z"/>';
    } 
    // PDF
    elseif ($ext === 'pdf') {
        $path = '<path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5zM4.5 12.5a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zm0-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zm0-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1z"/>';
    } 
    // Word/Text (doc, docx, txt)
    elseif (in_array($ext, ['doc', 'docx', 'txt'])) {
        $path = '<path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m9-3.5a.5.5 0 0 0-1 0V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>';
    } 
    // Archives (zip, rar, 7z)
    elseif (in_array($ext, ['zip', 'rar', '7z'])) {
        $path = '<path d="M6.5 7.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2m1 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2m-4 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2m1 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2m2 2a1 1 0 1 1 0-2 1 1 0 0 1 0 2m1 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>';
    } 
    // Video (mp4, mov, avi, mkv)
    elseif (in_array($ext, ['mp4', 'mov', 'avi', 'mkv'])) {
        $path = '<path d="M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm4 0v6h8V1zm8 8H4v6h8zM1 1v2h2V1zm2 3H1v2h2zm-2 3v2h2V7zm2 3H1v2h2zm-2 3v2h2v-2zM15 1h-2v2h2zm-2 3v2h2V4zm2 3h-2v2h2zm-2 3v2h2v-2zm2 3h-2v2h2z"/>';
    } 
    // Audio (mp3, wav, flac)
    elseif (in_array($ext, ['mp3', 'wav', 'flac'])) {
        $path = '<path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m7.132 6.213a.5.5 0 0 1 .62.395l.74 3.903a1.5 1.5 0 1 1-.985.3l-.627-3.307a.5.5 0 0 1 .252-.691z"/>';
    } 
    // Excel/Sheets (xls, xlsx, csv)
    elseif (in_array($ext, ['xls', 'xlsx', 'csv'])) {
        $path = '<path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5zM5.184 12.14l1.671-2.621-1.455-2.12h1.143l.857 1.481.847-1.481h1.13l-1.427 2.14 1.667 2.601h-1.19l-1.037-1.745-1.027 1.745z"/>';
    } 
    // PowerPoint (ppt, pptx)
    elseif (in_array($ext, ['ppt', 'pptx'])) {
        $path = '<path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5zM7 11.586V13h-.99V7h1.69c.944 0 1.591.563 1.591 1.446 0 .894-.647 1.464-1.604 1.464zM7 7.82v2.859h.6c.58 0 .918-.322.918-.748 0-.429-.333-.711-.904-.711z"/>';
    }

    return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">' . $path . '</svg>';
}

$files = $attributes['files'] ?? [];
$header_text = $attributes['headerText'] ?? '';
$header_level = $attributes['headerLevel'] ?? 2;
$layout_style = $attributes['layoutStyle'] ?? 'row';
$show_all = $attributes['showDownloadAll'] ?? false;
if (empty($files)) {
    return '';
}

$wrapper_attributes = get_block_wrapper_attributes([
    'class' => "mdb-container mdb-style-{$layout_style}"
]);
?>

<div <?php echo $wrapper_attributes; ?>>
    <?php if ($header_text): ?>
        <h<?php echo esc_attr($header_level); ?> class="mdb-front-header">
            <?php echo esc_html($header_text); ?>
        </h<?php echo esc_attr($header_level); ?>>
    <?php endif; ?>

    <div class="mdb-list-wrapper">
        <?php foreach ($files as $file): ?>
            <div class="mdb-download-row">
                <div class="mdb-file-icon">
                    <?php echo mdb_get_file_icon_path($file['fileLabel']); ?>
                </div>
                <div class="mdb-download-details">
                    <span class="mdb-download-title"><?php echo esc_html($file['displayName']); ?></span>
                    <span class="mdb-download-size"><?php echo esc_html($file['fileSize']); ?></span>
                </div>
                <a href="<?php echo esc_url($file['url']); ?>" class="mdb-clean-link" download aria-label="Download <?php echo esc_attr($file['displayName']); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                    </svg>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>