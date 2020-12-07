<?php
get_header();
?>
<div class="container">
<h1 class="search-title"><?php _e('Search result: ', 'universal')?><?php the_search_query(); ?> </h1>
<div class="option-grid">
<div class="option-grid__wrapper">
<div class="news-grid__wrapper">
<ul class=news-grid>
    <?php while ( have_posts() ){ the_post(); ?>
        <li class="news-item">
                    <img src="<?php 
                    //проверяем,есть ли у поста миниатюра
                    if( has_post_thumbnail() ) {
                        echo get_the_post_thumbnail_url();
                    } else {
	                    echo get_template_directory_uri() . '/assets/images/image-default.png';
                    }
                    ?>" alt="" class="news-item-thumb">

                    <div class="news-item-right">
                        <div class="news-item-top">
                            <span class="news-item-name">
                                <?php 
                            foreach (get_the_category() as $category) {
                                printf(
                                    '<a href="%s" class="category-link %s">%s</a>',
                                    esc_url(get_category_link($category)),
                                    esc_html( $category -> slug),
                                    esc_html( $category -> name),
                                );
                            }
                            ?></span>
                        </div>
                        <a class="post-permalink" href="<?php echo get_the_permalink(); ?>">
                            <h4 class="post-title"><?php echo mb_strimwidth(get_the_title(), 0, 60, '...') ?></h4>
                            <p class="news-item-excerpt">
                                <?php echo mb_strimwidth(get_the_excerpt(), 0, 200, '...'); ?>
                            </p>
                            <div class="author-info">
                                <span class="date"><?php the_time('j F'); ?></span>
                                <div class="comments">
                                    <svg fill="#BCBFC2" width="15" height="15" class="icon comments-icon">
                                        <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#Comment-icon"></use>
                                    </svg>
                                    <span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
                                </div>
                                <div class="likes">
                                    <svg fill="#BCBFC2" width="15" height="15" class="icon likes-icon">
                                        <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#Heart-icon"></use>
                                    </svg>
                                    <span class="likes-counter"><?php comments_number('0', '1', '%') ?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </li>
    <?php } ?>
    <?php if ( ! have_posts() ){ ?>
	    <?php _e('No entries', 'universal')?>
    <?php } ?>
</ul>
<?php 
$args = array (
    'prev_text'    => __('Back', 'universal'),
	'next_text'    => __('Next', 'universal'),
);
the_posts_pagination( $args )?>
</div>
<?php get_sidebar('news'); ?>
</div>
</div>
</div>

<?php get_footer(); ?>
