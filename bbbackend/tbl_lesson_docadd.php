<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "tbl_lesson_docinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$tbl_lesson_doc_add = NULL; // Initialize page object first

class ctbl_lesson_doc_add extends ctbl_lesson_doc {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_lesson_doc';

	// Page object name
	var $PageObjName = 'tbl_lesson_doc_add';

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

		// Table object (tbl_lesson_doc)
		if (!isset($GLOBALS["tbl_lesson_doc"])) {
			$GLOBALS["tbl_lesson_doc"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_lesson_doc"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_lesson_doc', TRUE);

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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("tbl_lesson_doclist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tbl_lesson_docview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
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

	// Load default values
	function LoadDefaultValues() {
		$this->lesson_id->CurrentValue = NULL;
		$this->lesson_id->OldValue = $this->lesson_id->CurrentValue;
		$this->doc_id->CurrentValue = NULL;
		$this->doc_id->OldValue = $this->doc_id->CurrentValue;
		$this->active->CurrentValue = NULL;
		$this->active->OldValue = $this->active->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->lesson_id->FldIsDetailKey) {
			$this->lesson_id->setFormValue($objForm->GetValue("x_lesson_id"));
		}
		if (!$this->doc_id->FldIsDetailKey) {
			$this->doc_id->setFormValue($objForm->GetValue("x_doc_id"));
		}
		if (!$this->active->FldIsDetailKey) {
			$this->active->setFormValue($objForm->GetValue("x_active"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->lesson_id->CurrentValue = $this->lesson_id->FormValue;
		$this->doc_id->CurrentValue = $this->doc_id->FormValue;
		$this->active->CurrentValue = $this->active->FormValue;
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
		$this->id->setDbValue($rs->fields('id'));
		$this->lesson_id->setDbValue($rs->fields('lesson_id'));
		$this->doc_id->setDbValue($rs->fields('doc_id'));
		$this->active->setDbValue($rs->fields('active'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// lesson_id
		// doc_id
		// active

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// lesson_id
			if (strval($this->lesson_id->CurrentValue) <> "") {
				$sFilterWrk = "`lesson_id`" . ew_SearchString("=", $this->lesson_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `lesson_id`, `lesson_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_lesson`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->lesson_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->lesson_id->ViewValue = $this->lesson_id->CurrentValue;
				}
			} else {
				$this->lesson_id->ViewValue = NULL;
			}
			$this->lesson_id->ViewCustomAttributes = "";

			// doc_id
			$this->doc_id->ViewValue = $this->doc_id->CurrentValue;
			if (strval($this->doc_id->CurrentValue) <> "") {
				$sFilterWrk = "`doc_id`" . ew_SearchString("=", $this->doc_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `doc_id`, `doc_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_doc`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->doc_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->doc_id->ViewValue = $this->doc_id->CurrentValue;
				}
			} else {
				$this->doc_id->ViewValue = NULL;
			}
			$this->doc_id->ViewCustomAttributes = "";

			// active
			$this->active->ViewValue = $this->active->CurrentValue;
			$this->active->ViewCustomAttributes = "";

			// lesson_id
			$this->lesson_id->LinkCustomAttributes = "";
			$this->lesson_id->HrefValue = "";
			$this->lesson_id->TooltipValue = "";

			// doc_id
			$this->doc_id->LinkCustomAttributes = "";
			$this->doc_id->HrefValue = "";
			$this->doc_id->TooltipValue = "";

			// active
			$this->active->LinkCustomAttributes = "";
			$this->active->HrefValue = "";
			$this->active->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// lesson_id
			$this->lesson_id->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `lesson_id`, `lesson_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tbl_lesson`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->lesson_id->EditValue = $arwrk;

			// doc_id
			$this->doc_id->EditCustomAttributes = "";
			$this->doc_id->EditValue = ew_HtmlEncode($this->doc_id->CurrentValue);
			if (strval($this->doc_id->CurrentValue) <> "") {
				$sFilterWrk = "`doc_id`" . ew_SearchString("=", $this->doc_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `doc_id`, `doc_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_doc`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->doc_id->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->doc_id->EditValue = $this->doc_id->CurrentValue;
				}
			} else {
				$this->doc_id->EditValue = NULL;
			}

			// active
			$this->active->EditCustomAttributes = "";
			$this->active->EditValue = ew_HtmlEncode($this->active->CurrentValue);

			// Edit refer script
			// lesson_id

			$this->lesson_id->HrefValue = "";

			// doc_id
			$this->doc_id->HrefValue = "";

			// active
			$this->active->HrefValue = "";
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
		if (!ew_CheckInteger($this->doc_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->doc_id->FldErrMsg());
		}
		if (!ew_CheckInteger($this->active->FormValue)) {
			ew_AddMessage($gsFormError, $this->active->FldErrMsg());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;
		$rsnew = array();

		// lesson_id
		$this->lesson_id->SetDbValueDef($rsnew, $this->lesson_id->CurrentValue, NULL, FALSE);

		// doc_id
		$this->doc_id->SetDbValueDef($rsnew, $this->doc_id->CurrentValue, NULL, FALSE);

		// active
		$this->active->SetDbValueDef($rsnew, $this->active->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$this->id->setDbValue($conn->Insert_ID());
			$rsnew['id'] = $this->id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
if (!isset($tbl_lesson_doc_add)) $tbl_lesson_doc_add = new ctbl_lesson_doc_add();

// Page init
$tbl_lesson_doc_add->Page_Init();

// Page main
$tbl_lesson_doc_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_lesson_doc_add = new ew_Page("tbl_lesson_doc_add");
tbl_lesson_doc_add.PageID = "add"; // Page ID
var EW_PAGE_ID = tbl_lesson_doc_add.PageID; // For backward compatibility

// Form object
var ftbl_lesson_docadd = new ew_Form("ftbl_lesson_docadd");

// Validate form
ftbl_lesson_docadd.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_doc_id"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_lesson_doc->doc_id->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_active"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_lesson_doc->active->FldErrMsg()) ?>");

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
ftbl_lesson_docadd.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_lesson_docadd.ValidateRequired = true;
<?php } else { ?>
ftbl_lesson_docadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_lesson_docadd.Lists["x_lesson_id"] = {"LinkField":"x_lesson_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_lesson_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_lesson_docadd.Lists["x_doc_id"] = {"LinkField":"x_doc_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_doc_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_lesson_doc->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $tbl_lesson_doc->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $tbl_lesson_doc_add->ShowPageHeader(); ?>
<?php
$tbl_lesson_doc_add->ShowMessage();
?>
<form name="ftbl_lesson_docadd" id="ftbl_lesson_docadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="tbl_lesson_doc">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_lesson_docadd" class="ewTable">
<?php if ($tbl_lesson_doc->lesson_id->Visible) { // lesson_id ?>
	<tr id="r_lesson_id"<?php echo $tbl_lesson_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_lesson_doc_lesson_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_lesson_doc->lesson_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_lesson_doc->lesson_id->CellAttributes() ?>><span id="el_tbl_lesson_doc_lesson_id">
<select id="x_lesson_id" name="x_lesson_id"<?php echo $tbl_lesson_doc->lesson_id->EditAttributes() ?>>
<?php
if (is_array($tbl_lesson_doc->lesson_id->EditValue)) {
	$arwrk = $tbl_lesson_doc->lesson_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_lesson_doc->lesson_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
<script type="text/javascript">
ftbl_lesson_docadd.Lists["x_lesson_id"].Options = <?php echo (is_array($tbl_lesson_doc->lesson_id->EditValue)) ? ew_ArrayToJson($tbl_lesson_doc->lesson_id->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_lesson_doc->lesson_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_lesson_doc->doc_id->Visible) { // doc_id ?>
	<tr id="r_doc_id"<?php echo $tbl_lesson_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_lesson_doc_doc_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_lesson_doc->doc_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_lesson_doc->doc_id->CellAttributes() ?>><span id="el_tbl_lesson_doc_doc_id">
<?php
	$wrkonchange = trim(" " . @$tbl_lesson_doc->doc_id->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$tbl_lesson_doc->doc_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_doc_id" style="white-space: nowrap; z-index: 8970">
	<input type="text" name="sv_x_doc_id" id="sv_x_doc_id" value="<?php echo $tbl_lesson_doc->doc_id->EditValue ?>" size="30"<?php echo $tbl_lesson_doc->doc_id->EditAttributes() ?>>&nbsp;<span id="em_x_doc_id" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x_doc_id" style="display: inline; z-index: 8970"></div>
</span>
<input type="hidden" name="x_doc_id" id="x_doc_id" value="<?php echo $tbl_lesson_doc->doc_id->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `doc_id`, `doc_name` FROM `tbl_doc`";
$sWhereWrk = "`doc_name` LIKE '{query_value}%'";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x_doc_id" id="q_x_doc_id" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($tbl_lesson_doc->doc_id->LookupFn) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x_doc_id", ftbl_lesson_docadd, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
oas.formatResult = function(ar) {
	var dv = ar[1];
	for (var i = 2; i <= 4; i++)
		dv += (ar[i]) ? ew_ValueSeparator(i - 1, "x_doc_id") + ar[i] : "";
	return dv;
}
oas.ac.typeAhead = false;
ftbl_lesson_docadd.AutoSuggests["x_doc_id"] = oas;
</script>
</span><?php echo $tbl_lesson_doc->doc_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_lesson_doc->active->Visible) { // active ?>
	<tr id="r_active"<?php echo $tbl_lesson_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_lesson_doc_active"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_lesson_doc->active->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_lesson_doc->active->CellAttributes() ?>><span id="el_tbl_lesson_doc_active">
<input type="text" name="x_active" id="x_active" size="30" value="<?php echo $tbl_lesson_doc->active->EditValue ?>"<?php echo $tbl_lesson_doc->active->EditAttributes() ?>>
</span><?php echo $tbl_lesson_doc->active->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
ftbl_lesson_docadd.Init();
</script>
<?php
$tbl_lesson_doc_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_lesson_doc_add->Page_Terminate();
?>
