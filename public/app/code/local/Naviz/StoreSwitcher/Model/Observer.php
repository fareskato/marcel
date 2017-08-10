<?php
class Naviz_StoreSwitcher_Model_Observer
{
    public function get_client_ip() {
        $ipaddress = '';
        if ($_SERVER['HTTP_CLIENT_IP'])
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if($_SERVER['HTTP_X_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if($_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if($_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if($_SERVER['HTTP_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
			
	public function getLocationInfoByIp(Varien_Event_Observer $observer) {
            /*
            $cookieValue = Mage::getModel('core/cookie')->get('mr_geoip_redirect');
            if($cookieValue == null) {
                $ip = $_SERVER['REMOTE_ADDR'];
                $ip = ($ip == '127.0.0.1') ? '46.218.85.101' : $ip;
                $ip = ($ip == '163.172.11.253') ? '46.218.85.101' : $ip;
                $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
                $cnCode = $details->country;
                if($cnCode == 'XX' || $cnCode == null) {
                    $geoIP = Mage::getSingleton('geoip/country');
                    $cnCode =  $geoIP->getCountry();
                }
            } else {
                $cnCode = $cookieValue;
            }
                switch ($cnCode) {
                    case "FR": {
                        Mage::app()->setCurrentStore(2);
                        break;
                    }

                    default: {
                    Mage::app()->setCurrentStore(3);
                    break;
                    }

                }
                Mage::getModel('core/cookie')->set('mr_geoip_redirect', $cnCode);

            */

 	}
		
}