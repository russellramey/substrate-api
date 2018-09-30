<?php
/***********************************************************
** Create new taxonomy filter
************************************************************/
if (!class_exists('Tax_CTP_Filter')){
	class Tax_CTP_Filter {
		function __construct($cpt = array()){
			$this->cpt = $cpt;
			// Adding a Taxonomy Filter to Admin List for a Custom Post Type
			add_action( 'restrict_manage_posts', array($this,'my_restrict_manage_posts' ));
		}
		public function my_restrict_manage_posts() {
		    // only display these taxonomy filters on desired custom post_type listings
		    global $typenow;
		    $types = array_keys($this->cpt);
		    if (in_array($typenow, $types)) {
		        // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
		        $filters = $this->cpt[$typenow];
		        foreach ($filters as $tax_slug) {
		            // retrieve the taxonomy object
		            $tax_obj = get_taxonomy($tax_slug);
		            $tax_name = $tax_obj->labels->name;
		            // output html for taxonomy dropdown filter
		            echo "<select name='".strtolower($tax_slug)."' id='".strtolower($tax_slug)."' class='postform'>";
		            echo "<option value=''>Show All $tax_name</option>";
		            $this->generate_taxonomy_options($tax_slug,0,0,(isset($_GET[strtolower($tax_slug)])? $_GET[strtolower($tax_slug)] : null));
		            echo "</select>";
		        }
		    }
		}
		public function generate_taxonomy_options($tax_slug, $parent = '', $level = 0,$selected = null) {
		    $args = array('show_empty' => 1);
		    if(!is_null($parent)) {
		        $args = array('parent' => $parent);
		    }
		    $terms = get_terms($tax_slug,$args);
		    $tab='';
		    for($i=0;$i<$level;$i++){
		        $tab.='--';
		    }
		    foreach ($terms as $term) {
		        // output each select option line, check against the last $_GET to show the current option selected
		        echo '<option value='. $term->slug, $selected == $term->slug ? ' selected="selected"' : '','>' .$tab. $term->name .' (' . $term->count .')</option>';
		        $this->generate_taxonomy_options($tax_slug, $term->term_id, $level+1,$selected);
		    }
		}
	}//end class
}//end if
// Call new class
new Tax_CTP_Filter(
    array(
	       'post' => array('content_type')
	)
);

/***********************************************************
** Add filter parameters for JSON endpoints
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
