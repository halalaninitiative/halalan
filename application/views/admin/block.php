<h1>Manage blocks <small>Election: <?php echo $this->session->userdata('manage_election_election'); ?></small></h1>
<ul class="nav nav-pills nav-admin">
  <li><?php echo anchor('admin/blocks', '<span class="glyphicon glyphicon-list"></span> List all'); ?></li>
  <li<?php echo $action == 'add' ? ' class="active"' : ''; ?>><?php echo anchor('admin/blocks/add', '<span class="glyphicon glyphicon-plus"></span> Add new'); ?></li>
  <?php if ($action == 'edit'): ?>
  <li class="active"><?php echo anchor('admin/blocks/edit/' . $block['id'], '<span class="glyphicon glyphicon-pencil"></span> Edit block'); ?></li>
  <?php endif; ?>
</ul>
<?php echo alert(validation_errors('&nbsp;', '<br />'), $this->session->flashdata('messages')); ?>
<?php echo form_open('', 'class="form-horizontal"'); ?>
  <?php echo form_group(4,
    form_input('block', set_value('block', $block['block']), 'class="form-control" id="block"'),
    form_label('Block', 'block', array('class' => 'col-sm-2 control-label')),
    form_error('block', '<span class="help-block">', '</span>')
  ); ?>
  <?php echo form_group(4,
    form_textarea('description', set_value('description', $block['description']), 'class="form-control" id="description"'),
    form_label('Description', 'description', array('class' => 'col-sm-2 control-label')),
    form_error('description', '<span class="help-block">', '</span>')
  ); ?>
  <?php echo form_group(10,
    form_button(array('type'=>'submit', 'content' => ucfirst($action) . ' block', 'class'=>'btn btn-default'))
  ); ?>
<?php echo form_close(); ?>
