<?php

class Tekserve_Teksearch_Block_CatalogSearch_Result extends Mage_CatalogSearch_Block_Result
{
    
    //draw tabs for any number of available profiles, excluding SiteDefault. Products profile TO BE displayed using core collection and template.
	function draw_result_tabs( $the_query ) {
		$q_api = Mage::getModel('conversionpro/salespersonSearchApi');
		$tabs = array();
		//get all profiles. set title for each to profile name, skipping SiteDefault, renaming Content to Information. Set content for tabs.
		$profiles = $q_api->GetAllSearchProfiles()->results;
		foreach( $profiles as $profile ) {
			if( $profile == 'SiteDefault' ) {
				continue;
			}
			elseif( $profile == 'Content') {
				$title = 'Information';
			}
			else {
				$title = $profile;
			}
			//create content for this profile's tab
			$content = format_content_results( celebros_content_search( $the_query, $profile ), $profile );
			$tabs[$profile] = array(
				'title'		=>	$title,
				'content'	=>	$content
			);
		}

		//generate html for tab container, titles, & contents
		$tab_output = '<div id="search-results-tabs">
		<ul id="search-results-tab-titles">';
		foreach( $tabs as $tab ) {
			//no tab for empty results. sure...
			if( $tab['content'] == false ) {
				continue;
			}
			$tab_output .= '<li><a href="#';
			$tab_output .= $tab['title'];
			$tab_output .= '-results">';
			$tab_output .= $tab['title'];
			$tab_output .= '</a></li>';
		}
		$tab_output .= '</ul>';
		foreach( $tabs as $tab ) {
			$tab_output .= '<div id="';
			$tab_output .= $tab['title'];
			$tab_output .= '-results">';
			$tab_output .= $tab['content'];
			$tab_output .= '</div>';
		}
		$tab_output .= '</div>';
		echo $tab_output;
	 }
}
