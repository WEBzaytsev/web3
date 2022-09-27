<?php
/**
 * Include Theme Functions
 *
 * @package Newsblock Child Theme
 * @subpackage Functions
 * @version 1.2.0
 */

/**
 * Setup Child Theme
 */
function csco_setup_child_theme() {
	// Add Child Theme Text Domain.
	load_child_theme_textdomain( 'newsblock', get_stylesheet_directory() . '/languages' );
}

add_action( 'after_setup_theme', 'csco_setup_child_theme', 99 );

/**
 * Enqueue Child Theme Assets
 */
function csco_child_assets() {
	if ( ! is_admin() ) {
		$version = wp_get_theme()->get( 'Version' );
		wp_enqueue_style( 'csco_child_css', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array(), $version, 'all' );
	}
}

add_action( 'wp_enqueue_scripts', 'csco_child_assets', 99 );

/**
 * Add your custom code below this comment.
 */


/**
 * Add posts views counter
 */
function csco_get_post_view() {
    return get_post_meta( get_the_ID(), 'post_views_count', true );
}
function csco_set_post_view() {
    $key = 'post_views_count';
    $post_id = get_the_ID();
    $count = (int) get_post_meta( $post_id, $key, true );
    $count++;
    update_post_meta( $post_id, $key, $count );
}
function csco_posts_column_views( $columns ) {
    $columns['post_views'] = 'Views';
    return $columns;
}
function csco_posts_custom_column_views( $column ) {
    if ( $column === 'post_views') {
        echo csco_get_post_view();
    }
}
add_filter( 'manage_posts_columns', 'csco_posts_column_views' );
add_action( 'manage_posts_custom_column', 'csco_posts_custom_column_views' );

function csco_child_theme_scripts() {
    $version = csco_get_theme_data( 'Version' );

    wp_register_script(
        'community-scripts',
        get_stylesheet_directory_uri() . '/js/community-scripts.js',
        array(),
        $version,
        true
    );

    $options = [
        'ajax_url' => admin_url('admin-ajax.php'),
        'get_community_posts' => wp_create_nonce('get_community_posts')
    ];

    if (is_page('community')) {

        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'author__not_in' => get_authors_ids(),
        );

        $popular_posts_args = array(
            'meta_key' => 'post_views_count',
            'orderby' => 'meta_value_num',
            'meta_type' => 'NUMERIC',
            'order' => 'DESC'
        );

        $popular_posts_count = query_posts($args + $popular_posts_args);
        $last_posts_count = query_posts($args);

        $options = array_merge( $options, [
            'popular-posts' => count($popular_posts_count),
            'last-posts' => count($last_posts_count)
        ] );

    }

    if( substr( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), 0, 9 ) == '/profile/' ) {
        if( function_exists( 'uwp_get_displayed_user' ) ) {
            $user = uwp_get_displayed_user();
            if( $user && property_exists( $user, 'data' ) && property_exists( $user->data, 'ID' ) ) {
                $user_id = $user->data->ID;
                $posts_count = count_user_posts( $user->ID, 'post', true );
                $comments_count = get_comments( [ 'user_id' => $user->ID, 'count' => true ] );
                $options = array_merge( $options, [
                    'posts' => $posts_count,
                    'comments' => $comments_count,
                    'author_id' => $user_id
                ] );
            }
        }
    }

    if( substr( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), 0, 7 ) == '/users/' ) {
        $options = array_merge( $options, [
            'new-users' => count_users()[ 'total_users' ],
            'popular-users' => count_users()[ 'total_users' ],
        ] );
    }

    wp_localize_script(
        'community-scripts',
        'options',
        $options
    );
    wp_enqueue_script( 'community-scripts');

}

add_action('wp_enqueue_scripts', 'csco_child_theme_scripts');

function get_community_posts() {
    check_ajax_referer('get_community_posts', 'nonce');

    wp_reset_query();

    $page = filter_input(INPUT_POST, 'pg', FILTER_VALIDATE_INT);
    $tab = filter_input(INPUT_POST, 'tab', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if( filter_has_var( INPUT_POST, 'author_id') ) {
        $author_id = filter_input( INPUT_POST, 'author_id', FILTER_VALIDATE_INT );
    }

    if( $type == 'comments' ) {
        $comments = get_comments( [ 'user_id' => $author_id, 'number' => 5, 'offset' => ( $page - 1 ) * 5 ] );
        if( $comments ) {
            foreach( $comments as $comment ):
                get_template_part( '/template-parts/comment-template', null, [ 'comment' => $comment ] );
            endforeach;
        }
    } elseif( $type == 'users' ) {
        $users = get_users( [
            'orderby' => 'registered',
            'order' => 'DESC',
            'number' => 10,
            'offset' => ( $page - 1 ) * 10
        ] );
        if( $users ) {
            foreach( $users as $user ):
                get_template_part( '/template-parts/user-card', null, [ 'user' => $user ] );
            endforeach;
        }
    } else {
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 5,
            'paged' => (int)$page,
        );
        if( isset( $author_id ) ) {
            $args[ 'author' ] = $author_id;
        } else {
            $args[ 'author__not_in' ] = get_authors_ids();
        }
    
        $popular_posts_args = array(
            'orderby' => 'meta_value_num',
            'meta_query' => [
                'relation' => 'OR',
                [
                    'key' => '_trianulla_like_count',
                    'compare' => 'NOT EXISTS',
                ],
                [
                    'key' => '_trianulla_like_count',
                    'compare' => 'EXISTS',
                ],
            ],
        );
    
        if ($tab == 'popular-posts') {
            $args = $args + $popular_posts_args;
        }
    
        $posts = query_posts($args);
    
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                get_template_part('/template-parts/post-template');
            }
            wp_reset_postdata();
        }
    }

    die();
}

add_action('wp_ajax_get_community_posts', 'get_community_posts');
add_action('wp_ajax_nopriv_get_community_posts', 'get_community_posts');

function get_authors_ids(): array
{
    $users_args = array(
        'role'    => 'Administrator',
        'order'   => 'ASC'
    );
    $users = get_users( $users_args );
    $excluded_users = array();

    foreach ($users as $user_) {
        array_push($excluded_users, $user_->ID);
    }

    return $excluded_users;
}

add_action('wp_enqueue_scripts', function() {
    wp_dequeue_style('userswp');
    wp_deregister_style('userswp');
    wp_dequeue_style('bfe-block-style');
    wp_deregister_style('bfe-block-style');
}, 999);

function modify_uwp_input_text( $html, $field, $value, $form_type ) {
    $required = '';
    if( $field->is_required ) {
        $required = 'required="required"';
    }
    $html = '<div class="user-form__field"><input type="text" name="' . $field->htmlvar_name . '" value="' . $value . '" placeholder="' . $field->site_title . '" ' . $required . ' /></div>';
    return $html;
}
add_filter( 'uwp_form_input_html_text', 'modify_uwp_input_text', 10, 4 );

function modify_uwp_input_email( $html, $field, $value, $form_type ) {
    $required = '';
    if( $field->is_required ) {
        $required = 'required="required"';
    }
    $html = '<div class="user-form__field"><input type="email" name="' . $field->htmlvar_name . '" value="' . $value . '" placeholder="' . $field->site_title . '" ' . $required . ' /></div>';
    return $html;
}
add_filter( 'uwp_form_input_html_email', 'modify_uwp_input_email', 10, 4 );

function modify_uwp_input_password( $html, $field, $value, $form_type ) {
    $required = '';
    if( $field->is_required ) {
        $required = 'required="required"';
    }
    $html = '<div class="user-form__field"><div class="user-form__field_password"><input type="password" name="' . $field->htmlvar_name . '" value="' . $value . '" placeholder="' . $field->site_title . '" ' . $required . ' /><span></span></div></div>';
    if( $form_type == 'register' && array_key_exists( 'extra_fields', $field ) ) {
        $extra_fields = unserialize( $field->extra_fields );
        $html .= '<div class="user-form__field"><div class="user-form__field_password"><input type="password" name="' . array_key_first( $extra_fields ) . '" value="' . $value . '" placeholder="Повторите ' . strtolower( $field->site_title ) . '" ' . $required . ' /><span></span></div></div>';
    }
    return $html;
}
add_filter( 'uwp_form_input_html_password', 'modify_uwp_input_password', 10, 4 );

function modify_uwp_input_textarea( $html, $field, $value, $form_type ) {
    $required = '';
    if( $field->is_required ) {
        $required = 'required="required"';
    }
    $html = '<div class="user-form__field"><textarea name="' . $field->htmlvar_name . '" placeholder="' . $field->site_title . '" ' . $required . '>' . $value . '</textarea></div>';
    return $html;
}
add_filter( 'uwp_form_input_html_textarea', 'modify_uwp_input_textarea', 10, 4 );

if ( ! function_exists( 'current_page_is_auth' ) ) {
    function current_page_is_auth() {
        return in_array( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), ['/login/', '/register/', '/forgot-password/', '/password-reset/'] );
    }
}

if ( ! function_exists( 'plural_form' ) ) {
    function plural_form( $value, $words, $show = true ) {
        $num = $value % 100;
        if ( $num > 19 ) { 
            $num = $num % 10; 
        }
        
        $out = ( $show ) ?  $value . ' ' : '';
        switch ( $num ) {
            case 1:  $out .= $words[0]; break;
            case 2: 
            case 3: 
            case 4:  $out .= $words[1]; break;
            default: $out .= $words[2]; break;
        }
        
        return $out;
    }
}

/* Remove userswp pagination from user list as we use custom ajax pagination */
if( substr( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), 0, 7 ) == '/users/' ) {
    function remove_profile_pagination() {
        global $wp_filter;
        if( isset( $wp_filter[ 'uwp_profile_pagination' ] ) ) {
            foreach( $wp_filter[ 'uwp_profile_pagination' ]->callbacks as $priority => $hook) {
                foreach( $hook as $name => $params ) {
                    remove_action( 'uwp_profile_pagination', $wp_filter[ 'uwp_profile_pagination' ][ $priority ][ $name ][ 'function' ], $priority );
                }
            }
        }
    }
    add_action( 'init', 'remove_profile_pagination' );
}

/* Mega Menu overrides */
require_once get_stylesheet_directory() . '/inc/mega-menu.php';

/* PowerKit overrides */
require_once get_stylesheet_directory() . '/inc/powerkit.php';

/* Override from parent theme */
function csco_section_heading( $title, $type = 'full', $echo = true, $class = '', $location = 'default' ) {

    if ( 'full' === $type && is_string( $title ) && ! $title ) {
        return;
    }

    $tag   = csco_live_get_theme_mod( 'section_heading_tag', 'div' );
    $align = csco_live_get_theme_mod( 'section_heading_align', 'halignleft' );

    // For submenu location.
    $default = csco_live_get_theme_mod( 'section_heading_submenu_default', false );

    if ( ! $default && ( 'submenu' === get_query_var( 'headinglocation' ) || 'submenu' === $location ) ) {
        $tag   = csco_live_get_theme_mod( 'section_heading_submenu_tag', 'div' );
        $align = csco_live_get_theme_mod( 'section_heading_submenu_align', 'halignleft' );
    }

    $class = sprintf( 'is-style-cnvs-block-section-heading-default %s %s ', $align, $class );

    ob_start();

    if ( function_exists( 'cnvs' ) ) {

        if ( 'full' === $type || 'before' === $type ) {
            echo '<' . esc_html( $tag ) . ' class="cs-section-heading cnvs-block-section-heading ' . esc_html( $class ) . '">';

            echo '<span class="cnvs-section-title"><span>';
        }

        if ( 'full' === $type ) {
            echo wp_kses_post( $title );
        }

        if ( 'full' === $type || 'after' === $type ) {
            echo '</span></span>';

            echo '</' . esc_html( $tag ) . '>';
        }
    } else {
        if ( 'full' === $type || 'before' === $type ) {
            echo '<' . esc_html( $tag ) . ' class="cs-section-heading cs-section-heading-common ' . esc_html( $class ) . '">';
        }

        if ( 'full' === $type ) {
            echo wp_kses_post( $title );
        }

        if ( 'full' === $type || 'after' === $type ) {
            echo '</' . esc_html( $tag ) . '>';
        }
    }

    if ( ! $echo ) {
        return ob_get_clean();
    } else {
        ob_end_flush();
    }
}

/**
 * Insert ads after each 5th paragraph in posts
 */
function insert_ads_to_posts( $content ) {
    if( is_single() ) {
        $parts = explode( '</p>', $content );
        if( count( $parts ) >= 8 ) {
            $ad_contents = file_get_contents( get_stylesheet_directory() . '/inc/ad.php' );
            if( $ad_contents ) {
                $content = '';
                foreach( $parts as $key => $part ) {
                    $content .= $part . '</p>';
                    if( $key == 4 ) {
                        $content .= $ad_contents;
                    }
                }
            }
        }
    }
    return $content;
}
add_filter( 'the_content', 'insert_ads_to_posts' );

/**
 * Header Single-Column Widgets. Parent theme override
 *
 * @param array $settings The advanced settings.
 */
function csco_header_single_column_widgets( $settings = array() ) {

    if ( ! get_theme_mod( 'header_single_column_display', true ) ) {
        return;
    }

    if ( ! is_active_sidebar( 'sidebar-singlecolumn' ) ) {
        return;
    }

    // Background Image.
    $bg_image_id = get_theme_mod( 'header_single_column_image' );

    $scheme = csco_color_scheme(
        get_theme_mod( 'color_submenu_background', '#FFFFFF' ),
        get_theme_mod( 'color_submenu_background_dark', '#1c1c1c' )
    );
    ?>
    <div <?php csco_site_submenu_class( array( 'cs-header__single-column' ) ); ?>>
        <span class="cs-header__single-column-label"><?php echo esc_html( get_theme_mod( 'header_single_column_title', esc_html__( 'Follow', 'newsblock' ) ) ); ?></span>
        <div class="cs-header__widgets" <?php echo wp_kses( $scheme, 'post' ); ?>>
            <?php if ( $bg_image_id ) { ?>
                <figure class="cs-header__widgets-img">
                    <?php
                        echo wp_get_attachment_image( $bg_image_id, 'large', array(
                            'class' => 'pk-lazyload-disabled',
                        ) );
                    ?>
                </figure>
            <?php } ?>
            <div class="cs-header__widgets-content cs-header__widgets-column cs-widget-area">
                <?php dynamic_sidebar( 'sidebar-singlecolumn' ); ?>
            </div>
        </div>
    </div>
    <?php
}