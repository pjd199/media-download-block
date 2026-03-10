<?php
/**
 * Render callback for the Media Download Block.
 * Using Output Buffering to prevent React Error #310.
 */

// 1. Extract attributes with strict defaults to prevent "Undefined Index" notices
$files          = isset($attributes['files']) ? $attributes['files'] : [];
$layout         = isset($attributes['layoutStyle']) ? $attributes['layoutStyle'] : 'row';
$header_text    = isset($attributes['headerText']) ? $attributes['headerText'] : '';
$header_level   = isset($attributes['headerLevel']) ? $attributes['headerLevel'] : 2;
$show_download  = isset($attributes['showDownloadAll']) ? $attributes['showDownloadAll'] : false;

// 2. Start the Buffer
ob_start();

$wrapper_attributes = get_block_wrapper_attributes([
    'class' => "mdb-container mdb-style-$layout"
]);

// 3. Helper for SVG Icons (logic remains the same)
if ( ! function_exists( 'mdb_get_file_icon' ) ) {
    function mdb_get_file_icon( $label ) {
        $ext = strtolower( trim( $label ) );
        // ... (Keep your switch/case logic here) ...
        return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">' . $path . '</svg>';
    }
}
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
// 4. Return the cleaned buffer
return ob_get_clean();
