<?php
add_action( 'wp_ajax_buddyforms_hierarchical_ajax_new_child', 'buddyforms_hierarchical_ajax_new_child' );
add_action( 'wp_ajax_nopriv_buddyforms_hierarchical_ajax_new_child', 'buddyforms_hierarchical_ajax_new_child' );
function buddyforms_hierarchical_ajax_new_child() {
	$post_parent = $_POST['post_id'];
	$form_slug   = get_post_meta( $post_parent, '_bf_form_slug', true );

	$args = Array(
		'post_parent' => $post_parent,
		'form_slug'   => $form_slug
	);
	echo buddyforms_create_edit_form( $args );
	die();
}

add_action( 'wp_ajax_buddyforms_hierarchical_ajax_view_children', 'buddyforms_hierarchical_ajax_view_children' );
add_action( 'wp_ajax_nopriv_buddyforms_hierarchical_ajax_view_children', 'buddyforms_hierarchical_ajax_view_children' );
function buddyforms_hierarchical_ajax_view_children() {
	global $paged, $the_lp_query, $buddyforms, $form_slug;

	$post_parent = $_POST['post_id'];
	$form_slug   = get_post_meta( $post_parent, '_bf_form_slug', true );

	$args = Array(
		'post_parent' => $post_parent,
		'form_slug'   => $form_slug
	);

	$post_type = $buddyforms[ $form_slug ]['post_type'];


	$args = array(
		'post_type'      => $post_type,
		'form_slug'      => $form_slug,
		'post_status'    => array( 'publish', 'pending', 'draft' ),
		'posts_per_page' => 5,
		'post_parent'    => $post_parent,
		'paged'          => $paged,
		'author'         => get_current_user_id()
	);

	$args = apply_filters( 'buddyforms_post_to_display_args', $args );

	$the_lp_query = new WP_Query( $args );
	$the_lp_query = apply_filters('buddyforms_the_lp_query', $the_lp_query );

	echo '<h4>' . __( 'View all ', '' ) . $buddyforms[ $form_slug ]['hierarchical']['hierarchical_name'] . __( ' of ', 'buddyforms' ) . ' <a href="' . get_post_permalink( $post_parent ) . '">' . get_the_title( $post_parent ) . '</a></h4>';

	buddyforms_locate_template( 'the-loop' );

	// Support for wp_pagenavi
	if ( function_exists( 'wp_pagenavi' ) ) {
		wp_pagenavi( array( 'query' => $the_lp_query ) );
	}

	die();
}
