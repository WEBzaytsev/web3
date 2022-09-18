<?php 
echo do_shortcode("[uwp_profile_header disable_greedy=".$args['disable_greedy']."]");
if ( isset( $_GET['tab'] ) ) {
    $current_tab = strip_tags( esc_sql( $_GET['tab'] ) );
} else {
    $current_tab = 'account';
}
$account_page = uwp_get_page_id( 'account_page', false );
$account_page_link = get_permalink( $account_page );
$tabs = [ 'account', 'change-password', 'privacy', 'delete-account' ];
$tabs = [
    [
        'type' => 'account',
        'title' => 'Данные профиля'
    ],
    [
        'type' => 'change-password',
        'title' => 'Изменить пароль'
    ],
    [
        'type' => 'privacy',
        'title' => 'Конфиденциальность'
    ],
];
if( 1 != uwp_get_option( 'disable_account_delete' ) && !current_user_can( 'administrator' ) ) {
    $tabs[] = [
        'type' => 'delete-account',
        'title' => 'Удалить аккаунт'
    ];
}
?>
<a class="profile__back-link" href="<?= uwp_build_profile_tab_url( get_current_user_id() ) ?>">← Вернуться на страницу профиля</a>
<div class="content-tabs-frame">
    <ul class="content-tabs"
        role="tablist"
        id="tabs-tab">
        <?php foreach( $tabs as $tab ): ?>
            <li class="content-tabs__tab<?= ( $current_tab == $tab[ 'type' ] ) ? ' content-tabs__tab_active' : ''; ?>"
                role="presentation">
                <a href="#<?= $tab[ 'type' ] ?>"
                    class="content-tabs__tab-url">
                    <?= $tab[ 'title' ] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php
    do_action( 'uwp_template_display_notices', 'account' );
    ?>
    <?php foreach( $tabs as $tab ): ?>
        <div id="<?= $tab[ 'type' ] ?>" <?php if( $current_tab != $tab[ 'type' ] ): ?>style="display: none;" <?php endif; ?>>
            <div class="user-form user-form_account-edit user-form_<?= $tab[ 'type' ] ?> content-tabs__tab-content">
                <?php if( $tab[ 'type' ] == 'privacy' ): ?>
                    <form class="uwp-account-form uwp_form" method="post">
                        <?php $value = get_user_meta( get_current_user_id(), 'uwp_hide_from_listing', true ); ?>
                        <div class="user-form__field">
                            <label class="switcher-container">
                                <div class="switcher">
                                    <input  name="uwp_hide_from_listing" class="<?php checked( $value, "1", true ); ?>"
                                            type="checkbox"
                                            value="<?= $value ?>"
                                            <?php if( $value == 1 ): ?>checked="checked"<?php endif; ?> />
                                    <span class="slider"></span>
                                </div>
                                <span><?php _e( 'Hide profile from the users listing page.', 'userswp' ); ?></span>
                            </label>
                        </div>
                        <input  type="hidden" name="uwp_privacy_nonce"
                                value="<?php echo wp_create_nonce( 'uwp-privacy-nonce' ); ?>"/>
                        <input  name="uwp_privacy_submit" class="<?php echo $bs_btn_class; ?>"
                                value="<?php echo __( 'Submit', 'userswp' ); ?>" type="submit">
                    </form>
                <?php else: ?>
                    <?php do_action( 'uwp_account_form_display', $tab[ 'type' ] ); ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>