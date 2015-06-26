<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "tbl_subject_facultyinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$tbl_subject_faculty_add = NULL; // Initialize page object first

class ctbl_subject_faculty_add extends ctbl_subject_faculty {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_subject_faculty';

	// Page object name
	var $PageObjName = 'tbl_subject_faculty_add';

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

		// Table object (tbl_subject_faculty)
		if (!isset($GLOBALS["tbl_subject_faculty"])) {
			$GLOBALS["tbl_subject_faculty"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_subject_faculty"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_subject_faculty', TRUE);

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
					$this->Page_Terminate("tbl_subject_facultylist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tbl_subject_facultyview.php")
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
		$this->subject_id->CurrentValue = NULL;
		$this->subject_id->OldValue = $this->subject_id->CurrentValue;
		$this->faculty_id->CurrentValue = NULL;
		$this->faculty_id->OldValue = $this->faculty_id->CurrentValue;
		$this->is_active->CurrentValue = NULL;
		$this->is_active->OldValue = $this->is_active->CurrentValue;
		$this->university_id->CurrentValue = NULL;
		$this->university_id->OldValue = $this->university_id->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->subject_id->FldIsDetailKey) {
			$this->subject_id->setFormValue($objForm->GetValue("x_subject_id"));
		}
		if (!$this->faculty_id->FldIsDetailKey) {
			$this->faculty_id->setFormValue($objForm->GetValue("x_faculty_id"));
		}
		if (!$this->is_active->FldIsDetailKey) {
			$this->is_active->setFormValue($objForm->GetValue("x_is_active"));
		}
		if (!$this->university_id->FldIsDetailKey) {
			$this->university_id->setFormValue($objForm->GetValue("x_university_id"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->subject_id->CurrentValue = $this->subject_id->FormValue;
		$this->faculty_id->CurrentValue = $this->faculty_id->FormValue;
		$this->is_active->CurrentValue = $this->is_active->FormValue;
		$this->university_id->CurrentValue = $this->university_id->FormValue;
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
		$this->subject_id->setDbValue($rs->fields('subject_id'));
		$this->faculty_id->setDbValue($rs->fields('faculty_id'));
		$this->is_active->setDbValue($rs->fields('is_active'));
		$this->university_id->setDbValue($rs->fields('university_id'));
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
		// subject_id
		// faculty_id
		// is_active
		// university_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// subject_id
			if (strval($this->subject_id->CurrentValue) <> "") {
				$sFilterWrk = "`subject_id`" . ew_SearchString("=", $this->subject_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `subject_id`, `subject_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_subject`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->subject_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->subject_id->ViewValue = $this->subject_id->CurrentValue;
				}
			} else {
				$this->subject_id->ViewValue = NULL;
			}
			$this->subject_id->ViewCustomAttributes = "";

			// faculty_id
			if (strval($this->faculty_id->CurrentValue) <> "") {
				$sFilterWrk = "`faculty_id`" . ew_SearchString("=", $this->faculty_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `faculty_id`, `faculty_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_faculty`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->faculty_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->faculty_id->ViewValue = $this->faculty_id->CurrentValue;
				}
			} else {
				$this->faculty_id->ViewValue = NULL;
			}
			$this->faculty_id->ViewCustomAttributes = "";

			// is_active
			$this->is_active->ViewValue = $this->is_active->CurrentValue;
			$this->is_active->ViewCustomAttributes = "";

			// university_id
			$this->university_id->ViewValue = $this->university_id->CurrentValue;
			$this->university_id->ViewCustomAttributes = "";

			// subject_id
			$this->subject_id->LinkCustomAttributes = "";
			$this->subject_id->HrefValue = "";
			$this->subject_id->TooltipValue = "";

			// faculty_id
			$this->faculty_id->LinkCustomAttributes = "";
			$this->faculty_id->HrefValue = "";
			$this->faculty_id->TooltipValue = "";

			// is_active
			$this->is_active->LinkCustomAttributes = "";
			$this->is_active->HrefValue = "";
			$this->is_active->TooltipValue = "";

			// university_id
			$this->university_id->LinkCustomAttributes = "";
			$this->university_id->HrefValue = "";
			$this->university_id->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// subject_id
			$this->subject_id->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `subject_id`, `subject_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tbl_subject`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->subject_id->EditValue = $arwrk;

			// faculty_id
			$this->faculty_id->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `faculty_id`, `faculty_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tbl_faculty`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->faculty_id->EditValue = $arwrk;

			// is_active
			$this->is_active->EditCustomAttributes = "";
			$this->is_active->EditValue = ew_HtmlEncode($this->is_active->CurrentValue);

			// university_id
			$this->university_id->EditCustomAttributes = "";
			$this->university_id->EditValue = ew_HtmlEncode($this->university_id->CurrentValue);

			// Edit refer script
			// subject_id

			$this->subject_id->HrefValue = "";

			// faculty_id
			$this->faculty_id->HrefValue = "";

			// is_active
			$this->is_active->HrefValue = "";

			// university_id
			$this->university_id->HrefValue = "";
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
		if (!ew_CheckInteger($this->is_active->FormValue)) {
			ew_AddMessage($gsFormError, $this->is_active->FldErrMsg());
		}
		if (!ew_CheckInteger($this->university_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->university_id->FldErrMsg());
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

		// subject_id
		$this->subject_id->SetDbValueDef($rsnew, $this->subject_id->CurrentValue, NULL, FALSE);

		// faculty_id
		$this->faculty_id->SetDbValueDef($rsnew, $this->faculty_id->CurrentValue, NULL, FALSE);

		// is_active
		$this->is_active->SetDbValueDef($rsnew, $this->is_active->CurrentValue, NULL, FALSE);

		// university_id
		$this->university_id->SetDbValueDef($rsnew, $this->university_id->CurrentValue, NULL, FALSE);

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
if (!isset($tbl_subject_faculty_add)) $tbl_subject_faculty_add = new ctbl_subject_faculty_add();

// Page init
$tbl_subject_faculty_add->Page_Init();

// Page main
$tbl_subject_faculty_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_subject_faculty_add = new ew_Page("tbl_subject_faculty_add");
tbl_subject_faculty_add.PageID = "add"; // Page ID
var EW_PAGE_ID = tbl_subject_faculty_add.PageID; // For backward compatibility

// Form object
var ftbl_subject_facultyadd = new ew_Form("ftbl_subject_facultyadd");

// Validate form
ftbl_subject_facultyadd.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_is_active"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_subject_faculty->is_active->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_university_id"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_subject_faculty->university_id->FldErrMsg()) ?>");

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
ftbl_subject_facultyadd.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_subject_facultyadd.ValidateRequired = true;
<?php } else { ?>
ftbl_subject_facultyadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_subject_facultyadd.Lists["x_subject_id"] = {"LinkField":"x_subject_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_subject_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_subject_facultyadd.Lists["x_faculty_id"] = {"LinkField":"x_faculty_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_faculty_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_subject_faculty->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $tbl_subject_faculty->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $tbl_subject_faculty_add->ShowPageHeader(); ?>
<?php
$tbl_subject_faculty_add->ShowMessage();
?>
<form name="ftbl_subject_facultyadd" id="ftbl_subject_facultyadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="tbl_subject_faculty">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_subject_facultyadd" class="ewTable">
<?php if ($tbl_subject_faculty->subject_id->Visible) { // subject_id ?>
	<tr id="r_subject_id"<?php echo $tbl_subject_faculty->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_faculty_subject_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject_faculty->subject_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject_faculty->subject_id->CellAttributes() ?>><span id="el_tbl_subject_faculty_subject_id">
<select id="x_subject_id" name="x_subject_id"<?php echo $tbl_subject_faculty->subject_id->EditAttributes() ?>>
<?php
if (is_array($tbl_subject_faculty->subject_id->EditValue)) {
	$arwrk = $tbl_subject_faculty->subject_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_subject_faculty->subject_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_subject_facultyadd.Lists["x_subject_id"].Options = <?php echo (is_array($tbl_subject_faculty->subject_id->EditValue)) ? ew_ArrayToJson($tbl_subject_faculty->subject_id->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_subject_faculty->subject_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject_faculty->faculty_id->Visible) { // faculty_id ?>
	<tr id="r_faculty_id"<?php echo $tbl_subject_faculty->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_faculty_faculty_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject_faculty->faculty_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject_faculty->faculty_id->CellAttributes() ?>><span id="el_tbl_subject_faculty_faculty_id">
<select id="x_faculty_id" name="x_faculty_id"<?php echo $tbl_subject_faculty->faculty_id->EditAttributes() ?>>
<?php
if (is_array($tbl_subject_faculty->faculty_id->EditValue)) {
	$arwrk = $tbl_subject_faculty->faculty_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_subject_faculty->faculty_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_subject_facultyadd.Lists["x_faculty_id"].Options = <?php echo (is_array($tbl_subject_faculty->faculty_id->EditValue)) ? ew_ArrayToJson($tbl_subject_faculty->faculty_id->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_subject_faculty->faculty_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject_faculty->is_active->Visible) { // is_active ?>
	<tr id="r_is_active"<?php echo $tbl_subject_faculty->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_faculty_is_active"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject_faculty->is_active->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject_faculty->is_active->CellAttributes() ?>><span id="el_tbl_subject_faculty_is_active">
<input type="text" name="x_is_active" id="x_is_active" size="30" value="<?php echo $tbl_subject_faculty->is_active->EditValue ?>"<?php echo $tbl_subject_faculty->is_active->EditAttributes() ?>>
</span><?php echo $tbl_subject_faculty->is_active->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject_faculty->university_id->Visible) { // university_id ?>
	<tr id="r_university_id"<?php echo $tbl_subject_faculty->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_faculty_university_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject_faculty->university_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject_faculty->university_id->CellAttributes() ?>><span id="el_tbl_subject_faculty_university_id">
<input type="text" name="x_university_id" id="x_university_id" size="30" value="<?php echo $tbl_subject_faculty->university_id->EditValue ?>"<?php echo $tbl_subject_faculty->university_id->EditAttributes() ?>>
</span><?php echo $tbl_subject_faculty->university_id->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
ftbl_subject_facultyadd.Init();
</script>
<?php
$tbl_subject_faculty_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_subject_faculty_add->Page_Terminate();
?>
