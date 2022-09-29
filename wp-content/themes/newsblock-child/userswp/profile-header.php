<?php
/**
 * Profile header template (default)
 *
 * @ver 0.0.1
 */
global $userswp, $uwp_in_user_loop;
$allow_change = isset( $args['allow_change'] ) ? $args['allow_change'] : '';
$avatar_url   = isset( $args['avatar_url'] ) ? $args['avatar_url'] : '';
$user_id      = isset( $args['user_id'] ) ? $args['user_id'] : '';

do_action( 'uwp_template_before', 'profile-header' );
if( $user_id ){
	$user = get_userdata($user_id);
} else {
	$user = uwp_get_displayed_user();
}

if(!$user){
	return;
}

$account_page = uwp_get_page_id( 'account_page', false );
$can_user_edit_account = apply_filters( 'uwp_user_can_edit_own_profile', true, $user->ID );
$in_account_settings = ( substr( get_page_link(), -9 ) == '/account/' ) ? true : false;

?>
<div class="profile-header">
	<div class="profile-avatar profile-header__avatar">
		<?php if ( !$uwp_in_user_loop && is_user_logged_in() && ( get_current_user_id() == $user->ID ) && $allow_change && !$in_account_settings ): ?>
			<a data-type="avatar" class="uwp-profile-modal-form-trigger profile-avatar__edit-link popup-trigger">
				<img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php _e("User avatar","userswp");?>" />
			</a>
		<?php else: ?>
			<img class="profile-avatar__image" src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php _e("User avatar","userswp");?>" />
		<?php endif; ?>
	</div>
	<div class="profile-header__summary">
		<div class="profile-title">
			<h1 class="profile-title__heading"><?= apply_filters( 'uwp_profile_display_name', esc_attr( $user->display_name ) ) ?></h1>
			<?php if ( ! $uwp_in_user_loop && $account_page && is_user_logged_in() && ( get_current_user_id() == $user->ID ) && $can_user_edit_account && !$in_account_settings ): ?>
			<a href="<?php echo get_permalink( $account_page ); ?>" class="profile-header__edit-link" title="<?php esc_attr_e( 'Edit Account', 'userswp' ); ?>"></a>
			<?php endif; ?>
		</div>
		<?php if( $in_account_settings ): ?>
			<div class="profile-actions">
				<div class="profile-actions__username">@<?= $user->user_login ?></div>
				<a class="profile-actions__logout-link" href="<?= wp_logout_url( apply_filters( 'uwp_logout_url', $redirect, $custom_redirect ) ) ?>">Выйти</a>
			</div>
		<?php else: ?>
			<?php if( ! is_user_logged_in() || get_current_user_id() != $user->ID ): ?>
				<div class="profile-likes">
					<?= do_shortcode('[trianulla_like type="user" id="' . $user->ID . '"]') ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>
<?php do_action( 'uwp_template_after', 'profile-header' ); ?>