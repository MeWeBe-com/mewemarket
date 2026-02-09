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
$admin_uploads_list = new admin_uploads_list();

// Run the page
$admin_uploads_list->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$admin_uploads_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$admin_uploads_list->isExport()) { ?>
<script>
var fadmin_uploadslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fadmin_uploadslist = currentForm = new ew.Form("fadmin_uploadslist", "list");
	fadmin_uploadslist.formKeyCountName = '<?php echo $admin_uploads_list->FormKeyCountName ?>';
	loadjs.done("fadmin_uploadslist");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$admin_uploads_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($admin_uploads_list->TotalRecords > 0 && $admin_uploads_list->ExportOptions->visible()) { ?>
<?php $admin_uploads_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($admin_uploads_list->ImportOptions->visible()) { ?>
<?php $admin_uploads_list->ImportOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$admin_uploads_list->renderOtherOptions();
?>
<?php $admin_uploads_list->showPageHeader(); ?>
<?php
$admin_uploads_list->showMessage();
?>
<?php if ($admin_uploads_list->TotalRecords > 0 || $admin_uploads->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($admin_uploads_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> admin_uploads">
<form name="fadmin_uploadslist" id="fadmin_uploadslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="admin_uploads">
<div id="gmp_admin_uploads" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($admin_uploads_list->TotalRecords > 0 || $admin_uploads_list->isGridEdit()) { ?>
<table id="tbl_admin_uploadslist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$admin_uploads->RowType = ROWTYPE_HEADER;

// Render list options
$admin_uploads_list->renderListOptions();

// Render list options (header, left)
$admin_uploads_list->ListOptions->render("header", "left");
?>
<?php if ($admin_uploads_list->id->Visible) { // id ?>
	<?php if ($admin_uploads_list->SortUrl($admin_uploads_list->id) == "") { ?>
		<th data-name="id" class="<?php echo $admin_uploads_list->id->headerCellClass() ?>"><div id="elh_admin_uploads_id" class="admin_uploads_id"><div class="ew-table-header-caption"><?php echo $admin_uploads_list->id->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $admin_uploads_list->id->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $admin_uploads_list->SortUrl($admin_uploads_list->id) ?>', 1);"><div id="elh_admin_uploads_id" class="admin_uploads_id">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $admin_uploads_list->id->caption() ?></span><span class="ew-table-header-sort"><?php if ($admin_uploads_list->id->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($admin_uploads_list->id->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($admin_uploads_list->test_id->Visible) { // test_id ?>
	<?php if ($admin_uploads_list->SortUrl($admin_uploads_list->test_id) == "") { ?>
		<th data-name="test_id" class="<?php echo $admin_uploads_list->test_id->headerCellClass() ?>"><div id="elh_admin_uploads_test_id" class="admin_uploads_test_id"><div class="ew-table-header-caption"><?php echo $admin_uploads_list->test_id->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="test_id" class="<?php echo $admin_uploads_list->test_id->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $admin_uploads_list->SortUrl($admin_uploads_list->test_id) ?>', 1);"><div id="elh_admin_uploads_test_id" class="admin_uploads_test_id">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $admin_uploads_list->test_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($admin_uploads_list->test_id->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($admin_uploads_list->test_id->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$admin_uploads_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($admin_uploads_list->ExportAll && $admin_uploads_list->isExport()) {
	$admin_uploads_list->StopRecord = $admin_uploads_list->TotalRecords;
} else {

	// Set the last record to display
	if ($admin_uploads_list->TotalRecords > $admin_uploads_list->StartRecord + $admin_uploads_list->DisplayRecords - 1)
		$admin_uploads_list->StopRecord = $admin_uploads_list->StartRecord + $admin_uploads_list->DisplayRecords - 1;
	else
		$admin_uploads_list->StopRecord = $admin_uploads_list->TotalRecords;
}
$admin_uploads_list->RecordCount = $admin_uploads_list->StartRecord - 1;
if ($admin_uploads_list->Recordset && !$admin_uploads_list->Recordset->EOF) {
	$admin_uploads_list->Recordset->moveFirst();
	$selectLimit = $admin_uploads_list->UseSelectLimit;
	if (!$selectLimit && $admin_uploads_list->StartRecord > 1)
		$admin_uploads_list->Recordset->move($admin_uploads_list->StartRecord - 1);
} elseif (!$admin_uploads->AllowAddDeleteRow && $admin_uploads_list->StopRecord == 0) {
	$admin_uploads_list->StopRecord = $admin_uploads->GridAddRowCount;
}

// Initialize aggregate
$admin_uploads->RowType = ROWTYPE_AGGREGATEINIT;
$admin_uploads->resetAttributes();
$admin_uploads_list->renderRow();
while ($admin_uploads_list->RecordCount < $admin_uploads_list->StopRecord) {
	$admin_uploads_list->RecordCount++;
	if ($admin_uploads_list->RecordCount >= $admin_uploads_list->StartRecord) {
		$admin_uploads_list->RowCount++;

		// Set up key count
		$admin_uploads_list->KeyCount = $admin_uploads_list->RowIndex;

		// Init row class and style
		$admin_uploads->resetAttributes();
		$admin_uploads->CssClass = "";
		if ($admin_uploads_list->isGridAdd()) {
		} else {
			$admin_uploads_list->loadRowValues($admin_uploads_list->Recordset); // Load row values
		}
		$admin_uploads->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$admin_uploads->RowAttrs->merge(["data-rowindex" => $admin_uploads_list->RowCount, "id" => "r" . $admin_uploads_list->RowCount . "_admin_uploads", "data-rowtype" => $admin_uploads->RowType]);

		// Render row
		$admin_uploads_list->renderRow();

		// Render list options
		$admin_uploads_list->renderListOptions();
?>
	<tr <?php echo $admin_uploads->rowAttributes() ?>>
<?php

// Render list options (body, left)
$admin_uploads_list->ListOptions->render("body", "left", $admin_uploads_list->RowCount);
?>
	<?php if ($admin_uploads_list->id->Visible) { // id ?>
		<td data-name="id" <?php echo $admin_uploads_list->id->cellAttributes() ?>>
<span id="el<?php echo $admin_uploads_list->RowCount ?>_admin_uploads_id">
<span<?php echo $admin_uploads_list->id->viewAttributes() ?>><?php echo $admin_uploads_list->id->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($admin_uploads_list->test_id->Visible) { // test_id ?>
		<td data-name="test_id" <?php echo $admin_uploads_list->test_id->cellAttributes() ?>>
<span id="el<?php echo $admin_uploads_list->RowCount ?>_admin_uploads_test_id">
<span<?php echo $admin_uploads_list->test_id->viewAttributes() ?>><?php echo $admin_uploads_list->test_id->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$admin_uploads_list->ListOptions->render("body", "right", $admin_uploads_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$admin_uploads_list->isGridAdd())
		$admin_uploads_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$admin_uploads->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($admin_uploads_list->Recordset)
	$admin_uploads_list->Recordset->Close();
?>
<?php if (!$admin_uploads_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$admin_uploads_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $admin_uploads_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $admin_uploads_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($admin_uploads_list->TotalRecords == 0 && !$admin_uploads->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $admin_uploads_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$admin_uploads_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$admin_uploads_list->isExport()) { ?>
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
$admin_uploads_list->terminate();
?>