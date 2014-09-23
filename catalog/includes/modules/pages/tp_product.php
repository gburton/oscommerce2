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
    protected $data;
    var $name;
  
    function prepare() {
      global $oscTemplate, $product;
      $oscTemplate->_data[$this->group] = $product->getData();
      $this->data = $oscTemplate->_data[$this->group];
    }

    function build() {
      global $oscTemplate, $currencies, $product;
 
      $price =   $currencies->display_price($this->data['products_price'], tep_get_tax_rate($this->data['products_tax_class_id']));
        
// check for special price otherwise will return the list price
      if ($new_price = tep_get_products_special_price($this->data['products_id'])) {  
        $specialprice = $currencies->display_price($new_price, tep_get_tax_rate($this->data['products_tax_class_id']));
      } 
      

    if (tep_not_null($this->data['products_image'])) {
      $photoset_layout = '1';
 
      $pi_query = $product->getHtmlcontent();
      $pi_total = tep_db_num_rows($pi_query);

      if ($pi_total > 0) {
        $pi_sub = $pi_total-1;
 
        while ($pi_sub > 5) {
          $photoset_layout .= 5;
          $pi_sub = $pi_sub-5;
        }
 
        if ($pi_sub > 0) {
          $photoset_layout .= ($pi_total > 5) ? 5 : $pi_sub;
        }

 
        $pi_counter = 0;
        $pi_html = array();

         while ($pi = tep_db_fetch_array($pi_query)) {
          $pi_counter++;
 
          if (tep_not_null($pi['htmlcontent'])) {
            $image[$pi_counter]['htmlcontent'][] = $pi['htmlcontent'];
          }
 
            $image[$pi_counter]['image'] = tep_image(DIR_WS_IMAGES . $pi['image'], '', '', '', 'id="piGalImg_' . $pi_counter . '"');
         }

        if ( !empty($image[$pi_counter]['htmlcontent']) ) {
           $image[$pi_counter]['none'] = implode('', $image[$pi_counter]['htmlcontent']);
        }
        
      } else {
        $image = tep_image(DIR_WS_IMAGES . $this->data['products_image'], addslashes($this->data['products_name']));
      }
    }
      
      ob_start();
      include DIR_WS_MODULES . 'pages/templates/' . $this->group . '.php';
      $output = ob_get_clean();
      
      $oscTemplate->addContent($output, $this->group);
    }
  }
?>
