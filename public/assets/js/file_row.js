(function(window, app) {
	'use strict';
	window.FileRow = (function(){

		// constructor
		var FileRow = function($object){
			this.$object = $object;
			this.modalId = this.$object.data('modalId');
			this.$modal = $(sprintf('#%s', this.modalId));
			this.$form = this.$modal.find('.jsRemoveForm');
			this.$inputDeleteKey = this.$form.find('[name="delete_key"]');
			this.$inputErrorLabel = this.$form.find('.form-error');
			this.$alertLabel = this.$form.find('.alertArea .label.alert');
			this.$submitButton = this.$form.find('[type="submit"]');
			this.$loader = this.$modal.find('.loaderWrapper');
			this.upload_file_id = this.$form.find('[name="upload_file_id"]').val();

			// init
			this.bind();
		};

		FileRow.prototype.bind = function(){
			this.$form.on('submit', this.submitRemoveForm.bind(this));
		}

		/**
		 * Formをsubmitした際の処理
		 * @param e
		 */
		FileRow.prototype.submitRemoveForm = function(e){

			// デフォルト制御無効
			e.preventDefault();

			var delete_key = this.$inputDeleteKey.val();

			// 前準備
			this.disableButton();
			this.showLoader();

			// ファイル削除API呼び出し
			app.api.file.remove(this.upload_file_id, delete_key, function() {

				// close modal
				this.closeModal();

				// remove DOM
				this.removeRow();

				// open success modal
				window.topPageScript.showRemovedModal();

			}.bind(this), function(jqXHR) {
				switch(jqXHR.status) {
					case 401: {
						this.showErrorLabel();
						break;
					}
					default: {
						this.showAlertLabel();
					}
				}
			}.bind(this), function() {

				// 後始末
				this.enableButton();
				this.hideLoader();

			}.bind(this));
		}

		/**
		 * 行(自分)を削除する
		 */
		FileRow.prototype.removeRow = function(){
			this.$object.fadeOut('normal', function() {
				$(this).remove();
			});
		}

		/**
		 * Modalを閉じる
		 */
		FileRow.prototype.closeModal = function(){
			this.$modal.foundation('close');
		}

		/**
		 * ボタン無効化
		 */
		FileRow.prototype.disableButton = function(){
			this.$submitButton.prop('disabled', true);
		}

		/**
		 * ボタン有効化
		 */
		FileRow.prototype.enableButton = function(){
			this.$submitButton.prop('disabled', false);
		}

		/**
		 * ローダー表示
		 */
		FileRow.prototype.showLoader = function(){
			this.$loader.removeClass('hide');
		}

		/**
		 * ローダー非表示
		 */
		FileRow.prototype.hideLoader = function(){
			this.$loader.addClass('hide');
		}

		/**
		 * エラー表示
		 */
		FileRow.prototype.showErrorLabel = function(){
			this.$inputDeleteKey.addClass('is-invalid-input');
			this.$inputErrorLabel.addClass('is-visible');
		}

		/**
		 * アラート表示（削除不可能）
		 */
		FileRow.prototype.showAlertLabel = function(){
			this.$alertLabel.removeClass('hide');
		}

		return FileRow;
	}());
})(window, window.app);
