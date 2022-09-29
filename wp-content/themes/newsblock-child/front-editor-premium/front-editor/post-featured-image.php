<?php 
$thumb_id = 0;
if (has_post_thumbnail($post_id)) {
    $thumb_id = get_post_thumbnail_id($post_id);
    $style = sprintf('style="background:url(%s)"', wp_get_attachment_url($thumb_id));
    $class = 'chosen';
    $thumb_exist = 1;
}
?>
<input type="hidden" name="post_image_required" value="<?= $field['required']?1:0; ?>">
<input type="hidden" id="post_image_wp_media_uploader" name="post_image_wp_media_uploader" value="<?= $field['wp_media_uploader']?1:0; ?>">
<input type="hidden" id="thumb_img_id" name="thumb_img_id" value="<?= $thumb_id ?? 0 ?>">
<div class="image_loader editor-button <?= $class ?? '' ?>" thumb_exist="<?= $thumb_exist ?? 0 ?>">
    <input name="post_thumbnail" type='file' id="img_inp" accept="image/*" title="<?php echo __('Set featured image', FE_TEXT_DOMAIN); ?>"/>
    <label class="thumbnail" for="img_inp">
        <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21 17.0003C21 17.5307 20.7893 18.0394 20.4142 18.4145C20.0391 18.7896 19.5304 19.0003 19 19.0003H3C2.46957 19.0003 1.96086 18.7896 1.58579 18.4145C1.21071 18.0394 1 17.5307 1 17.0003V6.00031C1 4.90031 1.9 4.00031 3 4.00031H6L8 1.00031H14L16 4.00031H19C19.5304 4.00031 20.0391 4.21102 20.4142 4.58609C20.7893 4.96116 21 5.46987 21 6.00031V17.0003Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M11 15.0003C13.2091 15.0003 15 13.2094 15 11.0003C15 8.79117 13.2091 7.00031 11 7.00031C8.79086 7.00031 7 8.79117 7 11.0003C7 13.2094 8.79086 15.0003 11 15.0003Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span>Выбрать обложку</span>
    </label>
    <img <?= $style ?? '' ?> id="post_thumbnail_image" src="data:image/jpeg;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=" />
    <img src="<?= FE_PLUGIN_URL . '/assets/img/cancel.svg' ?>" class="bfe-remove-image">
</div>
<div class="image_loader__error"></div>