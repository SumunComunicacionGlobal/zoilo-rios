<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package zoilo-rios
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content wp-block-post-content has-global-padding is-layout-constrained wp-block-post-content-is-layout-constrained">
		
        <?php
                
            the_content();

            $block = get_page_by_title( 'CTA Form', OBJECT, 'wp_block' );
            if ( $block ) {
                $block_content = apply_filters( 'the_content', $block->post_content );
                echo $block_content;
            }
        
            $block = get_page_by_title( 'Section - Testimonios', OBJECT, 'wp_block' );
            if ( $block ) {
                $block_content = apply_filters( 'the_content', $block->post_content );
                echo $block_content;
            }
        ?>
        

    </div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
