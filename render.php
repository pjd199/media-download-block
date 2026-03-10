<?php
/**
 * Render callback for the Media Download Block.
 * Uses Output Buffering to prevent React Reconciliation errors (like #310).
 */

// 1. Setup Attributes with Strict Fallbacks
// Using isset() prevents "Undefined Index" notices which break ServerSideRender
$files          = isset($attributes['files']) ? $attributes['files'] : [];
$layout         = isset($attributes['layoutStyle']) ? $attributes['layoutStyle'] : 'row';
$header_text    = isset($attributes['headerText']) ? $attributes['headerText'] : '';
$header_level   = isset($attributes['headerLevel']) ? $attributes['headerLevel'] : 2;
$show_download  = isset($attributes['showDownloadAll']) ? $attributes['showDownloadAll'] : false;

// 2. Start the Output Buffer
ob_start();

/**
 * Helper: mdb_get_file_icon
 * Encapsulates SVG logic to keep the template clean.
 */
if ( ! function_exists( 'mdb_get_file_icon' ) ) {
    function mdb_get_file_icon( $label ) {
        $ext = strtolower( trim( $label ) );
        $path = '';

        switch ( $ext ) {
            case 'pdf':
                $path = '<path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5zM4.5 12.5a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zm0-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1z"/>';
                break;
            case 'doc': case 'docx':
                $path = '<path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5zM5.485 6.879l.643.643a.5.5 0 0 0 .708 0l.642-.643a.5.5 0 0 0 0-.708l-.642-.642a.5.5 0 0 0-.708 0l-.643.642a.5.5 0 0 0 0 .708z"/>';
                break;
            case 'xls': case 'xlsx': case 'csv':
                $path = '<path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5zM5.184 12.14l1.671-2.621-1.455-2.12h1.143l.857 1.481.847-1.481h1.13l-1.427 2.14 1.667 2.601h-1.19l-1.037-1.745-1.027 1.745z"/>';
                break;
            case 'zip': case 'rar': case '7z':
                $path = '<path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5L9.5 1z"/><path d="M6.5 7.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2m1 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2m-4 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2m1 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2m2 2a1 1 0 1 1 0-2 1 1 0 0 1 0 2m1 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>';
                break;
            default:
                $path = '<path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5L9.5 1z"/>';
                break;
        }

        return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">' . $path . '</svg>';
    }
}

// 3. Generate Wrapper Attributes
$wrapper_attributes = get_block_wrapper_attributes([
    'class' => "mdb-container mdb-style-$layout"
]);
?>

<div <?php echo $wrapper_attributes; ?>>
    
    <?php if ( empty( $files ) ) : ?>
        <div class="mdb-placeholder-preview">
            <?php esc_html_e( 'No files selected. Add some in the sidebar!', 'mdb' ); ?>
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
                        <span class="mdb-download-title">
                            <?php echo esc_html( $file['displayName'] ); ?>
                        </span>
                        <span class="mdb-download-size">
                            <?php echo esc_html( $file['fileSize'] ); ?>
                        </span>
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
                    data-zipname="media-downloads"
                >
                    <span class="dashicons dashicons-archive"></span>
                    <?php esc_html_e( 'Download All (.zip)', 'mdb' ); ?>
                </button>
            </div>
        <?php endif; ?>

    <?php endif; ?>
</div>

<?php
// 4. Return and Clean the Buffer
// This ensures no stray whitespace or line breaks are returned to React
return ob_get_clean();