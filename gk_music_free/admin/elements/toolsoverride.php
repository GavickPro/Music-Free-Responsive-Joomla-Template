<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldToolsOverride extends JFormField
{
	public $type = 'ToolsOverride';

	protected function getInput() {		
		$options = array(JHtml::_('select.option', JText::_('TPL_GK_LANG_ENABLED'), 'enabled'), JHtml::_('select.option', JText::_('TPL_GK_LANG_DISABLED'), 'disabled'));
		$html = '';
		$html .= '<div id="tools_for_pages_form">';
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_ITEMID_OPTION') . '</div>';
		$html .= '<input type="text" id="tools_for_pages_input" />';
		$html .= '<input type="button" value="'.JText::_('TPL_GK_LANG_ADD_RULE').'" id="tools_for_pages_add_btn" />';
		$html .= '<textarea name="'.$this->name.'" id="'.$this->id.'">' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '</textarea>';
		$html .= '<div id="tools_for_pages_rules"></div>';
		$html .= '</div>';
		
		return $html;
	}
}
