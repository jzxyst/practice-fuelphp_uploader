(function(window, app) {
	'use strict';
	window.TopPageScript = (function(){

		// constructor
		var TopPageScript = function(){
			this.$uploadForm = $('#jsUploadForm');
			this.$uploadButton = this.$uploadForm.find('[type="submit"]');
			this.$uploadStatusField = this.$uploadForm.find('.jsUploadStatus');
			this.$uploadStatusLabel = this.$uploadStatusField.find('.uploadStatusLabel');
			this.$uploadProgressBar = $('#uploadProgressBar');
			this.$uploadProgressLabel = $('#uploadProgressLabel');
			this.$uploadSuccessModal = $('#uploadSuccessModal');
			this.$uploadFileList = this.$uploadSuccessModal.find('.uploadedFileList');
			this.$uploadFilesText = this.$uploadSuccessModal.find('[name="uploadedFilesText"]');
			this.$removeSuccessModal = $('#removeSuccessModal');
			this.$serverFileList = $('#serverFileList');
			this.fileRows = [];

			this.bindUploadForm();
			this.initFileRows();
		};

		/**
		 * アップロードフォームのeventsをhookする
		 */
		TopPageScript.prototype.bindUploadForm = function(){
			this.$uploadForm.on('submit', this.submitUploadForm.bind(this));
			this.$uploadForm.on('reset', this.resetUploadForm.bind(this));
		}

		/**
		 * アップロードフォームのsubmit時処理
		 * @param e
		 */
		TopPageScript.prototype.submitUploadForm = function(e){

			e.preventDefault();

			//  前準備
			this.disableUploadButton();
			this.showUploadStatus();
			this.changeUploadStatusLabel('ファイルをアップロードしています...');

			var formData = new FormData(this.$uploadForm.get(0));
			app.api.file.upload(formData, function(){
				var xhr = $.ajaxSettings.xhr();
				if (xhr.upload) {
					xhr.upload.addEventListener('progress',
						function(e) {
							this.changeUploadProgress(e);

							if (e.loaded >= e.total) {
								this.changeUploadStatusLabel('サーバで処理中...');
							}
						}.bind(this), false);
				}
				return xhr;
			}.bind(this), function(data, textStatus, jqXHR){

				// reset form
				this.$uploadForm.trigger('reset');
				this.hideUploadStatus();

				// add to dom
				this.addFileRowToDom(data);

				// show modal
				this.showUploadedModal(data);

			}.bind(this), function(data, textStatus, errorThrown){
				var errorDetail = app.api.file.errorResponseJsonToString(data['responseJSON']);
				this.changeUploadStatusLabel(sprintf(
					'エラーが発生しました。以下をコピーして管理人へ問い合わせてください。<br />エラーコード：%s<br />エラーメッセージ：%s<br />詳細：%s', data['status'], data['statusText'], errorDetail
				));

			}.bind(this), function(data, textStatus, returnedObject){
				// 後始末
				this.enableUploadButton();
			}.bind(this));
		}

		/**
		 * アップロードフォームのreset時処理
		 * @param e
		 */
		TopPageScript.prototype.resetUploadForm = function(){
			this.resetUploadProgress();
		}

		/**
		 * ファイルごとの処理をbind
		 */
		TopPageScript.prototype.initFileRows = function(){
			var that =this;
			$('#serverFileList .fileRow').each(function() {
				that.fileRows.push(new FileRow($(this)));
			});
		}

		/**
		 * アップロードしたファイルをDOMへ追加
		 * @param e
		 */
		TopPageScript.prototype.addFileRowToDom = function(data){
			var length = data.length;
			for (var i = 0; i < length; ++i) {

				// add to dom
				var $row = $(data[i]['template']);
				new Foundation.Reveal($row.find('.reveal'));
				this.fileRows.push(new FileRow($row));
				this.$serverFileList.prepend($row);
			}
		}

		/**
		 * アップロードボタンを有効化
		 */
		TopPageScript.prototype.enableUploadButton = function(){
			this.$uploadButton.prop('disabled', false);
		}

		/**
		 * アップロードボタンを無効化
		 */
		TopPageScript.prototype.disableUploadButton = function(){
			this.$uploadButton.prop('disabled', true);
		}

		/**
		 * アップロードステータスを表示
		 */
		TopPageScript.prototype.showUploadStatus = function(){
			this.$uploadStatusField.removeClass('hide');
		}

		/**
		 * アップロードステータスを非表示
		 */
		TopPageScript.prototype.hideUploadStatus = function(){
			this.$uploadStatusField.addClass('hide');
		}


		/**
		 * アップロードステータスラベルを変更する
		 */
		TopPageScript.prototype.changeUploadStatusLabel = function(string){
			this.$uploadStatusLabel.html(string);
		}


		/**
		 * プログレスバーを変更する
		 */
		TopPageScript.prototype.changeUploadProgress = function(e){
			var progress = parseInt(e.loaded / e.total * 10000) / 100;
			this.$uploadProgressBar.val(progress);
			this.$uploadProgressLabel.text(sprintf('%d / %d', e.loaded, e.total));
		}


		/**
		 * プログレスバーをリセットする
		 */
		TopPageScript.prototype.resetUploadProgress = function(e){
			this.$uploadProgressBar.val(0);
			this.$uploadProgressLabel.text('');
		}


		/**
		 * アップロード完了modalを表示する
		 */
		TopPageScript.prototype.showUploadedModal = function(data){

			// リストの更新
			this.$uploadFileList.empty();
			var urls = [];
			var length = data.length;
			for (var i = 0; i < length; ++i) {
				this.$uploadFileList.append(
					$('<li/>').append(
						$('<a>').attr({
							'href': data[i]['content_url'],
							'target': '_blank'
						}).text(data[i]['original_filename'])
					)
				);

				urls.push(data[i]['content_url']);
			}

			// テキストエリアの更新
			this.$uploadFilesText.val(urls.join("\n"));
			this.$uploadFilesText.attr('rows', length);

			// show modal
			this.$uploadSuccessModal.foundation('open');
		}

		/**
		 * 削除完了modalを表示する
		 */
		TopPageScript.prototype.showRemovedModal = function(){
			this.$removeSuccessModal.foundation('open');
		}

		return TopPageScript;
	}());

})(window, window.app);
