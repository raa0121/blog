<header><h2><?php echo __('Other Settings'); ?></h2></header>

<?php $this->display('BlogSettings/tab.php', array('tab'=>'etc_edit')); ?>

<form method="POST" id="sys-blog-template-form" class="admin-form">

<table>
  <tbody>
    <tr>
      <th><?php echo __('Initial display page'); ?></th>
      <td>
        <?php echo \Fc2blog\Web\Html::input('blog_setting[start_page]', 'select', array('options'=>\Fc2blog\Model\BlogSettingsModel::getStartPageList())); ?>
        <?php if (isset($errors['blog_setting']['start_page'])): ?><p class="error"><?php echo $errors['blog_setting']['start_page']; ?></p><?php endif; ?>
      </td>
    </tr>
    <tr>
      <td class="form-button" colspan="2">
        <input type="submit" value="<?php echo __('Update'); ?>" />
      </td>
    </tr>
  </tbody>
</table>
<input type="hidden" name="sig" value="<?php echo \Fc2blog\Web\Session::get('sig'); ?>">

</form>

