=== BuddyForms Hierarchical Posts ===
Contributors: svenl77, konradS, themekraft, buddyforms
Author: Sven Lehnert
Plugin URI: http://buddyforms.com/downloads/buddyforms-hierarchical-posts/
Description: BuddyForms Hierarchical Posts like Journal/logs
Tags: buddypress, user, members, profiles, custom post types, taxonomy, frontend posting, frontend editing, groups, post attached to groups
Stable tag: 1.1
Requires at least: 3.9
Tested up to: 4.7.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Hierarchical Posts Extension. Parent post = (Journal) child post = (log)

== Description ==

This is the BuddyForms extension for Hierarchical Posts. You need the BuddyForms plugin installed for the plugin to work. <a href="http://buddyforms.com" target="_blank">Get BuddyForms now!</a>

Select forms as hierarchical. Parent post = (Journal) and child post = (log)

In the posts list of the Hierarchical Form only the parent posts (Journals) are displayed. The child pages (logs) will not be displayed in the overview.

If a Journal is displayed, all child posts (logs) will be listed under the journal content.

If a user creates a new Journal he can add content like in normal posts and describe the journal. The logs from the journal will be listed under the content

<h4>Form Elements</h4>

Parent page select: to allow the user to make a log entry become a new parent.

<b>Logic</b>

If you delete a journal you delete all logs too. Delete will move the posts into trash.

== Documentation & Support ==

<h4>Extensive Documentation and Support</h4>

All code is neat, clean and well documented (inline as well as in the documentation).

The BuddyForms documentation with many how-to’s is following now!

If you still get stuck somewhere, our support gets you back on the right track.
You can find all help buttons in your BuddyForms Settings Panel in your WP Dashboard!

<h4>Got ideas or just missing something?</h4>

If you still miss something, let us know!

== Installation ==

You can download and install BuddyForms Hierarchical by using the built in WordPress plugin installer. If you download BuddyForms manually,
make sure it is uploaded to "/wp-content/plugins/".


== Frequently Asked Questions ==

You need the BuddyForms plugin installed for the plugin to work.
<a href="http://buddyforms.com" target="_blank">Get BuddyForms now!</a>

== Screenshots ==

coming soon

== Changelog ==

== 1.1 ==
New option to select child forms and use different forms for the children. Also works with multible forms
Added new option to allow to display child posts in the normal form views
Make sure multiple child forms does work with BuddyPress enabled even if one of them is embedded and one is separated but both use the same parent.
Added new option to select if post children should be added to the parent single above or under the content.
Restructure the settings page
Changed the form option array structure
Restructure the code
Multiple Fixes

== 1.0.5 ==
Fixed and issue with the dependencies check. The function tgmpa does not accepted an empty array.

== 1.0.4 ==
Fixed an issue with the dependencies management. If pro was activated it still ask for the free version. Fixed now with a new default BUDDYFORMS_PRO_VERSION in the core to check if the pro is active.

== 1.0.3 ==
Change buddyforms_locate_template to use only the file slug
Rename buddyforms_add_form_element_to_select to buddyforms_add_form_e…lement_select_option
Add dependencies management with tgm

== 1.0.2 ==
Support for the form builder select box added
Use buddyforms_display_field_group_table to display options
Add postbox_classes to make the postbox visible.
Only show form type related form elements
Create new functions to show hide metaboxes
Work on the conditionals admin ui
Hooks rename session

== 1.0.1 ==
Reformat code to stay conform with the WordPress coding style guide.
Fix an issue with the Create child link if used as sub form of a parent

== 1.0 ==
Fixed a issue in the create new url left over from the last BuddyForms Members update.
If the form was included with BuddyPress profile the link stop work.
First Stable Version 1.0. Moved the plugin out of the beta mode ;)´

== 0.3 ==
Make it work with the latest version of BuddyForms. the BuddyForms array has changed so I adjust the code too the new structure
Changed default BuddyForms to BUDDYFORMS_VERSION

== 0.2 ==
Change url from themekraft.com to buddyforms.com
Smaller bug fixes

== 0.1 ==
firs beta
