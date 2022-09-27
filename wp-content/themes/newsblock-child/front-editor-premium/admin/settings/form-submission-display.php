<table class="form-table">

    <tr class="setting">
        <th><?= __('Form Theme', FE_TEXT_DOMAIN) ?></th>
        <td>
            <select name="settings[form_theme]" id="labe_position">
                <?php
                $options = [
                    'default' => __('Default Theme', FE_TEXT_DOMAIN),
                    'no_style' => __('No Style', FE_TEXT_DOMAIN)
                ];

                $options_selected = isset($form_settings['form_theme']) ? $form_settings['form_theme'] : 'default';

                foreach ($options as $option => $label) {
                    printf('<option value="%s"%s>%s</option>', esc_attr($option), esc_attr(selected($options_selected, $option, false)), esc_html($label));
                }; ?>
            </select>
            <p class="description"><?= __('Select form theme', FE_TEXT_DOMAIN) ?></p>
        </td>
    </tr>

    <tr class="setting">
        <th><?= __('Custom css for form', FE_TEXT_DOMAIN) ?></th>
        <td>
            <textarea id="fus_code_editor_page_css" rows="10" name="settings[form_custom_css]" class="widefat textarea"><?php echo wp_unslash($form_settings['form_theme']??''); ?></textarea>
        </td>
    </tr>

</table>