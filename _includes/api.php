<?php
/***********************************************************
** REGISTER POST TYPES METADATA TO API
** Adds post_metadata to API response
************************************************************/
// Array for Post Types
$contentTypes = get_available_post_types();
// Register new field for each Type
register_rest_field( $contentTypes, 'metadata', array(
    'get_callback' => function ( $data ) {
        return get_post_meta( $data['id'], '', '' );
    },
));


/***********************************************************
** RETURN TAXONOMY NAME IN API
** Returns taxonomy as a SLUG instead of ID
** from the REST response.
************************************************************/
add_action( 'rest_api_init', 'add_taxonomy_slugs_to_api' );
function add_taxonomy_slugs_to_api() {

	// Array for Post Types
	$contentTypes = get_available_post_types();

	// Register new api field
	register_rest_field( $contentTypes, 'terms',
		array(
			'get_callback'    => 'get_content_type_tax_slug',
			'update_callback' => null,
			'schema'          => null,
		)
	);
}
function get_content_type_tax_slug( $object ) {
	// Empty array
    $formatted_terms = array();
	// Get the Terms of the object->id
	$terms = wp_get_post_terms($object['id']);
	// It terms obj exists
	if($terms){
		// Return terms obj
		return $terms;
	}
}


/***********************************************************
** Add filter parameters for JSON endpoints
** Pass the ?filter[VALUE] parameter into the Request to sort
** content by taxonomies or other available filters.
************************************************************/
add_action( 'rest_api_init', 'rest_api_filter_add_filters' );
function rest_api_filter_add_filters() {
	foreach ( get_post_types( array( 'show_in_rest' => true ), 'objects' ) as $post_type ) {
		add_filter( 'rest_' . $post_type->name . '_query', 'rest_api_filter_add_filter_param', 10, 2 );
	}
}
function rest_api_filter_add_filter_param( $args, $request ) {
	// Bail out if no filter parameter is set.
	if ( empty( $request['filter'] ) || ! is_array( $request['filter'] ) ) {
		return $args;
	}
	$filter = $request['filter'];
	if ( isset( $filter['posts_per_page'] ) && ( (int) $filter['posts_per_page'] >= 1 && (int) $filter['posts_per_page'] <= 100 ) ) {
		$args['posts_per_page'] = $filter['posts_per_page'];
	}
	global $wp;
	$vars = apply_filters( 'query_vars', $wp->public_query_vars );
	foreach ( $vars as $var ) {
		if ( isset( $filter[ $var ] ) ) {
			$args[ $var ] = $filter[ $var ];
		}
	}
	return $args;
}


/***********************************************************
** POST TYPE HELPER
** Get all Available Post Types
** This function looks for all Public Post Types, incuding CPT
************************************************************/
function get_available_post_types() {
	$contentTypes = [];
	// Get all public Post Types
	$postTypes = get_post_types(array('public'=>true));
	// Foreach type, push to Types array
	foreach($postTypes as $type){
		array_push($contentTypes, $type);
	}

	// Return data
	return $contentTypes;
}
