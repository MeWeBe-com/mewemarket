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
$doctor_uploads_delete = new doctor_uploads_delete();

// Run the page
$doctor_uploads_delete->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$doctor_uploads_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fdoctor_uploadsdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fdoctor_uploadsdelete = currentForm = new ew.Form("fdoctor_uploadsdelete", "delete");
	loadjs.done("fdoctor_uploadsdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $doctor_uploads_delete->showPageHeader(); ?>
<?php
$doctor_uploads_delete->showMessage();
?>
<form name="fdoctor_uploadsdelete" id="fdoctor_uploadsdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="doctor_uploads">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($doctor_uploads_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($doctor_uploads_delete->doctor_upload_id->Visible) { // doctor_upload_id ?>
		<th class="<?php echo $doctor_uploads_delete->doctor_upload_id->headerCellClass() ?>"><span id="elh_doctor_uploads_doctor_upload_id" class="doctor_uploads_doctor_upload_id"><?php echo $doctor_uploads_delete->doctor_upload_id->caption() ?></span></th>
<?php } ?>
<?php if ($doctor_uploads_delete->doctor_id->Visible) { // doctor_id ?>
		<th class="<?php echo $doctor_uploads_delete->doctor_id->headerCellClass() ?>"><span id="elh_doctor_uploads_doctor_id" class="doctor_uploads_doctor_id"><?php echo $doctor_uploads_delete->doctor_id->caption() ?></span></th>
<?php } ?>
<?php if ($doctor_uploads_delete->filename->Visible) { // filename ?>
		<th class="<?php echo $doctor_uploads_delete->filename->headerCellClass() ?>"><span id="elh_doctor_uploads_filename" class="doctor_uploads_filename"><?php echo $doctor_uploads_delete->filename->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$doctor_uploads_delete->RecordCount = 0;
$i = 0;
while (!$doctor_uploads_delete->Recordset->EOF) {
	$doctor_uploads_delete->RecordCount++;
	$doctor_uploads_delete->RowCount++;

	// Set row properties
	$doctor_uploads->resetAttributes();
	$doctor_uploads->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$doctor_uploads_delete->loadRowValues($doctor_uploads_delete->Recordset);

	// Render row
	$doctor_uploads_delete->renderRow();
?>
	<tr <?php echo $doctor_uploads->rowAttributes() ?>>
<?php if ($doctor_uploads_delete->doctor_upload_id->Visible) { // doctor_upload_id ?>
		<td <?php echo $doctor_uploads_delete->doctor_upload_id->cellAttributes() ?>>
<span id="el<?php echo $doctor_uploads_delete->RowCount ?>_doctor_uploads_doctor_upload_id" class="doctor_uploads_doctor_upload_id">
<span<?php echo $doctor_uploads_delete->doctor_upload_id->viewAttributes() ?>><?php echo $doctor_uploads_delete->doctor_upload_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($doctor_uploads_delete->doctor_id->Visible) { // doctor_id ?>
		<td <?php echo $doctor_uploads_delete->doctor_id->cellAttributes() ?>>
<span id="el<?php echo $doctor_uploads_delete->RowCount ?>_doctor_uploads_doctor_id" class="doctor_uploads_doctor_id">
<span<?php echo $doctor_uploads_delete->doctor_id->viewAttributes() ?>><?php echo $doctor_uploads_delete->doctor_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($doctor_uploads_delete->filename->Visible) { // filename ?>
		<td <?php echo $doctor_uploads_delete->filename->cellAttributes() ?>>
<span id="el<?php echo $doctor_uploads_delete->RowCount ?>_doctor_uploads_filename" class="doctor_uploads_filename">
<span<?php echo $doctor_uploads_delete->filename->viewAttributes() ?>><?php echo $doctor_uploads_delete->filename->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$doctor_uploads_delete->Recordset->moveNext();
}
$doctor_uploads_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $doctor_uploads_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$doctor_uploads_delete->showPageFooter();
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
$doctor_uploads_delete->terminate();
?>