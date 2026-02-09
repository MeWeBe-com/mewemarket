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
$doctor_uploads_add = new doctor_uploads_add();

// Run the page
$doctor_uploads_add->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$doctor_uploads_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fdoctor_uploadsadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	fdoctor_uploadsadd = currentForm = new ew.Form("fdoctor_uploadsadd", "add");

	// Validate form
	fdoctor_uploadsadd.validate = function() {
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
			<?php if ($doctor_uploads_add->doctor_id->Required) { ?>
				elm = this.getElements("x" + infix + "_doctor_id");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $doctor_uploads_add->doctor_id->caption(), $doctor_uploads_add->doctor_id->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_doctor_id");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($doctor_uploads_add->doctor_id->errorMessage()) ?>");
			<?php if ($doctor_uploads_add->filename->Required) { ?>
				elm = this.getElements("x" + infix + "_filename");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $doctor_uploads_add->filename->caption(), $doctor_uploads_add->filename->RequiredErrorMessage)) ?>");
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
	fdoctor_uploadsadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fdoctor_uploadsadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fdoctor_uploadsadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $doctor_uploads_add->showPageHeader(); ?>
<?php
$doctor_uploads_add->showMessage();
?>
<form name="fdoctor_uploadsadd" id="fdoctor_uploadsadd" class="<?php echo $doctor_uploads_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="doctor_uploads">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$doctor_uploads_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($doctor_uploads_add->doctor_id->Visible) { // doctor_id ?>
	<div id="r_doctor_id" class="form-group row">
		<label id="elh_doctor_uploads_doctor_id" for="x_doctor_id" class="<?php echo $doctor_uploads_add->LeftColumnClass ?>"><?php echo $doctor_uploads_add->doctor_id->caption() ?><?php echo $doctor_uploads_add->doctor_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $doctor_uploads_add->RightColumnClass ?>"><div <?php echo $doctor_uploads_add->doctor_id->cellAttributes() ?>>
<span id="el_doctor_uploads_doctor_id">
<input type="text" data-table="doctor_uploads" data-field="x_doctor_id" name="x_doctor_id" id="x_doctor_id" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($doctor_uploads_add->doctor_id->getPlaceHolder()) ?>" value="<?php echo $doctor_uploads_add->doctor_id->EditValue ?>"<?php echo $doctor_uploads_add->doctor_id->editAttributes() ?>>
</span>
<?php echo $doctor_uploads_add->doctor_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($doctor_uploads_add->filename->Visible) { // filename ?>
	<div id="r_filename" class="form-group row">
		<label id="elh_doctor_uploads_filename" for="x_filename" class="<?php echo $doctor_uploads_add->LeftColumnClass ?>"><?php echo $doctor_uploads_add->filename->caption() ?><?php echo $doctor_uploads_add->filename->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $doctor_uploads_add->RightColumnClass ?>"><div <?php echo $doctor_uploads_add->filename->cellAttributes() ?>>
<span id="el_doctor_uploads_filename">
<input type="text" data-table="doctor_uploads" data-field="x_filename" name="x_filename" id="x_filename" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($doctor_uploads_add->filename->getPlaceHolder()) ?>" value="<?php echo $doctor_uploads_add->filename->EditValue ?>"<?php echo $doctor_uploads_add->filename->editAttributes() ?>>
</span>
<?php echo $doctor_uploads_add->filename->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$doctor_uploads_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $doctor_uploads_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $doctor_uploads_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$doctor_uploads_add->showPageFooter();
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
$doctor_uploads_add->terminate();
?>