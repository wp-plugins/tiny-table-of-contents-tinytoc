<?php
/*
    Plugin Name: Tiny Table Of Content - TinyTOC
    Plugin URI: http://www.php4every1.com
    Description: Advanced plugin for dynamic creation of "Table of content" for you post or pages.
    Version: 0.3
    Author: Marijan Šuflaj
    Author URI: http://www.php4every1.com
*/

/*  
    Copyright 2009  Marijan Šuflaj  (email : msufflaj32@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Used for preventing direct view.
define('IN_PLUGIN', true);

//Load config class.
include 'classes/config.php';

if (get_option('tinytoc_settings_enabled') === false) {
    include 'installTinyTOC.php';
}

//Call function that hooks menus to admin panel.
add_action('admin_menu', 'hookMenus');

//Hook init function.
add_action('init', 'tinyTocAddButtons');

add_action('wp_footer', 'echoStyleSheets');

/**
 * Function create stylesheets.
 * 
 * @return 
 */
function echoStyleSheets()
{
	$options = array(
        'tinytoc_settings_header',
        'tinytoc_settings_backtotop',
        'tinytoc_settings_tocstyle',
    );

    $config = tinyConfig::getInstance()->get($options);
    
?>
<!-- TinyTOC Stylesheets -->
<style type="text/css">
/* Header styles */
<?php echo $config->tinytoc_settings_header->css ?>

/* Back To Top button styles */
<?php echo $config->tinytoc_settings_backtotop->css ?>

/* Table Of Content styles */
<?php echo $config->tinytoc_settings_tocstyle->css ?>
</style>
<?php
}


/**
 * Init function
 * 
 * @return
 */
function tinyTocAddButtons() {

        //Add button and plugin to tinyMCE editor.
        add_filter("mce_external_plugins", "tinyTocAddPlugin");

        add_filter('mce_buttons', 'tinyTocRegisterButton');


}

/**
 * Register button function.
 *
 * @param array $buttons Buttons that need to be enabled
 * @return array Buttons that need to be enabled
 */
function tinyTocRegisterButton($buttons) {

    array_push($buttons, 'tinyPlugin');

    return $buttons;

}

/**
 * Register plugin function
 *
 * @param array $plugin_array Plugins that need to be registered
 * @return array Plugins that need to be registered
 */
function tinyTocAddPlugin($plugin_array) {
	
	//Start output buffering.
	ob_start();
	
?> 
	(function()  {
    // Create a new plugin class
    tinymce.create('tinymce.plugins.ExamplePlugin', {
    createControl: function(n, cm) {
        switch (n) {
            case 'tinyPlugin':
                var mlb = cm.createListBox('tinyPlugin', {
                     title : 'TOC Levels',
                     onselect : function(v) {
                         var content = tinyMCE.activeEditor.selection.getContent({format : 'text'});
                         tinyMCE.activeEditor.selection.setContent('[tinytoc level="' + v + '"]' + content + '[/tinytoc]');
                     }
                });

                // Add some values to the list box
<?php
//Create levels.
$config = tinyConfig::getInstance()->get('tinytoc_settings_general');
$num = $config->tinytoc_settings_general->maxLevelNum + 1;
for ($i = 1; $i < $num; $i++) :
?>
                mlb.add('Level <?php echo $i; ?>', '<?php echo $i; ?>');
<?php 
endfor;
?>

                // Return the new listbox instance
                return mlb;
        }

        return null;
    }

    });
    
    // Register plugin with a short name
    tinymce.PluginManager.add('tinyPlugin', tinymce.plugins.ExamplePlugin);
})();

<?php
    
    //Stop output buffering and save content to file.
    $content = ob_get_clean();
    $file = fopen(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'tinyPlugin.js', 'w');
    fwrite($file, $content);
    fclose($file);

    $plugin_array['tinyPlugin'] = plugins_url('tinytoc/js/tinyPlugin.js');

    return $plugin_array;

}

/*
 * Function that hooks menus to admin panel.
 * 
 * @return
 */
function hookMenus()
{	
	//Menu.
    add_menu_page('TinyTOC Sumary', 'TinyTOC', 8, 'tinytoc/home.php');
    
    //Submenus.
    add_submenu_page('tinytoc/home.php', 'TinyTOC Summary', 'Summary', 8, 'tinytoc/home.php');
    add_submenu_page('tinytoc/home.php', 'TinyTOC Settings', 'Settings', 8, 'tinytoc/settings.php');
    
    $options = array(
        'tinytoc_settings_enabled',
        'tinytoc_settings_header',
        'tinytoc_settings_general',
        'tinytoc_settings_parse',
        'tinytoc_settings_backtotop',
        'tinytoc_settings_tocstyle',
        'tinytoc_settings_info'
    );

    tinyConfig::getInstance()->get($options);
}

$config = tinyConfig::getInstance()->get('tinytoc_settings_general');
add_action(
    'the_content', 
    'startContentParsing', 
    $config->tinytoc_settings_general->priority
);

/**
 * Function that start parsing.
 *
 * @param string $data Post content
 * @return string Parsed post content
 */
function startContentParsing($data)
{
	//Get config.
	$config = tinyConfig::getInstance()->get(array(
	    'tinytoc_settings_enabled',
        'tinytoc_settings_header',
        'tinytoc_settings_general',
        'tinytoc_settings_tocstyle'
    ));
    
    if ($config->tinytoc_settings_enabled !== '1')
        return $data;
	
    //Get post.
	global $post;
	
	//Split it by <!--nextpage-->.
	$allContent = explode('<!--nextpage-->', $post->post_content);
	//Number of pages.
	$numPages = count($allContent);
	
	//Get current page of multipage post.
	$currentPage = ((int) get_query_var('page') === 0) ? 1 : (int) get_query_var('page');
	
	//Check if we need to parse it.
	if (!checkIfWeNeedToParse())
	    return $data;
	
	$urlStuffTemp = array();
	$urlStuff = array();
	
	   
	$match = false;
	
	//Loop all pages.
	for ($i = 0; $i < $numPages; $i++) {
		//Search for levels and celan them
		if (preg_match_all(
		        '/\[tinytoc[[:space:]]+level="([0-9]+)"\]([\S\s]*?)\[\/tinytoc\]/i', 
		        $allContent[$i], $urlStuffTemp
		    )) {
		    $match = true;
			
		    $allContent[$i] = preg_replace_callback(
			    '/\[tinytoc[[:space:]]+level="([0-9]+)"\]([\S\s]*?)\[\/tinytoc\]/i',
                'callbackReplace',
			    $allContent[$i]
			);
			
			//Loop each match.
			foreach ($urlStuffTemp as $k => $v) {
				if ($k === 0) {
					foreach ($v as $v1) {
						$urlStuff[0][] = $i + 1;
					}
				}
				else {
					foreach ($v as $v1) {
						$urlStuff[$k][] = $v1;
					}
				}
			}
		}
	}
	
	//No match? Return data.
	if (!$match)
	   return $data;
	
	//Create toc.
	$toc = $config->tinytoc_settings_header->before;
	$toc .= $config->tinytoc_settings_header->title;
	$toc .= $config->tinytoc_settings_header->after;
	
	$toc .= $config->tinytoc_settings_tocstyle->startList;
	
	
	$count = count($urlStuff[1]);
	
	$lastLevel = 1;
	
	//Loop each match and create url for them.
    for ($i = 0; $i < $count; $i++) {
	    $lev = 1;
        $currLevel = (int) $urlStuff[1][$i];
        if ($currLevel > $lastLevel) {
		    $lev++;
            $toc .= $config->tinytoc_settings_tocstyle->startItem;
            $toc .= $config->tinytoc_settings_tocstyle->startList;
            $toc .= $config->tinytoc_settings_tocstyle->startItem;
            $toc .= $config->tinytoc_settings_general->useGoTo ? 
                createGoToUrl($urlStuff[0][$i], $currentPage, $urlStuff[1][$i],$urlStuff[2][$i]) : 
                $urlStuff[2][$i];
            $toc .= $config->tinytoc_settings_general->endItem;
        }
        elseif ($lastLevel > $currLevel) {
		    $lev--;
            $toc .= $config->tinytoc_settings_tocstyle->endList;
			$toc .= $config->tinytoc_settings_general->endItem;
            $toc .= $config->tinytoc_settings_tocstyle->startItem;
            $toc .= $config->tinytoc_settings_general->useGoTo ? 
                createGoToUrl($urlStuff[0][$i], $currentPage, $urlStuff[1][$i],$urlStuff[2][$i]) : 
                $urlStuff[2][$i];
            $toc .= $config->tinytoc_settings_tocstyle->endItem;
        }
        else {
            $toc .= $config->tinytoc_settings_tocstyle->startItem;
            $toc .= $config->tinytoc_settings_general->useGoTo ? 
                createGoToUrl($urlStuff[0][$i], $currentPage, $urlStuff[1][$i],$urlStuff[2][$i]) : 
                $urlStuff[2][$i];
            $toc .= $config->tinytoc_settings_tocstyle->endItem;
        }
        $lastLevel = $currLevel;
    }
    
    //Cleanup
	for ($i = 1; $i < $lev; $i++) {
	    $toc .= $config->tinytoc_settings_tocstyle->endList;
		$toc .= $config->tinytoc_settings_general->endItem;
	}
    
    $toc .= $config->tinytoc_settings_tocstyle->endList;
    
    return $toc . nl2br($allContent[$currentPage - 1]);
}

/**
 * Creates GoTo urls if needed.
 *
 * @param int $page Current page in loop
 * @param int $currPage Current page in URL
 * @param string $level Current level
 * @param string $title Current title
 * @return string Formated string
 */
function createGoToUrl($page, $currPage, $level, $title)
{
    global $post;
    
    //If enabled GoTo feature, this will create urls for them.
    $return = '<a href="';
    $return .= (($page !== $currPage) ? 
           (('' == get_option('permalink_structure') || 
               in_array($post->post_status, array('draft', 'pending'))
           ) ?  (get_permalink() . '&amp;page=' . $page) : 
           (trailingslashit(get_permalink()) . user_trailingslashit($page, 'single_paged'))) : '') 
       . '#' . str_replace(
            array(' ', '.'), 
            '-', 
            htmlentities($title)
        ) . '-' . $level . '">' . $title . '</a>';
        
    return $return;
}

/**
 * Function used for preg_replace_callback.
 *
 * @param array $matches PHP preg_replace_callback matches
 * @return string Formated string
 */
function callbackReplace($matches)
{
    //Get config
	$config = tinyConfig::getInstance()->get(array(
        'tinytoc_settings_general',
        'tinytoc_settings_backtotop'
    ));
    
    //Creates our replace.
    $replace = $config->tinytoc_settings_general->useGoTo 
        ? '<span id="' . str_replace(
            array(' ', '.'), 
            '-', 
            htmlentities($matches[2])
        ) . '-' . $matches[1] . '">' : '';
    $replace .= $matches[2];
    $replace .= $config->tinytoc_settings_general->useGoTo ? '</span>' : '';
    $replace .= $config->tinytoc_settings_general->useBackToTop ? (
        str_replace(
            '%image%', 
            $config->tinytoc_settings_backtotop->image, 
            $config->tinytoc_settings_backtotop->text
        )
    ) : '';
    
    return $replace;
}

/**
 * Function that we use to check if we need to parse this request.
 *
 * @return bool True if we need to parse it, otherwise false
 */
function checkIfWeNeedToParse()
{
	global $post;
	
	//Get parsing config.
	$config = tinyConfig::getInstance()->get('tinytoc_settings_parse');
	
	//Check if we have enabled settings that we need to parse this request.
	if (is_home() && !$config->tinytoc_settings_parse->parseHomePage)
	    return false;
	if (is_archive() && !$config->tinytoc_settings_parse->parseAnyArchive)
	    return false;
    if (is_date() && !$config->tinytoc_settings_parse->parseDateArchive)
         return false;
    if (is_category() && !$config->tinytoc_settings_parse->parseCategoryArchive)
         return false;
    if (is_search() && !$config->tinytoc_settings_parse->parseSearch)
         return false;
    if (is_feed() && !$config->tinytoc_settings_parse->parseFeed)
         return false;
    if ($post->post_type === 'post' && !$config->tinytoc_settings_parse->parsePost)
         return false;
    if ($post->post_type === 'page' && !$config->tinytoc_settings_parse->parsePage)
         return false;
    if (
         in_array($post->ID, $config->tinytoc_settings_parse->postExclude) || 
         in_array($post->ID, $config->tinytoc_settings_parse->pageExclude)
    )
         return false;

    //Yap, that's it. We need to parse it.
    return true;
}