<?php
class Tekserve_Teksearch_IndexController extends Mage_Core_Controller_Front_Action {    
    public function testModelAction() {
        echo 'Setup!<br/>';
        $search = Mage::getModel('teksearch/resultlist');
        echo get_class($search).'<br/>';
        $params = $this->getRequest()->getParams();
   		echo("Loading the results with an ID of ".$params['id']);
		$search->load($params['id']);     
		$data = $search->getData();
		var_dump($data);   
    }
    public function testResultAction() {
        echo 'Setup!<br/>';
        $item = Mage::getModel('teksearch/contentresult');
        echo get_class($item).'<br/>';
        $params = $this->getRequest()->getParams();
   		echo("Loading the content item with an ID of ".$params['id']);
		$item->load($params['id']); 
		$data = $item->getData();
		var_dump($data);   
    }
    public function showAllResultsAction() {
    $results = Mage::getModel('teksearch/contentresult')->getCollection();
    foreach($results as $result){
    	echo '<div style="width:30%; margin-right: 1%; display:inline-block">';
        echo '<h3>'.$result->getTitle().'</h3>';
        echo nl2br($result->getDescription());
        echo '</div>';
    }
    }
}