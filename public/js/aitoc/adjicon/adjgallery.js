
/**
 * Visualize Your Attributes - Color Swatch
 *
 * @category:    AdjustWare
 * @package:     AdjustWare_Icon
 * @version      3.1.15
 * @license:     n/a
 * @copyright:   Copyright (c) 2015 AITOC, Inc. (http://www.aitoc.com)
 */
Product.AdjGallery = Class.create();
Product.AdjGallery.prototype = {
    images : [],
    urls : $H({}),
    file2id : {
        'no_selection' :0
    },
    idIncrement :1,
    containerId :'',
    container :null,
    imageTypes : {},
    initialize : function(containerId, optionId, imageTypes) {
        this.containerId = containerId, this.container = $(this.containerId);
        this.optionId = optionId;
        this.imageTypes = imageTypes;
        this.images = this.getElement('save').value.evalJSON();
        this.imagesValues = this.getElement('save_image').value.evalJSON();
        this.template = new Template('<tr id="__id__" class="preview">' + this
            .getElement('template').innerHTML + '</tr>', new RegExp(
            '(^|.|\\r|\\n)(__([a-zA-Z0-9_]+)__)', ''));
        this.updateImages();
    },
    addUrl: function(id, url) {
        this.urls.set(id, url);
    },
    getUrl: function(id) {
        return this.urls.get(id);
    },
    uploadImageFile: function(id) {
        if(!$('image_'+id).value) {
            return;
        }
        $('loading-mask').show();
        var form_key = $$("input[name='form_key']")[0].value;
        AIM.upload(this.getUrl(id), 'image_'+id, form_key, { onComplete: this.addUploadedImageFile.bind(this)});
    },
    addUploadedImageFile: function(response) {
        if(!response.error) {
            var newImage = {};
            newImage.url = response.url;
            newImage.file = response.file;
            newImage.image_id = response.image_id;
            newImage.label = '';
            this.images.push(newImage);
            this.updateImages();
            $('loading-mask').hide();
        }
        else {
            $('loading-mask').hide();
            alert(response.error);
        }
    },

    /**
     * Aitoc CPP compatibility
     *
     */
    updateCPPOption : function(el){
        var toUpdate = false;
        this.images.each( function(row) {
            var imgId = el.id.replace('cpp-','');
            if(row.image_id == imgId){
                row.cpp_option_id = el.options[el.selectedIndex].value;
                toUpdate = true;
            }
        }.bind(this));

        if(toUpdate == true){
            this.getElement('save').value = Object.toJSON(this.images);
        }
    },

    getElement : function(name) {
        return $(this.containerId + '_' + name);
    },
    updateImages : function() {
        this.getElement('save').value = Object.toJSON(this.images);
        $H(this.imageTypes).each(
            function(pair) {
                this.getFileElement('no_selection',
                    'cell-' + pair.key + ' input').checked = true;
            }.bind(this));
        this.images.each( function(row) {
            if (!$(this.prepareId(row.file))) {
                this.createImageRow(row);
            }
            this.updateVisualisation(row.file);
        }.bind(this));
    },
    createImageRow : function(image) {
        var vars = Object.clone(image);
        vars.id = this.prepareId(image.file);

        // <<< Aitoc CPP compatibility
        vars.imgId = image.image_id;
        if(typeof image.cpp_option_id == null){
            vars.cppValue = '';
        }
        else{
            vars.cppValue = image.cpp_option_id;
        }
        // >>>

        var html = this.template.evaluate(vars);

        Element.insert(this.getElement('list'), {
            bottom :html
        });
    },
    removeImageRow : function(file, image_id, url) {
        $('loading-mask').show();
        new Ajax.Request(
            url,
            {
                method:'post',
                parameters: 'id='+image_id,
                onSuccess: this.removeRow.bind(this)
            }
        );
    },
    removeRow : function(e) {
        if (e && e.responseText) {
            try {
                response = eval('(' + e.responseText + ')');
            }
            catch (error) {
                response = {};
            }
        }
        if(!response.error) {
            Element.remove($("adj_remove["+response.image_id+"]").up('tr'));
            var index = this.getIndexByFile(response.file);
            this.images.remove(this.images[index]);
            this.getElement('save').value = Object.toJSON(this.images);
            $('loading-mask').hide();
        }
        else {
            $('loading-mask').hide();
            alert(response.error);
        }
    },
    prepareId : function(file) {
        if (typeof this.file2id[file] == 'undefined') {
            this.file2id[file] = this.idIncrement++;
        }
        return this.containerId + '-image-' + this.file2id[file];
    },
    getNextPosition : function() {
        var maxPosition = 0;
        this.images.each( function(item) {
            if (parseInt(item.position) > maxPosition) {
                maxPosition = parseInt(item.position);
            }
        });
        return maxPosition + 1;
    },
    updateImage : function(file) {
        var index = this.getIndexByFile(file);
        this.images[index].label = this.getFileElement(file, 'cell-label input').value;
        this.getElement('save').value = Object.toJSON(this.images);
    },
    loadImage : function(file) {
        var image = this.getImageByFile(file);
        this.getFileElement(file, 'cell-image img').src = image.url;
        this.getFileElement(file, 'cell-image img').show();
        this.getFileElement(file, 'cell-image .place-holder').hide();
    },
    setProductImages : function(file, image_id) {
        $H(this.imageTypes)
            .each(
                function(pair) {
                    if (this.getFileElement(file,
                        'cell-' + pair.key + ' input').checked) {
                        this.imagesValues[pair.key] = (file == 'no_selection' ? null
                            : file);
                    }
                }.bind(this));

        this.getElement('save_image').value = Object.toJSON($H(this.imagesValues));
    },
    updateVisualisation : function(file) {
        var image = this.getImageByFile(file);
        this.getFileElement(file, 'cell-label input').value = image.label;
        $H(this.imageTypes)
            .each(
                function(pair) {
                    if (this.imagesValues[pair.key] == file) {
                        this.getFileElement(file,
                            'cell-' + pair.key + ' input').checked = true;
                    }
                }.bind(this));
    },
    getFileElement : function(file, element) {
        var selector = '#' + this.prepareId(file) + ' .' + element;
        var elems = $$(selector);
        if (!elems[0]) {
            try {
                console.log(selector);
            } catch (e2) {
                alert(selector);
            }
        }

        return $$('#' + this.prepareId(file) + ' .' + element)[0];
    },
    getImageByFile : function(file) {
        if (this.getIndexByFile(file) === null) {
            return false;
        }

        return this.images[this.getIndexByFile(file)];
    },
    getIndexByFile : function(file) {
        var index;
        this.images.each( function(item, i) {
            if (item.file == file) {
                index = i;
            }
        });
        return index;
    }
};