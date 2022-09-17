<div class="profile-posts">
<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$the_query = isset( $args['template_args']['the_query'] ) ? $args['template_args']['the_query'] : '';
$user_id      = isset( $args['user_id'] ) ? $args['user_id'] : '';
$avatar_url = isset( $args['template_args']['user']->data->user_avatar ) ? $args['template_args']['user']->data->user_avatar : '';

if( is_user_logged_in() && ( get_current_user_id() == $args['template_args']['the_query']->query['author'] ) ) {
	//if( !$the_query || !$the_query->have_posts( )) {
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
<?php
if ($the_query && $the_query->have_posts()) {

	while ($the_query->have_posts()) {
		$the_query->the_post();
		uwp_get_template('posts-post.php', $args);
	}

	/* Restore original Post Data */
	wp_reset_postdata();
}
?>
</div>
<?php
do_action('uwp_profile_pagination', $the_query->max_num_pages);