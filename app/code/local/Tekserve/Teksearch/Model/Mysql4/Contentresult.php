<?php
class Tekserve_Teksearch_Model_Mysql4_Contentresult extends Mage_Core_Model_Mysql4_Abstract{
    protected function _construct()
    {
        $this->_init('teksearch/contentresult', 'sku');
    }   
}