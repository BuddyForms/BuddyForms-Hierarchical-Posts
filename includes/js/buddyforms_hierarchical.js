jQuery(document).ready(function (){
    jQuery('.bf_create_new_child').on('click', function(event){
        var post_id = jQuery(this).attr('id');

        if (typeof(tinyMCE) != "undefined") {
            tinyMCE.triggerSave();
        }

        event.preventDefault();

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {"action": "buddyforms_hierarchical_ajax_new_child", "post_id": post_id},
            beforeSend :function(){
                jQuery('.buddyforms_posts_list .bf_modal').show();
            },
            success: function(data){
                jQuery('.buddyforms_posts_list .bf_modal').hide();
                jQuery('.buddyforms_posts_list').replaceWith(data);

                // remove existing editor instance
                tinymce.execCommand('mceRemoveEditor', true, 'editpost_content');

                // init editor for newly appended div
                var init = tinymce.extend( {}, tinyMCEPreInit.mceInit[ 'editpost_content' ] );
                try { tinymce.init( init ); } catch(e){}
            }
        });

    });

    jQuery('.bf_view_children').on('click', function(event){
        var post_id = jQuery(this).attr('id');

        event.preventDefault();
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {"action": "buddyforms_hierarchical_ajax_view_children", "post_id": post_id},
            beforeSend :function(){
                jQuery('.buddyforms_posts_list .bf_modal').show();
            },
            success: function(data){
                jQuery('.buddyforms_posts_list .bf_modal').hide();
                jQuery('.buddyforms_posts_list').replaceWith(data);

                // remove existing editor instance
                tinymce.execCommand('mceRemoveEditor', true, 'editpost_content');

                // init editor for newly appended div
                var init = tinymce.extend( {}, tinyMCEPreInit.mceInit[ 'editpost_content' ] );
                try { tinymce.init( init ); } catch(e){}
            }
        });

    });


});