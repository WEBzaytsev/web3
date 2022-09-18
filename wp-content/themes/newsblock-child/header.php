<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "cs-site" div.
 *
 * @package Newsblock
 */

csco_set_post_view();
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<link rel="apple-touch-icon" sizes="180x180" href="/wp-content/themes/newsblock-child/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/wp-content/themes/newsblock-child/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="192x192" href="/wp-content/themes/newsblock-child/favicon/android-chrome-192x192.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/wp-content/themes/newsblock-child/favicon/favicon-16x16.png">
	<link rel="manifest" href="/wp-content/themes/newsblock-child/favicon/site.webmanifest">
	<link rel="mask-icon" href="https://trianulla.com/wp-content/themes/newsblock-child/favicon/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#000000">
	<meta name="msapplication-TileImage" content="/wp-content/themes/newsblock-child/favicon/mstile-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<?php wp_head(); ?>
  <script>window.yaContextCb = window.yaContextCb || []</script>
<script src="https://yandex.ru/ads/system/context.js" async></script>
</head>

<body <?php body_class(); ?> <?php csco_site_scheme(); ?>>

<?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
?>

<?php do_action( 'csco_site_before' ); ?>

<div id="page" class="cs-site">

	<?php do_action( 'csco_site_start' ); ?>

	<div class="cs-site-inner">

		<?php do_action( 'csco_header_before' ); ?>

		<?php get_template_part( 'template-parts/header' ); ?>

		<?php do_action( 'csco_header_after' ); ?>

		<main id="main" class="cs-site-primary">

			<?php do_action( 'csco_site_content_before' ); ?>

			<?php if( !current_page_is_auth() ): ?><div <?php csco_site_content_class(); ?>><?php endif; ?>

				<?php do_action( 'csco_site_content_start' ); ?>

				<?php if( !current_page_is_auth() ): ?><div class="cs-container"><?php endif; ?>

					<?php do_action( 'csco_main_content_before' ); ?>

					<div id="content" class="cs-main-content">

						<?php do_action( 'csco_main_content_start' ); ?>
