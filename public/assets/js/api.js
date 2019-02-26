/**
 * Created by *** on 2017/03/06.
 */
(function(window, app) {

	'use strict';

	// APIクラス定義
	app.api = (function(){

		// メンバ定義
		var api = function(){
			this.defaultTimeout = 1000 * 60 * 30;
		};

		//var p = api.prototype;

		// /api/file/
		api.file = (function(){

			var file = function(){
			};

			/**
			 *
			 * @param done
			 * @param fail
			 * @param always
			 */
			file.getList = function(done, fail, always, template){

				var query = $.param({
					'template': template
				});

				$.ajax({
					url: window.apiEndPoints['file'] + 'list.json?' + query,
					type: 'GET',
					cache: false,
					contentType: false,
					processData: false,
					timeout: api.defaultTimeout
				}).done(done).fail(fail).always(always);
			};

			/**
			 *
			 * @param formData
			 * @param xhr
			 * @param done
			 * @param fail
			 * @param always
			 */
			file.upload = function(formData, xhr, done, fail, always){
				$.ajax({
					url: window.apiEndPoints['file'] + 'upload',
					type: 'POST',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					headers: {
						'Accept': 'application/json'
					},
					xhr: xhr
				}).done(done).fail(fail).always(always);
			};

			/**
			 *
			 * @param upload_file_id
			 * @param delete_key
			 * @param done
			 * @param fail
			 * @param always
			 */
			file.remove = function(upload_file_id, delete_key, done, fail, always){

				var query = $.param({
					'upload_file_id': upload_file_id,
					'delete_key': delete_key
				});

				$.ajax({
					url: window.apiEndPoints['file'] + 'file?' + query,
					type: 'DELETE',
					cache: false,
					contentType: false,
					processData: false,
					timeout: api.defaultTimeout
				}).done(done).fail(fail).always(always);
			};

			file.errorResponseJsonToString = function (responseJSON) {
				var result = [];
				for (var i = 0; i < responseJSON.length; ++i) {
					var filtered = {};
					for (var key in responseJSON[i]) {
						if (key === 'name' || key === 'errors') {
							filtered[key] = responseJSON[i][key];
						}
					}
					result.push(filtered);
				}
				return JSON.stringify(result, undefined, 1);
			};

			return file;
		}());

		return api;
	}());
})(window, window.app);