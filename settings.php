<?php
/**
 * @author Marijan Šuflaj <msufflaj32@gmail.com>
 * @link http://www.php4every1.com
 */

//Disable direct view.
if (!defined('IN_PLUGIN'))
    die('You can not access this file directly.');
?>
<script type="text/javascript">
<!--
function incDecLevelNum(inc)
{
    var current = jQuery('input[name=maxLevelNum]').val() * 1;
    if (current > 1 || inc === true) {
	    var next = (inc === true) ? (current + 1) : (current - 1);
	    jQuery('input[name=maxLevelNum]').val(next);
	    jQuery('#maxLevelNum').text(next);
	}
}
//-->
</script>
<div class="wrap">
    <h3>Plugin settings</h3>
    
    <?php
    if (isset($_POST['update']))
        require_once 'updateSettings.php';
        
    if (isset($_POST['default']))
        require_once 'resetSettings.php';
        
    $config = tinyConfig::getInstance()->get('');
    ?>
    
    <form method="post">
	    <h4>General</h4>
	    <table class="widefat" style="width: 500px">
	        <thead>
	            <tr>
	                <th width="50%">
	                    Option
	                </th>
	                <th>
	                    Value
	                </th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr>
	                <td>
	                    Enabled:
	                </td>
	                <td>
	                    <input type="checkbox" name="tinytocEnabled" <?php checked('1', $config->tinytoc_settings_enabled); ?> />
	                </td>
	            </tr>
	            <tr class="alternate">
	                <td>
	                    Maximum level number:
	                </td>
	                <td>
	                    <input type="hidden" name="maxLevelNum" value="<?php echo $config->tinytoc_settings_general->maxLevelNum; ?>" />
	                    <div id="maxLevelNum" style="display: inline;">
                            <?php echo $config->tinytoc_settings_general->maxLevelNum; ?>
                        </div>
                        <a onclick="incDecLevelNum(true)" href="#">+</a>/<a onclick="incDecLevelNum(false)" href="#">-</a>
	                </td>
	            </tr>
	            <tr>
	                <td>
	                    Use "Back to top" button:
	                </td>
	                <td>
	                    <input type="checkbox" name="useBackToTop" <?php checked('1', $config->tinytoc_settings_general->useBackToTop); ?> />
	                </td>
	            </tr>
	            <tr class="alternate">
	                <td>
	                    Priority:
	                </td>
	                <td>
	                    <input type="text" style="width: 30px;" name="priority" value="<?php echo $config->tinytoc_settings_general->priority; ?>" />
	                </td>
	            </tr>
	            <tr>
	                <td>
	                    Use "Go to" feature:
	                </td>
	                <td>
	                    <input type="checkbox" name="useGoTo" <?php checked('1', $config->tinytoc_settings_general->useGoTo); ?> />
	                </td>
	            </tr>
                <tr>
                    <td>
                        Remove when not used:
                    </td>
                    <td>
                        <input type="checkbox" name="removeWhenNotUsed" <?php checked('1', $config->tinytoc_settings_general->removeWhenNotUsed); ?> />
                    </td>
                </tr>
                <tr>
                    <td>
                        TOC on all pages:
                    </td>
                    <td>
                        <input type="checkbox" name="tocOnAllPages" <?php checked('1', $config->tinytoc_settings_general->tocOnAllPages); ?> />
                    </td>
                </tr>
	        </tbody>
	    </table>
	    
	    <h4>Header</h4>
	    <table class="widefat" style="width: 500px">
	        <thead>
	            <tr>
	                <th width="50%">
	                    Option
	                </th>
	                <th>
	                    Value
	                </th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr>
	                <td>
	                    Title:
	                </td>
	                <td>
	                     <input type="text" name="headerTitle" value="<?php echo $config->tinytoc_settings_header->title; ?>" />
	                </td>
	            </tr>
	            <tr class="alternate">
	                <td>
	                    Html before title:
	                </td>
	                <td>
	                    <textarea name="headerBefore" cols="27" rows="3" ><?php echo htmlentities($config->tinytoc_settings_header->before); ?></textarea>
	                </td>
	            </tr>
	            <tr>
	                <td>
	                    Html after title:
	                </td>
	                <td>
	                    <textarea name="headerAfter" cols="27" rows="3" ><?php echo htmlentities($config->tinytoc_settings_header->after); ?></textarea>
	                </td>
	            </tr>
	            <tr class="alternate">
	                <td>
	                    Header css style:
	                </td>
	                <td>
	                    <textarea name="headerCss" cols="27" rows="3" ><?php echo htmlentities($config->tinytoc_settings_header->css); ?></textarea>
	                </td>
	            </tr>
	        </tbody>
	    </table>
	    
	    <h4>Back to top</h4>
	    <table class="widefat" style="width: 500px">
	        <thead>
	            <tr>
	                <th width="50%">
	                    Option
	                </th>
	                <th>
	                    Value
	                </th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr>
	                <td>
	                    Image:
	                </td>
	                <td>
	                    <textarea name="backToTopImage" cols="27" rows="3" ><?php echo $config->tinytoc_settings_backtotop->image; ?></textarea>
	                </td>
	            </tr>
	            <tr class="alternate">
	                <td>
	                    Text:
	                </td>
	                <td>
	                    <textarea name="backToTopText" cols="27" rows="3" ><?php echo htmlentities($config->tinytoc_settings_backtotop->text); ?></textarea>
	                </td>
	            </tr>
	            <tr>
	                <td>
	                    Css:
	                </td>
	                <td>
	                    <textarea name="backToTopCss" cols="27" rows="3" ><?php echo htmlentities($config->tinytoc_settings_backtotop->css); ?></textarea>
	                </td>
	            </tr>
	        </tbody>
	    </table>
	    
	    <h4>Table of contents style</h4>
	    <h5>Presets</h5>
	    
	    <table class="widefat" style="width: 500px">
	        <thead>
	            <tr>
	                <th width="50%">
	                    Option
	                </th>
	                <th>
	                    Value
	                </th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr>
	                <td>
	                    Start list:
	                </td>
	                <td>
	                    <textarea name="tocStartList" cols="27" rows="3" ><?php echo htmlentities($config->tinytoc_settings_tocstyle->startList); ?></textarea>
	                </td>
	            </tr>
	            <tr class="alternate">
	                <td>
	                    End list:
	                </td>
	                <td>
	                    <textarea name="tocEndList" cols="27" rows="3" ><?php echo htmlentities($config->tinytoc_settings_tocstyle->endList); ?></textarea>
	                </td>
	            </tr>
	            <tr>
	                <td>
	                    Start list item:
	                </td>
	                <td>
	                    <textarea name="tocStartItem" cols="27" rows="3" ><?php echo htmlentities($config->tinytoc_settings_tocstyle->startItem); ?></textarea>
	                </td>
	            </tr>
	            <tr class="alternate">
	                <td>
	                    End list item:
	                </td>
	                <td>
	                    <textarea name="tocEndItem" cols="27" rows="3" ><?php echo htmlentities($config->tinytoc_settings_tocstyle->endItem); ?></textarea>
	                </td>
	            </tr>
	            <tr>
	                <td>
	                    Css:
	                </td>
	                <td>
	                    <textarea name="tocCss" cols="27" rows="3" ><?php echo htmlentities($config->tinytoc_settings_tocstyle->css); ?></textarea>
	                </td>
	            </tr>
	        </tbody>
	    </table>
	    
	    <h4>Display on</h4>
	    <table class="widefat" style="width: 500px">
	        <thead>
	            <tr>
	                <th width="50%">
	                    Option
	                </th>
	                <th>
	                    Value
	                </th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr>
	                <td>
	                    Post:
	                </td>
	                <td>
	                    <input type="checkbox" name="parsePost" <?php checked('1', $config->tinytoc_settings_parse->parsePost); ?> />
	                </td>
	            </tr>
	            <tr class="alternate">
	                <td>
	                    Page:
	                </td>
	                <td>
	                    <input type="checkbox" name="parsePage" <?php checked('1', $config->tinytoc_settings_parse->parsePage); ?> />
	                </td>
	            </tr>
	            <tr>
	                <td>
	                    Home page:
	                </td>
	                <td>
	                    <input type="checkbox" name="parseHomePage" <?php checked('1', $config->tinytoc_settings_parse->parseHomePage); ?> />
	                </td>
	            </tr>
	            <tr class="alternate">
	                <td>
	                    Search:
	                </td>
	                <td>
	                    <input type="checkbox" name="parseSearch" <?php checked('1', $config->tinytoc_settings_parse->parseSearch); ?> />
	                </td>
	            </tr>
	            <tr>
	                <td>
	                    Feed:
	                </td>
	                <td>
	                    <input type="checkbox" name="parseFeed" <?php checked('1', $config->tinytoc_settings_parse->parseFeed); ?> />
	                </td>
	            </tr>
	            <tr class="alternate">
	                <td>
	                    Category archive:
	                </td>
	                <td>
	                    <input type="checkbox" name="parseCategory" <?php checked('1', $config->tinytoc_settings_parse->parseCategoryArchive); ?> />
	                </td>
	            </tr>
	            <tr>
	                <td>
	                    Date archive:
	                </td>
	                <td>
	                    <input type="checkbox" name="parseDate" <?php checked('1', $config->tinytoc_settings_parse->parseDateArchive); ?> />
	                </td>
	            </tr>
	            <tr class="alternate">
	                <td>
	                    Any archive:
	                </td>
	                <td>
	                    <input type="checkbox" name="parseAnyArchive" <?php checked('1', $config->tinytoc_settings_parse->parseAnyArchive); ?> />
	                </td>
	            </tr>
	            <tr>
	                <td>
	                    Exclude pages:
	                </td>
	                <td>
	                    <select multiple="multiple" name="excludePages[]" size="5" style="width: 250px; height: 70px;">
		                    <?php
		                    $pages = get_pages('');
		                    foreach ($pages as $page) {
		                    ?>
	                        <option value="<?php echo $page->ID; ?>" <?php echo (in_array($page->ID, $config->tinytoc_settings_parse->pageExclude)) ? 'selected="selected"' : ''; ?>><?php echo $page->post_title ?></option>
		                    <?php    
		                    }
		                    ?>
	                    </select>
	                </td>
	            </tr>
	            <tr class="alternate">
	                <td>
	                    Exclude posts:
	                </td>
	                <td>
	                    <select multiple="multiple" name="excludePosts[]" size="5" style="width: 250px; height: 70px;">
                            <?php
                            $posts = get_posts('numberposts=-1&orderby=title');
                            foreach ($posts as $post) {
                            ?>
                            <option value="<?php echo $post->ID; ?>" <?php echo (in_array($post->ID, $config->tinytoc_settings_parse->postExclude)) ? 'selected="selected"' : ''; ?>><?php echo $post->post_title ?></option>
                            <?php    
                            }
                            ?>
                        </select>
	                </td>
	            </tr>
	        </tbody>
	    </table>
	    <p class="submit">
	        <input type="submit" name="update" value="Update" />
	        <input type="reset" value="Reset">
            <input type="submit" name="default" value="Default" />
	    </p>
	    <p>
	       <small>
	           <i>
	               Reset button will reset form to its current settings, but Default button will reset settings to default and update them.
	           </i>
	       </small>
	    </p>
    </form>
</div>