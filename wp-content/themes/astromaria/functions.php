<?
add_action('wp_enqueue_scripts', function() {
  wp_enqueue_style(
    'astromaria-style',
    get_stylesheet_directory_uri() . '/style.css',
    [],
    filemtime(get_stylesheet_directory() . '/style.css')
  );
});

add_action('init', function () {
	register_post_type('news', [
		'description' => '',
		'exclude_from_search' => false,
		'has_archive' => true,
		'hierarchical' => false,
		'label'  => null,
		'labels' => [
			'add_new' => 'Добавить новость',
			'add_new_item' => 'Добавление новости',
			'all_items' => 'Все новости',
			'archives' => 'Архивы новостей',
			'attributes' => 'Свойства новости',
			'edit_item' => 'Редактировать новость',
			'featured_image' => 'Миниатюра новости',
			'filter_items_list' => 'Фильтровать список новостей',
			'insert_into_item' => 'Вставить в новость',
			'item_published' => 'Новость опубликована',
			'item_published_privately' => 'Новость опубликована приватно',
			'item_reverted_to_draft' => 'Новость переведена в черновик',
			'item_scheduled' => 'Новость запланирована',
			'item_updated' => 'Новость обновлена',
			'items_list' => 'Список новостей',
			'items_list_navigation' => 'Навигация по новостям',
			'menu_name' => 'Новости',
			'name' => 'Новости',
			'name_admin_bar' => 'Новости',
			'new_item' => 'Новая новость',
			'not_found' => 'Новости не найдены',
			'not_found_in_trash' => 'Новостей не найдено в корзине',
			'parent_item_colon' => 'Родительская страница',
			'remove_featured_image' => 'Удалить миниатюру новости',
			'search_items' => 'Поиск новости',
			'set_featured_image' => 'Установить миниатюру новости',
			'singular_name' => 'Новость',
			'uploaded_to_this_item' => 'Загружено для этой новости',
			'use_featured_image' => 'Использовать как миниатюру новости',
			'view_item' => 'Посмотреть новость',
			'view_items' => 'Посмотреть новости'
		],
		'menu_icon' => 'dashicons-portfolio',
		'menu_position' => 4,
		'public' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => true,
		'show_ui' => true,
		'show_in_admin_bar' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_rest' => true,
		'supports' => [
      // 'author',
      // 'comments',
      // 'custom-fields',
      'editor',
      'excerpt',
      // 'page-attributes',
      'post-formats',
      'revisions',
      'thumbnail',
      'title'
      // 'trackbacks'
		],
		'taxonomies' => [
			'category',
			'post_tag'
		]
	]);
});

add_action('after_setup_theme', function () {
	add_theme_support('title-tag');
});