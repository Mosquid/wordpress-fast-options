<?php

add_action( 'save_post', 'my_save_post_test' );
function my_save_post_test($post_id) {
	if( empty($post_id) ) 
		return false;
	$template = get_page_template_slug($post_id);

	if( strpos($template, 'template-options') !== false ) {
		$post = get_post( $post_id );
		$post_content = $post->post_content;
		
		if( empty($post_content) )
			return false;

		$rows = explode("\n", $post_content);
		if( !empty($rows) ) {
			foreach ($rows as $row) {
				$opts_dirty = explode('/=/', $row);
				$opts = array_map( function( $val ) { return trim(chop($val)); }, $opts_dirty);
				$opt_name = $opts[0];
				$opt_val = $opts[1];
				update_option( $opt_name, $opt_val );
			}
		}
	}

	return false;
}

?>