<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * MaxSite CMS
 * (c) https://max-3000.com/
 */


//  функция автоподключения плагина
function feed_turbo_autoload()
{
    mso_hook_add('custom_page_404', 'feed_custom');
}

# функции плагина
function feed_custom()
{

	if ( mso_segment(1)=='feedturbo' )
	{
		// подключили свой файл вывода
		require( getinfo('plugins_dir') . 'feed_turbo/turbo/home.php' );
		return true; // выходим с true
	}
}


// функция выполняется при активации (вкл) плагина
function feed_turbo_activate()
{
	mso_create_allow('feed_turbo_edit', t('Админ-доступ к настройкам feed_turbo'));
}

// функция выполняется при деактивации (выкл) плагина
function feed_turbo_deactivate()
{
	// mso_delete_option('plugin_feed_turbo', 'plugins' ); // удалим созданные опции
}

// функция выполняется при деинсталяции плагина
function feed_turbo_uninstall()
{
	mso_delete_option('plugin_feed_turbo', 'plugins'); // удалим созданные опции
	mso_remove_allow('feed_turbo_edit'); // удалим созданные разрешения
}

// функция отрабатывающая миниопции плагина (function плагин_mso_options)
// если не нужна, удалите целиком
function feed_turbo_mso_options()
{
	if (!mso_check_allow('feed_turbo_edit')) {
		echo t('Доступ запрещен');
		return;
	}

	// ключ, тип, ключи массива
	mso_admin_plugin_options(
		'plugin_feed_turbo',
		'plugins',
		[
			'full_rss' => [
				'type' => 'checkbox',
				'name' => t('Полные записи в RSS Яндекс.Турбо:'),
				'description' => t('Отметьте, если нужно отдавать в RSS Яндекс.Турбо полные записи. Если нет, то будет только до [cut].
                    '),
				'default' => '0'
			],
			'ytnumber' => [
				'type' => 'text',
				'name' => t('Количество записей:'),
				'description' => t('Общее количество записей в RSS-ленте (обязательно прочтите про <a target="_blank" href="https://yandex.ru/dev/turbo/doc/rss/quota-docpage/">ограничения</a> Яндекса). <br>
                    <!-- При установке более 1000 записей необходимо включить разбитие RSS-ленты в обязательном порядке. --> <br>
                    '),
				'default' => '50'
			],
			'ytmetrika' => [
				'type' => 'text',
				'name' => t('Яндекс.Метрика'),
				'description' => t('Укажите числовой идентификатор счетчика (например: 53603568)'),
				'default' => ''
			],
			'ytgoogle' => [
				'type' => 'text',
				'name' => t('Google Analytics'),
				'description' => t('Укажите идентификатор отслеживания (например: UA-12340005-6)'),
				'default' => ''
			],

			'ytliveinternet' => [
				'type' => 'text',
				'name' => t('LiveInternet'),
				'description' => t('Укажите идентификатор счетчика (например: site.ru)'),
				'default' => ''
			],
			'ytmailru' => [
				'type' => 'text',
				'name' => t('Рейтинг Mail.Ru'),
				'description' => t('Укажите числовой идентификатор счетчика (например: 1234567)'),
				'default' => ''
			],
			'ytrambler' => [
				'type' => 'text',
				'name' => t('Rambler Топ-100'),
				'description' => t('Укажите числовой идентификатор счетчика (например: 4505046)'),
				'default' => ''
			],
			'ytmediascope' => [
				'type' => 'text',
				'name' => t('Mediascope (TNS)'),
				'description' => t('Идентификатор проекта <tt>tmsec</tt> с окончанием <tt>-turbo</tt>. <br>Например, если для обычных страниц сайта установлен счетчик <tt>example_total</tt>, <br>то для турбо-страниц указывается <tt>example_total-turbo</tt>.'),
				'default' => ''
			],
            /*
			'ytad1rsa' => [
				'type' => 'text',
				'name' => t('РСЯ идентификатор'),
				'description' => t('Описание'),
				'default' => ''
			],
            */
		],
		t('Настройки плагина feed_turbo'), // титул
		t('Укажите необходимые опции.')   // инфо
	);
}

// функции плагина
function feed_turbo_custom($arg = [])
{

}

# end of file
?>
