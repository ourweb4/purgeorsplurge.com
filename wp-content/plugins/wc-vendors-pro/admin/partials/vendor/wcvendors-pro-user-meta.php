<?php

/**
 * The extended user meta fields
 *
 * This file is used to display the pro user meta fields on the edit screen. 
 *
 * @link       http://www.wcvendors.com
 * @since      1.2.3
 *
 * @package    WCVendors_Pro
 * @subpackage WCVendors_Pro/admin/partials/vendors
 */ 

// Store Meta fields 
foreach ( $fields as $fieldset ) : ?>
<h3><?php echo $fieldset['title']; ?></h3>
<table class="form-table">
	<?php
	foreach ( $fieldset['fields'] as $key => $field ) :
		?>
		<tr>
			<th><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label></th>
			<td>
				<?php if ( ! empty( $field['type'] ) && 'select' == $field['type'] ) : ?>
					<select name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" class="<?php echo ( ! empty( $field['class'] ) ? $field['class'] : '' ); ?>" style="width: 25em;">
						<?php
							$selected = esc_attr( get_user_meta( $user->ID, $key, true ) );
							foreach ( $field['options'] as $option_key => $option_value ) : ?>
							<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $selected, $option_key, true ); ?>><?php echo esc_attr( $option_value ); ?></option>
						<?php endforeach; ?>
					</select>
					<span class="description"><?php echo wp_kses_post( $field['description'] ); ?></span>
				<?php elseif ( ! empty( $field['type'] ) && 'checkbox' == $field['type'] ) : ?>
					<label for="<?php echo esc_attr( $key ); ?>">
						<input type="checkbox" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" <?php checked( 'on', get_user_meta( $user->ID, esc_attr( $key ), true ), true ); ?> />
						<?php echo esc_html( $field['description'] ); ?>
					</label>
				<?php else : ?>
					<input type="text" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( get_user_meta( $user->ID, $key, true ) ); ?>" class="<?php echo ( ! empty( $field['class'] ) ? $field['class'] : 'regular-text' ); ?>" />
					<span class="description"><?php echo wp_kses_post( $field['description'] ); ?></span>
				<?php endif; ?>
				<br/>
				
			</td>
		</tr>
		<?php
	endforeach;
	?>
</table>
<?php
endforeach;
?>

<!-- Branding -->

<?php do_action( 'wcv_admin_before_store_branding', $user ); ?>
<?php 
	
	$banner_id  = get_user_meta( $user->ID, '_wcv_store_banner_id', true ); 
	$banner_src = wp_get_attachment_image_src( $banner_id, 'medium' );
	$has_banner = is_array( $banner_src );

	$icon_id  = get_user_meta( $user->ID, '_wcv_store_icon_id', true ); 
	$icon_src = wp_get_attachment_image_src( $icon_id, 'thumbnail' );
	$has_icon = is_array( $icon_src );

?>
<h3><?php _e( 'Store Branding', 'wcvendors' ); ?></h3>
<table class="form-table">
	<tbody>
	<!-- Store Banner -->
	<tr>
		<th><label for="_wcv_store_banner_id"><?php _e( 'Store Banner', 'wcvendors-pro' ); ?></label></th>
		<td>
			<div class="wcv-file-uploader_wcv_store_banner_id">
				<?php if ( $has_banner ) : ?><img src="<?php echo $banner_src[0]; ?>" alt="" style="max-width:100%;" /><?php else: ?><?php _e('Upload an image for the banner.', 'wcvendors-pro' ); ?><?php endif; ?>
			</div>
			<br />
	        <input id="_wcv_add_wcv_store_banner_id" type="button" class="button" value="<?php _e( 'Add Banner', 'wcvendors-pro' ); ?>" />
	        <input id="_wcv_remove_wcv_store_banner_id" type="button" class="button" value="<?php _e( 'Remove Banner', 'wcvendors-pro' ); ?>" />
			<input type="hidden" name="_wcv_store_banner_id" id="_wcv_store_banner_id" data-save_button="<?php _e( 'Add Banner', 'wcvendors-pro' ); ?>" data-window_title="<?php _e( 'Add Banner', 'wcvendors-pro' ); ?>" data-upload_notice="<?php _e('Upload an image for the banner.', 'wcvendors-pro' ); ?>" value="<?php echo $banner_id; ?>">
		</td>
	</tr>
	<!-- Store Icon -->
	<tr>
		<th><label for="_wcv_store_icon_id"><?php _e( 'Store Icon', 'wcvendors-pro' ); ?></label></th>
		<td>
			<div class="wcv-file-uploader_wcv_store_icon_id">
				<?php if ( $has_icon ) : ?><img src="<?php echo $icon_src[0]; ?>" alt="" style="max-width:100%;" /><?php else: ?><?php _e('Upload an image for the store icon.', 'wcvendors-pro' ); ?><?php endif; ?>
			</div>
			<br />
	        <input id="_wcv_add_wcv_store_icon_id" type="button" class="button" value="<?php _e( 'Add Icon', 'wcvendors-pro' ); ?>" />
	        <input id="_wcv_remove_wcv_store_icon_id" type="button" class="button" value="<?php _e( 'Remove Icon', 'wcvendors-pro' ); ?>" />
			<input type="hidden" name="_wcv_store_icon_id" id="_wcv_store_icon_id" value="<?php echo $icon_id; ?>">
		</td>
	</tr>
	</tbody>
</table>
<?php do_action( 'wcv_admin_after_store_branding', $user ); ?>

