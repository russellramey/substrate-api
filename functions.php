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

// Unregister default Taxonomy: Categories
add_action('init', 'unregister_category_taxonomy');
function unregister_category_taxonomy(){
    register_taxonomy('category', array());
	register_taxonomy('post_tag', array());
}

/***********************************************************
** Disable Guttenburg Editor
************************************************************/
add_filter('gutenberg_can_edit_post_type', '__return_false');

/***********************************************************
** Remove Default Metaboxes
************************************************************/
add_action( 'admin_menu' , 'remove_default_metaboxes' );
function remove_default_metaboxes() {
	remove_meta_box( 'postcustom' , array('post', 'page') , 'normal' ); //removes custom fields for page
	remove_meta_box( 'commentstatusdiv' , array('post', 'page') , 'normal' ); //removes comments status for page
	remove_meta_box( 'commentsdiv' , array('post', 'page') , 'normal' ); //removes comments for page
	remove_meta_box( 'authordiv' , array('post', 'page') , 'normal' ); //removes author for page
	remove_meta_box( 'revisionsdiv' , array('post', 'page') , 'normal' ); //removes revisions for page
	remove_meta_box( 'trackbacksdiv' , array('post', 'page') , 'normal' ); //removes trackbacks for page
	remove_meta_box( 'postexcerpt' , array('post', 'page') , 'normal' ); //removes excerpt for page
}

/***********************************************************
** Remove Columns from admin views
************************************************************/
add_action( 'admin_init' , 'my_column_init' );
function my_manage_columns( $columns ) {
  unset($columns['author']); // Remove author
  unset($columns['comments']); // Remove comments
  unset($columns['categories']); // Remove comments
  return $columns;
}
function my_column_init() {
  add_filter( 'manage_posts_columns' , 'my_manage_columns' );
}

/***********************************************************
** ADDITONAL FUNCTIONS
************************************************************/
include 'inc/api.php';
include 'inc/taxonomy.php';
include 'inc/filter.php';
include 'inc/scripts.php';
?>
