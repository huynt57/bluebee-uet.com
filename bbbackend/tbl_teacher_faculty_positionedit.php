<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "tbl_teacher_faculty_positioninfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$tbl_teacher_faculty_position_edit = NULL; // Initialize page object first

class ctbl_teacher_faculty_position_edit extends ctbl_teacher_faculty_position {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_teacher_faculty_position';

	// Page object name
	var $PageObjName = 'tbl_teacher_faculty_position_edit';

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

		// Table object (tbl_teacher_faculty_position)
		if (!isset($GLOBALS["tbl_teacher_faculty_position"])) {
			$GLOBALS["tbl_teacher_faculty_position"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_teacher_faculty_position"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_teacher_faculty_position', TRUE);

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
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		if (@$_GET["id"] <> "")
			$this->id->setQueryStringValue($_GET["id"]);

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id->CurrentValue == "")
			$this->Page_Terminate("tbl_teacher_faculty_positionlist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("tbl_teacher_faculty_positionlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tbl_teacher_faculty_positionview.php")
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
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->teacher_id->FldIsDetailKey) {
			$this->teacher_id->setFormValue($objForm->GetValue("x_teacher_id"));
		}
		if (!$this->teacher_name->FldIsDetailKey) {
			$this->teacher_name->setFormValue($objForm->GetValue("x_teacher_name"));
		}
		if (!$this->faculty_id->FldIsDetailKey) {
			$this->faculty_id->setFormValue($objForm->GetValue("x_faculty_id"));
		}
		if (!$this->teacher_position->FldIsDetailKey) {
			$this->teacher_position->setFormValue($objForm->GetValue("x_teacher_position"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->teacher_id->CurrentValue = $this->teacher_id->FormValue;
		$this->teacher_name->CurrentValue = $this->teacher_name->FormValue;
		$this->faculty_id->CurrentValue = $this->faculty_id->FormValue;
		$this->teacher_position->CurrentValue = $this->teacher_position->FormValue;
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
		$this->teacher_id->setDbValue($rs->fields('teacher_id'));
		$this->teacher_name->setDbValue($rs->fields('teacher_name'));
		$this->faculty_id->setDbValue($rs->fields('faculty_id'));
		$this->teacher_position->setDbValue($rs->fields('teacher_position'));
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
		// teacher_id
		// teacher_name
		// faculty_id
		// teacher_position

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// teacher_id
			if (strval($this->teacher_id->CurrentValue) <> "") {
				$sFilterWrk = "`teacher_id`" . ew_SearchString("=", $this->teacher_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `teacher_id`, `teacher_id` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_teacher`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->teacher_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->teacher_id->ViewValue = $this->teacher_id->CurrentValue;
				}
			} else {
				$this->teacher_id->ViewValue = NULL;
			}
			$this->teacher_id->ViewCustomAttributes = "";

			// teacher_name
			if (strval($this->teacher_name->CurrentValue) <> "") {
				$sFilterWrk = "`teacher_name`" . ew_SearchString("=", $this->teacher_name->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `teacher_name`, `teacher_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_teacher`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->teacher_name->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->teacher_name->ViewValue = $this->teacher_name->CurrentValue;
				}
			} else {
				$this->teacher_name->ViewValue = NULL;
			}
			$this->teacher_name->ViewCustomAttributes = "";

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

			// teacher_position
			$this->teacher_position->ViewValue = $this->teacher_position->CurrentValue;
			$this->teacher_position->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// teacher_id
			$this->teacher_id->LinkCustomAttributes = "";
			$this->teacher_id->HrefValue = "";
			$this->teacher_id->TooltipValue = "";

			// teacher_name
			$this->teacher_name->LinkCustomAttributes = "";
			$this->teacher_name->HrefValue = "";
			$this->teacher_name->TooltipValue = "";

			// faculty_id
			$this->faculty_id->LinkCustomAttributes = "";
			$this->faculty_id->HrefValue = "";
			$this->faculty_id->TooltipValue = "";

			// teacher_position
			$this->teacher_position->LinkCustomAttributes = "";
			$this->teacher_position->HrefValue = "";
			$this->teacher_position->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// teacher_id
			$this->teacher_id->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `teacher_id`, `teacher_id` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tbl_teacher`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->teacher_id->EditValue = $arwrk;

			// teacher_name
			$this->teacher_name->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `teacher_name`, `teacher_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tbl_teacher`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->teacher_name->EditValue = $arwrk;

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

			// teacher_position
			$this->teacher_position->EditCustomAttributes = "";
			$this->teacher_position->EditValue = ew_HtmlEncode($this->teacher_position->CurrentValue);

			// Edit refer script
			// id

			$this->id->HrefValue = "";

			// teacher_id
			$this->teacher_id->HrefValue = "";

			// teacher_name
			$this->teacher_name->HrefValue = "";

			// faculty_id
			$this->faculty_id->HrefValue = "";

			// teacher_position
			$this->teacher_position->HrefValue = "";
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

			// teacher_id
			$this->teacher_id->SetDbValueDef($rsnew, $this->teacher_id->CurrentValue, NULL, $this->teacher_id->ReadOnly);

			// teacher_name
			$this->teacher_name->SetDbValueDef($rsnew, $this->teacher_name->CurrentValue, NULL, $this->teacher_name->ReadOnly);

			// faculty_id
			$this->faculty_id->SetDbValueDef($rsnew, $this->faculty_id->CurrentValue, NULL, $this->faculty_id->ReadOnly);

			// teacher_position
			$this->teacher_position->SetDbValueDef($rsnew, $this->teacher_position->CurrentValue, NULL, $this->teacher_position->ReadOnly);

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
if (!isset($tbl_teacher_faculty_position_edit)) $tbl_teacher_faculty_position_edit = new ctbl_teacher_faculty_position_edit();

// Page init
$tbl_teacher_faculty_position_edit->Page_Init();

// Page main
$tbl_teacher_faculty_position_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_teacher_faculty_position_edit = new ew_Page("tbl_teacher_faculty_position_edit");
tbl_teacher_faculty_position_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = tbl_teacher_faculty_position_edit.PageID; // For backward compatibility

// Form object
var ftbl_teacher_faculty_positionedit = new ew_Form("ftbl_teacher_faculty_positionedit");

// Validate form
ftbl_teacher_faculty_positionedit.Validate = function(fobj) {
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
ftbl_teacher_faculty_positionedit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_teacher_faculty_positionedit.ValidateRequired = true;
<?php } else { ?>
ftbl_teacher_faculty_positionedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_teacher_faculty_positionedit.Lists["x_teacher_id"] = {"LinkField":"x_teacher_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_teacher_id","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_teacher_faculty_positionedit.Lists["x_teacher_name"] = {"LinkField":"x_teacher_name","Ajax":null,"AutoFill":false,"DisplayFields":["x_teacher_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_teacher_faculty_positionedit.Lists["x_faculty_id"] = {"LinkField":"x_faculty_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_faculty_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_teacher_faculty_position->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $tbl_teacher_faculty_position->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $tbl_teacher_faculty_position_edit->ShowPageHeader(); ?>
<?php
$tbl_teacher_faculty_position_edit->ShowMessage();
?>
<form name="ftbl_teacher_faculty_positionedit" id="ftbl_teacher_faculty_positionedit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="tbl_teacher_faculty_position">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_teacher_faculty_positionedit" class="ewTable">
<?php if ($tbl_teacher_faculty_position->id->Visible) { // id ?>
	<tr id="r_id"<?php echo $tbl_teacher_faculty_position->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_faculty_position_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher_faculty_position->id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher_faculty_position->id->CellAttributes() ?>><span id="el_tbl_teacher_faculty_position_id">
<span<?php echo $tbl_teacher_faculty_position->id->ViewAttributes() ?>>
<?php echo $tbl_teacher_faculty_position->id->EditValue ?></span>
<input type="hidden" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($tbl_teacher_faculty_position->id->CurrentValue) ?>">
</span><?php echo $tbl_teacher_faculty_position->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher_faculty_position->teacher_id->Visible) { // teacher_id ?>
	<tr id="r_teacher_id"<?php echo $tbl_teacher_faculty_position->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_faculty_position_teacher_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher_faculty_position->teacher_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher_faculty_position->teacher_id->CellAttributes() ?>><span id="el_tbl_teacher_faculty_position_teacher_id">
<select id="x_teacher_id" name="x_teacher_id"<?php echo $tbl_teacher_faculty_position->teacher_id->EditAttributes() ?>>
<?php
if (is_array($tbl_teacher_faculty_position->teacher_id->EditValue)) {
	$arwrk = $tbl_teacher_faculty_position->teacher_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_teacher_faculty_position->teacher_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_teacher_faculty_positionedit.Lists["x_teacher_id"].Options = <?php echo (is_array($tbl_teacher_faculty_position->teacher_id->EditValue)) ? ew_ArrayToJson($tbl_teacher_faculty_position->teacher_id->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_teacher_faculty_position->teacher_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher_faculty_position->teacher_name->Visible) { // teacher_name ?>
	<tr id="r_teacher_name"<?php echo $tbl_teacher_faculty_position->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_faculty_position_teacher_name"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher_faculty_position->teacher_name->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher_faculty_position->teacher_name->CellAttributes() ?>><span id="el_tbl_teacher_faculty_position_teacher_name">
<select id="x_teacher_name" name="x_teacher_name"<?php echo $tbl_teacher_faculty_position->teacher_name->EditAttributes() ?>>
<?php
if (is_array($tbl_teacher_faculty_position->teacher_name->EditValue)) {
	$arwrk = $tbl_teacher_faculty_position->teacher_name->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_teacher_faculty_position->teacher_name->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_teacher_faculty_positionedit.Lists["x_teacher_name"].Options = <?php echo (is_array($tbl_teacher_faculty_position->teacher_name->EditValue)) ? ew_ArrayToJson($tbl_teacher_faculty_position->teacher_name->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_teacher_faculty_position->teacher_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher_faculty_position->faculty_id->Visible) { // faculty_id ?>
	<tr id="r_faculty_id"<?php echo $tbl_teacher_faculty_position->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_faculty_position_faculty_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher_faculty_position->faculty_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher_faculty_position->faculty_id->CellAttributes() ?>><span id="el_tbl_teacher_faculty_position_faculty_id">
<select id="x_faculty_id" name="x_faculty_id"<?php echo $tbl_teacher_faculty_position->faculty_id->EditAttributes() ?>>
<?php
if (is_array($tbl_teacher_faculty_position->faculty_id->EditValue)) {
	$arwrk = $tbl_teacher_faculty_position->faculty_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_teacher_faculty_position->faculty_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_teacher_faculty_positionedit.Lists["x_faculty_id"].Options = <?php echo (is_array($tbl_teacher_faculty_position->faculty_id->EditValue)) ? ew_ArrayToJson($tbl_teacher_faculty_position->faculty_id->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_teacher_faculty_position->faculty_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher_faculty_position->teacher_position->Visible) { // teacher_position ?>
	<tr id="r_teacher_position"<?php echo $tbl_teacher_faculty_position->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_faculty_position_teacher_position"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher_faculty_position->teacher_position->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher_faculty_position->teacher_position->CellAttributes() ?>><span id="el_tbl_teacher_faculty_position_teacher_position">
<input type="text" name="x_teacher_position" id="x_teacher_position" size="30" maxlength="255" value="<?php echo $tbl_teacher_faculty_position->teacher_position->EditValue ?>"<?php echo $tbl_teacher_faculty_position->teacher_position->EditAttributes() ?>>
</span><?php echo $tbl_teacher_faculty_position->teacher_position->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
ftbl_teacher_faculty_positionedit.Init();
</script>
<?php
$tbl_teacher_faculty_position_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_teacher_faculty_position_edit->Page_Terminate();
?>
