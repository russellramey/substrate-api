<?php
/***********************************************************
** THEME SETUP
** Base theme functions for WP Themes
************************************************************/
add_action( 'after_setup_theme', 'substrate_setup' );
function substrate_setup() {
	load_theme_textdomain( 'substrate', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
}

/***********************************************************
** ADDITONAL FUNCTIONS
************************************************************/
include '_includes/api.php';
include '_includes/taxonomy.php';
include '_includes/scripts.php';
?>
