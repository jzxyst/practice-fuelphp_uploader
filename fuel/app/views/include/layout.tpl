<!DOCTYPE HTML>
<html lang="ja-JP">
	<head prefix="og: http://ogp.me/ns#">
		<meta charset="UTF-8" />
		<meta name="author" content="{\Constant\Site::DOMAIN_NAME}" />
		<meta name="copyright" content="{\Constant\Site::COPYRIGHT}" />
		<meta name="generator" content="Microsoft notepad.exe" />
		<meta name="robots" content="noindex,nofollow,noarchive" />
		<meta name="description" content="" />
		<meta name="format-detection" content="telephone=no,address=no,email=no" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />
		<link rel="canonical" href="" />
		<link rel="icon" href="{$base_url}favicon.ico" />
		<link rel="apple-touch-icon" href="{$base_url}favicon.ico" />
		<link rel="alternate" type="application/rss+xml" href="" />
		<link type="text/css" rel="stylesheet" href="//fonts.googleapis.com/css?family=Lato:400,700" />
		<link type="text/css" rel="stylesheet" href="//fonts.googleapis.com/earlyaccess/notosansjp.css" />
		{*{Asset::css('vendor/normalize.css')}*}
		{Asset::css('vendor/foundation.min.css')}
		{Asset::css('font-awesome.min.css')}
		{Asset::css('base.css')}
		<title>{\Constant\Site::SITE_NAME}</title>
		{block name=head_contents}{/block}
		{literal}
			<!-- Google Tag Manager -->
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
					new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
					j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
					'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
				})(window,document,'script','dataLayer','GTM-MRZ4XF8');</script>
			<!-- End Google Tag Manager -->
		{/literal}
	</head>
	<body>
		{literal}
			<!-- Google Tag Manager (noscript) -->
			<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MRZ4XF8"
			                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
			<!-- End Google Tag Manager (noscript) -->
		{/literal}
		{block name=body_top_contents}{/block}
		<div id="bodyWrapper">
			{include file='file:include/header.tpl'}
			{include file='file:include/breadcrumbs.tpl' breadcrumbs=$breadcrumbs|default:[]}
			<main>
				{block name=body}{/block}
			</main>
			{include file='file:include/footer.tpl'}
		</div>
		<script>
			(function(window, app) {
				window.baseUrl = '{$base_url}';
				window.apiEndPointRoot = '{$base_url}api';
				window.apiEndPoints = {
					'file': '{$base_url}api/file/'
				};
			})(window, window.app);
		</script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		{Asset::js('vendor/what-input.js')}
		{Asset::js('vendor/foundation.min.js')}
		{Asset::js('vendor/js.cookie.js')}
		{Asset::js('jquery.jlib.min.js')}
		{Asset::js('app.js')}
		{Asset::js('api.js')}
		{block name=body_bottom_contents}{/block}
	</body>
</html>