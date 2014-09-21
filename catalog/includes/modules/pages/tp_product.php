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
  
    function prepare() {
      global $oscTemplate;
      $this->data = $oscTemplate->_data[$this->group];
    }

    function build() {
      global $oscTemplate, $currencies;

      $output = '';

      $output .= tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product'), 'post', 'class="form-horizontal" role="form"');
      
      $output .=   '<div class="page-header">';
      $output .=   '  <h1 class="pull-right">';

// check for special price otherwise will return the list price
      if ($new_price = tep_get_products_special_price($this->data['products_id'])) {
      $output .= '<del>' . $currencies->display_price($this->data['products_price'], tep_get_tax_rate($this->data['products_tax_class_id'])) . '</del> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($this->data['products_tax_class_id'])) . '</span>';
      } else {
        $output .= $currencies->display_price($this->data['products_price'], tep_get_tax_rate($this->data['products_tax_class_id']));
      }
      
      $output .=  '</h1>';
      $output .=   '  <h1>' . $this->data['products_name'] . '</h1>';
                   
      if ( $this->data['products_model'] ) {
      $output .= '<br />' .
                 '<span class="smallText">[' . $this->data['products_model'] . ']</span>'; 
      }
        
      $output .= '</div>' .
                 '<div class="contentContainer"> ' .
                 '<div class="contentText">';
                      
      $oscTemplate->addContent($output, $this->group);
    }
  }
?>
