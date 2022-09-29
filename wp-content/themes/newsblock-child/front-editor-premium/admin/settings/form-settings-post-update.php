<?php
$update_message = isset($form_settings['update_message']) ? $form_settings['update_message'] : __('Post updated successfully', FE_TEXT_DOMAIN);
$post_update_button_text = isset($form_settings['post_update_button_text']) ? $form_settings['post_update_button_text'] : __('Update', FE_TEXT_DOMAIN);
$redirect_to          = isset($form_settings['edit_redirect_to']) ? $form_settings['edit_redirect_to'] : 'same';
?>
<table class="form-table">

    <!-- Post redirection settings  -->
    <tr class="setting">
        <th><?= __('Redirect To', FE_TEXT_DOMAIN) ?></th>
        <td>
            <select name="settings[post_update_redirect_to]" id="post_update_redirect_to">
                <?php
                $options = [
                    'disable' => __('No Redirect', FE_TEXT_DOMAIN),
                    'post' => __('Newly created post', FE_TEXT_DOMAIN),
                    'url' => __('To a custom URL', FE_TEXT_DOMAIN)
                ];

                $options_selected = isset($form_settings['post_update_redirect_to']) ? $form_settings['post_update_redirect_to'] : 'disable';

                foreach ($options as $option => $label) {
                    printf('<option value="%s"%s>%s</option>', esc_attr($option), esc_attr(selected($options_selected, $option, false)), esc_html($label));
                }; ?>
            </select>
            <p class="description"><?= __('After successfully submit, where the page will redirect to', FE_TEXT_DOMAIN) ?></p>
        </td>
    </tr>

    <tr class="setting hidden_element" id="post_update_redirect_to_link">
        <th><?= __('Custom URL', FE_TEXT_DOMAIN) ?></th>
        <td>
            <input type="text" name="settings[post_update_redirect_to_link]" value="<?php echo esc_attr($settings['post_update_redirect_to_link']); ?>">
        </td>
    </tr>
    <!-- Post redirection settings  -->
    
    <tr class="update-message">
        <th><?php esc_html_e('Post Update Message', FE_TEXT_DOMAIN); ?></th>
        <td>
            <textarea rows="3" cols="40" name="settings[update_message]"><?php echo esc_textarea($update_message); ?></textarea>
        </td>
    </tr>
    <tr class="post_update_button_text">
        <th><?php esc_html_e('Update Post Button text', FE_TEXT_DOMAIN); ?></th>
        <td>
            <input type="text" name="settings[post_update_button_text]" value="<?php echo esc_attr($post_update_button_text); ?>">
        </td>
    </tr>
</table>