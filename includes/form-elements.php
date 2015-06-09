<?php

function buddyforms_hierarchical_form_builder_sidebar_metabox($form, $selected_form_slug){

    $buddyforms_options = get_option('buddyforms_options');


    $form->addElement(new Element_HTML('
		<div class="accordion-group postbox">
			<div class="accordion-heading"><p class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_'.$selected_form_slug.'" href="#accordion_'.$selected_form_slug.'_hierarchical">Hierarchical Posts</p></div>
		    <div id="accordion_'.$selected_form_slug.'_hierarchical" class="accordion-body collapse">
				<div class="accordion-inner">'));

    $attache = '';
    if(isset($buddyforms_options['buddyforms'][$selected_form_slug]['hierarchical']))
        $attache = $buddyforms_options['buddyforms'][$selected_form_slug]['hierarchical'];

    $form->addElement(new Element_Checkbox("<b>" . __('Allow Hierarchical Posts', 'buddyforms') . "</b>", "buddyforms_options[buddyforms][".$selected_form_slug."][hierarchical]", array("hierarchical" => "hierarchical"), array('value' => $attache, 'shortDesc' => __('hierarchical', 'buddyforms'))));
    //$form->addElement(new Element_Checkbox("<b>" . __('Delete Hierarchical Posts', 'buddyforms') . "</b>", "buddyforms_options[buddyforms][".$selected_form_slug."][hierarchical]", array("hierarchical" => "hierarchical"), array('value' => $attache, 'shortDesc' => __('hierarchical', 'buddyforms'))));


    $form->addElement(new Element_HTML('
				</div>
			</div>
		</div>'));

    return $form;
}
add_filter('buddyforms_admin_settings_sidebar_metabox','buddyforms_hierarchical_form_builder_sidebar_metabox',1,2);

/*
 * Add a new form element to the form create view sidebar
 *
 * @param object the form object
 * @param array selected form
 *
 * @return the form object
 */
function bf_hierarchical_add_form_element_to_sidebar($form, $form_slug){
    $form->addElement(new Element_HTML('<p><a href="hierarchical/'.$form_slug.'/unique" class="action">Hierarchical</a></p>'));
    return $form;
}
add_filter('buddyforms_add_form_element_to_sidebar','bf_hierarchical_add_form_element_to_sidebar',1,2);

/*
 * Create the new Form Builder Form Element
 *
 */
function bf_hierarchical_create_new_form_builder_form_element($form_fields, $form_slug, $field_type, $field_id){
    global $field_position;
    $buddyforms_options = get_option('buddyforms_options');

    switch ($field_type) {

        case 'hierarchical':
            unset($form_fields);
            $form_fields['right']['name']		= new Element_Hidden("buddyforms_options[buddyforms][".$form_slug."][form_fields][".$field_id."][name]", 'Hierarchical');
            $form_fields['right']['slug']		= new Element_Hidden("buddyforms_options[buddyforms][".$form_slug."][form_fields][".$field_id."][slug]", 'hierarchical');

            $form_fields['right']['type']	    = new Element_Hidden("buddyforms_options[buddyforms][".$form_slug."][form_fields][".$field_id."][type]", $field_type);
            $form_fields['right']['order']		= new Element_Hidden("buddyforms_options[buddyforms][".$form_slug."][form_fields][".$field_id."][order]", $field_position, array('id' => 'buddyforms/' . $form_slug .'/form_fields/'. $field_id .'/order'));
            $form_fields['left']['html']    = new Element_HTML(__("There are no settings needed so far. If you add the Review Logic form element to the form, the form will use the Review Logic automatically.<br><br> The Form Submit button will change dynamically depends on the post status.", 'buddyforms'));
//            $review_button = 'false';
//            if(isset($buddyforms_options['buddyforms'][$form_slug]['form_fields'][$field_id]['review_button']))
//                $review_button = $buddyforms_options['buddyforms'][$form_slug]['form_fields'][$field_id]['review_button'];
//            $form_fields['full']['draft']		= new Element_Checkbox('<b>' . __('Display Button', 'buddyforms') . '</b>' ,"buddyforms_options[buddyforms][".$form_slug."][form_fields][".$field_id."][review_button]",array('draft' => __('Show Draft Button', 'buddyforms') ,'review' => __('Show Review Button', 'buddyforms')),array('id' => 'draft'.$form_slug.'_'.$field_id , 'value' => $review_button));
            break;

    }

    return $form_fields;
}
add_filter('buddyforms_form_element_add_field','bf_hierarchical_create_new_form_builder_form_element',1,5);


/*
 * Display the new Form Element in the Frontend Form
 *
 */
function bf_hierarchical_create_frontend_form_element($form, $form_args){
    global $buddyforms;

    extract($form_args);

    $post_type = $buddyforms['buddyforms'][$form_slug]['post_type'];

    if(!$post_type)
        return;

    if(!isset($customfield['type']))
        return $form;

    switch ($customfield['type']) {
        case 'hierarchical':

                $args = array(
                    'post_type'			=> $post_type,
                    'form_slug'         => $form_slug,
                    'post_status'		=> array('publish', 'pending', 'draft'),
                    'posts_per_page'	=> -1,
                    'post_parent'		=> 0,
                    'author'			=> get_current_user_id(),
                    'meta_key'          => '_bf_form_slug',
                    'meta_value'        => $form_slug
                );


            $user_parents = new WP_Query( $args );


            $parents_select[0] = '(no parent)';
            if ( $user_parents->have_posts() ) {
                while ( $user_parents->have_posts() ) {
                    $user_parents->the_post();
                    if($post_id != get_the_id())
                        $parents_select[get_the_id()] = get_the_title();
                }
            } else {
                // no posts found
            }
            /* Restore original Post Data */
            wp_reset_postdata();

            $post_parent_id  =  wp_get_post_parent_id( $post_id );

            if(!$post_parent_id)
                $post_parent_id = $post_id;

                echo '<br>parent_id' . $post_id;
                echo '$post_parent_id' . $post_parent_id;

            $element_attr = isset($customfield['required']) ? array('required' => true, 'value' => $post_parent_id, 'class' => 'settings-input', 'shortDesc' => $customfield['description']) : array('value' => $post_parent_id, 'class' => 'settings-input');
            $form->addElement(new Element_Select($customfield['name'], 'hierarchical', $parents_select, $element_attr));

            break;
    }

    return $form;
}
add_filter('buddyforms_create_edit_form_display_element','bf_hierarchical_create_frontend_form_element',1,2);

add_filter('buddyforms_update_post_args', 'bf_hierarchical_post_control_args', 50, 1);
function bf_hierarchical_post_control_args($args){

    parse_str($_POST['data'], $formdata);

    if(isset($formdata['hierarchical'])){
        $args['post_parent'] = $formdata['hierarchical'];
    }

    return $args;
}


