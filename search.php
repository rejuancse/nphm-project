<?php get_header();

$search_query = get_search_query();
$page_url = get_site_url() .'?s='. $search_query;

$post_type = 'all';
if ( isset($_GET) ){
	if ( isset($_GET['t']) ){
		$post_type = $_GET['t'];
	}
}
$post_type = ( in_array($post_type, array('page', 'event','program',  'post', 'aviary-cpt')) ) ? $post_type : 'all'; ?>


<div class="search-results container">
	<?= cs__the_breadcrumbs('search-results__breadcrumbs'); ?>

	<?php get_template_part('parts/section/hero/hero'); ?>

	<div class="search-results__container">
		<form class="search-results__form searchform" action="<?= esc_url(home_url('/')); ?>" method="get" role="search">
			<input class="search-results__input" aria-label="search" type="search" name="s" placeholder="<?= esc_attr_x('Search...', 'placeholder'); ?>" value="<?= get_search_query(); ?>">
			<input class="search-results__button" type="submit" value="<?= esc_attr_x('Search', 'submit button'); ?>">
		</form>

		<ul class="feed-categories has-background-blue">
			<li class="feed-categories__item <?= ( $post_type=='all' ) ? 'is-active' : ''; ?>">
				<a class="builtin" href="<?= $page_url .'&t=all'; ?>">All</a>
			</li>
			<li class="feed-categories__item <?= ( $post_type=='page' ) ? 'is-active' : ''; ?>">
				<a class="builtin" href="<?= $page_url .'&t=page'; ?>">Page</a>
			</li>
			<li class="feed-categories__item <?= ( $post_type=='event' ) ? 'is-active' : ''; ?>">
				<a class="builtin" href="<?= $page_url .'&t=event'; ?>">Event</a>
			</li>
			<li class="feed-categories__item <?= ( $post_type=='program' ) ? 'is-active' : ''; ?>">
				<a class="builtin" href="<?= $page_url .'&t=program'; ?>">Program</a>
			</li>
			<li class="feed-categories__item <?= ( $post_type=='post' ) ? 'is-active' : ''; ?>">
				<a class="builtin" href="<?= $page_url .'&t=post'; ?>">Story</a>
			</li>
			<li class="feed-categories__item <?= ( $post_type=='aviary-cpt' ) ? 'is-active' : ''; ?>">
				<a class="builtin" href="<?= $page_url .'&t=aviary-cpt'; ?>">Oral History Archive</a>
			</li>
		</ul>

		<?php if ( have_posts() ): ?>
			<div class="grid grid--jc-center">
				<?php while ( have_posts() ): the_post(); ?>
					<div class="search-results__item col col--8 col--lg-10 col--sm-10 col--xs-12">
						<?php get_template_part('parts/content/search-card/search-card'); ?>
					</div>
				<?php endwhile; ?>
			</div>

			<?php cs__the_pagination(); ?>

		<?php else: ?>
			<h2><?php _e('Sorry, no posts found.', CSWP); ?></h2>

			<?php endif; wp_reset_query(); ?>
	</div>
</div>

<?php get_footer(); ?>