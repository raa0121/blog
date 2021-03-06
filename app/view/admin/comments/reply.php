<header><h2 class="editor_title"><?php echo __('Details of comment'); ?></h2></header>

<table><tbody>
  <tr>
    <th><?php echo __('Article name'); ?></th>
    <td><a href="<?php echo \Fc2blog\App::userURL(array('controller'=>'entries', 'action'=>'view', 'blog_id'=>$comment['blog_id'], 'id'=>$comment['entry_id'])); ?>" target="_blank"><?php echo $comment['entry_title']; ?></a></td>
  </tr>
  <tr>
    <th><?php echo __('Contributor'); ?></th>
    <td><?php echo $comment['name']; ?></td>
  </tr>
  <tr>
    <th><?php echo __('Title'); ?></th>
    <td><?php echo $comment['title']; ?></td>
  </tr>
  <tr>
    <th><?php echo __('Body'); ?></th>
    <td><?php echo nl2br(h($comment['body'])); ?></td>
  </tr>
  <?php if(!empty($comment['mail'])): ?>
  <tr>
    <th><?php echo __('E-mail address'); ?></th>
    <td><?php echo $comment['mail']; ?></td>
  </tr>
  <?php endif; ?>
  <?php if (!empty($comment['url'])) : ?>
  <tr>
    <th>URL</th>
    <td><a href="<?php echo $comment['url']; ?>" target="_blank"><?php echo $comment['url']; ?></a></td>
  </tr>
  <?php endif; ?>
  <tr>
    <th><?php echo __('Public state'); ?></th>
    <td id="sys-open-status">
      <?php if ($comment['open_status']==\Fc2blog\Config::get('COMMENT.OPEN_STATUS.PUBLIC')) : ?>
        <?php echo __('Published'); ?>
      <?php elseif ($comment['open_status']==\Fc2blog\Config::get('COMMENT.OPEN_STATUS.PENDING')) : ?>
        <?php echo __('Approval pending'); ?>
      <?php elseif ($comment['open_status']==\Fc2blog\Config::get('COMMENT.OPEN_STATUS.PRIVATE')) : ?>
        <?php echo __('Only exposed administrator'); ?>
      <?php endif; ?>
    </td>
  </tr>
  <tr>
    <th><?php echo __('Updated date'); ?></th>
    <td><?php echo df($comment['updated_at']); ?></td>
  </tr>
  <?php if ($comment['reply_status']==\Fc2blog\Config::get('COMMENT.REPLY_STATUS.REPLY')) : ?>
  <tr>
    <th><?php echo __('Response time'); ?></th>
    <td><?php echo df($comment['reply_updated_at']); ?></td>
  </tr>
  <?php endif; ?>
</tbody></table>

<?php if ($comment['open_status']==\Fc2blog\Config::get('COMMENT.OPEN_STATUS.PENDING')) : ?>
  <h3><?php echo __('I moderate comments'); ?></h3>
  <a href="<?php echo \Fc2blog\Web\Html::url(array('action'=>'approval', 'id'=>$comment['id'], 'back_url'=>ue($request->get('back_url')))); ?>"
     onclick="return confirm('<?php echo __('Are you sure you want to be approved?'); ?>');"><?php echo __('Approval'); ?></a>
<?php endif; ?>

<?php if ($comment['open_status']!=\Fc2blog\Config::get('COMMENT.OPEN_STATUS.PRIVATE')) : ?>
  <h3><?php echo __('I will reply to comments'); ?></h3>
  <form method="POST" id="sys-comment-form" class="admin-form">
    <?php echo \Fc2blog\Web\Html::input('back_url', 'hidden', array('default'=>$request->get('back_url'))); ?>
    <?php echo \Fc2blog\Web\Html::input('comment[reply_body]', 'textarea', array('style'=>'width: 95%; height: 200px;')); ?>
    <?php if (isset($errors['comment']['reply_body'])): ?><p class="error"><?php echo $errors['comment']['reply_body']; ?></p><?php endif; ?>
    <p class="mb20">
      <?php if($comment['reply_status']==\Fc2blog\Config::get('COMMENT.REPLY_STATUS.REPLY')): ?>
        <input type="submit" value="<?php echo __('Update'); ?>" />
      <?php else: ?>
        <input type="submit" value="<?php echo __('Reply'); ?>" /><br />
        <?php if($comment['open_status']==\Fc2blog\Config::get('COMMENT.OPEN_STATUS.PENDING')): ?>
          ※<?php echo __('When you press the reply button, the message will be approved'); ?>
        <?php endif; ?>
      <?php endif; ?>
    </p>
  </form>
<?php endif; ?>

<h3><?php echo __('Delete Comment'); ?></h3>
<div id="comment_dell" class="mb20">
  <p class="mb10"><?php echo __('You can delete a comment by pressing the button below.'); ?></p>
  <a class="admin_common_btn dell_btn" href="<?php echo \Fc2blog\Web\Html::url(array('action'=>'delete', 'id'=>$comment['id'], 'back_url'=>ue($request->get('back_url')))); ?>" onclick="return confirm('<?php echo __('Are you sure you want to delete?'); ?>');"><?php echo __('Delete'); ?></a>
</div>

