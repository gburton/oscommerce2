<?php

class reviews
 
{
  protected $reviews;
 
  public function __construct($products_id) {
   $reviews_query = tep_db_query("select count(*) as count from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.products_id = '" . (int)$_GET['products_id'] . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$_SESSION['languages_id'] . "' and reviews_status = 1");
    
    $this->reviews = tep_db_num_rows($reviews_query);
  }
  
  public function getReviews() {
  return $this->reviews;
  }
}
