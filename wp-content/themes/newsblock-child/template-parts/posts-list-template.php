<?php if (have_posts()) : ?>
    <div class="community-page__posts">
        <?php while (have_posts()) {
            the_post();
            get_template_part('/template-parts/post-template');
        }
        wp_reset_postdata(); ?>
    </div>
    <button class="community-page__load-more">
        <?php esc_html_e('Ещё'); ?>
    </button>
<?php else: ?>
    <p>
        <?php esc_html_e('Ничего не найдено'); ?>
    </p>
<?php endif; ?>