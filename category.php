<?php get_header();?>
<div class="container">
<?php if (function_exists('the_breadcrumbs') ) the_breadcrumbs(); ?>
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
        <div class="author">
            <?php $author_id = get_the_author_meta('ID');?>
            <img src="<?php echo get_avatar_url($author_id);?>" alt="" class="author-avatar">
            <div class="author-info">
                <span class="author-name"><strong><?php the_author();?></strong></span>
                <span class="date"><?php the_time('j F'); ?></span>
                <div class="comments">
                    <svg opacity="0.4" width="15" height="15" class="icon comments-icon">
                        <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#Comment-icon"></use>
                    </svg>
                    <span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
                </div>
                <div class="likes">
                    <svg opacity="0.4" width="15" height="15" class="icon likes-icon">
                        <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#Heart-icon"></use>
                    </svg>
                    <span class="likes-counter"><?php comments_number('0', '1', '%') ?></span>
                </div>
            </div>
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