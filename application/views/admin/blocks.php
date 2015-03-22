<h1>Manage blocks <small>Election: <?php echo $this->session->userdata('manage_election_election'); ?></small></h1>
<ul class="nav nav-pills nav-admin">
  <li class="active"><?php echo anchor('admin/blocks', '<span class="glyphicon glyphicon-list"></span> List all'); ?></li>
  <li><?php echo anchor('admin/blocks/add', '<span class="glyphicon glyphicon-plus"></span> Add new'); ?></li>
</ul>
<?php echo alert(validation_errors('&nbsp;', '<br />'), $this->session->flashdata('messages')); ?>
<table class="table table-bordered table-striped table-hover">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>Block</th>
      <th>Descriptionn</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($blocks as $i => $block): ?>
    <tr>
      <td class="text-center"><?php echo $i + 1; ?></td>
      <td><?php echo $block['block']; ?></td>
      <td><?php echo $block['description']; ?></td>
      <td>
        <?php echo anchor('admin/blocks/edit/' . $block['id'], '<span class="glyphicon glyphicon-pencil"></span> Edit', 'class="btn btn-default"'); ?>
        <?php echo anchor('admin/blocks/delete/' . $block['id'], '<span class="glyphicon glyphicon-trash"></span> Delete', 'class="btn btn-danger"'); ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
