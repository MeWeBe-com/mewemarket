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
$config_options_delete = new config_options_delete();

// Run the page
$config_options_delete->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_options_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fconfig_optionsdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fconfig_optionsdelete = currentForm = new ew.Form("fconfig_optionsdelete", "delete");
	loadjs.done("fconfig_optionsdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $config_options_delete->showPageHeader(); ?>
<?php
$config_options_delete->showMessage();
?>
<form name="fconfig_optionsdelete" id="fconfig_optionsdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_options">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($config_options_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($config_options_delete->id->Visible) { // id ?>
		<th class="<?php echo $config_options_delete->id->headerCellClass() ?>"><span id="elh_config_options_id" class="config_options_id"><?php echo $config_options_delete->id->caption() ?></span></th>
<?php } ?>
<?php if ($config_options_delete->parent_id->Visible) { // parent_id ?>
		<th class="<?php echo $config_options_delete->parent_id->headerCellClass() ?>"><span id="elh_config_options_parent_id" class="config_options_parent_id"><?php echo $config_options_delete->parent_id->caption() ?></span></th>
<?php } ?>
<?php if ($config_options_delete->role->Visible) { // role ?>
		<th class="<?php echo $config_options_delete->role->headerCellClass() ?>"><span id="elh_config_options_role" class="config_options_role"><?php echo $config_options_delete->role->caption() ?></span></th>
<?php } ?>
<?php if ($config_options_delete->name->Visible) { // name ?>
		<th class="<?php echo $config_options_delete->name->headerCellClass() ?>"><span id="elh_config_options_name" class="config_options_name"><?php echo $config_options_delete->name->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$config_options_delete->RecordCount = 0;
$i = 0;
while (!$config_options_delete->Recordset->EOF) {
	$config_options_delete->RecordCount++;
	$config_options_delete->RowCount++;

	// Set row properties
	$config_options->resetAttributes();
	$config_options->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$config_options_delete->loadRowValues($config_options_delete->Recordset);

	// Render row
	$config_options_delete->renderRow();
?>
	<tr <?php echo $config_options->rowAttributes() ?>>
<?php if ($config_options_delete->id->Visible) { // id ?>
		<td <?php echo $config_options_delete->id->cellAttributes() ?>>
<span id="el<?php echo $config_options_delete->RowCount ?>_config_options_id" class="config_options_id">
<span<?php echo $config_options_delete->id->viewAttributes() ?>><?php echo $config_options_delete->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_options_delete->parent_id->Visible) { // parent_id ?>
		<td <?php echo $config_options_delete->parent_id->cellAttributes() ?>>
<span id="el<?php echo $config_options_delete->RowCount ?>_config_options_parent_id" class="config_options_parent_id">
<span<?php echo $config_options_delete->parent_id->viewAttributes() ?>><?php echo $config_options_delete->parent_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_options_delete->role->Visible) { // role ?>
		<td <?php echo $config_options_delete->role->cellAttributes() ?>>
<span id="el<?php echo $config_options_delete->RowCount ?>_config_options_role" class="config_options_role">
<span<?php echo $config_options_delete->role->viewAttributes() ?>><?php echo $config_options_delete->role->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_options_delete->name->Visible) { // name ?>
		<td <?php echo $config_options_delete->name->cellAttributes() ?>>
<span id="el<?php echo $config_options_delete->RowCount ?>_config_options_name" class="config_options_name">
<span<?php echo $config_options_delete->name->viewAttributes() ?>><?php echo $config_options_delete->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$config_options_delete->Recordset->moveNext();
}
$config_options_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $config_options_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$config_options_delete->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php include_once "footer.php"; ?>
<?php
$config_options_delete->terminate();
?>