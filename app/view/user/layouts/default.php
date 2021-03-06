<?php
if(!headers_sent()){
  header("Content-Type: text/html; charset=UTF-8");
}
?>
<!DOCTYPE html>
<html lang="<?php echo \Fc2blog\Config::get('LANG'); ?>">
<head>
  <meta charset="utf-8">
  <title><?php echo h($blog['name']); ?></title>
  <link rel="icon" href="https://static.fc2.com/share/image/favicon.ico">
  <link rel="stylesheet" href="/css/normalize.css" type="text/css" media="all">
  <link rel="stylesheet" href="/css/user-fc2.css" type="text/css" media="all">
  <link rel="stylesheet" href="/css/user-form.css" type="text/css" media="all">
  <link rel="stylesheet" href="/css/common.css" type="text/css" media="all">
  <link rel="stylesheet" href="/css/main.css" type="text/css" media="all">
  <link rel="stylesheet" href="/css/blog_style.css" type="text/css" media="all">
  <link rel="stylesheet" href="/css/secret.css" type="text/css" media="all">

  <script type="text/javascript" src="/js/jquery/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="/js/common.js"></script>
  <script type="text/javascript" src="/js/common_design.js"></script>
</head>
<body>

  <header class="clear">
    <div>
      <?php if (\Fc2blog\Web\Session::get('id')): ?>
        <span><?php echo \Fc2blog\Web\Session::get('nickname'); ?></span>
      <?php endif; ?>

      <?php $lang = \Fc2blog\Config::get('LANG'); ?>
      <div id="switch_lang">
        <select id="sys-language-setting">
          <option value="ja" <?php if ($lang=='ja') : ?>selected="selected"<?php endif; ?>>日本語</option>
          <option value="en" <?php if ($lang=='en') : ?>selected="selected"<?php endif; ?>>English</option>
        </select>
        <script>
          $(function(){
            $('#sys-language-setting').on('change', function(){
              location.href="<?php echo \Fc2blog\Web\Html::url(array('controller'=>'Common', 'action'=>'lang')); ?>&lang=" + $('#sys-language-setting').val();
            });
          });
        </script>
      </div>
    </div>
  </header>

  <article>
    <article id="main-contents">
      <?php $this->display($fw_template); ?>
    </article>
  </article>

</body>
</html>
