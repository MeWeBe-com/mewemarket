<?php
namespace PHPMaker2020\project1;

// Autoload
include_once "autoload.php";

// Session
if (session_status() !== PHP_SESSION_ACTIVE)
	\Delight\Cookie\Session::start(Config("COOKIE_SAMESITE")); // Init session data

// Output buffering
ob_start();
?>
<?php

// Write header
WriteHeader(FALSE);

// Create page object
$config_options_view = new config_options_view();

// Run the page
$config_options_view->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_options_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$config_options_view->isExport()) { ?>
<script>
var fconfig_optionsview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	fconfig_optionsview = currentForm = new ew.Form("fconfig_optionsview", "view");
	loadjs.done("fconfig_optionsview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$config_options_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $config_options_view->ExportOptions->render("body") ?>
<?php $config_options_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $config_options_view->showPageHeader(); ?>
<?php
$config_options_view->showMessage();
?>
<form name="fconfig_optionsview" id="fconfig_optionsview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_options">
<input type="hidden" name="modal" value="<?php echo (int)$config_options_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($config_options_view->id->Visible) { // id ?>
	<tr id="r_id">
		<td class="<?php echo $config_options_view->TableLeftColumnClass ?>"><span id="elh_config_options_id"><?php echo $config_options_view->id->caption() ?></span></td>
		<td data-name="id" <?php echo $config_options_view->id->cellAttributes() ?>>
<span id="el_config_options_id">
<span<?php echo $config_options_view->id->viewAttributes() ?>><?php echo $config_options_view->id->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_options_view->parent_id->Visible) { // parent_id ?>
	<tr id="r_parent_id">
		<td class="<?php echo $config_options_view->TableLeftColumnClass ?>"><span id="elh_config_options_parent_id"><?php echo $config_options_view->parent_id->caption() ?></span></td>
		<td data-name="parent_id" <?php echo $config_options_view->parent_id->cellAttributes() ?>>
<span id="el_config_options_parent_id">
<span<?php echo $config_options_view->parent_id->viewAttributes() ?>><?php echo $config_options_view->parent_id->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_options_view->role->Visible) { // role ?>
	<tr id="r_role">
		<td class="<?php echo $config_options_view->TableLeftColumnClass ?>"><span id="elh_config_options_role"><?php echo $config_options_view->role->caption() ?></span></td>
		<td data-name="role" <?php echo $config_options_view->role->cellAttributes() ?>>
<span id="el_config_options_role">
<span<?php echo $config_options_view->role->viewAttributes() ?>><?php echo $config_options_view->role->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_options_view->name->Visible) { // name ?>
	<tr id="r_name">
		<td class="<?php echo $config_options_view->TableLeftColumnClass ?>"><span id="elh_config_options_name"><?php echo $config_options_view->name->caption() ?></span></td>
		<td data-name="name" <?php echo $config_options_view->name->cellAttributes() ?>>
<span id="el_config_options_name">
<span<?php echo $config_options_view->name->viewAttributes() ?>><?php echo $config_options_view->name->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_options_view->value->Visible) { // value ?>
	<tr id="r_value">
		<td class="<?php echo $config_options_view->TableLeftColumnClass ?>"><span id="elh_config_options_value"><?php echo $config_options_view->value->caption() ?></span></td>
		<td data-name="value" <?php echo $config_options_view->value->cellAttributes() ?>>
<span id="el_config_options_value">
<span<?php echo $config_options_view->value->viewAttributes() ?>><?php echo $config_options_view->value->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$config_options_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$config_options_view->isExport()) { ?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php } ?>
<?php include_once "footer.php"; ?>
<?php
$config_options_view->terminate();
?>