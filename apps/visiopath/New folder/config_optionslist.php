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
$config_options_list = new config_options_list();

// Run the page
$config_options_list->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_options_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$config_options_list->isExport()) { ?>
<script>
var fconfig_optionslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fconfig_optionslist = currentForm = new ew.Form("fconfig_optionslist", "list");
	fconfig_optionslist.formKeyCountName = '<?php echo $config_options_list->FormKeyCountName ?>';
	loadjs.done("fconfig_optionslist");
});
var fconfig_optionslistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fconfig_optionslistsrch = currentSearchForm = new ew.Form("fconfig_optionslistsrch");

	// Dynamic selection lists
	// Filters

	fconfig_optionslistsrch.filterList = <?php echo $config_options_list->getFilterList() ?>;
	loadjs.done("fconfig_optionslistsrch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$config_options_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($config_options_list->TotalRecords > 0 && $config_options_list->ExportOptions->visible()) { ?>
<?php $config_options_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($config_options_list->ImportOptions->visible()) { ?>
<?php $config_options_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($config_options_list->SearchOptions->visible()) { ?>
<?php $config_options_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($config_options_list->FilterOptions->visible()) { ?>
<?php $config_options_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$config_options_list->renderOtherOptions();
?>
<?php if (!$config_options_list->isExport() && !$config_options->CurrentAction) { ?>
<form name="fconfig_optionslistsrch" id="fconfig_optionslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fconfig_optionslistsrch-search-panel" class="<?php echo $config_options_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="config_options">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $config_options_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($config_options_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($config_options_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $config_options_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($config_options_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($config_options_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($config_options_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($config_options_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $config_options_list->showPageHeader(); ?>
<?php
$config_options_list->showMessage();
?>
<?php if ($config_options_list->TotalRecords > 0 || $config_options->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($config_options_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> config_options">
<form name="fconfig_optionslist" id="fconfig_optionslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_options">
<div id="gmp_config_options" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($config_options_list->TotalRecords > 0 || $config_options_list->isGridEdit()) { ?>
<table id="tbl_config_optionslist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$config_options->RowType = ROWTYPE_HEADER;

// Render list options
$config_options_list->renderListOptions();

// Render list options (header, left)
$config_options_list->ListOptions->render("header", "left");
?>
<?php if ($config_options_list->id->Visible) { // id ?>
	<?php if ($config_options_list->SortUrl($config_options_list->id) == "") { ?>
		<th data-name="id" class="<?php echo $config_options_list->id->headerCellClass() ?>"><div id="elh_config_options_id" class="config_options_id"><div class="ew-table-header-caption"><?php echo $config_options_list->id->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $config_options_list->id->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $config_options_list->SortUrl($config_options_list->id) ?>', 1);"><div id="elh_config_options_id" class="config_options_id">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $config_options_list->id->caption() ?></span><span class="ew-table-header-sort"><?php if ($config_options_list->id->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($config_options_list->id->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_options_list->parent_id->Visible) { // parent_id ?>
	<?php if ($config_options_list->SortUrl($config_options_list->parent_id) == "") { ?>
		<th data-name="parent_id" class="<?php echo $config_options_list->parent_id->headerCellClass() ?>"><div id="elh_config_options_parent_id" class="config_options_parent_id"><div class="ew-table-header-caption"><?php echo $config_options_list->parent_id->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="parent_id" class="<?php echo $config_options_list->parent_id->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $config_options_list->SortUrl($config_options_list->parent_id) ?>', 1);"><div id="elh_config_options_parent_id" class="config_options_parent_id">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $config_options_list->parent_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($config_options_list->parent_id->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($config_options_list->parent_id->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_options_list->role->Visible) { // role ?>
	<?php if ($config_options_list->SortUrl($config_options_list->role) == "") { ?>
		<th data-name="role" class="<?php echo $config_options_list->role->headerCellClass() ?>"><div id="elh_config_options_role" class="config_options_role"><div class="ew-table-header-caption"><?php echo $config_options_list->role->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="role" class="<?php echo $config_options_list->role->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $config_options_list->SortUrl($config_options_list->role) ?>', 1);"><div id="elh_config_options_role" class="config_options_role">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $config_options_list->role->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($config_options_list->role->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($config_options_list->role->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_options_list->name->Visible) { // name ?>
	<?php if ($config_options_list->SortUrl($config_options_list->name) == "") { ?>
		<th data-name="name" class="<?php echo $config_options_list->name->headerCellClass() ?>"><div id="elh_config_options_name" class="config_options_name"><div class="ew-table-header-caption"><?php echo $config_options_list->name->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="name" class="<?php echo $config_options_list->name->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $config_options_list->SortUrl($config_options_list->name) ?>', 1);"><div id="elh_config_options_name" class="config_options_name">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $config_options_list->name->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($config_options_list->name->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($config_options_list->name->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$config_options_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($config_options_list->ExportAll && $config_options_list->isExport()) {
	$config_options_list->StopRecord = $config_options_list->TotalRecords;
} else {

	// Set the last record to display
	if ($config_options_list->TotalRecords > $config_options_list->StartRecord + $config_options_list->DisplayRecords - 1)
		$config_options_list->StopRecord = $config_options_list->StartRecord + $config_options_list->DisplayRecords - 1;
	else
		$config_options_list->StopRecord = $config_options_list->TotalRecords;
}
$config_options_list->RecordCount = $config_options_list->StartRecord - 1;
if ($config_options_list->Recordset && !$config_options_list->Recordset->EOF) {
	$config_options_list->Recordset->moveFirst();
	$selectLimit = $config_options_list->UseSelectLimit;
	if (!$selectLimit && $config_options_list->StartRecord > 1)
		$config_options_list->Recordset->move($config_options_list->StartRecord - 1);
} elseif (!$config_options->AllowAddDeleteRow && $config_options_list->StopRecord == 0) {
	$config_options_list->StopRecord = $config_options->GridAddRowCount;
}

// Initialize aggregate
$config_options->RowType = ROWTYPE_AGGREGATEINIT;
$config_options->resetAttributes();
$config_options_list->renderRow();
while ($config_options_list->RecordCount < $config_options_list->StopRecord) {
	$config_options_list->RecordCount++;
	if ($config_options_list->RecordCount >= $config_options_list->StartRecord) {
		$config_options_list->RowCount++;

		// Set up key count
		$config_options_list->KeyCount = $config_options_list->RowIndex;

		// Init row class and style
		$config_options->resetAttributes();
		$config_options->CssClass = "";
		if ($config_options_list->isGridAdd()) {
		} else {
			$config_options_list->loadRowValues($config_options_list->Recordset); // Load row values
		}
		$config_options->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$config_options->RowAttrs->merge(["data-rowindex" => $config_options_list->RowCount, "id" => "r" . $config_options_list->RowCount . "_config_options", "data-rowtype" => $config_options->RowType]);

		// Render row
		$config_options_list->renderRow();

		// Render list options
		$config_options_list->renderListOptions();
?>
	<tr <?php echo $config_options->rowAttributes() ?>>
<?php

// Render list options (body, left)
$config_options_list->ListOptions->render("body", "left", $config_options_list->RowCount);
?>
	<?php if ($config_options_list->id->Visible) { // id ?>
		<td data-name="id" <?php echo $config_options_list->id->cellAttributes() ?>>
<span id="el<?php echo $config_options_list->RowCount ?>_config_options_id">
<span<?php echo $config_options_list->id->viewAttributes() ?>><?php echo $config_options_list->id->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_options_list->parent_id->Visible) { // parent_id ?>
		<td data-name="parent_id" <?php echo $config_options_list->parent_id->cellAttributes() ?>>
<span id="el<?php echo $config_options_list->RowCount ?>_config_options_parent_id">
<span<?php echo $config_options_list->parent_id->viewAttributes() ?>><?php echo $config_options_list->parent_id->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_options_list->role->Visible) { // role ?>
		<td data-name="role" <?php echo $config_options_list->role->cellAttributes() ?>>
<span id="el<?php echo $config_options_list->RowCount ?>_config_options_role">
<span<?php echo $config_options_list->role->viewAttributes() ?>><?php echo $config_options_list->role->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_options_list->name->Visible) { // name ?>
		<td data-name="name" <?php echo $config_options_list->name->cellAttributes() ?>>
<span id="el<?php echo $config_options_list->RowCount ?>_config_options_name">
<span<?php echo $config_options_list->name->viewAttributes() ?>><?php echo $config_options_list->name->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$config_options_list->ListOptions->render("body", "right", $config_options_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$config_options_list->isGridAdd())
		$config_options_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$config_options->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($config_options_list->Recordset)
	$config_options_list->Recordset->Close();
?>
<?php if (!$config_options_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$config_options_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $config_options_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $config_options_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($config_options_list->TotalRecords == 0 && !$config_options->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $config_options_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$config_options_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$config_options_list->isExport()) { ?>
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
$config_options_list->terminate();
?>