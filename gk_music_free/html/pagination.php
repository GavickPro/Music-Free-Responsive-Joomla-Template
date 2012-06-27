<?php

// Pagination override

// no direct access
defined('_JEXEC') or die('Restricted access');

function pagination_list_render($list) {
	// Reverse output rendering for right-to-left display.
	$html = '<nav class="pagination"><ul>';
	$html .= '<li class="pagination-start">'.$list['start']['data'].'</li>';
	$html .= '<li class="pagination-prev">'.$list['previous']['data'].'</li>';
	
	if(count($list['pages']) >= 7) {
		$founded = false;
		
		for($i = 1; $i <= count($list['pages']); $i++) {
			if($list['pages'][$i]['active'] != 1) {
				$founded = $i;
				break;
			}
		}
		
		for($i = 1; $i <= count($list['pages']); $i++) {
			if($i == 1 && $founded > $i + 2) {
				$html .= '<li><span>&hellip;</span></li>';
			}
			
			if($i == count($list['pages']) && $founded < $i - 2) {
				$html .= '<li><span>&hellip;</span></li>';
			}
			
			if($i >= $founded - 2 && $i <= $founded + 2) {
				$html .= '<li>'.$list['pages'][$i]['data'].'</li>';
			}
		}
	} else {
		for($i = 1; $i <= count($list['pages']); $i++) {
			$html .= '<li>'.$list['pages'][$i]['data'].'</li>';
		}
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