<?php get_header();?>
<main class="front-page-header">
    <div class="container">
        <div class="hero">
            <div class="left">
                <?php
        // объявляем глобальную переменную
            global $post;
        // параметры выводв постов, сколько выводим,из каких категорий и т.д
            $myposts = get_posts([ 
	            'numberposts' => 1,
                'category_name'    => 'JAVASCRIPT, css, html, Web Design',
            ]);
            // проверяем, есть ли посты?
            if( $myposts ){
                // если есть, запускаем цикл для перебора
	            foreach( $myposts as $post ){
		            setup_postdata( $post );
		            ?>
                <!-- <img src="<?php echo get_template_directory_uri() . '/assets/images/hero-image.jpg' ?>" alt="" class="post-thumb"> -->
                <!-- Теперь получаем картинку динамически -->
                <img src="<?php the_post_thumbnail_url(); ?>" alt="" class="post-thumb">
                <!-- узнаем данные пользователя -->
                <?php $author_id = get_the_author_meta('ID');?>
                <a href="<?php echo get_author_posts_url($author_id);?>" class="author">
                    <img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="avatar">
                    <div class="author-bio">
                        <span class="author-name"><?php the_author(); ?></span>
                        <span class="author-rank"><?php _e('Position', 'universe') ?></span>
                    </div>
                </a>
                <div class="post-text">
                    <?php 
                    // в цикле получаем категорию и заносим ее в переменную category
                        foreach (get_the_category() as $category) {
                            printf(
                                '<a href="%s" class="category-link %s">%s</a>',
                                // url лучше заворачивать в такую конструкцию. Делает нашу ссылку безопасной
                                esc_url( get_category_link($category)),
                                esc_html( $category -> slug),
                                esc_html( $category -> name),
                            );
                        }
                    ?>
                    <h2 class="post-title"><?php echo mb_strimwidth(get_the_title(), 0, 60, '...') ?></h2>
                    <a href="<?php echo get_the_permalink(); ?>" class="more"><?php _e('Read more', 'universal')?></a>
                </div>
                <?php 
	            }
            } else {
                // Постов не найдено
                ?> <p><?php _e('No posts', 'universal')?></p> <?php
            }

            wp_reset_postdata(); // Сбрасываем $post
        ?>
            </div>
            <div class="right">
                <h3 class="recommend"><?php _e('Recommend', 'universal')?></h3>
                <ul class="posts-list">
                    <?php
        // объявляем глобальную переменную
            global $post;
        // параметры выводв постов, сколько выводим,из каких категорий и т.д
            $myposts = get_posts([ 
                'numberposts' => 5,
                'offset' => 1,
                'category_name'    => 'JAVASCRIPT, css, html, Web Design',
                // 'category_name'    => 'JAVASCRIPT',
            ]);
            // проверяем, есть ли посты?
            if( $myposts ){
                // если есть, запускаем цикл для перебора
	            foreach( $myposts as $post ){
		            setup_postdata( $post );
		            ?>
                    <li class="post">
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
                        <a class="post-permalink" href="<?php echo get_the_permalink();?>">
                            <h4 class="post-title"><?php echo mb_strimwidth(get_the_title(), 0, 60, '...') ?></h4>
                        </a>
                    </li>
                    <?php 
	            }
            } else {
                // Постов не найдено
                ?> <p><?php _e('No posts', 'universal')?></p> <?php
            }

            wp_reset_postdata(); // Сбрасываем $post
        ?>
                </ul>
            </div>
        </div>
    </div>
</main>
<div class="container">
    <ul class="article-list">
        <?php
        // объявляем глобальную переменную
            global $post;
        // параметры выводв постов, сколько выводим,из каких категорий и т.д
            $myposts = get_posts([ 
                'numberposts' => 4,
                'category_name'    => 'articles',
            ]);
            // проверяем, есть ли посты?
            if( $myposts ){
                // если есть, запускаем цикл для перебора
	            foreach( $myposts as $post ){
		            setup_postdata( $post );
		            ?>
        <li class="article-item">
            <a class="article-permalink" href="<?php echo get_the_permalink();?>">
                <h4 class="article-title"><?php echo mb_strimwidth(get_the_title(), 0, 40, '...'); ?></h4>
            </a>
            <img width="65" height="65" src="<?php if( has_post_thumbnail() ) {
                        echo get_the_post_thumbnail_url(null, 'thumbnail');
                    } else {
	                    echo get_template_directory_uri().'./assets/images/image-default.png';
                    } ?>" alt="">
        </li>
        <?php 
	            }
            } else {
                // Постов не найдено
                ?> <p><?php _e('No posts', 'universal')?></p> <?php
            }

            wp_reset_postdata(); // Сбрасываем $post
        ?>
    </ul>
    <!-- ./article-list -->
    <div class="main-grid">
        <ul class="article-grid">
            <?php		
            global $post;
        // формируем запрос в базу данных
            $query = new WP_Query( [
                // получаем 7 постов
	            'posts_per_page' => 7,
                'orderby'        => 'comment_count',
                'category_name'    => 'articles',
                'tag' => 'Популярное',
                // 'meta_key' => 'css',
	            // 'meta_value'  => 'css',
            ] );
                // проверяем,есть ли посты
            if ( $query->have_posts() ) {
                // создаем переменную-счетчик постов
                $cnt = 0;
                // пока посты есть, выводим их
	            while ( $query->have_posts() ) {
                    $query->the_post();
                    // увеличиваем счетчик постов
                    $cnt++;
                    switch ($cnt) {
                        // первый пост
                        case '1':
                            ?>
            <li class="article-grid-item article-grid-item-1">
                <a href="<?php echo the_permalink() ?>" class="article-grid-permalink">
                    <img class="article-grid-thumb" src="<?php echo get_template_directory_uri() . '/assets/images/article-card1.png'?>" alt="">

                    <span class="category-name"><?php $category = get_the_category(); echo $category[0]->name; ?></span>
                    <h4 class="article-grid-title"><?php echo get_the_title(); ?> </h4>
                    <p class="article-grid-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 90, '...'); ?></p>
                    <div class="article-grid-info">
                        <div class="author">
                            <?php $author_id = get_the_author_meta('ID');?>
                            <img src="<?php echo get_avatar_url($author_id);?>" alt="" class="author-avatar">
                            <span class="author-name"><strong><?php the_author();?></strong> : <?php echo get_the_author_meta('description')?></span>
                        </div>
                        <div class="comments">
                            <svg fill="#BCBFC2" width="15" height="15" class="icon comments-icon">
                                <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#Comment-icon"></use>
                            </svg>
                            <span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
                        </div>
                    </div>
                </a>
            </li>
            <?php
                            break;
                            // выводим второй пост
                            case '2': ?>
            <li class="article-grid-item article-grid-item-2">
                <img src="<?php if( has_post_thumbnail() ) {
                        echo get_the_post_thumbnail_url();
                    } else {
	                    echo get_template_directory_uri().'./assets/images/image-default.png';
                    } ?>" alt="" class="article-grid-thumb">
                <a href="<?php echo the_permalink() ?>" class="article-grid-permalink">
                    <!-- выводим первый тег статьи -->
                    <span class="tag">
                        <?php $posttags = get_the_tags();
                            if ($posttags) {
                                echo $posttags[0]->name . '';
                            }?>
                    </span>
                    <span class="category-name"><?php $category = get_the_category(); echo $category[0]->name; ?></span>
                    <h4 class="article-grid-title"><?php the_title(); ?> </h4>
                    <div class="article-grid-info">
                        <div class="author">
                            <?php $author_id = get_the_author_meta('ID');?>
                            <img src="<?php echo get_avatar_url($author_id);?>" alt="" class="author-avatar">
                            <div class="author-info">
                                <span class="author-name"><strong><?php the_author();?></strong></span>
                                <span class="date"><?php the_time('j F'); ?></span>
                                <div class="comments">
                                    <svg fill="#FFFFFF" opacity="0.4" width="15" height="15" class="icon comments-icon">
                                        <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#Comment-icon"></use>
                                    </svg>
                                    <span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
                                </div>
                                <div class="likes">
                                    <svg fill="#fff" opacity="0.4" width="15" height="15" class="icon likes-icon">
                                        <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#Heart-icon"></use>
                                    </svg>
                                    <span class="likes-counter"><?php comments_number('0', '1', '%') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <?php

                            break;    

                            case '3': ?>
            <li class="article-grid-item article-grid-item-3">
                <a href="<?php echo the_permalink() ?>" class="article-grid-permalink">
                    <img src="<?php if( has_post_thumbnail() ) {
                        echo get_the_post_thumbnail_url();
                    } else {
	                    echo get_template_directory_uri().'./assets/images/image-default.png';
                    } ?>" alt="" class="article-grid-thumb">
                    <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 43, '...'); ?> </h4>
                </a>
            </li>
            <?php
                            break;
        // выводим остальные посты
                            default: ?>
            <li class="article-grid-item article-grid-item-default">
                <a href="<?php echo the_permalink() ?>" class="article-grid-permalink">
                    <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 22, '...'); ?> </h4>
                    <p class="article-grid-excerpt">
                        <?php echo mb_strimwidth(get_the_excerpt(), 0, 70, '...'); ?>
                    </p>
                    <span class="article-grid-date"><?php the_time('j F'); ?></span>
                </a>
            </li>
            <?php
                            break;    
                    }
		            ?>
            <!-- Вывода постов, функции цикла: the_title() и т.д. -->
            <?php 
	            }
            } else {
                // Постов не найдено
                ?> <p><?php _e('No posts', 'universal') ?></p> <?php
            }

            wp_reset_postdata(); // Сбрасываем $post
            ?>
        </ul>
        <!-- /.article-grid -->
        <!-- Подключаем sidebar -->
        <?php get_sidebar('front-page'); ?>
    </div>
</div>

<?php		
global $post;

$query = new WP_Query( [
	'posts_per_page' => 1,
	'category_name' => 'investigation',
] );

if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		?>
<section class="investigation" style="background: linear-gradient(0deg, rgba(64, 48, 61, 0.35), rgba(64, 48, 61, 0.35)), url(<?php if( has_post_thumbnail() ) {
                        echo get_the_post_thumbnail_url();
                    } else {
	                    echo get_template_directory_uri().'./assets/images/image-default.png';
                    }?>) no-repeat center center ">
    <div class="container">
        <h2 class="investigation-title"><?php the_title(); ?></h2>
        <a href="<?php echo get_the_permalink(); ?>" class="more"><?php _e('Read more', 'universal') ?></a>
    </div>
</section>
<?php 
	}
} else {
	// Постов не найдено
}

wp_reset_postdata(); // Сбрасываем $post
?>
<!-- /.investigation -->

<div class="option-grid">
    <div class="container">
        <div class="option-grid__wrapper">
            <ul class="news-grid">
                <?php		
        global $post;

$query = new WP_Query( [
	'posts_per_page' => 6,
	'category_name' => 'opinion, hot, news, compilation',
] );
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();                                                                                     
		?>
                <li class="news-item">
                    <img src="<?php 
                    //проверяем,есть ли у поста миниатюра
                    if( has_post_thumbnail() ) {
                        echo get_the_post_thumbnail_url();
                    } else {
	                    echo get_template_directory_uri().'./assets/images/image-default.png';
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
                            <svg fill="#BCBFC2" width="20" height="20" class="icon bookmarks-icon">
                                <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#Bookmark-icon"></use>
                            </svg>
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
                <?php 
	            }
            } else {
                // Постов не найдено
                ?> <p><?php _e('No posts', 'universal')?></p> <?php
            }
wp_reset_postdata(); // Сбрасываем $post
?>
            </ul>
            <?php get_sidebar('news'); ?>
        </div>
    </div>
</div>

<div class="special">
    <div class="container">
        <div class="special-grid">
            <?php		
        global $post;

$query = new WP_Query( [
	'posts_per_page' => 1,
	'category_name' => 'photo-report',
] );
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post(); ?>
            <div class="photo-report">
                <!-- Слайдер -->
                <!-- Slider main container -->
                <div class="swiper-container photo-report-slider">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <!-- получаем список всех вложенных картинок -->
                        <?php $images = get_attached_media( 'image');
                    foreach ($images as $image) {
                        echo '<div class="swiper-slide"><img src="';
                        print_r($image -> guid);
                        // guid - ссылка на картинку
                        echo '"></div>';
                    }
                    ?>
                    </div>
                    <!-- If we need pagination -->
                    <div class="swiper-pagination"></div>
                </div>


                <div class="photo-report-content">
                    <?php 
                foreach (get_the_category() as $category) {
                    printf(
                        '<a href="%s" class="category-link">%s</a>',
                        esc_url(get_category_link($category)),
                        esc_html( $category -> name),
                    );
                }
            ?>
                    <!-- узнаем данные пользователя -->
                    <?php $author_id = get_the_author_meta('ID');?>
                    <!-- получаем ссылку на автора -->
                    <a href="<?php echo get_author_posts_url($author_id);?>" class="author">
                        <img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="avatar">
                        <div class="author-bio">
                            <span class="author-name"><?php the_author(); ?></span>
                            <span class="author-rank"><?php _e('Position', 'universal')?></span>
                        </div>
                    </a>
                    <h3 class="photo-report-title">
                        <?php the_title() ?>
                    </h3>
                    <a href="<?php echo get_the_permalink() ?>" class="button button-photo">
                        <svg width="19" height="15" class="icon photo-report-icon">
                            <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#photo"></use>
                        </svg>
                        <?php _e('Look photo', 'universal') ?>
                        <span class="button-photo-counter"><?php echo count($images)?></span>
                    </a>
                </div>
            </div>
            <?php 
	            }
            } else {
                // Постов не найдено
                ?> <p><?php _e('No posts', 'universal')?></p> <?php
            }
            wp_reset_postdata(); // Сбрасываем $post
            ?>
            <div class="other">
                <div class="other-career">
                    <img src="<?php echo get_template_directory_uri() . '/assets/images/career.png';?>" alt="" class="other-career-thumb">
                    <div class="other-career-info">
                    <?php		
        global $post;

$query = new WP_Query( [
	'posts_per_page' => 1,
	'category_name' => 'career',
] );
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post(); ?>
                    <?php 
                foreach (get_the_category() as $category) {
                    printf(
                        '<a href="%s" class="category-link">%s</a>',
                        esc_url(get_category_link($category)),
                        esc_html( $category -> name),
                    );
                }
            ?>
                    <h4 class="other-career-title">
                        <?php the_title() ?>
                    </h4>
                    <p class="other-career-excerpt">
                        <?php echo mb_strimwidth(get_the_excerpt(), 0, 200, '...'); ?>
                    </p>
                    <a href="<?php echo get_the_permalink() ?>" class="more"><?php _e('Read more', 'universal')?></a>
                <?php 
	            }
            } else {
                // Постов не найдено
                ?> <p><?php _e('No posts', 'universal');?></p> <?php
            }
            wp_reset_postdata(); // Сбрасываем $post
            ?>
                    </div>
            </div>
            <div class="other-article">
                <?php		
        global $post;

$query = new WP_Query( [
	'posts_per_page' => 2,
	'category_name' => 'photo-report, opinion, hot, news, compilation',
] );
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post(); ?>

                <a href="<?php echo the_permalink() ?>" class="other-article-permalink">
                    <h4 class="other-article-title"><?php echo mb_strimwidth(get_the_title(), 0, 22, '...'); ?> </h4>
                    <p class="other-article-excerpt">
                        <?php echo mb_strimwidth(get_the_excerpt(), 0, 70, '...'); ?>
                    </p>
                    <span class="other-article-date"><?php the_time('j F'); ?></span>
                </a>
                <?php 
	            }
            } else {
                // Постов не найдено
                ?> <p><?php _e('No posts', 'universal')?></p> <?php
            }
            wp_reset_postdata(); // Сбрасываем $post
            ?>
            </div>
        </div>
    </div>
</div>
<!-- /.special -->

<?php
get_footer(); ?>
