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
  protected $data;
  protected $model;
  protected $name;
  protected $id;
  protected $description;
  protected $price;
  protected $specialprice;
  protected $image;
  protected $url;
  protected $qty;
  protected $products_date_available;
  protected $products_tax_class_id;
  protected $category_id;
 
  public function __construct($products_id = '') {
    
  if (!$products_id) return false;
    
    $product_info_query = tep_db_query("select p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$products_id . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
    
    $data =  tep_db_fetch_array($product_info_query);    
       
      $this->data = $data;
      $this->model = $data['products_model'];
      $this->name = $data['products_name'];
      $this->id = $data['products_id'];
      $this->description = $data['products_description'];
      $this->image = $data['products_image'];
      $this->url = $data['products_url'];
      $this->price = $data['products_price'];
      $this->specialprice = tep_get_products_special_price($data['products_id']);
      $this->qty = $data['products_quantity'];
      $this->products_date_available = $data['products_date_available'];
      $this->products_tax_class_id = $data['products_tax_class_id'];
      $this->category_id = tep_get_product_path($_data['products_id']);
  }
 
// returns product data as array 
  public function getData() 
  {
    return $this->data; 
  }
 
// returns product model 
  public function getModel()
  {
    return $this->model;
  }
 
// returns product name 
  public function getName()
  {
    return $this->name;
  }

// returns product ID 
  public function getId()
  {
    return $this->id;
  }

// returns product description 
  public function getDescription()
  {
    return $this->description;
  }

// returns product main image 
  public function getImage()
  {
    return $this->image;
  }
 
// updates product count
  public function countUpdate()
  {
    return tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$this->id . "' and language_id = '" . (int)$_SESSION['languages_id'] . "'");   
  }

// returns product multiple images and htmlcontent  
  public function getHtmlcontent()
  {
    return tep_db_query("select image, htmlcontent from " . TABLE_PRODUCTS_IMAGES . " where products_id = '" . (int)$this->id . "' order by sort_order");
  }

// returns product price   
  public function getPrice()
  {
    return $this->price;
  }

 // returns product special price
  public function getSpecialprice()
  {
    return $this->specialprice;
  }

// returns product quantity  
  public function getQty()
  {
    return $this->qty;
  }

// returns product data available  
  public function getDate_Available()
  {
    return $this->products_date_available;
  }

// returns product tax class id 
  public function getProducts_tax_class_id()
  {
    return $this->products_tax_class_id;
  }
  
// return category id
  public function getProductcategory()
  {
    return $this->category_id;
  }
  
}