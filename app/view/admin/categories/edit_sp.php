<header><h1 class="in_menu sh_heading_main_b"><span class="h1_title"><?php echo __('I edit a category'); ?></span></h1></header>

<h2><span class="h2_inner"><?php echo __('Edit category'); ?></span></h2>
<form method="POST" class="admin-form">
  <input type="hidden" name="id" value="<?php echo $request->get('id'); ?>" />
  <input type="hidden" name="sig" value="<?php echo \Fc2blog\Web\Session::get('sig'); ?>" />
  <div class="form_area">
    <div class="form_contents">
      <h4><?php echo __('Parent category'); ?></h4>
      <?php echo \Fc2blog\Web\Html::input('category[parent_id]', 'select', array('options' => $category_parents)); ?>
      <?php if (isset($errors['parent_id'])): ?><span class="error"><?php echo $errors['parent_id']; ?></span><?php endif; ?>
    </div>
    <div class="form_contents">
      <h4><?php echo __('Category name'); ?></h4>
      <div class="common_input_text"><?php echo \Fc2blog\Web\Html::input('category[name]', 'text'); ?></div>
      <?php if (isset($errors['name'])): ?><span class="error"><?php echo $errors['name']; ?></span><?php endif; ?>
    </div>
    <div class="form_contents">
      <h4><?php echo __('Sort by category'); ?></h4>
      <?php echo \Fc2blog\Web\Html::input('category[category_order]', 'select', array('options' => \Fc2blog\Model\CategoriesModel::getOrderList())); ?>
      <?php if (isset($errors['category_order'])): ?><span class="error"><?php echo $errors['category_order']; ?></span><?php endif; ?>
    </div>
    <div class="form_contents">
      <div class="btn">
        <button type="submit" class="btn_contents positive touch"><i class="save_icon btn_icon"></i><?php echo __('Update'); ?></button>
      </div>
    </div>
  </div>
</form>

<div class="btn_area">
  <ul class="btn_area_inner">
    <li>
      <a class="btn_contents touch" href="<?php echo \Fc2blog\Web\Html::url(array('controller'=>'Categories','action'=>'create')); ?>"><i class="return_icon btn_icon"></i><?php echo __('I Back to List'); ?></a>
    </li>
    <?php if ($request->get('id')!=1): ?>
      <li>
        <a href="<?php echo \Fc2blog\Web\Html::url(array('action'=>'delete', 'id'=>$request->get('id'), 'sig'=>\Fc2blog\Web\Session::get('sig'))); ?>" class="btn_contents touch"
           onclick="return confirm('<?php echo __('If the child category exists\nRemove all along with the child category, but do you really want?'); ?>');"><i class="delete_icon btn_icon"></i><?php echo __('Delete'); ?></a>
      </li>
    <?php endif; ?>
  </ul>
</div>

