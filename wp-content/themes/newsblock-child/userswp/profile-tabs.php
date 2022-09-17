<?php
/**
 * Profile tabs template (default)
 *
 * @ver 0.0.1
 */
$css_class    = ! empty( $args['css_class'] ) ? esc_attr( $args['css_class'] ) : '';
$output       = ! empty( $args['output'] ) ? esc_attr( $args['output'] ) : '';
$account_page = uwp_get_page_id( 'account_page', false );
$tabs_array   = $args['tabs_array'];
$active_tab   = $args['active_tab'];

do_action( 'uwp_template_before', 'profile-tabs' );
$user = uwp_get_displayed_user();
if ( ! $user ) {
	return;
}

$posts_count = count_user_posts( $user->ID, 'post', true );
$comments_count = get_comments( [ 'user_id' => $user->ID, 'count' => true ] );

?>
<div class="profile__content">
	<?php

	if ( $output === '' || $output == 'head' ) {
		?>
		<ul class="community-page__content_tabs"
			role="tablist"
			id="tabs-tab">
			<li class="community-page__content_tab community-page__content_tab_with-icon community-page__content_tab_posts<?php print ( $active_tab == 'posts' ) ? ' active' : ''; ?>"
				role="presentation">
				<a href="<?php echo esc_url( uwp_build_profile_tab_url( $user->ID, 'posts', false ) ); ?>"
					class="community-page__content_tab-url">
					<?= plural_form( $posts_count, ['статья', 'статьи', 'статей'] ) ?>
				</a>
			</li>
			<li class="community-page__content_tab community-page__content_tab_with-icon community-page__content_tab_comments<?php print ( $active_tab == 'user-comments' ) ? ' active' : ''; ?>"
				role="presentation">
				<a href="<?php echo esc_url( uwp_build_profile_tab_url( $user->ID, 'user-comments', false ) ); ?>"
					class="community-page__content_tab-url">
					<?= plural_form( $comments_count, ['комментарий', 'комментария', 'комментариев'] ) ?>
				</a>
			</li>
			<?php
			if ( ! empty( $tabs_array ) ) {
				foreach ( $tabs_array as $tab ) {
					$tab_id  = $tab['tab_key'];
					if ( $active_tab == $tab_id ) {
						$active_tab_content = $tab['tab_content_rendered'];
					}
				}
			}
			?>
		</ul>
		<?php
	}
	if ( $output === '' || $output == 'body' ) {
		if ( isset( $active_tab_content ) && ! empty( $active_tab_content ) ) {
			echo $active_tab_content;
		}
	}
	do_action( 'uwp_template_after', 'profile-tabs' );
	?>
</div>