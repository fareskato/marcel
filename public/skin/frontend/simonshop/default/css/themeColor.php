<?php
	define('MAGENTO_ROOT', (dirname(__FILE__).'../../../../../../'));
	$mageFilename = MAGENTO_ROOT . '/app/Mage.php';
	require_once $mageFilename;
	umask(0);
	Mage::app();
	
	header("Content-type: text/css; charset: UTF-8");
	$CurrentStoreId =Mage::app()->getRequest()->getParam('p');
	$config = Mage::getStoreConfig('mdloption',$CurrentStoreId);
	$color_helper = Mage::helper('mdloption/color');
?>

<?php if ( $config['genral_theme_setting']['page-width'] ) : ?>
.container
{max-width:<?php echo $config['genral_theme_setting']['page-width']; ?>px;}
<?php endif; ?>


<?php if($config['genral_theme_setting']['enable_font'] ) : ?>
html body, body input, body select, body textarea, h1, h2, h3, h4, h5, h6{font-family:"<?php echo $config['genral_theme_setting']['font']; ?>"} 
<?php endif; ?>

<?php if ( $config['genral_theme_setting']['font_size'] ) : ?>
body, input, select, textarea{font-size:<?php echo $config['genral_theme_setting']['font_size']; ?>px;}
<?php endif; ?>


/*color-settings*/
<?php
	$config = Mage::getStoreConfig('mdloptioncolor',$CurrentStoreId);
	$color_helper = Mage::helper('mdloptioncolor/color');
?>

<?php if ( $config['genral_theme_setting']['theme-color-option'] ) : ?>
	
    <?php if ( $config['genral_theme_setting']['body_bg_color'] ) : ?>
	
    {
    	background-color:<?php echo $config['genral_theme_setting']['body_bg_color']; ?>;
     }
    <?php endif; ?>
    
	<?php if ( $config['genral_theme_setting']['color'] ) : //General Theme Color ?>
	ul#nav li.level0 > a:hover::before, #prevslide, #nextslide,
	.secView .add-cart:hover, .secView a.add-cart:hover, .secView .w-btn:hover,
	.fot-wrapper, .fob-wrapper,
	.block-title h1:before, .block-title h2:before, .block-title strong:before, .page-title h1:before,
	.direction,button.button span, .copyrightBox
    {
    	background-color:<?php echo $config['genral_theme_setting']['color']; ?>;
    }
    
   .header-containe .fa, .w-btn .fa,
   .header-container .fa
    {
    	color:<?php echo $config['genral_theme_setting']['color']; ?>;
    }
    
    ul#nav li.level0 > a:hover:before, ul#nav li.level0.over > a:before, ul#nav li.level0.active > a:before, .tpm-inner, .block-title h1::before, .block-title h2:before, .block-title strong:before, .proImage .qv-btn, .direction, .page-title h1:before,
	.secView .add-cart, .secView a.add-cart, .secView .w-btn, .input-newsletter, .newsletterBox .msg-block
    {
    	border-color:<?php echo $config['genral_theme_setting']['color']; ?>;
    }
    
    .block-title,.page-title,
	.bestselling-title h2 span.active a, .bestselling-title h2 span a:hover,
    .toolbar .sorter,
    .block-cart .remain_cart:before,
	.product-view .product-shop .product-name
    {
   	 border-bottom-color:<?php echo $config['genral_theme_setting']['color']; ?>;
    }
    
    .buttons-set
    {
   	 border-top-color:<?php echo $config['genral_theme_setting']['color']; ?>;
    }
    
    <?php endif; ?>
    
    
    
    /*body font*/
    <?php if ( $config['genral_theme_setting']['body_font_color'] ) : ?>
    body{color:<?php echo $config['genral_theme_setting']['body_font_color']; ?>;}
    <?php endif; ?>
    
    /*body anchore color*/
    <?php if ( $config['genral_theme_setting']['anchor_color'] ) : ?>
     body a, a{color:<?php echo $config['genral_theme_setting']['anchor_color']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['genral_theme_setting']['anchor_hover'] ) : ?>
    body a:hover, a:hover{color:<?php echo $config['genral_theme_setting']['anchor_hover']; ?>;}
    <?php endif; ?>
    
    /*breadcrumb*/
    <?php if ( $config['genral_theme_setting']['breadcrumbs_anchore'] ) : ?>
    .breadcrumbs li a{color:<?php echo $config['genral_theme_setting']['breadcrumbs_anchore']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['genral_theme_setting']['breadcrumbs_text'] ) : ?>
    .breadcrumbs li strong{color:<?php echo $config['genral_theme_setting']['breadcrumbs_text']; ?>;}
    <?php endif; ?>
    
    /*block heading*/
    <?php if ( $config['genral_theme_setting']['block_heading_color'] ) : ?>
    .page-title h1 span, .block-title strong span, .page-title h2 span, .block-title h2 span,
	.newsletterBox h3
	{color:<?php echo $config['genral_theme_setting']['block_heading_color']; ?>;}
    <?php endif; ?>
    
	
	
    /*new sele*/
    <?php if ( $config['genral_theme_setting']['new_batch'] ) : ?>
	   .badge span.new{border-color:<?php echo $config['genral_theme_setting']['new_batch']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['genral_theme_setting']['new_batch_color'] ) : ?>
    .badge span.new{color:<?php echo $config['genral_theme_setting']['new_batch_color']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['genral_theme_setting']['sale_batch'] ) : ?>
    .badge span.sale{border-color:<?php echo $config['genral_theme_setting']['sale_batch']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['genral_theme_setting']['sale_batch_color'] ) : ?>
    .badge span.sale{color:<?php echo $config['genral_theme_setting']['sale_batch_color']; ?>;}
    <?php endif; ?>
    
<?php endif; ?>	



/*Header color*/
<?php if ( $config['header_color_setting']['theme-color-option'] ) : ?>

	<?php if ( $config['header_color_setting']['header_bg'] ) : ?>
    .header-top{background-color:<?php echo $config['header_color_setting']['header_bg']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['header_color_setting']['header_top_text'] ) : ?>
    .language-switcher label, .header_currency label, .compare_pan label,
    .header3 .language-switcher label, .header3 .header_currency label, .header3 .compare_pan label,
    .language-switcher .select_lang span, .header_currency .currency_pan span, .compare_pan span,
    .header3 .language-switcher .select_lang span, .header3 .header_currency .currency_pan span, .header3 .compare_pan span,
    .language-switcher .fa, .header_currency .fa, .compare_pan .fa,
    .header3 .language-switcher .fa, .header3 .header_currency .fa, .header3 .compare_pan .fa,
    .header-compare a.ancomp, .header3 .header-compare a.ancomp,
    .header-wrapper03 .links li a,
    .header2 .links li a,
    .header-container .welcome-msg,
    .header-wrapper01 .header-top .header-social-links li a
    {color:<?php echo $config['header_color_setting']['header_top_text']; ?>;}
    <?php endif; ?>
    
     <?php if ( $config['header_color_setting']['header_top_anchore'] ) : ?>
    .header-top li a, .header-top a
    {color:<?php echo $config['header_color_setting']['header_top_anchore']; ?>;}
    <?php endif; ?>
    
    
    <?php if ( $config['header_color_setting']['header_top_anchore_hover'] ) : ?>
    .header-top li a:hover, .header-top a:hover{color:<?php echo $config['header_color_setting']['header_top_anchore_hover']; ?>;}
    <?php endif; ?>
    
    
    
<?php endif; ?>	

/*Navigation color*/
<?php if ( $config['navsettings']['theme-color-option'] ) : ?>

	<?php if ( $config['navsettings']['mainTextColor'] ) : ?>
    	ul#nav li.level0 > a,
        .header3 ul#nav li.level0 > a{color:<?php echo $config['navsettings']['mainTextColor']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['navsettings']['mainTextHoverColor'] ) : ?>
    	 ul#nav li.level0 > a:hover,
        .header3 ul#nav li.level0 > a:hover, 
        .header3.cms-index-index ul#nav li.home.level0 > a, 
        .header3 ul#nav li.level0.active > a, 
        .header3 ul#nav li.level0.over > a, 
        .cms-index-index ul#nav li.home.level0 > a, 
        ul#nav li.level0.active > a, 
        ul#nav li.level0.over > a
        {color:<?php echo $config['navsettings']['mainTextHoverColor']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['navsettings']['manimenubordercolor'] ) : ?>
    	ul#nav li.level0 > a:hover:before, ul#nav li.level0.over > a:before, ul#nav li.level0.active > a:before
        {background-color:<?php echo $config['navsettings']['manimenubordercolor']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['navsettings']['submenubg'] ) : ?>
    	ul#nav li.level0.megamenu > .pump, 
        ul#nav li.level0 > .pump, 
        ul.dmenu ul, 
        ul#nav li.level0 ul.level0 .pump, 
        ul#nav li.level0.megamenu li.level2 .pump, 
        .nav-container ul#nav.level0 ul, .nav-container .level0 .pump,
        ul.dmenu ul ul{background-color:<?php echo $config['navsettings']['submenubg']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['navsettings']['submenubgH'] ) : ?>
    	ul#nav li.level0.megamenu ul.level0 > li > a{color:<?php echo $config['navsettings']['submenubgH']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['navsettings']['submenutext'] ) : ?>
    	ul#nav li.level0 ul.level0 li a{color:<?php echo $config['navsettings']['submenutext']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['navsettings']['submenutexthover'] ) : ?>
    	ul#nav li.level0 ul.level0 li a:hover, 
    	ul#nav li.level0 ul.level0 li.over > a
        {color:<?php echo $config['navsettings']['submenutexthover']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['navsettings']['headerfixbg'] ) : ?>
    	.hideTopNav .nav-wrapper, .hideTopNav .nav-wrapper,
        .hideTopNav .nav-container .mobMenu h1
        {background-color:<?php echo $config['navsettings']['headerfixbg']; ?>;}
    <?php endif; ?>
    
<?php endif; ?>	

/*Mobile navigation color*/
<?php if ( $config['navsettingMob']['theme-color-option'] ) : ?>

	<?php if ( $config['navsettingMob']['mainMobbg'] ) : ?>
    	.nav-container .mobMenu h1{background-color:<?php echo $config['navsettingMob']['mainMobbg']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['navsettingMob']['mainMobcolor'] ) : ?>
    	.mobMenu h1 span{color:<?php echo $config['navsettingMob']['mainMobcolor']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['navsettingMob']['buttonscolor'] ) : ?>
    	.nav-container .mobMenu h1 a .fa{color:<?php echo $config['navsettingMob']['buttonscolor']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['navsettingMob']['mainmenuBg'] ) : ?>
    	.mobMenu .accordion li a{background-color:<?php echo $config['navsettingMob']['mainmenuBg']; ?>;}
    <?php endif; ?>
	
	<?php if ( $config['navsettingMob']['mainmenuBghover'] ) : ?>
    	.mobMenu .accordion li a:hover{background-color:<?php echo $config['navsettingMob']['mainmenuBghover']; ?>;}
    <?php endif; ?>
	
	<?php if ( $config['navsettingMob']['sapborder'] ) : ?>
    	.mobMenu .accordion{background-color:<?php echo $config['navsettingMob']['sapborder']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['navsettingMob']['mobMainmenuTextColor'] ) : ?>
    	.mobMenu .accordion li a
        {color:<?php echo $config['navsettingMob']['mobMainmenuTextColor']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['navsettingMob']['mobMainmenuTextHoverColor'] ) : ?>
    	.mobMenu .accordion li.active a,.mobMenu .accordion li a:hover{color:<?php echo $config['navsettingMob']['mobMainmenuTextHoverColor']; ?>;}
    <?php endif; ?>
    
<?php endif; ?>	

/*Button color*/
<?php if ( $config['buttonSetting']['theme-color-option'] ) : ?>
		
    <?php if ( $config['buttonSetting']['button_color_bg'] ) : ?>
    	button.button span,
        .proImage .qv-btn, .add-cart,
		.add-cart, a.add-cart, .w-btn
        {background-color:<?php echo $config['buttonSetting']['button_color_bg']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['buttonSetting']['button_text_color'] ) : ?>
    	button.button span,
        .proImage .qv-btn, .add-cart,
		.add-cart, a.add-cart, .w-btn,
		.add-cart .fa, a.add-cart .fa, .w-btn .fa
        {color:<?php echo $config['buttonSetting']['button_text_color']; ?>;}
    <?php endif; ?>

	<?php if ( $config['buttonSetting']['button_border_color'] ) : ?>
    	.add-cart, a.add-cart, .w-btn,
		.secView .add-cart, .secView a.add-cart, .secView .w-btn
        {border-color:<?php echo $config['buttonSetting']['button_border_color']; ?>;}
    <?php endif; ?>	
    
    <?php if ( $config['buttonSetting']['button_hover_bg'] ) : ?>
    	button.button:hover span,
        .proImage .qv-btn:hover, .add-cart:hover,
		.w-btn:hover, .w-btn:hover .fa,
		.secView .add-cart:hover, .secView a.add-cart:hover, .secView .w-btn:hover
        {background-color:<?php echo $config['buttonSetting']['button_hover_bg']; ?>;}
    <?php endif; ?>
    
    <?php if ( $config['buttonSetting']['button_hover_text'] ) : ?>
    	button.button:hover span,
        .proImage .qv-btn:hover, .add-cart:hover,
		.w-btn:hover, .w-btn:hover .fa,
		.secView .add-cart:hover, .secView a.add-cart:hover, .secView .w-btn:hover,
		.secView .add-cart:hover .fa, .secView a.add-cart:hover .fa, .secView .w-btn:hover .fa
        {color:<?php echo $config['buttonSetting']['button_hover_text']; ?>;}
    <?php endif; ?>
	
	<?php if ( $config['buttonSetting']['button_border_hover_color'] ) : ?>
    	.add-cart:hover, a.add-cart:hover, .w-btn:hover
        {border-color:<?php echo $config['buttonSetting']['button_border_hover_color']; ?>;}
    <?php endif; ?>	
	
	
	
	
<?php endif; ?>

/*Price color*/
<?php if ( $config['priceSetting']['theme-color-option'] ) : ?>
	
    <?php if ( $config['priceSetting']['regular_price'] ) : ?>
    	.regular-price .price
        {color:<?php echo $config['priceSetting']['regular_price']; ?>;}
    <?php endif; ?>
    
    <?php if ($config['priceSetting']['price_label'] ) : ?>
    	.price-label, .minimal-price-link .label, .special-price .price-label
        {color:<?php echo $config['priceSetting']['price_label']; ?>;}
    <?php endif; ?>
    
    <?php if ($config['priceSetting']['special_price'] ) : ?>
    	.minimal-price .price, .price-from .price, .minimal-price-link .price, .special-price .price
        {color:<?php echo $config['priceSetting']['special_price']; ?>;}
    <?php endif; ?>
    
    <?php if ($config['priceSetting']['old_price'] ) : ?>
    	.old-price .price
        {color:<?php echo $config['priceSetting']['old_price']; ?>;}
    <?php endif; ?>
    
<?php endif; ?>	

/*Footer color*/
<?php if ( $config['footer_setting']['theme-color-option'] ) : ?>

	<?php if ($config['footer_setting']['footer_bg'] ) : ?>
    	.fot-wrapper
        {background-color:<?php echo $config['footer_setting']['footer_bg']; ?>;}
    <?php endif; ?>
    
    <?php if ($config['footer_setting']['footer_bg_bottom'] ) : ?>
    	.fob-wrapper
        {background-color:<?php echo $config['footer_setting']['footer_bg_bottom']; ?>;}
    <?php endif; ?>
	
	<?php if ($config['footer_setting']['footer_bg_copy'] ) : ?>
    	.copyrightBox
        {background-color:<?php echo $config['footer_setting']['footer_bg_copy']; ?>;}
    <?php endif; ?>
    
    <?php if ($config['footer_setting']['footer_text_color'] ) : ?>
    	.fot-wrapper p,
        .fob-wrapper .copyText,
        .fot-wrapper ol li p,
         .fot-wrapper ol li p a,
		 footer p		 
        {color:<?php echo $config['footer_setting']['footer_text_color']; ?>;}
    <?php endif; ?>
    
    <?php if ($config['footer_setting']['footer_heading'] ) : ?>
    	.fob-wrapper h3, .fot-wrapper h3
        {color:<?php echo $config['footer_setting']['footer_heading']; ?>;}
    <?php endif; ?>
    
     <?php if ($config['footer_setting']['footer_text_anchore_color']) : ?>
    	.fob-wrapper .footer-bottom-links li a, .fob-wrapper .links ul li a
        {color:<?php echo $config['footer_setting']['footer_text_anchore_color']; ?>;}
    <?php endif; ?>
    
    
    <?php if ($config['footer_setting']['footer_text_color_hover'] ) : ?>
    	.fob-wrapper .footer-bottom-links li a:hover, 
        .fob-wrapper .links ul li a:hover
        {color:<?php echo $config['footer_setting']['footer_text_color_hover']; ?>;}
    <?php endif; ?>
    
    <?php if ($config['footer_setting']['footer_bottom_border_color'] ) : ?>
    	.fob-wrapper .bottom-links
        {
        	border-top-color:<?php echo $config['footer_setting']['footer_bottom_border_color']; ?>;
        	border-bottom-color:<?php echo $config['footer_setting']['footer_bottom_border_color']; ?>;
         }
    <?php endif; ?>
	
	<?php if ($config['footer_setting']['footer_bg_copy_text'] ) : ?>
    	.copyrightBox p
        {
        	color:<?php echo $config['footer_setting']['footer_bg_copy_text']; ?>;
         }
    <?php endif; ?>
    
   

<?php endif; ?>	


/*Newletter color*/
<?php if ( $config['newsletterrow_color_setting']['theme-color-option'] ) : ?>

	<?php if ($config['newsletterrow_color_setting']['nlbg'] ) : ?>
    	.newsletterBox
        {background-color:<?php echo $config['newsletterrow_color_setting']['nlbg']; ?>;}
    <?php endif; ?>
    
    <?php if ($config['newsletterrow_color_setting']['nlbg_heading'] ) : ?>
    	.newsletterBox h3
        {color:<?php echo $config['newsletterrow_color_setting']['nlbg_heading']; ?>;}
    <?php endif; ?>
    
    <?php if ($config['newsletterrow_color_setting']['nlbg_input'] ) : ?>
    	 .fn-wrapper .form-subscribe .input-text
        {background-color:<?php echo $config['newsletterrow_color_setting']['nlbg_input']; ?>;}
    <?php endif; ?>
    
    <?php if ($config['newsletterrow_color_setting']['nlbg_input_border'] ) : ?>
    	.newsletterBox .msg-block, .input-newsletter
        {border-color:<?php echo $config['newsletterrow_color_setting']['nlbg_input_border']; ?>;}
    <?php endif; ?>
    
     <?php if ($config['newsletterrow_color_setting']['nlbg_btn'] ) : ?>
    	.newsletterBox .button-newsletter span .fa
        {color:<?php echo $config['newsletterrow_color_setting']['nlbg_btn']; ?>;}
    <?php endif; ?>  
    
<?php endif; ?>