<div class="user-auth user-auth_login">
    <div class="user-auth__background">
        <img src="/wp-content/themes/newsblock-child/images/login.png" alt="Login" />
    </div>
    <div class="user-auth__content">
        <div class="user-auth__frame">
            <div class="user-auth__head">
                <div class="user-auth__title">
                    <h1><?php
                    $form_title = ! empty( $args['form_title'] ) || ( isset($args['form_title']) && $args['form_title']=='0' ) ? esc_attr__( $args['form_title'], 'userswp' ) : __( 'Login', 'userswp' );
                    echo apply_filters('uwp_template_form_title',  $form_title, 'login');
                    ?></h1>
                </div>
                <div class="user-auth__sublink-container">
                    <a class="user-auth__sublink" href="<?= uwp_get_register_page_url() ?>">Создать аккаунт</a>
                </div>
            </div>
            <div class="user-form">
                <form method="post" enctype="multipart/form-data">
                    <?php do_action('uwp_template_display_notices', 'login'); ?>
                    <?php do_action('uwp_template_fields', 'login', $args); ?>
                    <input name="remember_me" id="remember_me<?php if(wp_doing_ajax()){echo "_ajax";}?>" value="forever" type="hidden" value="1" />
                    <input type="submit" name="uwp_login_submit" value="Войти">
                </form>
            </div>
            <a class="user-auth__forgot-link" href="<?= uwp_get_forgot_page_url() ?>">Не могу вспомнить пароль</a>
            <a class="user-auth__sublink" href="<?= uwp_get_register_page_url() ?>">Создать аккаунт</a>
        </div>
    </div>
</div>