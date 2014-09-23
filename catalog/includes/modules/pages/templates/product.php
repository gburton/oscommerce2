<?php
  tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product'), 'post', 'class="form-horizontal" role="form"'); 
?>
<div class="page-header">
  <h1 class="pull-right">
<?php if (isset($specialprice))  { ?>
    <del><?php echo $price ?></del>
    <span class="productSpecialPrice"><?php echo $specialprice ?></span>
<?php   } else { 
      echo $price;
      }
?>
  </h1>  
  <h1><?php echo $oscTemplate->_data[$this->group]['products_name']; ?></h1>
<?php if (!empty($oscTemplate->_data[$this->group]['products_model'])) { ?> 
    <span class="smallText">[<?php echo $oscTemplate->_data[$this->group]['products_model'] ?>]</span> 
<?php } ?>
</div>
<div class="contentContainer">
  <div class="contentText">
     <div id="piGal">  
<?php   if (is_array($image))  {  
          foreach ($image as $key => $img)  {
            echo $img['image'] ; 
             if ( !empty($img['htmlcontent']) ) { ?>
              <div style="display: none;"><div id="piGalDiv_<?php echo $key ?>'"><?php echo $img['htmlcontent'] ?></div></div>
<?php     
            }
          } 
?>
     </div>
<?php     
       } else  {   
    echo $image . '</div>'; 
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
<?php echo stripslashes($oscTemplate->_data[$this->group]['products_description']); ?>    
