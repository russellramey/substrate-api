<?php
/***********************************************************
** TEMPLATE TAXONOMY
** This taxonomy is used to give a hook to ACF (Advanced custom
** fields) plugin. Selecting a template will determin what
** custom fields/options show up on that post.
************************************************************/
add_action( 'init', 'content_type_taxonomy', 0 );
function content_type_taxonomy() {
 $labels = array(
     'name'                       => _x( 'Content Type', 'Taxonomy General Name', 'text_domain' ),
     'singular_name'              => _x( 'Type', 'Taxonomy Singular Name', 'text_domain' ),
     'menu_name'                  => __( 'Types', 'text_domain' ),
     'all_items'                  => __( 'All Types', 'text_domain' ),
     'parent_item'                => __( 'Parent Type', 'text_domain' ),
     'parent_item_colon'          => __( 'Parent Type:', 'text_domain' ),
     'new_item_name'              => __( 'New Type Name', 'text_domain' ),
     'add_new_item'               => __( 'Add New Type', 'text_domain' ),
     'edit_item'                  => __( 'Edit Type', 'text_domain' ),
     'update_item'                => __( 'Update Type', 'text_domain' ),
     'view_item'                  => __( 'View Type', 'text_domain' ),
     'popular_items'              => __( 'Popular Types', 'text_domain' ),
     'search_items'               => __( 'Search Types', 'text_domain' ),
     'not_found'                  => __( 'Not Found', 'text_domain' ),
     'no_terms'                   => __( 'No Types', 'text_domain' ),
     'items_list'                 => __( 'Types list', 'text_domain' ),
     'items_list_navigation'      => __( 'Types list navigation', 'text_domain' ),
 );
 $args = array(
     'labels'                     => $labels,
     'hierarchical'               => false,
     'public'                     => true,
     'show_ui'                    => true,
     'show_admin_column'          => true,
     'show_in_nav_menus'          => false,
     'show_tagcloud'              => false,
     'rewrite'                    => false,
     'show_in_rest'               => true,
	 'meta_box_cb'       => "post_categories_meta_box", // Make like checkbox
	 'capabilities' => array ( //giving a name to the capability
                'manage_terms' => 'manage_taxonomy',
                'edit_terms' => 'manage_taxonomy',
                'delete_terms' => 'manage_taxonomy',
                'assign_terms' => 'manage_taxonomy'
            )
 );
 register_taxonomy( 'content_type', array( 'post'), $args );
}

/***********************************************************
** FIELDS TAXONOMY
** This taxonomy is used to give a hook to ACF (Advanced custom
** fields) plugin. Selecting a template will determin what
** custom fields/options show up on that post.
************************************************************/
add_action( 'init', 'fields_taxonomy', 0 );
function fields_taxonomy() {
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
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => false,
		'show_in_rest'               => true,
		'capabilities' => array ( //giving a name to the capability
                   'manage_terms' => 'manage_taxonomy',
                   'edit_terms' => 'manage_taxonomy',
                   'delete_terms' => 'manage_taxonomy',
                   'assign_terms' => 'manage_taxonomy'
               )
	);
	register_taxonomy( 'content_fields', array( 'post' ), $args );
}

// Manage user roles for taxonomy
$role = get_role('administrator');
$role->add_cap("manage_taxonomy");

/***********************************************************
** TAXONOMY UI
** This function allows non-hierarchical taxonomy to be
displayed as hierarchical taxonomy (checkboxes) using the
'meta_box_cb' => "post_categories_meta_box" option when
registering the taxonomy
************************************************************/
add_action( 'admin_init', function() {
	if( isset( $_POST['tax_input'] ) && is_array( $_POST['tax_input'] ) ) {
		$new_tax_input = array();
		foreach( $_POST['tax_input'] as $tax => $terms) {
			if( is_array( $terms ) ) {
			  $taxonomy = get_taxonomy( $tax );
			  if( !$taxonomy->hierarchical ) {
				  $terms = array_map( 'intval', array_filter( $terms ) );
			  }
			}
			$new_tax_input[$tax] = $terms;
		}
		$_POST['tax_input'] = $new_tax_input;
	}
});
