<header><h2><?php echo __('Article setting') ?></h2></header>

<?php $this->display('BlogSettings/tab.php', array('tab'=>'entry_edit')); ?>

<form method="POST" id="sys-blog-template-form" class="admin-form">

<table>
  <tbody>
    <tr>
      <th><?php echo __('Display the latest entries'); ?></th>
      <td>
        <?php echo \Fc2blog\Web\Html::input('blog_setting[entry_recent_display_count]', 'text', array('maxlength'=>3)); ?>
        <?php if (isset($errors['blog_setting']['entry_recent_display_count'])): ?><p class="error"><?php echo $errors['blog_setting']['entry_recent_display_count']; ?></p><?php endif; ?>
      </td>
    </tr>
    <tr>
      <th><?php echo __('Display the number of articles, display order'); ?></th>
      <td>
        <?php echo \Fc2blog\Web\Html::input('blog_setting[entry_display_count]', 'text', array('maxlength'=>10)); ?>
        <?php if (isset($errors['blog_setting']['entry_display_count'])): ?><p class="error"><?php echo $errors['blog_setting']['entry_display_count']; ?></p><?php endif; ?>
        <?php echo \Fc2blog\Web\Html::input('blog_setting[entry_order]', 'select', array('options'=>\Fc2blog\Model\BlogSettingsModel::getEntryOrderList())); ?>
        <?php if (isset($errors['blog_setting']['entry_order'])): ?><p class="error"><?php echo $errors['blog_setting']['entry_order']; ?></p><?php endif; ?>
      </td>
    </tr>
    <tr>
      <th>
        <?php echo __('Password of the article view'); ?><br />
        (<?php echo __('It is adapted to the password is not set at the time of the article'); ?>)
      </th>
      <td>
        <?php echo \Fc2blog\Web\Html::input('blog_setting[entry_password]', 'text'); ?>
        <?php if (isset($errors['blog_setting']['entry_password'])): ?><p class="error"><?php echo $errors['blog_setting']['entry_password']; ?></p><?php endif; ?>
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

