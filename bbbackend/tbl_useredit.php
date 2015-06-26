<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "tbl_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$tbl_user_edit = NULL; // Initialize page object first

class ctbl_user_edit extends ctbl_user {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_user';

	// Page object name
	var $PageObjName = 'tbl_user_edit';

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

		// Table object (tbl_user)
		if (!isset($GLOBALS["tbl_user"])) {
			$GLOBALS["tbl_user"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_user"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_user', TRUE);

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
		$this->user_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		if (@$_GET["user_id"] <> "")
			$this->user_id->setQueryStringValue($_GET["user_id"]);

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->user_id->CurrentValue == "")
			$this->Page_Terminate("tbl_userlist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("tbl_userlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tbl_userview.php")
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
		if (!$this->user_id->FldIsDetailKey)
			$this->user_id->setFormValue($objForm->GetValue("x_user_id"));
		if (!$this->user_id_fb->FldIsDetailKey) {
			$this->user_id_fb->setFormValue($objForm->GetValue("x_user_id_fb"));
		}
		if (!$this->username->FldIsDetailKey) {
			$this->username->setFormValue($objForm->GetValue("x_username"));
		}
		if (!$this->password->FldIsDetailKey) {
			$this->password->setFormValue($objForm->GetValue("x_password"));
		}
		if (!$this->user_real_name->FldIsDetailKey) {
			$this->user_real_name->setFormValue($objForm->GetValue("x_user_real_name"));
		}
		if (!$this->user_avatar->FldIsDetailKey) {
			$this->user_avatar->setFormValue($objForm->GetValue("x_user_avatar"));
		}
		if (!$this->user_cover->FldIsDetailKey) {
			$this->user_cover->setFormValue($objForm->GetValue("x_user_cover"));
		}
		if (!$this->user_student_code->FldIsDetailKey) {
			$this->user_student_code->setFormValue($objForm->GetValue("x_user_student_code"));
		}
		if (!$this->user_university->FldIsDetailKey) {
			$this->user_university->setFormValue($objForm->GetValue("x_user_university"));
		}
		if (!$this->user_gender->FldIsDetailKey) {
			$this->user_gender->setFormValue($objForm->GetValue("x_user_gender"));
		}
		if (!$this->user_dob->FldIsDetailKey) {
			$this->user_dob->setFormValue($objForm->GetValue("x_user_dob"));
		}
		if (!$this->user_hometown->FldIsDetailKey) {
			$this->user_hometown->setFormValue($objForm->GetValue("x_user_hometown"));
		}
		if (!$this->user_phone->FldIsDetailKey) {
			$this->user_phone->setFormValue($objForm->GetValue("x_user_phone"));
		}
		if (!$this->user_description->FldIsDetailKey) {
			$this->user_description->setFormValue($objForm->GetValue("x_user_description"));
		}
		if (!$this->user_faculty->FldIsDetailKey) {
			$this->user_faculty->setFormValue($objForm->GetValue("x_user_faculty"));
		}
		if (!$this->user_class->FldIsDetailKey) {
			$this->user_class->setFormValue($objForm->GetValue("x_user_class"));
		}
		if (!$this->user_active->FldIsDetailKey) {
			$this->user_active->setFormValue($objForm->GetValue("x_user_active"));
		}
		if (!$this->user_status->FldIsDetailKey) {
			$this->user_status->setFormValue($objForm->GetValue("x_user_status"));
		}
		if (!$this->user_group->FldIsDetailKey) {
			$this->user_group->setFormValue($objForm->GetValue("x_user_group"));
		}
		if (!$this->user_token->FldIsDetailKey) {
			$this->user_token->setFormValue($objForm->GetValue("x_user_token"));
		}
		if (!$this->user_activator->FldIsDetailKey) {
			$this->user_activator->setFormValue($objForm->GetValue("x_user_activator"));
		}
		if (!$this->user_qoutes->FldIsDetailKey) {
			$this->user_qoutes->setFormValue($objForm->GetValue("x_user_qoutes"));
		}
		if (!$this->user_date_attend->FldIsDetailKey) {
			$this->user_date_attend->setFormValue($objForm->GetValue("x_user_date_attend"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->user_id->CurrentValue = $this->user_id->FormValue;
		$this->user_id_fb->CurrentValue = $this->user_id_fb->FormValue;
		$this->username->CurrentValue = $this->username->FormValue;
		$this->password->CurrentValue = $this->password->FormValue;
		$this->user_real_name->CurrentValue = $this->user_real_name->FormValue;
		$this->user_avatar->CurrentValue = $this->user_avatar->FormValue;
		$this->user_cover->CurrentValue = $this->user_cover->FormValue;
		$this->user_student_code->CurrentValue = $this->user_student_code->FormValue;
		$this->user_university->CurrentValue = $this->user_university->FormValue;
		$this->user_gender->CurrentValue = $this->user_gender->FormValue;
		$this->user_dob->CurrentValue = $this->user_dob->FormValue;
		$this->user_hometown->CurrentValue = $this->user_hometown->FormValue;
		$this->user_phone->CurrentValue = $this->user_phone->FormValue;
		$this->user_description->CurrentValue = $this->user_description->FormValue;
		$this->user_faculty->CurrentValue = $this->user_faculty->FormValue;
		$this->user_class->CurrentValue = $this->user_class->FormValue;
		$this->user_active->CurrentValue = $this->user_active->FormValue;
		$this->user_status->CurrentValue = $this->user_status->FormValue;
		$this->user_group->CurrentValue = $this->user_group->FormValue;
		$this->user_token->CurrentValue = $this->user_token->FormValue;
		$this->user_activator->CurrentValue = $this->user_activator->FormValue;
		$this->user_qoutes->CurrentValue = $this->user_qoutes->FormValue;
		$this->user_date_attend->CurrentValue = $this->user_date_attend->FormValue;
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
		$this->user_id->setDbValue($rs->fields('user_id'));
		$this->user_id_fb->setDbValue($rs->fields('user_id_fb'));
		$this->username->setDbValue($rs->fields('username'));
		$this->password->setDbValue($rs->fields('password'));
		$this->user_real_name->setDbValue($rs->fields('user_real_name'));
		$this->user_avatar->setDbValue($rs->fields('user_avatar'));
		$this->user_cover->setDbValue($rs->fields('user_cover'));
		$this->user_student_code->setDbValue($rs->fields('user_student_code'));
		$this->user_university->setDbValue($rs->fields('user_university'));
		$this->user_gender->setDbValue($rs->fields('user_gender'));
		$this->user_dob->setDbValue($rs->fields('user_dob'));
		$this->user_hometown->setDbValue($rs->fields('user_hometown'));
		$this->user_phone->setDbValue($rs->fields('user_phone'));
		$this->user_description->setDbValue($rs->fields('user_description'));
		$this->user_faculty->setDbValue($rs->fields('user_faculty'));
		$this->user_class->setDbValue($rs->fields('user_class'));
		$this->user_active->setDbValue($rs->fields('user_active'));
		$this->user_status->setDbValue($rs->fields('user_status'));
		$this->user_group->setDbValue($rs->fields('user_group'));
		$this->user_token->setDbValue($rs->fields('user_token'));
		$this->user_activator->setDbValue($rs->fields('user_activator'));
		$this->user_qoutes->setDbValue($rs->fields('user_qoutes'));
		$this->user_date_attend->setDbValue($rs->fields('user_date_attend'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// user_id
		// user_id_fb
		// username
		// password
		// user_real_name
		// user_avatar
		// user_cover
		// user_student_code
		// user_university
		// user_gender
		// user_dob
		// user_hometown
		// user_phone
		// user_description
		// user_faculty
		// user_class
		// user_active
		// user_status
		// user_group
		// user_token
		// user_activator
		// user_qoutes
		// user_date_attend

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// user_id
			$this->user_id->ViewValue = $this->user_id->CurrentValue;
			$this->user_id->ViewCustomAttributes = "";

			// user_id_fb
			$this->user_id_fb->ViewValue = $this->user_id_fb->CurrentValue;
			$this->user_id_fb->ViewCustomAttributes = "";

			// username
			$this->username->ViewValue = $this->username->CurrentValue;
			$this->username->ViewCustomAttributes = "";

			// password
			$this->password->ViewValue = $this->password->CurrentValue;
			$this->password->ViewCustomAttributes = "";

			// user_real_name
			$this->user_real_name->ViewValue = $this->user_real_name->CurrentValue;
			$this->user_real_name->ViewCustomAttributes = "";

			// user_avatar
			$this->user_avatar->ViewValue = $this->user_avatar->CurrentValue;
			$this->user_avatar->ImageAlt = $this->user_avatar->FldAlt();
			$this->user_avatar->ViewCustomAttributes = "";

			// user_cover
			$this->user_cover->ViewValue = $this->user_cover->CurrentValue;
			$this->user_cover->ViewCustomAttributes = "";

			// user_student_code
			$this->user_student_code->ViewValue = $this->user_student_code->CurrentValue;
			$this->user_student_code->ViewCustomAttributes = "";

			// user_university
			$this->user_university->ViewValue = $this->user_university->CurrentValue;
			$this->user_university->ViewCustomAttributes = "";

			// user_gender
			$this->user_gender->ViewValue = $this->user_gender->CurrentValue;
			$this->user_gender->ViewCustomAttributes = "";

			// user_dob
			$this->user_dob->ViewValue = $this->user_dob->CurrentValue;
			$this->user_dob->ViewCustomAttributes = "";

			// user_hometown
			$this->user_hometown->ViewValue = $this->user_hometown->CurrentValue;
			$this->user_hometown->ViewCustomAttributes = "";

			// user_phone
			$this->user_phone->ViewValue = $this->user_phone->CurrentValue;
			$this->user_phone->ViewCustomAttributes = "";

			// user_description
			$this->user_description->ViewValue = $this->user_description->CurrentValue;
			$this->user_description->ViewCustomAttributes = "";

			// user_faculty
			$this->user_faculty->ViewValue = $this->user_faculty->CurrentValue;
			$this->user_faculty->ViewCustomAttributes = "";

			// user_class
			$this->user_class->ViewValue = $this->user_class->CurrentValue;
			$this->user_class->ViewCustomAttributes = "";

			// user_active
			$this->user_active->ViewValue = $this->user_active->CurrentValue;
			$this->user_active->ViewCustomAttributes = "";

			// user_status
			$this->user_status->ViewValue = $this->user_status->CurrentValue;
			$this->user_status->ViewCustomAttributes = "";

			// user_group
			$this->user_group->ViewValue = $this->user_group->CurrentValue;
			$this->user_group->ViewCustomAttributes = "";

			// user_token
			$this->user_token->ViewValue = $this->user_token->CurrentValue;
			$this->user_token->ViewCustomAttributes = "";

			// user_activator
			$this->user_activator->ViewValue = $this->user_activator->CurrentValue;
			$this->user_activator->ViewCustomAttributes = "";

			// user_qoutes
			$this->user_qoutes->ViewValue = $this->user_qoutes->CurrentValue;
			$this->user_qoutes->ViewCustomAttributes = "";

			// user_date_attend
			$this->user_date_attend->ViewValue = $this->user_date_attend->CurrentValue;
			$this->user_date_attend->ViewCustomAttributes = "";

			// user_id
			$this->user_id->LinkCustomAttributes = "";
			$this->user_id->HrefValue = "";
			$this->user_id->TooltipValue = "";

			// user_id_fb
			$this->user_id_fb->LinkCustomAttributes = "";
			$this->user_id_fb->HrefValue = "";
			$this->user_id_fb->TooltipValue = "";

			// username
			$this->username->LinkCustomAttributes = "";
			$this->username->HrefValue = "";
			$this->username->TooltipValue = "";

			// password
			$this->password->LinkCustomAttributes = "";
			$this->password->HrefValue = "";
			$this->password->TooltipValue = "";

			// user_real_name
			$this->user_real_name->LinkCustomAttributes = "";
			$this->user_real_name->HrefValue = "";
			$this->user_real_name->TooltipValue = "";

			// user_avatar
			$this->user_avatar->LinkCustomAttributes = "";
			$this->user_avatar->HrefValue = "";
			$this->user_avatar->TooltipValue = "";

			// user_cover
			$this->user_cover->LinkCustomAttributes = "";
			$this->user_cover->HrefValue = "";
			$this->user_cover->TooltipValue = "";

			// user_student_code
			$this->user_student_code->LinkCustomAttributes = "";
			$this->user_student_code->HrefValue = "";
			$this->user_student_code->TooltipValue = "";

			// user_university
			$this->user_university->LinkCustomAttributes = "";
			$this->user_university->HrefValue = "";
			$this->user_university->TooltipValue = "";

			// user_gender
			$this->user_gender->LinkCustomAttributes = "";
			$this->user_gender->HrefValue = "";
			$this->user_gender->TooltipValue = "";

			// user_dob
			$this->user_dob->LinkCustomAttributes = "";
			$this->user_dob->HrefValue = "";
			$this->user_dob->TooltipValue = "";

			// user_hometown
			$this->user_hometown->LinkCustomAttributes = "";
			$this->user_hometown->HrefValue = "";
			$this->user_hometown->TooltipValue = "";

			// user_phone
			$this->user_phone->LinkCustomAttributes = "";
			$this->user_phone->HrefValue = "";
			$this->user_phone->TooltipValue = "";

			// user_description
			$this->user_description->LinkCustomAttributes = "";
			$this->user_description->HrefValue = "";
			$this->user_description->TooltipValue = "";

			// user_faculty
			$this->user_faculty->LinkCustomAttributes = "";
			$this->user_faculty->HrefValue = "";
			$this->user_faculty->TooltipValue = "";

			// user_class
			$this->user_class->LinkCustomAttributes = "";
			$this->user_class->HrefValue = "";
			$this->user_class->TooltipValue = "";

			// user_active
			$this->user_active->LinkCustomAttributes = "";
			$this->user_active->HrefValue = "";
			$this->user_active->TooltipValue = "";

			// user_status
			$this->user_status->LinkCustomAttributes = "";
			$this->user_status->HrefValue = "";
			$this->user_status->TooltipValue = "";

			// user_group
			$this->user_group->LinkCustomAttributes = "";
			$this->user_group->HrefValue = "";
			$this->user_group->TooltipValue = "";

			// user_token
			$this->user_token->LinkCustomAttributes = "";
			$this->user_token->HrefValue = "";
			$this->user_token->TooltipValue = "";

			// user_activator
			$this->user_activator->LinkCustomAttributes = "";
			$this->user_activator->HrefValue = "";
			$this->user_activator->TooltipValue = "";

			// user_qoutes
			$this->user_qoutes->LinkCustomAttributes = "";
			$this->user_qoutes->HrefValue = "";
			$this->user_qoutes->TooltipValue = "";

			// user_date_attend
			$this->user_date_attend->LinkCustomAttributes = "";
			$this->user_date_attend->HrefValue = "";
			$this->user_date_attend->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// user_id
			$this->user_id->EditCustomAttributes = "";
			$this->user_id->EditValue = $this->user_id->CurrentValue;
			$this->user_id->ViewCustomAttributes = "";

			// user_id_fb
			$this->user_id_fb->EditCustomAttributes = "";
			$this->user_id_fb->EditValue = ew_HtmlEncode($this->user_id_fb->CurrentValue);

			// username
			$this->username->EditCustomAttributes = "";
			$this->username->EditValue = ew_HtmlEncode($this->username->CurrentValue);

			// password
			$this->password->EditCustomAttributes = "";
			$this->password->EditValue = ew_HtmlEncode($this->password->CurrentValue);

			// user_real_name
			$this->user_real_name->EditCustomAttributes = "";
			$this->user_real_name->EditValue = ew_HtmlEncode($this->user_real_name->CurrentValue);

			// user_avatar
			$this->user_avatar->EditCustomAttributes = "";
			$this->user_avatar->EditValue = ew_HtmlEncode($this->user_avatar->CurrentValue);

			// user_cover
			$this->user_cover->EditCustomAttributes = "";
			$this->user_cover->EditValue = ew_HtmlEncode($this->user_cover->CurrentValue);

			// user_student_code
			$this->user_student_code->EditCustomAttributes = "";
			$this->user_student_code->EditValue = ew_HtmlEncode($this->user_student_code->CurrentValue);

			// user_university
			$this->user_university->EditCustomAttributes = "";
			$this->user_university->EditValue = ew_HtmlEncode($this->user_university->CurrentValue);

			// user_gender
			$this->user_gender->EditCustomAttributes = "";
			$this->user_gender->EditValue = ew_HtmlEncode($this->user_gender->CurrentValue);

			// user_dob
			$this->user_dob->EditCustomAttributes = "";
			$this->user_dob->EditValue = ew_HtmlEncode($this->user_dob->CurrentValue);

			// user_hometown
			$this->user_hometown->EditCustomAttributes = "";
			$this->user_hometown->EditValue = ew_HtmlEncode($this->user_hometown->CurrentValue);

			// user_phone
			$this->user_phone->EditCustomAttributes = "";
			$this->user_phone->EditValue = ew_HtmlEncode($this->user_phone->CurrentValue);

			// user_description
			$this->user_description->EditCustomAttributes = "";
			$this->user_description->EditValue = ew_HtmlEncode($this->user_description->CurrentValue);

			// user_faculty
			$this->user_faculty->EditCustomAttributes = "";
			$this->user_faculty->EditValue = ew_HtmlEncode($this->user_faculty->CurrentValue);

			// user_class
			$this->user_class->EditCustomAttributes = "";
			$this->user_class->EditValue = ew_HtmlEncode($this->user_class->CurrentValue);

			// user_active
			$this->user_active->EditCustomAttributes = "";
			$this->user_active->EditValue = ew_HtmlEncode($this->user_active->CurrentValue);

			// user_status
			$this->user_status->EditCustomAttributes = "";
			$this->user_status->EditValue = ew_HtmlEncode($this->user_status->CurrentValue);

			// user_group
			$this->user_group->EditCustomAttributes = "";
			$this->user_group->EditValue = ew_HtmlEncode($this->user_group->CurrentValue);

			// user_token
			$this->user_token->EditCustomAttributes = "";
			$this->user_token->EditValue = ew_HtmlEncode($this->user_token->CurrentValue);

			// user_activator
			$this->user_activator->EditCustomAttributes = "";
			$this->user_activator->EditValue = ew_HtmlEncode($this->user_activator->CurrentValue);

			// user_qoutes
			$this->user_qoutes->EditCustomAttributes = "";
			$this->user_qoutes->EditValue = ew_HtmlEncode($this->user_qoutes->CurrentValue);

			// user_date_attend
			$this->user_date_attend->EditCustomAttributes = "";
			$this->user_date_attend->EditValue = ew_HtmlEncode($this->user_date_attend->CurrentValue);

			// Edit refer script
			// user_id

			$this->user_id->HrefValue = "";

			// user_id_fb
			$this->user_id_fb->HrefValue = "";

			// username
			$this->username->HrefValue = "";

			// password
			$this->password->HrefValue = "";

			// user_real_name
			$this->user_real_name->HrefValue = "";

			// user_avatar
			$this->user_avatar->HrefValue = "";

			// user_cover
			$this->user_cover->HrefValue = "";

			// user_student_code
			$this->user_student_code->HrefValue = "";

			// user_university
			$this->user_university->HrefValue = "";

			// user_gender
			$this->user_gender->HrefValue = "";

			// user_dob
			$this->user_dob->HrefValue = "";

			// user_hometown
			$this->user_hometown->HrefValue = "";

			// user_phone
			$this->user_phone->HrefValue = "";

			// user_description
			$this->user_description->HrefValue = "";

			// user_faculty
			$this->user_faculty->HrefValue = "";

			// user_class
			$this->user_class->HrefValue = "";

			// user_active
			$this->user_active->HrefValue = "";

			// user_status
			$this->user_status->HrefValue = "";

			// user_group
			$this->user_group->HrefValue = "";

			// user_token
			$this->user_token->HrefValue = "";

			// user_activator
			$this->user_activator->HrefValue = "";

			// user_qoutes
			$this->user_qoutes->HrefValue = "";

			// user_date_attend
			$this->user_date_attend->HrefValue = "";
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
		if (!ew_CheckInteger($this->user_university->FormValue)) {
			ew_AddMessage($gsFormError, $this->user_university->FldErrMsg());
		}
		if (!ew_CheckInteger($this->user_faculty->FormValue)) {
			ew_AddMessage($gsFormError, $this->user_faculty->FldErrMsg());
		}
		if (!ew_CheckInteger($this->user_class->FormValue)) {
			ew_AddMessage($gsFormError, $this->user_class->FldErrMsg());
		}
		if (!ew_CheckInteger($this->user_active->FormValue)) {
			ew_AddMessage($gsFormError, $this->user_active->FldErrMsg());
		}
		if (!ew_CheckInteger($this->user_status->FormValue)) {
			ew_AddMessage($gsFormError, $this->user_status->FldErrMsg());
		}
		if (!ew_CheckInteger($this->user_group->FormValue)) {
			ew_AddMessage($gsFormError, $this->user_group->FldErrMsg());
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

			// user_id_fb
			$this->user_id_fb->SetDbValueDef($rsnew, $this->user_id_fb->CurrentValue, NULL, $this->user_id_fb->ReadOnly);

			// username
			$this->username->SetDbValueDef($rsnew, $this->username->CurrentValue, NULL, $this->username->ReadOnly);

			// password
			$this->password->SetDbValueDef($rsnew, $this->password->CurrentValue, NULL, $this->password->ReadOnly);

			// user_real_name
			$this->user_real_name->SetDbValueDef($rsnew, $this->user_real_name->CurrentValue, NULL, $this->user_real_name->ReadOnly);

			// user_avatar
			$this->user_avatar->SetDbValueDef($rsnew, $this->user_avatar->CurrentValue, NULL, $this->user_avatar->ReadOnly);

			// user_cover
			$this->user_cover->SetDbValueDef($rsnew, $this->user_cover->CurrentValue, NULL, $this->user_cover->ReadOnly);

			// user_student_code
			$this->user_student_code->SetDbValueDef($rsnew, $this->user_student_code->CurrentValue, NULL, $this->user_student_code->ReadOnly);

			// user_university
			$this->user_university->SetDbValueDef($rsnew, $this->user_university->CurrentValue, NULL, $this->user_university->ReadOnly);

			// user_gender
			$this->user_gender->SetDbValueDef($rsnew, $this->user_gender->CurrentValue, NULL, $this->user_gender->ReadOnly);

			// user_dob
			$this->user_dob->SetDbValueDef($rsnew, $this->user_dob->CurrentValue, NULL, $this->user_dob->ReadOnly);

			// user_hometown
			$this->user_hometown->SetDbValueDef($rsnew, $this->user_hometown->CurrentValue, NULL, $this->user_hometown->ReadOnly);

			// user_phone
			$this->user_phone->SetDbValueDef($rsnew, $this->user_phone->CurrentValue, NULL, $this->user_phone->ReadOnly);

			// user_description
			$this->user_description->SetDbValueDef($rsnew, $this->user_description->CurrentValue, NULL, $this->user_description->ReadOnly);

			// user_faculty
			$this->user_faculty->SetDbValueDef($rsnew, $this->user_faculty->CurrentValue, NULL, $this->user_faculty->ReadOnly);

			// user_class
			$this->user_class->SetDbValueDef($rsnew, $this->user_class->CurrentValue, NULL, $this->user_class->ReadOnly);

			// user_active
			$this->user_active->SetDbValueDef($rsnew, $this->user_active->CurrentValue, NULL, $this->user_active->ReadOnly);

			// user_status
			$this->user_status->SetDbValueDef($rsnew, $this->user_status->CurrentValue, NULL, $this->user_status->ReadOnly);

			// user_group
			$this->user_group->SetDbValueDef($rsnew, $this->user_group->CurrentValue, NULL, $this->user_group->ReadOnly);

			// user_token
			$this->user_token->SetDbValueDef($rsnew, $this->user_token->CurrentValue, NULL, $this->user_token->ReadOnly);

			// user_activator
			$this->user_activator->SetDbValueDef($rsnew, $this->user_activator->CurrentValue, NULL, $this->user_activator->ReadOnly);

			// user_qoutes
			$this->user_qoutes->SetDbValueDef($rsnew, $this->user_qoutes->CurrentValue, NULL, $this->user_qoutes->ReadOnly);

			// user_date_attend
			$this->user_date_attend->SetDbValueDef($rsnew, $this->user_date_attend->CurrentValue, NULL, $this->user_date_attend->ReadOnly);

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
if (!isset($tbl_user_edit)) $tbl_user_edit = new ctbl_user_edit();

// Page init
$tbl_user_edit->Page_Init();

// Page main
$tbl_user_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_user_edit = new ew_Page("tbl_user_edit");
tbl_user_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = tbl_user_edit.PageID; // For backward compatibility

// Form object
var ftbl_useredit = new ew_Form("ftbl_useredit");

// Validate form
ftbl_useredit.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_user_university"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_user->user_university->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_user_faculty"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_user->user_faculty->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_user_class"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_user->user_class->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_user_active"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_user->user_active->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_user_status"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_user->user_status->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_user_group"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_user->user_group->FldErrMsg()) ?>");

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
ftbl_useredit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_useredit.ValidateRequired = true;
<?php } else { ?>
ftbl_useredit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_user->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $tbl_user->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $tbl_user_edit->ShowPageHeader(); ?>
<?php
$tbl_user_edit->ShowMessage();
?>
<form name="ftbl_useredit" id="ftbl_useredit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="tbl_user">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_useredit" class="ewTable">
<?php if ($tbl_user->user_id->Visible) { // user_id ?>
	<tr id="r_user_id"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_id->CellAttributes() ?>><span id="el_tbl_user_user_id">
<span<?php echo $tbl_user->user_id->ViewAttributes() ?>>
<?php echo $tbl_user->user_id->EditValue ?></span>
<input type="hidden" name="x_user_id" id="x_user_id" value="<?php echo ew_HtmlEncode($tbl_user->user_id->CurrentValue) ?>">
</span><?php echo $tbl_user->user_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_id_fb->Visible) { // user_id_fb ?>
	<tr id="r_user_id_fb"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_id_fb"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_id_fb->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_id_fb->CellAttributes() ?>><span id="el_tbl_user_user_id_fb">
<input type="text" name="x_user_id_fb" id="x_user_id_fb" size="30" maxlength="200" value="<?php echo $tbl_user->user_id_fb->EditValue ?>"<?php echo $tbl_user->user_id_fb->EditAttributes() ?>>
</span><?php echo $tbl_user->user_id_fb->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->username->Visible) { // username ?>
	<tr id="r_username"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_username"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->username->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->username->CellAttributes() ?>><span id="el_tbl_user_username">
<input type="text" name="x_username" id="x_username" size="30" maxlength="45" value="<?php echo $tbl_user->username->EditValue ?>"<?php echo $tbl_user->username->EditAttributes() ?>>
</span><?php echo $tbl_user->username->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->password->Visible) { // password ?>
	<tr id="r_password"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_password"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->password->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->password->CellAttributes() ?>><span id="el_tbl_user_password">
<input type="text" name="x_password" id="x_password" size="30" maxlength="45" value="<?php echo $tbl_user->password->EditValue ?>"<?php echo $tbl_user->password->EditAttributes() ?>>
</span><?php echo $tbl_user->password->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_real_name->Visible) { // user_real_name ?>
	<tr id="r_user_real_name"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_real_name"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_real_name->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_real_name->CellAttributes() ?>><span id="el_tbl_user_user_real_name">
<input type="text" name="x_user_real_name" id="x_user_real_name" size="30" maxlength="45" value="<?php echo $tbl_user->user_real_name->EditValue ?>"<?php echo $tbl_user->user_real_name->EditAttributes() ?>>
</span><?php echo $tbl_user->user_real_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_avatar->Visible) { // user_avatar ?>
	<tr id="r_user_avatar"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_avatar"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_avatar->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_avatar->CellAttributes() ?>><span id="el_tbl_user_user_avatar">
<input type="text" name="x_user_avatar" id="x_user_avatar" size="30" maxlength="200" value="<?php echo $tbl_user->user_avatar->EditValue ?>"<?php echo $tbl_user->user_avatar->EditAttributes() ?>>
</span><?php echo $tbl_user->user_avatar->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_cover->Visible) { // user_cover ?>
	<tr id="r_user_cover"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_cover"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_cover->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_cover->CellAttributes() ?>><span id="el_tbl_user_user_cover">
<input type="text" name="x_user_cover" id="x_user_cover" size="30" maxlength="200" value="<?php echo $tbl_user->user_cover->EditValue ?>"<?php echo $tbl_user->user_cover->EditAttributes() ?>>
</span><?php echo $tbl_user->user_cover->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_student_code->Visible) { // user_student_code ?>
	<tr id="r_user_student_code"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_student_code"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_student_code->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_student_code->CellAttributes() ?>><span id="el_tbl_user_user_student_code">
<input type="text" name="x_user_student_code" id="x_user_student_code" size="30" maxlength="45" value="<?php echo $tbl_user->user_student_code->EditValue ?>"<?php echo $tbl_user->user_student_code->EditAttributes() ?>>
</span><?php echo $tbl_user->user_student_code->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_university->Visible) { // user_university ?>
	<tr id="r_user_university"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_university"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_university->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_university->CellAttributes() ?>><span id="el_tbl_user_user_university">
<input type="text" name="x_user_university" id="x_user_university" size="30" value="<?php echo $tbl_user->user_university->EditValue ?>"<?php echo $tbl_user->user_university->EditAttributes() ?>>
</span><?php echo $tbl_user->user_university->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_gender->Visible) { // user_gender ?>
	<tr id="r_user_gender"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_gender"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_gender->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_gender->CellAttributes() ?>><span id="el_tbl_user_user_gender">
<input type="text" name="x_user_gender" id="x_user_gender" size="30" maxlength="45" value="<?php echo $tbl_user->user_gender->EditValue ?>"<?php echo $tbl_user->user_gender->EditAttributes() ?>>
</span><?php echo $tbl_user->user_gender->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_dob->Visible) { // user_dob ?>
	<tr id="r_user_dob"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_dob"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_dob->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_dob->CellAttributes() ?>><span id="el_tbl_user_user_dob">
<input type="text" name="x_user_dob" id="x_user_dob" size="30" maxlength="45" value="<?php echo $tbl_user->user_dob->EditValue ?>"<?php echo $tbl_user->user_dob->EditAttributes() ?>>
</span><?php echo $tbl_user->user_dob->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_hometown->Visible) { // user_hometown ?>
	<tr id="r_user_hometown"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_hometown"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_hometown->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_hometown->CellAttributes() ?>><span id="el_tbl_user_user_hometown">
<input type="text" name="x_user_hometown" id="x_user_hometown" size="30" maxlength="200" value="<?php echo $tbl_user->user_hometown->EditValue ?>"<?php echo $tbl_user->user_hometown->EditAttributes() ?>>
</span><?php echo $tbl_user->user_hometown->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_phone->Visible) { // user_phone ?>
	<tr id="r_user_phone"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_phone"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_phone->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_phone->CellAttributes() ?>><span id="el_tbl_user_user_phone">
<input type="text" name="x_user_phone" id="x_user_phone" size="30" maxlength="45" value="<?php echo $tbl_user->user_phone->EditValue ?>"<?php echo $tbl_user->user_phone->EditAttributes() ?>>
</span><?php echo $tbl_user->user_phone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_description->Visible) { // user_description ?>
	<tr id="r_user_description"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_description"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_description->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_description->CellAttributes() ?>><span id="el_tbl_user_user_description">
<input type="text" name="x_user_description" id="x_user_description" size="30" maxlength="200" value="<?php echo $tbl_user->user_description->EditValue ?>"<?php echo $tbl_user->user_description->EditAttributes() ?>>
</span><?php echo $tbl_user->user_description->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_faculty->Visible) { // user_faculty ?>
	<tr id="r_user_faculty"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_faculty"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_faculty->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_faculty->CellAttributes() ?>><span id="el_tbl_user_user_faculty">
<input type="text" name="x_user_faculty" id="x_user_faculty" size="30" value="<?php echo $tbl_user->user_faculty->EditValue ?>"<?php echo $tbl_user->user_faculty->EditAttributes() ?>>
</span><?php echo $tbl_user->user_faculty->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_class->Visible) { // user_class ?>
	<tr id="r_user_class"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_class"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_class->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_class->CellAttributes() ?>><span id="el_tbl_user_user_class">
<input type="text" name="x_user_class" id="x_user_class" size="30" value="<?php echo $tbl_user->user_class->EditValue ?>"<?php echo $tbl_user->user_class->EditAttributes() ?>>
</span><?php echo $tbl_user->user_class->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_active->Visible) { // user_active ?>
	<tr id="r_user_active"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_active"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_active->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_active->CellAttributes() ?>><span id="el_tbl_user_user_active">
<input type="text" name="x_user_active" id="x_user_active" size="30" value="<?php echo $tbl_user->user_active->EditValue ?>"<?php echo $tbl_user->user_active->EditAttributes() ?>>
</span><?php echo $tbl_user->user_active->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_status->Visible) { // user_status ?>
	<tr id="r_user_status"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_status"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_status->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_status->CellAttributes() ?>><span id="el_tbl_user_user_status">
<input type="text" name="x_user_status" id="x_user_status" size="30" value="<?php echo $tbl_user->user_status->EditValue ?>"<?php echo $tbl_user->user_status->EditAttributes() ?>>
</span><?php echo $tbl_user->user_status->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_group->Visible) { // user_group ?>
	<tr id="r_user_group"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_group"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_group->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_group->CellAttributes() ?>><span id="el_tbl_user_user_group">
<input type="text" name="x_user_group" id="x_user_group" size="30" value="<?php echo $tbl_user->user_group->EditValue ?>"<?php echo $tbl_user->user_group->EditAttributes() ?>>
</span><?php echo $tbl_user->user_group->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_token->Visible) { // user_token ?>
	<tr id="r_user_token"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_token"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_token->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_token->CellAttributes() ?>><span id="el_tbl_user_user_token">
<input type="text" name="x_user_token" id="x_user_token" size="30" maxlength="200" value="<?php echo $tbl_user->user_token->EditValue ?>"<?php echo $tbl_user->user_token->EditAttributes() ?>>
</span><?php echo $tbl_user->user_token->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_activator->Visible) { // user_activator ?>
	<tr id="r_user_activator"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_activator"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_activator->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_activator->CellAttributes() ?>><span id="el_tbl_user_user_activator">
<input type="text" name="x_user_activator" id="x_user_activator" size="30" maxlength="200" value="<?php echo $tbl_user->user_activator->EditValue ?>"<?php echo $tbl_user->user_activator->EditAttributes() ?>>
</span><?php echo $tbl_user->user_activator->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_qoutes->Visible) { // user_qoutes ?>
	<tr id="r_user_qoutes"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_qoutes"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_qoutes->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_qoutes->CellAttributes() ?>><span id="el_tbl_user_user_qoutes">
<textarea name="x_user_qoutes" id="x_user_qoutes" cols="35" rows="4"<?php echo $tbl_user->user_qoutes->EditAttributes() ?>><?php echo $tbl_user->user_qoutes->EditValue ?></textarea>
</span><?php echo $tbl_user->user_qoutes->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_date_attend->Visible) { // user_date_attend ?>
	<tr id="r_user_date_attend"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_date_attend"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_date_attend->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_date_attend->CellAttributes() ?>><span id="el_tbl_user_user_date_attend">
<textarea name="x_user_date_attend" id="x_user_date_attend" cols="undefined" rows="undefined"<?php echo $tbl_user->user_date_attend->EditAttributes() ?>><?php echo $tbl_user->user_date_attend->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_useredit", "x_user_date_attend", 0, 0, <?php echo ($tbl_user->user_date_attend->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_user->user_date_attend->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
ftbl_useredit.Init();
</script>
<?php
$tbl_user_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_user_edit->Page_Terminate();
?>
