<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( isset( $_GET['tab'] ) ) {
    $current_tab = strip_tags( esc_sql( $_GET['tab'] ) );
} else {
    $current_tab = 'new-users';
}

?>
<div class="content-tabs-frame">
    <ul class="content-tabs"
        role="tablist"
        id="tabs-tab">
        <li class="content-tabs__tab <?= ( $current_tab == 'new-users' ) ? ' content-tabs__tab_active' : ''; ?>"
            role="presentation">
            <a href="#new-users"
                class="content-tabs__tab-url" data-paginated data-type="users">
                Самые новые
            </a>
        </li>
        <li class="content-tabs__tab<?= ( $current_tab == 'popular-users' ) ? ' content-tabs__tab_active' : ''; ?>"
            role="presentation">
            <a href="#popular-users"
                class="content-tabs__tab-url" data-paginated data-type="users">
                Самые популярные
            </a>
        </li>
    </ul>
</div>
<div id="new-users" <?php if( $current_tab != 'new-users' ): ?>style="display: none;" <?php endif; ?>>
    <div class="user-list content-tabs__tab-content">
        <?php
        //$paged = isset( $_GET[ 'pg' ] ) ? max( 1, $_GET[ 'pg' ] ) : 1;
        $page = isset( $_GET[ 'pg' ] ) && isset( $_GET[ 'tab' ] ) && $_GET[ 'tab' ] == 'new-users' ? $_GET[ 'pg' ] : 1;
        $users = get_users( [
            'orderby' => 'registered',
            'order' => 'DESC',
            'number' => $page * 10
        ] );
        if( count( $users ) > 0 ) {
            foreach( $users as $user ) {
                get_template_part( '/template-parts/user-card', null, [ 'user' => $user ] );
            }
        }
        ?>
    </div>
    <button class="load-more">
        <?php esc_html_e('Ещё'); ?>
    </button>
</div>
<div id="popular-users" <?php if( $current_tab != 'popular-users' ): ?>style="display: none;" <?php endif; ?>>
    <div class="user-list content-tabs__tab-content">
        <?php
        //$paged = isset( $_GET[ 'pg' ] ) ? max( 1, $_GET[ 'pg' ] ) : 1;
        $page = isset( $_GET[ 'pg' ] ) && isset( $_GET[ 'tab' ] ) && $_GET[ 'tab' ] == 'popular-users' ? $_GET[ 'pg' ] : 1;
        $users = get_users( [
            'number' => $page * 10,
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
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
        ] );
        if( count( $users ) > 0 ) {
            foreach( $users as $user ) {
                get_template_part( '/template-parts/user-card', null, [ 'user' => $user ] );
            }
        }
        ?>
    </div>
    <button class="load-more">
        <?php esc_html_e('Ещё'); ?>
    </button>
</div>
