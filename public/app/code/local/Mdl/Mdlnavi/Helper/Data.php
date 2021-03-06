<?php

class Mdl_Mdlnavi_Helper_Data extends Mage_Core_Helper_Abstract
{

	private $_processor;

	/**
	 * Retrieve config value for store by path
	 *
	 * @param string $path
	 * @param string $section
	 * @param int $store
	 * @return mixed
	 */
	public function getCfg($path, $section = 'mdlmdlnavi', $store = NULL)
	{
		return Mage::helper('mdlmdlnavi')->getCfg($path, $section, $store);
	}

	/**
	 * Process cms block content to render magento shortcodes
	 *
	 * @param string $content
	 * @return string
	 */
	public function processCmsBlock($content)
	{
		if (!$this->_processor) {
			$this->_processor = Mage::helper('cms')->getBlockTemplateProcessor();
		}
		return $this->_processor->filter($content);
	}
}