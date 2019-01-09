<?php
/***********************************************************
** FIELDS TAXONOMY
** This taxonomy is used to give a hook to ACF (Advanced custom
** fields) plugin. Selecting a value of this taxonomy will determin what
** custom field groups/options show on that content item.
************************************************************/
add_action( 'init', 'custom_fields_taxonomy', 0 );
function custom_fields_taxonomy() {
	$labels = array(
		'name'                       => _x( 'Content Fields', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Field', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Fields', 'text_domain' ),
		'all_items'                  => __( 'All Fields', 'text_domain' ),
		'parent_item'                => __( 'Parent Field', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Field:', 'text_domain' ),
		'new_item_name'              => __( 'New Field Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Field', 'text_domain' ),
		'edit_item'                  => __( 'Edit Field', 'text_domain' ),
		'update_item'                => __( 'Update Field', 'text_domain' ),
		'view_item'                  => __( 'View Field', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Fields', 'text_domain' ),
		'search_items'               => __( 'Search Fields', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No Fields', 'text_domain' ),
		'items_list'                 => __( 'Fields list', 'text_domain' ),
		'items_list_navigation'      => __( 'Fields list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => false,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => false,
	);
	register_taxonomy( 'custom_fields', array( 'post' ), $args );
}
