@section('flynsarmy/orchestra-cms::primary_menu')

<?php

use Illuminate\Support\Facades\HTML;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Fluent;
use Orchestra\Support\Facades\App; ?>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1" style="height: 1px;">
		<ul class="nav navbar-nav">
			<li class="<?= Request::is('*resources/orchestra-cms.templates*') ? 'active' : ''; ?>">
				<a href="<?= resources('orchestra-cms.templates'); ?>">Templates</a>
			</li>
			<li class="<?= Request::is('*resources/orchestra-cms.pages*') ? 'active' : ''; ?>">
				<a href="<?= resources('orchestra-cms.pages'); ?>">Pages</a>
			</li>
			<li class="<?= Request::is('*resources/orchestra-cms.partials*') ? 'active' : ''; ?>">
				<a href="<?= resources('orchestra-cms.partials'); ?>">Partials</a>
			</li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="<?= handles('flynsarmy/orchestra-cms::/'); ?>">View Website</a></li>
		</ul>
	</div><!-- /.navbar-collapse -->

@stop

<?php

$navbar = new Fluent(array(
	'id'    => 'orchestra-cms',
	'title' => 'CMS',
	'url'   => resources('orchestra-cms'),
	'menu'  => View::yieldContent('flynsarmy/orchestra-cms::primary_menu'),
)); ?>

@decorator('navbar', $navbar)

<br>
