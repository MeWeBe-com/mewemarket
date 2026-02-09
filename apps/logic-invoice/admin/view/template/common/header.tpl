<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $language_code; ?>">
  <head>
    <title><?php echo $title; ?></title>
    <base href="<?php echo $base; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script type="text/javascript" src="<?php echo $application; ?>vendor/jquery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="<?php echo $application; ?>vendor/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $application; ?>vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $application; ?>vendor/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" />
    <?php foreach ($scripts as $script) { ?>
    <script type="text/javascript" src="<?php echo $script; ?>"></script>
    <?php } ?>
    <?php foreach ($styles as $style) { ?>
    <link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
    <?php } ?>
	<script type="text/javascript" src="view/javascript/system.js"></script>
  </head>
  <body>
    <?php if ($logged) { ?>
    <header id="header">
		<h4 style="color:#fff;margin-left: 45px;margin-top: 10px;">Accounts</h4>
      <ul class="nav pull-right">

        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><?php echo $username; ?></a>
          <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="<?php echo $logout; ?>"><i class="fa fa-sign-out"></i> <?php echo $text_logout; ?></a></li>
          </ul>
        </li>
      </ul>
    </header>
    <nav id="column-left" role="navigation">
      <ul id="menu">
        <li><a href="<?php echo $dashboard; ?>"><i class="fa fa-dashboard fa-fw"></i> <span><?php echo $text_dashboard; ?></span></a></li>
        <li><a class="parent"><i class="fa fa-book fa-fw"></i> <span><?php echo $text_accounting; ?></span></a>
          <ul>
            <li><a href="<?php echo $account; ?>"><span><?php echo $text_account; ?></span></a></li>
            <li><a href="<?php echo $currency; ?>"><span><?php echo $text_currency; ?></span></a></li>
            <li><a href="<?php echo $inventory; ?>"><span><?php echo $text_inventory; ?></span></a></li>
            <li><a href="<?php echo $journal; ?>"><span><?php echo $text_journal; ?></span></a></li>
            <li><a class="parent"><span><?php echo $text_tax; ?></span></a>
              <ul>
                <li><a href="<?php echo $tax_class; ?>"><span><?php echo $text_tax_class; ?></span></a></li>
                <li><a href="<?php echo $tax_rate; ?>"><span><?php echo $text_tax_rate; ?></span></a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li><a class="parent"><i class="fa fa-usd fa-fw"></i> <span><?php echo $text_billing; ?></span></a>
          <ul>
            <li><a href="<?php echo $customer; ?>"><span><?php echo $text_customer; ?></span></a></li>
            <li><a href="<?php echo $invoice; ?>"><span><?php echo $text_invoice; ?></span></a></li>
            <li><a href="<?php echo $recurring; ?>"><span><?php echo $text_recurring; ?></span></a></li>
          </ul>
        </li>

        <li><a class="parent"><i class="fa fa-line-chart fa-fw"></i> <span><?php echo $text_report; ?></span></a>
          <ul>
            <li><a class="parent"><span><?php echo $text_accounting; ?></span></a>
              <ul>
                <li><a href="<?php echo $chart_of_accounts; ?>"><span><?php echo $text_chart_of_accounts; ?></span></a></li>
                <li><a href="<?php echo $sci; ?>"><span><?php echo $text_sci; ?></span></a></li>
                <li><a href="<?php echo $sfp; ?>"><span><?php echo $text_sfp; ?></span></a></li>
              </ul>
            </li>
            <li><a href="<?php echo $report_invoice; ?>"><span><?php echo $text_invoice; ?></span></a></li>
            <li><a href="<?php echo $report_recurring; ?>"><span><?php echo $text_recurring; ?></span></a></li>
          </ul>
        </li>
        <li><a class="parent"><i class="fa fa-wrench fa-fw"></i> <span><?php echo $text_system; ?></span></a>
          <ul>
            <li><a class="parent"><span><?php echo $text_user; ?></span></a>
              <ul>
                <li><a href="<?php echo $user; ?>"><span><?php echo $text_user; ?></span></a></li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <?php } ?>
    <div id="content" class="container-fluid">
