<?php get_header();?>
<div class="container">
<h1 class="category-title">
   <?php single_cat_title();?>
   </h1> 
   <div class="post-list">
        <?php while ( have_posts() ){ the_post(); ?>
	    <div class="post-card">
        <img src="<?php 
                    //проверяем,есть ли у поста миниатюра
                    if( has_post_thumbnail() ) {
                        echo get_the_post_thumbnail_url();
                    } else {
	                    echo get_template_directory_uri() . '/assets/images/image-default.png';
                    }
                    ?>" alt="" class="post-card-thumb">
        <div class="post-card-text">
        <h2 class="post-card-title"><?php echo mb_strimwidth(get_the_title(), 0, 28, '...'); ?></h2>
        <p><?php echo mb_strimwidth(get_the_excerpt(), 0, 75, '...'); ?></p>
        <span class="other-article-date"><?php the_time('j F'); ?></span>
        </div>
        </div>
        </div>
        <?php } ?>
        <?php if ( ! have_posts() ){ 
	      _e('No entries', 'universal') ; 
        } ?>
   </div>
</div>
<?php get_footer();?>