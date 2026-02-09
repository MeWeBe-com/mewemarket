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
$admin_uploads_edit = new admin_uploads_edit();

// Run the page
$admin_uploads_edit->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$admin_uploads_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fadmin_uploadsedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	fadmin_uploadsedit = currentForm = new ew.Form("fadmin_uploadsedit", "edit");

	// Validate form
	fadmin_uploadsedit.validate = function() {
		if (!this.validateRequired)
			return true; // Ignore validation
		var $ = jQuery, fobj = this.getForm(), $fobj = $(fobj);
		if ($fobj.find("#confirm").val() == "confirm")
			return true;
		var elm, felm, uelm, addcnt = 0;
		var $k = $fobj.find("#" + this.formKeyCountName); // Get key_count
		var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
		var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
		var gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
		for (var i = startcnt; i <= rowcnt; i++) {
			var infix = ($k[0]) ? String(i) : "";
			$fobj.data("rowindex", infix);
			<?php if ($admin_uploads_edit->id->Required) { ?>
				elm = this.getElements("x" + infix + "_id");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $admin_uploads_edit->id->caption(), $admin_uploads_edit->id->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($admin_uploads_edit->test_id->Required) { ?>
				elm = this.getElements("x" + infix + "_test_id");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $admin_uploads_edit->test_id->caption(), $admin_uploads_edit->test_id->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_test_id");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($admin_uploads_edit->test_id->errorMessage()) ?>");
			<?php if ($admin_uploads_edit->upload_file->Required) { ?>
				elm = this.getElements("x" + infix + "_upload_file");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $admin_uploads_edit->upload_file->caption(), $admin_uploads_edit->upload_file->RequiredErrorMessage)) ?>");
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
		}

		// Process detail forms
		var dfs = $fobj.find("input[name='detailpage']").get();
		for (var i = 0; i < dfs.length; i++) {
			var df = dfs[i], val = df.value;
			if (val && ew.forms[val])
				if (!ew.forms[val].validate())
					return false;
		}
		return true;
	}

	// Form_CustomValidate
	fadmin_uploadsedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fadmin_uploadsedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fadmin_uploadsedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $admin_uploads_edit->showPageHeader(); ?>
<?php
$admin_uploads_edit->showMessage();
?>
<form name="fadmin_uploadsedit" id="fadmin_uploadsedit" class="<?php echo $admin_uploads_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="admin_uploads">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$admin_uploads_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($admin_uploads_edit->id->Visible) { // id ?>
	<div id="r_id" class="form-group row">
		<label id="elh_admin_uploads_id" class="<?php echo $admin_uploads_edit->LeftColumnClass ?>"><?php echo $admin_uploads_edit->id->caption() ?><?php echo $admin_uploads_edit->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $admin_uploads_edit->RightColumnClass ?>"><div <?php echo $admin_uploads_edit->id->cellAttributes() ?>>
<span id="el_admin_uploads_id">
<span<?php echo $admin_uploads_edit->id->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($admin_uploads_edit->id->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="admin_uploads" data-field="x_id" name="x_id" id="x_id" value="<?php echo HtmlEncode($admin_uploads_edit->id->CurrentValue) ?>">
<?php echo $admin_uploads_edit->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($admin_uploads_edit->test_id->Visible) { // test_id ?>
	<div id="r_test_id" class="form-group row">
		<label id="elh_admin_uploads_test_id" for="x_test_id" class="<?php echo $admin_uploads_edit->LeftColumnClass ?>"><?php echo $admin_uploads_edit->test_id->caption() ?><?php echo $admin_uploads_edit->test_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $admin_uploads_edit->RightColumnClass ?>"><div <?php echo $admin_uploads_edit->test_id->cellAttributes() ?>>
<span id="el_admin_uploads_test_id">
<input type="text" data-table="admin_uploads" data-field="x_test_id" name="x_test_id" id="x_test_id" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($admin_uploads_edit->test_id->getPlaceHolder()) ?>" value="<?php echo $admin_uploads_edit->test_id->EditValue ?>"<?php echo $admin_uploads_edit->test_id->editAttributes() ?>>
</span>
<?php echo $admin_uploads_edit->test_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($admin_uploads_edit->upload_file->Visible) { // upload_file ?>
	<div id="r_upload_file" class="form-group row">
		<label id="elh_admin_uploads_upload_file" for="x_upload_file" class="<?php echo $admin_uploads_edit->LeftColumnClass ?>"><?php echo $admin_uploads_edit->upload_file->caption() ?><?php echo $admin_uploads_edit->upload_file->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $admin_uploads_edit->RightColumnClass ?>"><div <?php echo $admin_uploads_edit->upload_file->cellAttributes() ?>>
<span id="el_admin_uploads_upload_file">
<textarea data-table="admin_uploads" data-field="x_upload_file" name="x_upload_file" id="x_upload_file" cols="35" rows="4" placeholder="<?php echo HtmlEncode($admin_uploads_edit->upload_file->getPlaceHolder()) ?>"<?php echo $admin_uploads_edit->upload_file->editAttributes() ?>><?php echo $admin_uploads_edit->upload_file->EditValue ?></textarea>
</span>
<?php echo $admin_uploads_edit->upload_file->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$admin_uploads_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $admin_uploads_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $admin_uploads_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$admin_uploads_edit->showPageFooter();
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
$admin_uploads_edit->terminate();
?>