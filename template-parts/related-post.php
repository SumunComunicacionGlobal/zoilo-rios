<?php
    $related = get_posts(
		array(
            'post_type' => 'post',
            'numberposts' => 3,
            'orderby' => 'rand',
            'post__not_in' => array ( $post->ID ),
        )
	);
    
    if( $related ): ?>

        <section class="wp-block entry-content is-layout-constrained has-global-padding">   
            <p class="has-heading-4-font-size uppercase"><?php esc_html_e( 'Entradas relacionadas', 'zoilo-rios' ); ?></p>
            <div class="">	
                <?php
                    if( $related ) foreach( $related as $post ) {
                        setup_postdata($post);
                        
                        get_template_part( 'template-parts/loop', get_post_type() );  
                        }
                    wp_reset_postdata();
                ?>
            </div>    
        </section>

     <?php endif ;?>