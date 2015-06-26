<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "tbl_subject_group_typeinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$tbl_subject_group_type_add = NULL; // Initialize page object first

class ctbl_subject_group_type_add extends ctbl_subject_group_type {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_subject_group_type';

	// Page object name
	var $PageObjName = 'tbl_subject_group_type_add';

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

		// Table object (tbl_subject_group_type)
		if (!isset($GLOBALS["tbl_subject_group_type"])) {
			$GLOBALS["tbl_subject_group_type"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_subject_group_type"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_subject_group_type', TRUE);

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
			if (@$_GET["subject_type_id"] != "") {
				$this->subject_type_id->setQueryStringValue($_GET["subject_type_id"]);
				$this->setKey("subject_type_id", $this->subject_type_id->CurrentValue); // Set up key
			} else {
				$this->setKey("subject_type_id", ""); // Clear key
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
					$this->Page_Terminate("tbl_subject_group_typelist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tbl_subject_group_typeview.php")
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
		$this->subject_group_type->CurrentValue = NULL;
		$this->subject_group_type->OldValue = $this->subject_group_type->CurrentValue;
		$this->active->CurrentValue = NULL;
		$this->active->OldValue = $this->active->CurrentValue;
		$this->detail->CurrentValue = NULL;
		$this->detail->OldValue = $this->detail->CurrentValue;
		$this->subject_group->CurrentValue = NULL;
		$this->subject_group->OldValue = $this->subject_group->CurrentValue;
		$this->subject_dept->CurrentValue = NULL;
		$this->subject_dept->OldValue = $this->subject_dept->CurrentValue;
		$this->subject_faculty->CurrentValue = NULL;
		$this->subject_faculty->OldValue = $this->subject_faculty->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->subject_group_type->FldIsDetailKey) {
			$this->subject_group_type->setFormValue($objForm->GetValue("x_subject_group_type"));
		}
		if (!$this->active->FldIsDetailKey) {
			$this->active->setFormValue($objForm->GetValue("x_active"));
		}
		if (!$this->detail->FldIsDetailKey) {
			$this->detail->setFormValue($objForm->GetValue("x_detail"));
		}
		if (!$this->subject_group->FldIsDetailKey) {
			$this->subject_group->setFormValue($objForm->GetValue("x_subject_group"));
		}
		if (!$this->subject_dept->FldIsDetailKey) {
			$this->subject_dept->setFormValue($objForm->GetValue("x_subject_dept"));
		}
		if (!$this->subject_faculty->FldIsDetailKey) {
			$this->subject_faculty->setFormValue($objForm->GetValue("x_subject_faculty"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->subject_group_type->CurrentValue = $this->subject_group_type->FormValue;
		$this->active->CurrentValue = $this->active->FormValue;
		$this->detail->CurrentValue = $this->detail->FormValue;
		$this->subject_group->CurrentValue = $this->subject_group->FormValue;
		$this->subject_dept->CurrentValue = $this->subject_dept->FormValue;
		$this->subject_faculty->CurrentValue = $this->subject_faculty->FormValue;
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
		$this->subject_type_id->setDbValue($rs->fields('subject_type_id'));
		$this->subject_group_type->setDbValue($rs->fields('subject_group_type'));
		$this->active->setDbValue($rs->fields('active'));
		$this->detail->setDbValue($rs->fields('detail'));
		$this->subject_group->setDbValue($rs->fields('subject_group'));
		$this->subject_dept->setDbValue($rs->fields('subject_dept'));
		$this->subject_faculty->setDbValue($rs->fields('subject_faculty'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("subject_type_id")) <> "")
			$this->subject_type_id->CurrentValue = $this->getKey("subject_type_id"); // subject_type_id
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
		// subject_type_id
		// subject_group_type
		// active
		// detail
		// subject_group
		// subject_dept
		// subject_faculty

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// subject_type_id
			$this->subject_type_id->ViewValue = $this->subject_type_id->CurrentValue;
			$this->subject_type_id->ViewCustomAttributes = "";

			// subject_group_type
			$this->subject_group_type->ViewValue = $this->subject_group_type->CurrentValue;
			$this->subject_group_type->ViewCustomAttributes = "";

			// active
			$this->active->ViewValue = $this->active->CurrentValue;
			$this->active->ViewCustomAttributes = "";

			// detail
			$this->detail->ViewValue = $this->detail->CurrentValue;
			$this->detail->ViewCustomAttributes = "";

			// subject_group
			if (strval($this->subject_group->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->subject_group->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `id`, `subject_group_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_subject_group`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->subject_group->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->subject_group->ViewValue = $this->subject_group->CurrentValue;
				}
			} else {
				$this->subject_group->ViewValue = NULL;
			}
			$this->subject_group->ViewCustomAttributes = "";

			// subject_dept
			if (strval($this->subject_dept->CurrentValue) <> "") {
				$sFilterWrk = "`dept_id`" . ew_SearchString("=", $this->subject_dept->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `dept_id`, `dept_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_dept`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->subject_dept->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->subject_dept->ViewValue = $this->subject_dept->CurrentValue;
				}
			} else {
				$this->subject_dept->ViewValue = NULL;
			}
			$this->subject_dept->ViewCustomAttributes = "";

			// subject_faculty
			if (strval($this->subject_faculty->CurrentValue) <> "") {
				$sFilterWrk = "`faculty_id`" . ew_SearchString("=", $this->subject_faculty->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `faculty_id`, `faculty_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_faculty`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->subject_faculty->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->subject_faculty->ViewValue = $this->subject_faculty->CurrentValue;
				}
			} else {
				$this->subject_faculty->ViewValue = NULL;
			}
			$this->subject_faculty->ViewCustomAttributes = "";

			// subject_group_type
			$this->subject_group_type->LinkCustomAttributes = "";
			$this->subject_group_type->HrefValue = "";
			$this->subject_group_type->TooltipValue = "";

			// active
			$this->active->LinkCustomAttributes = "";
			$this->active->HrefValue = "";
			$this->active->TooltipValue = "";

			// detail
			$this->detail->LinkCustomAttributes = "";
			$this->detail->HrefValue = "";
			$this->detail->TooltipValue = "";

			// subject_group
			$this->subject_group->LinkCustomAttributes = "";
			$this->subject_group->HrefValue = "";
			$this->subject_group->TooltipValue = "";

			// subject_dept
			$this->subject_dept->LinkCustomAttributes = "";
			$this->subject_dept->HrefValue = "";
			$this->subject_dept->TooltipValue = "";

			// subject_faculty
			$this->subject_faculty->LinkCustomAttributes = "";
			$this->subject_faculty->HrefValue = "";
			$this->subject_faculty->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// subject_group_type
			$this->subject_group_type->EditCustomAttributes = "";
			$this->subject_group_type->EditValue = ew_HtmlEncode($this->subject_group_type->CurrentValue);

			// active
			$this->active->EditCustomAttributes = "";
			$this->active->EditValue = ew_HtmlEncode($this->active->CurrentValue);

			// detail
			$this->detail->EditCustomAttributes = "";
			$this->detail->EditValue = ew_HtmlEncode($this->detail->CurrentValue);

			// subject_group
			$this->subject_group->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `id`, `subject_group_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tbl_subject_group`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->subject_group->EditValue = $arwrk;

			// subject_dept
			$this->subject_dept->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `dept_id`, `dept_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tbl_dept`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->subject_dept->EditValue = $arwrk;

			// subject_faculty
			$this->subject_faculty->EditCustomAttributes = "";
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
			$this->subject_faculty->EditValue = $arwrk;

			// Edit refer script
			// subject_group_type

			$this->subject_group_type->HrefValue = "";

			// active
			$this->active->HrefValue = "";

			// detail
			$this->detail->HrefValue = "";

			// subject_group
			$this->subject_group->HrefValue = "";

			// subject_dept
			$this->subject_dept->HrefValue = "";

			// subject_faculty
			$this->subject_faculty->HrefValue = "";
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

		// subject_group_type
		$this->subject_group_type->SetDbValueDef($rsnew, $this->subject_group_type->CurrentValue, NULL, FALSE);

		// active
		$this->active->SetDbValueDef($rsnew, $this->active->CurrentValue, NULL, FALSE);

		// detail
		$this->detail->SetDbValueDef($rsnew, $this->detail->CurrentValue, NULL, FALSE);

		// subject_group
		$this->subject_group->SetDbValueDef($rsnew, $this->subject_group->CurrentValue, NULL, FALSE);

		// subject_dept
		$this->subject_dept->SetDbValueDef($rsnew, $this->subject_dept->CurrentValue, NULL, FALSE);

		// subject_faculty
		$this->subject_faculty->SetDbValueDef($rsnew, $this->subject_faculty->CurrentValue, NULL, FALSE);

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
			$this->subject_type_id->setDbValue($conn->Insert_ID());
			$rsnew['subject_type_id'] = $this->subject_type_id->DbValue;
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
if (!isset($tbl_subject_group_type_add)) $tbl_subject_group_type_add = new ctbl_subject_group_type_add();

// Page init
$tbl_subject_group_type_add->Page_Init();

// Page main
$tbl_subject_group_type_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_subject_group_type_add = new ew_Page("tbl_subject_group_type_add");
tbl_subject_group_type_add.PageID = "add"; // Page ID
var EW_PAGE_ID = tbl_subject_group_type_add.PageID; // For backward compatibility

// Form object
var ftbl_subject_group_typeadd = new ew_Form("ftbl_subject_group_typeadd");

// Validate form
ftbl_subject_group_typeadd.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_active"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_subject_group_type->active->FldErrMsg()) ?>");

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
ftbl_subject_group_typeadd.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_subject_group_typeadd.ValidateRequired = true;
<?php } else { ?>
ftbl_subject_group_typeadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_subject_group_typeadd.Lists["x_subject_group"] = {"LinkField":"x_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_subject_group_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_subject_group_typeadd.Lists["x_subject_dept"] = {"LinkField":"x_dept_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_dept_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_subject_group_typeadd.Lists["x_subject_faculty"] = {"LinkField":"x_faculty_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_faculty_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_subject_group_type->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $tbl_subject_group_type->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $tbl_subject_group_type_add->ShowPageHeader(); ?>
<?php
$tbl_subject_group_type_add->ShowMessage();
?>
<form name="ftbl_subject_group_typeadd" id="ftbl_subject_group_typeadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="tbl_subject_group_type">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_subject_group_typeadd" class="ewTable">
<?php if ($tbl_subject_group_type->subject_group_type->Visible) { // subject_group_type ?>
	<tr id="r_subject_group_type"<?php echo $tbl_subject_group_type->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_group_type_subject_group_type"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject_group_type->subject_group_type->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject_group_type->subject_group_type->CellAttributes() ?>><span id="el_tbl_subject_group_type_subject_group_type">
<textarea name="x_subject_group_type" id="x_subject_group_type" cols="undefined" rows="undefined"<?php echo $tbl_subject_group_type->subject_group_type->EditAttributes() ?>><?php echo $tbl_subject_group_type->subject_group_type->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_subject_group_typeadd", "x_subject_group_type", 0, 0, <?php echo ($tbl_subject_group_type->subject_group_type->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_subject_group_type->subject_group_type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject_group_type->active->Visible) { // active ?>
	<tr id="r_active"<?php echo $tbl_subject_group_type->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_group_type_active"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject_group_type->active->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject_group_type->active->CellAttributes() ?>><span id="el_tbl_subject_group_type_active">
<input type="text" name="x_active" id="x_active" size="30" value="<?php echo $tbl_subject_group_type->active->EditValue ?>"<?php echo $tbl_subject_group_type->active->EditAttributes() ?>>
</span><?php echo $tbl_subject_group_type->active->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject_group_type->detail->Visible) { // detail ?>
	<tr id="r_detail"<?php echo $tbl_subject_group_type->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_group_type_detail"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject_group_type->detail->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject_group_type->detail->CellAttributes() ?>><span id="el_tbl_subject_group_type_detail">
<textarea name="x_detail" id="x_detail" cols="35" rows="4"<?php echo $tbl_subject_group_type->detail->EditAttributes() ?>><?php echo $tbl_subject_group_type->detail->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_subject_group_typeadd", "x_detail", 35, 4, <?php echo ($tbl_subject_group_type->detail->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_subject_group_type->detail->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject_group_type->subject_group->Visible) { // subject_group ?>
	<tr id="r_subject_group"<?php echo $tbl_subject_group_type->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_group_type_subject_group"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject_group_type->subject_group->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject_group_type->subject_group->CellAttributes() ?>><span id="el_tbl_subject_group_type_subject_group">
<select id="x_subject_group" name="x_subject_group"<?php echo $tbl_subject_group_type->subject_group->EditAttributes() ?>>
<?php
if (is_array($tbl_subject_group_type->subject_group->EditValue)) {
	$arwrk = $tbl_subject_group_type->subject_group->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_subject_group_type->subject_group->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_subject_group_typeadd.Lists["x_subject_group"].Options = <?php echo (is_array($tbl_subject_group_type->subject_group->EditValue)) ? ew_ArrayToJson($tbl_subject_group_type->subject_group->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_subject_group_type->subject_group->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject_group_type->subject_dept->Visible) { // subject_dept ?>
	<tr id="r_subject_dept"<?php echo $tbl_subject_group_type->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_group_type_subject_dept"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject_group_type->subject_dept->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject_group_type->subject_dept->CellAttributes() ?>><span id="el_tbl_subject_group_type_subject_dept">
<select id="x_subject_dept" name="x_subject_dept"<?php echo $tbl_subject_group_type->subject_dept->EditAttributes() ?>>
<?php
if (is_array($tbl_subject_group_type->subject_dept->EditValue)) {
	$arwrk = $tbl_subject_group_type->subject_dept->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_subject_group_type->subject_dept->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_subject_group_typeadd.Lists["x_subject_dept"].Options = <?php echo (is_array($tbl_subject_group_type->subject_dept->EditValue)) ? ew_ArrayToJson($tbl_subject_group_type->subject_dept->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_subject_group_type->subject_dept->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject_group_type->subject_faculty->Visible) { // subject_faculty ?>
	<tr id="r_subject_faculty"<?php echo $tbl_subject_group_type->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_group_type_subject_faculty"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject_group_type->subject_faculty->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject_group_type->subject_faculty->CellAttributes() ?>><span id="el_tbl_subject_group_type_subject_faculty">
<select id="x_subject_faculty" name="x_subject_faculty"<?php echo $tbl_subject_group_type->subject_faculty->EditAttributes() ?>>
<?php
if (is_array($tbl_subject_group_type->subject_faculty->EditValue)) {
	$arwrk = $tbl_subject_group_type->subject_faculty->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_subject_group_type->subject_faculty->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_subject_group_typeadd.Lists["x_subject_faculty"].Options = <?php echo (is_array($tbl_subject_group_type->subject_faculty->EditValue)) ? ew_ArrayToJson($tbl_subject_group_type->subject_faculty->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_subject_group_type->subject_faculty->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
ftbl_subject_group_typeadd.Init();
</script>
<?php
$tbl_subject_group_type_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_subject_group_type_add->Page_Terminate();
?>
