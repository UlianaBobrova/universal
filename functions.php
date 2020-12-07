<?php
// проверяем,есть ли зарегистрированная ф-я,которая настраивает нашу тему
// если ф-я universal_theme_setup еще не существует,создаем ее
if (!function_exists('universal_theme_setup')) :
    // и внутри нее уже будет добавлять динамическое обновление полей, например title
   function universal_theme_setup() {
	// Подключение файлов перевода
	load_theme_textdomain( 'universal', get_template_directory() . '/languages' );


       //динамический вывод title 
       add_theme_support('title-tag');
       //добавляем возможность делать миниатюры изобраджений для статей
        add_theme_support('post-thumbnails', array('post'));
       //добавление пользовательского лого динамически
       add_theme_support( 'custom-logo', [
            'width'       => 163,
            'flex-height' => true,
            'header-text' => 'Universal',
            'unlink-homepage-logo' => false, // WP 5.5
        ] );
        // регистрация меню, ф-ия создает дырки под меню на сайте
            register_nav_menus( [
                'header_menu' => __('Header menu', 'universal'),
                'footer_menu' => __('Footer menu', 'universal'),
			] );
		// регистрация нового типа записей
		add_action( 'init', 'register_post_types' );
		function register_post_types(){
		register_post_type( 'videolesson', [
		'label'  => null,
		'labels' => [
			'name'               => __( 'Videolessons', 'universal' ), // основное название для типа записи
			'singular_name'      => __( 'Videolesson', 'universal' ), // название для одной записи этого типа
			'add_new'            => __( 'Add videolesson', 'universal' ), // для добавления новой записи
			'add_new_item'       => __( 'Add new videolesson', 'universal' ), // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => __( 'Edit videolesson', 'universal' ), // для редактирования типа записи
			'new_item'           => __( 'New videolesson', 'universal' ), // текст новой записи
			'view_item'          => __( 'View videolesson', 'universal' ), // для просмотра записи этого типа.
			'search_items'       => __( 'Search videolesson', 'universal' ), // для поиска по этим типам записи
			'not_found'          => __( 'Not found', 'universal' ), // если в результате поиска ничего не было найдено
			'not_found_in_trash' => __( 'Not found in trash', 'universal' ), // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => __( 'Videolessons', 'universal' ), // название меню
		],
		'description'         => __( 'Part with videolesson', 'universal' ),
		'public'              => true,
		'show_admin_column'   => true,
		// 'publicly_queryable'  => null, // зависит от public
		// 'exclude_from_search' => null, // зависит от public
		// 'show_ui'             => null, // зависит от public
		// 'show_in_nav_menus'   => null, // зависит от public
		'show_in_menu'        => true, // показывать ли в меню адмнки
		// 'show_in_admin_bar'   => null, // зависит от show_in_menu
		'show_in_rest'        => true, // добавить в REST API. C WP 4.7
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-video-alt2',
		'capability_type'   => 'post',
		//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
		//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
		'hierarchical'        => false,
		'supports'            => [ 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt', 'custom-fields', 'author' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => [],
		'has_archive'         => true,
		'rewrite'             => true,
		'query_var'           => true,
	] );
}

// хук, через который подключается функция
// регистрирующая новые таксономии (create_book_taxonomies)
add_action( 'init', 'create_videolesson_taxonomies' );

// функция, создающая 2 новые таксономии "genres" и "writers" для постов типа "book"
function create_videolesson_taxonomies(){

	// Добавляем древовидную таксономию 'genre' (как категории)
	register_taxonomy('type', array('videolesson'), array(
		'hierarchical'  => true,
		'labels'        => array(
			'name'              => _x( 'Type', 'taxonomy general name', 'universal' ),
			'singular_name'     => _x( 'Type', 'taxonomy singular name', 'universal' ),
			'search_items'      =>  __( 'Search Type', 'universal' ),
			'all_items'         => __( 'All Type', 'universal' ),
			'parent_item'       => __( 'Parent Type', 'universal' ),
			'parent_item_colon' => __( 'Parent Type:', 'universal' ),
			'edit_item'         => __( 'Edit Type', 'universal' ),
			'update_item'       => __( 'Update Type', 'universal' ),
			'add_new_item'      => __( 'Add New Type', 'universal' ),
			'new_item_name'     => __( 'New Type Name', 'universal' ),
			'menu_name'         => __( 'Type', 'universal' ),
		),
		// показывать ли это в меню
		'show_ui'       => true,
		'query_var'     => true,
		'rewrite'       => array( 'slug' => 'type' ), // свой слаг в URL
		'show_admin_column' => true,
	));

	// Добавляем НЕ древовидную таксономию 'writer' (как метки)
	register_taxonomy('teacher', 'videolesson',array(
		'hierarchical'  => false,
		'labels'        => array(
			'name'                        => _x( 'Teacher', 'taxonomy general name', 'universal' ),
			'singular_name'               => _x( 'Teacher', 'taxonomy singular name', 'universal' ),
			'search_items'                =>  __( 'Search Teachers', 'universal' ),
			'popular_items'               => __( 'Popular Teachers', 'universal' ),
			'all_items'                   => __( 'All Teachers', 'universal' ),
			'parent_item'                 => null,
			'parent_item_colon'           => null,
			'edit_item'                   => __( 'Edit Teacher', 'universal' ),
			'update_item'                 => __( 'Update Teacher', 'universal' ),
			'add_new_item'                => __( 'Add New Teacher', 'universal' ),
			'new_item_name'               => __( 'New Teacher Name', 'universal' ),
			'separate_items_with_commas'  => __( 'Separate Teacher with commas', 'universal' ),
			'add_or_remove_items'         => __( 'Add or remove teacher', 'universal' ),
			'choose_from_most_used'       => __( 'Choose from the most used teachers', 'universal' ),
			'menu_name'                   => __( 'Teachers', 'universal' ),
		),
		'show_ui'       => true,
		'query_var'     => true,
		'rewrite'       => array( 'slug' => 'teacher' ), // свой слаг в URL
		'show_admin_column' => true,
	));
	// Добавляем древовидную таксономию 'genre' (как категории)
}
/*
 * "Хлебные крошки" для WordPress
 * автор: Dimox
 * версия: 2019.03.03
 * лицензия: MIT
*/
function the_breadcrumbs() {

	/* === ОПЦИИ === */
	$text['home']     = __('Main', 'universe'); // текст ссылки "Главная"
	$text['category'] = '%s'; // текст для страницы рубрики
	$text['search']   = __('Results of search %s', 'universe'); // текст для страницы с результатами поиска
	$text['tag']      = __('Entries with tag "%s"', 'universe'); // текст для страницы тега
	$text['author']   = __('Author articles %s', 'universe'); // текст для страницы автора
	$text['404']      = __('Error 404', 'universe'); // текст для страницы 404
	$text['page']     = __('Page %s', 'universe'); // текст 'Страница N'
	$text['cpage']    = __('Comments page %s', 'universe'); // текст 'Страница комментариев N'

	$wrap_before    = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">'; // открывающий тег обертки
	$wrap_after     = '</div><!-- .breadcrumbs -->'; // закрывающий тег обертки
	$sep            = '<span class="breadcrumbs__separator"> › </span>'; // разделитель между "крошками"
	$before         = '<span class="breadcrumbs__current">'; // тег перед текущей "крошкой"
	$after          = '</span>'; // тег после текущей "крошки"

	$show_on_home   = 0; // 1 - показывать "хлебные крошки" на главной странице, 0 - не показывать
	$show_home_link = 1; // 1 - показывать ссылку "Главная", 0 - не показывать
	$show_current   = 1; // 1 - показывать название текущей страницы, 0 - не показывать
	$show_last_sep  = 1; // 1 - показывать последний разделитель, когда название текущей страницы не отображается, 0 - не показывать
	/* === КОНЕЦ ОПЦИЙ === */

	global $post;
	$home_url       = home_url('/');
	$link           = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	$link          .= '<a class="breadcrumbs__link" href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a>';
	$link          .= '<meta itemprop="position" content="%3$s" />';
	$link          .= '</span>';
	$parent_id      = ( $post ) ? $post->post_parent : '';
	$home_link      = sprintf( $link, $home_url, $text['home'], 1 );
	$page = get_page( $parent_id );

	if ( is_home() || is_front_page() ) {

		if ( $show_on_home ) echo $wrap_before . $home_link . $wrap_after;

	} else {

		$position = 0;

		echo $wrap_before;

		if ( $show_home_link ) {
			$position += 1;
			echo $home_link;
		}

		if ( is_category() ) {
			$parents = get_ancestors( get_query_var('cat'), 'category' );
			foreach ( array_reverse( $parents ) as $cat ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
			}
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				$cat = get_query_var('cat');
				echo $sep . sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_current ) {
					if ( $position >= 1 ) echo $sep;
					echo $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after;
				} elseif ( $show_last_sep ) echo $sep;
			}

		} elseif ( is_search() ) {
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				if ( $show_home_link ) echo $sep;
				echo sprintf( $link, $home_url . '?s=' . get_search_query(), sprintf( $text['search'], get_search_query() ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_current ) {
					if ( $position >= 1 ) echo $sep;
					echo $before . sprintf( $text['search'], get_search_query() ) . $after;
				} elseif ( $show_last_sep ) echo $sep;
			}

		} elseif ( is_year() ) {
			if ( $show_home_link && $show_current ) echo $sep;
			if ( $show_current ) echo $before . get_the_time('Y') . $after;
			elseif ( $show_home_link && $show_last_sep ) echo $sep;

		} elseif ( is_month() ) {
			if ( $show_home_link ) echo $sep;
			$position += 1;
			echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position );
			if ( $show_current ) echo $sep . $before . get_the_time('F') . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_day() ) {
			if ( $show_home_link ) echo $sep;
			$position += 1;
			echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position ) . $sep;
			$position += 1;
			echo sprintf( $link, get_month_link( get_the_time('Y'), get_the_time('m') ), get_the_time('F'), $position );
			if ( $show_current ) echo $sep . $before . get_the_time('d') . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_single() && ! is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$position += 1;
				$post_type = get_post_type_object( get_post_type() );
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->labels->name, $position );
				if ( $show_current ) echo $sep . $before . get_the_title() . $after;
				elseif ( $show_last_sep ) echo $sep;
			} else {
				$cat = get_the_category(); $catID = $cat[0]->cat_ID;
				$parents = get_ancestors( $catID, 'category' );
				$parents = array_reverse( $parents );
				$parents[] = $catID;
				foreach ( $parents as $cat ) {
					$position += 1;
					if ( $position > 1 ) echo $sep;
					echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
				}
				if ( get_query_var( 'cpage' ) ) {
					$position += 1;
					echo $sep . sprintf( $link, get_permalink(), get_the_title(), $position );
					echo $sep . $before . sprintf( $text['cpage'], get_query_var( 'cpage' ) ) . $after;
				} else {
					if ( $show_current ) echo $sep . $before . get_the_title() . $after;
					elseif ( $show_last_sep ) echo $sep;
				}
			}

		} elseif ( is_post_type_archive() ) {
			$post_type = get_post_type_object( get_post_type() );
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->label, $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . $post_type->label . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			}

		} elseif ( is_attachment() ) {
			$parent = get_post( $parent_id );
			$cat = get_the_category( $parent->ID ); $catID = $cat[0]->cat_ID;
			$parents = get_ancestors( $catID, 'category' );
			$parents = array_reverse( $parents );
			$parents[] = $catID;
			foreach ( $parents as $cat ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
			}
			$position += 1;
			echo $sep . sprintf( $link, get_permalink( $parent ), $parent->post_title, $position );
			if ( $show_current ) echo $sep . $before . get_the_title() . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_page() && ! $parent_id ) {
			if ( $show_home_link && $show_current ) echo $sep;
			if ( $show_current ) echo $before . get_the_title() . $after;
			elseif ( $show_home_link && $show_last_sep ) echo $sep;

		} elseif ( is_page() && $parent_id ) {
			$page = get_page( $parent_id );
			$parents = get_post_ancestors( get_the_ID() );
			foreach ( array_reverse( $parents ) as $pageID ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_page_link( $pageID ), get_the_title( $pageID ), $position );
			}
			if ( $show_current ) echo $sep . $before . get_the_title() . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_tag() ) {
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				$tagID = get_query_var( 'tag_id' );
				echo $sep . sprintf( $link, get_tag_link( $tagID ), single_tag_title( '', false ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			}

		} elseif ( is_author() ) {
			$author = get_userdata( get_query_var( 'author' ) );
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				echo $sep . sprintf( $link, get_author_posts_url( $author->ID ), sprintf( $text['author'], $author->display_name ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . sprintf( $text['author'], $author->display_name ) . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			}

		} elseif ( is_404() ) {
			if ( $show_home_link && $show_current ) echo $sep;
			if ( $show_current ) echo $before . $text['404'] . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( has_post_format() && ! is_singular() ) {
			if ( $show_home_link && $show_current ) echo $sep;
			echo get_post_format_string( get_post_format() );
		}

		echo $wrap_after;

	}
} // end of the_breadcrumbs()
   }
endif;
// все вышенаписанное сработает тогда,когда сработает хук событи 'after_setup_theme
add_action( 'after_setup_theme', 'universal_theme_setup' );

// подключение сайдбара
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function universe_theme_widgets_init() {
    // ф-ия регистрирует зоны под виджеты
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar in front page', 'universal' ),
			'id'            => 'main-sidebar',
			'description'   => esc_html__( 'Add widget here', 'universal' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	 // ф-ия регистрирует зоны под виджеты
	 register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar with news', 'universal' ),
			'id'            => 'news-sidebar',
			'description'   => esc_html__( 'Add widget here', 'universal' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	// ф-ия регистрирует зоны под виджеты
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer menu', 'universal' ),
			'id'            => 'sidebar-footer',
			'description'   => esc_html__( 'Add widget here', 'universal' ),
			'before_widget' => '<section id="%1$s" class="footer-menu %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="footer-menu-title">',
			'after_title'   => '</h2>',
		)
	);
	// ф-ия регистрирует зоны под виджеты
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer text', 'universal' ),
			'id'            => 'sidebar-footer-text',
			'description'   => esc_html__( 'Add widget here', 'universal' ),
			'before_widget' => '<section id="%1$s" class="footer-text %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
	// ф-ия регистрирует зоны под виджеты
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar content page', 'universal' ),
			'id'            => 'page-sidebar',
			'description'   => esc_html__( 'Add widget here', 'universal' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
}
add_action( 'widgets_init', 'universe_theme_widgets_init' );

/**
 * Добавление нового виджета Downloader_Widget.
 */
class Downloader_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'downloader_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: foo_widget
			__('Useful files', 'universal'),
			array( 'description' => __('Downloading files', 'universal'), 'classname' => 'widget-downloader', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_my_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_my_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
        $title = $instance['title'];
        $description = $instance['description'];
        $link = $instance['link'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
        }
        if ( ! empty( $description ) ) {
			echo '<p class="widget-description">' . $description . '</p>';
        }
        if ( ! empty( $link ) ) {
            echo '<a target="_black" class="widget-link" href="' . $link . '">
            <img class="widget-link-icon" src="' . get_template_directory_uri() . '/assets/images/download-icon.svg" >' . __('Download', 'universe') . '</a>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
        $title = @ $instance['title'] ?: __( 'Useful files', 'universal' );
        $description = @ $instance['description'] ?: __( 'Description', 'universal' );
        $link = @ $instance['link'] ?: 'http://yandex.ru/';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title: ', 'universal' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description: ', 'universal' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>">
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Downloading link: ', 'universal' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
        $instance = array();
        // записываем в массив и очищаем от тегов -strip_tags
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
        $instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_my_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_my_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.downloader_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Downloader_Widget

/**
 * Добавление нового виджета Social_Widget.
 */
class Social_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'social_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: foo_widget
			__('Useful files','universal'),
			array( 'description' => _e( 'Social networks', 'universal' ), 'classname' => 'widget-social', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_my_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_my_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
        $title = $instance['title'];
		$link_facebook = $instance['link_facebook'];
		$link_twitter = $instance['link_twitter'];
		$link_youtube = $instance['link_youtube'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
        }
        if ( ! empty( $link_facebook ) ) {
            echo '<a target="_black" href="' . $link_facebook . '">
            <img src="' . get_template_directory_uri() . '/assets/images/facebook-icon.svg" >
		</a>';
		}
		if ( ! empty( $link_twitter ) ) {
            echo '<a target="_black" href="' . $link_twitter . '">
            <img src="' . get_template_directory_uri() . '/assets/images/twitter-icon.svg" ></a>';
		}
		if ( ! empty( $link_youtube ) ) {
            echo '<a target="_black" href="' . $link_youtube. '">
			<img src="' . get_template_directory_uri() . '/assets/images/youtube-icon.svg" >
			</a>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
        $title = @ $instance['title'] ?: _e( 'Useful files', 'universal' );
		$link_facebook = @ $instance['link_facebook'] ?: 'http://yandex.ru/';
		$link_twitter = @ $instance['link_twitter'] ?: 'http://yandex.ru/';
		$link_youtube = @ $instance['link_youtube'] ?: 'http://yandex.ru/';
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title ', 'universal' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'link_facebook' ); ?>"><?php _e( 'Facebook link: ', 'universal' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link_facebook' ); ?>" name="<?php echo $this->get_field_name( 'link_facebook' ); ?>" type="text" value="<?php echo esc_attr( $link_facebook ); ?>">
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'link_twitter' ); ?>"><?php _e( 'Twitter link: ', 'universal' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link_twitter' ); ?>" name="<?php echo $this->get_field_name( 'link_twitter' ); ?>" type="text" value="<?php echo esc_attr( $link_twitter ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_youtube' ); ?>"><?php _e( 'Youtube link: ', 'universal' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link_youtube' ); ?>" name="<?php echo $this->get_field_name( 'link_youtube' ); ?>" type="text" value="<?php echo esc_attr( $link_youtube ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
        $instance = array();
        // записываем в массив и очищаем от тегов -strip_tags
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['link_facebook'] = ( ! empty( $new_instance['link_facebook'] ) ) ? strip_tags( $new_instance['link_facebook'] ) : '';
		$instance['link_twitter'] = ( ! empty( $new_instance['link_twitter'] ) ) ? strip_tags( $new_instance['link_twitter'] ) : '';
		$instance['link_youtube'] = ( ! empty( $new_instance['link_youtube'] ) ) ? strip_tags( $new_instance['link_youtube'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_my_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_my_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.social_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Social_Widget

// регистрация Downloader_Widget в WordPress
function register_downloader_widget() {
	register_widget( 'Downloader_Widget' );
	
}
// регистрация Social_Widget в WordPress
function register_social_widget() {
	register_widget( 'Social_Widget' );
}
add_action( 'widgets_init', 'register_downloader_widget' );
add_action( 'widgets_init', 'register_social_widget' );

/**
 * Добавление нового виджета Resent_Post_Widget.
 */
class Resent_Post_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'resent_post_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: foo_widget
			__('Resently published', 'universal'),
			array( 'description' => __( 'New posts', 'universal' ), 'classname' => 'widget-resent-post', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_my_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_my_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
        $title = $instance['title'];
		$count = $instance['count'];

		echo $args['before_widget'];
		
        if ( ! empty( $count ) ) {
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo '<div class="widget-resent-post-wrapper">';
				global $post;
				$postslist = get_posts( array( 'posts_per_page' => $count, 'order'=> 'ASC', 'orderby' => 'title' 				) );
				foreach ( $postslist as $post ){
					setup_postdata($post);
					?>
				<a href="<?php the_permalink() ?>" class="resent-post-link">
					<img class="resent-post-thumb" src="<?php echo get_the_post_thumbnail_url(null, 'thumbnail') ?>" alt="">
					<div class="resent-post-info">
						<h4 class="resent-post-title">
						<?php echo mb_strimwidth(get_the_title(), 0, 30, '...')?>
						</h4>
						<span class="resent-post-time">
							<?php $time_diff = human_time_diff( get_post_time('U'), current_time('timestamp') );
							echo $time_diff . __(' ago', 'universe')?>
						</span>
					</div>
				</a>
				<?php
			}
		wp_reset_postdata();
		echo '</div>';
		} 
		echo '<div class="widget-resent-post-last">';
		 ?>
		<a href="<?php the_permalink($post) ?>" class="resent-post-item">Read more</a>
		<?php
		echo '</div>';
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
        $title = @ $instance['title'] ?: __( 'Recently published', 'universal' );
		$count = @ $instance['count'] ?: '7';
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'universal' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of posts:', 'universal' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
        $instance = array();
        // записываем в массив и очищаем от тегов -strip_tags
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_my_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_my_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.resent_post_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Social_Widget

// регистрация Resent_Post_Widget в WordPress
function register_resent_post_widget() {
	register_widget( 'Resent_Post_Widget' );
	
}
add_action( 'widgets_init', 'register_resent_post_widget' );

/**
 * Добавление нового виджета Resent_Post_Widget.
 */
class Recommend_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'recommend_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: foo_widget
			'Рекомендованные статьи',
			array( 'description' => __( 'Recommend articles', 'universal' ), 'classname' => 'widget-recommend', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_my_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_my_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
        $title = $instance['title'];
		$count = $instance['count'];

		echo $args['before_widget'];
		
        if ( ! empty( $count ) ) {
			echo '<div class="container">';
			echo '<div class="widget-recommend-wrapper">';
				global $post;
				foreach (get_the_category() as $category) {
				$cat = get_category_link($category);
				$query = new WP_Query( [
					'posts_per_page' => $count,
					'category_name' => $cat,
				] );
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post(); ?>
							<a class="recommend-permalink" href="<?php echo get_the_permalink(); ?>">
								<img src="<?php 
                    //проверяем,есть ли у поста миниатюра
                    				if( has_post_thumbnail() ) {
                        				echo get_the_post_thumbnail_url(null, 'thumbnail');
                    				} else {
	                    				echo get_template_directory_uri().'./assets/images/image-default.png';
                    				}
                    				?>" alt="" class="recommend-item-thumb">
                            	<h4 class="recommend-title"><?php echo mb_strimwidth(get_the_title(), 0, 60, '...') ?></h4>
								<div class="recommend-info">
								<div class="eye">
                                    <svg fill="#BCBFC2" width="15" height="15" class="icon eye-icon">
                                        <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#Eye"></use>
                                    </svg>
                                    <span class="eye-counter"><?php comments_number('0', '1', '%') ?></span>
                                </div>
                                <div class="comments">
                                    <svg fill="#BCBFC2" width="15" height="15" class="icon comments-icon">
                                        <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#Comment-icon"></use>
                                    </svg>
                                    <span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
                                </div>
                            </div>
							</a>
								<?php 
								}
							} else {
								// Постов не найдено
		};
	}
		wp_reset_postdata();
		echo '</div>';
		echo '</div>';
		} 
	
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
        $title = @ $instance['title'] ?: __( 'Recommend articles', 'universal' );
		$count = @ $instance['count'] ?: '7';
		?>

        <p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of posts:', 'universal' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
        $instance = array();
        // записываем в массив и очищаем от тегов -strip_tags
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_my_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_my_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.recommend_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Social_Widget

// регистрация Resent_Post_Widget в WordPress
function register_recommend_widget() {
	register_widget( 'Recommend_Widget' );
	
}
add_action( 'widgets_init', 'register_recommend_widget' );

// подключение стилей Значение time убрать после окончания разработки!!!!!
function enqueue_universal_style() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'swiper-slider', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', 'style');
    wp_enqueue_style( 'universal-theme', get_template_directory_uri() . '/assets/css/universal-theme.css', 'style', time());
	// подключение шрифта
    wp_enqueue_style('Roboto-Slab', '//fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
	wp_deregister_script( 'jquery-core' );
	wp_register_script( 'jquery-core', '//code.jquery.com/jquery-3.5.1.min.js');
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', null, true);
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/js/scripts.js', 'swiper', time(), true);
}
add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' );

// Отправка формы посредством AJAX
add_action( 'wp_enqueue_scripts', 'adminAjax_data', 99 );
function adminAjax_data(){
	wp_localize_script( 'jquery', 'adminAjax', 
		array(
			'url' => admin_url('admin-ajax.php')
		)
	);  

}
// обработчик формы
add_action('wp_ajax_contacts_form', 'ajax_form');
add_action('wp_ajax_nopriv_contacts_form', 'my_action_callback');
function ajax_form() {
	//с помощью post-запроса беру имя,которое передалось. contact_name - name из input
	$contact_name = $_POST['contact_name'];
	$contact_email = $_POST['contact_email'];
	$contact_comment = $_POST['contact_comment'];
	$message = __( 'User left their data: ', 'universal' ) . $contact_name;
	// $headers = 'From: webmaster@example.com' . "\r\n" .
    // 'Reply-To: webmaster@example.com' . "\r\n" .
    // 'X-Mailer: PHP/' . phpversion();
	// $message = 'Пользователь ' . $contact_name . 'задал вопрос: ' . $contact_comment . '. Его email: ' . $contact_email;
	// mail('uliana.bobrova@gmail.com', 'Новая заявка', $message, $headers );

	$headers = 'From: Uliana <uliana.bobrova@gmail.com>' . "\r\n";
	$sent_message = wp_mail('uliana.bobrova@gmail.com', 'Новая заявка с сайта', $message, $headers);
	if ($sent_message) {
		echo 'Все получилось';
	}else {
		echo 'Где-то есть ошибка';
	}
	// выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
	wp_die();
}
## фильтр для облака тэгов, изменяем настройки облака тэгов
add_filter( 'widget_tag_cloud_args', 'edit_widget_tag_cloud_args');
function edit_widget_tag_cloud_args($args) {
	$args['unit'] = 'px';
	$args['smallest'] = '14';
	$args['largest'] = '14';
	$args['number'] = '11';
	// сортировка по кол-ву повторений тега
	$args['orderby'] = 'count';
	return $args;
}


## отключаем создание миниатюр файлов для указанных размеров
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, [
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	] );
}

// меняем стиль многоточие в отрывках
add_filter('excerpt_more', function($more) {
	return '...';
});

// склоняем слова после числительных
function plural_form($number, $after) {
	$cases = array (2, 0, 1, 1, 1, 2);
	echo $number.' '.$after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
}