<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2014 osCommerce

  Released under the GNU General Public License
*/

class Product
{
  protected $data;
  protected $htmlcontent;
 
  public function __construct($products_id = '') {

    if (!$products_id) return false;
    
    $product_info_query = tep_db_query("select p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . $products_id . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
    
    $this->data = tep_db_fetch_array($product_info_query);    
  }
 
// returns product data as array 
  public function getData() 
  {
    return $this->data; 
  }

// returns a single element of the data array 
  public function get($obj)
  {
    return $this->data[$obj];
  }
  
// add the products model to the breadcrumb trail
  public function productBreadcrumb() 
  {
    global $breadcrumb;
    
    if ($this->get('products_model')) {

      $breadcrumb->add($this->get('products_model'), tep_href_link(FILENAME_PRODUCT_INFO, 'cPath=' . $this->getProductcategory() . '&products_id=' . $this->get('products_id')));
    }  
  }
 
// updates product count
  public function countUpdate()
  {
    return tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . $this->get('products_id') . "' and language_id = '" . (int)$_SESSION['languages_id'] . "'");   
  }

// returns product multiple images and htmlcontent  
  public function getHtmlcontent()
  {
    $pi_query = tep_db_query("select image, htmlcontent from " . TABLE_PRODUCTS_IMAGES . " where products_id = '" . $this->get('products_id') . "' order by sort_order");
    
    $pi_counter = 0;
    $image = array();

    while ($pi = tep_db_fetch_array($pi_query)) {
      $pi_counter++;
 
      if (tep_not_null($pi['htmlcontent'])) $image[$pi_counter]['htmlcontent'] = $pi['htmlcontent'];
 
     $image[$pi_counter]['image'] = tep_image(DIR_WS_IMAGES . $pi['image'], '', '', '', 'id="piGalImg_' . $pi_counter . '"');         
    }
    
    $this->htmlcontent = $image;
    return $this->htmlcontent;
  }

 // returns product special price
  public function getSpecialprice()
  {
    return tep_get_products_special_price($this->get('products_id'));
  }
  
// return category id
  public function getProductcategory()
  {
    return tep_get_product_path($this->get('products_id'));
  }  
}
