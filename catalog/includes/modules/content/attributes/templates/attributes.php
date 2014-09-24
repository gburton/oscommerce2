<div class="page-header">
      <h4><?php echo TEXT_PRODUCT_OPTIONS; ?></h4>
    </div>  
    <div class="row">
      <div class="col-sm-6">
<?php  foreach ( $products_options_name_array as $key => $value )  {   ?>
      <div class="form-group">
        <label class="control-label col-xs-3"><?php echo $key . ':'; ?></label>
        <div class="col-xs-9">
          <?php echo tep_draw_pull_down_menu('id[' . $value . ']', $products_options_array[$value], $selected_attribute[$value]); ?>
        </div>
      </div>
<?php  } ?>
      </div>
    </div>