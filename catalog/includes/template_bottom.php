<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

?>

</div> <!-- bodyContent //-->

<?php
  if ($oscTemplate->hasBlocks('boxes_column_left')) {
?>

<div id="columnLeft" class="col-md-<?php echo $oscTemplate->getGridColumnWidth(); ?> col-md-pull-<?php echo $oscTemplate->getGridContentWidth(); ?>">
  <?php echo $oscTemplate->getBlocks('boxes_column_left'); ?>
</div>

<?php
  }

  if ($oscTemplate->hasBlocks('boxes_column_right')) {
?>

<div id="columnRight" class="col-md-<?php echo $oscTemplate->getGridColumnWidth(); ?>">
  <?php echo $oscTemplate->getBlocks('boxes_column_right'); ?>
</div>

<?php
  }
?>

</div> <!-- row //-->

</div> <!-- bodyWrapper //-->

<footer>
  <div class="container-fluid row-fluid">
    <div class="col-sm-12 text-center"><?php echo FOOTER_TEXT_BODY; ?></div>
    <?php
    if ($banner = tep_banner_exists('dynamic', 'footer')) {
      ?>

      <div class="col-sm-12 text-center">
        <?php echo tep_display_banner('static', $banner); ?>
      </div>

      <?php
    }
    ?>
  </div>
</footer>

<?php echo $oscTemplate->getBlocks('footer_scripts'); 

 if (STORE_PAGE_PARSE_TIME == 'true') {
   $parse_time = $oscTemplate->getdebuginfo();
    if (DISPLAY_PAGE_PARSE_TIME == 'true') {
      echo '<span class="smallText">Parse Time: ' . $parse_time . 's</span>';
    }
  }
?>
</body>
</html>
<?php
  if ( (GZIP_COMPRESSION == 'true') && ($ext_zlib_loaded == true) && ($ini_zlib_output_compression < 1) ) {
      tep_gzip_output(GZIP_LEVEL);
  }