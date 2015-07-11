<div id="flash_box">
<?php foreach(array('success', 'error') as $type): ?>
	<?php if (Session::get_flash($type)): ?>
		<div class="container">
			<div class="alert alert--<?= $type ?>">
				<p><?= implode('</p><p>', e((array) Session::get_flash($type))) ?></p>
			</div>
		</div>
	<?php endif; ?>
<?php endforeach; ?>
</div>
