<article id="videolesson-<?php the_ID(); ?>" <?php post_class(); ?>>
    <!-- шапка поста -->
    <header class="entry-header <?php echo get_post_type()?>-header" style="background: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75)), url(<?php the_field('thumbnail');?>) 100%/cover no-repeat">
        <div class="container">
            <div class="videolesson-header-wrapper">
                <div class="videolesson-header-nav">
                    <?php
		    foreach (get_the_category() as $category) {
				printf(
					'<a href="%s" class="category-link %s">%s</a>',
					esc_url(get_category_link($category)),
					esc_html( $category -> slug),
					esc_html( $category -> name),
				);
			}
			?>
            </div>
                <div class="videolesson">
                <!-- <iframe width="100%" height="450" src="https://www.youtube.com/embed/a4fv-BtzNmY" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
                    <?php
                    $video_link = get_field('video');
                    if(strpos($video_link, 'youtube')) {
                        $tmp = explode('?v=', get_field('video'));?>
                        <iframe width="100%" height="450" src="https://www.youtube.com/embed/<?php echo end($tmp); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> 
                        <?php
                    }
                    if(strpos($video_link, 'vimeo')) {
                        $tmp = explode('.com/', get_field('video'));?>
                        <iframe src="https://player.vimeo.com/video/<?php echo end($tmp);?>" width="100%" height="640" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                        <?php
                    }

                         ?>
                </div>
                <div class="vdeolesson-header-title-wrapper">
                
                <div class="vdeolesson-header-item">
                <div class="vdeolesson-header-left">
                    <?php
            // проверяем,точно ли мы странице поста
		    if ( is_singular() ) :
			    the_title( '<h1 class="post-title">', '</h1>' );
		    else :
			    the_title( '<h2 class="post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		    endif;?>
                    <!-- выводим краткое описание записи -->

                    <!-- выводим  -->
                    <div class="post-header-info">
                        <span class="post-header-date">
                            <img class="icon post-header-clock" src="<?php echo get_template_directory_uri() . '/assets/images/clock-icon.svg' ?>">
                            <?php the_time('j F, H:i'); ?></span>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </header><!-- .entry-header -->

    <div class="container">
    
        <!-- Содержимое поста -->
        <div class="post-content">
            <?php
        // выводим содержимое
		the_content(
            // выводим его на экран
			sprintf(
                // очищаем от разных лишних тегов 
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'universe-example' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
                // очищаем от разных лишних тегов title
                wp_kses_post( get_the_title() )
			)
		);
        // Обертка для страничной навигации, например,когда пост состоит из нескольких постов
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'universe-example' ),
				'after'  => '</div>',
			)
		);
		?>
        
        </div><!-- .post-content -->
        </div>
        <!-- подвал сайта -->
        <footer class="post-footer">
        <div class="container">
        <?php
                    $terms = get_terms( 'type' );

                    if( $terms && ! is_wp_error($terms) ){
                        foreach( $terms as $term ){
                            printf(
                                '<a href="%s" class="type-link">%s</a>',
                                esc_url(get_category_link($term)),
                                esc_html( $term -> name),
                            );}
                        }
                // ссылки на соцсети
                meks_ess_share(); ?>
                </div>
                <?php
                // Виджет с рекомендованными статьями
                // get_sidebar('page'); 
            ?>

        </footer>
    
</article>
