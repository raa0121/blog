<header><h2><?php echo __('I edit a category'); ?></h2></header>

<form method="POST" class="admin-form">

  <input type="hidden" name="id" value="<?php echo $request->get('id'); ?>" />
  <input type="hidden" name="sig" value="<?php echo \Fc2blog\Web\Session::get('sig'); ?>" />

  <table>
    <tbody>
      <tr>
        <th><?php echo __('Parent category'); ?></th>
        <td>
          <?php echo \Fc2blog\Web\Html::input('category[parent_id]', 'select', array('options' => $category_parents)); ?>
          <?php if (isset($errors['parent_id'])): ?><span class="error"><?php echo $errors['parent_id']; ?></span><?php endif; ?>
        </td>
      </tr>
      <tr>
        <th><?php echo __('Category name'); ?></th>
        <td>
          <?php echo \Fc2blog\Web\Html::input('category[name]', 'text'); ?>
          <?php if (isset($errors['name'])): ?><span class="error"><?php echo $errors['name']; ?></span><?php endif; ?>
        </td>
      </tr>
      <tr>
        <th><?php echo __('Sort by category'); ?></th>
        <td>
          <?php echo \Fc2blog\Web\Html::input('category[category_order]', 'select', array('options'=>\Fc2blog\Model\CategoriesModel::getOrderList())); ?>
          <?php if (isset($errors['category_order'])): ?><span class="error"><?php echo $errors['category_order']; ?></span><?php endif; ?>
        </td>
      </tr>
      <tr>
        <td class="form-button" colspan="2">
          <input type="submit" value="<?php echo __('Update'); ?>" />
        </td>
      </tr>
    </tbody>
  </table>

</form>

