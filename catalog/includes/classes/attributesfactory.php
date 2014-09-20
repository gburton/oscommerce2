<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2014 osCommerce

  Released under the GNU General Public License
*/

class AttributesFactory {
   
/* 
   example usage: AttributesFactory->build($products_id = '5', $type = 'checkbox') 
   TODO: extend this mehotd with more attributes options es.:
   AttributesFactory->build($products_id, $type, $bundle)
*/
    public function build($products_id, $type) {

        $attribute = "attribute_" . $type;
        if (file_exists(DIR_WS_CLASSES . $attribute)) {
            return new $attributes($products_id, $type);
        }
        else {
            throw new Exception("Invalid attribute type given.");
        }
    } 
}