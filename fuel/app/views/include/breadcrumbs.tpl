<nav id="breadcrumbsWrapper" aria-label="You are here:" role="navigation">
	<ol class="breadcrumbs">
		<li><a href="{$base_url}">HOME</a></li>
		{foreach $breadcrumbs as $breadcrumb}
			<li><a href="{$breadcrumb.href}">{$breadcrumb.text}</a></li>
		{/foreach}
	</ol>
</nav>