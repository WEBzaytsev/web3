<div class="user-auth user-auth_forgot-password">
    <div class="user-auth__background">
        <img src="/wp-content/themes/newsblock-child/images/password-reset.png" alt="Password reset" />
    </div>
    <div class="user-auth__content">
        <div class="user-auth__frame">
            <div class="user-auth__head">
                <div class="user-auth__title">
                    <h1>Восстановление пароля</h1>
                </div>
            </div>
            <div class="user-form" enctype="multipart/form-data">
                <form method="post">
                    <?php do_action('uwp_template_display_notices', 'forgot'); ?>
                    <?php do_action('uwp_template_fields', 'forgot'); ?>
                    <input type="submit" name="uwp_forgot_submit" value="Отправить">
                </form>
            </div>
        </div>
    </div>
</div>