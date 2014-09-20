<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  class tp_notfound {
    var $group = 'notfound';

    function prepare() {
      global $oscTemplate;

      $oscTemplate->_data[$this->group] = array('notfound' => array('title' => TEXT_PRODUCT_NOT_FOUND));
    }

    function build() {
      global $oscTemplate;

      $output = '';
      
      $output .= '<div class="contentContainer">'.
                   '  <div class="contentText">'.
                   '  <div class="alert alert-warning"> . $group['title'] . </div>'.
                   '</div>'.
                   ' <div class="text-right">';
      $output .= tep_draw_button(IMAGE_BUTTON_CONTINUE, 'glyphicon glyphicon-chevron-right', tep_href_link(FILENAME_DEFAULT), null, null, 'btn-default btn-block');
      $output .= '</div>' .
                 '</div>';  
                 
      $oscTemplate->addContent($output, $this->group);
    }
  }
?>
