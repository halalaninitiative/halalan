<h1>Manage positions <small>Election: <?php echo $this->session->userdata('manage_election_election'); ?></small></h1>
<ul class="nav nav-pills nav-admin">
  <li><?php echo anchor('admin/positions', '<span class="glyphicon glyphicon-list"></span> List all'); ?></li>
  <li<?php echo $action == 'add' ? ' class="active"' : ''; ?>><?php echo anchor('admin/positions/add', '<span class="glyphicon glyphicon-plus"></span> Add new'); ?></li>
  <?php if ($action == 'edit'): ?>
  <li class="active"><?php echo anchor('admin/positions/edit/' . $position['id'], '<span class="glyphicon glyphicon-pencil"></span> Edit position'); ?></li>
  <?php endif; ?>
</ul>
<?php echo alert(validation_errors('&nbsp;', '<br />'), $this->session->flashdata('messages')); ?>
<?php echo form_open('', 'class="form-horizontal"'); ?>
  <?php echo form_group(4,
    form_input('position', set_value('position', $position['position']), 'class="form-control" id="position"'),
    form_label('Position', 'position', array('class' => 'col-sm-2 control-label')),
    form_error('position', '<span class="help-block">', '</span>')
  ); ?>
  <?php echo form_group(4,
    form_input('maximum', set_value('maximum', $position['maximum']), 'class="form-control" id="maximum"'),
    form_label('Maximum', 'maximum', array('class' => 'col-sm-2 control-label')),
    form_error('maximum', '<span class="help-block">', '</span>')
  ); ?>
  <?php echo form_group(4,
    form_checkbox('abstain', '1', set_value('abstain', $position['abstain']) == 1 ? TRUE : FALSE, 'id="abstain"'),
    form_label('Abstain', 'abstain', array('class' => 'col-sm-2 control-label'))
  ); ?>
  <?php echo form_group(10,
    form_button(array('type'=>'submit', 'content' => ucfirst($action) . ' position', 'class'=>'btn btn-default'))
  ); ?>
<?php echo form_close(); ?>
