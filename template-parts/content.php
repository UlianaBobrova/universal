<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <!-- шапка поста -->
    <header class="entry-header <?php echo get_post_type()?>-header" style="background: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75)), url(
        <?php if( has_post_thumbnail() ) {
            echo get_the_post_thumbnail_url();
                } else {
	                echo get_template_directory_uri().'./assets/images/image-default.png';
                }?>) 100%/cover no-repeat">
        <div class="container">
            <div class="post-header-wrapper">
                <div class="post-header-nav">
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
                    <!-- ссылка на главную -->
                    <a class="home-link" href="<?php echo get_home_url(); ?>">
                        <img src="<?php echo get_template_directory_uri() . '/assets/images/home.svg'?>"> На главную
                    </a>
                    <?php
			// выводим ссылки на предыдущий и следующий посты
            the_post_navigation(
				array(
					'prev_text' => '<span class="post-nav-prev">
					<img class="prev-icon" src="' . get_template_directory_uri() . '/assets/images/arrow-back.svg">
					' . esc_html__( 'Назад', 'universe-example' ) . '</span>',
					'next_text' => '<span class="post-nav-next">' . esc_html__( 'Вперед', 'universe-example' ) . '
					<img class="next-icon" src="' . get_template_directory_uri() . '/assets/images/arrow-next.svg">
					</span>',
				)
			); 
			?>
                </div>
                <div class="post-header-title-wrapper">
                
                <div class="post-header-item">
                <div class="post-header-left">
                    <?php
            // проверяем,точно ли мы странице поста
		    if ( is_singular() ) :
			    the_title( '<h1 class="post-title">', '</h1>' );
		    else :
			    the_title( '<h2 class="post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		    endif;?>
                    <!-- выводим краткое описание записи -->
                    <p class="post-excerpt">
                        <?php echo mb_strimwidth(get_the_excerpt(), 0, 300, '...'); ?>
                    </p>
                    <!-- выводим  -->
                    <div class="post-header-info">
                        <span class="post-header-date">
                            <img class="icon post-header-clock" src="<?php echo get_template_directory_uri() . '/assets/images/clock-icon.svg' ?>">
                            <?php the_time('j F, H:i'); ?></span>
                        <div class="likes post-header-likes">
                            <svg fill="#BCBFC2" width="15" height="15" class="icon likes-icon">
                                <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#Heart-icon"></use>
                            </svg>
                            <span class="likes-counter"><?php comments_number('0', '1', '%') ?></span>
                        </div>
                        <div class="comments post-header-comments">
                            <svg fill="#BCBFC2" width="15" height="15" class="icon comments-icon">
                                <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#Comment-icon"></use>
                            </svg>
                            <span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
                        </div>
                    </div>
                    </div>
                    <div class="post-header-right">
                    <svg fill="#BCBFC2" width="21" height="27" class="icon post-header-bookmarks-icon">
                    <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#Bookmark-icon"></use>
                    </svg>
                    </div>
                    </div>
                    <div class="post-author">
                        <div class="post-author-info">
                        <?php $author_id = get_the_author_meta('ID');?>
                            <img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="post-author-avatar">
                                <span class="post-author-name"><?php the_author(); ?></span>
                                <span class="post-author-rank">Должность</span>
                                <span class="post-author-posts">
                                <?php plural_form(count_user_posts($author_id), 
                                // варианты написания для количества 1,2 и 5
                                array('статья', 'статьи', 'статей'))
                                ?></span>
                        </div>
                        <!-- /.post-author-info -->
                        <a href="<?php echo get_author_posts_url($author_id);?>" class="post-author-link">Страница автора</a>
                    </div>
                    <!-- /.post-author -->
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
                $tags_list = get_the_tag_list( '', esc_html_x( ' ', 'list item separator', 'universe-example' ) );
			    if ( $tags_list ) {
				/* translators: 1: list of tags. */
				    printf( '<span class="tags-links">' . esc_html__( '%1$s', 'universe-example' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                }
                // ссылки на соцсети
                meks_ess_share(); ?>
                </div>
                <?php
                // Виджет с рекомендованными статьями
                get_sidebar('page'); 
            ?>

        </footer>
    
</article>
