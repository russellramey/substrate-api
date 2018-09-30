<?php
/***********************************************************
** API PREP
** Prepares content types api results, strips out unneed data
** from the REST response.
************************************************************/
// Add filter to various content types
add_filter( 'rest_prepare_post', 'api_post', 10, 3 );
function api_post( $data, $post, $request ) {
	// Set data var
	$_data = $data->data;

	// Change Featured image from ID to URL
	$thumbnail_id = get_post_thumbnail_id( $post->ID );
	$thumbnail = wp_get_attachment_image_src( $thumbnail_id, array(720, 415) );
	$_data['featured_image'] = $thumbnail[0];

	// Remove unneeded data
	unset($_data['featured_media']);
	//unset($_data['content']);
	//unset($_data['excerpt']);
	unset($_data['guid']);
	unset($_data['modified']);
	unset($_data['modified_gmt']);
	unset($_data['type']);
	unset($_data['date_gmt']);
	unset($_data['author']);
	unset($_data['comment_status']);
	unset($_data['ping_status']);
	unset($_data['sticky']);
	unset($_data['format']);
	unset($_data['link']);

	// Return new data
	$data->data = $_data;
	return $data;
}

/***********************************************************
** REGISTER POST TYPES META TO API
** Adds post_metadata to API response
************************************************************/
register_rest_field( array('post', 'page'), 'metadata', array(
    'get_callback' => function ( $data ) {
        return get_post_meta( $data['id'], '', '' );
    },
));


/***********************************************************
** RETURN TAXONOMY NAME IN API
** Returns 'content_type' as a SLUG instead of ID
** from the REST response.
************************************************************/
add_action( 'rest_api_init', 'add_taxonomy_slugs_to_api' );
function add_taxonomy_slugs_to_api() {
	// Register new api field
    register_rest_field( 'post', 'content_type',
        array(
            'get_callback'    => 'get_content_type_tax_slug',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}
function get_content_type_tax_slug( $object, $field_name, $request ) {
	// Empty array
    $formatted_categories = array();
	// Get the taxonomy
    $categories = get_the_terms( $object['id'], 'content_type' );
	// It taxonomy obj exists
	if($categories){
		foreach ($categories as $category) {
	        $formatted_categories[] = $category->slug;
	    }
		// Return new data
		return $formatted_categories;
	}
}
