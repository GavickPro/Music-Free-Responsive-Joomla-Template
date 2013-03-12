<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldGoogleAnalytics extends JFormField
{
	public $type = 'GoogleAnalytics';

	protected function getInput() {
		$html = '<div id="google_analytics_form">';
		$html .= '<div class="label">' . JText::_('TPL_GK_LANG_ADD_RULE_GA_CODE') . '</div>';
		$html .= '<input type="text" placeholder="UA-XXXXXX" id="google_analytics_input" />';
		$html .= '<input class="btn" type="button" value="'.JText::_('TPL_GK_LANG_ADD_RULE').'" id="google_analytics_add_btn" />';
		$html .= '<textarea name="'.$this->name.'" id="'.$this->id.'">' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '</textarea>';
		$html .= '<div id="google_analytics_rules"></div>';
		$html .= '</div>';
		
		return $html;
	}
}
