<div class="user-auth user-auth_password-reset">
    <div class="user-auth__background">
        <img src="/wp-content/themes/newsblock-child/images/password-reset.png" alt="Password reset" />
    </div>
    <div class="user-auth__content">
        <div class="user-auth__frame">
            <div class="user-auth__head">
                <div class="user-auth__title">
                    <h1>Сброс пароля</h1>
                </div>
            </div>
            <div class="user-form" enctype="multipart/form-data">
                <form method="post">
                    <?php do_action('uwp_template_display_notices', 'reset'); ?>
                    <?php do_action('uwp_template_fields', 'reset'); ?>
                    <input type="submit" name="uwp_reset_submit" value="Отправить">
                </form>
            </div>
        </div>
    </div>
</div>