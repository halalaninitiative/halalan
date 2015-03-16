<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $title; ?> - Gate - Halalan</title>

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
        <h3 class="text-muted">Halalan</h3>
      </div>

      <div class="row marketing">
        <div class="col-sm-12">
          <?php echo $body; ?>
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
