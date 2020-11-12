<?php get_header('post');?>
    <main class="site-main">
    <?php
    // запускаем цикл wp и проверяем,есть ли посты
        while ( have_posts() ) :
            // если пост есть, выводим содержимое
			the_post();
            // находим шаблон для вывода поста в папке temlate/parts
			get_template_part( 'template-parts/content', get_post_type() );
            // ищет файл template-parts/content-{post-type}
            
			// Если комментариии к записи открыты,выводим комментарии
            if ( comments_open() || get_comments_number() ) :
                // находим файл comments.php и выводим его
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

    </main>
<?php get_footer();?>