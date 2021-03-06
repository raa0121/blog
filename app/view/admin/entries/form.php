
<table>
  <tbody>
    <tr>
      <th><?php echo __('Title'); ?></th>
      <td>
        <?php echo \Fc2blog\Web\Html::input('entry[title]', 'text'); ?>
        <?php if (isset($errors['entry']['title'])): ?><p class="error"><?php echo $errors['entry']['title']; ?></p><?php endif; ?>
      </td>
    </tr>
  </tbody>
</table>

  <h3><?php echo __('Body'); ?></h3>
  <div>
    <?php echo \Fc2blog\Web\Html::input('entry[body]', 'textarea', array('id'=>'sys-entry-body')); ?>
    <?php if (isset($errors['entry']['body'])): ?><p class="error"><?php echo $errors['entry']['body']; ?></p><?php endif; ?>
  </div>

  <h3 class="accordion_head" id="sys-accordion-extend"><?php echo __('Edit a postscript'); ?><span>▼<?php echo __('Click to open/close'); ?></span></h3>
  <div <?php if(\Fc2blog\Web\Cookie::get('js_entry_hide_extend')){echo 'style="visibility: hidden;"';} ?>>
    <?php echo \Fc2blog\Web\Html::input('entry[extend]', 'textarea', array('id'=>'sys-entry-extend')); ?>
    <?php if (isset($errors['entry']['extend'])): ?><p class="error"><?php echo $errors['entry']['extend']; ?></p><?php endif; ?>
  </div>

  <h3 class="accordion_head" id="sys-accordion-setting"><?php echo __('Entry settings'); ?><span>▼<?php echo __('Click to open/close'); ?></span></h3>
  <div <?php if(\Fc2blog\Web\Cookie::get('js_entry_hide_setting')){echo 'style="display: none;"';} ?>>

    <?php $this->display('Categories/ajax_add.php', array()); ?>

    <table>
      <tbody>
        <tr>
          <th><?php echo __('User tags'); ?></th>
          <td>
            <input type="text" id="sys-add-tag-text" />
            <input type="button" value="<?php echo __('Add'); ?>" id="sys-add-tag-button" />
            <ul id="sys-add-tags"></ul>
            <ul id="sys-use-well-tags">
            <?php $tags = \Fc2blog\Model\Model::load('Tags')->getWellUsedTags($this->getBlogId()); ?>
            <?php foreach($tags as $key => $tag): ?><li><?php echo h($tag); ?></li><?php endforeach; ?>
            </ul>
          </td>
        </tr>
      </tbody>
    </table>

    <table>
      <tbody>
        <tr>
          <th><?php echo __('Date and time'); ?></th>
          <td>
            <?php echo \Fc2blog\Web\Html::input('entry[posted_at]', 'text', array('class'=>'date-time-picker')); ?>
            <?php echo __('Date and time of submission will be set when it is not input'); ?><br />
            <?php if (isset($errors['entry']['posted_at'])): ?><p class="error"><?php echo $errors['entry']['posted_at']; ?></p><?php endif; ?>
          </td>
        </tr>
        <tr>
          <th><?php echo __('Post type'); ?></th>
          <td>
            <?php echo \Fc2blog\Web\Html::input('entry[open_status]', 'radio', array('options'=>\Fc2blog\Model\EntriesModel::getOpenStatusList(), 'default'=>\Fc2blog\Config::get('ENTRY.OPEN_STATUS.OPEN'))); ?>
            <?php if (isset($errors['entry']['open_status'])): ?><p class="error"><?php echo $errors['entry']['open_status']; ?></p><?php endif; ?>
          </td>
        </tr>
        <tr>
          <th class="sys-entry-password"><?php echo __('Set Password'); ?></th>
          <td class="sys-entry-password">
            <?php echo \Fc2blog\Web\Html::input('entry[password]', 'text'); ?>
            <?php if (isset($errors['entry']['password'])): ?><p class="error"><?php echo $errors['entry']['password']; ?></p><?php endif; ?>
            <p>
              <?php echo __('They are authenticated with a password of the entire If empty');  ?><br />
              <a href="<?php echo \Fc2blog\Web\Html::url(array('controller'=>'BlogSettings', 'action'=>'entry_edit')); ?>" target="_blank"><?php echo __('Passwords in the whole place'); ?></a><br />
            </p>
          </td>
        </tr>
      </tbody>
    </table>

    <table>
      <tbody>
        <tr>
          <th><?php echo __('New paragraph'); ?></th>
          <td>
            <?php echo \Fc2blog\Web\Html::input('entry[auto_linefeed]', 'radio', array('options'=>\Fc2blog\Model\EntriesModel::getAutoLinefeedList(), 'default'=>\Fc2blog\Config::get('ENTRY.AUTO_LINEFEED.USE'))); ?>
            <?php if (isset($errors['entry']['auto_linefeed'])): ?><p class="error"><?php echo $errors['entry']['auto_linefeed']; ?></p><?php endif; ?>
          </td>
        </tr>
        <tr>
          <th><?php echo __('Accept comments'); ?></th>
          <td>
            <?php echo \Fc2blog\Web\Html::input('entry[comment_accepted]', 'radio', array('options'=>\Fc2blog\Model\EntriesModel::getCommentAcceptedList(), 'default'=>\Fc2blog\Config::get('ENTRY.COMMENT_ACCEPTED.ACCEPTED'))); ?>
            <?php if (isset($errors['entry']['comment_accepted'])): ?><p class="error"><?php echo $errors['entry']['comment_accepted']; ?></p><?php endif; ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

<p class="form-button">
  <input type="submit" value="<?php echo __('Save this entry'); ?>" id="sys-entry-form-submit" />
  <input type="button" value="<?php echo __('Preview'); ?>" id="sys-entry-form-preview" />
</p>

<?php $this->display('Entries/editor_js.php', array()); ?>

