<?php

// Pagination override

// no direct access
defined('_JEXEC') or die('Restricted access');

function pagination_list_render($list) {
	// Reverse output rendering for right-to-left display.
	$html = '<nav class="pagination"><ul>';
	$html .= '<li class="pagination-start">'.$list['start']['data'].'</li>';
	$html .= '<li class="pagination-prev">'.$list['previous']['data'].'</li>';
	
		foreach($list['pages'] as $page) {
			$html .= '<li>'.$page['data'].'</li>';
		}
	
	$html .= '<li class="pagination-next">'. $list['next']['data'].'</li>';
	$html .= '<li class="pagination-end">'. $list['end']['data'].'</li>';
	$html .= '</ul></nav>';

	return $html;
}
	
function pagination_item_active($item) {
	$app = JFactory::getApplication();
	
	if ($app->isAdmin()) {
		if ($item->base > 0) {
			return "<a title=\"".$item->text."\" onclick=\"document.adminForm." . $this->prefix . "limitstart.value=".$item->base."; Joomla.submitform();return false;\">".$item->text."</a>";
		} else {
			return "<a title=\"".$item->text."\" onclick=\"document.adminForm." . $this->prefix . "limitstart.value=0; Joomla.submitform();return false;\">".$item->text."</a>";
		}
	} else {
		return "<a title=\"".$item->text."\" href=\"".$item->link."\" class=\"pagenav\">".$item->text."</a>";
	}
}

function pagination_item_inactive($item) {
	$app = JFactory::getApplication();
	
	if ($app->isAdmin()) {
		return "<span>".$item->text."</span>";
	} else {
		return "<span class=\"pagenav\">".$item->text."</span>";
	}
}

// EOF