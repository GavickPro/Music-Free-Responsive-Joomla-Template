<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldMooToolsOverride extends JFormField
{
	public $type = 'MooToolsOverride';

	protected function getInput() {		
		$options = array(JHtml::_('select.option', JText::_('TPL_GK_LANG_ENABLED'), 'enabled'), JHtml::_('select.option', JText::_('TPL_GK_LANG_DISABLED'), 'disabled'));
		$html = '';
		$html .= '<div id="mootools_for_pages_form">';
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_ITEMID_OPTION') . '</div>';
		$html .= '<input type="text" id="mootools_for_pages_input" />';
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_STATE') . '</div>';
		$html .= JHtml::_('select.genericlist', $options, 'name', '', 'value', 'text', 'default', 'mootools_for_pages_select');
		$html .= '<input type="button" value="'.JText::_('TPL_GK_LANG_ADD_RULE').'" id="mootools_for_pages_add_btn" />';
		$html .= '<textarea name="'.$this->name.'" id="'.$this->id.'">' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '</textarea>';
		$html .= '<div id="mootools_for_pages_rules"></div>';
		$html .= '</div>';
		
		return $html;
	}
}
