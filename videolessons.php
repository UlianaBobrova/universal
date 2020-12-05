<?php
/*
Template Name: Страница видеоуроков
Template Post Type: page
*/
get_header();
?>
<div class="container">
<?php if (function_exists('the_breadcrumbs') ) the_breadcrumbs(); ?>
<div class="videolesson-list">
<?php		
global $post;
$query = new WP_Query( [
	'posts_per_page' => 100,
	'post_type' => 'videolesson',
] );

if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
        $query->the_post(); 
        // $query->the_post(); 
        // echo '<pre>';
        // var_dump($query);
        // echo '</pre>';
        ?>
                <div class="videolesson-card">
                <a href="<?php echo the_permalink() ?>" class="videolesson-permalink">
                    <img src="<?php 
                       the_field('thumbnail');
                    ?>" alt="" class="videolesson-thumb">
                <div class="videolesson-text">
                    <h4 class="videolesson-title"><?php echo mb_strimwidth(get_the_title(), 0, 30, '...'); ?> </h4>
                    <p class="videolesson-excerpt">
                        <?php echo mb_strimwidth(get_the_excerpt(), 0, 70, '...'); ?>
                    </p>
                </div>
                </a>
                <div class="author">
                <?php $author_id = get_the_author_meta('ID');?>
                <img src="<?php echo get_avatar_url($author_id);?>" alt="" class="author-avatar">
                <div class="author-info">
                        <span class="author-name">
                        <?php
                        $terms = get_terms( 'teacher' );

                        if( $terms && ! is_wp_error($terms) ){
                        foreach( $terms as $term ){
                            printf(
                                '<a href="%s" class="type-link">%s</a>',
                                esc_url(get_category_link($term)),
                                esc_html( $term -> name),
                            );}
                        }
                        ?>
                        </span>
                        <span class="videolesson-date"><?php the_time('j F'); ?></span>
                </div>
                </div>
                </div>
                   
                <?php 
	            }
            } else {
                // Постов не найдено
                ?> <p>Постов нет</p> <?php
            }
            wp_reset_postdata(); // Сбрасываем $post
            ?>
</div>
</div>
<?php
get_footer();