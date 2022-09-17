<div class="user-auth user-auth_register">
    <div class="user-auth__background">
        <img src="/wp-content/themes/newsblock-child/images/register.png" alt="Register" />
    </div>
    <div class="user-auth__content">
        <div class="user-auth__frame">
            <div class="user-auth__head">
                <div class="user-auth__title">
                    <h1>Регистрация</h1>
                </div>
                <div class="user-auth__sublink-container">
                    <a class="user-auth__sublink" href="<?= uwp_get_login_page_url() ?>">Вход в аккаунт</a>
                </div>
            </div>
            <div class="user-form" enctype="multipart/form-data">
                <form method="post">
                    <?php do_action( 'uwp_template_display_notices', 'register' ); ?>
                    <?php do_action( 'uwp_template_fields', 'register', $args ); ?>
                    <input type="submit" name="uwp_register_submit" value="Зарегистрироваться">
                </form>
            </div>
            <a class="user-auth__sublink" href="<?= uwp_get_login_page_url() ?>">Вход в аккаунт</a>
        </div>
    </div>
</div>