<?php
class Mdlext_Mdloption_Helper_Data extends Mage_Core_Helper_Abstract
{	
    const XML_CONFIG_PATH = 'mdloption/';
   
	const NAME_DIR_JS = 'mdl/mdloption/';
  
    protected $_files = array(
        'jquery-1.11.1.min.js',
        'jquery.noconflict.js',
    );
	 public function getJQueryPath($file)
    {
        return self::NAME_DIR_JS . $file;
    }
	
    public function getFiles()
    {
        return $this->_files;
    }
}