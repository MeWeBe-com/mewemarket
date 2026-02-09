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
$admin_uploads_delete = new admin_uploads_delete();

// Run the page
$admin_uploads_delete->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$admin_uploads_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fadmin_uploadsdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fadmin_uploadsdelete = currentForm = new ew.Form("fadmin_uploadsdelete", "delete");
	loadjs.done("fadmin_uploadsdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $admin_uploads_delete->showPageHeader(); ?>
<?php
$admin_uploads_delete->showMessage();
?>
<form name="fadmin_uploadsdelete" id="fadmin_uploadsdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="admin_uploads">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($admin_uploads_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($admin_uploads_delete->id->Visible) { // id ?>
		<th class="<?php echo $admin_uploads_delete->id->headerCellClass() ?>"><span id="elh_admin_uploads_id" class="admin_uploads_id"><?php echo $admin_uploads_delete->id->caption() ?></span></th>
<?php } ?>
<?php if ($admin_uploads_delete->test_id->Visible) { // test_id ?>
		<th class="<?php echo $admin_uploads_delete->test_id->headerCellClass() ?>"><span id="elh_admin_uploads_test_id" class="admin_uploads_test_id"><?php echo $admin_uploads_delete->test_id->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$admin_uploads_delete->RecordCount = 0;
$i = 0;
while (!$admin_uploads_delete->Recordset->EOF) {
	$admin_uploads_delete->RecordCount++;
	$admin_uploads_delete->RowCount++;

	// Set row properties
	$admin_uploads->resetAttributes();
	$admin_uploads->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$admin_uploads_delete->loadRowValues($admin_uploads_delete->Recordset);

	// Render row
	$admin_uploads_delete->renderRow();
?>
	<tr <?php echo $admin_uploads->rowAttributes() ?>>
<?php if ($admin_uploads_delete->id->Visible) { // id ?>
		<td <?php echo $admin_uploads_delete->id->cellAttributes() ?>>
<span id="el<?php echo $admin_uploads_delete->RowCount ?>_admin_uploads_id" class="admin_uploads_id">
<span<?php echo $admin_uploads_delete->id->viewAttributes() ?>><?php echo $admin_uploads_delete->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($admin_uploads_delete->test_id->Visible) { // test_id ?>
		<td <?php echo $admin_uploads_delete->test_id->cellAttributes() ?>>
<span id="el<?php echo $admin_uploads_delete->RowCount ?>_admin_uploads_test_id" class="admin_uploads_test_id">
<span<?php echo $admin_uploads_delete->test_id->viewAttributes() ?>><?php echo $admin_uploads_delete->test_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$admin_uploads_delete->Recordset->moveNext();
}
$admin_uploads_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $admin_uploads_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$admin_uploads_delete->showPageFooter();
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
$admin_uploads_delete->terminate();
?>