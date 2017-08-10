jQuery("document").ready(function () {
/*
|--------------------------------------
|    History page
|--------------------------------------    
 */
//  Change the background of sliders arrow
    jQuery("a.left").hover(function () {
        jQuery(this).children(":first").css("background-color", "#000");
    }, function () {
        jQuery(this).children(":first").css("background-color", "transparent");
    });

    jQuery("a.right").hover(function () {
        jQuery(this).children(":first").css("background-color", "#000");
    }, function () {
        jQuery(this).children(":first").css("background-color", "transparent");
    });
});
