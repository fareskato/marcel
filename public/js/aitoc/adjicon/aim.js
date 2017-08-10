
/**
 * Visualize Your Attributes - Color Swatch
 *
 * @category:    AdjustWare
 * @package:     AdjustWare_Icon
 * @version      3.1.15
 * @license:     n/a
 * @copyright:   Copyright (c) 2015 AITOC, Inc. (http://www.aitoc.com)
 */
/**
 *
 *  AJAX IFRAME METHOD (AIM) AITOC MODIFIED
 *  Made For PrototypeJs Use Only
 *  http://www.webtoolkit.info/
 *
 **/

AIM = {
    form_id: 'ait_form',
    file_id : 0,
    frame : function(url, file_id, form_key, options) {
        var n = 'f' + Math.floor(Math.random() * 99999);
        var d = document.createElement('DIV');
        d.style.display = 'none';
        d.innerHTML = '<form action="'+ url +'" method="POST" enctype="multipart/form-data" id="'+this.form_id + '_' + n +'" target="'+n+'">' +
            '<input name="form_key" type="hidden" value="' + form_key + '" /></form><iframe src="about:blank" id="'+n+'" name="'+n+'" onload="AIM.loaded(\''+n+'\')"></iframe>';
        document.body.appendChild(d);

        if(typeof(options)=='object') {
            var frame = $(n),
                form = $(this.form_id + '_' + n);
            for(var i in options) {
                switch(i) {
                    case 'onComplete':
                        frame.onComplete = options.onComplete;
                        frame.file_id = this.file_id;
                        break;
                    default:
                        form.insert('<input type="text" name="'+i+'" value="'+options[i]+'" />');
                        break;
                }
            }
        }
        return n;
    },

    form : function(id , frame_id) {
        var old = $(id);
        var parent = old.parentNode;
        var copy = old.cloneNode(true);
        copy.disabled = true;
        old.className = '';
        Element.insert(old, {after:copy});
        Element.insert($(this.form_id + '_' + frame_id), old);
        Event.extend();
    },

    upload : function(url, file_id, form_key, options) {
        if($(file_id).value=="") {
            return false;
        }
        var frame_id = this.frame(url, file_id, form_key, options);
        this.form(file_id, frame_id);
        this.file_id = file_id;
        $(this.form_id + '_' + frame_id).submit();
        return true;
    },

    loaded : function(id) {
        var d,
            i = $(id);
        if (i.contentDocument) {
            d = i.contentDocument;
        } else if (i.contentWindow) {
            d = i.contentWindow.document;
        } else {
            d = window.frames[id].document;
        }
        if (d.location.href == "about:blank") {
            $(d).remove();
            return;
        }

        with($(this.file_id)) {
            disabled = false;
            value = "";
        }
        if (typeof(i.onComplete) == 'function') {
            eval('var el = ' + d.body.innerHTML + ';');
            i.onComplete( el );
        }
    }
}