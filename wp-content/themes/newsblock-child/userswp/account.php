<?php 
echo do_shortcode("[uwp_profile_header disable_greedy=".$args['disable_greedy']."]");
if ( isset( $_GET['type'] ) ) {
    $type = strip_tags( esc_sql( $_GET['type'] ) );
} else {
    $type = 'account';
}
$account_page = uwp_get_page_id( 'account_page', false );
$account_page_link = get_permalink( $account_page );
?>
<a class="profile__back-link" href="<?= uwp_build_profile_tab_url( get_current_user_id() ) ?>">← Вернуться на страницу профиля</a>
<ul class="community-page__content_tabs"
    role="tablist"
    id="tabs-tab">
    <li class="community-page__content_tab<?php print ( $type == 'account' ) ? ' active' : ''; ?>"
        role="presentation">
        <a href="<?= add_query_arg( array( 'type' => 'account', ), $account_page_link ) ?>"
            class="community-page__content_tab-url">
            Данные профиля
        </a>
    </li>
    <li class="community-page__content_tab<?php print ( $type == 'change-password' ) ? ' active' : ''; ?>"
        role="presentation">
        <a href="<?= add_query_arg( array( 'type' => 'change-password', ), $account_page_link ) ?>"
            class="community-page__content_tab-url">
            Изменить пароль
        </a>
    </li>
    <li class="community-page__content_tab<?php print ( $type == 'notifications' ) ? ' active' : ''; ?>"
        role="presentation">
        <a href="<?= add_query_arg( array( 'type' => 'notifications', ), $account_page_link ) ?>"
            class="community-page__content_tab-url">
            Уведомления
        </a>
    </li>
    <li class="community-page__content_tab<?php print ( $type == 'privacy' ) ? ' active' : ''; ?>"
        role="presentation">
        <a href="<?= add_query_arg( array( 'type' => 'privacy', ), $account_page_link ) ?>"
            class="community-page__content_tab-url">
            Конфиденциальность
        </a>
    </li>
    <li class="community-page__content_tab<?php print ( $type == 'delete-account' ) ? ' active' : ''; ?>"
        role="presentation">
        <a href="<?= add_query_arg( array( 'type' => 'delete-account', ), $account_page_link ) ?>"
            class="community-page__content_tab-url">
            Удалить аккаунт
        </a>
    </li>
</ul>
<?php
do_action( 'uwp_template_display_notices', 'account' );
?>
<div class="user-form user-form_account-edit user-form_<?= $type ?>">
    <?php do_action('uwp_account_form_display', $type); ?>
</div>