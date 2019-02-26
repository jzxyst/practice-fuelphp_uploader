{extends file='include/layout.tpl'}
{block name=body_bottom_contents}
	{Asset::js('index.js')}
	{Asset::js('file_row.js')}
	<script>
	$(function(){
		// init index script
		window.topPageScript = new TopPageScript();
	});
	</script>
{/block}
{block name=body}
	<ul id="userActionTabs" class="tabs" data-tabs data-active-collapse="true">
		<li class="tabs-title"><a href="#userActionTab_Uoload" aria-selected="true">アップロード</a></li>
		<li class="tabs-title {if $input.freeword|default:'' || $input.mimetype|default:'' || $input.is_only_mine|default:''}is-active{/if}"><a href="#userActionTab_Search">検索</a></li>
	</ul>
	<div class="tabs-content" data-tabs-content="userActionTabs">
		<div id="userActionTab_Uoload" class="tabs-panel">
			<form id="jsUploadForm" action="{$base_url}api/file/upload/" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
				<input name="file[]" type="file" multiple="multiple" />
				<label>
					コメント
					<input name="comment" type="text" />
				</label>
				<label>
					削除キー
					<input name="password" type="password" aria-describedby="passwordHelpText" />
					<p class="help-text" id="passwordHelpText">削除キーを設定しない場合、後からファイルを削除することができません。</p>
				</label>
				<button name="action" type="submit" class="button" value="upload"><i class="fa fa-upload margin"></i>アップロード</button>
				<fieldset class="fieldset jsUploadStatus hide">
					<legend>ステータス</legend>
					<p class="uploadStatusLabel"></p>
					<progress id="uploadProgressBar" class="progress" max="100" value="0"></progress>
					<p id="uploadProgressLabel"></p>
				</fieldset>
			</form>
		</div>
		<div id="userActionTab_Search" class="tabs-panel {if $input.freeword|default:'' || $input.mimetype|default:''}is-active{/if}">
			<form id="jsSearchForm" action="{$base_url}" method="get" accept-charset="UTF-8">
				<label>
					キーワード
					<input name="freeword" type="text" value="{$input.freeword|default:''}" />
				</label>
				{assign_mimetypes}
				{$other_mimetypes = [['label' => 'テキスト', 'value' => 'text/'], ['label' => '画像', 'value' => 'image/'], ['label' => '動画', 'value' => 'video/'], ['label' => 'オーディオ', 'value' => 'audio/']]}
				<label>
					ファイルタイプ
					<select name="mimetype">
						<option value="">-</option>
						{foreach $other_mimetypes as $mimetype}
							<option value="{$mimetype.value}" {if $input.mimetype|default:'' == $mimetype.value}selected="selected"{/if}>{$mimetype.label}</option>
						{/foreach}
						{foreach $mimetypes as $mimetype}
							<option value="{$mimetype.mimetype}" {if $input.mimetype|default:'' == $mimetype.mimetype}selected="selected"{/if}>{$mimetype.mimetype}</option>
						{/foreach}
					</select>
				</label>
				<label><input name="is_only_mine" type="checkbox" value="1" {if $input.is_only_mine|default:'' == '1'}checked="checked"{/if} />自分でアップロードしたファイルをお探しですか？</label>
				<button name="action" type="submit" class="button" value="search"><i class="fa fa-search margin"></i>検索</button>
			</form>
		</div>
	</div>
	<section id="serverFileListWrapper">
		{include file='file:include/pager.tpl'}
		<table id="serverFileList" class="hover stack">
			<caption class="hide">ファイル一覧</caption>
			<thead>
				<tr>
					<th class="fileName">ファイル名</th>
					<th class="mimeType">MIME Type</th>
					<th class="fileSize">ファイルサイズ</th>
					<th class="comment">コメント</th>
					<th class="createdDatetime">アップロード日時</th>
					<th class="removeButton">削除</th>
				</tr>
			</thead>
			<tbody>
			{foreach $files as $file}
				{include file='file:include/file_row.tpl' _file=$file}
			{/foreach}
			</tbody>
		</table>
		{include file='file:include/pager.tpl'}

		{* アップロード完了modal *}
		<div id="uploadSuccessModal" class="reveal small" data-reveal data-close-on-click="true" data-animation-in="slide-in-down fast" data-animation-out="slide-out-up fast">
			<p class="margin0">ファイルのアップロードが完了しました！</p>
			<ol class="uploadedFileList"></ol>
			<label>
				URLはこちらからコピーできます。
				<textarea name="uploadedFilesText" readonly></textarea>
			</label>
			<button class="close-button" data-close aria-label="Close reveal" type="button">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>

		{* 削除完了modal *}
		<div id="removeSuccessModal" class="reveal tiny" data-reveal data-overlay="false" data-close-on-click="true" data-animation-in="fade-in" data-animation-out="fade-out">
			<p class="margin0">ファイルの削除が完了しました。</p>
			<button class="close-button" data-close aria-label="Close reveal" type="button">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	</section>
{/block}