<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2014 osCommerce

  Released under the GNU General Public License
*/

class reviews
{

  protected $id;
  
  public function __construct($products_id) 
  {
   $this->id = $products_id;
  }
 
 // prepare query for all product review
  public function getReviewsraw()
  {
    $reviews_query_raw = "select r.reviews_id, left(rd.reviews_text, 100) as reviews_text, r.reviews_rating, r.date_added, p.products_id, pd.products_name, p.products_image, r.customers_name from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = r.products_id and r.reviews_id = rd.reviews_id and p.products_id = pd.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' and rd.languages_id = '" . (int)$_SESSION['languages_id'] . "' and reviews_status = 1 order by r.reviews_id DESC";
    return $reviews_query_raw;
  }
 
// prepare query for single product review 
   public function getReviews()
  { 
    $reviews_query_raw = "select r.reviews_id, left(rd.reviews_text, 100) as reviews_text, r.reviews_rating, r.date_added, r.customers_name from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.products_id = '" . $this->id . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$_SESSION['languages_id'] . "' and r.reviews_status = 1 order by r.reviews_id desc"; 
    
    return $reviews_query_raw;
  } 

// returns a new splitpageresults object that can be used to split the all reviews query or the single product reviews query
   public function getReviewssplit($query)
  {  
    return new splitPageResults($query, MAX_DISPLAY_NEW_REVIEWS);
  } 

// returns the average reviews rating as array  
   public function getReviewsavg()
  {  
      $average_query = tep_db_query("select AVG(r.reviews_rating) as average, COUNT(r.reviews_rating) as count from " . TABLE_REVIEWS . " r where r.products_id = '" . (int)$this->id . "' and r.reviews_status = 1");
      return tep_db_fetch_array($average_query); 
  } 

// returns number of reviews for current product  
  public function getReviewscount()
  {
    $reviews_query = tep_db_query("select count(*) as count from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.products_id = '" . $this->id . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$_SESSION['languages_id'] . "' and reviews_status = 1");
    return tep_db_fetch_array($reviews_query); 
  }
    
}
