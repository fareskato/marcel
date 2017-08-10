<?php 
class Mdl_Featuredcategory_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {      
	       $this->loadLayout();
		   $block=$this->getLayout()->createBlock('featuredcategory/categoryblock')->setTemplate('featuredcategory/categoryform.phtml');
	       // append block to content block
	       $this->getLayout()->getBlock('content')->append($block);
	       // render the layout 
	       $this->renderLayout();
    }

    public function saveCategoryAction()
    {     /* get post data */
		  $param=$this->getRequest()->getPost();
		  $categoryIds;
		  /* if  categories are not  selected  */
		  // if(!isset($param['category'])) 
		   // {   $message = $this->__('Please Select at leaset one category');
               // Mage::getSingleton('adminhtml/session')->addError($message);
			   // $this->_redirect('adminfeaturedcategory/adminhtml_index/index/'); 
		   // }
		  // else
			 // {        /* get category id  array from  */ 
					  $categoryIds=$param['category'];
					  /* encode array in json form */ 
					  $categoryIds=json_encode($categoryIds); 
					  /* Create Model_Resource_Featured_Collection Object and get first item to get featured categories  */
		               $Featured=Mage::getModel('featuredcategory/featured')->getCollection()->getFirstItem()->getData();
					 
					  if(isset($Featured['featured_id']))
					  $firstFeaturedId=$Featured['featured_id'];
					
					  /* Create Model_Featured Object */
					  $FeaturedObj=Mage::getModel('featuredcategory/featured');
					  if(!count($Featured))
					  {  /* to create first row */
					    $FeaturedObj->setFeaturedCategory($categoryIds);
						$FeaturedObj->save();
					  }
					  else
					  {   /* to update existing row */
						   $FeaturedObj->load($firstFeaturedId)->setFeaturedCategory($categoryIds)->save();
						    /* To show update msg to admin */
							$message = $this->__('Featured category has been updated successfully ');
                            Mage::getSingleton('adminhtml/session')->addSuccess($message);
					  }
			      $this->_redirect('adminfeaturedcategory/adminhtml_index/index/'); 
		//	 }
		
	 }

}