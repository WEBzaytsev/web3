<?php

function csco_powerkit_featured_default_template_child( $posts, $params, $instance ) {

    $style = null;

    if ( $params['image_radius'] ) {
        $style = sprintf( '--cs-image-border-radius: %s;', $params['image_radius'] );
    }

    if ( 'list' === $params['template'] ) {
        ?>
        <article <?php post_class(); ?> style="<?php echo esc_attr( $style ); ?>">
            <div class="cs-entry__outer">
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="cs-entry__inner cs-entry__thumbnail cs-overlay-ratio cs-ratio-<?php echo esc_attr( $params['image_orientation'] ); ?>">
                        <div class="cs-overlay-background cs-overlay-transparent">
                            <?php the_post_thumbnail( $params['image_size'] ); ?>
                        </div>

                        <a class="cs-overlay-link" href="<?php echo esc_url( get_permalink() ); ?>"></a>
                    </div>
                <?php } ?>

                <div class="cs-entry__inner cs-entry__content">
                    <?php csco_get_post_meta( array( 'category' ), (bool) $params['post_meta_compact'], true, $params['post_meta'] ); ?>

                    <div class="cs-entry__title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </div>

                    <?php csco_get_post_meta( array( 'author', 'date', 'views', 'shares', 'reading_time', 'comments' ), (bool) $params['post_meta_compact'], true, $params['post_meta'] ); ?>
                </div>
            </div>
        </article>
        <?php

    } elseif ( 'numbered' === $params['template'] ) {
        ?>
        <article <?php post_class(); ?> style="<?php echo esc_attr( $style ); ?>">
            <div class="cs-entry__outer">
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="cs-entry__inner cs-entry__thumbnail cs-overlay-ratio cs-ratio-<?php echo esc_attr( $params['image_orientation'] ); ?>">
                        <div class="cs-overlay-background">
                            <?php the_post_thumbnail( $params['image_size'] ); ?>
                        </div>

                        <a class="cs-overlay-link" href="<?php echo esc_url( get_permalink() ); ?>"></a>
                    </div>
                <?php } ?>

                <div class="cs-entry__inner cs-entry__content">
                    <?php csco_get_post_meta( array( 'category' ), (bool) $params['post_meta_compact'], true, $params['post_meta'] ); ?>

                    <div class="cs-entry__title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </div>

                    <?php csco_get_post_meta( array( 'author', 'date', 'views', 'shares', 'reading_time', 'comments' ), (bool) $params['post_meta_compact'], true, $params['post_meta'] ); ?>
                </div>
            </div>
        </article>
        <?php
    } elseif ( 'large-1' === $params['template'] ) {
        ?>
        <article <?php post_class(); ?> style="<?php echo esc_attr( $style ); ?>">
            <div class="cs-entry__outer">
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="cs-entry__inner cs-entry__thumbnail cs-overlay-ratio cs-ratio-<?php echo esc_attr( $params['image_orientation'] ); ?>">
                        <div class="cs-overlay-background cs-overlay-transparent">
                            <?php the_post_thumbnail( $params['image_size'] ); ?>
                        </div>

                        <a class="cs-overlay-link" href="<?php echo esc_url( get_permalink() ); ?>"></a>
                    </div>
                <?php } ?>

                <div class="cs-entry__inner cs-entry__content">
                        <?php csco_get_post_meta( array( 'category', 'date' ), (bool) $params['post_meta_compact'], true, $params['post_meta'] ); ?>

                        <div class="cs-entry__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </div>

                        <?php csco_get_post_meta( array( 'author', 'views', 'shares', 'reading_time', 'comments' ), (bool) $params['post_meta_compact'], true, $params['post_meta'] ); ?>
                </div>
            </div>
        </article>
        <?php
    } elseif ( 'large-2' === $params['template'] ) {
        ?>
        <article <?php post_class(); ?> style="<?php echo esc_attr( $style ); ?>">
            <div class="cs-entry__outer">
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="cs-entry__inner cs-entry__thumbnail cs-overlay-ratio cs-ratio-<?php echo esc_attr( $params['image_orientation'] ); ?>">
                        <div class="cs-overlay-background cs-overlay-transparent">
                            <?php the_post_thumbnail( $params['image_size'] ); ?>
                        </div>

                        <a class="cs-overlay-link" href="<?php echo esc_url( get_permalink() ); ?>"></a>
                    </div>
                <?php } ?>

                <div class="cs-entry__inner cs-entry__content">
                    <?php csco_get_post_meta( array( 'category' ), (bool) $params['post_meta_compact'], true, $params['post_meta'], array( 'category_type' => 'line' ) ); ?>

                    <div class="cs-entry__title cs-entry__title-line">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </div>

                    <?php csco_get_post_meta( array( 'author', 'date', 'views', 'shares', 'reading_time', 'comments' ), (bool) $params['post_meta_compact'], true, $params['post_meta'] ); ?>
                </div>
            </div>
        </article>
        <?php
    }
}

function csco_powerkit_featured_posts_default_child( $templates = array() ) {

	unset( $templates['large'] );

	$templates['list']['func']     = 'csco_powerkit_featured_default_template_child';
	$templates['numbered']['func'] = 'csco_powerkit_featured_default_template_child';

	$templates['large-1'] = array(
		'name' => esc_html__( 'Large Type 1', 'newsblock' ),
		'func' => 'csco_powerkit_featured_default_template_child',
	);

	$templates['large-2'] = array(
		'name' => esc_html__( 'Large Type 2', 'newsblock' ),
		'func' => 'csco_powerkit_featured_default_template_child',
	);

	return $templates;
}

/* Override parent theme default template filter */
function override_powerkit_filters() {
    remove_filter( 'powerkit_featured_posts_templates', 'csco_powerkit_featured_posts_default' );
    add_filter( 'powerkit_featured_posts_templates', 'csco_powerkit_featured_posts_default_child' );
}
add_action( 'init', 'override_powerkit_filters' );