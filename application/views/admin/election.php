<h1>Manage elections</h1>
<ul class="nav nav-pills nav-admin">
  <li><?php echo anchor('admin/elections', '<span class="glyphicon glyphicon-list"></span> List all'); ?></li>
  <li<?php echo $action == 'add' ? ' class="active"' : ''; ?>><?php echo anchor('admin/elections/add', '<span class="glyphicon glyphicon-plus"></span> Add new'); ?></li>
  <?php if ($action == 'edit'): ?>
  <li class="active"><?php echo anchor('admin/elections/edit/' . $election['id'], '<span class="glyphicon glyphicon-pencil"></span> Edit election'); ?></li>
  <?php endif; ?>
</ul>
<?php echo alert(validation_errors('&nbsp;', '<br />'), $this->session->flashdata('messages')); ?>
<?php echo form_open('', 'class="form-horizontal"'); ?>
  <?php echo form_group(4,
    form_input('election', set_value('election', $election['election']), 'class="form-control" id="election"'),
    form_label('Election', 'election', array('class' => 'col-sm-2 control-label')),
    form_error('election', '<span class="help-block">', '</span>')
  ); ?>
  <?php
    $admins = for_dropdown($admins, 'id', 'username', TRUE, $admin_ids);
    if ($action == 'edit' && $admin)
      $admins = $admins + array($admin['id'] => $admin['username']);
  ?>
  <?php echo form_group(4,
    form_dropdown('admin_id', $admins, set_value('admin_id', $election['admin_id']), 'id="admin_id" class="form-control"'),
    form_label('Admin', 'admin_id', array('class' => 'col-sm-2 control-label'))
  ); ?>
  <?php echo form_group(10,
    form_button(array('type'=>'submit', 'content' => ucfirst($action) . ' election', 'class'=>'btn btn-default'))
  ); ?>
<?php echo form_close(); ?>
