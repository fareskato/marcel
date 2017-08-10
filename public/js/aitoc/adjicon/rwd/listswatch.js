
/**
 * Visualize Your Attributes - Color Swatch
 *
 * @category:    AdjustWare
 * @package:     AdjustWare_Icon
 * @version      3.1.15
 * @license:     n/a
 * @copyright:   Copyright (c) 2015 AITOC, Inc. (http://www.aitoc.com)
 */
AdjListSwatch = Class.create();
AdjListSwatch.prototype = {
    initialize: function(config){
        this.config = config;
        $$('.adj-icon').each(function(elem) {
            var option = elem.getAttribute('id');
            var url = elem.up().previousElementSibling.down('a').getAttribute('href');
            if(this.config[url].isIcons == false) {
                elem.setStyle('pointer-events: none');
            }
            elem.observe('click', this.updateAdjListImage.bind(this));
        }.bind(this));

    },

    updateAdjListImage: function(event) {
        var option = event.currentTarget.getAttribute('id');
        var url = event.currentTarget.up().previousElementSibling.down('a').getAttribute('href');
        var imageEl = event.currentTarget.up().previous('.product-image');
		if(typeof imageEl == 'undefined') {
            if(event.currentTarget.up('.product-shop') != undefined)
            {
                var imageEl = event.currentTarget.up('.product-shop').previous('.product-image');
            }
            else if(event.currentTarget.up('.product-info') != undefined) {
                var imageEl = event.currentTarget.up('.product-info').previous('.product-image');
            }
		}
        if(typeof this.config[url].options[option] != 'undefined' && this.config[url].options[option].files.length > 0) {
            if(this.config[url].options[option].base == false) {
                var image = this.config[url].options[option].files[0];
            }
            else {
                var image = this.config[url].options[option].base;
            }
            baseImageUrl = this.config[url].baseMediaUrl + image.file;
            var image = imageEl.select('img').first();
            image.src = baseImageUrl;
        }
        else {
            imageEl.down('img').remove();
            imageEl.insert(this.config[url].productImage);
        }
    }
}