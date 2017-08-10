
/**
 * Visualize Your Attributes - Color Swatch
 *
 * @category:    AdjustWare
 * @package:     AdjustWare_Icon
 * @version      3.1.15
 * @license:     n/a
 * @copyright:   Copyright (c) 2015 AITOC, Inc. (http://www.aitoc.com)
 */
Product.Config.prototype.updateAdjProductImages = function(event){
    var select = event.currentTarget;
    var option = event.currentTarget.value;
    if(typeof option == 'undefined') {
        option = event.currentTarget.nextElementSibling.value;
        select = select.up('div.input-box').down('select.super-attribute-select');
    }
    if(!select.prevSetting) {
        this.updateAdjProductBaseImage(option);
        this.updateAdjProductMoreViews(option);
    }
};

Product.Config.prototype.updateAdjProductBaseImage = function(option){
    this.productMainGalleryReset();
    if(typeof adjImages.options[option] != 'undefined' && adjImages.options[option].files.length > 0) {
        if(adjImages.options[option].base == false) {
            var image = adjImages.options[option].files[0];
        }
        else {
            var image = adjImages.options[option].base;
        }

        var baseImageUrl = adjImages.baseMediaUrl + image.file;

        // <<< Aitoc CPP compatibility
        if(typeof objectsCPPVYA != 'undefined'){
            compatibilityCPPVYA(adjImages, option);
        }
        // >>> Aitoc CPP compatibility

        this.changeAdjProductBaseImage(baseImageUrl);
    }
    else {
        var el = $$('.product-image .product-image-gallery').first();
        el.down('img#image-main').remove();
        el.insert({top: productImage});
        jQuery('#image-main').elevateZoom();
    }
};


Product.Config.prototype.productMainGalleryReset = function(){
    $$('.product-image .product-image-gallery img').each(function(el) {
        if(el.hasClassName('visible')) {
            el.removeClassName('visible');
        }
    }.bind(this));
    $('image-main').addClassName('visible');
};

// <<< Aitoc CPP compatibility
function compatibilityCPPVYA(adjImages, option){
    objectsCPPVYA.each(function(el){
        adjImages.options[option].files.each(function(file){
            var toUseDefaultCPPImage = false;
            var aitCgId = file.cpp_option_id;
            if(aitCgId == null){
                toUseDefaultCPPImage = true;
            }
            if(aitCgId != el.id && aitCgId != null){
                return;
            }

            var baseImageUrl = adjImages.baseMediaUrl + file.file;
            var sizePrefix = Math.max(el.config.productImage.thumb.sizeX, el.config.productImage.thumb.sizeY);
            var thumbImageUrl = adjImages.baseMediaUrl + sizePrefix + "x_" + file.file;

            var leftOffset = 0;
            var topOffset = 0;
            if(el.config.productImage.thumb.sizeX > el.config.productImage.thumb.sizeY){
                topOffset = Math.round((el.config.productImage.thumb.sizeX - el.config.productImage.thumb.sizeY) / 2);
            }
            else if(el.config.productImage.thumb.sizeX < el.config.productImage.thumb.sizeY){
                leftOffset = Math.round((el.config.productImage.thumb.sizeY - el.config.productImage.thumb.sizeX) / 2);
            }

            el.setVYAProductImage(baseImageUrl, thumbImageUrl, toUseDefaultCPPImage, leftOffset, topOffset);

            if(aitCgId == el.id){
                throw $break;
            }
        });
    });
};

Product.Config.prototype.changeAdjProductBaseImage = function(baseImageUrl){
    $$('div.product-image').each(function(el) {
        if(!el.hasClassName('product-image-zoom')) {
            el.addClassName('product-image-zoom');
        }

        var image = el.select('img#image-main').first();
        if(!image.hasAttribute('id')) {
            image.id = 'image-main';
        }
        image.onload = this.resizeAdjImage.bind(this, image);
        image.src = baseImageUrl;
    }.bind(this));
};

Product.Config.prototype.resizeAdjImage = function(image){
    image.setAttribute('style', '');
    if($('image') != undefined)
    {
        $('image').stopObserving();
    }
    if($('zoom_in') != undefined)
    {
        $('zoom_in').stopObserving();
    }
    if($('zoom_out') != undefined)
    {
        $('zoom_out').stopObserving();
    }
    if(typeof product_zoom !== 'undefined') {
        product_zoom.initialize('image', 'track', 'handle', 'zoom_in', 'zoom_out', 'track_hint');
    }
    if($('image-main') != undefined && ProductMediaManager != undefined) //use for 1900 magento
    {
        $j('.zoomContainer').remove();
        $j('.product-image-gallery .gallery-image').removeData('elevateZoom');
        jQuery('#image-main').elevateZoom();
    }
};

Product.Config.prototype.updateAdjProductMoreViews = function(option) {
    $$('.more-views li.product_image_conf').each(function(el) {
        el.setStyle('display:none');
    });
    $$('.more-views li.adj_image').each(function(el) {
        el.remove();
    });
    $$('.product-image .product-image-gallery img.adj_image').each(function(elem) {
        elem.remove();
    });

    if(typeof adjImages.options[option] != 'undefined' && adjImages.options[option].files.length > 0 && $$('.more-views').length == 0) {
        var base_image = $$('.product-image').first();
        this.createAdjMoreViewsDiv(base_image);
        this.insertAdjMoreViewsImages(option);
    }
    else if(typeof adjImages.options[option] != 'undefined' && adjImages.options[option].files.length > 0) {
        this.insertAdjMoreViewsImages(option);
    }
    else {
        $$('.more-views li.product_image_conf').each(function(el) {
            el.removeAttribute('style');
        });
    }
};

Product.Config.prototype.createAdjMoreViewsDiv = function(image) {
    $$('.zoom-notice').each(function(elem) {
        elem.remove();
    });
    $$('.zoom').each(function(elem) {
        elem.remove();
    });
    var template = new Template(zoomTemplate);
    Element.insert(image, {'after':template.evaluate()});
    if(typeof product_zoom === 'undefined') {
        product_zoom = new Product.Zoom('image', 'track', 'handle', 'zoom_in', 'zoom_out', 'track_hint');
    }

};

Product.Config.prototype.insertAdjMoreViewsImages = function(option) {
    i = $$('.product-image .product-image-gallery img').length;
    adjImages.options[option].files.each(function(file) {
        var li = new Element('li');
        li.addClassName('adj_image');
        li.addClassName('product_image_conf');
        var img = new Element('img', {
            width: file.width,
            src: adjImages.baseMediaUrl + file.src
        });
        var a = new Element('a', {
            'href': '#',
            //'onclick': "popWin('"+file.gallery +"', 'gallery', 'width=300,height=300,left=0,top=0,location=no,status=yes,scrollbars=yes,resizable=yes'); return false;",
            'class': 'thumb-link',
            'data-image-index': i
        });
        a.appendChild(img);
        li.appendChild(a);
        $$('.more-views ul')[0].appendChild(li);


        var imgMain = new Element('img', {
            'id': 'image-'+i,
            'class': 'gallery-image adj_image',
            'data-zoom-image': adjImages.baseMediaUrl + file.src_full,
            'src': adjImages.baseMediaUrl + file.src_full
        });

        i = i + 1;
        $$('.product-image .product-image-gallery')[0].appendChild(imgMain);
    });

    jQuery('.product-image-thumbs .adj_image .thumb-link').click(function(e) {
        e.preventDefault();
        var jlink = jQuery(this);
        var target = jQuery('#image-' + jlink.data('image-index'));

        ProductMediaManager.swapImage(target);
    });
};

Product.Zoom.prototype._initialize = Product.Zoom.prototype.initialize;
Product.Zoom.prototype.initialize = function(imageEl, trackEl, handleEl, zoomInEl, zoomOutEl, hintEl) {
    this._initialize(imageEl, trackEl, handleEl, zoomInEl, zoomOutEl, hintEl);
    if (this.imageDim.width > this.containerDim.width
        && this.imageDim.height > this.containerDim.height) {
        this.trackEl.up().show();
        this.hintEl.show();
        this.containerEl.addClassName('product-image-zoom');
        return;
    }
};