<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "tbl_subjectinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$tbl_subject_edit = NULL; // Initialize page object first

class ctbl_subject_edit extends ctbl_subject {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_subject';

	// Page object name
	var $PageObjName = 'tbl_subject_edit';

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

		// Table object (tbl_subject)
		if (!isset($GLOBALS["tbl_subject"])) {
			$GLOBALS["tbl_subject"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_subject"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_subject', TRUE);

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
		$this->subject_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		if (@$_GET["subject_id"] <> "")
			$this->subject_id->setQueryStringValue($_GET["subject_id"]);

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->subject_id->CurrentValue == "")
			$this->Page_Terminate("tbl_subjectlist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("tbl_subjectlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tbl_subjectview.php")
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
		if (!$this->subject_id->FldIsDetailKey)
			$this->subject_id->setFormValue($objForm->GetValue("x_subject_id"));
		if (!$this->subject_name->FldIsDetailKey) {
			$this->subject_name->setFormValue($objForm->GetValue("x_subject_name"));
		}
		if (!$this->subject_code->FldIsDetailKey) {
			$this->subject_code->setFormValue($objForm->GetValue("x_subject_code"));
		}
		if (!$this->subject_active->FldIsDetailKey) {
			$this->subject_active->setFormValue($objForm->GetValue("x_subject_active"));
		}
		if (!$this->subject_university->FldIsDetailKey) {
			$this->subject_university->setFormValue($objForm->GetValue("x_subject_university"));
		}
		if (!$this->subject_type->FldIsDetailKey) {
			$this->subject_type->setFormValue($objForm->GetValue("x_subject_type"));
		}
		if (!$this->subject_year->FldIsDetailKey) {
			$this->subject_year->setFormValue($objForm->GetValue("x_subject_year"));
		}
		if (!$this->subject_credits->FldIsDetailKey) {
			$this->subject_credits->setFormValue($objForm->GetValue("x_subject_credits"));
		}
		if (!$this->subject_credit_hour->FldIsDetailKey) {
			$this->subject_credit_hour->setFormValue($objForm->GetValue("x_subject_credit_hour"));
		}
		if (!$this->subject_requirement->FldIsDetailKey) {
			$this->subject_requirement->setFormValue($objForm->GetValue("x_subject_requirement"));
		}
		if (!$this->subject_target->FldIsDetailKey) {
			$this->subject_target->setFormValue($objForm->GetValue("x_subject_target"));
		}
		if (!$this->subject_info->FldIsDetailKey) {
			$this->subject_info->setFormValue($objForm->GetValue("x_subject_info"));
		}
		if (!$this->subject_test->FldIsDetailKey) {
			$this->subject_test->setFormValue($objForm->GetValue("x_subject_test"));
		}
		if (!$this->subject_faculty->FldIsDetailKey) {
			$this->subject_faculty->setFormValue($objForm->GetValue("x_subject_faculty"));
		}
		if (!$this->subject_dept->FldIsDetailKey) {
			$this->subject_dept->setFormValue($objForm->GetValue("x_subject_dept"));
		}
		if (!$this->subject_content->FldIsDetailKey) {
			$this->subject_content->setFormValue($objForm->GetValue("x_subject_content"));
		}
		if (!$this->subject_general_faculty_id->FldIsDetailKey) {
			$this->subject_general_faculty_id->setFormValue($objForm->GetValue("x_subject_general_faculty_id"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->subject_id->CurrentValue = $this->subject_id->FormValue;
		$this->subject_name->CurrentValue = $this->subject_name->FormValue;
		$this->subject_code->CurrentValue = $this->subject_code->FormValue;
		$this->subject_active->CurrentValue = $this->subject_active->FormValue;
		$this->subject_university->CurrentValue = $this->subject_university->FormValue;
		$this->subject_type->CurrentValue = $this->subject_type->FormValue;
		$this->subject_year->CurrentValue = $this->subject_year->FormValue;
		$this->subject_credits->CurrentValue = $this->subject_credits->FormValue;
		$this->subject_credit_hour->CurrentValue = $this->subject_credit_hour->FormValue;
		$this->subject_requirement->CurrentValue = $this->subject_requirement->FormValue;
		$this->subject_target->CurrentValue = $this->subject_target->FormValue;
		$this->subject_info->CurrentValue = $this->subject_info->FormValue;
		$this->subject_test->CurrentValue = $this->subject_test->FormValue;
		$this->subject_faculty->CurrentValue = $this->subject_faculty->FormValue;
		$this->subject_dept->CurrentValue = $this->subject_dept->FormValue;
		$this->subject_content->CurrentValue = $this->subject_content->FormValue;
		$this->subject_general_faculty_id->CurrentValue = $this->subject_general_faculty_id->FormValue;
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
		$this->subject_id->setDbValue($rs->fields('subject_id'));
		$this->subject_name->setDbValue($rs->fields('subject_name'));
		$this->subject_code->setDbValue($rs->fields('subject_code'));
		$this->subject_active->setDbValue($rs->fields('subject_active'));
		$this->subject_university->setDbValue($rs->fields('subject_university'));
		$this->subject_type->setDbValue($rs->fields('subject_type'));
		$this->subject_year->setDbValue($rs->fields('subject_year'));
		$this->subject_credits->setDbValue($rs->fields('subject_credits'));
		$this->subject_credit_hour->setDbValue($rs->fields('subject_credit_hour'));
		$this->subject_requirement->setDbValue($rs->fields('subject_requirement'));
		$this->subject_target->setDbValue($rs->fields('subject_target'));
		$this->subject_info->setDbValue($rs->fields('subject_info'));
		$this->subject_test->setDbValue($rs->fields('subject_test'));
		$this->subject_faculty->setDbValue($rs->fields('subject_faculty'));
		$this->subject_dept->setDbValue($rs->fields('subject_dept'));
		$this->subject_content->setDbValue($rs->fields('subject_content'));
		$this->subject_general_faculty_id->setDbValue($rs->fields('subject_general_faculty_id'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// subject_id
		// subject_name
		// subject_code
		// subject_active
		// subject_university
		// subject_type
		// subject_year
		// subject_credits
		// subject_credit_hour
		// subject_requirement
		// subject_target
		// subject_info
		// subject_test
		// subject_faculty
		// subject_dept
		// subject_content
		// subject_general_faculty_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// subject_id
			$this->subject_id->ViewValue = $this->subject_id->CurrentValue;
			$this->subject_id->ViewCustomAttributes = "";

			// subject_name
			$this->subject_name->ViewValue = $this->subject_name->CurrentValue;
			$this->subject_name->ViewCustomAttributes = "";

			// subject_code
			$this->subject_code->ViewValue = $this->subject_code->CurrentValue;
			$this->subject_code->ViewCustomAttributes = "";

			// subject_active
			$this->subject_active->ViewValue = $this->subject_active->CurrentValue;
			$this->subject_active->ViewCustomAttributes = "";

			// subject_university
			$this->subject_university->ViewValue = $this->subject_university->CurrentValue;
			$this->subject_university->ViewCustomAttributes = "";

			// subject_type
			if (strval($this->subject_type->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->subject_type->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `id`, `subject_type_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_subject_type`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->subject_type->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->subject_type->ViewValue = $this->subject_type->CurrentValue;
				}
			} else {
				$this->subject_type->ViewValue = NULL;
			}
			$this->subject_type->ViewCustomAttributes = "";

			// subject_year
			$this->subject_year->ViewValue = $this->subject_year->CurrentValue;
			$this->subject_year->ViewCustomAttributes = "";

			// subject_credits
			$this->subject_credits->ViewValue = $this->subject_credits->CurrentValue;
			$this->subject_credits->ViewCustomAttributes = "";

			// subject_credit_hour
			$this->subject_credit_hour->ViewValue = $this->subject_credit_hour->CurrentValue;
			$this->subject_credit_hour->ViewCustomAttributes = "";

			// subject_requirement
			$this->subject_requirement->ViewValue = $this->subject_requirement->CurrentValue;
			$this->subject_requirement->ViewCustomAttributes = "";

			// subject_target
			$this->subject_target->ViewValue = $this->subject_target->CurrentValue;
			$this->subject_target->ViewCustomAttributes = "";

			// subject_info
			$this->subject_info->ViewValue = $this->subject_info->CurrentValue;
			$this->subject_info->ViewCustomAttributes = "";

			// subject_test
			$this->subject_test->ViewValue = $this->subject_test->CurrentValue;
			$this->subject_test->ViewCustomAttributes = "";

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

			// subject_content
			$this->subject_content->ViewValue = $this->subject_content->CurrentValue;
			$this->subject_content->ViewCustomAttributes = "";

			// subject_general_faculty_id
			if (strval($this->subject_general_faculty_id->CurrentValue) <> "") {
				$sFilterWrk = "`faculty_id`" . ew_SearchString("=", $this->subject_general_faculty_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `faculty_id`, `faculty_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_faculty`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->subject_general_faculty_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->subject_general_faculty_id->ViewValue = $this->subject_general_faculty_id->CurrentValue;
				}
			} else {
				$this->subject_general_faculty_id->ViewValue = NULL;
			}
			$this->subject_general_faculty_id->ViewCustomAttributes = "";

			// subject_id
			$this->subject_id->LinkCustomAttributes = "";
			$this->subject_id->HrefValue = "";
			$this->subject_id->TooltipValue = "";

			// subject_name
			$this->subject_name->LinkCustomAttributes = "";
			$this->subject_name->HrefValue = "";
			$this->subject_name->TooltipValue = "";

			// subject_code
			$this->subject_code->LinkCustomAttributes = "";
			$this->subject_code->HrefValue = "";
			$this->subject_code->TooltipValue = "";

			// subject_active
			$this->subject_active->LinkCustomAttributes = "";
			$this->subject_active->HrefValue = "";
			$this->subject_active->TooltipValue = "";

			// subject_university
			$this->subject_university->LinkCustomAttributes = "";
			$this->subject_university->HrefValue = "";
			$this->subject_university->TooltipValue = "";

			// subject_type
			$this->subject_type->LinkCustomAttributes = "";
			$this->subject_type->HrefValue = "";
			$this->subject_type->TooltipValue = "";

			// subject_year
			$this->subject_year->LinkCustomAttributes = "";
			$this->subject_year->HrefValue = "";
			$this->subject_year->TooltipValue = "";

			// subject_credits
			$this->subject_credits->LinkCustomAttributes = "";
			$this->subject_credits->HrefValue = "";
			$this->subject_credits->TooltipValue = "";

			// subject_credit_hour
			$this->subject_credit_hour->LinkCustomAttributes = "";
			$this->subject_credit_hour->HrefValue = "";
			$this->subject_credit_hour->TooltipValue = "";

			// subject_requirement
			$this->subject_requirement->LinkCustomAttributes = "";
			$this->subject_requirement->HrefValue = "";
			$this->subject_requirement->TooltipValue = "";

			// subject_target
			$this->subject_target->LinkCustomAttributes = "";
			$this->subject_target->HrefValue = "";
			$this->subject_target->TooltipValue = "";

			// subject_info
			$this->subject_info->LinkCustomAttributes = "";
			$this->subject_info->HrefValue = "";
			$this->subject_info->TooltipValue = "";

			// subject_test
			$this->subject_test->LinkCustomAttributes = "";
			$this->subject_test->HrefValue = "";
			$this->subject_test->TooltipValue = "";

			// subject_faculty
			$this->subject_faculty->LinkCustomAttributes = "";
			$this->subject_faculty->HrefValue = "";
			$this->subject_faculty->TooltipValue = "";

			// subject_dept
			$this->subject_dept->LinkCustomAttributes = "";
			$this->subject_dept->HrefValue = "";
			$this->subject_dept->TooltipValue = "";

			// subject_content
			$this->subject_content->LinkCustomAttributes = "";
			$this->subject_content->HrefValue = "";
			$this->subject_content->TooltipValue = "";

			// subject_general_faculty_id
			$this->subject_general_faculty_id->LinkCustomAttributes = "";
			$this->subject_general_faculty_id->HrefValue = "";
			$this->subject_general_faculty_id->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// subject_id
			$this->subject_id->EditCustomAttributes = "";
			$this->subject_id->EditValue = $this->subject_id->CurrentValue;
			$this->subject_id->ViewCustomAttributes = "";

			// subject_name
			$this->subject_name->EditCustomAttributes = "";
			$this->subject_name->EditValue = ew_HtmlEncode($this->subject_name->CurrentValue);

			// subject_code
			$this->subject_code->EditCustomAttributes = "";
			$this->subject_code->EditValue = ew_HtmlEncode($this->subject_code->CurrentValue);

			// subject_active
			$this->subject_active->EditCustomAttributes = "";
			$this->subject_active->EditValue = ew_HtmlEncode($this->subject_active->CurrentValue);

			// subject_university
			$this->subject_university->EditCustomAttributes = "";
			$this->subject_university->EditValue = ew_HtmlEncode($this->subject_university->CurrentValue);

			// subject_type
			$this->subject_type->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `id`, `subject_type_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tbl_subject_type`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->subject_type->EditValue = $arwrk;

			// subject_year
			$this->subject_year->EditCustomAttributes = "";
			$this->subject_year->EditValue = ew_HtmlEncode($this->subject_year->CurrentValue);

			// subject_credits
			$this->subject_credits->EditCustomAttributes = "";
			$this->subject_credits->EditValue = ew_HtmlEncode($this->subject_credits->CurrentValue);

			// subject_credit_hour
			$this->subject_credit_hour->EditCustomAttributes = "";
			$this->subject_credit_hour->EditValue = ew_HtmlEncode($this->subject_credit_hour->CurrentValue);

			// subject_requirement
			$this->subject_requirement->EditCustomAttributes = "";
			$this->subject_requirement->EditValue = ew_HtmlEncode($this->subject_requirement->CurrentValue);

			// subject_target
			$this->subject_target->EditCustomAttributes = "";
			$this->subject_target->EditValue = ew_HtmlEncode($this->subject_target->CurrentValue);

			// subject_info
			$this->subject_info->EditCustomAttributes = "";
			$this->subject_info->EditValue = ew_HtmlEncode($this->subject_info->CurrentValue);

			// subject_test
			$this->subject_test->EditCustomAttributes = "";
			$this->subject_test->EditValue = ew_HtmlEncode($this->subject_test->CurrentValue);

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

			// subject_content
			$this->subject_content->EditCustomAttributes = "";
			$this->subject_content->EditValue = ew_HtmlEncode($this->subject_content->CurrentValue);

			// subject_general_faculty_id
			$this->subject_general_faculty_id->EditCustomAttributes = "";
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
			$this->subject_general_faculty_id->EditValue = $arwrk;

			// Edit refer script
			// subject_id

			$this->subject_id->HrefValue = "";

			// subject_name
			$this->subject_name->HrefValue = "";

			// subject_code
			$this->subject_code->HrefValue = "";

			// subject_active
			$this->subject_active->HrefValue = "";

			// subject_university
			$this->subject_university->HrefValue = "";

			// subject_type
			$this->subject_type->HrefValue = "";

			// subject_year
			$this->subject_year->HrefValue = "";

			// subject_credits
			$this->subject_credits->HrefValue = "";

			// subject_credit_hour
			$this->subject_credit_hour->HrefValue = "";

			// subject_requirement
			$this->subject_requirement->HrefValue = "";

			// subject_target
			$this->subject_target->HrefValue = "";

			// subject_info
			$this->subject_info->HrefValue = "";

			// subject_test
			$this->subject_test->HrefValue = "";

			// subject_faculty
			$this->subject_faculty->HrefValue = "";

			// subject_dept
			$this->subject_dept->HrefValue = "";

			// subject_content
			$this->subject_content->HrefValue = "";

			// subject_general_faculty_id
			$this->subject_general_faculty_id->HrefValue = "";
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
		if (!ew_CheckInteger($this->subject_year->FormValue)) {
			ew_AddMessage($gsFormError, $this->subject_year->FldErrMsg());
		}
		if (!ew_CheckInteger($this->subject_credits->FormValue)) {
			ew_AddMessage($gsFormError, $this->subject_credits->FldErrMsg());
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

			// subject_name
			$this->subject_name->SetDbValueDef($rsnew, $this->subject_name->CurrentValue, NULL, $this->subject_name->ReadOnly);

			// subject_code
			$this->subject_code->SetDbValueDef($rsnew, $this->subject_code->CurrentValue, NULL, $this->subject_code->ReadOnly);

			// subject_active
			$this->subject_active->SetDbValueDef($rsnew, $this->subject_active->CurrentValue, NULL, $this->subject_active->ReadOnly);

			// subject_university
			$this->subject_university->SetDbValueDef($rsnew, $this->subject_university->CurrentValue, NULL, $this->subject_university->ReadOnly);

			// subject_type
			$this->subject_type->SetDbValueDef($rsnew, $this->subject_type->CurrentValue, NULL, $this->subject_type->ReadOnly);

			// subject_year
			$this->subject_year->SetDbValueDef($rsnew, $this->subject_year->CurrentValue, NULL, $this->subject_year->ReadOnly);

			// subject_credits
			$this->subject_credits->SetDbValueDef($rsnew, $this->subject_credits->CurrentValue, NULL, $this->subject_credits->ReadOnly);

			// subject_credit_hour
			$this->subject_credit_hour->SetDbValueDef($rsnew, $this->subject_credit_hour->CurrentValue, NULL, $this->subject_credit_hour->ReadOnly);

			// subject_requirement
			$this->subject_requirement->SetDbValueDef($rsnew, $this->subject_requirement->CurrentValue, NULL, $this->subject_requirement->ReadOnly);

			// subject_target
			$this->subject_target->SetDbValueDef($rsnew, $this->subject_target->CurrentValue, NULL, $this->subject_target->ReadOnly);

			// subject_info
			$this->subject_info->SetDbValueDef($rsnew, $this->subject_info->CurrentValue, NULL, $this->subject_info->ReadOnly);

			// subject_test
			$this->subject_test->SetDbValueDef($rsnew, $this->subject_test->CurrentValue, NULL, $this->subject_test->ReadOnly);

			// subject_faculty
			$this->subject_faculty->SetDbValueDef($rsnew, $this->subject_faculty->CurrentValue, NULL, $this->subject_faculty->ReadOnly);

			// subject_dept
			$this->subject_dept->SetDbValueDef($rsnew, $this->subject_dept->CurrentValue, NULL, $this->subject_dept->ReadOnly);

			// subject_content
			$this->subject_content->SetDbValueDef($rsnew, $this->subject_content->CurrentValue, NULL, $this->subject_content->ReadOnly);

			// subject_general_faculty_id
			$this->subject_general_faculty_id->SetDbValueDef($rsnew, $this->subject_general_faculty_id->CurrentValue, NULL, $this->subject_general_faculty_id->ReadOnly);

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
if (!isset($tbl_subject_edit)) $tbl_subject_edit = new ctbl_subject_edit();

// Page init
$tbl_subject_edit->Page_Init();

// Page main
$tbl_subject_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_subject_edit = new ew_Page("tbl_subject_edit");
tbl_subject_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = tbl_subject_edit.PageID; // For backward compatibility

// Form object
var ftbl_subjectedit = new ew_Form("ftbl_subjectedit");

// Validate form
ftbl_subjectedit.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_subject_year"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_subject->subject_year->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_subject_credits"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_subject->subject_credits->FldErrMsg()) ?>");

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
ftbl_subjectedit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_subjectedit.ValidateRequired = true;
<?php } else { ?>
ftbl_subjectedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_subjectedit.Lists["x_subject_type"] = {"LinkField":"x_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_subject_type_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_subjectedit.Lists["x_subject_faculty"] = {"LinkField":"x_faculty_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_faculty_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_subjectedit.Lists["x_subject_dept"] = {"LinkField":"x_dept_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_dept_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_subjectedit.Lists["x_subject_general_faculty_id"] = {"LinkField":"x_faculty_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_faculty_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_subject->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $tbl_subject->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $tbl_subject_edit->ShowPageHeader(); ?>
<?php
$tbl_subject_edit->ShowMessage();
?>
<form name="ftbl_subjectedit" id="ftbl_subjectedit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="tbl_subject">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_subjectedit" class="ewTable">
<?php if ($tbl_subject->subject_id->Visible) { // subject_id ?>
	<tr id="r_subject_id"<?php echo $tbl_subject->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_subject_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject->subject_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject->subject_id->CellAttributes() ?>><span id="el_tbl_subject_subject_id">
<span<?php echo $tbl_subject->subject_id->ViewAttributes() ?>>
<?php echo $tbl_subject->subject_id->EditValue ?></span>
<input type="hidden" name="x_subject_id" id="x_subject_id" value="<?php echo ew_HtmlEncode($tbl_subject->subject_id->CurrentValue) ?>">
</span><?php echo $tbl_subject->subject_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject->subject_name->Visible) { // subject_name ?>
	<tr id="r_subject_name"<?php echo $tbl_subject->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_subject_name"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject->subject_name->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject->subject_name->CellAttributes() ?>><span id="el_tbl_subject_subject_name">
<textarea name="x_subject_name" id="x_subject_name" cols="undefined" rows="undefined"<?php echo $tbl_subject->subject_name->EditAttributes() ?>><?php echo $tbl_subject->subject_name->EditValue ?></textarea>
</span><?php echo $tbl_subject->subject_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject->subject_code->Visible) { // subject_code ?>
	<tr id="r_subject_code"<?php echo $tbl_subject->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_subject_code"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject->subject_code->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject->subject_code->CellAttributes() ?>><span id="el_tbl_subject_subject_code">
<input type="text" name="x_subject_code" id="x_subject_code" size="30" maxlength="45" value="<?php echo $tbl_subject->subject_code->EditValue ?>"<?php echo $tbl_subject->subject_code->EditAttributes() ?>>
</span><?php echo $tbl_subject->subject_code->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject->subject_active->Visible) { // subject_active ?>
	<tr id="r_subject_active"<?php echo $tbl_subject->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_subject_active"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject->subject_active->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject->subject_active->CellAttributes() ?>><span id="el_tbl_subject_subject_active">
<input type="text" name="x_subject_active" id="x_subject_active" size="30" maxlength="45" value="<?php echo $tbl_subject->subject_active->EditValue ?>"<?php echo $tbl_subject->subject_active->EditAttributes() ?>>
</span><?php echo $tbl_subject->subject_active->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject->subject_university->Visible) { // subject_university ?>
	<tr id="r_subject_university"<?php echo $tbl_subject->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_subject_university"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject->subject_university->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject->subject_university->CellAttributes() ?>><span id="el_tbl_subject_subject_university">
<input type="text" name="x_subject_university" id="x_subject_university" size="30" maxlength="45" value="<?php echo $tbl_subject->subject_university->EditValue ?>"<?php echo $tbl_subject->subject_university->EditAttributes() ?>>
</span><?php echo $tbl_subject->subject_university->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject->subject_type->Visible) { // subject_type ?>
	<tr id="r_subject_type"<?php echo $tbl_subject->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_subject_type"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject->subject_type->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject->subject_type->CellAttributes() ?>><span id="el_tbl_subject_subject_type">
<select id="x_subject_type" name="x_subject_type"<?php echo $tbl_subject->subject_type->EditAttributes() ?>>
<?php
if (is_array($tbl_subject->subject_type->EditValue)) {
	$arwrk = $tbl_subject->subject_type->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_subject->subject_type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_subjectedit.Lists["x_subject_type"].Options = <?php echo (is_array($tbl_subject->subject_type->EditValue)) ? ew_ArrayToJson($tbl_subject->subject_type->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_subject->subject_type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject->subject_year->Visible) { // subject_year ?>
	<tr id="r_subject_year"<?php echo $tbl_subject->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_subject_year"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject->subject_year->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject->subject_year->CellAttributes() ?>><span id="el_tbl_subject_subject_year">
<input type="text" name="x_subject_year" id="x_subject_year" size="30" value="<?php echo $tbl_subject->subject_year->EditValue ?>"<?php echo $tbl_subject->subject_year->EditAttributes() ?>>
</span><?php echo $tbl_subject->subject_year->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject->subject_credits->Visible) { // subject_credits ?>
	<tr id="r_subject_credits"<?php echo $tbl_subject->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_subject_credits"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject->subject_credits->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject->subject_credits->CellAttributes() ?>><span id="el_tbl_subject_subject_credits">
<input type="text" name="x_subject_credits" id="x_subject_credits" size="30" value="<?php echo $tbl_subject->subject_credits->EditValue ?>"<?php echo $tbl_subject->subject_credits->EditAttributes() ?>>
</span><?php echo $tbl_subject->subject_credits->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject->subject_credit_hour->Visible) { // subject_credit_hour ?>
	<tr id="r_subject_credit_hour"<?php echo $tbl_subject->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_subject_credit_hour"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject->subject_credit_hour->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject->subject_credit_hour->CellAttributes() ?>><span id="el_tbl_subject_subject_credit_hour">
<input type="text" name="x_subject_credit_hour" id="x_subject_credit_hour" size="30" maxlength="100" value="<?php echo $tbl_subject->subject_credit_hour->EditValue ?>"<?php echo $tbl_subject->subject_credit_hour->EditAttributes() ?>>
</span><?php echo $tbl_subject->subject_credit_hour->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject->subject_requirement->Visible) { // subject_requirement ?>
	<tr id="r_subject_requirement"<?php echo $tbl_subject->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_subject_requirement"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject->subject_requirement->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject->subject_requirement->CellAttributes() ?>><span id="el_tbl_subject_subject_requirement">
<textarea name="x_subject_requirement" id="x_subject_requirement" cols="35" rows="4"<?php echo $tbl_subject->subject_requirement->EditAttributes() ?>><?php echo $tbl_subject->subject_requirement->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_subjectedit", "x_subject_requirement", 35, 4, <?php echo ($tbl_subject->subject_requirement->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_subject->subject_requirement->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject->subject_target->Visible) { // subject_target ?>
	<tr id="r_subject_target"<?php echo $tbl_subject->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_subject_target"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject->subject_target->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject->subject_target->CellAttributes() ?>><span id="el_tbl_subject_subject_target">
<textarea name="x_subject_target" id="x_subject_target" cols="35" rows="4"<?php echo $tbl_subject->subject_target->EditAttributes() ?>><?php echo $tbl_subject->subject_target->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_subjectedit", "x_subject_target", 35, 4, <?php echo ($tbl_subject->subject_target->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_subject->subject_target->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject->subject_info->Visible) { // subject_info ?>
	<tr id="r_subject_info"<?php echo $tbl_subject->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_subject_info"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject->subject_info->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject->subject_info->CellAttributes() ?>><span id="el_tbl_subject_subject_info">
<textarea name="x_subject_info" id="x_subject_info" cols="35" rows="4"<?php echo $tbl_subject->subject_info->EditAttributes() ?>><?php echo $tbl_subject->subject_info->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_subjectedit", "x_subject_info", 35, 4, <?php echo ($tbl_subject->subject_info->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_subject->subject_info->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject->subject_test->Visible) { // subject_test ?>
	<tr id="r_subject_test"<?php echo $tbl_subject->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_subject_test"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject->subject_test->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject->subject_test->CellAttributes() ?>><span id="el_tbl_subject_subject_test">
<textarea name="x_subject_test" id="x_subject_test" cols="35" rows="4"<?php echo $tbl_subject->subject_test->EditAttributes() ?>><?php echo $tbl_subject->subject_test->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_subjectedit", "x_subject_test", 35, 4, <?php echo ($tbl_subject->subject_test->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_subject->subject_test->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject->subject_faculty->Visible) { // subject_faculty ?>
	<tr id="r_subject_faculty"<?php echo $tbl_subject->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_subject_faculty"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject->subject_faculty->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject->subject_faculty->CellAttributes() ?>><span id="el_tbl_subject_subject_faculty">
<select id="x_subject_faculty" name="x_subject_faculty"<?php echo $tbl_subject->subject_faculty->EditAttributes() ?>>
<?php
if (is_array($tbl_subject->subject_faculty->EditValue)) {
	$arwrk = $tbl_subject->subject_faculty->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_subject->subject_faculty->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_subjectedit.Lists["x_subject_faculty"].Options = <?php echo (is_array($tbl_subject->subject_faculty->EditValue)) ? ew_ArrayToJson($tbl_subject->subject_faculty->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_subject->subject_faculty->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject->subject_dept->Visible) { // subject_dept ?>
	<tr id="r_subject_dept"<?php echo $tbl_subject->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_subject_dept"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject->subject_dept->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject->subject_dept->CellAttributes() ?>><span id="el_tbl_subject_subject_dept">
<select id="x_subject_dept" name="x_subject_dept"<?php echo $tbl_subject->subject_dept->EditAttributes() ?>>
<?php
if (is_array($tbl_subject->subject_dept->EditValue)) {
	$arwrk = $tbl_subject->subject_dept->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_subject->subject_dept->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_subjectedit.Lists["x_subject_dept"].Options = <?php echo (is_array($tbl_subject->subject_dept->EditValue)) ? ew_ArrayToJson($tbl_subject->subject_dept->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_subject->subject_dept->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject->subject_content->Visible) { // subject_content ?>
	<tr id="r_subject_content"<?php echo $tbl_subject->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_subject_content"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject->subject_content->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject->subject_content->CellAttributes() ?>><span id="el_tbl_subject_subject_content">
<textarea name="x_subject_content" id="x_subject_content" cols="35" rows="4"<?php echo $tbl_subject->subject_content->EditAttributes() ?>><?php echo $tbl_subject->subject_content->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_subjectedit", "x_subject_content", 35, 4, <?php echo ($tbl_subject->subject_content->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_subject->subject_content->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_subject->subject_general_faculty_id->Visible) { // subject_general_faculty_id ?>
	<tr id="r_subject_general_faculty_id"<?php echo $tbl_subject->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_subject_subject_general_faculty_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject->subject_general_faculty_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_subject->subject_general_faculty_id->CellAttributes() ?>><span id="el_tbl_subject_subject_general_faculty_id">
<select id="x_subject_general_faculty_id" name="x_subject_general_faculty_id"<?php echo $tbl_subject->subject_general_faculty_id->EditAttributes() ?>>
<?php
if (is_array($tbl_subject->subject_general_faculty_id->EditValue)) {
	$arwrk = $tbl_subject->subject_general_faculty_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_subject->subject_general_faculty_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_subjectedit.Lists["x_subject_general_faculty_id"].Options = <?php echo (is_array($tbl_subject->subject_general_faculty_id->EditValue)) ? ew_ArrayToJson($tbl_subject->subject_general_faculty_id->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_subject->subject_general_faculty_id->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
ftbl_subjectedit.Init();
</script>
<?php
$tbl_subject_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_subject_edit->Page_Terminate();
?>
