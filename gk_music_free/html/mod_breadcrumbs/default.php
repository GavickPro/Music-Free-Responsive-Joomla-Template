<?php

// no direct access
defined('_JEXEC') or die;

?>

<div class="breadcrumbs<?php echo $moduleclass_sfx; ?>">
<?php 
	echo '<ul>';
    for ($i = 0; $i < $count; $i ++) {
		// If not the last item in the breadcrumbs add the separator
		if ($i < $count -1) {
			if (!empty($list[$i]->link)) echo '<li><a href="'.$list[$i]->link.'" class="pathway">'.$list[$i]->name.'</a></li>';
			else echo '<li class="pathway">' . $list[$i]->name . '</li>';
			if($i < $count -2) echo ' <li class="pathway separator">|</li> ';
		} else if ($params->get('showLast', 1)) { // when $i == $count -1 and 'showLast' is true
			if($i > 0) echo ' <li class="pathway separator">|</li> ';
			echo '<li class="pathway">' . $list[$i]->name . '</li>';
		}
	} 
    echo '</ul>';
?>
</div>