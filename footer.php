<footer class="footer">
    <div class="container">
        <div class="footer-menu-bar">
        <!-- выводим конкретно наш сайдбар -->
            <?php dynamic_sidebar( 'sidebar-footer' ); ?>
        </div>
    <!-- ./footer-menu-bar -->
    <div class="footer-info">

    <?php 
        wp_nav_menu( [
            'theme_location'  => 'footer_menu',
            'container'       => 'nav', 
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
        <span class="footer-copyright"><?php echo '&copy;  ' . date('Y  ') . get_bloginfo('  name');?></span>
        <!-- /.footer-copyright -->
    </div>
    <!-- /.footer-text-wrapper -->
    </div>
</footer>


<?php wp_footer(); ?>
</body>
</html>