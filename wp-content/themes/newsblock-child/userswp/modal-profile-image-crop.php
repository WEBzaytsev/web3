<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$type  = isset( $_POST['uwp_popup_type'] ) && $_POST['uwp_popup_type'] == 'avatar' ? 'avatar' : 'banner';
$image_url = !empty($args['image_url']) ? esc_url( $args['image_url'] ) : '';
?>
<div class="popup profile-image-upload" id="uwp-popup-modal-wrap">
	<div class="profile-image-upload__title">Загрузить фото профиля</div>
	<div class="profile-image-upload__avatar">
		<img src="<?php echo $image_url; ?>" id="uwp-<?php echo $type; ?>-to-crop" />
	</div>
	<div class="uwp-bs-modal-body user-form">
		<div id="uwp-bs-modal-notice" class="bsui"></div>
		<form class="uwp-crop-form" method="post">
			<input type="hidden" name="x" value="" id="<?php echo $type; ?>-x" />
			<input type="hidden" name="y" value="" id="<?php echo $type; ?>-y" />
			<input type="hidden" name="w" value="" id="<?php echo $type; ?>-w" />
			<input type="hidden" name="h" value="" id="<?php echo $type; ?>-h" />
			<input type="hidden" id="uwp-<?php echo $type; ?>-crop-image" name="uwp_crop" value="<?php echo $image_url; ?>" />
			<input type="hidden" name="uwp_crop_nonce" value="<?php echo wp_create_nonce( 'uwp_crop_nonce_'.$type ); ?>" />
			<input type="submit" name="uwp_<?php echo $type; ?>_crop" value="Применить" id="save_uwp_<?php echo $type; ?>" />
		</form>
	</div>
	<div class="profile-image-upload__cancel">
		<a class="popup__close" onClick="close_popup()">Отменить</a>
	</div>
</div>