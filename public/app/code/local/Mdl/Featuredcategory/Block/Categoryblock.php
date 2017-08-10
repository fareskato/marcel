<?php
class Mdl_Featuredcategory_Block_Categoryblock extends Mage_Core_Block_Template
{
    /* to get categories Collection */
	
	 public function __construct()
    {       
        $this->_controller = 'featured';
        $this->_blockGroup = 'featuredcategory';
        $this->_headerText = 'Featured Category Manager';
        parent::__construct();
        $this->setTemplate('featuredcategory/categoryform.phtml');
    }
	
	public function getLoadedCategories()
	{    /* get root categoryid */ 
	      $websites = Mage::app()->getWebsites();
		  $code = $websites[1]->getDefaultStore()->getCode();
		  $rootcatId= Mage::app()->getStore($code)->getRootCategoryId();
		  $categories = Mage::getModel('catalog/category')->getCategories($rootcatId);
	      return $categories;
	}

   public function getLoadedFeaturedCat()
   {  /* return fettured category id array to featuredcat.phtml */
	 
	  $feturedcat=Mage::getModel('featuredcategory/featured')->getCollection()->getFirstItem()->getData();
      if(isset($feturedcat['featured_category']))
       {
		   $featuredCatIds=json_decode($feturedcat['featured_category']);
	       return $featuredCatIds;
	   }
	   else
	   {   /* if there is no row in database return an empty array */
	       $featuredCatIds=array();
		   return $featuredCatIds ;
	   }
   
   }
	  
public function childCategory()
 {
  $store = Mage::getModel('core/store')->load(Mage_Core_Model_App::DISTRO_STORE_ID);
  $rootId = $store->getRootCategoryId();
  $category = Mage::getModel('catalog/category')->load($rootId); 
  return $category;
 }	  
}
?>