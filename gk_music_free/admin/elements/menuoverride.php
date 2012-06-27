<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldMenuOverride extends JFormField
{
	public $type = 'MenuOverride';

	protected function getInput() {
		$options = array(JHtml::_('select.option', 'gk_menu', 'GK Extra Menu'), JHtml::_('select.option', 'gk_dropline', 'GK Dropline Menu'), JHtml::_('select.option', 'gk_split', 'GK Split Menu'));
			
		$html = '';		
		$html .= '<div id="menu_override_form">';
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_ITEMID_OPTION') . '</div>';
		$html .= '<input type="text" id="menu_override_input" />';
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_MENU_TYPE') . '</div>';
		$html .= JHtml::_('select.genericlist', $options, 'name', '', 'value', 'text', 'default', 'menu_override_select');
		$html .= '<input type="button" value="'.JText::_('TPL_GK_LANG_ADD_RULE').'" id="menu_override_add_btn" />';
		$html .= '<textarea name="'.$this->name.'" id="'.$this->id.'">' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '</textarea>';
		$html .= '<div id="menu_override_rules"></div>';
		$html .= '</div>';
		
		return $html;
	}
}
