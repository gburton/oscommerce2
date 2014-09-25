<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  class tp_product {
    var $group = 'product';

// class construct
    function prepare() {
      global $oscTemplate, $product;
      $oscTemplate->_data[$this->group] = $product->getData();   
    }

    function build() {
      global $oscTemplate, $currencies,  $product;
      
      if (is_null($oscTemplate->_data[$this->group]['products_id'])) {
          header('HTTP/1.0 404 Not Found');  
  
          $output = '<div class="contentContainer">' .
                    '  <div class="contentText">' .
                    '    <div class="alert alert-warning">' . TEXT_PRODUCT_NOT_FOUND . '</div>'.
                    '  </div>' .
                    ' <div class="text-right">';
      } else {
        
          $price = $currencies->display_price($oscTemplate->_data[$this->group]['products_price'], tep_get_tax_rate($oscTemplate->_data[$this->group]['products_tax_class_id']));
        
// check for special price otherwise will return the list price
      if ($new_price = $product->getSpecialprice()) {  
        $specialprice = $currencies->display_price($new_price, tep_get_tax_rate($oscTemplate->_data[$this->group]['products_tax_class_id']));
      } 
      
// check if product has multiple images with html content otherwise will return defualt product image
    if (tep_not_null($oscTemplate->_data[$this->group]['products_image'])) {
      $photoset_layout = '1';
 
      $image = $product->getHtmlcontent();
      $pi_total = (sizeof($image));

      if ($pi_total > 0) {
        $pi_sub = $pi_total-1;
 
        while ($pi_sub > 5) {
          $photoset_layout .= 5;
          $pi_sub = $pi_sub-5;
        }
 
        if ($pi_sub > 0) {
          $photoset_layout .= ($pi_total > 5) ? 5 : $pi_sub;
        }
      
      } else {
        $image = $oscTemplate->_data[$this->group]['products_image'];
      }
    }

// loads product page template       
      ob_start();
      include DIR_WS_MODULES . 'pages/templates/tp_' . $this->group . '.php';
      $output = ob_get_clean();
    }
      $oscTemplate->addContent($output, $this->group);   
   }
 }    
?>