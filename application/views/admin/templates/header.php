<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>CI Gallery</title>

    <!-- Bootstrap -->
    <link href="<?= base_url('asset/bootstrap-3.3.6-dist/css/bootstrap.min.css')?>" rel="stylesheet">

    <!-- Datepicker -->
    <link href="<?= base_url('asset/bootstrap-datepicker/bootstrap-datepicker.css')?>" rel="stylesheet">

    <!-- Costum css -->
    <link href="<?= base_url('asset/site/css/main.css')?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <header class="page-header text-center">
        <h2>CI Gallery</h2>
        <small class="text-muted">
          Single user photo gallery web application created using PHP framework
          CodeIgniter and Twitter Bootstrap.
        </small>
      </header>

      <!-- Navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">

          <!-- Check session for logged in user -->
          <?php if ($this->session->userdata('logged_in')): ?>

            <!-- Admin menubar -->
            <ul class="nav navbar-nav">
              <li><?php echo anchor('admin', 'Index'); ?></li>
              <li><?php echo anchor('admin/upload', 'Upload Image'); ?></li>
              <li><?php echo anchor('', 'Go To Site'); ?></li>
            </ul>

            <!-- Logout form -->
            <?=
              form_open(
                'admin/logout',
                'class="navbar-form navbar-right" role="logout"'
              )
            ?>
              <input type="submit" class="btn btn-default" value="Logout"/>
            </form>

          <?php else: ?>

            <?=
              form_open(
                'admin/login',
                'class="navbar-form navbar-right" role="login"'
              )
            ?>
              <div class="form-group">
                <input
                  type="password"
                  name="password"
                  class="form-control"
                  placeholder="Password"
                >
              </div>

              <input type="submit" class="btn btn-default" value="Login"/>
            </form>

          <?php endif ?>
          <!-- End check session -->

        </div>
      </nav>
