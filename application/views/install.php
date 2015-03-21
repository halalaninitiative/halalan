<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Halalan Installer</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('public/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="<?php echo base_url('public/css/bootstrap-theme.min.css'); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <style>
      /* Space out content a bit */
      body {
        padding-top: 20px;
        padding-bottom: 20px;
      }

      /* Everything but the jumbotron gets side spacing for mobile first views */
      .header,
      .marketing,
      .footer {
        padding-right: 15px;
        padding-left: 15px;
      }

      /* Custom page header */
      .header {
        border-bottom: 1px solid #e5e5e5;
      }
      /* Make the masthead heading the same height as the navigation */
      .header h3 {
        padding-bottom: 19px;
        margin-top: 0;
        margin-bottom: 0;
        line-height: 40px;
      }

      /* Custom page footer */
      .footer {
        padding-top: 19px;
        color: #777;
        border-top: 1px solid #e5e5e5;
      }

      /* Customize container */
      @media (min-width: 768px) {
        .container {
          max-width: 730px;
        }
      }
      .container-narrow > hr {
        margin: 30px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        text-align: center;
        border-bottom: 1px solid #e5e5e5;
      }
      .jumbotron .btn {
        padding: 14px 24px;
        font-size: 21px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 40px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }

      /* Responsive: Portrait tablets and up */
      @media screen and (min-width: 768px) {
        /* Remove the padding we set earlier */
        .header,
        .marketing,
        .footer {
          padding-right: 0;
          padding-left: 0;
        }
        /* Space out the masthead */
        .header {
          margin-bottom: 30px;
        }
        /* Remove the bottom border on the jumbotron for visual effect */
        .jumbotron {
          border-bottom: 0;
        }
      }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo base_url('public/js/html5shiv.min.js'); ?>"></script>
      <script src="<?php echo base_url('public/js/respond.min.js'); ?>"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="header">
        <h3 class="text-muted">Halalan Installer</h3>
      </div>

      <div class="row marketing">
        <div class="col-sm-12">
<?php if ($installed): ?>
          <?php echo alert('', array('success', '<strong>Well done!</strong> Halalan was successfully installed.')); ?>
          <?php echo alert('', array('info', '<strong>Heads up!</strong> Remove application/controllers/install.php before proceeding.')); ?>
<?php else: ?>
          <?php echo alert(validation_errors()); ?>
          <?php echo form_open('install', 'class="form-horizontal"'); ?>
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
            <?php echo form_group(6,
              form_password('passconf', '', 'class="form-control" id="passconf"'),
              form_label('Confirm Password', 'passconf', array('class'=>'col-sm-3 control-label')),
              form_error('passconf', '<span class="help-block">', '</span>')
            ); ?>
            <?php echo form_group(6,
              form_input('last_name', set_value('last_name'), 'class="form-control" id="last_name"'),
              form_label('Last Name', 'last_name', array('class'=>'col-sm-3 control-label')),
              form_error('last_name', '<span class="help-block">', '</span>')
            ); ?>
            <?php echo form_group(6,
              form_input('first_name', set_value('first_name'), 'class="form-control" id="first_name"'),
              form_label('First Name', 'first_name', array('class'=>'col-sm-3 control-label')),
              form_error('first_name', '<span class="help-block">', '</span>')
            ); ?>
            <?php echo form_group(6,
              form_input('email', set_value('email'), 'class="form-control" id="email"'),
              form_label('Email', 'email', array('class'=>'col-sm-3 control-label')),
              form_error('email', '<span class="help-block">', '</span>')
            ); ?>
            <?php echo form_group(9,
              form_button(array('type'=>'submit', 'content'=>'Install', 'class'=>'btn btn-default'))
            ); ?>
          <?php echo form_close(); ?>
<?php endif; ?>
        </div>
      </div>

      <div class="footer">
        <p>Powered by Halalan</p>
      </div>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url('public/js/ie10-viewport-bug-workaround.js'); ?>"></script>
  </body>
</html>
