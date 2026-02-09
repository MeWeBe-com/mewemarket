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
$config_options_edit = new config_options_edit();

// Run the page
$config_options_edit->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_options_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fconfig_optionsedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	fconfig_optionsedit = currentForm = new ew.Form("fconfig_optionsedit", "edit");

	// Validate form
	fconfig_optionsedit.validate = function() {
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
			<?php if ($config_options_edit->id->Required) { ?>
				elm = this.getElements("x" + infix + "_id");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $config_options_edit->id->caption(), $config_options_edit->id->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($config_options_edit->parent_id->Required) { ?>
				elm = this.getElements("x" + infix + "_parent_id");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $config_options_edit->parent_id->caption(), $config_options_edit->parent_id->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_parent_id");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($config_options_edit->parent_id->errorMessage()) ?>");
			<?php if ($config_options_edit->role->Required) { ?>
				elm = this.getElements("x" + infix + "_role");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $config_options_edit->role->caption(), $config_options_edit->role->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($config_options_edit->name->Required) { ?>
				elm = this.getElements("x" + infix + "_name");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $config_options_edit->name->caption(), $config_options_edit->name->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($config_options_edit->value->Required) { ?>
				elm = this.getElements("x" + infix + "_value");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $config_options_edit->value->caption(), $config_options_edit->value->RequiredErrorMessage)) ?>");
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
	fconfig_optionsedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fconfig_optionsedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fconfig_optionsedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $config_options_edit->showPageHeader(); ?>
<?php
$config_options_edit->showMessage();
?>
<form name="fconfig_optionsedit" id="fconfig_optionsedit" class="<?php echo $config_options_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_options">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$config_options_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($config_options_edit->id->Visible) { // id ?>
	<div id="r_id" class="form-group row">
		<label id="elh_config_options_id" class="<?php echo $config_options_edit->LeftColumnClass ?>"><?php echo $config_options_edit->id->caption() ?><?php echo $config_options_edit->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $config_options_edit->RightColumnClass ?>"><div <?php echo $config_options_edit->id->cellAttributes() ?>>
<span id="el_config_options_id">
<span<?php echo $config_options_edit->id->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($config_options_edit->id->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="config_options" data-field="x_id" name="x_id" id="x_id" value="<?php echo HtmlEncode($config_options_edit->id->CurrentValue) ?>">
<?php echo $config_options_edit->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_options_edit->parent_id->Visible) { // parent_id ?>
	<div id="r_parent_id" class="form-group row">
		<label id="elh_config_options_parent_id" for="x_parent_id" class="<?php echo $config_options_edit->LeftColumnClass ?>"><?php echo $config_options_edit->parent_id->caption() ?><?php echo $config_options_edit->parent_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $config_options_edit->RightColumnClass ?>"><div <?php echo $config_options_edit->parent_id->cellAttributes() ?>>
<span id="el_config_options_parent_id">
<input type="text" data-table="config_options" data-field="x_parent_id" name="x_parent_id" id="x_parent_id" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($config_options_edit->parent_id->getPlaceHolder()) ?>" value="<?php echo $config_options_edit->parent_id->EditValue ?>"<?php echo $config_options_edit->parent_id->editAttributes() ?>>
</span>
<?php echo $config_options_edit->parent_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_options_edit->role->Visible) { // role ?>
	<div id="r_role" class="form-group row">
		<label id="elh_config_options_role" for="x_role" class="<?php echo $config_options_edit->LeftColumnClass ?>"><?php echo $config_options_edit->role->caption() ?><?php echo $config_options_edit->role->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $config_options_edit->RightColumnClass ?>"><div <?php echo $config_options_edit->role->cellAttributes() ?>>
<span id="el_config_options_role">
<input type="text" data-table="config_options" data-field="x_role" name="x_role" id="x_role" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($config_options_edit->role->getPlaceHolder()) ?>" value="<?php echo $config_options_edit->role->EditValue ?>"<?php echo $config_options_edit->role->editAttributes() ?>>
</span>
<?php echo $config_options_edit->role->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_options_edit->name->Visible) { // name ?>
	<div id="r_name" class="form-group row">
		<label id="elh_config_options_name" for="x_name" class="<?php echo $config_options_edit->LeftColumnClass ?>"><?php echo $config_options_edit->name->caption() ?><?php echo $config_options_edit->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $config_options_edit->RightColumnClass ?>"><div <?php echo $config_options_edit->name->cellAttributes() ?>>
<span id="el_config_options_name">
<input type="text" data-table="config_options" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($config_options_edit->name->getPlaceHolder()) ?>" value="<?php echo $config_options_edit->name->EditValue ?>"<?php echo $config_options_edit->name->editAttributes() ?>>
</span>
<?php echo $config_options_edit->name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_options_edit->value->Visible) { // value ?>
	<div id="r_value" class="form-group row">
		<label id="elh_config_options_value" for="x_value" class="<?php echo $config_options_edit->LeftColumnClass ?>"><?php echo $config_options_edit->value->caption() ?><?php echo $config_options_edit->value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $config_options_edit->RightColumnClass ?>"><div <?php echo $config_options_edit->value->cellAttributes() ?>>
<span id="el_config_options_value">
<textarea data-table="config_options" data-field="x_value" name="x_value" id="x_value" cols="35" rows="4" placeholder="<?php echo HtmlEncode($config_options_edit->value->getPlaceHolder()) ?>"<?php echo $config_options_edit->value->editAttributes() ?>><?php echo $config_options_edit->value->EditValue ?></textarea>
</span>
<?php echo $config_options_edit->value->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$config_options_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $config_options_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $config_options_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$config_options_edit->showPageFooter();
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
$config_options_edit->terminate();
?>