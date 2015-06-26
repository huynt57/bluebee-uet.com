<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "tbl_facultyinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$tbl_faculty_edit = NULL; // Initialize page object first

class ctbl_faculty_edit extends ctbl_faculty {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_faculty';

	// Page object name
	var $PageObjName = 'tbl_faculty_edit';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			$html .= "<p class=\"ewMessage\">" . $sMessage . "</p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			$html .= "<table class=\"ewMessageTable\"><tr><td class=\"ewWarningIcon\"></td><td class=\"ewWarningMessage\">" . $sWarningMessage . "</td></tr></table>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			$html .= "<table class=\"ewMessageTable\"><tr><td class=\"ewSuccessIcon\"></td><td class=\"ewSuccessMessage\">" . $sSuccessMessage . "</td></tr></table>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			$html .= "<table class=\"ewMessageTable\"><tr><td class=\"ewErrorIcon\"></td><td class=\"ewErrorMessage\">" . $sErrorMessage . "</td></tr></table>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p class=\"phpmaker\">" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Fotoer exists, display
			echo "<p class=\"phpmaker\">" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language, $UserAgent;

		// User agent
		$UserAgent = ew_UserAgent();
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (tbl_faculty)
		if (!isset($GLOBALS["tbl_faculty"])) {
			$GLOBALS["tbl_faculty"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_faculty"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_faculty', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"];
		$this->faculty_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["faculty_id"] <> "")
			$this->faculty_id->setQueryStringValue($_GET["faculty_id"]);

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->faculty_id->CurrentValue == "")
			$this->Page_Terminate("tbl_facultylist.php"); // Invalid key, return to list

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("tbl_facultylist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tbl_facultyview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to View page directly
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
		$index = $objForm->Index; // Save form index
		$objForm->Index = -1;
		$confirmPage = (strval($objForm->GetValue("a_confirm")) <> "");
		$objForm->Index = $index; // Restore form index
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->faculty_id->FldIsDetailKey)
			$this->faculty_id->setFormValue($objForm->GetValue("x_faculty_id"));
		if (!$this->faculty_university->FldIsDetailKey) {
			$this->faculty_university->setFormValue($objForm->GetValue("x_faculty_university"));
		}
		if (!$this->faculty_name->FldIsDetailKey) {
			$this->faculty_name->setFormValue($objForm->GetValue("x_faculty_name"));
		}
		if (!$this->faculty_code->FldIsDetailKey) {
			$this->faculty_code->setFormValue($objForm->GetValue("x_faculty_code"));
		}
		if (!$this->faculty_active->FldIsDetailKey) {
			$this->faculty_active->setFormValue($objForm->GetValue("x_faculty_active"));
		}
		if (!$this->faculty_research->FldIsDetailKey) {
			$this->faculty_research->setFormValue($objForm->GetValue("x_faculty_research"));
		}
		if (!$this->faculty_lab->FldIsDetailKey) {
			$this->faculty_lab->setFormValue($objForm->GetValue("x_faculty_lab"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->faculty_id->CurrentValue = $this->faculty_id->FormValue;
		$this->faculty_university->CurrentValue = $this->faculty_university->FormValue;
		$this->faculty_name->CurrentValue = $this->faculty_name->FormValue;
		$this->faculty_code->CurrentValue = $this->faculty_code->FormValue;
		$this->faculty_active->CurrentValue = $this->faculty_active->FormValue;
		$this->faculty_research->CurrentValue = $this->faculty_research->FormValue;
		$this->faculty_lab->CurrentValue = $this->faculty_lab->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->faculty_id->setDbValue($rs->fields('faculty_id'));
		$this->faculty_university->setDbValue($rs->fields('faculty_university'));
		$this->faculty_name->setDbValue($rs->fields('faculty_name'));
		$this->faculty_code->setDbValue($rs->fields('faculty_code'));
		$this->faculty_active->setDbValue($rs->fields('faculty_active'));
		$this->faculty_research->setDbValue($rs->fields('faculty_research'));
		$this->faculty_lab->setDbValue($rs->fields('faculty_lab'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// faculty_id
		// faculty_university
		// faculty_name
		// faculty_code
		// faculty_active
		// faculty_research
		// faculty_lab

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// faculty_id
			$this->faculty_id->ViewValue = $this->faculty_id->CurrentValue;
			$this->faculty_id->ViewCustomAttributes = "";

			// faculty_university
			$this->faculty_university->ViewValue = $this->faculty_university->CurrentValue;
			$this->faculty_university->ViewCustomAttributes = "";

			// faculty_name
			$this->faculty_name->ViewValue = $this->faculty_name->CurrentValue;
			$this->faculty_name->ViewCustomAttributes = "";

			// faculty_code
			$this->faculty_code->ViewValue = $this->faculty_code->CurrentValue;
			$this->faculty_code->ViewCustomAttributes = "";

			// faculty_active
			$this->faculty_active->ViewValue = $this->faculty_active->CurrentValue;
			$this->faculty_active->ViewCustomAttributes = "";

			// faculty_research
			$this->faculty_research->ViewValue = $this->faculty_research->CurrentValue;
			$this->faculty_research->ViewCustomAttributes = "";

			// faculty_lab
			$this->faculty_lab->ViewValue = $this->faculty_lab->CurrentValue;
			$this->faculty_lab->ViewCustomAttributes = "";

			// faculty_id
			$this->faculty_id->LinkCustomAttributes = "";
			$this->faculty_id->HrefValue = "";
			$this->faculty_id->TooltipValue = "";

			// faculty_university
			$this->faculty_university->LinkCustomAttributes = "";
			$this->faculty_university->HrefValue = "";
			$this->faculty_university->TooltipValue = "";

			// faculty_name
			$this->faculty_name->LinkCustomAttributes = "";
			$this->faculty_name->HrefValue = "";
			$this->faculty_name->TooltipValue = "";

			// faculty_code
			$this->faculty_code->LinkCustomAttributes = "";
			$this->faculty_code->HrefValue = "";
			$this->faculty_code->TooltipValue = "";

			// faculty_active
			$this->faculty_active->LinkCustomAttributes = "";
			$this->faculty_active->HrefValue = "";
			$this->faculty_active->TooltipValue = "";

			// faculty_research
			$this->faculty_research->LinkCustomAttributes = "";
			$this->faculty_research->HrefValue = "";
			$this->faculty_research->TooltipValue = "";

			// faculty_lab
			$this->faculty_lab->LinkCustomAttributes = "";
			$this->faculty_lab->HrefValue = "";
			$this->faculty_lab->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// faculty_id
			$this->faculty_id->EditCustomAttributes = "";
			$this->faculty_id->EditValue = $this->faculty_id->CurrentValue;
			$this->faculty_id->ViewCustomAttributes = "";

			// faculty_university
			$this->faculty_university->EditCustomAttributes = "";
			$this->faculty_university->EditValue = ew_HtmlEncode($this->faculty_university->CurrentValue);

			// faculty_name
			$this->faculty_name->EditCustomAttributes = "";
			$this->faculty_name->EditValue = ew_HtmlEncode($this->faculty_name->CurrentValue);

			// faculty_code
			$this->faculty_code->EditCustomAttributes = "";
			$this->faculty_code->EditValue = ew_HtmlEncode($this->faculty_code->CurrentValue);

			// faculty_active
			$this->faculty_active->EditCustomAttributes = "";
			$this->faculty_active->EditValue = ew_HtmlEncode($this->faculty_active->CurrentValue);

			// faculty_research
			$this->faculty_research->EditCustomAttributes = "";
			$this->faculty_research->EditValue = ew_HtmlEncode($this->faculty_research->CurrentValue);

			// faculty_lab
			$this->faculty_lab->EditCustomAttributes = "";
			$this->faculty_lab->EditValue = ew_HtmlEncode($this->faculty_lab->CurrentValue);

			// Edit refer script
			// faculty_id

			$this->faculty_id->HrefValue = "";

			// faculty_university
			$this->faculty_university->HrefValue = "";

			// faculty_name
			$this->faculty_name->HrefValue = "";

			// faculty_code
			$this->faculty_code->HrefValue = "";

			// faculty_active
			$this->faculty_active->HrefValue = "";

			// faculty_research
			$this->faculty_research->HrefValue = "";

			// faculty_lab
			$this->faculty_lab->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckInteger($this->faculty_university->FormValue)) {
			ew_AddMessage($gsFormError, $this->faculty_university->FldErrMsg());
		}
		if (!ew_CheckInteger($this->faculty_active->FormValue)) {
			ew_AddMessage($gsFormError, $this->faculty_active->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$rsnew = array();

			// faculty_university
			$this->faculty_university->SetDbValueDef($rsnew, $this->faculty_university->CurrentValue, NULL, $this->faculty_university->ReadOnly);

			// faculty_name
			$this->faculty_name->SetDbValueDef($rsnew, $this->faculty_name->CurrentValue, NULL, $this->faculty_name->ReadOnly);

			// faculty_code
			$this->faculty_code->SetDbValueDef($rsnew, $this->faculty_code->CurrentValue, NULL, $this->faculty_code->ReadOnly);

			// faculty_active
			$this->faculty_active->SetDbValueDef($rsnew, $this->faculty_active->CurrentValue, NULL, $this->faculty_active->ReadOnly);

			// faculty_research
			$this->faculty_research->SetDbValueDef($rsnew, $this->faculty_research->CurrentValue, NULL, $this->faculty_research->ReadOnly);

			// faculty_lab
			$this->faculty_lab->SetDbValueDef($rsnew, $this->faculty_lab->CurrentValue, NULL, $this->faculty_lab->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tbl_faculty_edit)) $tbl_faculty_edit = new ctbl_faculty_edit();

// Page init
$tbl_faculty_edit->Page_Init();

// Page main
$tbl_faculty_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_faculty_edit = new ew_Page("tbl_faculty_edit");
tbl_faculty_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = tbl_faculty_edit.PageID; // For backward compatibility

// Form object
var ftbl_facultyedit = new ew_Form("ftbl_facultyedit");

// Validate form
ftbl_facultyedit.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();	
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var elm, aelm;
	var rowcnt = 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // rowcnt == 0 => Inline-Add
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = "";
		elm = fobj.elements["x" + infix + "_faculty_university"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_faculty->faculty_university->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_faculty_active"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_faculty->faculty_active->FldErrMsg()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}

	// Process detail page
	if (fobj.detailpage && fobj.detailpage.value && ewForms[fobj.detailpage.value])
		return ewForms[fobj.detailpage.value].Validate(fobj);
	return true;
}

// Form_CustomValidate event
ftbl_facultyedit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_facultyedit.ValidateRequired = true;
<?php } else { ?>
ftbl_facultyedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_faculty->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $tbl_faculty->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $tbl_faculty_edit->ShowPageHeader(); ?>
<?php
$tbl_faculty_edit->ShowMessage();
?>
<form name="ftbl_facultyedit" id="ftbl_facultyedit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="tbl_faculty">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_facultyedit" class="ewTable">
<?php if ($tbl_faculty->faculty_id->Visible) { // faculty_id ?>
	<tr id="r_faculty_id"<?php echo $tbl_faculty->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_faculty_faculty_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_faculty->faculty_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_faculty->faculty_id->CellAttributes() ?>><span id="el_tbl_faculty_faculty_id">
<span<?php echo $tbl_faculty->faculty_id->ViewAttributes() ?>>
<?php echo $tbl_faculty->faculty_id->EditValue ?></span>
<input type="hidden" name="x_faculty_id" id="x_faculty_id" value="<?php echo ew_HtmlEncode($tbl_faculty->faculty_id->CurrentValue) ?>">
</span><?php echo $tbl_faculty->faculty_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_faculty->faculty_university->Visible) { // faculty_university ?>
	<tr id="r_faculty_university"<?php echo $tbl_faculty->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_faculty_faculty_university"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_faculty->faculty_university->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_faculty->faculty_university->CellAttributes() ?>><span id="el_tbl_faculty_faculty_university">
<input type="text" name="x_faculty_university" id="x_faculty_university" size="30" value="<?php echo $tbl_faculty->faculty_university->EditValue ?>"<?php echo $tbl_faculty->faculty_university->EditAttributes() ?>>
</span><?php echo $tbl_faculty->faculty_university->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_faculty->faculty_name->Visible) { // faculty_name ?>
	<tr id="r_faculty_name"<?php echo $tbl_faculty->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_faculty_faculty_name"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_faculty->faculty_name->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_faculty->faculty_name->CellAttributes() ?>><span id="el_tbl_faculty_faculty_name">
<textarea name="x_faculty_name" id="x_faculty_name" cols="undefined" rows="undefined"<?php echo $tbl_faculty->faculty_name->EditAttributes() ?>><?php echo $tbl_faculty->faculty_name->EditValue ?></textarea>
</span><?php echo $tbl_faculty->faculty_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_faculty->faculty_code->Visible) { // faculty_code ?>
	<tr id="r_faculty_code"<?php echo $tbl_faculty->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_faculty_faculty_code"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_faculty->faculty_code->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_faculty->faculty_code->CellAttributes() ?>><span id="el_tbl_faculty_faculty_code">
<input type="text" name="x_faculty_code" id="x_faculty_code" size="30" maxlength="200" value="<?php echo $tbl_faculty->faculty_code->EditValue ?>"<?php echo $tbl_faculty->faculty_code->EditAttributes() ?>>
</span><?php echo $tbl_faculty->faculty_code->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_faculty->faculty_active->Visible) { // faculty_active ?>
	<tr id="r_faculty_active"<?php echo $tbl_faculty->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_faculty_faculty_active"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_faculty->faculty_active->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_faculty->faculty_active->CellAttributes() ?>><span id="el_tbl_faculty_faculty_active">
<input type="text" name="x_faculty_active" id="x_faculty_active" size="30" value="<?php echo $tbl_faculty->faculty_active->EditValue ?>"<?php echo $tbl_faculty->faculty_active->EditAttributes() ?>>
</span><?php echo $tbl_faculty->faculty_active->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_faculty->faculty_research->Visible) { // faculty_research ?>
	<tr id="r_faculty_research"<?php echo $tbl_faculty->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_faculty_faculty_research"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_faculty->faculty_research->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_faculty->faculty_research->CellAttributes() ?>><span id="el_tbl_faculty_faculty_research">
<textarea name="x_faculty_research" id="x_faculty_research" cols="35" rows="4"<?php echo $tbl_faculty->faculty_research->EditAttributes() ?>><?php echo $tbl_faculty->faculty_research->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_facultyedit", "x_faculty_research", 35, 4, <?php echo ($tbl_faculty->faculty_research->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_faculty->faculty_research->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_faculty->faculty_lab->Visible) { // faculty_lab ?>
	<tr id="r_faculty_lab"<?php echo $tbl_faculty->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_faculty_faculty_lab"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_faculty->faculty_lab->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_faculty->faculty_lab->CellAttributes() ?>><span id="el_tbl_faculty_faculty_lab">
<textarea name="x_faculty_lab" id="x_faculty_lab" cols="35" rows="4"<?php echo $tbl_faculty->faculty_lab->EditAttributes() ?>><?php echo $tbl_faculty->faculty_lab->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_facultyedit", "x_faculty_lab", 35, 4, <?php echo ($tbl_faculty->faculty_lab->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_faculty->faculty_lab->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
ftbl_facultyedit.Init();
</script>
<?php
$tbl_faculty_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_faculty_edit->Page_Terminate();
?>
