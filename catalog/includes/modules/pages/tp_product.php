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
      global $oscTemplate;

      $output = '';

      $output .= tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product'), 'post', 'class="form-horizontal" role="form"');
      
      $output .=   '<div class="page-header">' .
                   '  <h1 class="pull-right">' . $this->data['products_price'] . '</h1>' .
                   '  <h1>' . $this->data['products_name'] . '</h1>';
                   
      if ( $this->data['products_model'] ) {
      $output .= '<br />' .
                 '<span class="smallText">[' . $this->data['products_model'] . ']</span>'; 
      }
        
      $output .= '</div>';
                      
      $oscTemplate->addContent($output, $this->group);
    }
  }
?>
