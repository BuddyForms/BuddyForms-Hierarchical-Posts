<?php
/*
 Plugin Name: BuddyForms Hierarchical Posts
 Plugin URI: http://buddyforms.com/downloads/buddyforms-hierarchical-posts/
 Description: BuddyForms Hierarchical Posts like Journal/logs
 Version: 1.0
 Author: Sven Lehnert
 Author URI: https://profiles.wordpress.org/svenl77
 License: GPLv2 or later
 Network: false

 *****************************************************************************
 *
 * This script is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ****************************************************************************
 */


add_action('plugins_loaded', 'buddyforms_hierarchical_requirements');
function buddyforms_hierarchical_requirements(){

    if( ! defined( 'BUDDYFORMS_VERSION' )){
        add_action( 'admin_notices', create_function( '', 'printf(\'<div id="message" class="error"><p><strong>\' . __(\'BuddyForms Hierarchical Form Elements needs BuddyForms to be installed. <a target="_blank" href="%s">--> Get it now</a>!\', " wc4bp_xprofile" ) . \'</strong></p></div>\', "http://themekraft.com/store/wordpress-front-end-editor-and-form-builder-buddyforms/" );' ) );
        return;
    }

}

add_action('init', 'buddyforms_hierarchical_require');
function buddyforms_hierarchical_require() {
    require (dirname(__FILE__) . '/includes/form-ajax.php');
    require (dirname(__FILE__) . '/includes/functions.php');
    require (dirname(__FILE__) . '/includes/form-elements.php');
}


add_action('buddyforms_front_js_css_enqueue', 'buddyforms_hierarchical_front_js_css_enqueue');
function buddyforms_hierarchical_front_js_css_enqueue(){
    wp_enqueue_script( 'buddyforms_hierarchical-js', plugins_url('includes/js/buddyforms_hierarchical.js', __FILE__),	array('jquery') );
}
?>
