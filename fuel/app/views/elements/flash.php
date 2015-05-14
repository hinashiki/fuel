<div id="flash_box">
<?php foreach(array('success', 'error') as $type): ?>
	<?php if (Session::get_flash($type)): ?>
		<div class="flash flash--<?= $type ?> container">
			<p><?= implode('</p><p>', h((array) Session::get_flash($type))) ?></p>
		</div>
	<?php endif; ?>
<?php endforeach; ?>
</div>
