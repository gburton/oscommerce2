<?php
/*
  $Id$
 
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
 
  Copyright (c) 2014 osCommerce
 
  Released under the GNU General Public License
*/
 
  require('includes/application_top.php');
 
  if (!isset($_GET['products_id'])) {
    tep_redirect(tep_href_link(FILENAME_DEFAULT));
    exit;
  }
  
  require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . FILENAME_PRODUCT_INFO);
  
  $data = $product->getData();

  if (isset($data['products_model'])) {
// add the products model to the breadcrumb trail
    $breadcrumb->add($data['products_model'], tep_href_link(FILENAME_PRODUCT_INFO, 'cPath=' . $cPath . '&products_id=' . $data['products_id']));
  }

  require(DIR_WS_INCLUDES . 'template_top.php');
    
// exexcute the product count query
    $product->countUpdate(); 

// print the product page module content 
    echo $oscTemplate->getContent('product');
// load attributes content module
if  (defined('MODULE_CONTENT_ATTRIBUTES_STATUS')) echo $oscTemplate->getContent('attributes');
?>
    <div class="clearfix"></div>
<?php
    if ($data['products_date_available'] > date('Y-m-d H:i:s')) {
?>
    <div class="alert alert-info"><?php echo sprintf(TEXT_DATE_AVAILABLE, tep_date_long($data['products_date_available'])); ?></div>
<?php
    }
?>
 
   </div>
 
<?php
    $reviews = $reviews->getReviewscount();
?>
 
  <div class="row">
    <div class="col-sm-6 text-right pull-right"><?php echo tep_draw_hidden_field('products_id', $data['products_id']) . tep_draw_button(IMAGE_BUTTON_IN_CART, 'glyphicon glyphicon-shopping-cart', null, 'primary', null, 'btn-success'); ?></div>
    <div class="col-sm-6"><?php echo tep_draw_button(IMAGE_BUTTON_REVIEWS . (($reviews['count'] > 0) ? ' (' . $reviews['count'] . ')' : ''), 'glyphicon glyphicon-comment', tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params())); ?></div>
  </div>
 
<?php
    if ((USE_CACHE == 'true') && empty($SID)) {
      echo tep_cache_also_purchased(3600);
    } else {
      include(DIR_WS_MODULES . FILENAME_ALSO_PURCHASED_PRODUCTS);
    }
?>
 
</div>
 
</form>
 
<?php
 
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
