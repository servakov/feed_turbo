<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$info = [
	'name' => t('RSS for Yandex Turbo'),
	'description' => t('Добавляет отдельный RSS канал с разметкой под Яндекс.Турбо-страницы, сразу после установки и активации плагина можно отдавать Яндексу в Вебмастере канал по адресу «http(s)://YOUR_SITE/feedturbo/». Разметка соответствует требованиям Яндекса и выдает ошибки при тесте обычными xml валидаторами, тк имеет специфические теги.'),
	'version' => '1.1',
	'author' => 'servakov',
	'plugin_url' => 'https://github.com/servakov/feed_turbo',
	'author_url' => 'http://wpgrabber-tune.blogspot.com/',
	'group' => 'rss',

    // https://yandex.ru/dev/turbo/doc/rss/markup-docpage/
    // https://max-3000.com/doc/scheme-maxsite
    // https://valentin-kupriyanov.ru/page/kak-vostanovit-rss-lentu-na-maxsite-cms-esli-slomalas

    // https://yandex.ru/dev/turbo/#plagins
    // https://yandex.ru/dev/turbo/doc/quick-start/articles-docpage/

    // реадакторы/модификаторы
	// 'editors' => '',

	// ссылка на help плагина
	'help' => getinfo('plugins_url') . 'feed_turbo/feed_turbo_help.txt', # ссылка на help плагина

	// ссылка на свою страницу настроек (только если используется свой admin.php!)
	// 'options_url' => getinfo('site_admin_url') . 'pluginX_',
];

# end of file