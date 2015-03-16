<?php echo alert('', $this->session->flashdata('messages')); ?>
<?php echo form_open('', 'class="form-horizontal"'); ?>
  <?php echo form_group(6,
    form_input('username', set_value('username'), 'class="form-control" id="username"'),
    form_label('Username', 'username', array('class'=>'col-sm-3 control-label')),
    form_error('username', '<span class="help-block">', '</span>')
  ); ?>
  <?php echo form_group(6,
    form_password('password', '', 'class="form-control" id="password"'),
    form_label('Password', 'password', array('class'=>'col-sm-3 control-label')),
    form_error('password', '<span class="help-block">', '</span>')
  ); ?>
  <?php echo form_group(9,
    form_button(array('type'=>'submit', 'content'=>'Sign In', 'class'=>'btn btn-default'))
  ); ?>
<?php echo form_close(); ?>
