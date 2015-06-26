<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "tbl_deptinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$tbl_dept_edit = NULL; // Initialize page object first

class ctbl_dept_edit extends ctbl_dept {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_dept';

	// Page object name
	var $PageObjName = 'tbl_dept_edit';

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

		// Table object (tbl_dept)
		if (!isset($GLOBALS["tbl_dept"])) {
			$GLOBALS["tbl_dept"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_dept"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_dept', TRUE);

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
		$this->dept_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		if (@$_GET["dept_id"] <> "")
			$this->dept_id->setQueryStringValue($_GET["dept_id"]);

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->dept_id->CurrentValue == "")
			$this->Page_Terminate("tbl_deptlist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("tbl_deptlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tbl_deptview.php")
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
		if (!$this->dept_id->FldIsDetailKey)
			$this->dept_id->setFormValue($objForm->GetValue("x_dept_id"));
		if (!$this->dept_name->FldIsDetailKey) {
			$this->dept_name->setFormValue($objForm->GetValue("x_dept_name"));
		}
		if (!$this->dept_active->FldIsDetailKey) {
			$this->dept_active->setFormValue($objForm->GetValue("x_dept_active"));
		}
		if (!$this->dept_faculty->FldIsDetailKey) {
			$this->dept_faculty->setFormValue($objForm->GetValue("x_dept_faculty"));
		}
		if (!$this->dept_target->FldIsDetailKey) {
			$this->dept_target->setFormValue($objForm->GetValue("x_dept_target"));
		}
		if (!$this->dept_knowleadge->FldIsDetailKey) {
			$this->dept_knowleadge->setFormValue($objForm->GetValue("x_dept_knowleadge"));
		}
		if (!$this->dept_behavior->FldIsDetailKey) {
			$this->dept_behavior->setFormValue($objForm->GetValue("x_dept_behavior"));
		}
		if (!$this->dept_out_standard->FldIsDetailKey) {
			$this->dept_out_standard->setFormValue($objForm->GetValue("x_dept_out_standard"));
		}
		if (!$this->dept_contact->FldIsDetailKey) {
			$this->dept_contact->setFormValue($objForm->GetValue("x_dept_contact"));
		}
		if (!$this->dept_in_standart->FldIsDetailKey) {
			$this->dept_in_standart->setFormValue($objForm->GetValue("x_dept_in_standart"));
		}
		if (!$this->dept_language->FldIsDetailKey) {
			$this->dept_language->setFormValue($objForm->GetValue("x_dept_language"));
		}
		if (!$this->dept_credits->FldIsDetailKey) {
			$this->dept_credits->setFormValue($objForm->GetValue("x_dept_credits"));
		}
		if (!$this->dept_code->FldIsDetailKey) {
			$this->dept_code->setFormValue($objForm->GetValue("x_dept_code"));
		}
		if (!$this->dept_link_download->FldIsDetailKey) {
			$this->dept_link_download->setFormValue($objForm->GetValue("x_dept_link_download"));
		}
		if (!$this->dept_skill->FldIsDetailKey) {
			$this->dept_skill->setFormValue($objForm->GetValue("x_dept_skill"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->dept_id->CurrentValue = $this->dept_id->FormValue;
		$this->dept_name->CurrentValue = $this->dept_name->FormValue;
		$this->dept_active->CurrentValue = $this->dept_active->FormValue;
		$this->dept_faculty->CurrentValue = $this->dept_faculty->FormValue;
		$this->dept_target->CurrentValue = $this->dept_target->FormValue;
		$this->dept_knowleadge->CurrentValue = $this->dept_knowleadge->FormValue;
		$this->dept_behavior->CurrentValue = $this->dept_behavior->FormValue;
		$this->dept_out_standard->CurrentValue = $this->dept_out_standard->FormValue;
		$this->dept_contact->CurrentValue = $this->dept_contact->FormValue;
		$this->dept_in_standart->CurrentValue = $this->dept_in_standart->FormValue;
		$this->dept_language->CurrentValue = $this->dept_language->FormValue;
		$this->dept_credits->CurrentValue = $this->dept_credits->FormValue;
		$this->dept_code->CurrentValue = $this->dept_code->FormValue;
		$this->dept_link_download->CurrentValue = $this->dept_link_download->FormValue;
		$this->dept_skill->CurrentValue = $this->dept_skill->FormValue;
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
		$this->dept_id->setDbValue($rs->fields('dept_id'));
		$this->dept_name->setDbValue($rs->fields('dept_name'));
		$this->dept_active->setDbValue($rs->fields('dept_active'));
		$this->dept_faculty->setDbValue($rs->fields('dept_faculty'));
		$this->dept_target->setDbValue($rs->fields('dept_target'));
		$this->dept_knowleadge->setDbValue($rs->fields('dept_knowleadge'));
		$this->dept_behavior->setDbValue($rs->fields('dept_behavior'));
		$this->dept_out_standard->setDbValue($rs->fields('dept_out_standard'));
		$this->dept_contact->setDbValue($rs->fields('dept_contact'));
		$this->dept_in_standart->setDbValue($rs->fields('dept_in_standart'));
		$this->dept_language->setDbValue($rs->fields('dept_language'));
		$this->dept_credits->setDbValue($rs->fields('dept_credits'));
		$this->dept_code->setDbValue($rs->fields('dept_code'));
		$this->dept_link_download->setDbValue($rs->fields('dept_link_download'));
		$this->dept_skill->setDbValue($rs->fields('dept_skill'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// dept_id
		// dept_name
		// dept_active
		// dept_faculty
		// dept_target
		// dept_knowleadge
		// dept_behavior
		// dept_out_standard
		// dept_contact
		// dept_in_standart
		// dept_language
		// dept_credits
		// dept_code
		// dept_link_download
		// dept_skill

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// dept_id
			$this->dept_id->ViewValue = $this->dept_id->CurrentValue;
			$this->dept_id->ViewCustomAttributes = "";

			// dept_name
			$this->dept_name->ViewValue = $this->dept_name->CurrentValue;
			$this->dept_name->ViewCustomAttributes = "";

			// dept_active
			$this->dept_active->ViewValue = $this->dept_active->CurrentValue;
			$this->dept_active->ViewCustomAttributes = "";

			// dept_faculty
			if (strval($this->dept_faculty->CurrentValue) <> "") {
				$sFilterWrk = "`faculty_id`" . ew_SearchString("=", $this->dept_faculty->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `faculty_id`, `faculty_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_faculty`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->dept_faculty->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->dept_faculty->ViewValue = $this->dept_faculty->CurrentValue;
				}
			} else {
				$this->dept_faculty->ViewValue = NULL;
			}
			$this->dept_faculty->ViewCustomAttributes = "";

			// dept_target
			$this->dept_target->ViewValue = $this->dept_target->CurrentValue;
			$this->dept_target->ViewCustomAttributes = "";

			// dept_knowleadge
			$this->dept_knowleadge->ViewValue = $this->dept_knowleadge->CurrentValue;
			$this->dept_knowleadge->ViewCustomAttributes = "";

			// dept_behavior
			$this->dept_behavior->ViewValue = $this->dept_behavior->CurrentValue;
			$this->dept_behavior->ViewCustomAttributes = "";

			// dept_out_standard
			$this->dept_out_standard->ViewValue = $this->dept_out_standard->CurrentValue;
			$this->dept_out_standard->ViewCustomAttributes = "";

			// dept_contact
			$this->dept_contact->ViewValue = $this->dept_contact->CurrentValue;
			$this->dept_contact->ViewCustomAttributes = "";

			// dept_in_standart
			$this->dept_in_standart->ViewValue = $this->dept_in_standart->CurrentValue;
			$this->dept_in_standart->ViewCustomAttributes = "";

			// dept_language
			$this->dept_language->ViewValue = $this->dept_language->CurrentValue;
			$this->dept_language->ViewCustomAttributes = "";

			// dept_credits
			$this->dept_credits->ViewValue = $this->dept_credits->CurrentValue;
			$this->dept_credits->ViewCustomAttributes = "";

			// dept_code
			$this->dept_code->ViewValue = $this->dept_code->CurrentValue;
			$this->dept_code->ViewCustomAttributes = "";

			// dept_link_download
			$this->dept_link_download->ViewValue = $this->dept_link_download->CurrentValue;
			$this->dept_link_download->ViewCustomAttributes = "";

			// dept_skill
			$this->dept_skill->ViewValue = $this->dept_skill->CurrentValue;
			$this->dept_skill->ViewCustomAttributes = "";

			// dept_id
			$this->dept_id->LinkCustomAttributes = "";
			$this->dept_id->HrefValue = "";
			$this->dept_id->TooltipValue = "";

			// dept_name
			$this->dept_name->LinkCustomAttributes = "";
			$this->dept_name->HrefValue = "";
			$this->dept_name->TooltipValue = "";

			// dept_active
			$this->dept_active->LinkCustomAttributes = "";
			$this->dept_active->HrefValue = "";
			$this->dept_active->TooltipValue = "";

			// dept_faculty
			$this->dept_faculty->LinkCustomAttributes = "";
			$this->dept_faculty->HrefValue = "";
			$this->dept_faculty->TooltipValue = "";

			// dept_target
			$this->dept_target->LinkCustomAttributes = "";
			$this->dept_target->HrefValue = "";
			$this->dept_target->TooltipValue = "";

			// dept_knowleadge
			$this->dept_knowleadge->LinkCustomAttributes = "";
			$this->dept_knowleadge->HrefValue = "";
			$this->dept_knowleadge->TooltipValue = "";

			// dept_behavior
			$this->dept_behavior->LinkCustomAttributes = "";
			$this->dept_behavior->HrefValue = "";
			$this->dept_behavior->TooltipValue = "";

			// dept_out_standard
			$this->dept_out_standard->LinkCustomAttributes = "";
			$this->dept_out_standard->HrefValue = "";
			$this->dept_out_standard->TooltipValue = "";

			// dept_contact
			$this->dept_contact->LinkCustomAttributes = "";
			$this->dept_contact->HrefValue = "";
			$this->dept_contact->TooltipValue = "";

			// dept_in_standart
			$this->dept_in_standart->LinkCustomAttributes = "";
			$this->dept_in_standart->HrefValue = "";
			$this->dept_in_standart->TooltipValue = "";

			// dept_language
			$this->dept_language->LinkCustomAttributes = "";
			$this->dept_language->HrefValue = "";
			$this->dept_language->TooltipValue = "";

			// dept_credits
			$this->dept_credits->LinkCustomAttributes = "";
			$this->dept_credits->HrefValue = "";
			$this->dept_credits->TooltipValue = "";

			// dept_code
			$this->dept_code->LinkCustomAttributes = "";
			$this->dept_code->HrefValue = "";
			$this->dept_code->TooltipValue = "";

			// dept_link_download
			$this->dept_link_download->LinkCustomAttributes = "";
			$this->dept_link_download->HrefValue = "";
			$this->dept_link_download->TooltipValue = "";

			// dept_skill
			$this->dept_skill->LinkCustomAttributes = "";
			$this->dept_skill->HrefValue = "";
			$this->dept_skill->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// dept_id
			$this->dept_id->EditCustomAttributes = "";
			$this->dept_id->EditValue = $this->dept_id->CurrentValue;
			$this->dept_id->ViewCustomAttributes = "";

			// dept_name
			$this->dept_name->EditCustomAttributes = "";
			$this->dept_name->EditValue = ew_HtmlEncode($this->dept_name->CurrentValue);

			// dept_active
			$this->dept_active->EditCustomAttributes = "";
			$this->dept_active->EditValue = ew_HtmlEncode($this->dept_active->CurrentValue);

			// dept_faculty
			$this->dept_faculty->EditCustomAttributes = "";
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
			$this->dept_faculty->EditValue = $arwrk;

			// dept_target
			$this->dept_target->EditCustomAttributes = "";
			$this->dept_target->EditValue = ew_HtmlEncode($this->dept_target->CurrentValue);

			// dept_knowleadge
			$this->dept_knowleadge->EditCustomAttributes = "";
			$this->dept_knowleadge->EditValue = ew_HtmlEncode($this->dept_knowleadge->CurrentValue);

			// dept_behavior
			$this->dept_behavior->EditCustomAttributes = "";
			$this->dept_behavior->EditValue = ew_HtmlEncode($this->dept_behavior->CurrentValue);

			// dept_out_standard
			$this->dept_out_standard->EditCustomAttributes = "";
			$this->dept_out_standard->EditValue = ew_HtmlEncode($this->dept_out_standard->CurrentValue);

			// dept_contact
			$this->dept_contact->EditCustomAttributes = "";
			$this->dept_contact->EditValue = ew_HtmlEncode($this->dept_contact->CurrentValue);

			// dept_in_standart
			$this->dept_in_standart->EditCustomAttributes = "";
			$this->dept_in_standart->EditValue = ew_HtmlEncode($this->dept_in_standart->CurrentValue);

			// dept_language
			$this->dept_language->EditCustomAttributes = "";
			$this->dept_language->EditValue = ew_HtmlEncode($this->dept_language->CurrentValue);

			// dept_credits
			$this->dept_credits->EditCustomAttributes = "";
			$this->dept_credits->EditValue = ew_HtmlEncode($this->dept_credits->CurrentValue);

			// dept_code
			$this->dept_code->EditCustomAttributes = "";
			$this->dept_code->EditValue = ew_HtmlEncode($this->dept_code->CurrentValue);

			// dept_link_download
			$this->dept_link_download->EditCustomAttributes = "";
			$this->dept_link_download->EditValue = ew_HtmlEncode($this->dept_link_download->CurrentValue);

			// dept_skill
			$this->dept_skill->EditCustomAttributes = "";
			$this->dept_skill->EditValue = ew_HtmlEncode($this->dept_skill->CurrentValue);

			// Edit refer script
			// dept_id

			$this->dept_id->HrefValue = "";

			// dept_name
			$this->dept_name->HrefValue = "";

			// dept_active
			$this->dept_active->HrefValue = "";

			// dept_faculty
			$this->dept_faculty->HrefValue = "";

			// dept_target
			$this->dept_target->HrefValue = "";

			// dept_knowleadge
			$this->dept_knowleadge->HrefValue = "";

			// dept_behavior
			$this->dept_behavior->HrefValue = "";

			// dept_out_standard
			$this->dept_out_standard->HrefValue = "";

			// dept_contact
			$this->dept_contact->HrefValue = "";

			// dept_in_standart
			$this->dept_in_standart->HrefValue = "";

			// dept_language
			$this->dept_language->HrefValue = "";

			// dept_credits
			$this->dept_credits->HrefValue = "";

			// dept_code
			$this->dept_code->HrefValue = "";

			// dept_link_download
			$this->dept_link_download->HrefValue = "";

			// dept_skill
			$this->dept_skill->HrefValue = "";
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
		if (!ew_CheckInteger($this->dept_active->FormValue)) {
			ew_AddMessage($gsFormError, $this->dept_active->FldErrMsg());
		}
		if (!ew_CheckInteger($this->dept_credits->FormValue)) {
			ew_AddMessage($gsFormError, $this->dept_credits->FldErrMsg());
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

			// dept_name
			$this->dept_name->SetDbValueDef($rsnew, $this->dept_name->CurrentValue, NULL, $this->dept_name->ReadOnly);

			// dept_active
			$this->dept_active->SetDbValueDef($rsnew, $this->dept_active->CurrentValue, NULL, $this->dept_active->ReadOnly);

			// dept_faculty
			$this->dept_faculty->SetDbValueDef($rsnew, $this->dept_faculty->CurrentValue, NULL, $this->dept_faculty->ReadOnly);

			// dept_target
			$this->dept_target->SetDbValueDef($rsnew, $this->dept_target->CurrentValue, NULL, $this->dept_target->ReadOnly);

			// dept_knowleadge
			$this->dept_knowleadge->SetDbValueDef($rsnew, $this->dept_knowleadge->CurrentValue, NULL, $this->dept_knowleadge->ReadOnly);

			// dept_behavior
			$this->dept_behavior->SetDbValueDef($rsnew, $this->dept_behavior->CurrentValue, NULL, $this->dept_behavior->ReadOnly);

			// dept_out_standard
			$this->dept_out_standard->SetDbValueDef($rsnew, $this->dept_out_standard->CurrentValue, NULL, $this->dept_out_standard->ReadOnly);

			// dept_contact
			$this->dept_contact->SetDbValueDef($rsnew, $this->dept_contact->CurrentValue, NULL, $this->dept_contact->ReadOnly);

			// dept_in_standart
			$this->dept_in_standart->SetDbValueDef($rsnew, $this->dept_in_standart->CurrentValue, NULL, $this->dept_in_standart->ReadOnly);

			// dept_language
			$this->dept_language->SetDbValueDef($rsnew, $this->dept_language->CurrentValue, NULL, $this->dept_language->ReadOnly);

			// dept_credits
			$this->dept_credits->SetDbValueDef($rsnew, $this->dept_credits->CurrentValue, NULL, $this->dept_credits->ReadOnly);

			// dept_code
			$this->dept_code->SetDbValueDef($rsnew, $this->dept_code->CurrentValue, NULL, $this->dept_code->ReadOnly);

			// dept_link_download
			$this->dept_link_download->SetDbValueDef($rsnew, $this->dept_link_download->CurrentValue, NULL, $this->dept_link_download->ReadOnly);

			// dept_skill
			$this->dept_skill->SetDbValueDef($rsnew, $this->dept_skill->CurrentValue, NULL, $this->dept_skill->ReadOnly);

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
if (!isset($tbl_dept_edit)) $tbl_dept_edit = new ctbl_dept_edit();

// Page init
$tbl_dept_edit->Page_Init();

// Page main
$tbl_dept_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_dept_edit = new ew_Page("tbl_dept_edit");
tbl_dept_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = tbl_dept_edit.PageID; // For backward compatibility

// Form object
var ftbl_deptedit = new ew_Form("ftbl_deptedit");

// Validate form
ftbl_deptedit.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_dept_active"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_dept->dept_active->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_dept_credits"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_dept->dept_credits->FldErrMsg()) ?>");

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
ftbl_deptedit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_deptedit.ValidateRequired = true;
<?php } else { ?>
ftbl_deptedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_deptedit.Lists["x_dept_faculty"] = {"LinkField":"x_faculty_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_faculty_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_dept->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $tbl_dept->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $tbl_dept_edit->ShowPageHeader(); ?>
<?php
$tbl_dept_edit->ShowMessage();
?>
<form name="ftbl_deptedit" id="ftbl_deptedit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="tbl_dept">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_deptedit" class="ewTable">
<?php if ($tbl_dept->dept_id->Visible) { // dept_id ?>
	<tr id="r_dept_id"<?php echo $tbl_dept->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_dept_dept_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_dept->dept_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_dept->dept_id->CellAttributes() ?>><span id="el_tbl_dept_dept_id">
<span<?php echo $tbl_dept->dept_id->ViewAttributes() ?>>
<?php echo $tbl_dept->dept_id->EditValue ?></span>
<input type="hidden" name="x_dept_id" id="x_dept_id" value="<?php echo ew_HtmlEncode($tbl_dept->dept_id->CurrentValue) ?>">
</span><?php echo $tbl_dept->dept_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_dept->dept_name->Visible) { // dept_name ?>
	<tr id="r_dept_name"<?php echo $tbl_dept->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_dept_dept_name"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_dept->dept_name->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_dept->dept_name->CellAttributes() ?>><span id="el_tbl_dept_dept_name">
<input type="text" name="x_dept_name" id="x_dept_name" size="30" maxlength="100" value="<?php echo $tbl_dept->dept_name->EditValue ?>"<?php echo $tbl_dept->dept_name->EditAttributes() ?>>
</span><?php echo $tbl_dept->dept_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_dept->dept_active->Visible) { // dept_active ?>
	<tr id="r_dept_active"<?php echo $tbl_dept->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_dept_dept_active"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_dept->dept_active->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_dept->dept_active->CellAttributes() ?>><span id="el_tbl_dept_dept_active">
<input type="text" name="x_dept_active" id="x_dept_active" size="30" value="<?php echo $tbl_dept->dept_active->EditValue ?>"<?php echo $tbl_dept->dept_active->EditAttributes() ?>>
</span><?php echo $tbl_dept->dept_active->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_dept->dept_faculty->Visible) { // dept_faculty ?>
	<tr id="r_dept_faculty"<?php echo $tbl_dept->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_dept_dept_faculty"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_dept->dept_faculty->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_dept->dept_faculty->CellAttributes() ?>><span id="el_tbl_dept_dept_faculty">
<select id="x_dept_faculty" name="x_dept_faculty"<?php echo $tbl_dept->dept_faculty->EditAttributes() ?>>
<?php
if (is_array($tbl_dept->dept_faculty->EditValue)) {
	$arwrk = $tbl_dept->dept_faculty->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_dept->dept_faculty->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_deptedit.Lists["x_dept_faculty"].Options = <?php echo (is_array($tbl_dept->dept_faculty->EditValue)) ? ew_ArrayToJson($tbl_dept->dept_faculty->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_dept->dept_faculty->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_dept->dept_target->Visible) { // dept_target ?>
	<tr id="r_dept_target"<?php echo $tbl_dept->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_dept_dept_target"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_dept->dept_target->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_dept->dept_target->CellAttributes() ?>><span id="el_tbl_dept_dept_target">
<textarea name="x_dept_target" id="x_dept_target" cols="35" rows="4"<?php echo $tbl_dept->dept_target->EditAttributes() ?>><?php echo $tbl_dept->dept_target->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_deptedit", "x_dept_target", 35, 4, <?php echo ($tbl_dept->dept_target->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_dept->dept_target->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_dept->dept_knowleadge->Visible) { // dept_knowleadge ?>
	<tr id="r_dept_knowleadge"<?php echo $tbl_dept->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_dept_dept_knowleadge"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_dept->dept_knowleadge->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_dept->dept_knowleadge->CellAttributes() ?>><span id="el_tbl_dept_dept_knowleadge">
<textarea name="x_dept_knowleadge" id="x_dept_knowleadge" cols="35" rows="4"<?php echo $tbl_dept->dept_knowleadge->EditAttributes() ?>><?php echo $tbl_dept->dept_knowleadge->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_deptedit", "x_dept_knowleadge", 35, 4, <?php echo ($tbl_dept->dept_knowleadge->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_dept->dept_knowleadge->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_dept->dept_behavior->Visible) { // dept_behavior ?>
	<tr id="r_dept_behavior"<?php echo $tbl_dept->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_dept_dept_behavior"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_dept->dept_behavior->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_dept->dept_behavior->CellAttributes() ?>><span id="el_tbl_dept_dept_behavior">
<textarea name="x_dept_behavior" id="x_dept_behavior" cols="35" rows="4"<?php echo $tbl_dept->dept_behavior->EditAttributes() ?>><?php echo $tbl_dept->dept_behavior->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_deptedit", "x_dept_behavior", 35, 4, <?php echo ($tbl_dept->dept_behavior->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_dept->dept_behavior->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_dept->dept_out_standard->Visible) { // dept_out_standard ?>
	<tr id="r_dept_out_standard"<?php echo $tbl_dept->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_dept_dept_out_standard"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_dept->dept_out_standard->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_dept->dept_out_standard->CellAttributes() ?>><span id="el_tbl_dept_dept_out_standard">
<textarea name="x_dept_out_standard" id="x_dept_out_standard" cols="35" rows="4"<?php echo $tbl_dept->dept_out_standard->EditAttributes() ?>><?php echo $tbl_dept->dept_out_standard->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_deptedit", "x_dept_out_standard", 35, 4, <?php echo ($tbl_dept->dept_out_standard->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_dept->dept_out_standard->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_dept->dept_contact->Visible) { // dept_contact ?>
	<tr id="r_dept_contact"<?php echo $tbl_dept->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_dept_dept_contact"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_dept->dept_contact->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_dept->dept_contact->CellAttributes() ?>><span id="el_tbl_dept_dept_contact">
<textarea name="x_dept_contact" id="x_dept_contact" cols="35" rows="4"<?php echo $tbl_dept->dept_contact->EditAttributes() ?>><?php echo $tbl_dept->dept_contact->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_deptedit", "x_dept_contact", 35, 4, <?php echo ($tbl_dept->dept_contact->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_dept->dept_contact->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_dept->dept_in_standart->Visible) { // dept_in_standart ?>
	<tr id="r_dept_in_standart"<?php echo $tbl_dept->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_dept_dept_in_standart"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_dept->dept_in_standart->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_dept->dept_in_standart->CellAttributes() ?>><span id="el_tbl_dept_dept_in_standart">
<textarea name="x_dept_in_standart" id="x_dept_in_standart" cols="35" rows="4"<?php echo $tbl_dept->dept_in_standart->EditAttributes() ?>><?php echo $tbl_dept->dept_in_standart->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_deptedit", "x_dept_in_standart", 35, 4, <?php echo ($tbl_dept->dept_in_standart->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_dept->dept_in_standart->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_dept->dept_language->Visible) { // dept_language ?>
	<tr id="r_dept_language"<?php echo $tbl_dept->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_dept_dept_language"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_dept->dept_language->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_dept->dept_language->CellAttributes() ?>><span id="el_tbl_dept_dept_language">
<textarea name="x_dept_language" id="x_dept_language" cols="35" rows="4"<?php echo $tbl_dept->dept_language->EditAttributes() ?>><?php echo $tbl_dept->dept_language->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_deptedit", "x_dept_language", 35, 4, <?php echo ($tbl_dept->dept_language->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_dept->dept_language->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_dept->dept_credits->Visible) { // dept_credits ?>
	<tr id="r_dept_credits"<?php echo $tbl_dept->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_dept_dept_credits"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_dept->dept_credits->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_dept->dept_credits->CellAttributes() ?>><span id="el_tbl_dept_dept_credits">
<input type="text" name="x_dept_credits" id="x_dept_credits" size="30" value="<?php echo $tbl_dept->dept_credits->EditValue ?>"<?php echo $tbl_dept->dept_credits->EditAttributes() ?>>
</span><?php echo $tbl_dept->dept_credits->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_dept->dept_code->Visible) { // dept_code ?>
	<tr id="r_dept_code"<?php echo $tbl_dept->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_dept_dept_code"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_dept->dept_code->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_dept->dept_code->CellAttributes() ?>><span id="el_tbl_dept_dept_code">
<input type="text" name="x_dept_code" id="x_dept_code" size="30" maxlength="255" value="<?php echo $tbl_dept->dept_code->EditValue ?>"<?php echo $tbl_dept->dept_code->EditAttributes() ?>>
</span><?php echo $tbl_dept->dept_code->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_dept->dept_link_download->Visible) { // dept_link_download ?>
	<tr id="r_dept_link_download"<?php echo $tbl_dept->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_dept_dept_link_download"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_dept->dept_link_download->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_dept->dept_link_download->CellAttributes() ?>><span id="el_tbl_dept_dept_link_download">
<textarea name="x_dept_link_download" id="x_dept_link_download" cols="35" rows="4"<?php echo $tbl_dept->dept_link_download->EditAttributes() ?>><?php echo $tbl_dept->dept_link_download->EditValue ?></textarea>
</span><?php echo $tbl_dept->dept_link_download->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_dept->dept_skill->Visible) { // dept_skill ?>
	<tr id="r_dept_skill"<?php echo $tbl_dept->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_dept_dept_skill"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_dept->dept_skill->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_dept->dept_skill->CellAttributes() ?>><span id="el_tbl_dept_dept_skill">
<textarea name="x_dept_skill" id="x_dept_skill" cols="35" rows="4"<?php echo $tbl_dept->dept_skill->EditAttributes() ?>><?php echo $tbl_dept->dept_skill->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_deptedit", "x_dept_skill", 35, 4, <?php echo ($tbl_dept->dept_skill->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_dept->dept_skill->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
ftbl_deptedit.Init();
</script>
<?php
$tbl_dept_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_dept_edit->Page_Terminate();
?>
