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

  require(DIR_WS_INCLUDES . 'template_top.php');
 
  if (is_null($data['products_id'])) {
    header('HTTP/1.0 404 Not Found');  
    echo $oscTemplate->getContent('notfound'); 
  } else {
    
  if (!isset($data['products_model'])) {
// add the products model to the breadcrumb trail
     $breadcrumb->add($data['products_model'], tep_href_link(FILENAME_PRODUCT_INFO, 'cPath=' . $cPath . '&products_id=' . $data['products_id']));
    }
    
// exexcute the product count query
    $product->countUpdate(); 
?>
 
<?php 
// print the product page module content 
// TODO: pass all html content to product page module
    echo $oscTemplate->getContent('product');
?>
   
<?php    
    if (tep_not_null($attributes->getProductsOptionNameArray())) {     
?>
 
    <div class="page-header">
      <h4><?php echo TEXT_PRODUCT_OPTIONS; ?></h4>
    </div>
 
    <div class="row">
      <div class="col-sm-6">
<?php
// TODO: pass all attributes html content to attributes content module                                                                  
  $products_options_array = $attributes->getProductsOptionsArray();
  $selected_attribute = $attributes->getSelectedAttribute();
  
  foreach ( $attributes->getProductsOptionNameArray() as $key => $value )  {   
?>
      <div class="form-group">
        <label class="control-label col-xs-3"><?php echo $key . ':'; ?></label>
        <div class="col-xs-9">
          <?php echo tep_draw_pull_down_menu('id[' . $value . ']', $products_options_array[$value], $selected_attribute[$value]); ?>
        </div>
      </div>
    <?php
  }
?>
      </div>
    </div>
<?php
    }
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
  }
 
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
