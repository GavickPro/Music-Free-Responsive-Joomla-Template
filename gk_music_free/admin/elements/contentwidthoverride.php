<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldContentWidthOverride extends JFormField
{
	public $type = 'ContentWidthOverride';

	protected function getInput() {		
		$options = array(
			JHtml::_('select.option', '1', '1'), 
			JHtml::_('select.option', '1.5', '1.5'),
			JHtml::_('select.option', '2', '2'), 
			JHtml::_('select.option', '2.5', '2.5'),
			JHtml::_('select.option', '3', '3'), 
			JHtml::_('select.option', '3.5', '3.5'),	
			JHtml::_('select.option', '4', '4'), 
			JHtml::_('select.option', '4.5', '4.5'),
			JHtml::_('select.option', '5', '5'), 
			JHtml::_('select.option', '5.5', '5.5'),
			JHtml::_('select.option', '6', '6'), 
			JHtml::_('select.option', '6.5', '6.5'),
			JHtml::_('select.option', '7', '7'), 
			JHtml::_('select.option', '7.5', '7.5'),
			JHtml::_('select.option', '8', '8'), 
			JHtml::_('select.option', '8.5', '8.5'),		
			JHtml::_('select.option', '9', '9'), 
			JHtml::_('select.option', '9.5', '9.5'),
			JHtml::_('select.option', '10', '10')
		);
		$html = '';
		$html .= '<div id="content_width_for_pages_form">';
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_ITEMID_OPTION') . '</div>';
		$html .= '<input type="text" id="content_width_for_pages_input" />';
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_STATE') . '</div>';
		$html .= JHtml::_('select.genericlist', $options, 'name', '', 'value', 'text', 'default', 'content_width_for_pages_select');
		$html .= '<input type="button" value="'.JText::_('TPL_GK_LANG_ADD_RULE').'" id="content_width_for_pages_add_btn" />';
		$html .= '<textarea name="'.$this->name.'" id="'.$this->id.'">' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '</textarea>';
		$html .= '<div id="content_width_for_pages_rules"></div>';
		$html .= '</div>';
		
		return $html;
	}
}
