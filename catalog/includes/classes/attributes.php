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
       
     $products_attributes_query = tep_db_query("select distinct popt.products_options_id, popt.products_options_name from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$_GET['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$_SESSION['languages_id'] . "' order by popt.products_options_name");
   
    if (tep_db_num_rows($products_attributes_query) > 0) {
    while($products_options_name_array = tep_db_fetch_array($products_attributes_query)) {
          $this->products_options_name_arr[$products_options_name_array['products_options_name']] = (int)$products_options_name_array['products_options_id'];
        }      
 
    $products_options_array = array();
   
 $products_options_query = tep_db_query("select pa.options_id, pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$_GET['products_id'] . "' and pa.options_id in (" .  implode(',', $this->products_options_name_arr) . ") and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$_SESSION['languages_id'] . "'");
 
        while ($products_options = tep_db_fetch_array($products_options_query)) {
          $text =  $products_options['products_options_values_name'];

         
          if ($products_options['options_values_price'] != '0') {
            $text .= ' ' . $products_options['price_prefix'] . $currencies->display_price($products_options['options_values_price'], tep_get_tax_rate($this->getProducts_tax_class_id()));
          }
 
          $this->products_options_array[$products_options['options_id']][] = array('id' => $products_options['products_options_values_id'],
                                                                   'text' => $text,
                                                                    'name' => $products_options['products_options_values_id']);
     
      if (is_string($_GET['products_id']) && !empty($_SESSION['cart']->contents[$_GET['products_id']]['attributes'])) {
            $this->selected_attribute = $_SESSION['cart']->contents[$_GET['products_id']]['attributes'];
          } else {
            $this->selected_attribute = false;
          }
       }
     } else {
      return false;
    }
  }
       
  public function getProductsOptionNameArray() {
   return $this->products_options_name_arr;
  }
 
  public function getProductsOptionsArray() {
   return $this->products_options_array;
  }    
 
  public function getSelectedAttribute() {
   return $this->selected_attribute;
  }    
 
}