<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<!-- динамически wp может навешвать служебные классы на body -->
<body <?php body_class(); ?>>
<!-- возможность разработчикам вставлять свои участки кода,плагин,щетчик аналитики яндекс и -->
<?php wp_body_open(); ?>
<header class="header">
    <div class="container">
        <div class="header-wrapper">
            <?php 
            $logo_img = '';
            if(is_front_page()){
            if( $custom_logo_id = get_theme_mod('custom_logo') ){
                $logo_img = wp_get_attachment_image( $custom_logo_id, 'full', false, array(
                    'class'    => 'custom-logo',
                    'itemprop' => 'logo',
                ) );
                echo '<div class="logo">' . $logo_img .
                    '<span class="logo-name">' . get_bloginfo('name') . '</span></div>';
                }else {
                    echo '<span class="logo-name">' . get_bloginfo('name') . '</span>';
                }} else {
                    echo '<div class="logo">' . get_custom_logo() .
                        '<a class="logo-name" href="' . get_bloginfo('url') . '">' . get_bloginfo('name') . '</a></div>';
                }
            // echo $logo_img;
            // проверяем,если ли логотип. Если да-выводим его
                // if(has_custom_logo()) {
                //     echo '<div class="logo">' . get_custom_logo() .
                //     '<span class="logo-name">' . get_bloginfo('name') . '</span></div>';
                // }else {
                //     echo '<span class="logo-name">' . get_bloginfo('name') . '</span>';
                // }
            ?>
            <?php 
                wp_nav_menu( [
                    'theme_location'  => 'header_menu',
                    'container'       => 'nav', 
                    'container_class' => 'header-nav', 
                    'menu_class'      => 'header-menu', 
                    'echo'            => true,
                ] );
            ?>
            <?php echo get_search_form(); ?>
            <a href="#" class="header-menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>
    </div>
</header>