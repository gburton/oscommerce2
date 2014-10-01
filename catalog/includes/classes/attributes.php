<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2014 osCommerce

  Released under the GNU General Public License
*/

class Attributes extends product
 
{
  protected $products_options_name_arr;
  protected $products_options_array;
  protected $selected_attribute;
 
  public function __construct($products_id = '') {
    global $currencies;
    
    if (!$products_id) return false;
       
    $products_attributes_query = tep_db_query("select distinct popt.products_options_id, popt.products_options_name from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$products_id . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$_SESSION['languages_id'] . "' order by popt.products_options_name");
   
    if (tep_db_num_rows($products_attributes_query) > 0) {
      while($products_options_name_array = tep_db_fetch_array($products_attributes_query)) {
        $this->products_options_name_arr[$products_options_name_array['products_options_name']] = (int)$products_options_name_array['products_options_id'];
     }
     
    $products_options_array = array();
   
    $products_options_query = tep_db_query("select pa.options_id, pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$products_id . "' and pa.options_id in (" .  implode(',', $this->products_options_name_arr) . ") and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$_SESSION['languages_id'] . "'");
 
    $type_query = tep_db_query("SELECT po.products_options_id, type , pt.options_id FROM ". TABLE_PRODUCTS_OPTIONS . " po, " . TABLE_PRODUCTS_OPTIONS_TYPES . " pt WHERE po.products_options_id = pt.options_id");
      
    while ( $types = tep_db_fetch_array($type_query) ) { 
       $arri[$types['options_id']] = $types;
     }   
      
      while ($products_options = tep_db_fetch_array($products_options_query)) {
        $text =  $products_options['products_options_values_name'];
         
        if ($products_options['options_values_price'] != '0') {
          $text .= ' ' . $products_options['price_prefix'] . $currencies->display_price($products_options['options_values_price'], tep_get_tax_rate($this->getProducts_tax_class_id()));
         }
 
          if ( isset($arri[$products_options['products_options_values_id']])) {
            $type = $arri[$products_options['products_options_values_id']]['type'];
          }
        
          $this->products_options_array[$products_options['options_id']][] = array('id' => $products_options['products_options_values_id'],
                                                                                   'text' => $text,
                                                                                   'name' => $products_options['products_options_values_id'],
                                                                                   'type' => $type);
        }
      } else {
      return false;
    }
  }
       
// return products options name array  
  public function getProductsOptionNameArray() {
   return $this->products_options_name_arr;
  }
 
// return products options array 
  public function getProductsOptionsArray() {
   return $this->products_options_array;
  }    

// return the actually selected attribute taken from cart $_SESSION
  public function getSelectedAttribute() {
    if (is_string($_GET['products_id']) && !empty($_SESSION['cart']->contents[$_GET['products_id']]['attributes'])) {
      $this->selected_attribute = $_SESSION['cart']->contents[$_GET['products_id']]['attributes'];
    return $this->selected_attribute;
    } else {
    return false;
    }   
  }
}
