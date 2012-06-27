<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldSuffixOverride extends JFormField
{
	public $type = 'SuffixOverride';

	protected function getInput() {
		$html = '';	
		$html .= '<div id="suffix_override_form">';
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_ITEMID_OPTION') . '</div>';
		$html .= '<input type="text" id="suffix_override_input" />';
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_SUFFIX') . '</div>';
		$html .= '<input type="text" id="suffix_override_select" />';
		$html .= '<input type="button" value="'.JText::_('TPL_GK_LANG_ADD_RULE').'" id="suffix_override_add_btn" />';
		$html .= '<textarea name="'.$this->name.'" id="'.$this->id.'">' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '</textarea>';
		$html .= '<div id="suffix_override_rules"></div>';
		$html .= '</div>';
		
		return $html;
	}
}
