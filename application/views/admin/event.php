<h1>Manage events</h1>
<ul class="nav nav-pills nav-admin">
  <li><?php echo anchor('admin/events', '<span class="glyphicon glyphicon-list"></span> List all'); ?></li>
  <li<?php echo $action == 'add' ? ' class="active"' : ''; ?>><?php echo anchor('admin/events/add', '<span class="glyphicon glyphicon-plus"></span> Add new'); ?></li>
  <?php if ($action == 'edit'): ?>
  <li class="active"><?php echo anchor('admin/events/edit/' . $event['id'], '<span class="glyphicon glyphicon-pencil"></span> Edit event'); ?></li>
  <?php endif; ?>
</ul>
<?php echo alert(validation_errors('&nbsp;', '<br />'), $this->session->flashdata('messages')); ?>
<?php echo form_open('', 'class="form-horizontal"'); ?>
  <?php echo form_group(4,
    form_input('event', set_value('event', $event['event']), 'class="form-control" id="event"'),
    form_label('Event', 'event', array('class' => 'col-sm-2 control-label')),
    form_error('event', '<span class="help-block">', '</span>')
  ); ?>
  <?php echo form_group(4,
    form_input('slug', set_value('slug', $event['slug']), 'class="form-control" id="slug"'),
    form_label('Slug', 'slug', array('class' => 'col-sm-2 control-label')),
    form_error('slug', '<span class="help-block">', '</span>')
  ); ?>
  <?php echo form_group(10,
    form_button(array('type'=>'submit', 'content' => ucfirst($action) . ' event', 'class'=>'btn btn-default'))
  ); ?>
<?php echo form_close(); ?>
