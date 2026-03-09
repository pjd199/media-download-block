<?php
/**
 * Plugin Name: Media Download Block
 * Version: 1.2.0
 * Author: WPDM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function wpdm_media_download_block_init() {
    $asset_path = plugin_dir_path( __FILE__ ) . 'build/index.asset.php';
    if ( ! file_exists( $asset_path ) ) return;

    $asset_file = include( $asset_path );

    // Standardized Block Name: wpdm/media-download
    register_block_type( 'wpdm/media-download', array(
        'editor_script' => 'wpdm-block-js',
        'style'         => 'wpdm-block-css',
    ) );

    wp_register_script(
        'wpdm-block-js',
        plugins_url( 'build/index.js', __FILE__ ),
        $asset_file['dependencies'],
        $asset_file['version']
    );

    wp_register_style(
        'wpdm-block-css',
        plugins_url( 'build/index.css', __FILE__ ),
        array(),
        $asset_file['version']
    );
}
add_action( 'init', 'wpdm_media_download_block_init' );
