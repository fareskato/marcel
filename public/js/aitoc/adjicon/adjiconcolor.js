
/**
 * Visualize Your Attributes - Color Swatch
 *
 * @category:    AdjustWare
 * @package:     AdjustWare_Icon
 * @version      3.1.15
 * @license:     n/a
 * @copyright:   Copyright (c) 2015 AITOC, Inc. (http://www.aitoc.com)
 */
var AdjIconColor = Class.create({
    initialize: function() {
        this.iconSpans = '.icon0 span, .icon1 span, .icon2 span, .icon3, .icon4, .icon5';
        this.selectedIcons = '.icon0.adjselected, .icon1.adjselected, .icon2.adjselected';
        this.defIcons = '.icon0.adjdef, .icon1.adjdef, .icon2.adjdef, .icon0.adjdisabled, .icon1.adjdisabled, ' +
            '.icon2.adjdisabled, .icon3, .icon4, .icon5, .icon3:hover, .icon4:hover, .icon5:hover';
        this.iconsHover = '.icon0.adjdef:hover, .icon1.adjdef:hover, .icon2.adjdef:hover';
        this.iconColor = $("icon_color");
        this.iconeTextColor = $("icon_text_color");
        if(this.iconColor != null) {
            this.changeColor(this.iconColor.value);
        }
        if(this.iconeTextColor != null) {
            this.changeTextColor(this.iconeTextColor.value);
        }
        this.addFieldsListeners();
    },

    addFieldsListeners: function() {
        if(this.iconColor != null && this.iconeTextColor != null) {
            this.iconColor.addEventListener('change', this.changeIconsColor.bind(this), false);
            this.iconeTextColor.addEventListener('change', this.changeIconsTextColor.bind(this), false);
        }
    },

    changeIconsColor: function(event) {
        var value = Event.element(event).value;
        this.changeColor(value);
    },

    changeIconsTextColor: function(event) {
        var value = Event.element(event).value;
        this.changeTextColor(value);
    },

    changeColor: function(value) {
        var css = this.iconSpans + ' { background: '+value+'; } ' +
            this.iconsHover + ' {color: '+value+'; box-shadow: 0 0 0 2px '+value+'; } ' +
            this.selectedIcons + ' { color: '+value+'; box-shadow: 0 0 0 2px '+value+'; }';
        this.createStyleSheet(css);
    },

    changeTextColor: function(value) {
        var css = this.defIcons + ' { color: '+value+'; } ' +
            this.iconsHover + ' {background: '+value+'; } ' +
            this.selectedIcons + ' { background: '+value+'; }';
        this.createStyleSheet(css);
    },

    createStyleSheet: function(css) {
        var head = document.head || document.getElementsByTagName('head')[0];
        var style = document.createElement('style');
        style.type = 'text/css';

        if (style.styleSheet){
            style.styleSheet.cssText = css;
        } else {
            style.appendChild(document.createTextNode(css));
        }

        head.appendChild(style);
    }
});