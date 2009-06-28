=== Tiny Table Of Contents - TinyTOC ===
Contributors: zlikavac32
Tags: content, table, tiny, tinytoc, toc, bookmark, simple, easy
Requires at least: 2.0.2
Tested up to: 2.7
Stable tag: 0.7

Plugin that enables you to create table of contents in your posts and pages. It's very simple to use from your editor.

== Description ==

Plugin that enables you to create table of contents in your posts and pages. You can choose what it will parse, and what
it will not parse. It's very simple to use from your editor
so you do not have to manualy enter tags. Now it's nothing special, but later it will have much more features including
some predefined styles and more styling control.

== Changelog ==

= Ver 0.7 (released 2009-06-27) =
-------------------------------------------------------------------
* Fixed problem when parsing home page (<!--more--> tag)
* Fixed some small parsing bugs
* Optimized script
* Fixed creating of TOC problem (nested loops problem)
* Fixed chapter parsing in TOC (now all styling is removed)
* Added "Remove when not used" feature
* Added "TOC on all pages" feature

= Ver 0.3 (released 2009-05-21) =
-------------------------------------------------------------------
* Plugin first version

First version of the plugin.

== Installation ==

1. Upload folder `tiny-table-of-contents-tinytoc` to your `/wp-content/plugins` directory
2. Activate the plugin through the `Plugins` menu in WordPress

== Frequently Asked Questions ==

= Now do I use this plugin? =
When you go to your post editor you will see drop down menu "TOC Levels". Select you chapter and then chose one of the levels. Or you can manualy wrap your chapter in [tinytoc level="ln"]cont[/tinytoc] tags where `ln` is your level (number) and `cont` is you chapter.

= How to use image as "Back to top" button? =
You can add image values to image field and in text create place holder by placing `%image%` or you cand add `<img />` tag to your text.

= Can I add text before TOC? =
Currently you can not, but it will be avilable in next version.

= Can I chose TOC position? =
No, you can not, but it will also be avilable in next version.

= How do you know what each of these fields mean? =
Go to [english documentation](http://php4every1.com/scripts/tiny-table-of-contents-wordpress-plugin/#Documentation-1) or [Croatian documentation](http://hr.php4every1.com/skripte/tiny-table-of-contents-wordpress-plugin/#Dokumentacija-1).

== Screenshots ==

1. Part of `Plugin summary` page
2. An other part of `Plugin summary` page
3. Part of `Plugin settings` page
4. An other part of `Plugin settings` page
5. Also a part of `Plugin settings` page


== Planned Features ==

* Custom TOC position
* Custom text before TOC
* Custom styling for each level
* Custom TOC tag (so you dont have to use `[tinytoc lev="lv"]cont[/tinytoc]`)

== Source SVN ==

* svn checkout http://svn.wp-plugins.org/tiny-table-of-contents-tinytoc/trunk/ tiny-table-of-contents-tinytoc

== Support ==

* Twitter: http://www.twitter.com/php4every1
* Facebook: http://www.new.facebook.com/profile.php?id=1296304925&ref=mf
* Plugin home: http://php4every1.com/scripts/tiny-table-of-contents-wordpress-plugin/
* Documentation: http://php4every1.com/scripts/tiny-table-of-contents-wordpress-plugin/#Documentation-1