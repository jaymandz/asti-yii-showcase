<!doctype html>
<html lang="en">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?= Yii::app()->request->baseUrl ?>/libraries/bootstrap/5.3.3/dist/css/bootstrap.css">
<title><?= CHtml::encode($this->pageTitle) ?></title>

<body>

<nav class="bg-info navbar navbar-expand ">
<div class="container-fluid">
<a class="navbar-brand" href="#">
    <?= CHtml::encode(Yii::app()->name) ?>
</a>
<div class="collapse navbar-collapse">
<ul class="mb-2 mb-lg-0 me-auto navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="<?= $this->createUrl('/site/index') ?>">
            Home
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= $this->createUrl('/site/page',
		  ['view' => 'about']) ?>">About</a>
    </li>
	<li class="nav-item">
        <a class="nav-link" href="<?= $this->createUrl('/site/contact') ?>">
            Contact
        </a>
    </li>
	<?php if (Yii::app()->user->isGuest): ?>
	<li class="nav-item">
        <a class="nav-link" href="<?= $this->createUrl('/site/login') ?>">
            Login
        </a>
    </li>
	<?php else: ?>
	<li class="nav-item">
        <a class="nav-link" href="<?= $this->createUrl('/site/logout') ?>">
            Logout (<?= Yii::app()->user->name ?>)
        </a>
    </li>
	<?php endif ?>
</ul>
</div>
</div>
</nav>

<div class="container-fluid">

<?php if (isset($this->breadcrumbs)): ?>
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="#">Home</a>
		</li>
		<?php foreach ($this->breadcrumbs as $c => $crumb): ?>
		<?php if ($c == array_key_last($this->breadcrumbs)): ?>
		<li aria-current="page" class="breadcrumb-item active">
			<?= $crumb ?>
		</li>
		<?php else: ?>
		<li class="breadcrumb-item">
			<a href="#"><?= $crumb ?></a>
		</li>
		<?php endif ?>
		<?php endforeach ?>
	</ol>
</nav>
<?php endif ?>

<?= $content ?>

</div>

<script src="<?= Yii::app()->request->baseUrl ?>/libraries/bootstrap/5.3.3/dist/js/bootstrap.bundle.js"></script>

</body>
</html>