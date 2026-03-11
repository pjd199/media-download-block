<?php
/**
 * Render callback with Output Buffering to prevent Error #310
 */

// 1. Setup Data
$files          = isset($attributes['files']) ? $attributes['files'] : [];
$layout         = isset($attributes['layoutStyle']) ? $attributes['layoutStyle'] : 'row';
$show_download  = isset($attributes['showDownloadAll']) ? $attributes['showDownloadAll'] : false;

// 2. Start Buffering
ob_start();

$wrapper_attributes = get_block_wrapper_attributes([
    'class' => "mdb-container mdb-style-$layout"
]);

// 3. Render inside the buffer
?>
<div <?php echo $wrapper_attributes; ?>>
    <?php if ( empty( $files ) ) : ?>
        <div class="mdb-placeholder-preview">
            <?php esc_html_e( 'No files selected.', 'mdb' ); ?>
        </div>
    <?php else : ?>
        
        <div class="mdb-list-wrapper">
            <?php foreach ( $files as $file ) : ?>
                <div class="mdb-download-row">
                    <div class="mdb-file-icon">
                        </div>
                    <div class="mdb-download-details">
                        <span class="mdb-download-title"><?php echo esc_html( $file['displayName'] ); ?></span>
                    </div>
                    <a href="<?php echo esc_url( $file['url'] ); ?>" class="mdb-clean-link" download>Download</a>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ( $show_download && count( $files ) > 1 ) : ?>
            <div class="mdb-download-all-wrapper" style="margin-top: 20px;">
                <button class="mdb-download-all-btn" data-files='<?php echo htmlspecialchars( json_encode( $files ), ENT_QUOTES, 'UTF-8' ); ?>'>
                    Download All (.zip)
                </button>
            </div>
        <?php endif; ?>

    <?php endif; ?>
</div>
<?php

// 4. Clean and Return
return ob_get_clean();