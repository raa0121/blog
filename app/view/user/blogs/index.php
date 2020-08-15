<header><h2><?php echo __('List of blogs'); ?></h2></header>

<ul class="blog_list">
  <?php foreach($blogs as $blog): ?>
    <li>
      <a href="<?php echo \Fc2blog\Web\Html::url(array('controller'=>'Entries', 'action'=>'index', 'blog_id'=>$blog['id'])); ?>" target="_blank"><?php echo h($blog['name']); ?></a>
      <p><?php echo h($blog['introduction']); ?></p>
    </li>
  <?php endforeach; ?>
</ul>

<?php $this->display('Common/paging.php', array('paging' => $paging)); ?>

