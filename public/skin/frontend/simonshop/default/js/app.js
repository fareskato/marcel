var bp={xsmall:479,small:599,medium:770,large:979,xlarge:1199};Varien.searchForm.prototype.initialize=function(e,t,i){this.form=$(e),this.field=$(t),this.emptyText=i,Event.observe(this.form,"submit",this.submit.bind(this)),Event.observe(this.field,"change",this.change.bind(this)),Event.observe(this.field,"focus",this.focus.bind(this)),Event.observe(this.field,"blur",this.blur.bind(this)),this.blur()},Varien.searchForm.prototype.submit=function(e){return this.field.value==this.emptyText||""==this.field.value?(Event.stop(e),this.field.addClassName("validation-failed"),this.field.focus(),!1):!0},Varien.searchForm.prototype.change=function(){this.field.value!=this.emptyText&&""!=this.field.value&&this.field.hasClassName("validation-failed")&&this.field.removeClassName("validation-failed")},Varien.searchForm.prototype.blur=function(){this.field.hasClassName("validation-failed")&&this.field.removeClassName("validation-failed")};var PointerManager={MOUSE_POINTER_TYPE:"mouse",TOUCH_POINTER_TYPE:"touch",POINTER_EVENT_TIMEOUT_MS:500,standardTouch:!1,touchDetectionEvent:null,lastTouchType:null,pointerTimeout:null,pointerEventLock:!1,getPointerEventsSupported:function(){return this.standardTouch},getPointerEventsInputTypes:function(){return window.navigator.pointerEnabled?{MOUSE:"mouse",TOUCH:"touch",PEN:"pen"}:window.navigator.msPointerEnabled?{MOUSE:4,TOUCH:2,PEN:3}:{}},getPointer:function(){return Modernizr.ios?this.TOUCH_POINTER_TYPE:this.lastTouchType?this.lastTouchType:Modernizr.touch?this.TOUCH_POINTER_TYPE:this.MOUSE_POINTER_TYPE},setPointerEventLock:function(){this.pointerEventLock=!0},clearPointerEventLock:function(){this.pointerEventLock=!1},setPointerEventLockTimeout:function(){var e=this;this.pointerTimeout&&clearTimeout(this.pointerTimeout),this.setPointerEventLock(),this.pointerTimeout=setTimeout(function(){e.clearPointerEventLock()},this.POINTER_EVENT_TIMEOUT_MS)},triggerMouseEvent:function(e){this.lastTouchType!=this.MOUSE_POINTER_TYPE&&(this.lastTouchType=this.MOUSE_POINTER_TYPE,jQuery(window).trigger("mouse-detected",e))},triggerTouchEvent:function(e){this.lastTouchType!=this.TOUCH_POINTER_TYPE&&(this.lastTouchType=this.TOUCH_POINTER_TYPE,jQuery(window).trigger("touch-detected",e))},initEnv:function(){window.navigator.pointerEnabled?(this.standardTouch=!0,this.touchDetectionEvent="pointermove"):window.navigator.msPointerEnabled?(this.standardTouch=!0,this.touchDetectionEvent="MSPointerMove"):this.touchDetectionEvent="touchstart"},wirePointerDetection:function(){var e=this;this.standardTouch?jQuery(window).on(this.touchDetectionEvent,function(t){switch(t.originalEvent.pointerType){case e.getPointerEventsInputTypes().MOUSE:e.triggerMouseEvent(t);break;case e.getPointerEventsInputTypes().TOUCH:case e.getPointerEventsInputTypes().PEN:e.triggerTouchEvent(t)}}):(jQuery(window).on(this.touchDetectionEvent,function(t){e.pointerEventLock||(e.setPointerEventLockTimeout(),e.triggerTouchEvent(t))}),jQuery(document).on("mouseover",function(t){e.pointerEventLock||(e.setPointerEventLockTimeout(),e.triggerMouseEvent(t))}))},init:function(){this.initEnv(),this.wirePointerDetection()}},MenuManager={mouseEnterEventObserved:!1,touchEventOrderIncorrect:!1,cancelNextTouch:!1,TouchScroll:{TOUCH_SCROLL_THRESHOLD:20,touchStartPosition:null,reset:function(){this.touchStartPosition=jQuery(window).scrollTop()},shouldCancelTouch:function(){if(null==this.touchStartPosition)return!1;var e=jQuery(window).scrollTop()-this.touchStartPosition;return Math.abs(e)>this.TOUCH_SCROLL_THRESHOLD}},useSmallScreenBehavior:function(){return Modernizr.mq("screen and (max-width:"+bp.medium+"px)")},toggleMenuVisibility:function(e){var t=jQuery(e),i=t.closest("li");this.useSmallScreenBehavior()||(i.siblings().removeClass("menu-active").find("li").removeClass("menu-active"),i.find("li.menu-active").removeClass("menu-active")),i.toggleClass("menu-active")},init:function(){this.wirePointerEvents()},wirePointerEvents:function(){var e=this,t=jQuery("#nav a.has-children"),i=jQuery("#nav li");if(PointerManager.getPointerEventsSupported()){var n=window.navigator.pointerEnabled?"pointerenter":"mouseenter",r=window.navigator.pointerEnabled?"pointerleave":"mouseleave",o=window.navigator.pointerEnabled;i.on(n,function(t){(void 0===t.originalEvent.pointerType||t.originalEvent.pointerType==PointerManager.getPointerEventsInputTypes().MOUSE)&&(o?e.mouseEnterAction(t,this):e.PartialPointerEventsSupport.mouseEnterAction(t,this))}).on(r,function(t){(void 0===t.originalEvent.pointerType||t.originalEvent.pointerType==PointerManager.getPointerEventsInputTypes().MOUSE)&&(o?e.mouseLeaveAction(t,this):e.PartialPointerEventsSupport.mouseLeaveAction(t,this))}),o||t.on("MSPointerDown",function(e){jQuery(this).data("pointer-type",e.originalEvent.pointerType)}),t.on("click",function(t){var i=o?t.originalEvent.pointerType:jQuery(this).data("pointer-type");void 0===i||i==PointerManager.getPointerEventsInputTypes().MOUSE?e.mouseClickAction(t,this):o?e.touchAction(t,this):e.PartialPointerEventsSupport.touchAction(t,this),jQuery(this).removeData("pointer-type")})}else i.on("mouseenter",function(t){e.mouseEnterEventObserved=!0,e.cancelNextTouch=!0,e.mouseEnterAction(t,this)}).on("mouseleave",function(t){e.mouseLeaveAction(t,this)}),jQuery(window).on("touchstart",function(){e.mouseEnterEventObserved&&(e.touchEventOrderIncorrect=!0,e.mouseEnterEventObserved=!1),e.TouchScroll.reset()}),t.on("touchend",function(t){jQuery(this).data("was-touch",!0),t.preventDefault(),e.TouchScroll.shouldCancelTouch()||(e.touchEventOrderIncorrect?e.PartialTouchEventsSupport.touchAction(t,this):e.touchAction(t,this))}).on("click",function(t){return jQuery(this).data("was-touch")?void t.preventDefault():void e.mouseClickAction(t,this)})},PartialPointerEventsSupport:{mouseleaveLock:0,mouseEnterAction:function(e,t){if(MenuManager.useSmallScreenBehavior())return void MenuManager.mouseEnterAction(e,t);e.stopPropagation();var i=jQuery(t);i.hasClass("level0")||(this.mouseleaveLock=i.parents("li").length+1),MenuManager.toggleMenuVisibility(t)},mouseLeaveAction:function(e,t){return MenuManager.useSmallScreenBehavior()?void MenuManager.mouseLeaveAction(e,t):this.mouseleaveLock>0?void this.mouseleaveLock--:void jQuery(t).removeClass("menu-active")},touchAction:function(e,t){return MenuManager.useSmallScreenBehavior()?void MenuManager.touchAction(e,t):(e.preventDefault(),void this.mouseleaveLock++)}},PartialTouchEventsSupport:{touchAction:function(e,t){return MenuManager.cancelNextTouch?void(MenuManager.cancelNextTouch=!1):void MenuManager.toggleMenuVisibility(t)}},mouseEnterAction:function(e,t){this.useSmallScreenBehavior()||jQuery(t).addClass("menu-active")},mouseLeaveAction:function(e,t){this.useSmallScreenBehavior()||jQuery(t).removeClass("menu-active")},mouseClickAction:function(e,t){this.useSmallScreenBehavior()&&(e.preventDefault(),this.toggleMenuVisibility(t))},touchAction:function(e,t){this.toggleMenuVisibility(t),e.preventDefault()}};jQuery(document).ready(function(){function e(){var e=jQuery(window).width();jQuery("ul.level0").each(function(){var t=jQuery(this);t.addClass("position-test"),t.removeClass("spill");var i=t.outerWidth(),n=t.offset().left;t.removeClass("position-test"),n+i>e&&t.addClass("spill")})}jQuery(window),jQuery(document),jQuery("body");Modernizr.addTest("ios",function(){return navigator.userAgent.match(/(iPad|iPhone|iPod)/g)}),PointerManager.init(),jQuery(".change").click(function(e){jQuery(this).toggleClass("active"),e.stopPropagation()}),jQuery(document).click(function(e){jQuery(e.target).hasClass(".change")||jQuery(".change").removeClass("active")});var t=jQuery(".skip-content"),i=jQuery(".skip-link");i.on("click",function(e){e.preventDefault();var n=jQuery(this),r=n.attr(n.attr("data-target-element")?"data-target-element":"href"),o=jQuery(r),a=o.hasClass("skip-active")?1:0;i.removeClass("skip-active"),t.removeClass("skip-active"),a?n.removeClass("skip-active"):(n.addClass("skip-active"),o.addClass("skip-active"))}),jQuery("#header-cart").on("click",".skip-link-close",function(e){var t=jQuery(this).parents(".skip-content"),i=t.siblings(".skip-link");t.removeClass("skip-active"),i.removeClass("skip-active"),e.preventDefault()}),MenuManager.init(),e(),jQuery(window).on("delayed-resize",e),enquire.register("(max-width: "+bp.medium+"px)",{match:function(){jQuery(".page-header-container .store-language-container").prepend(jQuery(".form-language"))},unmatch:function(){jQuery(".header-language-container .store-language-container").prepend(jQuery(".form-language"))}}),enquire.register("screen and (min-width: "+(bp.medium+1)+"px)",{match:function(){jQuery(".menu-active").removeClass("menu-active"),jQuery(".sub-menu-active").removeClass("sub-menu-active"),jQuery(".skip-active").removeClass("skip-active")},unmatch:function(){jQuery(".menu-active").removeClass("menu-active"),jQuery(".sub-menu-active").removeClass("sub-menu-active"),jQuery(".skip-active").removeClass("skip-active")}});var n=jQuery(".media-list").find("a"),r=jQuery(".primary-image").find("img");if(n.length&&n.on("click",function(e){e.preventDefault();var t=jQuery(this);r.attr("src",t.attr("href"))}),jQuery.fn.toggleSingle=function(e){var t=jQuery.extend({destruct:!1},e);return this.each(function(){t.destruct?(jQuery(this).off("click"),jQuery(this).removeClass("active").next().removeClass("no-display")):(jQuery(this).on("click",function(){jQuery(this).toggleClass("active").next().toggleClass("no-display")}),jQuery(this).next().addClass("no-display"))})},jQuery(".toggle-content").each(function(){function e(e,t){var i,n=t.index(e);for(i=0;i<s.length;i++)s[i].removeClass("current"),s[i].eq(n).addClass("current")}var t=jQuery(this),i=t.hasClass("tabs"),n=(t.hasClass("accordion"),t.hasClass("open")),r=t.children("dl:first"),o=r.children("dt"),a=r.children("dd"),s=new Array(o,a);if(i){var u=jQuery('<ul class="toggle-tabs"></ul>');o.each(function(){var e=jQuery(this),t=jQuery("<li></li>");t.html(e.html()),u.append(t)}),u.insertBefore(r);var c=u.children();s.push(c)}var l;for(l=0;l<s.length;l++)s[l].filter(":last").addClass("last");o.on("click",function(){jQuery(this).hasClass("current")&&t.hasClass("accordion-open")?t.removeClass("accordion-open"):t.addClass("accordion-open"),e(jQuery(this),o)}),i&&(c.on("click",function(){e(jQuery(this),c)}),c.eq(0).trigger("click")),n&&o.eq(0).trigger("click")}),jQuery(".col-left-first > .block").length&&jQuery(".category-products").length&&enquire.register("screen and (max-width: "+bp.medium+"px)",{match:function(){jQuery(".col-left-first").insertBefore(jQuery(".category-products"))},unmatch:function(){jQuery(".col-left-first").insertBefore(jQuery(".col-main"))}}),jQuery(".main-container.col3-layout").length>0&&enquire.register("screen and (max-width: 1000px)",{match:function(){var e=jQuery(".col-right"),t=jQuery(".col-wrapper");e.appendTo(t)},unmatch:function(){var e=jQuery(".col-right"),t=jQuery(".main");e.appendTo(t)}}),enquire.register("(max-width: "+bp.medium+"px)",{setup:function(){this.toggleElements=jQuery(".col-left-first .block:not(.block-layered-nav) .block-title, .col-left-first .block-layered-nav .block-subtitle--filter, .sidebar:not(.col-left-first) .block .block-title")},match:function(){this.toggleElements.toggleSingle()},unmatch:function(){this.toggleElements.toggleSingle({destruct:!0})}}),jQuery("body.checkout-onepage-index").length&&enquire.register("(max-width: "+bp.large+"px)",{match:function(){jQuery("#checkout-step-review").prepend(jQuery("#checkout-progress-wrapper"))},unmatch:function(){jQuery(".col-right").prepend(jQuery("#checkout-progress-wrapper"))}}),jQuery("body.checkout-cart-index").length&&jQuery('input[name^="cart"]').focus(function(){jQuery(this).siblings("button").fadeIn()}),jQuery(".a-left").length&&enquire.register("(max-width: "+bp.large+"px)",{match:function(){jQuery(".gift-info").each(function(){jQuery(this).next("td").children("textarea").appendTo(this).children()})},unmatch:function(){jQuery(".left-note").each(function(){jQuery(this).prev("td").children("textarea").appendTo(this).children()})}}),jQuery(".products-grid").length){var o=function(){jQuery(".products-grid").each(function(){var e=[],t=[];productGridElements=jQuery(this).children("li"),productGridElements.each(function(i){"none"!=jQuery(this).css("clear")&&0!=i&&(e.push(t),t=[]),t.push(this),productGridElements.length==i+1&&e.push(t)}),jQuery.each(e,function(){var e=0;jQuery.each(this,function(){jQuery(this).find(".product-info").css({"min-height":"","padding-bottom":""});var t=jQuery(this).find(".product-info").height(),i=10,n=jQuery(this).find(".product-info .actions").height(),r=t+i+n;r>e&&(e=r),jQuery(this).find(".product-info").css("padding-bottom",n+"px")}),jQuery.each(this,function(){jQuery(this).find(".product-info").css("min-height",e)})})})};o(),jQuery(window).on("delayed-resize",function(){o()})}var a;jQuery(window).resize(function(e){clearTimeout(a),a=setTimeout(function(){jQuery(window).trigger("delayed-resize",e)},250)})});var ProductMediaManager={IMAGE_ZOOM_THRESHOLD:20,imageWrapper:null,destroyZoom:function(){jQuery(".zoomContainer").remove(),jQuery(".product-image-gallery .gallery-image").removeData("elevateZoom")},createZoom:function(e){if(ProductMediaManager.destroyZoom(),!(PointerManager.getPointer()==PointerManager.TOUCH_POINTER_TYPE||Modernizr.mq("screen and (max-width:"+bp.medium+"px)")||e.length<=0)){if(e[0].naturalWidth&&e[0].naturalHeight){var t=e[0].naturalWidth-e.width()-ProductMediaManager.IMAGE_ZOOM_THRESHOLD,i=e[0].naturalHeight-e.height()-ProductMediaManager.IMAGE_ZOOM_THRESHOLD;if(0>t&&0>i)return void e.parents(".product-image").removeClass("zoom-available");e.parents(".product-image").addClass("zoom-available")}e.elevateZoom()}},swapImage:function(e){e=jQuery(e),e.addClass("gallery-image"),ProductMediaManager.destroyZoom();var t=jQuery(".product-image-gallery");e[0].complete?(t.find(".gallery-image").removeClass("visible"),t.append(e),e.addClass("visible"),ProductMediaManager.createZoom(e)):(t.addClass("loading"),t.append(e),imagesLoaded(e,function(){t.removeClass("loading"),t.find(".gallery-image").removeClass("visible"),e.addClass("visible"),ProductMediaManager.createZoom(e)}))},wireThumbnails:function(){jQuery(".product-image-thumbs .thumb-link").click(function(e){e.preventDefault();var t=jQuery(this),i=jQuery("#image-"+t.data("image-index"));ProductMediaManager.swapImage(i)})},initZoom:function(){ProductMediaManager.createZoom(jQuery(".gallery-image.visible"))},init:function(){ProductMediaManager.imageWrapper=jQuery(".product-img-box"),jQuery(window).on("delayed-resize",function(){ProductMediaManager.initZoom()}),ProductMediaManager.initZoom(),ProductMediaManager.wireThumbnails(),jQuery(document).trigger("product-media-loaded",ProductMediaManager)}};jQuery(document).ready(function(){ProductMediaManager.init()});