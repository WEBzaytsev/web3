<?php
$comment_status        = isset($form_settings['comment_status']) ? $form_settings['comment_status'] : 'open';
$submit_text           = isset($form_settings['submit_text']) ? $form_settings['submit_text'] : __('Submit', FE_TEXT_DOMAIN);
$post_added_message = isset($form_settings['post_added_message']) ? $form_settings['post_added_message'] : __('New post created', FE_TEXT_DOMAIN);
?>
<table class="form-table">
    <tr class="setting">
        <th><?= __('Post Status', FE_TEXT_DOMAIN) ?></th>
        <td>
            <select name="settings[fe_post_status]" id="fe_settings_post_status">
                <?php
                $post_statuses = [
                    'publish' => __('Publish', FE_TEXT_DOMAIN),
                    'pending' => __('Pending', FE_TEXT_DOMAIN)
                ];

                $post_status_selected    = isset($form_settings['fe_post_status']) ? $form_settings['fe_post_status'] : 'publish';

                foreach ($post_statuses as $status => $label) {
                    printf('<option value="%s"%s>%s</option>', esc_attr($status), esc_attr(selected($post_status_selected, $status, false)), esc_html($label));
                }; ?>
            </select>
        </td>
    </tr>
    <tr class="setting">
        <th><?= __('Add new button', FE_TEXT_DOMAIN) ?></th>
        <td>
            <select name="settings[fe_add_new_button]" id="fe_add_new_button">
                <?php
                $options = [
                    'display' => __('Display', FE_TEXT_DOMAIN),
                    'always_display' => __('Always display', FE_TEXT_DOMAIN),
                    'disable' => __('Disable', FE_TEXT_DOMAIN)
                ];

                $options_selected = isset($form_settings['fe_add_new_button']) ? $form_settings['fe_add_new_button'] : 'display';

                foreach ($options as $option => $label) {
                    printf('<option value="%s"%s>%s</option>', $option, selected($options_selected, $option, false), esc_html($label));
                }; ?>
            </select>
            <p class="description"><?= __('It will show add new button after post creation or on editing', FE_TEXT_DOMAIN) ?></p>
        </td>
    </tr>

    <!-- Post redirection settings  -->
    <tr class="setting">
        <th><?= __('Redirect To', FE_TEXT_DOMAIN) ?></th>
        <td>
            <select name="settings[post_redirect_to]" id="post_redirect_to">
                <?php
                $options = [
                    'disable' => __('No Redirect', FE_TEXT_DOMAIN),
                    'post' => __('Newly created post', FE_TEXT_DOMAIN),
                    'url' => __('To a custom URL', FE_TEXT_DOMAIN)
                ];

                $options_selected = isset($form_settings['post_redirect_to']) ? $form_settings['post_redirect_to'] : 'disable';

                foreach ($options as $option => $label) {
                    printf('<option value="%s"%s>%s</option>', esc_attr($option), esc_attr(selected($options_selected, $option, false)), esc_html($label));
                }; ?>
            </select>
            <p class="description"><?= __('After successfully submit, where the page will redirect to', FE_TEXT_DOMAIN) ?></p>
        </td>
    </tr>

    <tr class="setting hidden_element" id="post_redirect_to_link">
        <th><?= __('Custom URL', FE_TEXT_DOMAIN) ?></th>
        <td>
            <input type="text" name="settings[post_redirect_to_link]" value="<?php echo esc_attr($settings['post_redirect_to_link']); ?>">
        </td>
    </tr>
    <!-- Post redirection settings  -->

    <tr class="setting">
        <th><?= __('Draft button', FE_TEXT_DOMAIN) ?></th>
        <td>
            <select name="settings[save_draft]" id="save_draft">
                <?php
                $options = [
                    'display' => __('Display', FE_TEXT_DOMAIN),
                    'disable' => __('Disable', FE_TEXT_DOMAIN)
                ];

                $options_selected = isset($form_settings['save_draft']) ? $form_settings['save_draft'] : 'display';

                foreach ($options as $option => $label) {
                    printf('<option value="%s"%s>%s</option>', esc_attr($option), esc_attr(selected($options_selected, $option, false)), esc_html($label));
                }; ?>
            </select>
            <p class="description"><?= __('Show button save to draft', FE_TEXT_DOMAIN) ?></p>
        </td>
    </tr>
    <tr class="setting">
        <th><?php esc_html_e('Save draft button text', FE_TEXT_DOMAIN); ?></th>
        <td>
            <input type="text" name="settings[save_draft_button_text]" value="<?php echo isset($form_settings['save_draft_button_text']) ? esc_attr($form_settings['save_draft_button_text']) : __('Save Draft', FE_TEXT_DOMAIN); ?>">
        </td>
    </tr>
    <tr class="setting">
        <th><?php esc_html_e('Comment Status', 'wp-user-frontend'); ?></th>
        <td>
            <select name="settings[comment_status]">
                <option value="open" <?php selected($comment_status, 'open'); ?>><?php esc_html_e('Open', FE_TEXT_DOMAIN); ?></option>
                <option value="closed" <?php selected($comment_status, 'closed'); ?>><?php esc_html_e('Closed', FE_TEXT_DOMAIN); ?></option>
            </select>
        </td>
    </tr>
    <tr class="setting-submit-text">
        <th><?php esc_html_e('Submit Post Button text', 'wp-user-frontend'); ?></th>
        <td>
            <input type="text" name="settings[submit_text]" value="<?php echo esc_attr($submit_text); ?>">
        </td>
    </tr>
    <tr class="setting-post_added_message">
        <th><?php esc_html_e('Post Added Message', FE_TEXT_DOMAIN); ?></th>
        <td>
            <textarea rows="3" cols="40" name="settings[post_added_message]"><?php echo esc_textarea($post_added_message); ?></textarea>
        </td>
    </tr>
</table>