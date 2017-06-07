<?php

/*
 * Create the Form Builder Post metabox
 */
add_filter( 'add_meta_boxes', 'buddyforms_hierarchical_form_builder_metabox', 1, 2 );
function buddyforms_hierarchical_form_builder_metabox() {
	add_meta_box( 'buddyforms_hierarchical', __( "Hierarchical Posts", 'buddyforms' ), 'buddyforms_hierarchical_form_builder_metabox_html', 'buddyforms', 'normal', 'low' );
	add_filter( 'postbox_classes_buddyforms_buddyforms_hierarchical', 'buddyforms_metabox_class' );
	add_filter( 'postbox_classes_buddyforms_buddyforms_hierarchical', 'buddyforms_metabox_show_if_form_type_post' );
	add_filter( 'postbox_classes_buddyforms_buddyforms_hierarchical', 'buddyforms_metabox_show_if_post_type_none' );
}

/*
 * Create the Form Builder matabox html
 */
function buddyforms_hierarchical_form_builder_metabox_html() {
	global $post, $buddyforms;

	if ( $post->post_type != 'buddyforms' ) {
		return;
	}

	$buddyform = get_post_meta( get_the_ID(), '_buddyforms_options', true );

	$form_setup = array();

	if(is_array($buddyforms)){
		$forms[$buddyform['slug']] = 'This Form';
		foreach ( $buddyforms as $form ) {
			if( $form['slug'] != $post->post_name && $form['form_type'] == 'post' ){
				if( isset( $form['post_type'] ) && $form['post_type'] == $buddyform['post_type'] )
					$forms[$form['slug']] = $form['name'];
			}
		}
	}

	$form_setup[] = new Element_HTML( '<br><br><h4><b>' . __( 'Parent Post Settings', 'buddyforms' ) . '</b></h4><br><br>' );
	$hierarchical = isset( $buddyform['hierarchical']['hierarchical'] ) ? $buddyform['hierarchical']['hierarchical'] : '';
	$form_setup[] = new Element_Checkbox( '<b>' .__( 'Allow Hierarchical Posts', 'buddyforms' ) . '</b>', "buddyforms_options[hierarchical][hierarchical]", array( "hierarchical" => "Hierarchical Posts" ), array(
		'value'     => $hierarchical,
		'shortDesc' => __( 'Enable Hierarchical Posts for this form', 'buddyforms' )
	) );

	$hierarchical_forms         = isset( $buddyform['hierarchical']['hierarchical_forms'] )         ? $buddyform['hierarchical']['hierarchical_forms'] : 'none';
	$form_setup[] = new Element_Checkbox( '<b>' . __( 'Select Forms to use for the Children.', 'buddyforms'), 'buddyforms_options[hierarchical][hierarchical_forms]', $forms, array( 'value' => $hierarchical_forms, 'multiple' => 'multiple', 'class' => '', 'shortDesc' => 'Only forms from the same post type can be used as child forms.' ) );

	$form_setup[] = new Element_HTML( '<br><br><b>' . __( 'Buttons Label:', 'buddyforms' ) . '</b><br><br>' );
	$hierarchical_name = isset( $buddyform['hierarchical']['hierarchical_name'] )          ? $buddyform['hierarchical']['hierarchical_name'] : __( 'Children', 'buddyforms' );
	$form_setup[] = new Element_Textbox( '<b>' . __( 'Name', 'buddyforms' ) . '</b>', "buddyforms_options[hierarchical][hierarchical_name]", array( 'value' => $hierarchical_name ) );
	$hierarchical_singular_name = isset( $buddyform['hierarchical']['hierarchical_singular_name'] ) ? $buddyform['hierarchical']['hierarchical_singular_name'] : __( 'Child', 'buddyforms' );
	$form_setup[] = new Element_Textbox( '<b>' . __( 'Singular Name', 'buddyforms' ) . '</b>', "buddyforms_options[hierarchical][hierarchical_singular_name]", array( 'value' => $hierarchical_singular_name ) );

	$display_child_posts_on_parent_single = isset( $buddyform['hierarchical']['display_child_posts_on_parent_single'] ) ? $buddyform['hierarchical']['display_child_posts_on_parent_single'] : 'none';
	$form_setup[] = new Element_Select( "<b>" . __( 'Display Child Posts', 'buddyforms' ) . "</b>", "buddyforms_options[hierarchical][display_child_posts_on_parent_single]", array( "none" => "Disabled", "above" => "Display above the content", "under" => "Display under the content" ), array(
		'value'     => $display_child_posts_on_parent_single,
		'shortDesc' => __( 'You can display the child posts on the parent single view.', 'buddyforms' )
	) );

	$form_setup[] = new Element_HTML( '<br><br><h4>' . __( 'Child Post Settings:', 'buddyforms' ) . '</h4><br><br>' );
	$display_child_posts = isset( $buddyform['hierarchical']['display_child_posts'] ) ? $buddyform['hierarchical']['display_child_posts'] : '';
	$form_setup[] = new Element_Checkbox( "<b>" . __( 'Display Child Posts', 'buddyforms' ) . "</b>", "buddyforms_options[hierarchical][display_child_posts]", array( "display" => "Display Children" ), array(
		'value'     => $display_child_posts,
		'shortDesc' => __( 'If you want to use this form as Child Form for a other Parent you should enable this option otherwiuse the child posts does not get displayed in the user submission view', 'buddyforms' )
	) );

	buddyforms_display_field_group_table( $form_setup );
}



/*
 * Add the Hierarchical Form ELement to the Form Element Select
 */
add_filter( 'buddyforms_add_form_element_select_option', 'bf_hierarchical_add_form_element_to_select', 1, 2 );
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

/*
 * Create the new Form Builder Form Element
 */
add_filter( 'buddyforms_form_element_add_field', 'bf_hierarchical_create_new_form_builder_form_element', 1, 5 );
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

/*
 * Display the new Form Element in the Frontend Form
 *
 */
add_filter( 'buddyforms_create_edit_form_display_element', 'bf_hierarchical_create_frontend_form_element', 1, 2 );
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

			$parents_select['none'] = '(no parent)';
			if ( $user_parents->have_posts() ) {
				while ( $user_parents->have_posts() ) {
					$user_parents->the_post();
					if ( $post_id != get_the_id() ) {
						$parents_select[ get_the_id() ] = get_the_title();
					}
				}
			}
			/* Restore original Post Data */
			wp_reset_postdata();

			$post_parent_id = wp_get_post_parent_id( $post_id );

			if ( $post_parent ) {
				$post_parent_id = $post_parent;
			}

			$element_attr = array(
				'value'     => $post_parent_id != 0 ? $post_parent_id : 'none',
				'class'     => 'settings-input',
				'shortDesc' => empty($customfield['description']) ? '' : $customfield['description'],
			);

			if( isset( $customfield['required'] ) ) {
				$element_attr['required'] = true;
			}

			if ( $post_id && get_children( Array( 'post_parent' => $post_id ) ) ) {
				$element_attr['shortDesc'] = $customfield['name'] . __( ' is disabled. This is a parent post and has children. Remove the children first to allow this post become a child.' );
				$element_attr['disabled'] = 'disabled';
			}

			$form->addElement(  new Element_Select( $customfield['name'], 'hierarchical', $parents_select, $element_attr ) );

			break;
	}

	return $form;
}

/*
 * Add the post parent to the post args
 */
add_filter( 'buddyforms_update_post_args', 'bf_hierarchical_post_control_args', 50, 1 );
function bf_hierarchical_post_control_args( $args ) {

	if ( isset( $_POST['hierarchical'] ) ) {
		$args['post_parent'] = $_POST['hierarchical'];
	}

	return $args;
}


