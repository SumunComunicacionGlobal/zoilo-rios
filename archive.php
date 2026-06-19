<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package zoilo-rios
 */

get_header();
$hero_block_title = 'Hero Archive';
$loop_block_title = 'Loop - Blog';

if ( is_tax('tema') || is_post_type_archive('proyecto') ) {
	$loop_block_title = 'Loop páginas';
}

?>

	<main id="primary" class="site-main">

	 	<?php 
	 		$block = get_page_by_title( $hero_block_title, OBJECT, 'wp_block' );
                if ( $block ) {
                    $block_content = apply_filters( 'the_content', $block->post_content );
                    echo $block_content;
                }
		?>

		<div class="breadcrumbs has-global-padding">
            <?php if (function_exists("rank_math_the_breadcrumbs")) rank_math_the_breadcrumbs(); ?>
        </div>

		<div class="wp-block-query entry-content wp-block-post-content has-global-padding is-layout-constrained">
			<div class="wp-block-group is-style-margin-vertical">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php 
						$block = get_page_by_title( $loop_block_title, OBJECT, 'wp_block' );
							if ( $block ) {
								$block_content = apply_filters( 'the_content', $block->post_content );
								echo $block_content;
							}
					?>
				</article>
			</div>
		</div><!-- .entry-content -->

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
