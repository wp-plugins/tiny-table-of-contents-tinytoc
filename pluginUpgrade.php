<?php
/**
 * @author Marijan Šuflaj <msufflaj32@gmail.com>
 * @link http://www.php4every1.com
 */

//Disable direct view.
if (!defined('IN_PLUGIN'))
    die('You can not access this file directly.');

//Update settings
$keys = array(
    'tinytoc_settings_enabled',
    'tinytoc_settings_header',
    'tinytoc_settings_general',
    'tinytoc_settings_parse',
    'tinytoc_settings_backtotop',
    'tinytoc_settings_tocstyle',
    'tinytoc_chapter_styling',
    'tinytoc_settings_info'
);

$autoload = array(
    'yes',
    'no',
    'no',
    'no',
    'no',
    'no',
    'no',
    'no'
);

$config = tinyConfig::getInstance()->get($keys);

$settings = array();
$settings[] = isset($config->tinytoc_settings_enabled) ? $config->tinytoc_settings_enabled : '1';

$configNew = new stdClass();

$configNew->title = isset($config->tinytoc_settings_header->title) ?
    $config->tinytoc_settings_header->title : 'Table of content';
$configNew->before = isset($config->tinytoc_settings_header->before) ?
    $config->tinytoc_settings_header->before : '<h3 id="tinyTOC">';
$configNew->after = isset($config->tinytoc_settings_header->after) ?
    $config->tinytoc_settings_header->after : '</h3>';
$configNew->css = isset($config->tinytoc_settings_header->css) ?
    $config->tinytoc_settings_header->css : '';

$settings[] = $configNew;

$configNew = new stdClass();

$configNew->maxLevelNum = isset($config->tinytoc_settings_general->maxLevelNum) ?
    $config->tinytoc_settings_general->maxLevelNum : 3;
$configNew->useBackToTop = isset($config->tinytoc_settings_general->useBackToTop) ?
    $config->tinytoc_settings_general->useBackToTop : true;
$configNew->useGoTo = isset($config->tinytoc_settings_general->useGoTo) ?
    $config->tinytoc_settings_general->useGoTo : true;
$configNew->priority = isset($config->tinytoc_settings_general->priority) ?
    $config->tinytoc_settings_general->priority : 8;
$configNew->removeWhenNotUsed = isset($config->tinytoc_settings_general->removeWhenNotUsed) ?
    $config->tinytoc_settings_general->removeWhenNotUsed : true;
$configNew->tocOnAllPages = isset($config->tinytoc_settings_general->tocOnAllPages) ?
    $config->tinytoc_settings_general->tocOnAllPages : false;

$settings[] = $configNew;

$configNew = new stdClass();

$configNew->parsePage = isset($config->tinytoc_settings_parse->parsePage) ?
    $config->tinytoc_settings_parse->parsePage : true;
$configNew->parsePost = isset($config->tinytoc_settings_parse->parsePost) ?
    $config->tinytoc_settings_parse->parsePost : true;
$configNew->parseHomePage = isset($config->tinytoc_settings_parse->parseHomePage) ?
    $config->tinytoc_settings_parse->parseHomePage : true;
$configNew->parseSearch = isset($config->tinytoc_settings_parse->parseSearch) ?
    $config->tinytoc_settings_parse->parseSearch : true;
$configNew->parseFeed = isset($config->tinytoc_settings_parse->parseFeed) ?
    $config->tinytoc_settings_parse->parseFeed : true;
$configNew->parseCategoryArchive = isset($config->tinytoc_settings_parse->parseCategoryArchive) ?
    $config->tinytoc_settings_parse->parseCategoryArchive : true;
$configNew->parseDateArchive = isset($config->tinytoc_settings_parse->parseDateArchive) ?
    $config->tinytoc_settings_parse->parseDateArchive : true;
$configNew->parseAnyArchive = isset($config->tinytoc_settings_parse->parseAnyArchive) ?
    $config->tinytoc_settings_parse->parseAnyArchive : true;
$configNew->pageExclude = isset($config->tinytoc_settings_parse->pageExclude) ?
    $config->tinytoc_settings_parse->pageExclude : array();
$configNew->postExclude = isset($config->tinytoc_settings_parse->postExclude) ?
    $config->tinytoc_settings_parse->postExclude : array();

$settings[] = $configNew;

$configNew = new stdClass();

$configNew->html = isset($config->tinytoc_settings_backtotop->html) ?
    $config->tinytoc_settings_backtotop->text : ' <small><a href="#tinyTOC">Top</a></small>';
$configNew->css = isset($config->tinytoc_settings_backtotop->css) ?
    $config->tinytoc_settings_backtotop->css : '';

$settings[] = $configNew;

$config = new stdClass();

$configNew->startList = isset($config->tinytoc_settings_tocstyle->startList) ?
    $config->tinytoc_settings_tocstyle->startList : '<ul>';
$configNew->endList = isset($config->tinytoc_settings_tocstyle->endList) ?
    $config->tinytoc_settings_tocstyle->endList : '</ul>';
$configNew->startItem = isset($config->tinytoc_settings_tocstyle->startItem) ?
    $config->tinytoc_settings_tocstyle->startItem : '<li>';
$configNew->endItem = isset($config->tinytoc_settings_tocstyle->endItem) ?
    $config->tinytoc_settings_tocstyle->endItem : '</li>';
$configNew->css = isset($config->tinytoc_settings_tocstyle->css) ?
    $config->tinytoc_settings_tocstyle->css : '';

$settings[] = $configNew;

$config = new stdClass();

$configNew->useChapterLevelStyling = isset($config->tinytoc_chapter_styling->useChapterLevelStyling) ?
    $config->tinytoc_chapter_styling->useChapterLevelStyling : false;
$configNew->stripExistingTags = isset($config->tinytoc_chapter_styling->stripExistingTags) ?
    $config->tinytoc_chapter_styling->stripExistingTags : false;
$configNew->levelStyleStart = isset($config->tinytoc_chapter_styling->levelStyleStart) ?
    $config->tinytoc_chapter_styling->levelStyleStart : array(
        1   => '',
        2   => '',
        3   => ''
    );
$configNew->levelStyleEnd = isset($config->tinytoc_chapter_styling->levelStyleEnd) ?
    $config->tinytoc_chapter_styling->levelStyleEnd : array(
        1   => '',
        2   => '',
        3   => ''
    );

$settings[] = $configNew;

$configNew = new stdClass();

$configNew->name = 'Tiny Table Of Content - TinyTOC';
$configNew->version = '1.6.3';
$configNew->home = 'http://php4every1.com/scripts/tiny-table-of-contents-wordpress-plugin/';
$configNew->author = 'Marijan Šuflaj';
$configNew->email = 'msufflaj32@gmail.com';
$configNew->authorHome = 'http://www.php4every1.com';

$settings[] = $configNew;

tinyConfig::getInstance()->delete($keys);

tinyConfig::getInstance()->create($keys, $settings, $autoload, 'no');