
/**
 * Visualize Your Attributes - Color Swatch
 *
 * @category:    AdjustWare
 * @package:     AdjustWare_Icon
 * @version      3.1.15
 * @license:     n/a
 * @copyright:   Copyright (c) 2015 AITOC, Inc. (http://www.aitoc.com)
 */
AdjiconAdmin = Class.create();
AdjiconAdmin.prototype = {
    initialize: function() {
        var iconTypes = $$(".visualization_type");
        var typeValue = this.getChecked(iconTypes);
        this.showIconsTypeManager(typeValue);
        iconTypes.each(function(elem) {
            Event.observe(elem, 'click', this.showIconsManager.bind(this));
            Event.observe(elem, 'change', this.showIconsManager.bind(this));
        }.bind(this))
    },

    getChecked: function(iconTypes) {
        for(var i= 0; i< iconTypes.length; i++) {
            if(iconTypes[i].checked) {
                return iconTypes[i].value;
            }
        };
    },

    showIconsManager: function(event) {
        this.showIconsTypeManager(event.target.value);
    },

    showIconsTypeManager: function(value) {
        var fieldsetElements = {1 : $('adjicon_color'), 2 : $('adjicon_images'), 3 : $('adjicon_icon')};
        var keys = Object.keys(fieldsetElements);
        if(value == 0) {
            for (var k=1; k<=keys.length; k++) {
                if(fieldsetElements[k] != null) {
                    fieldsetElements[k].addClassName('no-display');
                    fieldsetElements[k].previousElementSibling.addClassName('no-display');
                }
            }
        }
        else {
            for (var j=1; j<=keys.length; j++) {
                if(value == j && fieldsetElements[j] != null) {
                    fieldsetElements[j].removeClassName('no-display');
                    fieldsetElements[j].previousElementSibling.removeClassName('no-display');
                }
                else if(fieldsetElements[j] != null) {
                    fieldsetElements[j].addClassName('no-display');
                    fieldsetElements[j].previousElementSibling.addClassName('no-display');
                }
            }
        }
    }
}

document.observe("dom:loaded", function() {
    adjcolor = new AdjColor();
    adjadmin = new AdjiconAdmin();
    adjiconcolor = new AdjIconColor();
});

function getAttributeOptions(url, value) {
    new Ajax.Request(url,
        {
            method:'post',
            parameters: 'attribute='+value,
            onSuccess: function(e){
                if (e && e.responseText){
                    try{
                        response = eval('(' + e.responseText + ')');
                    }
                    catch (error) {
                        response = {};
                    }
                }
                $('edit_form').replace(response.form);
                adjadmin.initialize();
                adjcolor.initialize();
                adjiconcolor.initialize();
                jscolor.init();
            }
        }
    );
}

function uploadImageIcon(url, id, form_key) {
    if(!$(id).value) {
        return;
    }
    $('loading-mask').show();
    AIM.upload(url, id, form_key, { onComplete: addUploadedImage });
}

function addUploadedImage(url) {
    if(!url.error) {
        var p = $('option_' + url.file_id).nextElementSibling;
        p.innerHTML = '<img src="'+url.src_view+'" valign="top"/>&nbsp;<img src="'+url.src_list+'" valign="top"/>&nbsp;<img src="'+url.src_layered+'" valign="top"/>&nbsp;<img src="'+url.src_option+'" valign="top"/>';
        $('loading-mask').hide();
    }
    else {
        $('loading-mask').hide();
        alert(url.error);
    }
}