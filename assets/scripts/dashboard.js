jQuery(document).ready(function(){   
    jQuery('.color-picker').wpColorPicker({});

    var ashu_upload_frame;   
    jQuery('.upload_btn').click(function(event){   
        var inputIns = jQuery( this );
        var value_id =jQuery( this ).data('fdname');       
        event.preventDefault();   
        if( ashu_upload_frame ){   
            ashu_upload_frame.open();   
            return;   
        }   
        ashu_upload_frame = wp.media({   
            title: '选择一张图作为' + inputIns.data('as'),   
            button: {   
                text: '使用本图',   
            },   
            multiple: false   
        });   
        ashu_upload_frame.on('select',function(){   
            attachment = ashu_upload_frame.state().get('selection').first().toJSON();   
            jQuery('input[name='+inputIns.data('fdname')+']').val(attachment.url);   
        });   
        
        ashu_upload_frame.open();   
    });   
});   