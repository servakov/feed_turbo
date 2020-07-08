<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * MaxSite CMS
 * (c) https://max-3000.com/
 */

mso_cur_dir_lang('templates');

#global $MSO, $mso_page_current;
$CI = &get_instance();
$CI->load->helper('xml');

header('Content-Type: application/rss+xml; charset=utf-8');



$cache_key = mso_md5('feed_turbo_' . mso_current_url());
$k = mso_get_cache($cache_key);

if ($k) return print($k); // да есть в кэше

$options = mso_get_option('plugin_feed_turbo', 'plugins', 1);
#var_export($options);
extract($options);
#die();
ob_start();



$time_zone = getinfo('time_zone'); // 2.00 -> 200
$time_zone_server = date('O') / 100; // +0100 -> 1.00
$time_zone = $time_zone + $time_zone_server; // 3
$time_zone = number_format($time_zone, 2, '.', ''); // 3.00

if ($time_zone < 10 and $time_zone > 0) {
	$time_zone = '+0' . $time_zone;
} elseif ($time_zone > -10 and $time_zone < 0) {
	$time_zone = '0' . $time_zone;
	$time_zone = str_replace('0-', '-0', $time_zone);
} else {
	$time_zone = '+00.00';
}

$time_zone = str_replace('.', '', $time_zone);

$encoding = 'utf-8';
if($ytnumber)
{
    $limit = $ytnumber;
}else
{
    $limit = mso_get_option('limit_post_rss', 'templates', 7);
}

$cut = $full_rss ? false : tf('Читать полностью') . ' »';
#$cut = mso_get_option('full_rss', 'templates', 0) ? false : tf('Читать полностью') . ' »';
$feed_name = mso_head_meta('title');
$description = mso_head_meta('description');
$feed_url = getinfo('siteurl');
$language = 'en-ru';
$generator = 'MaxSite CMS (https://max-3000.com/)';

$par = ['custom_type'=>'home', 'limit' => $limit, 'cut' => $cut, 'type' => false, 'pagination' => false, 'only_feed' => true];

$pages = mso_get_pages($par, $pagination);
#var_export($pages);

if ($pages) {
	$pubdate = date('D, d M Y H:i:s ' . $time_zone, strtotime(mso_date_convert('Y-m-d H:i:s', $pages[0]['page_date_publish'])));

	echo '<' . '?xml version="1.0" encoding="UTF-8"?' . '>';
	?>
	<rss xmlns:yandex="http://news.yandex.ru"
     xmlns:media="http://search.yahoo.com/mrss/"
     xmlns:turbo="http://turbo.yandex.ru"
     version="2.0">
        <channel>
            <!-- Информация о сайте-источнике -->
            <title><?= $feed_name ?></title>
            <link><?= $feed_url ?></link>
            <description><?= $description ?></description>
    <?php if ($ytmetrika) { ?><turbo:analytics id="<?php echo $ytmetrika; ?>" type="Yandex"></turbo:analytics><?php echo PHP_EOL; ?><?php } ?>
    <?php if ($ytliveinternet) { ?><turbo:analytics type="LiveInternet"></turbo:analytics><?php echo PHP_EOL; ?><?php } ?>
    <?php if ($ytgoogle) { ?><turbo:analytics id="<?php echo $ytgoogle; ?>" type="Google"></turbo:analytics><?php echo PHP_EOL; ?><?php } ?>
    <?php if ($ytmailru) { ?><turbo:analytics id="<?php echo $ytmailru; ?>" type="MailRu"></turbo:analytics><?php echo PHP_EOL; ?><?php } ?>
    <?php if ($ytrambler) { ?><turbo:analytics id="<?php echo $ytrambler; ?>" type="Rambler"></turbo:analytics><?php echo PHP_EOL; ?><?php } ?>
    <?php if ($ytmediascope) { ?><turbo:analytics id="<?php echo $ytmediascope; ?>" type="Mediascope"></turbo:analytics><?php echo PHP_EOL; ?><?php } ?>


            <language>ru</language>
            <pubDate><?= $pubdate ?></pubDate>
            <language><?= $language ?></language>
            <generator><?= $generator ?></generator>
            <copyright>Copyright <?= gmdate("Y", time()) ?>, <?= getinfo('siteurl') ?></copyright>
            <?php foreach ($pages as $page) : extract($page); ?>
                <item turbo="true">
                    <title><![CDATA[<?= xml_convert(strip_tags($page_title)) ?>]]></title>
                    <link><?= getinfo('siteurl') . 'page/' . mso_slug($page_slug) ?></link>
                    <turbo:topic><![CDATA[<?= xml_convert(strip_tags($page_title)) ?>]]></turbo:topic>
                    <turbo:source><?= getinfo('siteurl') . 'page/' . mso_slug($page_slug) ?></turbo:source>
                    <pubDate><?= date('D, d M Y H:i:s ' . $time_zone, strtotime(mso_date_convert('Y-m-d H:i:s', $page_date_publish))) ?></pubDate>
                    <?= mso_page_cat_link($page_categories, ", ", '<category><![CDATA[', ']]></category>' . "\n", false, 'category', false) ?>
                    <turbo:content>
                        <![CDATA[<?= mso_page_content($page_content) ?>]]>
                    </turbo:content>
                    <yandex:related></yandex:related>
                </item>
            <?php endforeach; ?>
        </channel>
    </rss>
<?php
}

mso_add_cache($cache_key, ob_get_flush()); // сразу и в кэш добавим - время 10 минут 60 сек * 10 минут *

# end of file
