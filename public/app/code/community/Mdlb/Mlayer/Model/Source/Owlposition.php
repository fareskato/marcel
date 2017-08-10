<?php
class Mdlb_Mlayer_Model_Source_Owlposition{
	public function toOptionArray() {
		$options = array();
		$options[] = array('value'=>'topleft', 'label'=>'Top Left');
		$options[] = array('value'=>'topright', 'label'=>'Top Right');
		$options[] = array('value'=>'topcenter', 'label'=>'Top Center');
		$options[] = array('value'=>'bottomleft', 'label'=>'Bottom Left');
		$options[] = array('value'=>'bottomright', 'label'=>'Bottom Right');
		$options[] = array('value'=>'bottomcenter', 'label'=>'Bottom Center');

		return $options;
	}
}