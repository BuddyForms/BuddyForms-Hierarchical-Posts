<?php
function buddyforms_hierarchical_form_builder_sidebar_metabox() {
	add_meta_box( 'buddyforms_hierarchical', __( "Hierarchical Posts", 'buddyforms' ), 'buddyforms_hierarchical_form_builder_sidebar_metabox_html', 'buddyforms', 'normal', 'low' );
	add_filter( 'postbox_classes_buddyforms_buddyforms_hierarchical', 'buddyforms_metabox_class' );
	add_filter( 'postbox_classes_buddyforms_buddyforms_hierarchical', 'buddyforms_metabox_show_if_form_type_post' );
	add_filter( 'postbox_classes_buddyforms_buddyforms_hierarchical', 'buddyforms_metabox_show_if_post_type_none' );

}

function buddyforms_hierarchical_form_builder_sidebar_metabox_html() {
	global $post, $buddyforms;

	if ( $post->post_type != 'buddyforms' ) {
		return;
	}

	$buddyform = get_post_meta( get_the_ID(), '_buddyforms_options', true );

	$form_setup = array();

	$hierarchical = '';
	if ( isset( $buddyform['hierarchical'] ) ) {
		$hierarchical = $buddyform['hierarchical'];
	}

	$form_setup[] = new Element_Checkbox( "<b>" . __( 'Allow Hierarchical Posts', 'buddyforms' ) . "</b>", "buddyforms_options[hierarchical]", array( "hierarchical" => "hierarchical" ), array(
		'value'     => $hierarchical,
		'shortDesc' => __( 'hierarchical', 'buddyforms' )
	) );
	//$form_setup[] = new Element_Checkbox("<b>" . __('Delete Hierarchical Posts', 'buddyforms') . "</b>", "buddyforms_options[hierarchical]", array("hierarchical" => "hierarchical"), array('value' => $attache, 'shortDesc' => __('hierarchical', 'buddyforms')));
	$form_setup[]      = new Element_HTML( '<br><br><b>' . __( 'Buttons Label:', 'buddyforms' ) . '</b><br><br>' );


	if(is_array($buddyforms)){
		$forms[$buddyform['slug']] = 'This Form';
		foreach ( $buddyforms as $form ) {
			if( $form['slug'] != $post->post_name && $form['form_type'] == 'post' ){
				echo get_post_type(get_the_ID());
				if( isset( $form['post_type'] ) && $form['post_type'] == $buddyform['post_type'] )
				$forms[$form['slug']] = $form['name'];
			}
		}
	}

	$different_form = 'none';
	if ( isset( $buddyform['different_form'] ) ) {
		$different_form = $buddyform['different_form'];
	}


	$form_setup[]      = new Element_Checkbox('Select Forms to use for the Children.', 'buddyforms_options[different_form]', $forms, array( 'value' => $different_form, 'multiple' => 'multiple', 'class' => '', 'shortDesc' => 'Only forms from the same post type can be used as child forms.' ) );



	$hierarchical_name = 'Children';
	if ( isset( $buddyform['hierarchical_name'] ) ) {
		$hierarchical_name = $buddyform['hierarchical_name'];
	}
	$form_setup[] = new Element_Textbox( '<b>' . __( 'Name', 'buddyforms' ) . '</b>', "buddyforms_options[hierarchical_name]", array( 'value' => $hierarchical_name ) );

	$hierarchical_singular_name = 'Child';
	if ( isset( $buddyform['hierarchical_singular_name'] ) ) {
		$hierarchical_singular_name = $buddyform['hierarchical_singular_name'];
	}
	$form_setup[] = new Element_Textbox( '<b>' . __( 'Singular Name', 'buddyforms' ) . '</b>', "buddyforms_options[hierarchical_singular_name]", array( 'value' => $hierarchical_singular_name ) );

	buddyforms_display_field_group_table( $form_setup );
}

add_filter( 'add_meta_boxes', 'buddyforms_hierarchical_form_builder_sidebar_metabox', 1, 2 );

/*
 * Add a new form element to the form create view sidebar
 *
 * @param object the form object
 * @param array selected form
 *
 * @return the form object
 */
function bf_hierarchical_add_form_element_to_sidebar( $sidebar_elements ) {
	global $post;

	if ( $post->post_type != 'buddyforms' ) {
		return;
	}

	$sidebar_elements[] = new Element_HTML( '<p><a href="#" data-fieldtype="hierarchical" data-unique="unique" class="bf_add_element_action">Hierarchical</a></p>' );

	return $sidebar_elements;
}

add_filter( 'buddyforms_add_form_element_to_sidebar', 'bf_hierarchical_add_form_element_to_sidebar', 1, 2 );

function bf_hierarchical_add_form_element_to_select( $elements_select_options ) {
	global $post;

	if ( $post->post_type != 'buddyforms' ) {
		return;
	}

	$elements_select_options['hierarchical']['label']                  = 'Hierarchical';
	$elements_select_options['hierarchical']['class']                  = 'bf_show_if_f_type_post';
	$elements_select_options['hierarchical']['fields']['hierarchical'] = array(
		'label'  => __( 'Hierarchical', 'buddyforms' ),
		'unique' => 'unique'
	);

	return $elements_select_options;
}

add_filter( 'buddyforms_add_form_element_select_option', 'bf_hierarchical_add_form_element_to_select', 1, 2 );


/*
 * Create the new Form Builder Form Element
 *
 */
function bf_hierarchical_create_new_form_builder_form_element( $form_fields, $form_slug, $field_type, $field_id ) {
	global $buddyforms;
	$buddyforms_options = $buddyforms;

	switch ( $field_type ) {

		case 'hierarchical':
			unset( $form_fields );
			$name = 'Hierarchical';
			if ( isset( $buddyforms_options[ $form_slug ]['form_fields'][ $field_id ]['name'] ) ) {
				$name = $buddyforms_options[ $form_slug ]['form_fields'][ $field_id ]['name'];
			}
			$form_fields['general']['name'] = new Element_Textbox( '<b>' . __( 'Name', 'buddyforms' ) . '</b>', "buddyforms_options[form_fields][" . $field_id . "][name]", array( 'value' => $name ) );

			$form_fields['advanced']['slug'] = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][slug]", 'hierarchical' );

			$form_fields['general']['type'] = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][type]", $field_type );
			break;

	}

	return $form_fields;
}

add_filter( 'buddyforms_form_element_add_field', 'bf_hierarchical_create_new_form_builder_form_element', 1, 5 );


/*
 * Display the new Form Element in the Frontend Form
 *
 */
function bf_hierarchical_create_frontend_form_element( $form, $form_args ) {
	global $buddyforms;

	extract( $form_args );

	$post_type = $buddyforms[ $form_slug ]['post_type'];

	if ( ! $post_type ) {
		return $form;
	}

	if ( ! isset( $customfield['type'] ) ) {
		return $form;
	}

	switch ( $customfield['type'] ) {
		case 'hierarchical':

			$args = array(
				'post_type'      => $post_type,
				'form_slug'      => $form_slug,
				'post_status'    => array( 'publish', 'pending', 'draft' ),
				'posts_per_page' => - 1,
				'post_parent'    => 0,
				'author'         => get_current_user_id(),
//				'meta_key'       => '_bf_form_slug',
//				'meta_value'     => $form_slug
			);


			$user_parents = new WP_Query( $args );


			$parents_select[0] = '(no parent)';
			if ( $user_parents->have_posts() ) {
				while ( $user_parents->have_posts() ) {
					$user_parents->the_post();
					if ( $post_id != get_the_id() ) {
						$parents_select[ get_the_id() ] = get_the_title();
					}
				}
			} else {
				// no posts found
			}
			/* Restore original Post Data */
			wp_reset_postdata();

			$post_parent_id = wp_get_post_parent_id( $post_id );

			if ( $post_parent ) {
				$post_parent_id = $post_parent;
			}

			if ( $post_id && get_children( Array( 'post_parent' => $post_id ) ) ) {
				$element_attr = isset( $customfield['required'] ) ? array(
					'disabled'  => 'disabled',
					'required'  => true,
					'value'     => $post_parent_id,
					'class'     => 'settings-input',
					'shortDesc' => $customfield['name'] . __( ' is disabled. This is a parent post and has children. Remove the children first to allow this post become a child.' )
				) : array(
					'value'     => $post_parent_id,
					'class'     => 'settings-input',
					'disabled'  => 'disabled',
					'shortDesc' => $customfield['name'] . __( ' is disabled. This is a parent post and has children. Remove the children first to allow this post become a child.' )
				);
			} else {
				$element_attr = isset( $customfield['required'] ) ? array(
					'required'  => true,
					'value'     => $post_parent_id,
					'class'     => 'settings-input',
					'shortDesc' => $customfield['description']
				) : array( 'value' => $post_parent_id, 'class' => 'settings-input' );
			}


			$form->addElement( new Element_Select( $customfield['name'], 'hierarchical', $parents_select, $element_attr ) );

			break;
	}

	return $form;
}

add_filter( 'buddyforms_create_edit_form_display_element', 'bf_hierarchical_create_frontend_form_element', 1, 2 );

add_filter( 'buddyforms_update_post_args', 'bf_hierarchical_post_control_args', 50, 1 );
function bf_hierarchical_post_control_args( $args ) {

	if ( isset( $_POST['hierarchical'] ) ) {
		$args['post_parent'] = $_POST['hierarchical'];
	}

	return $args;
}


