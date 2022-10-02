<?php
$get_author_id = get_the_author_meta('ID');
$author_avatar_url = get_avatar_url($get_author_id);
$author_name = get_the_author_meta('display_name');
$author_url = get_the_author_meta('nickname');
$post_tags = get_the_tags();
$post_excerpt = get_the_excerpt();
$post_cats = get_the_category($post->ID);
$post_views = csco_get_post_view();
?>
<article class="community-page__post">
    <header class="community-page__post_header">
        <address class="community-page__post_address">
            <a href="/profile/<?php echo $author_url ?>"
               class="community-page__post_author-url">
                <img src="<?php echo esc_url($author_avatar_url) ?>"
                     alt="img"
                     loading="lazy"
                     width="20"
                     class="community-page__post_author-avatar"
                     height="20">
                <span rel="author"
                      class="community-page__post_author-name">
                    <?php esc_html_e($author_name); ?>
                </span>
            </a>
            <div class="community-page__post_views">
                <svg width="14"
                     height="14"
                     viewBox="0 0 14 14"
                     fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.583332 7.00001C0.583332 7.00001 2.91667 2.33334 7 2.33334C11.0833 2.33334 13.4167 7.00001 13.4167 7.00001C13.4167 7.00001 11.0833 11.6667 7 11.6667C2.91667 11.6667 0.583332 7.00001 0.583332 7.00001Z"
                          stroke="#818181"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                    <path d="M7 8.75C7.9665 8.75 8.75 7.9665 8.75 7C8.75 6.0335 7.9665 5.25 7 5.25C6.0335 5.25 5.25 6.0335 5.25 7C5.25 7.9665 6.0335 8.75 7 8.75Z"
                          stroke="#818181"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
                <span class="community-page__post_views-count">
                    <?php echo $post_views ?: '0'; ?>
                </span>
            </div>
            <time class="community-page__post_date">
                <?php echo get_the_date(); ?>
            </time>
        </address>
    </header>
    <section class="community-page__post_content">
        <h2 class="community-page__post_title">
            <a href="<?php echo esc_url(get_permalink()); ?>">
                <?php the_title(); ?>
            </a>
        </h2>
        <?php if (get_the_post_thumbnail()) : ?>
            <figure class="community-page__post_thumbnail">
                <a href="<?php echo esc_url(get_permalink()); ?>">
                    <?php echo get_the_post_thumbnail(); ?>
                </a>
            </figure>
        <?php endif; ?>
    </section>
    <footer class="community-page__post_footer">
        <div class="community-page__post_likes">
            <?= do_shortcode('[webtree_like type="post" id="' . $post->ID . '"]') ?>
            <!--<?php echo do_shortcode('[posts_like_dislike id=' . $post->ID . ']'); ?>-->
        </div>
        <a href="<?php echo esc_url(get_permalink()); ?>#comments"
           class="community-page__post_comments">
            <svg width="24"
                 height="24"
                 viewBox="0 0 24 24"
                 fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M21 11.5C21.0034 12.8199 20.6951 14.1219 20.1 15.3C19.3944 16.7117 18.3098 17.8992 16.9674 18.7293C15.6251 19.5594 14.0782 19.9994 12.5 20C11.1801 20.0034 9.87812 19.6951 8.7 19.1L3 21L4.9 15.3C4.30493 14.1219 3.99656 12.8199 4 11.5C4.00061 9.92176 4.44061 8.37485 5.27072 7.03255C6.10083 5.69025 7.28825 4.60557 8.7 3.9C9.87812 3.30493 11.1801 2.99656 12.5 3H13C15.0843 3.11499 17.053 3.99476 18.5291 5.47086C20.0052 6.94695 20.885 8.91565 21 11V11.5Z"
                      stroke="#BDBDBD"
                      stroke-width="1.5"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
            <span class="community-page__post_comments-count">
                <?php echo get_comments_number(); ?>
            </span>
        </a>
        <?php if (count($post_cats)) : ?>
            <ul class="community-page__post_cats">
                <?php foreach ($post_cats as $post_cat) : ?>
                    <li class="community-page__post_cat">
                        <a href="/category/<?php esc_attr_e($post_cat->slug); ?>">
                            <?php esc_html_e($post_cat->cat_name); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </footer>
</article>