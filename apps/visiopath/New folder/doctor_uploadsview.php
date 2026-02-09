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
$doctor_uploads_view = new doctor_uploads_view();

// Run the page
$doctor_uploads_view->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$doctor_uploads_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$doctor_uploads_view->isExport()) { ?>
<script>
var fdoctor_uploadsview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	fdoctor_uploadsview = currentForm = new ew.Form("fdoctor_uploadsview", "view");
	loadjs.done("fdoctor_uploadsview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$doctor_uploads_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $doctor_uploads_view->ExportOptions->render("body") ?>
<?php $doctor_uploads_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $doctor_uploads_view->showPageHeader(); ?>
<?php
$doctor_uploads_view->showMessage();
?>
<form name="fdoctor_uploadsview" id="fdoctor_uploadsview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="doctor_uploads">
<input type="hidden" name="modal" value="<?php echo (int)$doctor_uploads_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($doctor_uploads_view->doctor_upload_id->Visible) { // doctor_upload_id ?>
	<tr id="r_doctor_upload_id">
		<td class="<?php echo $doctor_uploads_view->TableLeftColumnClass ?>"><span id="elh_doctor_uploads_doctor_upload_id"><?php echo $doctor_uploads_view->doctor_upload_id->caption() ?></span></td>
		<td data-name="doctor_upload_id" <?php echo $doctor_uploads_view->doctor_upload_id->cellAttributes() ?>>
<span id="el_doctor_uploads_doctor_upload_id">
<span<?php echo $doctor_uploads_view->doctor_upload_id->viewAttributes() ?>><?php echo $doctor_uploads_view->doctor_upload_id->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($doctor_uploads_view->doctor_id->Visible) { // doctor_id ?>
	<tr id="r_doctor_id">
		<td class="<?php echo $doctor_uploads_view->TableLeftColumnClass ?>"><span id="elh_doctor_uploads_doctor_id"><?php echo $doctor_uploads_view->doctor_id->caption() ?></span></td>
		<td data-name="doctor_id" <?php echo $doctor_uploads_view->doctor_id->cellAttributes() ?>>
<span id="el_doctor_uploads_doctor_id">
<span<?php echo $doctor_uploads_view->doctor_id->viewAttributes() ?>><?php echo $doctor_uploads_view->doctor_id->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($doctor_uploads_view->filename->Visible) { // filename ?>
	<tr id="r_filename">
		<td class="<?php echo $doctor_uploads_view->TableLeftColumnClass ?>"><span id="elh_doctor_uploads_filename"><?php echo $doctor_uploads_view->filename->caption() ?></span></td>
		<td data-name="filename" <?php echo $doctor_uploads_view->filename->cellAttributes() ?>>
<span id="el_doctor_uploads_filename">
<span<?php echo $doctor_uploads_view->filename->viewAttributes() ?>><?php echo $doctor_uploads_view->filename->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$doctor_uploads_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$doctor_uploads_view->isExport()) { ?>
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
$doctor_uploads_view->terminate();
?>