<?php
/**
 * @copyright	Copyright © 2018 - All rights reserved Crock.
 * @license		GNU General Public License v2.0
 * April 2018
 */
defined('_JEXEC') or die;

class modTagsSearchHelper
{
    public static function getAjax()
    {
       JLoader::register('TagsHelperRoute', JPATH_BASE .'/components/com_tags/helpers/route.php');
	

        $input = JFactory::getApplication()->input;
        $data  = $input->get('data', '', 'string');

        // Connect to database
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);


        // Build the query
        $query
            ->select($db->quoteName(array('title','id','alias')))
            ->from($db->quoteName('#__tags'))
            ->where($db->quoteName('title') . ' LIKE '. $db->quote('%' . $data . '%')
                . ' AND ' . $db->quoteName('published') . ' = 1');
          //  ->order('ordering ASC');


        $db->setQuery($query);
        $tags = $db->loadObjectList();


        // Get output
        $output = '';

        foreach($tags as $tag){
            $output .= '<div><a href ="'.JRoute::_(TagsHelperRoute::getTagRoute($tag->id .':' . $tag->alias)).'">#'.$tag->title. '</a></div>';
			
        }

        if($output == null or empty($data))
        {
            $output = 'Нет данных для отображения.';
        }


        return $output;
    }
}