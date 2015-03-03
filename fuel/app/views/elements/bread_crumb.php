<?php
/**
 * render bread crumb
 *
 * @use array $crumbs
 */
if( ! empty($crumbs)):
	array_unshift($crumbs, array(
		'url' => '/',
		'label' => \Config::get('app_name').'トップ',
	));
	$end = end($crumbs);
?>
	<nav class="container">
		<ul class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">
			<?php foreach($crumbs as $crumb): ?>
				<?php if($end === $crumb): ?>
					<li class="breadcrumb__list">
						<?= \Html::anchor($crumb['url'], \e($crumb['label']), array('class' => 'breadcrumb__list__anchor')) ?>
					</li>
				<?php else: ?>
					<li class="breadcrumb__list" typeof="v:Breadcrumb">
						<?= \Html::anchor($crumb['url'], \e($crumb['label']), array('class' => 'breadcrumb__list__anchor', 'rel' => 'v:url', 'property' => 'v:title')) ?>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</nav>
<?php endif; ?>

