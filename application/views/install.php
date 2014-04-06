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

      /* Supporting marketing content */
      .marketing {
        margin: 40px 0;
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
      }
    </style>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
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
          <?php echo alert('', array('info', '<strong>Heads up!</strong> Copy the following settings to application/config/halalan.php before proceeding.')); ?>
          <form>
            <textarea class="form-control" rows="20" readonly="readonly">
<?php echo '<?php '?> if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['halalan']['password_pin_generation'] = "<?php echo $password_pin_generation; ?>";
$config['halalan']['password_pin_characters'] = "<?php echo $password_pin_characters; ?>";
$config['halalan']['password_length'] = <?php echo $password_length; ?>;
$config['halalan']['pin'] = <?php echo $pin; ?>;
$config['halalan']['pin_length'] = <?php echo $pin_length; ?>;
$config['halalan']['captcha'] = <?php echo $captcha; ?>;
$config['halalan']['captcha_length'] = <?php echo $captcha_length; ?>;
$config['halalan']['generate_image_trail'] = <?php echo $image_trail; ?>;
$config['halalan']['image_trail_path'] = "<?php echo $image_trail_path; ?>";
$config['halalan']['show_candidate_details'] = <?php echo $details; ?>;

$config['encryption_key'] = "<?php echo $encryption_key; ?>";

/* End of file halalan.php */
/* Location: ./application/config/halalan.php */
            </textarea>
          </form>
<?php else: ?>
          <?php echo alert(validation_errors()); ?>
          <?php echo form_open('install', 'class="form-horizontal"'); ?>
            <fieldset>
              <legend>Administrator Settings</legend>
              <?php echo form_group(8,
                form_input('username', set_value('username'), 'class="form-control" id="username"'),
                form_label('Username', 'username', array('class'=>'col-sm-4 control-label')),
                form_error('username', '<span class="help-block">', '</span>')
              ); ?>
              <?php echo form_group(8,
                form_password('password', '', 'class="form-control" id="password"'),
                form_label('Password', 'password', array('class'=>'col-sm-4 control-label')),
                form_error('password', '<span class="help-block">', '</span>')
              ); ?>
              <?php echo form_group(8,
                form_password('passconf', '', 'class="form-control" id="passconf"'),
                form_label('Confirm Password', 'passconf', array('class'=>'col-sm-4 control-label')),
                form_error('passconf', '<span class="help-block">', '</span>')
              ); ?>
              <?php echo form_group(8,
                form_input('first_name', set_value('first_name'), 'class="form-control" id="first_name"'),
                form_label('First Name', 'first_name', array('class'=>'col-sm-4 control-label')),
                form_error('first_name', '<span class="help-block">', '</span>')
              ); ?>
              <?php echo form_group(8,
                form_input('last_name', set_value('last_name'), 'class="form-control" id="last_name"'),
                form_label('Last Name', 'last_name', array('class'=>'col-sm-4 control-label')),
                form_error('last_name', '<span class="help-block">', '</span>')
              ); ?>
              <?php echo form_group(8,
                form_input('email', set_value('email'), 'class="form-control" id="email"'),
                form_label('Email', 'email', array('class'=>'col-sm-4 control-label')),
                form_error('email', '<span class="help-block">', '</span>')
              ); ?>
            </fieldset>
            <fieldset>
              <legend>Halalan Settings</legend>
              <?php echo form_group(8,
                form_dropdown('password_pin_generation', array('web'=>'Web', 'email'=>'Email'), set_value('password_pin_generation', 'web'), 'id="password_pin_generation"'),
                form_label('Password/PIN Generation', 'password_pin_generation', array('class'=>'col-sm-4 control-label'))
              ); ?>
              <?php echo form_group(8,
                form_dropdown('password_pin_characters', array('alnum'=>'Alphanumeric', 'numeric'=>'Numeric', 'nozero'=>'No Zero'), set_value('password_pin_characters', 'alnum'), 'id="password_pin_characters"'),
                form_label('Password/PIN Characters', 'password_pin_characters', array('class'=>'col-sm-4 control-label'))
              ); ?>
              <?php echo form_group(8,
                form_dropdown('password_length', array_combine(range(4, 10), range(4, 10)), set_value('password_length', '6'), 'id="password_length"'),
                form_label('Password Length', 'password_length', array('class'=>'col-sm-4 control-label'))
              ); ?>
              <?php echo form_group(8,
                form_checkbox('pin', 'yes', set_value('pin', 'yes') == 'yes' ? TRUE : FALSE, 'id="pin"') . ' Use PIN in ballot validation?',
                form_label('PIN', 'pin', array('class'=>'col-sm-4 control-label'))
              ); ?>
              <?php echo form_group(8,
                form_dropdown('pin_length', array_combine(range(4, 10), range(4, 10)), set_value('pin_length', '6'), 'id="pin_length"'),
                form_label('PIN Length', 'pin_length', array('class'=>'col-sm-4 control-label'))
              ); ?>
              <?php echo form_group(8,
                form_checkbox('captcha', 'yes', set_value('captcha', 'yes') == 'yes' ? TRUE : FALSE, 'id="captcha"') . ' Use CAPTCHA in ballot validation?',
                form_label('CAPTCHA', 'captcha', array('class'=>'col-sm-4 control-label'))
              ); ?>
              <?php echo form_group(8,
                form_dropdown('captcha_length', array_combine(range(4, 10), range(4, 10)), set_value('captcha_length', '6'), 'id="captcha_length"'),
                form_label('CAPTCHA Length', 'captcha_length', array('class'=>'col-sm-4 control-label'))
              ); ?>
              <?php echo form_group(8,
                form_checkbox('image_trail', 'yes', set_value('image_trail', 'no') == 'yes' ? TRUE : FALSE, 'id="image_trail"') . ' Generate virtual paper trail (image)?',
                form_label('Virtual Paper Trail', 'image_trail', array('class'=>'col-sm-4 control-label'))
              ); ?>
              <?php echo form_group(8,
                form_input('image_trail_path', '', 'class="form-control" id="image_trail_path" placeholder="/trails/"'),
                form_label('Virtual Paper Trail Path', 'image_trail_path', array('class'=>'col-sm-4 control-label')),
                form_error('image_trail_path', '<span class="help-block">', '</span>')
              ); ?>
              <?php echo form_group(8,
                form_checkbox('details', 'yes', set_value('details', 'yes') == 'yes' ? TRUE : FALSE, 'id="details"') . ' Show candidate details in ballot?',
                form_label('Candidate Details', 'details', array('class'=>'col-sm-4 control-label'))
              ); ?>
            </fieldset>
            <fieldset>
              <legend></legend>
              <?php echo form_group(8,
                form_button(array('type'=>'submit', 'content'=>'Install', 'class'=>'btn btn-default'))
              ); ?>
            </fieldset>
          <?php echo form_close(); ?>
<?php endif; ?>
        </div>
      </div>

      <div class="footer">
        <p>Powered by Halalan</p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
