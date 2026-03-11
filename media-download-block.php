<?php
/**
 * Plugin Name: Media Download Block
 * Description: Block for downloading files from the Media Library
 * Version: 0.0.2
 * Author: Pete Dibdin
 * GitHub Plugin URI: https://github.com/pjd199/media-download-block
 * License: MIT
 * 
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function mdb_register_block_init() {
    // Points to the folder where the build version of block.json lives
    register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'mdb_register_block_init' );