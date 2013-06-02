=== Flashcard Plugin for WordPress ===
Contributors: LiangShao
Tags: flashcard,flash,card,flip,animation,language,learn,memorization
Donate link: http://www.myapps4ipad.com
Requires at least: 3.2.1
Tested up to: 3.2.1
Stable tag: trunk

Flashcard is a WordPress plugin that enables your website to display animated flashcards to help language learning.

== Description ==

With its 3D rotation animation handled by <a href="http://www.zachstronaut.com/projects/rotate3di/#demos">rotate3Di - Zachary Johnson's jQuery plugin</a>, Flashcard is a WordPress plugin that allows you to configure and display a series of animated flashcards on your website. The data is loaded from a tab-deliminated UTF-8 text file saved in the media library. See the demo on <a href="http://www.myapps4ipad.com/flashcard-wp-plugin">Liang Shao's Flashcard Plugin website</a>. Just mouse over the flashcards to make them flip over and reveal the content on their reverse sides.

== Installation ==

This plugin follows the [standard WordPress installation method][]:

1. Upload the 'flashcard.zip' file to the '/wp-content/plugins/' directory using wget, curl of ftp.
2. 'unzip' the 'flashcard.zip' which will create the folder to the directory '/wp-content/plugins/flashcard' 
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure the plugin through 'Flashcard' submenu in the the 'Settings' section of the Wordpress admin menu
5. Modify the fields to choice and save.

[standard WordPress installation method]: http://codex.wordpress.org/Managing_Plugins#Installing_Plugins

== Frequently Asked Questions ==

= How can I create the tab-deliminated UTF-8 text file? =

This is an <a href="http://www.myapps4ipad.com/wp-content/uploads/2011/11/chinese.txt">example</a>. By default, the first column contains the contents to display on the front side of flashcard, and the second column is for the back side. You can create it from a text editing application such as EditPlus or generate it from Microsoft Excel spreadsheet. 

* If you create it from EditPlus, you can directly save the file as UTF-8.
* If you create it from Excel and your data contains multi-byte characters, save it as Unicode Text first. Then convert it to UTF-8 text in EditPlus. The convertion is not needed if your data does not contain multi-byte characters.

= How can I display Flashcard on my website? =

* After uploading your UTF-8 text file to media library, use shortcode [flashcard source="..."] insert to any page or posts.
* Replace the source with the URL to your UTF-8 text file. For example, [flashcard source="http://www.myapps4ipad.com/wp-content/uploads/2011/11/thai.txt"]
* This is another example of using the shortcode: [flashcard source="http://www.myapps4ipad.com/wp-content/uploads/2011/11/thai.txt" order="random" max=10 show="back"]
* The source is the only required parameter for the shortcode, everything else is optional. By default, the order will be the same as in text file, all records will be displayed, and content in the first row will be shown on the front side of the card.

    * source: the location of tab-deliminated UTF-8 file
    * order: the display order of the flashcards. Can use “random” or “reverse“, otherwise the flashcards will be displayed in its creation order in text file.
    * max: the maximum number of cards to be displayed if the total number of records exceeds this number.
    * show: if specified as “back“, content in the second row in text file will be shown on the front side of the card.

= How come all my multi-byte characters display as gibberish? =

Flashcard plugin requires the data file in UTF-8 format. If your text file displays multibyte characters properly but not doing so in Flashcards, your file is probably saved in Unicode format. Microsoft Excel can only export multibyte characters in Unicode, so afterwards you need to use a text editing application like EditPlus to convert the file from Unicode to UTF-8 then re-upload to media library.

= What can be customized? =

Width and height of flashcards in pixels, the background color, text color, text size of the front and back side of the flashcards.

== Screenshots ==

1. Screenshot of the Flashcard web page
2. Screenshot of Flashcard settings

== Changelog ==

= 0.1 =
Created the plugin.

== Upgrade Notice ==

= 0.1 =
Upgrade to get the Flashcard plugin!