<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?$APPLICATION->ShowTitle()?></title>
	<?$APPLICATION->ShowHead()?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/script.js"></script>
</head>
<body>
	<?$APPLICATION->ShowPanel();?>
	<header class="py-2 bg-light border-bottom">
		<div class="container d-flex flex-wrap">
			<a href="/" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
				<span class="fs-4">Тестовое задание</span>
			</a>
			<ul class="nav">
				<li class="nav-item"><a href="/bitrix/" class="nav-link link-dark px-2">Вход</a></li>
			</ul>
		</div>
  	</header>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
	