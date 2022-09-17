<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$files = new UsersWP_Files();
$type = isset($_POST['type']) && $_POST['type'] == 'avatar' ? 'avatar' : 'banner';
?>
<div class="popup profile-image-upload" id="uwp-popup-modal-wrap">
	<div class="profile-image-upload__title">Загрузить фото профиля</div>
	<div class="profile-image-upload__avatar">
		<img src="/wp-content/themes/newsblock-child/images/default-avatar.png" alt="Default avatar" />
	</div>
	<div class="uwp-bs-modal-body user-form">
		<div id="uwp-bs-modal-notice" class="bsui"></div>
		<form id="uwp-upload-<?php echo $type; ?>-form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="uwp_upload_nonce" value="<?php echo wp_create_nonce( 'uwp-upload-nonce' ); ?>" />
			<input type="hidden" name="uwp_<?php echo $type; ?>_submit" value="" />
			<button type="button" class="profile-image-upload__button uwp_upload_button" onclick="document.getElementById('uwp_upload_<?php echo $type; ?>').click();">Загрузить файл</button>
			<div class="uwp_upload_field" style="display: none">
				<input name="uwp_<?php echo $type; ?>_file" id="uwp_upload_<?php echo $type; ?>" required="required" type="file" value="">
			</div>
		</form>
		<div id="progressBar" class="tiny-green progressBar" style="display: none;"><div></div></div>
	</div>
	<div class="profile-image-upload__size">Максимальный размер файла: <?= $files->uwp_formatSizeUnits( $files->uwp_get_max_upload_size( $type ) ) ?></div>
</div>