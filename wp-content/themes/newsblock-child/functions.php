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
        'get_community_posts' => wp_create_nonce('get_community_posts'),
        'publish_community_post' => wp_create_nonce('publish_community_post'),
        'remove_community_post' => wp_create_nonce('remove_community_post'),
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
                if ( is_user_logged_in() && ( get_current_user_id() == $user->data->ID ) ) {
                    $query_args = [
                        'post_type' => 'post',
                    ];
                    if ( ! current_user_can( 'edit_pages' ) ) {
                        $query_args['post_status'] = ['draft', 'pending'];
                        $query_args['author'] = $user->ID;
                    } else {
                        $query_args['post_status'] = 'pending';
                    }
                    $user_posts_query = new WP_Query( $query_args );
                    $user_posts_count = $user_posts_query->found_posts;
                    $options = array_merge( $options, [
                        'user_posts' => $user_posts_count,
                    ] );
                }
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
        if ( $tab == 'user_posts' ) {
            if ( is_user_logged_in() && ( get_current_user_id() == $author_id ) || current_user_can( 'edit_pages' ) ) {
                $query_args = [
                    'post_type' => 'post',
                    'posts_per_page' => 10,
                    'paged' => (int) $page,
                ];
                if ( ! current_user_can( 'edit_pages' ) ) {
                    $query_args['post_status'] = ['draft', 'pending'];
                    $query_args['author'] = get_current_user_id();
                } else {
                    $query_args['post_status'] = 'pending';
                }
                $posts = query_posts($query_args);
        
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        get_template_part('/template-parts/list-post-template');
                    }
                    wp_reset_postdata();
                }
            }
        } else {
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => 5,
                'paged' => (int) $page,
            );
            if ( isset( $author_id ) ) {
                $args[ 'author' ] = $author_id;
            } else {
                $args[ 'author__not_in' ] = get_authors_ids();
            }
        
            $popular_posts_args = array(
                'orderby' => 'meta_value_num',
                'meta_query' => [
                    'relation' => 'OR',
                    [
                        'key' => '_webtree_like_count',
                        'compare' => 'NOT EXISTS',
                    ],
                    [
                        'key' => '_webtree_like_count',
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
    $html = '<div class="user-form__field">';
    $html .= '<input type="text" name="' . $field->htmlvar_name . '" value="' . $value . '" placeholder="' . $field->site_title . '" ' . $required . ' />';
    if ( 'register' === $form_type && 'username' === $field->htmlvar_name ) {
        $username_length = uwp_get_option( 'register_username_length');
        $username_length = ! empty( $username_length ) ? (int) $username_length : 4;
        $html .= '<div class="user-form__field-note">Минимальная длина: ' . plural_form( $username_length, ['символ', 'символа', 'символов'] ) . '</div>';
    }
    $html .= '</div>';
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
    $html = '<div class="user-form__field">';
    $html .= '<div class="user-form__field_password"><input type="password" name="' . $field->htmlvar_name . '" value="' . $value . '" placeholder="' . $field->site_title . '" ' . $required . ' /><span></span></div>';
    if ( 'register' === $form_type && 'password' === $field->htmlvar_name || 'change' === $form_type && 'password' === $field->htmlvar_name ) {
        $password_min_length = uwp_get_option( 'register_password_min_length');
        $password_min_length = ! empty( $password_min_length ) ? (int)$password_min_length : 8;
        $password_max_length = uwp_get_option( 'register_password_max_length');
        $password_max_length = ! empty( $password_max_length ) ? (int) $password_max_length : 15;
        $html .= '<div class="user-form__field-note">Минимальная длина: ' . plural_form( $password_min_length, ['символ', 'символа', 'символов'] ) . '<br />';
        $html .= 'Максимальная длина: ' . plural_form( $password_max_length, ['символ', 'символа', 'символов'] ) . '</div>';
    }
    $html .= '</div>';
    if ( $form_type == 'register' && array_key_exists( 'extra_fields', $field ) ) {
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

/* Add post meta "Community post" to archive post template */
function add_community_post_to_meta_choices( $choices ) {
    $choices['community_post'] = esc_html__( 'Community Post Link', 'newsblock' );
    return $choices;
}
add_filter( 'csco_post_meta_choices', 'add_community_post_to_meta_choices' );

function is_community_author( $user_id ) {
    $user_meta = get_userdata( $user_id );
    $roles = $user_meta->roles;
    if ( in_array( 'subsriber', $roles, true ) || in_array( 'contributor', $roles, true ) ) {
        return true;
    } else {
        return false;
    }
}

function csco_get_meta_community_post( $tag = 'div', $compact = false, $settings = array() ) {
    $output = '';
    $author_id = array( get_the_author_meta( 'ID' ) )[ 0 ];
    if( is_community_author( $author_id ) ) {
        $output = '<' . esc_html( $tag ) . ' class="cs-meta-community_post">';
        $output .= '<a href="/community">Из сообщества</a>';
        $output .= '</' . esc_html( $tag ) . '>';
    }
    return $output;
}
/* */

function publish_community_post() {
    check_ajax_referer('publish_community_post', 'nonce');
    $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
    if ( ! is_user_logged_in() || ! current_user_can( 'edit_pages' ) ) {
        wp_send_json(
            array(
                'success' => false,
                'error'   => 'User cant manage posts',
            )
        );
    }
    $post = get_post( $id );
    if ( ! $post ) {
        wp_send_json(
            array(
                'success' => false,
                'error'   => 'Post not found',
            )
        );
    }
    $post->post_status = 'publish';
    wp_update_post( $post );
    wp_send_json(
        array(
            'success' => true,
            'url'   => get_permalink( $post->ID ),
        )
    );
}

add_action( 'wp_ajax_publish_community_post', 'publish_community_post' );


function remove_community_post() {
    check_ajax_referer('remove_community_post', 'nonce');
    $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
    $post = get_post( $id );
    if ( ! $post ) {
        wp_send_json(
            array(
                'success' => false,
                'error'   => 'Post not found',
            )
        );
    }
    if ( is_user_logged_in() && current_user_can( 'edit_pages' ) || is_user_logged_in() && get_current_user_id() == $post->post_author ) {
        $post->post_status = 'trash';
        wp_update_post( $post );
        wp_send_json(
            array(
                'success' => true,
            )
        );
    } else {
        wp_send_json(
            array(
                'success' => false,
                'error'   => 'User cant manage the post',
            )
        );
    }
}

add_action( 'wp_ajax_remove_community_post', 'remove_community_post' );

function send_post_moderation_email( $post_id, $post, $update ) {
    if ( ! $update && 'pending' === $post->post_status ) {
        $post_author = get_userdata( $post->post_author );
        if ( $post_author->user_email && is_email( $post_author->user_email ) ) {
            $content = '<p>Ваша статья &laquo;' . esc_html( $post->post_title ) . '&raquo; была успешно добавлена и отправлена на модерацию. Вы получите уведомление, когда ваша статья будет одобрена.</p>';
            ob_start();
            get_template_part( '/template-parts/email-template', null, [ 'content' => $content ] );
            $html = ob_get_clean();
            $headers = array(
                'Content-Type: text/html; charset=UTF-8',
                'From: ' . esc_attr( get_bloginfo( 'name' ) ) . ' <noreply@' . parse_url( get_site_url(), PHP_URL_HOST ) . '>',
            );
            wp_mail( $post_author->user_email, 'Статья отправлена на модерацию', $html, $headers );
        }
    }
}
add_action( 'wp_insert_post', 'send_post_moderation_email', 10, 3 );

function send_post_publish_email( $post ) {
    $post_author = get_userdata( $post->post_author );
    if ( $post_author->user_email && is_email( $post_author->user_email ) ) {
        $content = '<p>Ваша статья &laquo;<a href="' . esc_html( get_permalink( $post->ID ) ) . '">' . esc_html( $post->post_title ) . '</a>&raquo; успешно прошла модерацию и была опубликована.</p>';
        ob_start();
        get_template_part( '/template-parts/email-template', null, [ 'content' => $content ] );
        $html = ob_get_clean();
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . esc_attr( get_bloginfo( 'name' ) ) . ' <noreply@' . parse_url( get_site_url(), PHP_URL_HOST ) . '>',
        );
        wp_mail( $post_author->user_email, 'Статья успешно опубликована', $html, $headers );
    }
}
add_action( 'pending_to_publish', 'send_post_publish_email', 10, 1 );
