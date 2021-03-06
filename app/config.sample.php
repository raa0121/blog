<?php
// Sample Config file
// Please copy `config.sample.php` to `config.php` and edit them.

//error_reporting(-1);
error_reporting(0);

// DBの接続情報
define('DB_HOST', 'localhost'); // dbのホスト名
define('DB_USER', 'your user name'); // dbのユーザー名
define('DB_PASSWORD', 'your password'); // dbのパスワード
define('DB_DATABASE', 'your database name'); // dbのデータベース名
define('DB_CHARSET', 'UTF8MB4'); // MySQL 5.5未満の場合はUTF8を指定してください

// サーバーの設定情報
define('DOMAIN', 'example.test'); // ドメイン名
define('HTTP_PORT', '80'); // HTTP時ポート
define('HTTPS_PORT', '443'); // HTTPS時ポート

// PASSWORD_SALTは十分にランダムなテキストを生成して設定ください。
// PASSWORD_SALT should be unique and random string.
// ex: $ php -r 'echo hash("sha256", random_bytes(1024));'
define('PASSWORD_SALT', '0123456789abcdef');

// publicとappの位置関係を修正した場合には変更してください
// Please edit the path when change `app` and `public` relative path condition.
define('WWW_DIR', __DIR__ . '/../public');

// 設定クラス読み込み
require(__DIR__ . '/core/bootstrap.php');
