<h1>Manage parties <small>Event: <?php echo $this->session->userdata('manage_event_event'); ?></small></h1>
<ul class="nav nav-pills nav-admin">
  <li><?php echo anchor('admin/parties', '<span class="glyphicon glyphicon-list"></span> List all'); ?></li>
  <li<?php echo $action == 'add' ? ' class="active"' : ''; ?>><?php echo anchor('admin/parties/add', '<span class="glyphicon glyphicon-plus"></span> Add new'); ?></li>
  <?php if ($action == 'edit'): ?>
  <li class="active"><?php echo anchor('admin/parties/edit/' . $party['id'], '<span class="glyphicon glyphicon-pencil"></span> Edit party'); ?></li>
  <?php endif; ?>
</ul>
<?php echo alert(validation_errors('&nbsp;', '<br />'), $this->session->flashdata('messages')); ?>
<?php echo form_open('', 'class="form-horizontal"'); ?>
  <?php echo form_group(4,
    form_input('party', set_value('party', $party['party']), 'class="form-control" id="party"'),
    form_label('Party', 'party', array('class' => 'col-sm-2 control-label')),
    form_error('party', '<span class="help-block">', '</span>')
  ); ?>
  <?php echo form_group(4,
    form_input('alias', set_value('alias', $party['alias']), 'class="form-control" id="alias"'),
    form_label('Alias', 'alias', array('class' => 'col-sm-2 control-label')),
    form_error('alias', '<span class="help-block">', '</span>')
  ); ?>
  <?php echo form_group(4,
    form_textarea('description', set_value('description', $party['description']), 'class="form-control" id="description"'),
    form_label('Description', 'description', array('class' => 'col-sm-2 control-label')),
    form_error('description', '<span class="help-block">', '</span>')
  ); ?>
  <?php echo form_group(10,
    form_button(array('type'=>'submit', 'content' => ucfirst($action) . ' party', 'class'=>'btn btn-default'))
  ); ?>
<?php echo form_close(); ?>
