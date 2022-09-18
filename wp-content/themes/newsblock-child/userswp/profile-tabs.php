<?php
/**
 * Profile tabs template (default)
 *
 * @ver 0.0.1
 */
if ( isset( $_GET['tab'] ) ) {
    $current_tab = strip_tags( esc_sql( $_GET['tab'] ) );
} else {
    $current_tab = 'posts';
}

do_action( 'uwp_template_before', 'profile-tabs' );
$user = uwp_get_displayed_user();
if ( ! $user ) {
	return;
}
$avatar_url = get_avatar_url( $user->data->ID );

$posts_count = count_user_posts( $user->ID, 'post', true );
$comments_count = get_comments( [ 'user_id' => $user->ID, 'count' => true ] );

?>
<div class="profile__content content-tabs-frame">
	<?php

	if ( $output === '' || $output == 'head' ) {
		?>
		<ul class="content-tabs"
			role="tablist"
			id="tabs-tab">
			<li class="content-tabs__tab content-tabs__tab_with-padding content-tabs__tab_with-icon content-tabs__tab_with-icon_posts<?= ( $current_tab == 'posts' ) ? ' content-tabs__tab_active' : ''; ?>"
				role="presentation">
				<a href="#posts"
					class="content-tabs__tab-url" data-paginated>
					<?= plural_form( $posts_count, ['статья', 'статьи', 'статей'] ) ?>
				</a>
			</li>
			<li class="content-tabs__tab content-tabs__tab_with-padding content-tabs__tab_with-icon content-tabs__tab_with-icon_comments<?= ( $current_tab == 'comments' ) ? ' content-tabs__tab_active' : ''; ?>"
				role="presentation">
				<a href="#comments"
					class="content-tabs__tab-url" data-paginated>
					<?= plural_form( $comments_count, ['комментарий', 'комментария', 'комментариев'] ) ?>
				</a>
			</li>
		</ul>
		<div id="posts" <?php if( $current_tab != 'posts' ): ?>style="display: none;" <?php endif; ?>>
			<?php
			if( is_user_logged_in() && ( get_current_user_id() == $user->data->ID ) ) {
				?>
					<div class="profile-no-posts">
						<div class="profile-no-posts__title">Вы пока не написали ни одного материала</div>
						<p>Здесь публикуются все тексты наших читателей, которые прошли модерацию.<br />Сюда может написать любой, но сначала стоит изучить правила</p>
					</div>
				<?php
				//}
				?>
				<div class="community-page__create-post profile__create-post">
					<a href="/add/" class="community-page__create-post_link"></a>
					<figure class="community-page__create-post_img">
						<img src="<?php echo esc_url( $avatar_url ); ?>"
								alt="avatar"
								loading="lazy"
								width="40"
								height="40">
					</figure>
					<p class="community-page__create-post_text">
						<?php esc_html_e('Написать свой текст...'); ?>
					</p>
				</div>
				<?php
			}
			?>
			<div class="content-tabs__tab-content">
				<?php
				//$paged = isset( $_GET[ 'pg' ] ) ? max( 1, $_GET[ 'pg' ] ) : 1;
				$page = $_GET[ 'pg' ] ?? 1;
				$posts_per_page = $page * 5;
				$query_args = [
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => 5,
					'author' => $user->ID,
					'posts_per_page' => $paged,
				];
				$the_query = new WP_Query( $query_args );
				if ( $the_query && $the_query->have_posts() ) {

					while ( $the_query->have_posts())  {
						$the_query->the_post();
						uwp_get_template( 'posts-post.php', $args );
					}
				
					/* Restore original Post Data */
					wp_reset_postdata();
				}
				?>
			</div>
			<button class="load-more">
				<?php esc_html_e('Ещё'); ?>
			</button>
		</div>
		<div id="comments" <?php if( $current_tab != 'comments' ): ?>style="display: none;" <?php endif; ?>>
			<div class="content-tabs__tab-content">
				comments
			</div>
		</div>
		<?php
	}
	do_action( 'uwp_template_after', 'profile-tabs' );
	?>
</div>