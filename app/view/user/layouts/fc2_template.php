<?php

if(!headers_sent()) {
  header("Content-Type: text/html; charset=UTF-8");
}

// FC2のテンプレート用にデータを置き換える

if (!empty($entry)) {
  $entries = array($entry);
}
if (!empty($entries)) {
  foreach ($entries as $key => $value) {
    // topentry系変数のデータ設定
    $entries[$key]['title_w_img'] = $value['title'];
    $entries[$key]['title'] = strip_tags($value['title']);
    $entries[$key]['link'] = \Fc2blog\App::userURL(array('controller'=>'Entries', 'action'=>'view', 'blog_id'=>$value['blog_id'], 'id'=>$value['id']));

    list($entries[$key]['year'], $entries[$key]['month'], $entries[$key]['day'],
      $entries[$key]['hour'], $entries[$key]['minute'], $entries[$key]['second'], $entries[$key]['youbi'], $entries[$key]['month_short']
      ) = explode('/', date('Y/m/d/H/i/s/D/M', strtotime($value['posted_at'])));
    $entries[$key]['wayoubi'] = __($entries[$key]['youbi']);

    // 自動改行処理
    if ($value['auto_linefeed']==\Fc2blog\Config::get('ENTRY.AUTO_LINEFEED.USE')) {
      $entries[$key]['body'] = nl2br($value['body']);
      $entries[$key]['extend'] = nl2br($value['extend']);
    }
  }
}

// コメント一覧の情報
if (!empty($comments)) {
  foreach ($comments as $key => $value) {
    $comments[$key]['edit_link'] = \Fc2blog\Web\Html::url(array('controller'=>'Entries', 'action'=>'comment_edit', 'blog_id'=>$value['blog_id'], 'id'=>$value['id']));

    list($comments[$key]['year'], $comments[$key]['month'], $comments[$key]['day'],
      $comments[$key]['hour'], $comments[$key]['minute'], $comments[$key]['second'], $comments[$key]['youbi']
      ) = explode('/', date('Y/m/d/H/i/s/D', strtotime($value['updated_at'])));
    $comments[$key]['wayoubi'] = __($comments[$key]['youbi']);
    $comments[$key]['body'] = $value['body'];

    list($comments[$key]['reply_year'], $comments[$key]['reply_month'], $comments[$key]['reply_day'],
      $comments[$key]['reply_hour'], $comments[$key]['reply_minute'], $comments[$key]['reply_second'], $comments[$key]['reply_youbi']
      ) = explode('/', date('Y/m/d/H/i/s/D', strtotime($value['reply_updated_at'])));
    $comments[$key]['reply_wayoubi'] = __($comments[$key]['reply_youbi']);
    $comments[$key]['reply_body'] = nl2br($value['reply_body']);
  }
}

// FC2用のどこでも有効な単変数
$url = '/' . $blog['id'] . '/';
$blog_id = $this->getBlogId();

// 年月日系
$now_date = $date_area ? $now_date : date('Y-m-d') ;
$now_month_date = date('Y-m-1', strtotime($now_date));
$prev_month_date = date('Y-m-1', strtotime($now_month_date . ' -1 month'));
$next_month_date = date('Y-m-1', strtotime($now_month_date . ' +1 month'));

// テンプレート表示
include($fw_template);

