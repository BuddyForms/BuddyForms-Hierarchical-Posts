=== BuddyForms Hierarchical Posts ===
Contributors: svenl77, konradS, themekraft, buddyforms
Author: Sven Lehnert
Plugin URI: http://buddyforms.com/downloads/buddyforms-hierarchical-posts/
Description: Create, manage and display hierarchical posts based on parent- and child relationships for a better user experience.
Tags: hierarchical, hierarchical posts, hierarchical post, page, pages, custom post types, hierarchically, frontend posting, frontend editing, post relations, posts relations,
Stable tag: 1.1.7
Requires at least: 3.9
Tested up to: 6.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create, manage and display hierarchical posts based on parent- and child relationships for a better user experience.

== Description ==

#### Parent to child relationship
With Hierarchical Posts you can structure your user submissions in a user friendly way. It's logic is all about parent to child relationships which means that a parent post can have multiple child posts.

WordPress can become unpleasant to write and read stories if they belong together in a hierarchical way. If you have multiple posts belonging together to one story usually you would create a category for this story and add new posts to this category to make them a part of it.

This is a nice system but can become confusing and user unfriendly if you need a much more advanced way to structure your posts. In many cases you need a more structured order within a category or between posts. With the plugin you are able to create one parent post and have its children listed above or underneath the content. The children can share the same or a different category.

---

#### WordPress inbuilt and fully supported in custom post types
WordPress has all functions in place to work nicely with child posts. They are used for pages and also menus (sub navigation). We have the 'get_children' function built in to gather all children posts off a parent post in one place. From there you can create custom post types. The only thing you need to do in the settings is setting 'hierarchical' to true which will enable the hierarchical functionalities.

All in all with the parent to child relationship you give your story related posts a closer binding and make them belonging together. Making the structure of posts visible makes it a lot easier for readers to understand the relationships between the posts.

---

#### Think of parent post as journal and the child post as log
Most off the time you don't want to display the children in the posts list. You want to display the parents and then generate a view for the children log entries. With using the plugin both viewing types are possible: displaying them separately or grouped together.

---

#### Parent post single view
All child posts can be listed under or above the content of the parent post if displayed in the single view. If a user creates a new parent post one can add any type of content just like in normal posts describing the parent (journal). The child posts (log from the journal) can be listed under or above the content.

---

#### Multiple child forms
You can create different forms for the children and enable the user to select the form he likes to use for the child posts. If you only give one form as an option, this form will be used automatically.

---

#### Form element to the select the parent
If one is selecting the parent page: allow the user to select the parent post or change a child posts parent.

---

#### Deleting a parent post
If you delete a parent journal you delete all logs too. Deleting will move the posts into trash.

---

#### Watch the video to see the plugin in action:

[youtube https://www.youtube.com/watch?v=QflNRGYKQuQ]

---

> #### Docs & Support
> * Find our Getting Started, How-to and Developer Docs on [docs.buddyforms.com](http://docs.buddyforms.com/)
> * or watch one of our Video Tutorials [Videos](https://themekraft.com/buddyforms-videos/)

---

> #### Submit Issues - Contribute
> * Pull request are welcome. BuddyForms is community driven and developed on [Github](https://buddyforms.github.io/BuddyForms/)

---

> #### Demo Site
> * Feel free to test BuddyForms on our Demo Site: [BuddyForms Demo](https://addendio.com/try-plugin/?slug=buddyforms)

---

> #### Follow Us
> [Blog](https://themekraft.com/blog/) | [Twitter](https://twitter.com/buddyforms) | [Facebook](https://www.facebook.com/buddyforms/) | [Google+](https://plus.google.com/u/0/b/100975390423636463712/?pageId=100975390423636463712) | [YouTube](https://www.youtube.com/playlist?list=PLYPguOC5yk7_aB2Q2FTaktqHCXDc_mzqb)

---

> **Powered with ❤ by [ThemeKraft](https://themekraft.com)**

---

#### Tags
hierarchical, hierarchical posts, hierarchical post, page, pages, custom post types, hierarchically, frontend posting, frontend editing, post relations, posts relations

---

== Documentation & Support ==

<h4>Extensive Documentation and Support</h4>

All code is neat, clean and well documented (inline as well as in the documentation).

The BuddyForms documentation with many how-to’s is following now!

If you still get stuck somewhere, our support gets you back on the right track.
You can find all help buttons in your BuddyForms Settings Panel in your WP Dashboard!

<h4>Got ideas or just missing something?</h4>

If you still miss something, let us know any feedback is welcome!


== Installation ==

You can download and install BuddyForms Hierarchical by using the built in WordPress plugin installer. If you download BuddyForms manually,
make sure it is uploaded to "/wp-content/plugins/".

== Screenshots ==

1. Form Builder Settings
2. Multiple Forms Select
2. Frontend Form Element
3. Child Posts View
4. List Child Posts on the Parent Single


== Changelog ==
= 1.1.7 - 16 Sep 2022 =
* Fixed issue with BF addons page
* Fixed issue with plugin dependencies
* Tested up to WordPress 6.0.2

= 1.1.6 - 9 Mar 2021 =
* Improved the compatibility with the setting pages of the core plugin
* Fixed the View Children button not working when form List Style is set to 'table'
* Tested up with WordPress 5.7

= 1.1.5 - Mar. 23 2020 =
* Fixed some jQuery issues with the dialog
* Fixed the css
* Added the child forms as links to the modal and make the modal work nicely.
* Updated TGM to the latest version
* Several bug fixes and improvements

= 1.1.4 -  Mar. 03 2019 =
* Freemius SDK Update

= 1.1.3 =
* Give modal a css class, make it not resizable, remove the ok button (because you just need to choose an option and thats it, no extra ok click)
* CSS added to the-loop.css in buddyforms
* Removed the - from the link. We have redesigned the buttons
* Freemius SDK update

= 1.1.2 =
* Added new filter buddyforms_the_lp_query to adjust the query result.
* Smaller bug fixes like checks to avoid notices.

= 1.1.1 =
* Added buddyforms_members_parent_tab freemius integration
* Added function exist buddyforms_members_parent_tab
* Make sure hierarchical posts du work with BuddyPress.

= 1.1 =
* New option to select child forms and use different forms for the children. Also works with multible forms
* Added new option to allow to display child posts in the normal form views
* Make sure multiple child forms does work with BuddyPress enabled even if one of them is embedded and one is separated but both use the same parent.
* Added new option to select if post children should be added to the parent single above or under the content.
* Restructure the settings page
* Changed the form option array structure
* Restructure the code
* Multiple Fixes

= 1.0.5 =
* Fixed and issue with the dependencies check. The function tgmpa does not accepted an empty array.

= 1.0.4 =
* Fixed an issue with the dependencies management. If pro was activated it still ask for the free version. Fixed now with a new default BUDDYFORMS_PRO_VERSION in the core to check if the pro is active.

= 1.0.3 =
* Change buddyforms_locate_template to use only the file slug
* Rename buddyforms_add_form_element_to_select to buddyforms_add_form_e…lement_select_option
* Add dependencies management with tgm

= 1.0.2 =
* Support for the form builder select box added
* Use buddyforms_display_field_group_table to display options
* Add postbox_classes to make the postbox visible.
* Only show form type related form elements
* Create new functions to show hide metaboxes
* Work on the conditionals admin ui
* Hooks rename session

= 1.0.1 =
* Reformat code to stay conform with the WordPress coding style guide.
* Fix an issue with the Create child link if used as sub form of a parent

= 1.0 =
* Fixed a issue in the create new url left over from the last BuddyForms Members update.
* If the form was included with BuddyPress profile the link stop work.
* First Stable Version 1.0. Moved the plugin out of the beta mode ;)´

= 0.3 =
* Make it work with the latest version of BuddyForms. the BuddyForms array has changed so I adjust the code too the new structure
* Changed default BuddyForms to BUDDYFORMS_VERSION

= 0.2 =
Change url from themekraft.com to buddyforms.com
Smaller bug fixes

= 0.1 =
firs beta
