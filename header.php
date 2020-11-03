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
            // проверяем,если ли логотип. Если да-выводим его
                if(has_custom_logo()) {
                    the_custom_logo();
                }else {
                    echo 'Universal';
                }
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