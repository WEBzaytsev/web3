<?php
/**
 * The template for displaying the header 4
 *
 * @package Newsblock
 */

$scheme = csco_color_scheme(
	get_theme_mod( 'color_header_background', '#0a0a0a' ),
	get_theme_mod( 'color_header_background_dark', '#1c1c1c' )
);
?>

<header class="cs-header cs-header-stretch cs-header-four" <?php echo wp_kses( $scheme, 'post' ); ?>>
<!--AdFox START-->
<!--yandex_web3adv-->
<!--Площадка: Web3 / Desktop / Перетяжка 100%*200px-->
<!--Категория: <не задана>-->
<!--Тип баннера: Billboard-->
<div id="adfox_166291109391615849"></div>
<script>
    window.yaContextCb.push(()=>{
        Ya.adfoxCode.createAdaptive({
            ownerId: 706490,
            containerId: 'adfox_166291109391615849',
            params: {
                p1: 'cvslz',
                p2: 'hvhv'
            }
        }, ['desktop', 'tablet'], {
            tabletWidth: 830,
            phoneWidth: 480,
            isAutoReloads: false
        })
    })
</script>

<!--AdFox START-->
<!--yandex_web3adv-->
<!--Площадка: Web3 / Mobile / Mobile Перетяжка 100%*200px-->
<!--Категория: <не задана>-->
<!--Тип баннера: Mobile-->
<div id="adfox_166291111123671898"></div>
<script>
    window.yaContextCb.push(()=>{
        Ya.adfoxCode.createAdaptive({
            ownerId: 706490,
            containerId: 'adfox_166291111123671898',
            params: {
                p1: 'cvsme',
                p2: 'hvie'
            }
        }, ['phone'], {
            tabletWidth: 830,
            phoneWidth: 480,
            isAutoReloads: false
        })
    })
</script>
	<div class="cs-container">
		<div class="cs-header__inner-wrapper cs-header__inner-desktop">
			<div class="cs-header__col cs-col-left">
				<?php
					csco_component( 'header_offcanvas_toggle' );
					csco_component( 'header_logo', true, array( 'variant' => 'large' ) );
				?>
			</div>
			<div class="cs-header__col cs-col-column">
				<div class="cs-header__item">
					<div class="cs-header__inner">
						<?php
						$header_text = get_theme_mod( 'header_textarea', '' );
						?>
						<div class="cs-header__col cs-col-left <?php echo esc_attr( $header_text ? 'cs-col-large' : null ); ?>">
							<?php
							if ( $header_text ) {
								?>
								<div class="cs-header__info">
									<span><?php echo wp_kses_post( $header_text ); ?></span>
								</div>
								<?php
							}
							?>
						</div>
						<div class="cs-header__col cs-col-right">
							

							<?php
							if (is_user_logged_in()) {?>
								<a href="./profile/." class="cs-header__button" ><i class="fa fa-user-o"></i> Личный кабинет </a> 
								<a class="cs-header__button" href="<?php echo esc_url(wp_logout_url()); ?>">Выйти</a> <!-- Когда нить надо занести в перевод  -->
								<?php
							} else {
								echo '<a href="/login/" class="uwp-login-link" rel="nofollow"><i class="fa fa-sign-in" aria-hidden="true"></i>	</a>';
							}
							csco_component( 'header_scheme_toggle' );
							csco_component( 'wc_header_cart' );
							csco_component( 'header_search_toggle' );
							?>
						</div>
					</div>
				</div>
				<div class="cs-header__item">
					<div class="cs-header__inner">
						<div class="cs-header__col cs-col-nav">
							<?php
								csco_component( 'header_nav_menu' );
								csco_component( 'header_multi_column_widgets' );
							?>
						</div>
						<div class="cs-header__col cs-col-right">
							<?php
								csco_component( 'header_social_links' );
								csco_component( 'header_button' );
								if ( is_user_logged_in() ) {
									$subscribed = get_user_meta( get_current_user_id(), '_trianulla_subscribe_subscribed', true );
									if ( ! $subscribed ) {
										csco_component( 'header_single_column_widgets' );
									}
								} else {
									csco_component( 'header_single_column_widgets' );
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php csco_site_nav_mobile(); ?>
	</div>

	<?php csco_site_search(); ?>
</header>
