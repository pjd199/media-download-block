<?php
return '<div class="mdb-placeholder-preview">' . 
        esc_html__( 'HERE', 'mdb' ) . 
        '</div>';


/**
 * Render callback for the Media Download Block.
 * * IMPORTANT: Ensure there is NO whitespace before the opening <?php tag.
 */

// 1. Data Setup - Use the Null Coalescing Operator (??) for safety
$files          = $attributes['files'] ?? [];
$layout         = $attributes['layoutStyle'] ?? 'row';
$header_text    = $attributes['headerText'] ?? '';
$header_level   = $attributes['headerLevel'] ?? 2;
$show_download  = $attributes['showDownloadAll'] ?? false;

// 2. Helper function (defined once)
if ( ! function_exists( 'mdb_get_file_icon' ) ) {
    function mdb_get_file_icon( $label ) {
        $ext = strtolower( trim( $label ) );
        $path = '';
        switch ( $ext ) {
            case 'pdf': $path = '<path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5zM4.5 12.5a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zm0-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1z"/>'; break;
            case 'doc': case 'docx': $path = '<path d="M13.5 1h-11a.5.5 0 0 0-.5.5V11h12V1.5a.5.5 0 0 0-.5-.5zM4.5 12.5a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zm0-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1z"/>'; break;
            case 'xls': case 'xlsx': case 'csv': $path = '<path d="M5.184 12.14l1.671-2.621-1.455-2.12h1.143l.857 1.481.847-1.481h1.13l-1.427 2.14 1.667 2.601h-1.19l-1.037-1.745-1.027 1.745zM14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5z"/>'; break;
            default: $path = '<path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5L9.5 1z"/>'; break;
        }
        return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">' . $path . '</svg>';
    }
}

// 3. Start Output Buffering
ob_start();

// Get standard block wrapper attributes
$wrapper_attributes = get_block_wrapper_attributes([
    'class' => "mdb-container mdb-style-$layout"
]);

// 4. Render HTML inside the buffer
?>
<div <?php echo $wrapper_attributes; ?>>
    <?php if ( empty( $files ) ) : ?>
        <div class="mdb-placeholder-preview">
            <?php esc_html_e( 'No files selected. Add them in the sidebar!', 'mdb' ); ?>
        </div>
    <?php else : ?>

        <?php if ( ! empty( $header_text ) ) : ?>
            <h<?php echo (int) $header_level; ?> class="mdb-front-header">
                <?php echo esc_html( $header_text ); ?>
            </h<?php echo (int) $header_level; ?>>
        <?php endif; ?>

        <div class="mdb-list-wrapper">
            <?php foreach ( $files as $file ) : ?>
                <div class="mdb-download-row">
                    <div class="mdb-file-icon">
                        <?php echo mdb_get_file_icon( $file['fileLabel'] ); ?>
                    </div>
                    <div class="mdb-download-details">
                        <span class="mdb-download-title"><?php echo esc_html( $file['displayName'] ); ?></span>
                        <span class="mdb-download-size"><?php echo esc_html( $file['fileSize'] ); ?></span>
                    </div>
                    <a href="<?php echo esc_url( $file['url'] ); ?>" class="mdb-clean-link" download>
                        <?php esc_html_e( 'Download', 'mdb' ); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ( $show_download && count( $files ) > 1 ) : ?>
            <div class="mdb-download-all-wrapper" style="margin-top: 20px;">
                <button 
                    class="mdb-download-all-btn" 
                    data-files='<?php echo htmlspecialchars( json_encode( $files ), ENT_QUOTES, 'UTF-8' ); ?>'
                >
                    <span class="dashicons dashicons-archive"></span>
                    <?php esc_html_e( 'Download All (.zip)', 'mdb' ); ?>
                </button>
            </div>
        <?php endif; ?>

    <?php endif; ?>
</div>
<?php

// 5. Clean, Trim, and Return
return trim( ob_get_clean() );