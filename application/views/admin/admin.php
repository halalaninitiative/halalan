<h1>Manage admins</h1>
<ul class="nav nav-pills nav-admin">
  <li><?php echo anchor('admin/admins', '<span class="glyphicon glyphicon-list"></span> List all'); ?></li>
  <li<?php echo $action == 'add' ? ' class="active"' : ''; ?>><?php echo anchor('admin/admins/add', '<span class="glyphicon glyphicon-plus"></span> Add new'); ?></li>
  <?php if ($action == 'edit'): ?>
  <li class="active"><?php echo anchor('admin/admins/edit/' . $admin['id'], '<span class="glyphicon glyphicon-pencil"></span> Edit admin'); ?></li>
  <?php endif; ?>
</ul>
<?php echo alert(validation_errors('&nbsp;', '<br />'), $this->session->flashdata('messages')); ?>
<?php echo form_open('', 'class="form-horizontal"'); ?>
  <?php echo form_group(4,
    form_input('username', set_value('username', $admin['username']), 'class="form-control" id="username"'),
    form_label('Username', 'username', array('class' => 'col-sm-2 control-label')),
    form_error('username', '<span class="help-block">', '</span>')
  ); ?>
  <?php echo form_group(4,
    form_input('last_name', set_value('last_name', $admin['last_name']), 'class="form-control" id="last_name"'),
    form_label('Last name', 'last_name', array('class' => 'col-sm-2 control-label')),
    form_error('last_name', '<span class="help-block">', '</span>')
  ); ?>
  <?php echo form_group(4,
    form_input('first_name', set_value('first_name', $admin['first_name']), 'class="form-control" id="first_name"'),
    form_label('First name', 'first_name', array('class' => 'col-sm-2 control-label')),
    form_error('first_name', '<span class="help-block">', '</span>')
  ); ?>
  <?php echo form_group(4,
    form_input('email', set_value('email', $admin['email']), 'class="form-control" id="email"'),
    form_label('Email', 'email', array('class' => 'col-sm-2 control-label')),
    form_error('email', '<span class="help-block">', '</span>')
  ); ?>

  <?php if ($this->session->userdata('admin')['type'] == 'super'): ?>
  <?php echo form_group(4,
    form_dropdown('type', array('super' => 'Super Admin', 'event' => 'Event Admin', 'election' => 'Election Admin'), set_value('type', $admin['type']), 'id="type" class="form-control"'),
    form_label('Type', 'type', array('class' => 'col-sm-2 control-label'))
  ); ?>
  <?php endif; ?>

  <?php if ($action == 'edit'): ?>
  <?php echo form_group(4,
    form_checkbox('regenerate', 'yes', '', 'id="regenerate"') . ' Regenerate password?',
    form_label('', 'regenerate', array('class'=>'col-sm-2 control-label'))
  ); ?>
  <?php endif ;?>

  <?php echo form_group(10,
    form_button(array('type'=>'submit', 'content' => ucfirst($action) . ' admin', 'class'=>'btn btn-default'))
  ); ?>
<?php echo form_close(); ?>
