<?php
/*
Plugin Name: Indic Language Comments
Plugin URI: http://www.readers-cafe.net/2009/06/21/indic-language-plugin-for-comments/
Description: Indic Language plugin for Comments, It enables Indic Languages for comment form, When Visitors will write comments in Roman script this plugin automatically converts text into default Indian Script selected using google transliteration API. Visitors can use Ctrl G key combination to toggle between english and selected Indian langueage.
Author: Tarun Joshi
Version: 0.7
Author URI: http://www.readers-cafe.net/
*/

/*  Copyright 2009-2010 Tarun Joshi (email: readerscafe@gmail.com)

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
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

function indicLangCommentCO() {
$lang='hi';  //default
$enabled=1;   //True
$showOpt=1;   //Yes
$chkAdvance=1;  //Yes
$multilang = 'hi'; //"['hi','kn','ml','ta','te','gu','mr','bn','pa','ur',ne','ar']";  //default
$sNote = 'Type Comments in Indian languages (Press Ctrl+g to toggle between English and Hindi OR just Click on the letter) ';

$lang = get_option('indicLanguage');
$enabled = get_option('indicEnabled');
$showOpt = get_option('indicControl');
$chkAdvance = get_option('indicAdvance');
$multilang = get_option('indicMultiLang');
$sNote = get_option('indicNote');

?>

<script type="text/javascript" src="http://www.google.com/jsapi">    
</script>    
<script type="text/javascript">      
         // Load the Google Transliteration API      
         google.load("elements", "1", {            
              packages: "transliteration"          
          });

	  var lang= decodeURIComponent("<?php echo rawurlencode($lang); ?>");
	  var e= <?php echo $enabled; ?>;

      function onLoad() {
        var options = {
          sourceLanguage: 'en',            
          destinationLanguage: <?php if ($chkAdvance==1) { echo "['hi','kn','ml','ta','te','gu','mr','bn','pa','ur','ne','ar'],"; } else {?> lang, <?php } ?>    //'hi','kn','ml','ta','te'
          shortcutKey: 'ctrl+g',   
          transliterationEnabled: e
        };
 
        var control =
            new google.elements.transliteration.TransliterationControl(options);

        var textArea=document.getElementsByTagName("textarea")[0].id;
        var ids = [textArea];
        control.makeTransliteratable(ids);
        <?php if ($showOpt==1) { ?> control.showControl('translControl');  <?php }?>
        
      }
      google.setOnLoadCallback(onLoad);

</script>

<?php

//show_text_cf($sNote);
}

/* This is the code that is inserted into the comment form */
function show_text_cf ($showNote) {
	global $sg_subscribe;
         echo $showNote;

}

function indicLangCommentMenu() {
  add_submenu_page('options-general.php', 'Indic Language Comments', 'Indic Language Comments', 8, 'IndicLangComment', 'indicLangCommentOpt');

}

function indicLangCommentOpt() {
if( $_POST['action' ] == 'update' ) {
 update_option( 'indicLanguage', $_POST['indicLanguage'] );
 update_option( 'indicEnabled', $_POST['indicEnabled'] );
 update_option( 'indicControl', $_POST['indicControl'] );
 update_option( 'indicAdvance', $_POST['indicAdvance'] );
 update_option( 'indicMultiLang', $_POST['indicMultiLang'] );
 update_option( 'indicNote', $_POST['indicNote'] );

}
$lang = get_option('indicLanguage');
$enabled = get_option('indicEnabled');
$showOpt = get_option('indicControl');
$chkAdvance = get_option('indicAdvance');
$multilang = get_option('indicMultiLang');
$sNote = get_option('indicNote');
?>

<div class="wrap">
<h2>Indic Language Comments</h2>

<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<?php wp_nonce_field('update-options'); ?>

<table class="form-table">

<tr valign="top">
<td><b>Indic Transliteration Enabled</b></td>
<td><select name="indicEnabled" >
<option value="1" <?php if ($enabled==1) echo "selected";?>>True</option> 
<option value="0" <?php if ($enabled==0) echo "selected";?>>False</option> 
</select></td>
 <td> 
<b>'True'</b><i> means Comments will be in Indian language, To toggle back to english User has to press <b>ctrl+g</b> </i><br>
<b>'False'</b><i> means Comments will be in English, To toggle to Indic Language User has to press <b>ctrl+g</b></i> <br>
</td></tr>

<tr valign="top">
<td><b>Show Indic Transliteration Options Control (for Your Reader to Select)</b></td>
<td><select name="indicControl" >
<option value="1" <?php if ($showOpt==1) echo "selected";?>>Yes</option> 
<option value="0" <?php if ($showOpt==0) echo "selected";?>>No</option> 
</select></td>
 <td>
<b>NOTE:</b> if You select YES then You need to copy following code and paste where you want to display Indic Language options (<i>Depending on your wordpress theme, most of the time it will be on your Comment Template file e.g. comment.php OR Legacy comment file.</i>)<br> 
<code><textarea name = "indicNote" style="width:600px;height:50px"><span id='translControl'></span>&nbsp; Type Comments in Indian languages (Press Ctrl+g to toggle between English and Hindi OR just Click on the letter) </textarea></code>
</td>
</tr>

<tr valign="top">
<td width="200px"><b>Set default Indic Language</b></td>
<td><select name="indicLanguage" >
<option value="hi" <?php if ($lang=="hi") echo "selected";?>>Hindi (hi) </option> 
<option value="ta" <?php if ($lang=="ta") echo "selected";?>>Tamil (ta) </option> 
<option value="te" <?php if ($lang=="te") echo "selected";?>>Telugu (te)</option> 
<option value="kn" <?php if ($lang=="kn") echo "selected";?>>kannad (kn)</option> 
<option value="ml" <?php if ($lang=="ml") echo "selected";?>>Malyalam (ml)</option> 
<option value="gu" <?php if ($lang=="gu") echo "selected";?>>Gujarati (gu)</option> 
<option value="mr" <?php if ($lang=="mr") echo "selected";?>>Marathi (mr)</option> 
<option value="bn" <?php if ($lang=="bn") echo "selected";?>>Bengali (bn)</option> 
<option value="pa" <?php if ($lang=="pa") echo "selected";?>>Punjabi (pa)</option> 
<option value="ur" <?php if ($lang=="ur") echo "selected";?>>Urdu (ur)</option> 
<option value="ne" <?php if ($lang=="ne") echo "selected";?>>Nepali (ne)</option> 
<option value="ar" <?php if ($lang=="ar") echo "selected";?>>Arabic (ar)</option> 
</select></td>
<td>
<i>Select the indic script in which you want the transliteration to work.</i>
</td></tr>

<tr valign="top">
<td><b>Advance Use</b></td>
<td><select name="indicAdvance" >
<option value="1" <?php if ($chkAdvance==1) echo "selected";?>>Yes</option> 
<option value="0" <?php if ($chkAdvance==0) echo "selected";?>>No</option> 
</select></td>
 <td>
<b>NOTE:</b> if You select YES then it will overwrite <b>default Indic Language</b> option selected in above drop down. Using Advance Use, you can give more language choices to Reader to select from. <del>For this You should know the language code used by Google and it must be supported by API e.g. 'hi' is code for Hindi (See <a href="http://code.google.com/apis/ajaxlanguage/documentation/#TransliterationSupportedLanguages" target="_blank">supported language here</a>). <i>if  anything goes wrong then just copy and paste this to box below - ['hi','kn','ml','ta','te']</i>.</del> First language will be default, in this case 'hi' i.e. hindi. <b>This advance use is useful if you select YES to "Show Indic Transliteration Options Control".</b> <br> 
<code><input type='textbox' name="indicMultiLang" value="['hi','kn','ml','ta','te','gu','mr','bn','pa','ur',ne','ar']" /></code> <br>

</td>
</tr>
<tr><td colspan=3>
<b>NOTE:</b> <i>Indic thing get enabled for Textarea Type controls used in Comment Form.</i>
</td>
</table>

<input type="hidden" name="action" value="update" />

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>


<?php
}

add_action('comment_form',  'indicLangCommentCO',5);
add_action('admin_menu', 'indicLangCommentMenu');
?>