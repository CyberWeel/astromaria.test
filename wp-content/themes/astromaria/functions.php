<?
// Установка основного файла стилей
add_action('wp_enqueue_scripts', function() {
  wp_enqueue_style(
    'astromaria-style',
    get_stylesheet_directory_uri() . '/style.min.css',
    [],
    filemtime(get_stylesheet_directory() . '/style.min.css')
  );
});

// Создание типа записей "Новости"
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
		'rewrite' => [
			'slug' => 'news',
			'with_front' => false,
		],
		'show_ui' => true,
		'show_in_admin_bar' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_rest' => true,
		'supports' => [
      'editor',
      'excerpt',
      'post-formats',
      'revisions',
      'thumbnail',
      'title'
		],
		'taxonomies' => [
			'category',
			'post_tag'
		]
	]);
});

// Отображение миниатюр в админке. Вывод title на страницах
add_action('after_setup_theme', function () {
	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');
});

// Установка вывода 8 новостей в пагинации
add_action('pre_get_posts', function ($query) {
	if (!is_admin() && $query->is_main_query() && $query->is_post_type_archive('news')) {
		$query->set('posts_per_page', 8);
	}
});

// Добавление к URL статей "/articles/"
add_filter('post_link', function ($permalink, $post) {
	if ($post->post_type === 'post') {
		return home_url('/articles/' . $post->post_name . '/');
	}
	
	return $permalink;
}, 10, 2);

// Правило переписи URL для статей для устранения возможных конфликтов с news
add_action('init', function () {
	add_rewrite_rule(
		'^articles/([^/]+)/?$',
		'index.php?post_type=post&name=$matches[1]',
		'top'
	);
});

// Функция для обрезки текста до $length символов
function show_custom_excerpt(String $text, Int $length = 100) :String {
	$text = wp_strip_all_tags($text);

	if (mb_strlen($text) <= $length) return $text;

	$text = mb_substr($text, 0, $length);
	$text = mb_substr($text, 0, mb_strrpos($text, ' '));
	return $text . '...';
}

// Функция, возвращающая количество просмотров поста
function get_post_views() {
	$post_id = get_the_ID();
	return (int) get_post_meta($post_id, 'views', true);
}

// Функция, увеличивающая количество просмотров поста на 1
function increment_post_views() {
	if (is_single() && !is_admin()) {
		$post_id = get_the_ID();
		$views = get_post_views();

		update_post_meta($post_id, 'views', $views + 1);
	}
}
add_action('wp', 'increment_post_views');

// Получение "Похожих записей" поста
function get_related_posts($post_type = 'post', $limit = 4) {
	$post_id = get_the_ID();

	if (!$post_id) return [];

	$categories = wp_get_post_categories($post_id);
	$tags = wp_get_post_tags($post_id, ['fields' => 'ids']);
	$found = [];

	// Получаем опубликованные записи, исключая текущую и найденные.
	$get_posts = function($args) use ($post_id, &$found, $limit, $post_type) {
		$args = array_merge([
			'post_type'           => $post_type,
			'post_status'         => 'publish',
			'posts_per_page'      => $limit - count($found),
			'post__not_in'        => array_merge([$post_id], $found),
			'ignore_sticky_posts' => true,
			'fields'              => 'ids',
		], $args);

		if ($args['posts_per_page'] <= 0) return;

		$ids = get_posts($args);

		foreach ($ids as $id) {
			$found[] = $id;
		}
	};

	// 1. Полное совпадение набора меток.
	if ($tags) {
		$candidates = get_posts([
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'post__not_in'   => [$post_id],
			'tag__and'       => $tags,
			'fields'         => 'ids'
		]);

		foreach ($candidates as $id) {
			$candidate_tags = wp_get_post_tags($id, ['fields' => 'ids']);
			sort($candidate_tags);
			$current_tags = $tags;
			sort($current_tags);

			if ($candidate_tags === $current_tags) {
				$found[] = $id;
				
				if (count($found) >= $limit) {
					return array_slice($found, 0, $limit);
				}
			}
		}
	}

	// 2. Частичное совпадение меток.
	if ($tags && count($found) < $limit) {
		$get_posts([
			'tag__in' => $tags,
			'orderby' => 'date',
			'order'   => 'DESC'
		]);
	}

	// 3. Совпадение рубрики.
	if ($categories && count($found) < $limit) {
		$get_posts([
			'category__in' => $categories,
			'orderby'      => 'date',
			'order'        => 'DESC'
		]);
	}

	// 4. Случайные записи.
	if (count($found) < $limit) {
		$get_posts([ 'orderby' => 'rand' ]);
	}

	return array_slice($found, 0, $limit);
}

// Подключение файла JavaScript
add_action('wp_enqueue_scripts', function() {
	wp_enqueue_script(
		'main-js',
		get_stylesheet_directory_uri() . '/js/main.min.js',
		array('jquery'),
		'1.0',
		true
	);
});