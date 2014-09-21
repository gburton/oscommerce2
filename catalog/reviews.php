<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . FILENAME_REVIEWS);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_REVIEWS));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<div class="page-header">
  <h1><?php echo HEADING_TITLE; ?></h1>
</div>

<div class="contentContainer">

<?php

  $reviews_split = $reviews->getReviewssplit($reviews->getReviewsraw());

  if ($reviews_split->number_of_rows > 0) {
    if ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3')) {
?>

  <div class="contentText">
    <p style="float: right;"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info'))); ?></p>

    <p><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></p>
  </div>

  <br />

<?php
    }
    ?>
<div class="row">
<?php
    $reviews_query = tep_db_query($reviews_split->sql_query);
    while ($reviews = tep_db_fetch_array($reviews_query)) {
?>

  <div class="col-sm-6 review">
    <h4><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id=' . $reviews['products_id'] . '&reviews_id=' . $reviews['reviews_id']) . '">' . $reviews['products_name'] . '</a>'; ?></h4>
    <blockquote>
      <p><span class="pull-left"><?php echo tep_image(DIR_WS_IMAGES . tep_output_string_protected($reviews['products_image']), tep_output_string_protected($reviews['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT); ?></span><?php echo tep_output_string_protected($reviews['reviews_text']) . ' ... '; ?></p>
      <div class="clearfix"></div>
      <footer>
        <?php
        $review_name = tep_output_string_protected($reviews['customers_name']);
        echo sprintf(REVIEWS_TEXT_RATED, tep_draw_stars($reviews['reviews_rating']), $review_name, $review_name) . '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id=' . (int)$reviews['products_id']) . '"><span class="pull-right label label-info">' . REVIEWS_TEXT_READ_MORE . '</span></a>'; ?>
      </footer>
    </blockquote>
  </div>

<?php
    }
    ?>
</div>
<?php
  } else {
?>

  <div class="contentText">
    <div class="alert alert-info">
      <?php echo TEXT_NO_REVIEWS; ?>
    </div>
  </div>

<?php
  }

  if (($reviews_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
  <div class="clearfix"></div>
  <br />

  <div class="contentText">
    <p style="float: right;"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info'))); ?></p>

    <p><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></p>
  </div>

<?php
  }
?>

</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
