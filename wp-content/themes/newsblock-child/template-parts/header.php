<?php
/**
 * The template for displaying the header layout
 *
 * @package Newsblock
 */

switch ( get_theme_mod( 'header_layout', 'cs-header-four' ) ) {
	case 'cs-header-one':
		get_template_part( 'template-parts/headers/header-1' );
		break;
	case 'cs-header-two':
		get_template_part( 'template-parts/headers/header-2' );
		break;
	case 'cs-header-three':
		get_template_part( 'template-parts/headers/header-3' );
		break;
	case 'cs-header-four':
		get_template_part( 'template-parts/headers/header-4' );
		break;
}
