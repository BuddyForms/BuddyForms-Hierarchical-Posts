<?php
add_filter('buddyforms_front_js_css_loader', 'buddyforms_hierarchical_load_css_js', 10, 1);
function buddyforms_hierarchical_load_css_js($found){
    global $buddyforms, $post;

    if(is_admin())
        return $found;

    if(!isset($buddyforms['buddyforms']))
        return $found;

    if(!isset($post))
        return $found;

    $form_slug = get_post_meta($post->ID, '_bf_form_slug', true);

    if(!$form_slug)
        return $found;

    if(!isset($buddyforms['buddyforms'][$form_slug]['hierarchical']))
        return $found;

    $found = true;

    return $found;
}

add_filter('the_content', 'buddyforms_hierarchical_display_child_posts', 10, 1);
function buddyforms_hierarchical_display_child_posts($content){
    global $post, $paged, $buddyforms, $form_slug;

    if(is_admin())
        return $content;

    if(!isset($buddyforms['buddyforms']))
        return $content;

    if($post->post_parent)
        return $content;

    $form_slug = get_post_meta($post->ID, '_bf_form_slug', true);

    if(!$form_slug)
        return $content;

    if(!isset($buddyforms['buddyforms'][$form_slug]['hierarchical']))
        return $content;

    $post_type = $buddyforms['buddyforms'][$form_slug]['post_type'];

    remove_filter('the_content', 'buddyforms_hierarchical_display_child_posts', 10, 1);

    $args = array(
        'post_type'			=> $post_type,
        'form_slug'         => $form_slug,
        'post_status'		=> array('publish', 'pending', 'draft'),
        'posts_per_page'	=> 5,
        'post_parent'		=> $post->ID,
        'paged'				=> $paged,
        'sort_column'       => 'post_date',
        'sort_order'        => 'desc',
    );
    ob_start();
    buddyforms_the_loop($args);
    $bf_form = ob_get_contents();
    ob_clean();
    $content .= $bf_form;

    add_filter('the_content', 'buddyforms_hierarchical_display_child_posts', 10, 1);

    return $content;
}

add_action('buddyforms_the_loop_actions', 'buddyforms_hierarchical_the_loop_actions', 10, 1);
function buddyforms_hierarchical_the_loop_actions($post_id){
    global $buddyforms, $post;

    if(!isset($buddyforms['buddyforms']))
        return;

    if($post->post_parent)
        return;

    $form_slug = get_post_meta($post->ID, '_bf_form_slug', true);

    if(!$form_slug)
        return;

    if(!isset($buddyforms['buddyforms'][$form_slug]['hierarchical']))
        return;

    if( current_user_can('buddyforms_'.$form_slug.'_create') ) {
        echo ' - <a href="#" id="' . $post_id . '" class="bf_create_new_child" type="button">Create new Child</a>';
    }

    echo ' - <a href="#" id="' . $post_id . '" class="bf_view_children" type="button">View Children</a>';
}

add_action('buddyforms_delete_post', 'buddyforms_delete_child_posts');
function buddyforms_delete_child_posts($post_id){

    $childs = get_children( Array('post_parent' => $post_id));

    if(empty($childs))
        return;

    foreach($childs as $child){
        wp_delete_post($child->ID); // true => bypass trash and permanently delete
    }

}