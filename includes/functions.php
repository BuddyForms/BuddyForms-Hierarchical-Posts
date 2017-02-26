<?php
add_filter( 'buddyforms_front_js_css_loader', 'buddyforms_hierarchical_load_css_js', 10, 1 );
function buddyforms_hierarchical_load_css_js( $found ) {
	global $buddyforms, $post;

	if ( is_admin() ) {
		return $found;
	}

	if ( ! isset( $buddyforms ) ) {
		return $found;
	}

	if ( ! isset( $post ) ) {
		return $found;
	}

	$form_slug = get_post_meta( $post->ID, '_bf_form_slug', true );

	if ( ! $form_slug ) {
		return $found;
	}

	if ( ! isset( $buddyforms[ $form_slug ]['hierarchical'] ) ) {
		return $found;
	}

	$found = true;

	return $found;
}

add_filter( 'the_content', 'buddyforms_hierarchical_display_child_posts', 10, 1 );
function buddyforms_hierarchical_display_child_posts( $content ) {
	global $post, $paged, $buddyforms, $form_slug;

	remove_filter( 'the_content', 'buddyforms_hierarchical_display_child_posts', 50, 1 );

	if(!is_single()){
		return $content;
	}

	if ( is_admin() ) {
		return $content;
	}

	if ( ! isset( $buddyforms ) ) {
		return $content;
	}

	if ( $post->post_parent ) {
		return $content;
	}

	$form_slug = get_post_meta( $post->ID, '_bf_form_slug', true );

	if ( ! $form_slug ) {
		return $content;
	}

	if ( ! isset( $buddyforms[ $form_slug ]['hierarchical'] ) ) {
		return $content;
	}

	$post_type = $buddyforms[ $form_slug ]['post_type'];

	remove_filter( 'the_content', 'buddyforms_hierarchical_display_child_posts', 10, 1 );

	$args = array(
		'post_type'      => $post_type,
		'form_slug'      => $form_slug,
		'post_status'    => array( 'publish', 'pending', 'draft' ),
		'posts_per_page' => 5,
		'post_parent'    => $post->ID,
		'paged'          => $paged,
		'sort_column'    => 'post_date',
		'sort_order'     => 'desc',
	);

	ob_start();
	buddyforms_the_loop( $args );
	$bf_form = ob_get_contents();
	ob_clean();

	$content .= $bf_form;

	add_filter( 'the_content', 'buddyforms_hierarchical_display_child_posts', 10, 1 );

	return $content;
}

add_action( 'buddyforms_the_loop_actions', 'buddyforms_hierarchical_the_loop_actions', 10, 1 );
function buddyforms_hierarchical_the_loop_actions( $post_id ) {
	global $buddyforms, $post;

	if ( ! isset( $buddyforms ) ) {
		return;
	}

	if ( $post->post_parent ) {
		return;
	}

	$form_slug = get_post_meta( $post->ID, '_bf_form_slug', true );

	if ( ! $form_slug ) {
		return;
	}

	if ( ! isset( $buddyforms[ $form_slug ]['hierarchical'] ) ) {
		return;
	}

	$permalink = get_permalink( $buddyforms[ $form_slug ]['attached_page'] );


	$d_form = isset( $buddyforms[$form_slug]['different_form'][0] ) ? $buddyforms[$form_slug]['different_form'][0] : 'none';

	$different_form = $d_form != 'none' ? $buddyforms[$form_slug]['different_form'] : $form_slug;


	if( is_array( $different_form ) ){

		$tmp = '';
		foreach( $different_form as $l_form_slug ){
			$permalink_different_form = get_permalink( $buddyforms[ $l_form_slug ]['attached_page'] );
			if ( current_user_can( 'buddyforms_' . $l_form_slug . '_create' ) ) {
				$tmp .= ' <a class="button" title="' .$buddyforms[$l_form_slug]['hierarchical_singular_name'].'" id="' . $post_id . '" class="" href="' . $permalink_different_form . 'create/' . $l_form_slug . '/' . $post_id . '">' . __( 'Create new 2 ', 'buddyforms' ) . $buddyforms[$l_form_slug]['name'].'</a><br>';
			}
		}

		ob_start(); ?>
		<script>
            jQuery(document).ready(function (){
	            jQuery('.bf_view_form_select').on('click', function(event){
	                jQuery('<div></div>').dialog({
	                    modal: true,
	                    title: "Select Type",
	                    open: function () {
	                        jQuery(this).html('<?php echo $tmp ?>');
	                    },
	                    buttons: {
	                        Ok: function () {
	                            jQuery(this).dialog("close");
	                        }
	                    }
	                });

	            });
            });

		</script>
		<?php
		$form_select_js = ob_get_clean();
	}


//	print_r($different_form);
	if( $d_form != 'none') {
		echo $form_select_js;
	}

	if ( current_user_can( 'buddyforms_' . $form_slug . '_create' ) ) {

	    // Add BuddyPress Support and check if BuddyPress is activated and Profile Integration enabled
		if ( defined( 'BP_VERSION' ) && isset( $buddyforms[ $form_slug ]['profiles_integration'] ) ) {

		    if( $d_form == 'none'){
			    echo ' <a title="' . __('Create ', 'buddyforms') .$buddyforms[$form_slug]['hierarchical_singular_name'].'" id="' . $post_id . '" class="" href="' . $user_domain . $parent_tab . '/' . $different_form . '-create/' . $post_id . '">' . __( 'Create new ', 'buddyforms' ) . $buddyforms[$form_slug]['hierarchical_singular_name'].'</a>';
		    } else {
			    echo ' <a class="bf_view_form_select" title="' . __('Create ', 'buddyforms') .$buddyforms[$form_slug]['hierarchical_singular_name'].'" id="' . $post_id . '" class="" href="#">' . __( 'Create new  ', 'buddyforms' ) . $buddyforms[$form_slug]['hierarchical_singular_name'].'</a>';
		    }

		} else {

			if( $d_form == 'none'){
				echo ' <a title="' . __( 'Create ', 'buddyforms' ) . $buddyforms[ $form_slug ]['hierarchical_singular_name'] . '" id="' . $post_id . '" class="" href="' . $permalink . 'create/' . $different_form . '/' . $post_id . '">' . __( 'Create new ', 'buddyforms' ) . $buddyforms[ $form_slug ]['hierarchical_singular_name'] . '</a>';
			} else {
				echo ' <a class="bf_view_form_select" title="' . __('Create ', 'buddyforms') .$buddyforms[$form_slug]['hierarchical_singular_name'].'" id="' . $post_id . '" class="" href="#">' . __( 'Create new  ', 'buddyforms' ) . $buddyforms[$form_slug]['hierarchical_singular_name'].'</a>';
			}

		}
	}

	echo ' - <a title="' . __( 'View ', 'buddyforms' ) . $buddyforms[ $form_slug ]['hierarchical_name'] . '" href="#" id="' . $post_id . '" class="bf_view_children" type="button">' . __( 'View ', 'buddyforms' ) . $buddyforms[ $form_slug ]['hierarchical_name'] . '</a>';
}

add_action( 'buddyforms_delete_post', 'buddyforms_delete_child_posts' );
function buddyforms_delete_child_posts( $post_id ) {

	$childs = get_children( Array( 'post_parent' => $post_id ) );

	if ( empty( $childs ) ) {
		return;
	}

	foreach ( $childs as $child ) {
		wp_delete_post( $child->ID ); // true => bypass trash and permanently delete
	}

}
