
/**
 * Visualize Your Attributes - Color Swatch
 *
 * @category:    AdjustWare
 * @package:     AdjustWare_Icon
 * @version      3.1.15
 * @license:     n/a
 * @copyright:   Copyright (c) 2015 AITOC, Inc. (http://www.aitoc.com)
 */
Product.Config.prototype._init = Product.Config.prototype.initialize;
Product.Config.prototype.initialize = function (config) {
    this._init(config);
    for(var i=this.settings.length-1;i>=0;i--) {
        var attributeId = this.settings[i].id.replace(/[a-z]*/, '');
        if(typeof adjConfig.attributes[attributeId] != 'undefined' && adjConfig.attributes[attributeId].show_images_configurable == "1") {
            if(adjConfig.attributes[attributeId].config_option_type == "2") {
                this.settings[i].style.display = 'none';
            }
            this.adjfillSelectIcons(this.settings[i]);
            if (i != 0){
                $$('.adjicon_icon_config').each(function(el) {
                    this.addAdjDisabledClass(el);
                }.bind(this))
            }
            this.addAdjIconListeners();
        }
    }
    this.createAdjProductPrice();
};

Product.Config.prototype.createAdjProductPrice = function () {
    $$('.product-options dt label').each(function(el) {
        var span = new Element('span', {
            class : 'adjprice'
        });
        Element.insert(el, {after: span});
    })
};

Product.Config.prototype.updateAdjProductPrice = function (event) {
    if (Event.element(event).tagName == 'SELECT' ) {
        var select = event.currentTarget;
        var option_id = select.value;
        if (!parseInt(option_id)) {
            option_id = -1;
            var price = '';
        }
    } else {
        var icon = event.currentTarget;
        var option_id = icon.getAttribute('id');
        var select = icon.up('div.input-box').down('select.super-attribute-select');
    }
    var options = select.options;
    for(var i=0; i<options.length; i++) {
        if(options[i].getAttribute('value') == option_id) {
            var price = options[i].getInnerText();
        }
    }
    var adjprice = select.up('dd').previous('dt').down('label + span.adjprice');
    adjprice.innerHTML = price;

};

Product.Config.prototype.removeAdjProductPrice = function (event) {
    var adjprice = event.currentTarget.up('dd').previous('dt').down('label + span.adjprice');
    adjprice.innerHTML = '';
};

Product.Config.prototype.addAdjIconListeners = function() {
    $$('.adjicon_icon_config.adjdef, .adjimage.adjdef').each(function(elem) {
        elem.observe('click', this.updateAdjProductPrice.bind(this));
        elem.observe('click', this.updateAdjProductImages.bind(this));
        elem.observe('click', this.manageAdjSelectDisplay.bind(this));
    }.bind(this));
    this.settings.each(function(elem) {
        elem.observe('change', this.updateAdjProductImages.bind(this));
//        elem.observe('click', this.removeAdjProductPrice.bind(this));
        elem.observe('change', this.manageAdjIconsDisplay.bind(this));
        elem.observe('change', this.updateAdjProductPrice.bind(this));
    }.bind(this));
};

Product.Config.prototype._configureForValues = Product.Config.prototype.configureForValues;
Product.Config.prototype.configureForValues = function() {
    this._configureForValues();
    if (this.values) {
        this.settings.each(function(element){
            var attributeId = element.attributeId;
            if(typeof this.values[attributeId] != 'undefined') {
                $$('.adjicon_icon_config').each(function(el) {
                    if(el.nextElementSibling.value == this.values[attributeId]) {
                        this.addAdjSelectedClass(el);
                        this.updateAdjProductBaseImage(this.values[attributeId]);
                        this.updateAdjProductMoreViews(this.values[attributeId]);
                    }
                }.bind(this));
            }
        }.bind(this));
    }
};

Product.Config.prototype.adjfillSelectIcons = function (element) {
    var attributeId = element.id.replace(/[a-z]*/, '');
    var options = this.getAttributeOptions(attributeId);

    var advice = new Element('div', {
        id: attributeId+"_advice"
    })

    for(var i=options.length-1;i>=0;i--){
        var li = $(document.createElement('LI'));
        var input = new Element('input', {
            type: 'checkbox',
            class: 'adjicon_input_config',
            name: "super_attribute["+attributeId+"]",
            id: "attribute"+attributeId+"["+options[i].id+"]",
            value: options[i].id,
            style: "display:none"
        });

        var link = new Element('a', {
            id: options[i].id,
            className: 'adjicon_icon_config adjdef'
        });

        switch(adjConfig.attributes[attributeId].visualization_type) {
            case "2":
                var img = new Element('img', {
                    alt: options[i].label,
                    title: options[i].label,
                    src: adjConfig.media_url+'icons/o_'+adjConfig.attributes[attributeId].options[options[i].id].icon
                });
                link.addClassName('adjimage');
                link.appendChild(img);
                break;
            case "1":
                if(adjConfig.attributes[attributeId].options[options[i].id].color != null) {
                    link.setAttribute('title', options[i].label);
                    link.addClassName('adjcolor'+adjConfig.attributes[attributeId].color_icon_type+' adjoption');
                    link.setStyle({backgroundColor: adjConfig.attributes[attributeId].options[options[i].id].color})
                }
                break;
            case "3":
                link.addClassName('icon'+adjConfig.attributes[attributeId].icon_type+' adjoption');
                link.addClassName('icons-' + adjConfig.attributes[attributeId].icon_id);
                var span = new Element('span');
                link.innerHTML = '<span></span>'+options[i].label;
                break;
            default:
                break;
        }

        li.appendChild(link);
        li.appendChild(input);
        Element.insert(element, {after: li});
    }
    element.up('.input-box').insert(advice);
};



Product.Config.prototype._resetChildren = Product.Config.prototype.resetChildren;
Product.Config.prototype.resetChildren = function (element) {
    if(!element.value) {
        this._resetChildren(element);
    }
    if(element.childSettings) {
        for(var i=0;i<element.childSettings.length;i++){
            var icons = element.childSettings[i].nextSiblings();
            icons.each(function(icon) {
                if(icon.tagName == 'LI') {
                    this.addAdjDisabledClass(icon.children[0]);
                }
            }.bind(this))
            var adjprice = element.childSettings[i].up('dd').previous('dt').down('label + span.adjprice');
            if(typeof adjprice !== 'undefined') {
                adjprice.innerHTML = '';
            }
        }
    }
};

Product.Config.prototype.manageAdjIconsDisplay = function(event){
    var select = event.currentTarget;
    var id = select.value;
    var icons = select.up('div.input-box').select('li a');
    this.resetChildren(select);
    if(select.value) {
        icons.each(function(icon) {
            if(icon.getAttribute('id') == id) {
                this.addAdjSelectedClass(icon);
            }
            else {
                if(icon.hasClassName('adjselected')) {
                    this.addAdjDefaultClass(icon);
                }
            }
        }.bind(this));

        this.configureElement(select);

        if(select.nextSetting) {
            for(var i=0; i<select.nextSetting.options.length; i++) {
                if(select.nextSetting.options[i].value) {
                    var childIcon = $(select.nextSetting.options[i].value);
                    if(childIcon) {
                        this.addAdjDefaultClass(childIcon);
                    }
                }
            }
            this.resetChildren(select.nextSetting);
        }
    }
    else {
        icons.each(function(link) {
            if(link.hasClassName('adjselected')) {
                this.addAdjDefaultClass(link);
            }
        }.bind(this))

        this.resetChildren(select);
    }
};

Product.Config.prototype.manageAdjSelectDisplay = function(event){
    var icon = event.currentTarget;
    var select = icon.up('div.input-box').down('select.super-attribute-select');
    var options = select.select('option');
    var icons = icon.up('div.input-box').select('li a');
    this.resetChildren(select);
    icons.each(function(link) {
        if(link == icon) {
            this.addAdjSelectedClass(link);
        }
        else {
            if(link.hasClassName('adjselected')) {
                this.addAdjDefaultClass(link);
            }
        }
    }.bind(this))

    options.each(function(option) {
        if(parseInt(option.getAttribute('value')) == parseInt(icon.getAttribute('id'))) {
            option.selected = true;
            this.configureElement(select);
        }
    }.bind(this))

    if(select.nextSetting){
        for(var i=0; i<select.nextSetting.options.length; i++) {
            if(select.nextSetting.options[i].value) {
                var childIcon = $(select.nextSetting.options[i].value);
                if(childIcon) {
                    this.addAdjDefaultClass(childIcon);
                }
            }
        }
        this.resetChildren(select.nextSetting);
    }
};

Product.Config.prototype.addAdjSelectedClass = function(element){
    if(element.hasClassName('adjdef')) {
        element.removeClassName('adjdef');
    }
    element.addClassName('adjselected');
    element.nextElementSibling.checked = true;
    element.stopObserving();
};

Product.Config.prototype.addAdjDefaultClass = function(element){
    if(element.hasClassName('adjselected')) {
        element.removeClassName('adjselected');
    }
    if(element.hasClassName('adjdisabled')) {
        element.removeClassName('adjdisabled');
    }
    element.addClassName('adjdef');
    element.nextElementSibling.checked = false;
    element.observe('click', this.updateAdjProductPrice.bind(this));
    element.observe('click', this.updateAdjProductImages.bind(this));
    element.observe('click', this.manageAdjSelectDisplay.bind(this));
};

Product.Config.prototype.addAdjDisabledClass = function(element){
    if(element.hasClassName('adjselected')) {
        element.removeClassName('adjselected');
    }
    if(element.hasClassName('adjdef')) {
        element.removeClassName('adjdef');
    }
    element.addClassName('adjdisabled');
    element.nextElementSibling.checked = false;
    element.stopObserving();
};

Object.extend(Validation, {
    isVisible : function(elm) {
        while(elm.tagName != 'BODY') {
            if(elm.hasClassName('adjicon_input_config')) return true;
            if(!$(elm).visible()) return false;
            elm = elm.parentNode;
        }
        return true;
    }
})


Product.ConfigurableSwatches = function()
{
    return null;
}