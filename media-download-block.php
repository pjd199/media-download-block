<?php
/**
 * Plugin Name: Media Download Block
 * Description: Block for downloading files from the Media Library
 * Version: 0.0.1
 * Author: Pete Dibdin
 * GitHub Plugin URI: https://github.com/pjd199/media-download-block
 * License: MIT
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function mdb_register_block_init() {
    $asset_path = plugin_dir_path( __FILE__ ) . 'build/index.asset.php';
    if ( ! file_exists( $asset_path ) ) return;

    $asset_file = include( $asset_path );

    // Block handle: mdb/media-download
    register_block_type( 'mdb/media-download', array(
        'editor_script' => 'mdb-block-js',
        'editor_style'  => 'mdb-block-editor-css',
        'style'         => 'mdb-block-css',
    ) );

    wp_register_script(
        'mdb-block-js',
        plugins_url( 'build/index.js', __FILE__ ),
        $asset_file['dependencies'],
        $asset_file['version']
    );

    wp_register_style(
        'mdb-block-css',
        plugins_url( 'build/style-index.css', __FILE__ ),
        array(),
        $asset_file['version']
    );
}
add_action( 'init', 'mdb_register_block_init' );