<?php
/*
  $Id$
 
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
 
  Copyright (c) 2014 osCommerce
 
  Released under the GNU General Public License
*/
 
  require('includes/application_top.php');
 
  require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . FILENAME_PRODUCT_INFO);

// add the product model to the breadcrumb trail
  $product->productBreadcrumb(); 

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
    if ($product->get('products_date_available') > date('Y-m-d H:i:s')) {
?>
    <div class="alert alert-info"><?php echo sprintf(TEXT_DATE_AVAILABLE, tep_date_long($product->get('products_date_available'))); ?></div>
<?php
    }

?>
 
   </div>
 
  <div class="row">
    <div class="col-sm-6 text-right pull-right"><?php echo tep_draw_hidden_field('products_id', $product->get('products_id')) . tep_draw_button(IMAGE_BUTTON_IN_CART, 'glyphicon glyphicon-shopping-cart', null, 'primary', null, 'btn-success'); ?></div>
    <div class="col-sm-6"><?php echo tep_draw_button(IMAGE_BUTTON_REVIEWS . (($reviews->getReviewscount() > 0) ? ' (' . $reviews->getReviewscount() . ')' : ''), 'glyphicon glyphicon-comment', tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params())); ?></div>
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
