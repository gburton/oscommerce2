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
  protected $model;
  protected $name;
  protected $id;
  protected $description;
  protected $price;
  protected $image;
  protected $url;
  protected $products_date_available;
  protected $products_tax_class_id;
 
  public function __construct($products_id) {
   
    $product_info_query = tep_db_query("select p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$_GET['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
   
    $data = tep_db_fetch_array($product_info_query);
       
      $this->model = $data['products_model'];
      $this->name = $data['products_name'];
      $this->id = $data['products_id'];
      $this->description = $data['products_description'];
      $this->image = $data['products_image'];
      $this->url = $data['products_url'];
      $this->price = $data['products_price'];
      $this->products_date_available = $data['products_date_available'];
      $this->products_tax_class_id = $data['products_tax_class_id'];
  }
 
  public function getModel()
  {
    return $this->model;
  }
 
  public function getName()
  {
    return $this->name;
  }
 
  public function getId()
  {
    return $this->id;
  }
 
  public function getDescription()
  {
    return $this->description;
  }
 
  public function getImage()
  {
    return $this->image;
  }
 
  public function countUpdate()
  {
  return tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$this->id . "' and language_id = '" . (int)$_SESSION['languages_id'] . "'");
   
  }
 
  public function getHtmlcontent()
  {
  return tep_db_query("select image, htmlcontent from " . TABLE_PRODUCTS_IMAGES . " where products_id = '" . (int)$this->id . "' order by sort_order");
  }
   
  public function getPrice()
  {
    return $this->price;
  }
 
  public function getDate_Available()
  {
    return $this->products_date_available;
  }
 
  public function getProducts_tax_class_id()
  {
    return $this->products_tax_class_id;
  }
 
}