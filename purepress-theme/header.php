<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package purepress
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<header class="navbar bg-body text-dark sticky-top z-5 d-block py-2 drop-shadow">
			<div class="container">
				<div class="col-lg-2 col-md-4 col-4  order-md-2 order-lg-1 order-sm-2 order-2">
					<?php
					if (has_custom_logo()) {
						$custom_logo_id = get_theme_mod('custom_logo');
						$custom_logo = wp_get_attachment_image($custom_logo_id, 'full', false, array('class' => 'site-branding'));
						echo $custom_logo;
					} else {
						echo '<h1>' . get_bloginfo('name') . '</h1>';
					}
					?>
				</div>
				<div class="col-lg-8 col-md-4 col-4  order-md-1 order-lg-2 order-sm-1 order-1">
					<div class="desktop d-none d-sm-none d-md-none d-lg-block">
						<nav class="navbar navbar-expand-lg justify-content-center">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'container' => false,
									'menu_class' => '',
									'menu_id' => 'primary-menu',
									'fallback_cb' => '__return_false',
									'items_wrap' => '<ul id="bootscore-navbar" class="navbar-nav justify-content-center m-0 %2$s">%3$s</ul>',
									'depth' => 2,
									'walker' => new bootstrap_5_wp_nav_menu_walker()
								)
							);
							?>
						</nav>
					</div>
					<div class="off-c d-lg-none">
						<button class="btn text-dark" type="button" data-bs-toggle="offcanvas"
							data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
							<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
								class="bi bi-list" viewBox="0 0 16 16">
								<path fill-rule="evenodd"
									d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z">
								</path>
							</svg>
						</button>
						<div class="offcanvas offcanvas-start bg-black w-75" data-bs-scroll="true" tabindex="-1"
							id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel" data-bs-theme="dark">
							<div class="offcanvas-header justify-content-end">
								<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
							</div>
							<div class="offcanvas-body text-light">
								<nav class="navbar navbar-expand-lg ">
									<?php
									wp_nav_menu(
										array(
											'theme_location' => 'menu-1',
											'container' => false,
											'menu_class' => '',
											'menu_id' => 'primary-menu',
											'fallback_cb' => '__return_false',
											'items_wrap' => '<ul id="bootscore-navbar" class="navbar-nav justify-content-center m-0 %2$s">%3$s</ul>',
											'depth' => 2,
											'walker' => new bootstrap_5_wp_nav_menu_walker()
										)
									);
									?>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-4 col-4  order-lg-3 order-md-3 order-sm-3 order-3 d-flex justify-content-end">
					<div class="search-icon">
						<button class="btn text-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop"
							aria-controls="offcanvasTop">
							<svg xmlns="http://www.w3.org/2000/svg" class="feather feather-search" fill="none" height="24"
								stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								viewBox="0 0 24 24" width="24">
								<circle cx="11" cy="11" r="8"></circle>
								<line x1="21" x2="16.65" y1="21" y2="16.65"></line>
							</svg>
						</button>
						<div class="offcanvas offcanvas-top bg-black" tabindex="-1" id="offcanvasTop"
							aria-labelledby="offcanvasTopLabel" data-bs-theme="dark">
							<div class="offcanvas-header justify-content-end">
								<button type="button" class="btn-close " data-bs-dismiss="offcanvas"
									aria-label="Close"></button>
							</div>
							<div class="offcanvas-body container ">
								<div class="fs-2">Search</div>
								<form role="search" method="get" class="search-form"
									action="<?php echo esc_url(home_url('/')); ?>">
									<label class="w-100">
										<span class="screen-reader-text">
											<?php echo _x('Search for:', 'label', 'your-theme-text-domain'); ?>
										</span>
										<input type="search" class="search-field w-100 p-2 bg-white text-dark"
											placeholder="<?php echo esc_attr_x('Hit enter to search or ESC to close', 'placeholder', 'your-theme-text-domain'); ?>"
											value="<?php echo get_search_query(); ?>" name="s" />
									</label>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>