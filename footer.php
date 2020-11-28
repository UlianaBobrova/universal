<footer class="footer">
    <div class="container">
    <?php
        if(!is_page_template('thankyou.php')){
            ?>
    <div class="footer-form-wrapper">
    <h3 class="footer-form-title">Подпишитесь на нашу рассылку</h3>
    <form action="https://app.getresponse.com/add_subscriber.html" accept-charset="utf-8" method="post" class="footer-form">
	<!-- Поле Email (обязательно) -->
	<input type="text" name="email" placeholder="Введите email" class="input footer-form-input"/>
	<!-- Токен списка -->
	<!-- Получить API ID на: https://app.getresponse.com/campaign_list.html -->
	    <input required type="hidden" name="campaign_token" value="Bey6M" />
        <!-- страница благодарности -->
        <input type="hidden" name="thankyou_url" value="<?php echo home_url('thankyou') ?>"/>
	<!-- Добавить подписчика в цикл на определенный день (по желанию) -->
	    <input type="hidden" name="start_day" value="0" />
	<!-- Кнопка подписаться -->
	    <button type="submit" value="Подписаться">Подписаться</button>
    </form> 
    </div>
    <?php 
    }
    ?>
        <div class="footer-menu-bar">
        <!-- выводим конкретно наш сайдбар -->
            <?php dynamic_sidebar( 'sidebar-footer' ); ?>
        </div>
    <!-- ./footer-menu-bar -->
    <div class="footer-info">

    <?php 
            // проверяем,если ли логотип. Если да-выводим его
        if(has_custom_logo()) {
            // проверяем, на главной ли мы странице
            if(is_front_page() || is_home()) {
            //  echo '<div class="logo">' . get_custom_logo() .
            //  '<span class="logo-name">' . get_bloginfo('name') . '</span></div>';
            echo '<span class="logo-name">' . get_bloginfo('name') . '</span>';
        }else {
            echo '<div class="logo">' . get_custom_logo() .
            '</div>';

        }
    }
        wp_nav_menu( [
            'theme_location'  => 'footer_menu',
            'container'       => 'nav', 
            'container_class' => 'footer-nav-wrapper',
            'menu_class'      => 'footer-nav', 
            'echo'            => true,
        ] );
    ?> 
  
    <?php 
    $instance = array(
        'title' => '',
        'link_facebook' => 'https://fb.com/',
        'link_twitter' => 'https://twitter.com/',
        'link_youtube' => 'https://youtube.com/'
    );
    $args = array(
       'before_widget' => '<div class = "footer-social">',
       'after_widget' => '</div>' 
    );
    the_widget( 'Social_Widget', $instance, $args); ?>
      </div>
    <!-- ./footer-info -->
    <div class="footer-text-wrapper">
        <?php dynamic_sidebar( 'sidebar-footer-text' ); ?>
        <span class="footer-copyright"><?php     
        //выводим поля ACF
        the_field('phone'); 
        echo '  &copy;  ' . date('Y  ') . get_bloginfo('  name');?></span>
        <!-- /.footer-copyright -->
    </div>
    <!-- /.footer-text-wrapper -->
    </div>
</footer>


<?php wp_footer(); ?>
</body>
</html>