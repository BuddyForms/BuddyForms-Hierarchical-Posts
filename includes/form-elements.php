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
