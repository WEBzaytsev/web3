<?php
/**
 * Template Name: Сообщество
 */

$current_tab = $_GET['tab'] ?? false;
$current_page = $_GET['pg'] ?? 1;
$posts_per_page = 5;
$user = wp_get_current_user();

get_header(); ?>

<div id="primary" class="cs-content-area community-page">

    <!--    --><?php //do_action('csco_main_before'); ?>

    <div class="community-page__header">
        <!-- <h1 class="community-page__title">
            <?php
            wp_reset_query();
            the_title(); ?>
        </h1> -->

        <div class="community-page__excerpt">
            <?php the_content(); ?>
        </div>

        <!-- <div class="community-page__create-post">
            <a href="/add/" class="community-page__create-post_link"></a>
            <figure class="community-page__create-post_img">
                <img src="<?php echo esc_url(get_avatar_url($user->ID)); ?>"
                     alt="avatar"
                     loading="lazy"
                     width="40"
                     height="40">
            </figure>
            <p class="community-page__create-post_text">
                <?php esc_html_e('Написать свой текст...'); ?>
            </p>
        </div> -->
    </div>

    <div class="community-page__content"
         style="display: none">

        <ul class="community-page__content_tabs"
            role="tablist"
            id="tabs-tab">
            <li class="community-page__content_tab<?php echo !$current_tab || $current_tab == 'last-posts' ? ' active' : ''; ?>"
                role="presentation">
                <a href="<?php esc_attr_e('#last-posts') ?>"
                   class="community-page__content_tab-url">
                    <?php esc_html_e('Самые новые'); ?>
                </a>
            </li>
            <li class="community-page__content_tab<?php echo $current_tab == 'popular-posts' ? ' active' : ''; ?>"
                role="presentation">
                <a href="<?php esc_attr_e('#popular-posts') ?>"
                   class="community-page__content_tab-url">
                    <?php esc_html_e('Самые популярные'); ?>
                </a>
            </li>
        </ul>

        <div class="community-page__tab-content"
             style="display: <?php echo !$current_tab || $current_tab == 'last-posts' ? ' block' : 'none'; ?>"
             data-page="1"
             id="last-posts">
            <?php
            $last_posts_per_page = $posts_per_page;

            if ($current_tab == 'last-posts') {
                $last_posts_per_page *= $current_page;
            }

            $posts_args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => $last_posts_per_page,
                'author__not_in' => get_authors_ids(),
            );

            $posts = query_posts($posts_args);
            get_template_part('/template-parts/posts-list-template'); ?>
        </div>

        <div class="community-page__tab-content"
             style="display: <?php echo $current_tab == 'popular-posts' ? ' block' : 'none'; ?>"
             data-page="1"
             id="popular-posts">
            <?php
            $popular_posts_per_page = $posts_per_page;

            if ($current_tab == 'popular-posts') {
                $popular_posts_per_page *= $current_page;
            }

            $posts_args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => $popular_posts_per_page,
                'author__not_in' => get_authors_ids(),
                'meta_key' => 'post_views_count',
                'orderby' => 'meta_value_num',
                'meta_type' => 'NUMERIC',
                'order' => 'DESC'
            );

            $posts = query_posts($posts_args);
            get_template_part('/template-parts/posts-list-template'); ?>
        </div>
    </div>

</div>

<?php do_action('csco_main_after'); ?>

<!--</div>-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
