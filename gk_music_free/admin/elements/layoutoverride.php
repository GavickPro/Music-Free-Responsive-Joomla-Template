<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldLayoutOverride extends JFormField
{
	public $type = 'LayoutOverride';

	protected function getInput() {
		$options = (array) $this->getOptions();
		$html = '';
		$html .= '<div id="layout_override_form">';
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_ITEMID_OPTION') . '</div>';
		$html .= '<input type="text" id="layout_override_input" />';
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_LAYOUT') . '</div>';
		$html .= JHtml::_('select.genericlist', $options, 'name', '', 'value', 'text', 'default', 'layout_override_select');
		$html .= '<input type="button" value="'.JText::_('TPL_GK_LANG_ADD_RULE').'" id="layout_override_add_btn" />';
		$html .= '<textarea name="'.$this->name.'" id="'.$this->id.'">' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '</textarea>';
		$html .= '<div id="layout_override_rules"></div>';
		$html .= '</div>';
		
		return $html;
	}

	protected function getOptions() {
		$options = array();
		$path = (string) $this->element['directory'];
		if (!is_dir($path)) $path = JPATH_ROOT.'/'.$path;
		$files = JFolder::files($path, '.php');

		if (is_array($files)) {
			foreach($files as $file) {
				$file = JFile::stripExt($file);
				$options[] = JHtml::_('select.option', $file, $file);
			}
		}

		return array_merge($options);
	}
}
