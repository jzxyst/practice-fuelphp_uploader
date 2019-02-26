{$unique_hash = uniqid()}
{$unique_modal_id = "fileRemoveModal_$unique_hash"}
<tr class="fileRow" data-upload-file-id="{$_file.upload_file_id}" data-modal-id="{$unique_modal_id}">
	<td class="fileName">
		<a href="{$_file.content_url}" target="_blank"><i class="fa {$_file.mimetype_awesome_class} margin"></i>{$_file.original_filename}</a>
	</td>
	<td class="mimeType">{$_file.mimetype}</td>
	<td class="fileSize medium-text-right">{$_file.file_size_with_unit}</td>
	<td class="comment abridgement">{$_file.comment}</td>
	<td class="createdDatetime">{$_file.created_datetime}</td>
	<td class="removeButton medium-text-center">
		<button class="button jsRemoveFile" type="button" data-toggle="{$unique_modal_id}">
			<i class="fa fa-trash"></i>
		</button>

		{* 削除画面modal *}
		<div class="reveal small removeFormModal" id="{$unique_modal_id}" data-reveal data-close-on-click="true" data-animation-in="slide-in-down fast" data-animation-out="slide-out-up fast">
			<p>アップロードした際の削除キーを入力してください。</p>
			<dl>
				<dt>ファイル名</dt>
				<dd>{$_file.original_filename}</dd>
			</dl>
			<form class="jsRemoveForm" action="{$base_url}api/file/upload/file/" method="delete" accept-charset="UTF-8" data-abide novalidate>
				<input type="hidden" name="upload_file_id" value="{$_file.upload_file_id}" />
				<input type="password" name="delete_key" value="" placeholder="password" aria-describedby="passwordHelpText" required />
				<span class="form-error">削除キーが一致しません。</span>
				<button name="action" type="submit" class="button alert" value="remove"><i class="fa fa-trash margin"></i>削除</button>
				<div class="alertArea">
					<div class="label alert hide">
						このファイルは削除できません。
					</div>
				</div>
			</form>
			<button class="close-button" data-close aria-label="Close reveal" type="button">
				<span aria-hidden="true">&times;</span>
			</button>
			{include file='file:include/loader.tpl'}
		</div>
	</td>
</tr>