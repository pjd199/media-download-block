<?php
/**
 * Plugin Name: Media Download Block
 * Description: A clean file download block for the Gutenberg editor.
 * Version: 1.2.0
 * Author: WPDM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function media_download_block_init() {
    if ( ! file_exists( plugin_dir_path( __FILE__ ) . 'build/index.asset.php' ) ) {
        return;
    }

    $asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php' );

    register_block_type( 'wpdm/media-download', array(
        'editor_script' => 'media-download-block-js',
        'style'         => 'media-download-block-css',
    ) );

    wp_register_script(
        'media-download-block-js',
        plugins_url( 'build/index.js', __FILE__ ),
        $asset_file['dependencies'],
        $asset_file['version']
    );

    wp_register_style(
        'media-download-block-css',
        plugins_url( 'build/style-index.css', __FILE__ ),
        array(),
        $asset_file['version']
    );
}
add_action( 'init', 'media_download_block_init' );
