<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldModuleOverride extends JFormField
{
	public $type = 'ModuleOverride';

	protected function getInput() {
		$module_positions = explode(',', $this->element['module_positions']);
		$module_styles = explode(',', $this->element['module_styles']);
		$options_mp = array();
		$options_ms = array();
	
		foreach($module_positions as $pos) {
			$options_mp[] = JHtml::_('select.option', $pos, $pos);
		}
		
		foreach($module_styles as $style) {
			$options_ms[] = JHtml::_('select.option', $style, $style);
		}
	
		$html = '';
		$html .= '<div id="module_override_form">';
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_MOD_POS') . '</div>';
		$html .= JHtml::_('select.genericlist', $options_mp, 'name', '', 'value', 'text', 'default', 'module_override_input');
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_STYLE') . '</div>';
		$html .= JHtml::_('select.genericlist', $options_ms, 'name', '', 'value', 'text', 'default', 'module_override_select');
		$html .= '<input type="button" value="'.JText::_('TPL_GK_LANG_ADD_RULE').'" id="module_override_add_btn" />';
		$html .= '<textarea name="'.$this->name.'" id="'.$this->id.'">' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '</textarea>';
		$html .= '<div id="module_override_rules"></div>';
		$html .= '</div>';
		
		return $html;
	}
}