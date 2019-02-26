#!/usr/bin/env php
<?php
/**
 * ConoHaオブジェクトストレージに接続する認証トークンを取得するプログラム
 *
 * @link https://www.conoha.jp/blog/tech/3429.html
 */
require_once 'config.php';
// cURLの初期化
$curl = curl_init();
// HTTPヘッダー
$headers = array(
    // Acceptヘッダーでレスポンスの形式を指定できる
    // application/jsonの他にapplication/xmlやtext/xmlなど
    'Content-Type: application/json'
);
// POSTデータの準備
// アカウント名、テナント名、パスワードは環境に合わせて変更する。
$data = array(
    'auth' => array(
        'tenantName' => TENANT_NAME,
        'passwordCredentials' => array(
            'username' => USERNAME,
            'password' => PASSWORD
        )
    )
);
$postdata = json_encode($data);
// URL
$url = AUTH_URL . '/tokens';
// cURLのオプション
$options = array(
    // HTTPヘッダーの設定
    CURLOPT_HTTPHEADER => $headers,
    // URL
    CURLOPT_URL => $url,
    
    // POSTリクエストを実行する
    CURLOPT_POST => true,
    // POSTデータのセット
    CURLOPT_POSTFIELDS => $postdata,
    // curl_exec()の返り値で本文を受け取る
    CURLOPT_RETURNTRANSFER => true,
);
curl_setopt_array($curl, $options);
// HTTPリクエストを実行
// レスポンスはJSON形式の文字列
$body = curl_exec($curl);
if(curl_errno($curl)) {
    $msg = sprintf('cURL error: %s', curl_error($curl));
    throw new RuntimeException($msg);
}
// HTTPステータスコードを取得します。
// 認証に成功すると200、失敗すると401が返ってきます。
$status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
if(curl_errno($curl) OR $status_code != 200) {
    $msg = sprintf(
        'Authentication failed. The auth server returned status code(%d).',
        $status_code
    );
    throw new RuntimeException($msg);
}
// json_decode()は、JSON文字列をPHPの汎用オブジェクト(stdClass)に変換する関数
$authinfo = json_decode($body);
// トークンはこれで取得できます。
// $authinfoには、他にもトークンの有効期限、テナントの情報、サービスカタログなどが含まれている
echo "token: " . $authinfo->access->token->id  . "\n";
// オブジェクトストレージのエンドポイントURLも取得できる
// これはコントロールパネルのAPI情報から確認できるURLと同じ
foreach($authinfo->access->serviceCatalog as $catalog) {
    if($catalog->type == 'object-store') {
        $endpoint = array_shift($catalog->endpoints);
        echo "endpoint url: " . $endpoint->publicURL . "\n";
    }
}





// コンテナ作成
echo "\n\n";


// cURLの初期化
$curl = curl_init();


// HTTPヘッダー
$headers = array(
    // X-Auth-Tokenヘッダーでトークンを指定します
    'X-Auth-Token: ' . $authinfo->access->token->id,
    
    // Acceptヘッダーでレスポンスの形式を指定できる
    // application/jsonの他にapplication/xmlやtext/xmlなど
    'Accept: application/json'
);
// リクエストURL
$url = ENDPOINT_URL;
// cURLのオプション
$options = array(
    // URLの設定
    CURLOPT_URL => $url,
    
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers,
);
curl_setopt_array($curl, $options);
// HTTPリクエストを実行
// レスポンスには何も含まれていません。
$body = curl_exec($curl);
if(curl_errno($curl)) {
    $msg = sprintf('cURL error: %s', curl_error($curl));
    throw new RuntimeException($msg);
}
// 結果を表示します。
$status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
echo "status code: " . $status_code . "\n";
echo $body . "\n";