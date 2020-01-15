<?php
/**
 * @copyright	Copyright © 2018 - All rights reserved Crock.
 * @license		GNU General Public License v2.0
 * April 2018
 */
defined('_JEXEC') or die;

include_once __DIR__ . '/helper.php';

$doc = JFactory::getDocument();
// Include assets
$doc->addStyleSheet(JURI::root()."modules/mod_tags_search/assets/css/style.css");
$doc->addScript(JURI::root()."modules/mod_tags_search/assets/js/script.js");
// $width 			= $params->get("width");
$jqury = $params->get('query') ;
//if ($jqury == 1) $doc->addScript("https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js");
$characters = $params->get('characters') ;

$js = "
jQuery(document).ready(function () {
	var characters = '".$characters."';
	var el = jQuery('#tags_search_results');
	jQuery('#tags_search').keyup(function(e) {
	if (this.value && this.value.length >= characters ){

    
        var value   = jQuery('input[name=data]').val(),
            request = {
                    'option' : 'com_ajax',
                    'module' : 'tags_search',
                    'data'   : value,
                    'format' : 'raw'
                };
        jQuery.ajax({
            type   : 'POST',
            data   : request,
            success: function(json){
				
			el.empty(); 
			el.html(json);
			}
			});  
       			return false;
		} else { el.empty(); }
		});
   
});
";

$doc->addScriptDeclaration($js);
require JModuleHelper::getLayoutPath('mod_tags_search', $params->get('layout', 'default'));