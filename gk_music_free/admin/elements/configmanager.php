<?php

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldConfigManager extends JFormField {
	protected $type = 'ConfigManager';

	protected function getInput() {
		jimport('joomla.filesystem.file');
		// necessary Joomla! classes
		$uri = JURI::getInstance();
		$db = JFactory::getDBO();
		// variables from URL
		$tpl_id = $uri->getVar('id', 'none');
		$task = $uri->getVar('gk_template_task', 'none');
		$file = $uri->getVar('gk_template_file', 'none');
		$base_path = str_replace('admin/elements', '', dirname(__FILE__)).'config/';
		// helping variables
		$redirectUrl = $uri->root() . 'administrator/index.php?option=com_templates&view=style&layout=edit&id=' . $tpl_id;
		// if the URL contains proper variables
		if($tpl_id !== 'none' && is_numeric($tpl_id) && $task !== 'none') {
			if($task == 'load') {
				if(JFile::exists($base_path . $file)) {
					//
					$query = '
						UPDATE 
							#__template_styles
						SET	
							params = '.$db->quote(file_get_contents($base_path . $file)).'
						WHERE 
						 	id = '.$tpl_id.'
						LIMIT 1
						';	
					// Executing SQL Query
					$db->setQuery($query);
					$result = $db->query();
					// check the result
					if($result) {
						// make an redirect
						$app = JFactory::getApplication();
						$app->redirect($redirectUrl, JText::_('TPL_GK_LANG_CONFIG_LOADED_AND_SAVED'), 'message');
					} else {
						// make an redirect
						$app = JFactory::getApplication();
						$app->redirect($redirectUrl, JText::_('TPL_GK_LANG_CONFIG_SQL_ERROR'), 'error');
					}
				} else {
					// make an redirect
					$app = JFactory::getApplication();
					$app->redirect($redirectUrl, JText::_('TPL_GK_LANG_CONFIG_SELECTED_FILE_DOESNT_EXIST'), 'error');
				}	
			} else if($task == 'save') {
				if($file == '') {
					$file = date('d_m_Y_h_s');
				}
				// variable used to detect if the specified file exists
				$i = 0;
				// check if the file to save doesn't exist
				if(JFile::exists($base_path . $file . '.json')) {
					// find the proper name for the file by incrementing
					$i = 1;
					while(JFile::exists($base_path . $file . $i . '.json')) { $i++; }
				}	
				// get the settings from the database
				$query = '
					SELECT
						params AS params
					FROM 
						#__template_styles
					WHERE 
					 	id = '.$tpl_id.'
					LIMIT 1
					';	
				// Executing SQL Query
				$db->setQuery($query);
				$row = $db->loadObject();
				// write it
				if(JFile::write($base_path . $file . (($i != 0) ? $i : '') . '.json' , $row->params)) {
					// make an redirect
					$app = JFactory::getApplication();
					$app->redirect($redirectUrl, JText::_('TPL_GK_LANG_CONFIG_FILE_SAVED_AS'). ' '. $file . (($i == 0) ? '' : $i) .'.json', 'message');
				} else {
					// make an redirect
					$app = JFactory::getApplication();
					$app->redirect($redirectUrl, JText::_('TPL_GK_LANG_CONFIG_FILE_WASNT_SAVED_PLEASE_CHECK_PERM'), 'error');
				}
			}
		}
		// generate the select list
		$options = (array) $this->getOptions();
		$file_select = JHtml::_('select.genericlist', $options, 'name', '', 'value', 'text', 'default', 'config_manager_load_filename');
		// return the standard formfield output
		$html = '';
		$html .= '<div id="config_manager_form">';
		$html .= '<div><label>'.JText::_('TPL_GK_LANG_CONFIG_LOAD').'</label>'.$file_select.'<button id="config_manager_load">'.JText::_('TPL_GK_LANG_CONFIG_LOAD_BTN').'</button></div>';
		$html .= '<div><label>'.JText::_('TPL_GK_LANG_CONFIG_SAVE').'</label><input type="text" id="config_manager_save_filename" /><span>.json</span><button id="config_manager_save">'.JText::_('TPL_GK_LANG_CONFIG_SAVE_BTN').'</button></div>';
		$html .= '</div>';
		// finish the output
		return $html;
	}

	protected function getOptions() {
		$options = array();
		$path = (string) $this->element['directory'];
		if (!is_dir($path)) $path = JPATH_ROOT.'/'.$path;
		$files = JFolder::files($path, '.json');

		if (is_array($files)) {
			foreach($files as $file) {
				$options[] = JHtml::_('select.option', $file, $file);
			}
		}

		return array_merge($options);
	}
}

/* EOF */