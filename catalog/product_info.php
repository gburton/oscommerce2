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
  
    $products_name = $data['products_name'];
    
    if (!is_null($data['products_model'])) {
     $products_name .= '<br /><span class="smallText">[' . $data['products_model'] . ']</span>';

// add the products model to the breadcrumb trail
     $breadcrumb->add($data['products_model'], tep_href_link(FILENAME_PRODUCT_INFO, 'cPath=' . $cPath . '&products_id=' . $data['products_id']));
    }
    
// exexcute the product count query
    $product->countUpdate();
 
// check for special price otherwise will return the list price
    if ($new_price = tep_get_products_special_price($data['products_id'])) {
      $products_price = '<del>' . $currencies->display_price($data['products_price'], tep_get_tax_rate($data['products_tax_class_id'])) . '</del> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($data['products_tax_class_id'])) . '</span>';
    } else {
      $products_price = $currencies->display_price($data['products_price'], tep_get_tax_rate($data['products_tax_class_id']));
    }    
?>
 
<?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product'), 'post', 'class="form-horizontal" role="form"'); ?>
 
<div class="page-header">
  <h1 class="pull-right"><?php echo $products_price; ?></h1>
  <h1><?php echo $products_name; ?></h1>
</div>
 
<div class="contentContainer">
  <div class="contentText">
 
<?php
    if (tep_not_null($data['products_image'])) {
      $photoset_layout = '1';
 
      $pi_query = $product->getHtmlcontent();
      $pi_total = tep_db_num_rows($pi_query);

      if ($pi_total > 0) {
        $pi_sub = $pi_total-1;
 
        while ($pi_sub > 5) {
          $photoset_layout .= 5;
          $pi_sub = $pi_sub-5;
        }
 
        if ($pi_sub > 0) {
          $photoset_layout .= ($pi_total > 5) ? 5 : $pi_sub;
        }
?>
 
    <div id="piGal">
 
<?php
        $pi_counter = 0;
        $pi_html = array();

         while ($pi = tep_db_fetch_array($pi_query)) {
          $pi_counter++;
 
          if (tep_not_null($pi['htmlcontent'])) {
            $pi_html[] = '<div id="piGalDiv_' . $pi_counter . '">' . $pi['htmlcontent'] . '</div>';
          }
 
          echo tep_image(DIR_WS_IMAGES . $pi['image'], '', '', '', 'id="piGalImg_' . $pi_counter . '"');
        }
?>
 
    </div>
 
<?php
        if ( !empty($pi_html) ) {
          echo '    <div style="display: none;">' . implode('', $pi_html) . '</div>';
        }
      } else {
?>
 
    <div id="piGal">
      <?php echo tep_image(DIR_WS_IMAGES . $data['products_image'], addslashes($data['products_name'])); ?>
    </div>
 
<?php
      }
    }
?>
 
<script>
$(function() {
  $('#piGal').css({
    'visibility': 'hidden'
  });
 
  $('#piGal').photosetGrid({
    layout: '<?php echo $photoset_layout; ?>',
    width: '250px',
    highresLinks: true,
    rel: 'pigallery',
    onComplete: function() {
      $('#piGal').css({ 'visibility': 'visible'});
 
      $('#piGal a').colorbox({
        maxHeight: '90%',
        maxWidth: '90%',
        rel: 'pigallery'
      });
 
      $('#piGal img').each(function() {
        var imgid = $(this).attr('id').substring(9);
 
        if ( $('#piGalDiv_' + imgid).length ) {
          $(this).parent().colorbox({ inline: true, href: "#piGalDiv_" + imgid });
        }
      });
    }
  });
});
</script>
 
<?php echo stripslashes($data['products_description']); ?>
 
<?php    
    if (tep_not_null($attributes->getProductsOptionNameArray())) {     
?>
 
    <div class="page-header">
      <h4><?php echo TEXT_PRODUCT_OPTIONS; ?></h4>
    </div>
 
    <div class="row">
      <div class="col-sm-6">
<?php
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
    $reviews = $reviews->getReviews();
?>
 
  <div class="row">
    <div class="col-sm-6 text-right pull-right"><?php echo tep_draw_hidden_field('products_id', $data['products_id']) . tep_draw_button(IMAGE_BUTTON_IN_CART, 'glyphicon glyphicon-shopping-cart', null, 'primary', null, 'btn-success'); ?></div>
    <div class="col-sm-6"><?php echo tep_draw_button(IMAGE_BUTTON_REVIEWS . (($reviews > 0) ? ' (' . $reviews . ')' : ''), 'glyphicon glyphicon-comment', tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params())); ?></div>
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
