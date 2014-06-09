<?php
class Tekserve_Teksearch_Block_Contentresult_List extends Mage_Core_Block_Template
{
	function format_content_results( $content_results, $search_profile ) {
		//use Magento's standard catalog output for tab content
	//  	krumo($search_profile);
	//  	krumo($content_results);
		$_helper = Mage::helper('catalog/output');
		$mode = 'grid';
		//message for no content found
		if( count( $content_results ) < 1 ) {
			echo '<p class="note-msg">There are no products matching the selection.</p>';
			return false;
		}
 
		//if content is found for this tab
		else {
			//add toolbars
	//  		$html = $this->getToolbarHtml();
	//  		$html .= $this->getAdditionalHtml();
			$html = '<div class="category-products">';
			//for list view
	// 		if($this->getMode()!='grid') {
			if( $mode !='grid' ) {
				$i=0;
				$html .= ' <ol class="products-list" id="products-list">';
				foreach( $content_results as $key=>$result ) {
					//get product obj if is product profile
					if( $search_profile == "Products" ) {
						$product = Mage::getModel( 'catalog/product' );
						$productId = $product->getIdBySku( $result['sku'] );
						if($productId) {
							$product->load($productId);
						}
						$theProductBlock = new Mage_Catalog_Block_Product;
					}
					//define li class, add last for last item in list view
					$html .= '<li class="item';
					if( ++$i == count($content_results) ) {
						$html .= ' last';
					}
					$html .= '">';
					//add image if profile is product
					if( isset( $productId ) ) {
						$html .= '<a href="' . $result['link'] . '" title="' . $result['title'] . '" class="product-image"><img src="' . $result['thumbnail'] . '" width="166" height="166" alt="' . $result['title'] . '" /></a>';
					}
					//name, meta, and description
					$html .= '<div class="product-shop">
					<div class="f-fix">
					<h2 class="product-name">';
					$html .= '<a href="' . $result['link'] . '" title="' . $result['title'] . '">';
					$html .= $result['title'];
					$html .= '</a>';
					$html .= '</h2>';
					if( isset( $productId ) ) {
						if( $product->getRatingSummary() ) {
							$html .= $theProductBlock->getReviewsSummaryHtml($product);
						}
						$html .= $theProductBlock->getPriceHtml($product, true);
						unset($theProductBlock);
					}
					$html .= '<div class="desc std">';
					$html .= $result['description'];
					if( $search_profile != "Product" ) {
						$html .= '<a href="' . $result['link'] . '" title="' . $result['title'] . '" class="link-learn">READ MORE</a>';
					}
					else {
						$html .= '<a href="' . $result['link'] . '" title="' . $result['title'] . '" class="link-learn">LEARN MORE</a>';
					}
					$html .= '</div>';
					//buttons for products only
					if( isset( $productId ) ) {
						if( $product->isSaleable() ) {
							$html .= '<button type="button" title="Add to Cart" class="button btn-cart" onclick="setLocation(\'' . Mage::helper('checkout/cart')->getAddUrl($product) . '\')"><span><span>Add to Cart</span></span></button>';
						}
						if ( $product->getIsSalable() ) {
							$html .= '<p class="availability in-stock"><span>In stock</span></p>';
						}
						else {
							$html .= '<p class="availability out-of-stock"><span>Out of stock</span></p>';
						}
					}
					//add product to... buttons
					if( isset( $productId ) ) {
						$html .= '<ul class="add-to-links">';
						if ( Mage::helper( 'wishlist' )->isAllow() ) {
							if( !Mage::getSingleton( 'vbw_punchout/session' )->isPunchoutSession() ) {   
								$html .= '<li><a href="' . Mage::helper('wishlist')->getAddUrl($product) . '" class="link-wishlist"><span>+</span>Add to Wishlist</a></li>';
							}
							if( $compareUrl = Mage::helper('catalog/product_compare')->getAddUrl( $product ) ) {
								$html .= '<li><a href="' . $compareUrl . '" class="link-compare">Add to Compare</a></li>';
							}
						}
						$html .= '</ul>';
					}
					$html .= '</div></div>';
					$html .= '</li>';
				}
				$html .= '</ol>
				<script type="text/javascript">decorateList("products-list", "none-recursive")</script>';
			}
			else {
				//grid view
				//get item count
				$result_count = count( $content_results );
				$i = 0;
				foreach( $content_results as $key=>$result ) {
					//get product obj if is product profile
					if( $search_profile == "Products" ) {
						$product = Mage::getModel( 'catalog/product' );
						$productId = $product->getIdBySku( $result['sku'] );
						if($productId) {
							$product->load($productId);
						}
						$theProductBlock = new Mage_Catalog_Block_Product;
					}
					//assign classes to items in 3-col layout
					if( $i++%3 == 0 ) {
						$html .= '<ul class="products-grid row">';
					}
					$html .= '<li class="col-md-4 item';
					if( ( $i-1 )%3 == 0 ) {
						$html .= ' first';
					}
					elseif( $i%3 == 0 ) {
						$html .= ' last';
					}
					$html .= '">';
					//add image if profile is product
					if( isset( $productId ) ) {
						$html .= '<a href="' . $result['link'] . '" title="' . $result['title'] . '" class="product-image"><img src="' . $result['thumbnail'] . '" width="135" height="135" alt="' . $result['title'] . '" /></a>';
					}
					//name, meta, and description
					$html .= '<h2 class="product-name">';
					$html .= '<a href="' . $result['link'] . '" title="' . $result['title'] . '">';
					$html .= $result['title'];
					$html .= '</a>';
					$html .= '</h2>';
					if( isset( $productId ) ) {
						if( $product->getRatingSummary() ) {
							$html .= $theProductBlock->getReviewsSummaryHtml($product);
						}
						$html .= $theProductBlock->getPriceHtml($product, true);
					}
					if( !isset( $productId ) ) {
						$html .= '<div class="desc std">';
						$html .= $result['description'];
						$html .= '<a href="' . $result['link'] . '" title="' . $result['title'] . '" class="link-learn button">READ MORE</a>';
						$html .= '</div>';
					}
					else {
					//buttons for products only
					$html .= '<div class="actions">';
						if( isset( $productId ) ) {
							if( $product->isSaleable() ) {
								$html .= '<button type="button" title="Add to Cart" class="button btn-cart" onclick="setLocation(\'' . Mage::helper('checkout/cart')->getAddUrl($product) . '\')"><span><span>Add to Cart</span></span></button>';
							}
							if ( $product->getIsSalable() ) {
								$html .= '<p class="availability in-stock"><span>In stock</span></p>';
							}
							else {
								$html .= '<p class="availability out-of-stock"><span>Out of stock</span></p>';
							}
						}
						//add product to... buttons
						$html .= '<ul class="add-to-links">';
						if ( Mage::helper( 'wishlist' )->isAllow() ) {
							if( !Mage::getSingleton( 'vbw_punchout/session' )->isPunchoutSession() ) {   
								$html .= '<li><a href="' . Mage::helper('wishlist')->getAddUrl($product) . '" class="link-wishlist"><span>+</span>Add to Wishlist</a></li>';
							}
							if( $compareUrl = Mage::helper('catalog/product_compare')->getAddUrl( $product ) ) {
								$html .= '<li><a href="' . $compareUrl . '" class="link-compare">Add to Compare</a></li>';
							}
						}
						$html .= '</ul></div>';
						unset($theProductBlock);
					}
					$html .= '</li>';
					if( $i%3 == 0 || $i == $result_count ) {
						$html .= '</ul>';
					}
				}
				$html .= '<script type="text/javascript">decorateGeneric( $$( "ul.products-grid" ), ["odd","even","first","last"])</script>';
			}
			$html .= '</div>';
			$html .= '<div class="toolbar-bottom">';
	// 		$html .+ $this->getToolbarHtml();
			$html .= '</div>';
			return $html;
		}
	 }
 
	
}