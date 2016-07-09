<?php

/**
 * The store shipping type override
 *
 * This file is used to display the shipping type override in the edit user screen
 *
 * @link       http://www.wcvendors.com
 * @since      1.2.0
 *
 * @package    WCVendors_Pro
 * @subpackage WCVendors_Pro/admin/partials/store
 */ 
?>

<!-- Shipping Override -->
<?php do_action( 'wcv_admin_before_store_shipping', $user ); ?>

<h3><?php _e( 'Store Shipping', 'wcvendors' ); ?></h3>
<table class="form-table">
	<tbody>
	<tr>
		<th><label for="_wcv_shipping_type"><?php _e( 'Shipping Type', 'wcvendors-pro' ); ?></label></th>
		<td>
			<select id="_wcv_shipping_type" name="_wcv_shipping_type">
			<option></option>
			<?php 
				foreach ( WCVendors_Pro_Shipping_Controller::shipping_types() as $option => $option_name ) {
					$selected = selected( $option, get_user_meta( $user->ID, '_wcv_shipping_type', true ), false );
					echo '<option value="' . $option . '" ' . $selected . '>' . $option_name . '</option>';
				}	
			 ?>
			</select>
			<br />
			<span class="description"><?php _e( 'You can override the global setting for shipping type for this vendor.', 'wcvendors-pro'); ?></span>
		</td>
	</tr>
	</tbody>
</table>

<?php do_action( 'wcv_admin_after_store_shipping', $user ); ?>