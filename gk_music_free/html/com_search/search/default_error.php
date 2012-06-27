<?php

// no direct access
defined('_JEXEC') or die;

?>

<?php if($this->error): ?>
<div class="error">
	<?php echo $this->escape($this->error); ?>
</div>
<?php endif; ?>
