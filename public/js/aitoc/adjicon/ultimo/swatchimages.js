
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
        var el = $$('p.product-image a').first();
        el.down('img').remove();
        el.insert(productImage);
        el.href = el.down('img').readAttribute('href');
        if($('zoom-btn') != null) {
            $('zoom-btn').href = el.down('img').readAttribute('href');
        }
        jQuery('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();
    }
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
    $$('p.product-image').each(function(el) {
        var image = el.select('img').first();
        if(el.select('a').length != 0) {
            el.select('a').first().href = baseImageUrl;
        }
        if($('zoom-btn') != null) {
            $('zoom-btn').href = baseImageUrl;
        }
        image.src = baseImageUrl;
    }.bind(this));
};

Product.Config.prototype.updateAdjProductMoreViews = function(option) {
    $$('.more-images div.thumbnails div.item').each(function(el) {
        el.setStyle("display:none;");
    });
    $$('.more-images div.adj_image').each(function(el) {
        el.remove();
    });

    if(typeof adjImages.options[option] != 'undefined' && adjImages.options[option].files.length > 0 && $$('.more-images').length == 0) {
        var base_image = $$('p.product-image').first();
        this.createAdjMoreViewsDiv(base_image);
        this.insertAdjMoreViewsImages(option);
    }
    else if(typeof adjImages.options[option] != 'undefined' && adjImages.options[option].files.length > 0) {
        this.insertAdjMoreViewsImages(option);
    }
    else {
        $$('.more-images div.thumbnails div.item').each(function(el) {
            el.removeAttribute('style');
        });

        if(owlCarousel = jQuery('#itemslider-zoom').data('owlCarousel'))
        {
            a = owlCarousel.userOptions;
            owlCarousel.destroy();
            jQuery('#itemslider-zoom').show();
            jQuery('#itemslider-zoom .owl-item').remove();
            jQuery('#itemslider-zoom .owl-wrapper').remove();
            jQuery('#itemslider-zoom').owlCarousel(a);

            jQuery('#itemslider-zoom .owl-item').css('width', '79px');
        }

        var elMore = $$('.more-images')[0];
        var classes = elMore.getAttribute('class');
        var classes = classes.replace(/(count-(\w+))/gi, '');
        elMore.setAttribute('class', classes);
        count = $$('.more-images div.thumbnails div.item').length;
        if (count <= 5) {
            elMore.addClassName("count-"+count);
        }
        else {
            elMore.addClassName("count-multi");
        }

        jQuery(".lightbox-group").removeData('colorbox');
        jQuery(".lightbox-group:visible").colorbox({
            rel:		'lightbox-group',
            opacity:	0.5,
            speed:		300,
            current:	'{current} / {total}',
            previous: '',
            next: '',
            close: '' //No comma here
            , maxWidth:'95%', maxHeight:'95%'			});

    }
    if(owlCarousel = jQuery('#itemslider-zoom').data('owlCarousel'))
    {
        if(jQuery('#aiticon_more').length == 0)
        {
            var div = new Element('div', {'class': 'aiticon_more', 'style': 'display:none', 'id' : 'aiticon_more'});
            Element.insert($$('p.product-image').first(), {'after':div});
        }
        a = owlCarousel.userOptions;
        owlCarousel.destroy();
        jQuery('#itemslider-zoom').show();
        jQuery('#itemslider-zoom .owl-item').remove();
        jQuery('#itemslider-zoom .owl-wrapper').remove();
        $$('#itemslider-zoom .item').each(function(a){
            if(!a.visible())
            {
                $('aiticon_more').insert(a);
            }
        });
        jQuery('#itemslider-zoom').owlCarousel(a);

        jQuery('#itemslider-zoom .owl-item').css('width', '79px');

        $$('#aiticon_more .item').each(function(a){
            $('itemslider-zoom').insert(a);
        });
    }
};

Product.Config.prototype.createAdjMoreViewsDiv = function(image) {
    var template = new Template(cloudZoomTemplate);
    Element.insert(image, {'after':template.evaluate()});
};

Product.Config.prototype.insertAdjMoreViewsImages = function(option) {

    parent = $$('.more-images div.thumbnails')[0];
    parentChildFirst = parent.firstChild;
    adjImages.options[option].files.each(function(file) {
        var div = new Element('div');
        div.addClassName('item');
        div.addClassName('adj_image');
        div.setStyle('width: 79px;');
        var img = new Element('img', {
            src: adjImages.baseMediaUrl + file.src_full
        });
        var a = new Element('a', {
            'href': adjImages.baseMediaUrl + file.src_full,
            'class' : 'cloud-zoom-gallery lightbox-group cboxElement',
            'rel' : "useZoom:'zoom1', smallImage: '"+adjImages.baseMediaUrl + file.src_full+"'"
        });
        a.appendChild(img);
        div.appendChild(a);
        parent.insertBefore(div, parentChildFirst);
    });
    $$('.more-images')[0].removeClassName("hide-direction-nav");
    var classes = $$('.more-images')[0].getAttribute('class');
    var classes = classes.replace(/(count-(\w+))/gi, '');
    $$('.more-images')[0].setAttribute('class', classes);

    var count = adjImages.options[option].files.length;
    if (count > 0)
    {
        if (count <= 5) {
            $$('.more-images')[0].addClassName("count-"+count);
        }
        else {
            $$('.more-images')[0].addClassName("count-multi");
        }
    }
    if (count < 4) {
        $$('.more-images')[0].addClassName("hide-direction-nav");
    }

    jQuery('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();
    jQuery(".cloud-zoom-gallery").click(function() {
        jQuery("#zoom-btn").attr('href', jQuery(this).attr('href'));
        jQuery("#zoom-btn").attr('title', jQuery(this).attr('title'));

        jQuery(".cloud-zoom-gallery").each(function() {
            jQuery(this).addClass("cboxElement");
        });
        jQuery(this).removeClass("cboxElement");
    });


    jQuery(".lightbox-group").removeData('colorbox');
    jQuery(".lightbox-group:visible").colorbox({
        rel:		'lightbox-group',
        opacity:	0.5,
        speed:		300,
        current:	'{current} / {total}',
        previous: '',
        next: '',
        close: '' //No comma here
        , maxWidth:'95%', maxHeight:'95%'			});

    if(owlCarousel = jQuery('#itemslider-zoom').data('owlCarousel'))
    {
        if(jQuery('#aiticon_more').length == 0)
        {
            var div = new Element('div', {'class': 'aiticon_more', 'style': 'display:none', 'id' : 'aiticon_more'});
            Element.insert($$('p.product-image').first(), {'after':div});
        }
        a = owlCarousel.userOptions;
        owlCarousel.destroy();
        jQuery('#itemslider-zoom').show();
        jQuery('#itemslider-zoom .owl-item').remove();
        jQuery('#itemslider-zoom .owl-wrapper').remove();
        $$('#itemslider-zoom .item').each(function(a){
            if(!a.visible())
            {
                $('aiticon_more').insert(a);
            }
        });
        jQuery('#itemslider-zoom').owlCarousel(a);

        jQuery('#itemslider-zoom .owl-item').css('width', '79px');

        $$('#aiticon_more .item').each(function(a){
            $('itemslider-zoom').insert(a);
        });
    }

};