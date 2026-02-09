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
$doctor_uploads_edit = new doctor_uploads_edit();

// Run the page
$doctor_uploads_edit->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$doctor_uploads_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fdoctor_uploadsedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	fdoctor_uploadsedit = currentForm = new ew.Form("fdoctor_uploadsedit", "edit");

	// Validate form
	fdoctor_uploadsedit.validate = function() {
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
			<?php if ($doctor_uploads_edit->doctor_upload_id->Required) { ?>
				elm = this.getElements("x" + infix + "_doctor_upload_id");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $doctor_uploads_edit->doctor_upload_id->caption(), $doctor_uploads_edit->doctor_upload_id->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($doctor_uploads_edit->doctor_id->Required) { ?>
				elm = this.getElements("x" + infix + "_doctor_id");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $doctor_uploads_edit->doctor_id->caption(), $doctor_uploads_edit->doctor_id->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_doctor_id");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($doctor_uploads_edit->doctor_id->errorMessage()) ?>");
			<?php if ($doctor_uploads_edit->filename->Required) { ?>
				elm = this.getElements("x" + infix + "_filename");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $doctor_uploads_edit->filename->caption(), $doctor_uploads_edit->filename->RequiredErrorMessage)) ?>");
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
	fdoctor_uploadsedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fdoctor_uploadsedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fdoctor_uploadsedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $doctor_uploads_edit->showPageHeader(); ?>
<?php
$doctor_uploads_edit->showMessage();
?>
<form name="fdoctor_uploadsedit" id="fdoctor_uploadsedit" class="<?php echo $doctor_uploads_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="doctor_uploads">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$doctor_uploads_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($doctor_uploads_edit->doctor_upload_id->Visible) { // doctor_upload_id ?>
	<div id="r_doctor_upload_id" class="form-group row">
		<label id="elh_doctor_uploads_doctor_upload_id" class="<?php echo $doctor_uploads_edit->LeftColumnClass ?>"><?php echo $doctor_uploads_edit->doctor_upload_id->caption() ?><?php echo $doctor_uploads_edit->doctor_upload_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $doctor_uploads_edit->RightColumnClass ?>"><div <?php echo $doctor_uploads_edit->doctor_upload_id->cellAttributes() ?>>
<span id="el_doctor_uploads_doctor_upload_id">
<span<?php echo $doctor_uploads_edit->doctor_upload_id->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($doctor_uploads_edit->doctor_upload_id->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="doctor_uploads" data-field="x_doctor_upload_id" name="x_doctor_upload_id" id="x_doctor_upload_id" value="<?php echo HtmlEncode($doctor_uploads_edit->doctor_upload_id->CurrentValue) ?>">
<?php echo $doctor_uploads_edit->doctor_upload_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($doctor_uploads_edit->doctor_id->Visible) { // doctor_id ?>
	<div id="r_doctor_id" class="form-group row">
		<label id="elh_doctor_uploads_doctor_id" for="x_doctor_id" class="<?php echo $doctor_uploads_edit->LeftColumnClass ?>"><?php echo $doctor_uploads_edit->doctor_id->caption() ?><?php echo $doctor_uploads_edit->doctor_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $doctor_uploads_edit->RightColumnClass ?>"><div <?php echo $doctor_uploads_edit->doctor_id->cellAttributes() ?>>
<span id="el_doctor_uploads_doctor_id">
<input type="text" data-table="doctor_uploads" data-field="x_doctor_id" name="x_doctor_id" id="x_doctor_id" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($doctor_uploads_edit->doctor_id->getPlaceHolder()) ?>" value="<?php echo $doctor_uploads_edit->doctor_id->EditValue ?>"<?php echo $doctor_uploads_edit->doctor_id->editAttributes() ?>>
</span>
<?php echo $doctor_uploads_edit->doctor_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($doctor_uploads_edit->filename->Visible) { // filename ?>
	<div id="r_filename" class="form-group row">
		<label id="elh_doctor_uploads_filename" for="x_filename" class="<?php echo $doctor_uploads_edit->LeftColumnClass ?>"><?php echo $doctor_uploads_edit->filename->caption() ?><?php echo $doctor_uploads_edit->filename->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $doctor_uploads_edit->RightColumnClass ?>"><div <?php echo $doctor_uploads_edit->filename->cellAttributes() ?>>
<span id="el_doctor_uploads_filename">
<input type="text" data-table="doctor_uploads" data-field="x_filename" name="x_filename" id="x_filename" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($doctor_uploads_edit->filename->getPlaceHolder()) ?>" value="<?php echo $doctor_uploads_edit->filename->EditValue ?>"<?php echo $doctor_uploads_edit->filename->editAttributes() ?>>
</span>
<?php echo $doctor_uploads_edit->filename->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$doctor_uploads_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $doctor_uploads_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $doctor_uploads_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$doctor_uploads_edit->showPageFooter();
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
$doctor_uploads_edit->terminate();
?>