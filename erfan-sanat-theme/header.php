<?php
/**
 * Theme Header Template
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="es-site-wrapper">
	<?php get_template_part( 'template-parts/header/site-header' ); ?>
	<?php get_template_part( 'template-parts/global/breadcrumbs' ); ?>
	<main id="main-content" class="es-site-main" role="main">
