<?php
$guest_post = !empty($form_settings['guest_post']) ? $form_settings['guest_post'] : 'false';
?>
<table class="form-table">

    <!-- Added Submission Restriction Settings -->
    <tr>
        <th><?php esc_html_e('Guest Post', FE_TEXT_DOMAIN); ?></th>
        <td>
            <label>
                <?php if (fe_fs()->can_use_premium_code__premium_only()) : ?>
                    <input type="hidden" name="settings[guest_post]" value="false">
                    <input type="checkbox" name="settings[guest_post]" value="true" <?php checked($guest_post, 'true'); ?> />
                    <?php esc_html_e('Enable Guest Post', FE_TEXT_DOMAIN); ?>
                <?php else : ?>
                    <input type="hidden" name="demo_pro_guest_post" value="false">
                    <input type="checkbox" name="demo_pro_guest_post" value="true" <?php checked(false, 'true'); ?> disabled/>
                    <?php esc_html_e('Available in Pro version',FE_TEXT_DOMAIN); ?>
                <?php endif; ?>
            </label>
            <p class="description"><?php esc_html_e('Unregistered users will be able to submit posts', FE_TEXT_DOMAIN); ?>.</p>
        </td>
    </tr>

</table>