<?php
$user = $args[ 'user' ];
$meta = get_user_meta( $user->ID );
$avatar_url = get_avatar_url( $user->ID );
$posts_count = count_user_posts( $user->ID, 'post', true );
$comments_count = get_comments( [ 'user_id' => $user->ID, 'count' => true ] );
?>
<div class="user-card">
    <div class="user-card__avatar">
        <a href="<?= uwp_build_profile_tab_url( $user->ID ) ?>">
            <img src="<?= esc_url( $avatar_url ); ?>" alt="<?php _e("User avatar","userswp");?>" />
        </a>
    </div>
    <div class="user-card__content">
        <a href="<?= uwp_build_profile_tab_url( $user->ID ) ?>" class="user-card__name"><?= esc_html( $user->display_name ) ?></a>
        <div class="user-card__description">
            <?= esc_html( $meta[ 'description' ][ 0 ] ) ?>
        </div>
        <div class="user-card__actions">
            <?= do_shortcode('[trianulla_like type="user" id="' . $user->ID . '"]') ?>
            <a href="<?= uwp_build_profile_tab_url( $user->ID ) . '?tab=comments' ?>" class="user-card__action user-card__action_comments"><?= $comments_count ?></a>
            <a href="<?= uwp_build_profile_tab_url( $user->ID ) ?>" class="user-card__action user-card__action_posts"><?= $posts_count ?></a>
        </div>
    </div>
</div>