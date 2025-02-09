<?php
/**
 * Site Header
 */

$header_navigation = get_field('header_navigation', 'options'); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class('is-header-fixed'); ?>>
	<!-- Page -->
	<div id="page" class="site-container">
		<a class="screen-reader-shortcut" href="#menu-primary-menu" aria-label="Skip to primary menu">Skip to primary menu</a>
		<a class="screen-reader-shortcut" href="#main" aria-label="Skip to main content">Skip to main content</a>
		<a class="screen-reader-shortcut" href="#footer" aria-label="Skip to footer content">Skip to footer content</a>

		<header id="masthead" class="site-header container" role="banner">
			<div class="site-header__container">
				<div class="site-header__toggle">
					<a class="site-header__search-toggle" href="#search">Search</a>

					<button id="navbar-toggle" class="navbar-toggle" type="button">
						<span class="navbar-toggle__bar"></span>.
					</button>
				</div>

				<div class="site-header__logo">
					<?php if ( !has_custom_logo() ){ ?>
						<a class="logo" href="<?= get_home_url(); ?>" title="Go to Home page">
							<img class="logo__image" src="<?php bloginfo('template_url'); ?>/assets/img/logo.png" alt="<?php bloginfo('name'); ?>, logo" />
						</a>
					<?php } else { ?>
						<?php the_custom_logo(); ?>
					<?php } ?>
				</div>

				<?php if ( is_active_sidebar('header') ){ ?>
					<div class="site-header__widgets">
						<?php dynamic_sidebar('header'); ?>
					</div>
				<?php } ?>

				<div class="site-header__menu">
					<?php if ( has_nav_menu('primary-menu') ){
						wp_nav_menu(array(
							'container' => false,
							'menu_class' => 'primary-menu',
							'theme_location' => 'primary-menu',
							'walker' => new cs__header_menu_walker()
						));
					} ?>

					<a class="site-header__search-toggle" href="#search">Search</a>
				</div>
			</div>

			<div id="search" class="site-header-search container">
				<form class="site-header-search__form searchform" action="<?= esc_url(home_url('/')); ?>" method="get" role="search">
					<input class="site-header-search__input" aria-label="search" type="search" name="s" placeholder="<?= esc_attr_x('Search', 'placeholder'); ?>" value="<?= get_search_query(); ?>">
					<input class="site-header-search__button" type="submit" value="<?= esc_attr_x('Search', 'submit button'); ?>">
				</form>
			</div>
		</header>

		<div class="site-header-navigation">
			<div class="site-header-navigation__menu">
				<?php if ( has_nav_menu('primary-menu') ){
					wp_nav_menu(array(
						'container' => false,
						'menu_class' => 'primary-menu',
						'theme_location' => 'primary-menu',
						'walker' => new cs__header_menu_mobile_walker()
					));
				} ?>
			</div>

			<?php if ( $header_navigation['text_bottom']!='' || $header_navigation['form']!='' ){ ?>
				<div class="site-header-navigation__footer">
					<?php if ( $header_navigation['text_bottom']!='' ){ ?>
						<div class="site-header-navigation__text-bottom"><?= $header_navigation['text_bottom']; ?></div>	
					<?php } ?>

					<?php if ( $header_navigation['form']!='' ){ ?>
						<div class="site-header-navigation__form"><?= $header_navigation['form']; ?></div>	
					<?php } ?>
				</div>
			<?php } ?>
		</div>

		<!-- Container -->
		<main id="primary" class="site-main">