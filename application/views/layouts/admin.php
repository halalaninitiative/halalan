<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php //<link rel="icon" href="../../favicon.ico"> ?>

    <title><?php echo $title; ?> - Admin - Halalan</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('public/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/css/bootstrap-theme.min.css'); ?>" rel="stylesheet">
    <style>
      body {
        padding-top: 70px;
      }
      .nav-admin {
        margin-bottom: 10px;
      }
      .table > thead > tr > th {
        background-color: #333;
        color: #fff;
      }
      .table > thead > tr > th, .table > tbody > tr > td {
        vertical-align: middle;
      }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo base_url('public/js/html5shiv.min.js'); ?>"></script>
      <script src="<?php echo base_url('public/js/respond.min.js'); ?>></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <?php echo anchor('admin/dashboard', 'Halalan', 'class="navbar-brand"'); ?>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><?php echo anchor('admin/dashboard', 'Dashboard'); ?></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><?php echo anchor('admin/admins', 'Admins'); ?></li>
                <li><?php echo anchor('admin/events', 'Events'); ?></li>
                <li class="divider"></li>
                <li><?php echo anchor('admin/elections', 'Elections'); ?></li>
                <li><?php echo anchor('admin/parties', 'Parties'); ?></li>
                <li class="divider"></li>
                <li><?php echo anchor('admin/positions', 'Positions'); ?></li>
		<li><?php echo anchor('admin/candidates', 'Candidates'); ?></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?php echo $this->session->userdata('admin')['username']; ?>
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><?php echo anchor('gate/logout', 'Sign Out'); ?></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
      <?php echo $body; ?>
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('public/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('public/js/bootstrap.min.js'); ?>"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url('public/js/ie10-viewport-bug-workaround.js'); ?>"></script>
  </body>
</html>
