<?php
/**
 * The template for displaying the Product edit form  
 *
 * Override this template by copying it to yourtheme/wc-vendors/dashboard/
 *
 * @package    WCVendors_Pro
 * @version    1.2.0
 */
/**
 *   DO NOT EDIT ANY OF THE LINES BELOW UNLESS YOU KNOW WHAT YOU'RE DOING 
 *   
*/

$title = 	( is_numeric( $object_id ) ) ? __('Save Changes', 'wcvendors-pro') : __('Add Product', 'wcvendors-pro'); 
$product = 	( is_numeric( $object_id ) ) ? wc_get_product( $object_id ) : null;

// Get basic information for the product 
$product_title     			= ( isset($product) && null !== $product ) ? $product->post->post_title    : ''; 
$product_description        = ( isset($product) && null !== $product ) ? $product->post->post_content  : ''; 
$product_short_description  = ( isset($product) && null !== $product ) ? $product->post->post_excerpt  : ''; 

/**
 *  Ok, You can edit the template below but be careful!
*/
?>

<h2><?php echo $title; ?></h2>

<!-- Product Edit Form -->
<form method="post" action="" id="wcv-product-edit" class="wcv-form wcv-formvalidator"> 

	<!-- Basic Product Details -->
	<div class="wcv-product-basic wcv-product"> 
		<!-- Product Title -->
		<?php WCVendors_Pro_Product_Form::title( $object_id, $product_title ); ?> 
		<!-- Product Description -->
		<?php WCVendors_Pro_Product_Form::description( $object_id, $product_description );  ?>
		<!-- Product Short Description -->
        <hr /><em><strong>Add a short description to appear below the item price</strong></em>
		<?php WCVendors_Pro_Product_Form::short_description( $object_id, $product_short_description);  ?> 
        <hr /><em><strong>Please select the categories that best fit your product</strong></em>
		<!-- Product Categories -->
	    <?php WCVendors_Pro_Product_Form::categories( $object_id, true ); ?>
        <span style="display:none">
	    <!-- Product Tags -->
	    <?php WCVendors_Pro_Product_Form::tags( $object_id ); ?></span>
        <hr /><em><strong>Please select the product attributes for your product. These will assist buyers when they search to items on the site.<br />If you don not see your brand listed, please leave this selection blank.</strong></em>
        <table width="553">
          <tr>
            <td colspan="3"><strong>Select Product Type</strong></td>
            </tr>
          <tr>
            <td width="169"><label>
              <input type="radio" name="RadioGroup1" value="clothes" id="RadioGroup1_0" />
              Clothing</label></td>
          
            <td width="148"><label>
              <input type="radio" name="RadioGroup1" value="men-shoe" id="RadioGroup1_1"  />
              Men's Shoes</label></td>
         
            <td width="220"><label>
              <input type="radio" name="RadioGroup1" value="women-shoe" id="RadioGroup1_2" />
              Women's Shoes</label></td>
          </tr>
        </table>
	    
        <!-- Product Attributes (if any) -->
	     <!-- Product Attributes (if any) -->
	    <div class="control-group"><label for="attribute_values[0][]">Brands</label><div class="control select"><select id="attribute_values[0][]" name="attribute_values[0][]" class="select2" style="" ><option value>Select a Brands</option><option value="an-ren" >An Ren</option><option value="bakers" >Bakers</option><option value="banana-republic" >Banana Republic</option><option value="belizza" >Belizza</option><option value="burberry" >Burberry</option><option value="by-together" >By Together</option><option value="catherines" >Catherines</option><option value="chicos" >Chicos</option><option value="city" >City</option><option value="cole-haan" >Cole Haan</option><option value="dooney-and-burke" >Dooney and Burke</option><option value="eileen-fisher" >Eileen Fisher</option><option value="hd-in-paris" >HD in Paris</option><option value="j-crew" >J Crew</option><option value="jessica-simpson" >Jessica Simpson</option><option value="kasper" >Kasper</option><option value="kate-spade" >Kate Spade</option><option value="lane-bryant" >Lane Bryant</option><option value="ledor" >Ledor</option><option value="lily-pulitzer" >Lily Pulitzer</option><option value="loft" >Loft</option><option value="maggie-barnes" >Maggie Barnes</option><option value="manolo-blahnick" >Manolo Blahnick</option><option value="mike-and-chris" >Mike and Chris</option><option value="my-beloved" >My Beloved</option><option value="other" >Other</option><option value="pour-le-victoire" >Pour le victoire</option><option value="red-poppy" >Red Poppy</option><option value="ruby-road" >Ruby Road</option><option value="sevier" >Sevier</option><option value="stizzoli" >Stizzoli</option><option value="tahari" >Tahari</option><option value="talbots" >Talbots</option><option value="tori-burch" >Tori Burch</option><option value="trina-turk" >Trina Turk</option><option value="vince-camuto" >Vince Camuto</option></select> </div></div>
        
        <div class="control-group"></label><div class="control"><input type="hidden" class="" style="" name="attribute_names[0]" id="attribute_names[0]" value="pa_brands" placeholder=""  /> </div></div><div class="control-group"><label for="attribute_values[1][]">Color</label><div class="control select"><select id="attribute_values[1][]" name="attribute_values[1][]" class="select2" style="" ><option value>Select a Color</option><option value="black" >Black</option><option value="blue" >Blue</option><option value="brown" >Brown</option><option value="gold" >Gold</option><option value="green" >Green</option><option value="grey" >Grey</option><option value="orange" >Orange</option><option value="pink" >Pink</option><option value="purple" >Purple</option><option value="red" >Red</option><option value="silver" >Silver</option><option value="white" >White</option></select> </div></div><div class="control-group"></label><div class="control"><input type="hidden" class="" style="" name="attribute_names[1]" id="attribute_names[1]" value="pa_color" placeholder=""  /> </div></div>
        
        <div class="control-group" id="men_shoe"><label for="attribute_values[2][]">Mens Shoe Size</label><div class="control select"><select id="attribute_values[2][]" name="attribute_values[2][]" class="select2" style="" ><option value>Select a Mens Shoe Size</option><option value="6" >6</option><option value="6-5" >6.5</option><option value="7-5" >7.5</option><option value="8" >8</option><option value="8-5" >8.5</option><option value="9" >9</option><option value="9-5" >9.5</option><option value="7" >7</option><option value="10" >10</option><option value="10-5" >10.5</option><option value="11" >11</option><option value="11-5" >11.5</option><option value="12" >12</option><option value="12-5" >12.5</option><option value="13" >13</option><option value="13-5" >13.5</option><option value="14" >14</option><option value="14-5" >14.5</option><option value="15" >15</option></select> </div></div><div class="control-group"></label><div class="control"><input type="hidden" class="" style="" name="attribute_names[2]" id="attribute_names[2]" value="pa_mens-shoe-size" placeholder=""  /> </div></div>
        
        <div class="control-group" id="wm_shoe"><label for="attribute_values[3][]">Womens Shoe Size</label><div class="control select"><select id="attribute_values[3][]" name="attribute_values[3][]" class="select2" style="" ><option value>Select a Womens Shoe Size</option><option value="4" >4</option><option value="4-5" >4.5</option><option value="5" >5</option><option value="5-5" >5.5</option><option value="6" >6</option><option value="6-5" >6.5</option><option value="7" >7</option><option value="8" >8</option><option value="7-5" >7.5</option><option value="8-5" >8.5</option><option value="9" >9</option><option value="9-5" >9.5</option><option value="10" >10</option><option value="10-5" >10.5</option><option value="11" >11</option><option value="11-5" >11.5</option><option value="12" >12</option></select> </div></div>
        
        <div id="clothes_size"> <div class="control-group"></label><div class="control"><input type="hidden" class="" style="" name="attribute_names[3]" id="attribute_names[3]" value="pa_shoe-size" placeholder=""  /> </div></div><div class="control-group"><label for="attribute_values[4][]">Dress Size</label><div class="control select"><select id="attribute_values[4][]" name="attribute_values[4][]" class="select2" style="" ><option value>Select a Dress Size</option><option value="2" >2</option><option value="4" >4</option><option value="6" >6</option><option value="8" >8</option><option value="10" >10</option><option value="12" >12</option><option value="14" >14</option><option value="16" >16</option><option value="18" >18</option><option value="20" >20</option><option value="22" >22</option><option value="24" >24</option><option value="26" >26</option><option value="small" >Small</option><option value="medium" >Medium</option><option value="large" >Large</option><option value="x-large" >X-Large</option></select> </div></div><div class="control-group"></label><div class="control"><input type="hidden" class="" style="" name="attribute_names[4]" id="attribute_names[4]" value="pa_size" placeholder=""  /> </div></div>	</div></div>


	<div class="all-100"> 
    <hr /><h4>Upload your product images.</h4><br />*Feature images are your main product images and should be high-resoultion, 500 pixels wide x 500 pixels height for best viewing on the site.<br />**Gallery Images are additional (optional) images you would like to post for your item.<br />***The best photos use natural or diffused lighting, and don’t use a flash<br /><br />
    	<!-- Media uploader -->
		<div class="wcv-product-media">
			<?php WCVendors_Pro_Form_helper::product_media_uploader( $object_id ); ?>
		</div>
	</div>

	<hr /><h4>Enter additional product information below</h4>
	
	<div class="all-100" style="display:none">
		<!-- Product Type -->
		<div class="wcv-product-type"> 
			<?php WCVendors_Pro_Product_Form::product_type( $object_id ); ?>
		</div>
	</div>

	<div class="all-100">
		<div class="wcv-tabs top" data-prevent-url-change="true">

			<?php WCVendors_Pro_Product_Form::product_meta_tabs( ); ?>

			<?php do_action( 'wcv_before_general_tab' ); ?>
	
			<!-- General Product Options -->
			<div class="wcv-product-general tabs-content" id="general">
			
				<div class="hide_if_grouped">
					<!-- SKU  -->
					<?php WCVendors_Pro_Product_Form::sku( $object_id ); ?>
					<!-- Private listing  -->
					<?php WCVendors_Pro_Product_Form::private_listing( $object_id ); ?>
				</div>


				<div class="options_group show_if_external">
					<?php WCVendors_Pro_Product_Form::external_url( $object_id ); ?>
					<?php WCVendors_Pro_Product_Form::button_text( $object_id ); ?>
				</div>

				<div >
					<!-- Price and Sale Price -->
					<?php WCVendors_Pro_Product_Form::prices( $object_id ); ?>
				</div>

				<div class="show_if_simple show_if_external"> 
					<!-- Tax -->
					<?php WCVendors_Pro_Product_Form::tax( $object_id ); ?>
				</div>

				<div class="show_if_downloadable" id="files_download">
					<!-- Downloadable files -->
					<?php WCVendors_Pro_Product_Form::download_files( $object_id ); ?>
					<!-- Download Limit -->
					<?php WCVendors_Pro_Product_Form::download_limit( $object_id ); ?>
					<!-- Download Expiry -->
					<?php WCVendors_Pro_Product_Form::download_expiry( $object_id ); ?>
					<!-- Download Type -->
					<?php WCVendors_Pro_Product_Form::download_type( $object_id ); ?>
				</div>
			</div>

			<?php do_action( 'wcv_after_general_tab' ); ?>

			<?php do_action( 'wcv_before_inventory_tab' ); ?>

			<!-- Inventory -->
			<div class="wcv-product-inventory inventory_product_data tabs-content" id="inventory">
				
				<?php WCVendors_Pro_Product_Form::manage_stock( $object_id ); ?>
				
				<?php do_action( 'woocommerce_product_options_stock' ); ?>
				
				<div class="stock_fields show_if_simple show_if_variable">
					<?php WCVendors_Pro_Product_Form::stock_qty( $object_id ); ?>
					<?php WCVendors_Pro_Product_Form::backorders( $object_id ); ?>
				</div>

				<?php WCVendors_Pro_Product_Form::stock_status( $object_id ); ?>
				<div class="options_group show_if_simple show_if_variable">
					<?php WCVendors_Pro_Product_Form::sold_individually( $object_id ); ?>
				</div>

				<?php do_action( 'woocommerce_product_options_sold_individually' ); ?>

				<?php do_action( 'woocommerce_product_options_inventory_product_data' ); ?>

			</div>

			<?php do_action( 'wcv_after_inventory_tab' ); ?>

			<?php do_action( 'wcv_before_shipping_tab' ); ?>

			<!-- Shipping  -->
			<div class="wcv-product-shipping shipping_product_data tabs-content" id="shipping">

				<div class="hide_if_grouped">

					<!-- Shipping rates  -->
					<?php WCVendors_Pro_Product_Form::shipping_rates( $object_id ); ?>	
					<!-- weight  -->
					<?php WCVendors_Pro_Product_Form::weight( $object_id ); ?>
					<!-- Dimensions -->
					<?php WCVendors_Pro_Product_Form::dimensions( $object_id ); ?>
					<?php do_action( 'woocommerce_product_options_dimensions' ); ?>
					<!-- shipping class -->
					<?php WCVendors_Pro_Product_Form::shipping_class( $object_id ); ?>
					<?php do_action( 'woocommerce_product_options_shipping' ); ?>
				</div>
			
			</div>

			<?php do_action( 'wcv_after_shipping_tab' ); ?>

			<?php do_action( 'wcv_before_linked_tab' ); ?>

			<!-- Upsells and grouping -->
			<div class="wcv-product-upsells tabs-content" id="linked_product"> 
				<?php WCVendors_Pro_Product_Form::up_sells( $object_id ); ?>
				
				<?php WCVendors_Pro_Product_Form::crosssells( $object_id ); ?>
			</div>

			<?php do_action( 'wcv_after_linked_tab' ); ?>

			<?php WCVendors_Pro_Product_Form::form_data( $object_id ); ?>
			<?php WCVendors_Pro_Product_Form::save_button( $title ); ?>
			<?php WCVendors_Pro_Product_Form::draft_button( __('Save Draft',' wcvendors-pro') ); ?>

			</div>
		</div>
</form>

<script type="text/javascript">
jQuery(document).ready(function() {
 // hides the slickbox as soon as the DOM is ready
 // jQuery('#clothes_size').hide();

 // toggles the slickbox on clicking the noted link
  jQuery('#RadioGroup1_1').click(function() {
	  jQuery('#clothes_size').hide();
	   jQuery('#wm_shoe').hide();
	   jQuery('#men_shoe').show();
	//return false;
  });
   jQuery('#RadioGroup1_0').click(function() {
	  jQuery('#clothes_size').show();
	   jQuery('#wm_shoe').hide();
	   jQuery('#men_shoe').hide();
	//return false;
  });
   jQuery('#RadioGroup1_2').click(function() {
	  jQuery('#clothes_size').hide();
	   jQuery('#wm_shoe').show();
	   jQuery('#men_shoe').hide();
	//return false;
  });
});
</script>