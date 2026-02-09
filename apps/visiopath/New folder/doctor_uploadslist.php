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
$doctor_uploads_list = new doctor_uploads_list();

// Run the page
$doctor_uploads_list->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$doctor_uploads_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$doctor_uploads_list->isExport()) { ?>
<script>
var fdoctor_uploadslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fdoctor_uploadslist = currentForm = new ew.Form("fdoctor_uploadslist", "list");
	fdoctor_uploadslist.formKeyCountName = '<?php echo $doctor_uploads_list->FormKeyCountName ?>';
	loadjs.done("fdoctor_uploadslist");
});
var fdoctor_uploadslistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fdoctor_uploadslistsrch = currentSearchForm = new ew.Form("fdoctor_uploadslistsrch");

	// Dynamic selection lists
	// Filters

	fdoctor_uploadslistsrch.filterList = <?php echo $doctor_uploads_list->getFilterList() ?>;
	loadjs.done("fdoctor_uploadslistsrch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$doctor_uploads_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($doctor_uploads_list->TotalRecords > 0 && $doctor_uploads_list->ExportOptions->visible()) { ?>
<?php $doctor_uploads_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($doctor_uploads_list->ImportOptions->visible()) { ?>
<?php $doctor_uploads_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($doctor_uploads_list->SearchOptions->visible()) { ?>
<?php $doctor_uploads_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($doctor_uploads_list->FilterOptions->visible()) { ?>
<?php $doctor_uploads_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$doctor_uploads_list->renderOtherOptions();
?>
<?php if (!$doctor_uploads_list->isExport() && !$doctor_uploads->CurrentAction) { ?>
<form name="fdoctor_uploadslistsrch" id="fdoctor_uploadslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fdoctor_uploadslistsrch-search-panel" class="<?php echo $doctor_uploads_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="doctor_uploads">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $doctor_uploads_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($doctor_uploads_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($doctor_uploads_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $doctor_uploads_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($doctor_uploads_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($doctor_uploads_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($doctor_uploads_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($doctor_uploads_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $doctor_uploads_list->showPageHeader(); ?>
<?php
$doctor_uploads_list->showMessage();
?>
<?php if ($doctor_uploads_list->TotalRecords > 0 || $doctor_uploads->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($doctor_uploads_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> doctor_uploads">
<form name="fdoctor_uploadslist" id="fdoctor_uploadslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="doctor_uploads">
<div id="gmp_doctor_uploads" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($doctor_uploads_list->TotalRecords > 0 || $doctor_uploads_list->isGridEdit()) { ?>
<table id="tbl_doctor_uploadslist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$doctor_uploads->RowType = ROWTYPE_HEADER;

// Render list options
$doctor_uploads_list->renderListOptions();

// Render list options (header, left)
$doctor_uploads_list->ListOptions->render("header", "left");
?>
<?php if ($doctor_uploads_list->doctor_upload_id->Visible) { // doctor_upload_id ?>
	<?php if ($doctor_uploads_list->SortUrl($doctor_uploads_list->doctor_upload_id) == "") { ?>
		<th data-name="doctor_upload_id" class="<?php echo $doctor_uploads_list->doctor_upload_id->headerCellClass() ?>"><div id="elh_doctor_uploads_doctor_upload_id" class="doctor_uploads_doctor_upload_id"><div class="ew-table-header-caption"><?php echo $doctor_uploads_list->doctor_upload_id->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="doctor_upload_id" class="<?php echo $doctor_uploads_list->doctor_upload_id->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $doctor_uploads_list->SortUrl($doctor_uploads_list->doctor_upload_id) ?>', 1);"><div id="elh_doctor_uploads_doctor_upload_id" class="doctor_uploads_doctor_upload_id">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $doctor_uploads_list->doctor_upload_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($doctor_uploads_list->doctor_upload_id->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($doctor_uploads_list->doctor_upload_id->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($doctor_uploads_list->doctor_id->Visible) { // doctor_id ?>
	<?php if ($doctor_uploads_list->SortUrl($doctor_uploads_list->doctor_id) == "") { ?>
		<th data-name="doctor_id" class="<?php echo $doctor_uploads_list->doctor_id->headerCellClass() ?>"><div id="elh_doctor_uploads_doctor_id" class="doctor_uploads_doctor_id"><div class="ew-table-header-caption"><?php echo $doctor_uploads_list->doctor_id->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="doctor_id" class="<?php echo $doctor_uploads_list->doctor_id->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $doctor_uploads_list->SortUrl($doctor_uploads_list->doctor_id) ?>', 1);"><div id="elh_doctor_uploads_doctor_id" class="doctor_uploads_doctor_id">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $doctor_uploads_list->doctor_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($doctor_uploads_list->doctor_id->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($doctor_uploads_list->doctor_id->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($doctor_uploads_list->filename->Visible) { // filename ?>
	<?php if ($doctor_uploads_list->SortUrl($doctor_uploads_list->filename) == "") { ?>
		<th data-name="filename" class="<?php echo $doctor_uploads_list->filename->headerCellClass() ?>"><div id="elh_doctor_uploads_filename" class="doctor_uploads_filename"><div class="ew-table-header-caption"><?php echo $doctor_uploads_list->filename->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="filename" class="<?php echo $doctor_uploads_list->filename->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $doctor_uploads_list->SortUrl($doctor_uploads_list->filename) ?>', 1);"><div id="elh_doctor_uploads_filename" class="doctor_uploads_filename">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $doctor_uploads_list->filename->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($doctor_uploads_list->filename->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($doctor_uploads_list->filename->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$doctor_uploads_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($doctor_uploads_list->ExportAll && $doctor_uploads_list->isExport()) {
	$doctor_uploads_list->StopRecord = $doctor_uploads_list->TotalRecords;
} else {

	// Set the last record to display
	if ($doctor_uploads_list->TotalRecords > $doctor_uploads_list->StartRecord + $doctor_uploads_list->DisplayRecords - 1)
		$doctor_uploads_list->StopRecord = $doctor_uploads_list->StartRecord + $doctor_uploads_list->DisplayRecords - 1;
	else
		$doctor_uploads_list->StopRecord = $doctor_uploads_list->TotalRecords;
}
$doctor_uploads_list->RecordCount = $doctor_uploads_list->StartRecord - 1;
if ($doctor_uploads_list->Recordset && !$doctor_uploads_list->Recordset->EOF) {
	$doctor_uploads_list->Recordset->moveFirst();
	$selectLimit = $doctor_uploads_list->UseSelectLimit;
	if (!$selectLimit && $doctor_uploads_list->StartRecord > 1)
		$doctor_uploads_list->Recordset->move($doctor_uploads_list->StartRecord - 1);
} elseif (!$doctor_uploads->AllowAddDeleteRow && $doctor_uploads_list->StopRecord == 0) {
	$doctor_uploads_list->StopRecord = $doctor_uploads->GridAddRowCount;
}

// Initialize aggregate
$doctor_uploads->RowType = ROWTYPE_AGGREGATEINIT;
$doctor_uploads->resetAttributes();
$doctor_uploads_list->renderRow();
while ($doctor_uploads_list->RecordCount < $doctor_uploads_list->StopRecord) {
	$doctor_uploads_list->RecordCount++;
	if ($doctor_uploads_list->RecordCount >= $doctor_uploads_list->StartRecord) {
		$doctor_uploads_list->RowCount++;

		// Set up key count
		$doctor_uploads_list->KeyCount = $doctor_uploads_list->RowIndex;

		// Init row class and style
		$doctor_uploads->resetAttributes();
		$doctor_uploads->CssClass = "";
		if ($doctor_uploads_list->isGridAdd()) {
		} else {
			$doctor_uploads_list->loadRowValues($doctor_uploads_list->Recordset); // Load row values
		}
		$doctor_uploads->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$doctor_uploads->RowAttrs->merge(["data-rowindex" => $doctor_uploads_list->RowCount, "id" => "r" . $doctor_uploads_list->RowCount . "_doctor_uploads", "data-rowtype" => $doctor_uploads->RowType]);

		// Render row
		$doctor_uploads_list->renderRow();

		// Render list options
		$doctor_uploads_list->renderListOptions();
?>
	<tr <?php echo $doctor_uploads->rowAttributes() ?>>
<?php

// Render list options (body, left)
$doctor_uploads_list->ListOptions->render("body", "left", $doctor_uploads_list->RowCount);
?>
	<?php if ($doctor_uploads_list->doctor_upload_id->Visible) { // doctor_upload_id ?>
		<td data-name="doctor_upload_id" <?php echo $doctor_uploads_list->doctor_upload_id->cellAttributes() ?>>
<span id="el<?php echo $doctor_uploads_list->RowCount ?>_doctor_uploads_doctor_upload_id">
<span<?php echo $doctor_uploads_list->doctor_upload_id->viewAttributes() ?>><?php echo $doctor_uploads_list->doctor_upload_id->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($doctor_uploads_list->doctor_id->Visible) { // doctor_id ?>
		<td data-name="doctor_id" <?php echo $doctor_uploads_list->doctor_id->cellAttributes() ?>>
<span id="el<?php echo $doctor_uploads_list->RowCount ?>_doctor_uploads_doctor_id">
<span<?php echo $doctor_uploads_list->doctor_id->viewAttributes() ?>><?php echo $doctor_uploads_list->doctor_id->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($doctor_uploads_list->filename->Visible) { // filename ?>
		<td data-name="filename" <?php echo $doctor_uploads_list->filename->cellAttributes() ?>>
<span id="el<?php echo $doctor_uploads_list->RowCount ?>_doctor_uploads_filename">
<span<?php echo $doctor_uploads_list->filename->viewAttributes() ?>><?php echo $doctor_uploads_list->filename->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$doctor_uploads_list->ListOptions->render("body", "right", $doctor_uploads_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$doctor_uploads_list->isGridAdd())
		$doctor_uploads_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$doctor_uploads->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($doctor_uploads_list->Recordset)
	$doctor_uploads_list->Recordset->Close();
?>
<?php if (!$doctor_uploads_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$doctor_uploads_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $doctor_uploads_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $doctor_uploads_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($doctor_uploads_list->TotalRecords == 0 && !$doctor_uploads->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $doctor_uploads_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$doctor_uploads_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$doctor_uploads_list->isExport()) { ?>
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
$doctor_uploads_list->terminate();
?>