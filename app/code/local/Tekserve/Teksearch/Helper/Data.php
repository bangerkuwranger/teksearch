<?php
class Tekserve_Teksearch_Helper_Data extends Mage_Core_Helper_Abstract {

	protected $_q_api = ; //get celebros api object for search methods
	
	//gets current search query on results page
	function content_query_term() {
		$the_query = urlencode( Mage::helper( 'catalogsearch' )->getQueryText() );
		return $the_query;
	}
	
	//performs search, sorted by relevance, for a search profile on Celebros. Returns a multidimensional array of 'products' and their assorted fields.
	function celebros_content_search($query_term, $search_profile) {
		$q_search = $_q_api->Search( $query_term )->results->GetSearchHandle();
		$q_r_handle = $_q_api->SortByRelevancy( $q_search )->results->GetSearchHandle();
		$q_filtered = $_q_api->ActivateProfile( $q_r_handle, $search_profile );
		$q_results = $q_filtered->results->Products->Items;
		$q_contents = array();
		foreach( $q_results as $key=>$item ) {
			$fields = array();
			foreach( $item->Field as $name=>$value ) {
				if( !empty( $value ) ) {
					$fields[$name] = $value;
				}
			}
			$q_contents[$key] = $fields;
		}
 
		// 	 return $q_results['Products'];
		return $q_contents;
	}
	
	//changes pagination of a search, caches data for session
	
	//changes search view, caches data for session
	
	//changes sort method, caches data for session
	
	//changes sort direction, caches data for session
	
	//parse url for non-product pagination, sort, and view
	
	

}