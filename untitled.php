<?php
/*
Plugin Name: Untitled
Plugin URI: https://github.com/brilik/
Description: A brief description of the Plugin.
Version: 1.0
Author: brilik
Author URI: https://ibryl.store/profile/
License: A "Slug" license name e.g. GPL2
*/

$path = plugin_dir_path( __FILE__ );
define( 'DIR_INCL', $path . '/includes/' );
define( 'DIR_VIEW', $path . '/views/' );

include_once DIR_INCL . 'Untitled.php';

$box = new Untitled();

$box->create_menu( 'Plugin Options' );
$box->add_option( [
    'sec_title'   => 'Hello sections',
    'sec_options' => array(
        [
            'input' => 'checkbox',
            'title' => 'Test option',
            'label' => 'label for option',
        ],
        [
            'input' => 'text',
            'title' => 'Test title',
            'label' => 'label for title',
        ],
    ),
] );

// ***********************************************
/**
 * include_once Database
 * db -> create_table [id], [post_id], [post_view]
 * db -> copy id's all posts to table[post_id]
 */