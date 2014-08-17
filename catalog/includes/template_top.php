<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2014 osCommerce

  Released under the GNU General Public License
*/

  $oscTemplate->buildBlocks();

  if (!$oscTemplate->hasBlocks('boxes_column_left')) {
    $oscTemplate->setGridContentWidth($oscTemplate->getGridContentWidth() + $oscTemplate->getGridColumnWidth());
  }

  if (!$oscTemplate->hasBlocks('boxes_column_right')) {
    $oscTemplate->setGridContentWidth($oscTemplate->getGridContentWidth() + $oscTemplate->getGridColumnWidth());
  }
?>

<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta charset="<?php echo CHARSET; ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo tep_output_string_protected($oscTemplate->getTitle()); ?></title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>" />

<!-- Bootstrap -->
<link href="ext/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<script src="ext/jquery/jquery-1.11.1.min.js"></script>

<script src="ext/bootstrap/js/bootstrap.min.js"></script>

<script src="ext/photoset-grid/jquery.photoset-grid.min.js"></script>

<link rel="stylesheet" href="ext/colorbox/colorbox.css" />
<script type="text/javascript" src="ext/colorbox/jquery.colorbox-min.js"></script>

<!-- Custom -->
<link href="custom.css" rel="stylesheet">
<!-- Custom -->
<link href="user.css" rel="stylesheet">
 
<?php echo $oscTemplate->getBlocks('header_tags'); ?>
</head>
<body>

<div id="bodyWrapper" class="container-fluid">

<div class="row">

<?php

  if ($messageStack->size('header') > 0) {
    echo '<div>' . $messageStack->output('header') . '</div>';
  }
?>

  <div id="storeLogo" class="col-sm-6"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image(DIR_WS_IMAGES . 'store_logo.png', STORE_NAME) . '</a>'; ?></div>

  <div id="headerShortcuts" class="col-sm-6 text-right">
    <div class="btn-group">
<?php
  echo tep_draw_button(HEADER_TITLE_CART_CONTENTS . ($_SESSION['cart']->count_contents() > 0 ? ' (' . $_SESSION['cart']->count_contents() . ')' : ''), 'glyphicon glyphicon-shopping-cart', tep_href_link(FILENAME_SHOPPING_CART)) .
       tep_draw_button(HEADER_TITLE_CHECKOUT, 'glyphicon glyphicon-credit-card', tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL')) .
       tep_draw_button(HEADER_TITLE_MY_ACCOUNT, 'glyphicon glyphicon-user', tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));

  if (isset($_SESSION['customer_id'])) {
    echo tep_draw_button(HEADER_TITLE_LOGOFF, 'glyphicon glyphicon-log-out', tep_href_link(FILENAME_LOGOFF, '', 'SSL'));
  }
?>
    </div>
  </div>

<div class="clearfix"></div>
<div class="col-xs-12"><?php echo $breadcrumb->trail(' &raquo; '); ?></div>

<?php
  if (isset($_GET['error_message']) && tep_not_null($_GET['error_message'])) {
?>
<div class="clearfix"></div>
<div class="col-xs-12">
  <div class="alert alert-danger">
    <a href="#" class="close glyphicon glyphicon-remove" data-dismiss="alert"></a>
    <?php echo htmlspecialchars(stripslashes(urldecode($_GET['error_message']))); ?>
  </div>
</div>
<?php
  }

  if (isset($_GET['info_message']) && tep_not_null($_GET['info_message'])) {
?>
<div class="clearfix"></div>
<div class="col-xs-12">
  <div class="alert alert-info">
    <a href="#" class="close glyphicon glyphicon-remove" data-dismiss="alert"></a>
    <?php echo htmlspecialchars(stripslashes(urldecode($_GET['info_message']))); ?>
  </div>
</div>
<?php
  }
?>

<div id="bodyContent" class="col-md-<?php echo $oscTemplate->getGridContentWidth(); ?> <?php echo ($oscTemplate->hasBlocks('boxes_column_left') ? 'col-md-push-' . $oscTemplate->getGridColumnWidth() : ''); ?>">
