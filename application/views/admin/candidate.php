<h1>Manage candidates <small>Election: <?php echo $this->session->userdata('manage_election_election'); ?></small></h1>
<ul class="nav nav-pills nav-admin">
  <li><?php echo anchor('admin/candidates', '<span class="glyphicon glyphicon-list"></span> List all'); ?></li>
  <li<?php echo $action == 'add' ? ' class="active"' : ''; ?>><?php echo anchor('admin/candidates/add', '<span class="glyphicon glyphicon-plus"></span> Add new'); ?></li>
  <?php if ($action == 'edit'): ?>
  <li class="active"><?php echo anchor('admin/candidates/edit/' . $candidate['id'], '<span class="glyphicon glyphicon-pencil"></span> Edit candidate'); ?></li>
  <?php endif; ?>
</ul>
<?php echo alert(validation_errors('&nbsp;', '<br />'), $this->session->flashdata('messages')); ?>
<?php echo form_open('', 'class="form-horizontal"'); ?>
  <?php echo form_group(4,
    form_dropdown('position_id', for_dropdown($positions, 'id', 'position'), set_value('position_id', $candidate['position_id']), 'id="position_id" class="form-control"'),
    form_label('Position', 'position_id', array('class' => 'col-sm-2 control-label')),
    form_error('position_id', '<span class="help-block">', '</span>')
  ); ?>
  <?php echo form_group(4,
    form_input('last_name', set_value('last_name', $candidate['last_name']), 'class="form-control" id="last_name"'),
    form_label('Last name', 'last_name', array('class' => 'col-sm-2 control-label')),
    form_error('last_name', '<span class="help-block">', '</span>')
  ); ?>
  <?php echo form_group(4,
    form_input('first_name', set_value('first_name', $candidate['first_name']), 'class="form-control" id="first_name"'),
    form_label('First name', 'first_name', array('class' => 'col-sm-2 control-label')),
    form_error('first_name', '<span class="help-block">', '</span>')
  ); ?>
  <?php echo form_group(4,
    form_input('alias', set_value('alias', $candidate['alias']), 'class="form-control" id="alias"'),
    form_label('Alias', 'alias', array('class' => 'col-sm-2 control-label'))
  ); ?>
  <?php echo form_group(4,
    form_dropdown('party_id', for_dropdown($parties, 'id', 'party'), set_value('party_id', $candidate['party_id']), 'id="party_id" class="form-control"'),
    form_label('Party', 'party_id', array('class' => 'col-sm-2 control-label'))
  ); ?>
  <?php echo form_group(4,
    form_textarea('description', set_value('description', $candidate['description']), 'class="form-control" id="description"'),
    form_label('Description', 'description', array('class' => 'col-sm-2 control-label'))
  ); ?>
  <?php echo form_group(10,
    form_button(array('type'=>'submit', 'content' => ucfirst($action) . ' candidate', 'class'=>'btn btn-default'))
  ); ?>
<?php echo form_close(); ?>
