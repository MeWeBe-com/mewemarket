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
$admin_uploads_view = new admin_uploads_view();

// Run the page
$admin_uploads_view->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$admin_uploads_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$admin_uploads_view->isExport()) { ?>
<script>
var fadmin_uploadsview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	fadmin_uploadsview = currentForm = new ew.Form("fadmin_uploadsview", "view");
	loadjs.done("fadmin_uploadsview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$admin_uploads_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $admin_uploads_view->ExportOptions->render("body") ?>
<?php $admin_uploads_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $admin_uploads_view->showPageHeader(); ?>
<?php
$admin_uploads_view->showMessage();
?>
<form name="fadmin_uploadsview" id="fadmin_uploadsview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="admin_uploads">
<input type="hidden" name="modal" value="<?php echo (int)$admin_uploads_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($admin_uploads_view->id->Visible) { // id ?>
	<tr id="r_id">
		<td class="<?php echo $admin_uploads_view->TableLeftColumnClass ?>"><span id="elh_admin_uploads_id"><?php echo $admin_uploads_view->id->caption() ?></span></td>
		<td data-name="id" <?php echo $admin_uploads_view->id->cellAttributes() ?>>
<span id="el_admin_uploads_id">
<span<?php echo $admin_uploads_view->id->viewAttributes() ?>><?php echo $admin_uploads_view->id->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($admin_uploads_view->test_id->Visible) { // test_id ?>
	<tr id="r_test_id">
		<td class="<?php echo $admin_uploads_view->TableLeftColumnClass ?>"><span id="elh_admin_uploads_test_id"><?php echo $admin_uploads_view->test_id->caption() ?></span></td>
		<td data-name="test_id" <?php echo $admin_uploads_view->test_id->cellAttributes() ?>>
<span id="el_admin_uploads_test_id">
<span<?php echo $admin_uploads_view->test_id->viewAttributes() ?>><?php echo $admin_uploads_view->test_id->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($admin_uploads_view->upload_file->Visible) { // upload_file ?>
	<tr id="r_upload_file">
		<td class="<?php echo $admin_uploads_view->TableLeftColumnClass ?>"><span id="elh_admin_uploads_upload_file"><?php echo $admin_uploads_view->upload_file->caption() ?></span></td>
		<td data-name="upload_file" <?php echo $admin_uploads_view->upload_file->cellAttributes() ?>>
<span id="el_admin_uploads_upload_file">
<span<?php echo $admin_uploads_view->upload_file->viewAttributes() ?>><?php echo $admin_uploads_view->upload_file->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$admin_uploads_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$admin_uploads_view->isExport()) { ?>
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
$admin_uploads_view->terminate();
?>