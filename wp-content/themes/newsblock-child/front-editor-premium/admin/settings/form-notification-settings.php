<?php
$admin_notifications = !empty($form_settings['admin_notifications']) ? $form_settings['admin_notifications'] : 'false';
$send_admin_notification_to = isset($form_settings['send_admin_notification_to']) ? $form_settings['send_admin_notification_to'] : __('your_email@example.com', FE_TEXT_DOMAIN);
$send_admin_notification_subject = isset($form_settings['send_admin_notification_subject']) ? $form_settings['send_admin_notification_subject'] : __('New post created - [post_title]', FE_TEXT_DOMAIN);
$send_admin_notification_text = isset($form_settings['send_admin_notification_text']) ? $form_settings['send_admin_notification_text'] : 'Hi Admin,' . PHP_EOL . PHP_EOL . 'A new post has been created in your site [sitename] ([siteurl]).' . PHP_EOL . 'Here is the details: ' . PHP_EOL . 'Post Title: [post_title] ' . PHP_EOL . 'Author: [author_name] ' . PHP_EOL . 'Post URL: [post_link] ' . PHP_EOL . 'Edit URL: [post_link] ' . PHP_EOL;
?>

<table class="form-table">
    <tr class="setting">
        <th><?php esc_html_e('Activate Notifications', FE_TEXT_DOMAIN); ?></th>
        <td>
            <input type="checkbox" name="settings[admin_notifications]" value="true" <?php checked($admin_notifications, 'true'); ?> />
        </td>
    </tr>
    <tr class="send_admin_notification_to">
        <th><?php esc_html_e('To', FE_TEXT_DOMAIN); ?></th>
        <td>
            <input type="text" name="settings[send_admin_notification_to]" value="<?php echo esc_attr($send_admin_notification_to); ?>">
        </td>
    </tr>
    <tr class="send_admin_notification_subject">
        <th><?php esc_html_e('Subject', FE_TEXT_DOMAIN); ?></th>
        <td>
            <input type="text" name="settings[send_admin_notification_subject]" value="<?php echo esc_attr($send_admin_notification_subject); ?>">
        </td>
    </tr>
    <tr class="send_admin_notification_text">
        <th><?php esc_html_e('Post Update Message', FE_TEXT_DOMAIN);?> </th>
        <td>
            <textarea rows="10" cols="80" name="settings[send_admin_notification_text]"><?php echo esc_textarea($send_admin_notification_text); ?></textarea>
        </td>
    </tr>
</table>