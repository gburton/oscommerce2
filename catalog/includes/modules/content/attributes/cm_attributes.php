<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2014 osCommerce

  Released under the GNU General Public License
*/

  class cm_attributes {
    var $code;
    var $group;
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function cm_attributes() {
      $this->code = get_class($this);
      $this->group = basename(dirname(__FILE__));

      $this->title = MODULE_CONTENT_ATTRIBUTES_TITLE;
      $this->description = MODULE_CONTENT_ATTRIBUTES_DESCRIPTION;

      if ( defined('MODULE_CONTENT_ATTRIBUTES_STATUS') ) {
        $this->sort_order = MODULE_CONTENT_ATTRIBUTES_SORT_ORDER;
        $this->enabled = (MODULE_CONTENT_ATTRIBUTES_STATUS == 'True');
      }
    }
    
    function execute() {
      global $oscTemplate, $attributes;

      if ($attributes->getProductsOptionNameArray()) { 
        $products_options_name_array = $attributes->getProductsOptionNameArray();
        $products_options_array = $attributes->getProductsOptionsArray();
        $selected_attribute = $attributes->getSelectedAttribute();  
      } else {
        return false;
      }
        
      ob_start();
      include(DIR_WS_MODULES . 'content/' . $this->group . '/templates/cm_attributes.php');
      $template = ob_get_clean();

      $oscTemplate->addContent($template, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_CONTENT_ATTRIBUTES_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Attributes Module', 'MODULE_CONTENT_ATTRIBUTES_STATUS', 'True', 'Do you want to enable the attribtes module?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_CONTENT_ATTRIBUTES_SORT_ORDER', '1000', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
// updates old version database when installing module. Will not be removed on module uninstall. 
      tep_db_query("CREATE TABLE IF NOT EXISTS products_options_types (id int NOT NULL auto_increment, options_id int NOT NULL, type VARCHAR(30), PRIMARY KEY (id)) CHARACTER SET utf8 COLLATE utf8_unicode_ci");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_CONTENT_ATTRIBUTES_STATUS', 'MODULE_CONTENT_ATTRIBUTES_SORT_ORDER');
    }
  }
?>