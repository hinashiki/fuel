<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="content-language" content="ja">
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<title><?= $title ?>:<?= \Config::get('app_name') ?></title>
	<?= \Seo::instance()->get_meta_html() ?>
	<?= \Asset::css(\Arr::merge(array('bootstrap.css', 'common.css'), $css)) ?>
</head>
<body>
	<header class="header navbar navbar-inverse">
		<div class="container">
			<a href="<?= \Config::get('base_url') ?>" class="navbar-brand"><?= \Config::get('app_name') ?></a>
		</div>
	</header>
	<?= $bread_crumb ?>
	<div class="container">
		<?= $content ?>
	</div>
	<footer class="footer">
		<div class="container">
			<p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
			<p>
				<a href="http://fuelphp.com">FuelPHP</a> is released under the MIT license.<br>
				<small>Version: <?php echo Fuel::VERSION; ?></small>
			</p>
		</div>
	</footer>
	<script type="text/javascript" src="//code.jquery.com/jquery-<?= $jquery_version ?>.min.js"></script>
	<?= \Asset::js(\Arr::merge(array('bootstrap.js', 'core.js'), $js)) ?>
</body>
</html>
