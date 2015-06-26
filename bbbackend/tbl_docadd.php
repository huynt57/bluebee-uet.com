<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "tbl_docinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$tbl_doc_add = NULL; // Initialize page object first

class ctbl_doc_add extends ctbl_doc {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_doc';

	// Page object name
	var $PageObjName = 'tbl_doc_add';

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

		// Table object (tbl_doc)
		if (!isset($GLOBALS["tbl_doc"])) {
			$GLOBALS["tbl_doc"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_doc"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_doc', TRUE);

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
			if (@$_GET["doc_id"] != "") {
				$this->doc_id->setQueryStringValue($_GET["doc_id"]);
				$this->setKey("doc_id", $this->doc_id->CurrentValue); // Set up key
			} else {
				$this->setKey("doc_id", ""); // Clear key
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
					$this->Page_Terminate("tbl_doclist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tbl_docview.php")
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
		$this->doc_url->CurrentValue = NULL;
		$this->doc_url->OldValue = $this->doc_url->CurrentValue;
		$this->doc_name->CurrentValue = NULL;
		$this->doc_name->OldValue = $this->doc_name->CurrentValue;
		$this->doc_scribd_id->CurrentValue = NULL;
		$this->doc_scribd_id->OldValue = $this->doc_scribd_id->CurrentValue;
		$this->doc_description->CurrentValue = NULL;
		$this->doc_description->OldValue = $this->doc_description->CurrentValue;
		$this->doc_title->CurrentValue = NULL;
		$this->doc_title->OldValue = $this->doc_title->CurrentValue;
		$this->doc_status->CurrentValue = NULL;
		$this->doc_status->OldValue = $this->doc_status->CurrentValue;
		$this->doc_author->CurrentValue = NULL;
		$this->doc_author->OldValue = $this->doc_author->CurrentValue;
		$this->doc_type->CurrentValue = NULL;
		$this->doc_type->OldValue = $this->doc_type->CurrentValue;
		$this->doc_path->CurrentValue = NULL;
		$this->doc_path->OldValue = $this->doc_path->CurrentValue;
		$this->subject_dept->CurrentValue = NULL;
		$this->subject_dept->OldValue = $this->subject_dept->CurrentValue;
		$this->subject_type->CurrentValue = NULL;
		$this->subject_type->OldValue = $this->subject_type->CurrentValue;
		$this->subject_faculty->CurrentValue = NULL;
		$this->subject_faculty->OldValue = $this->subject_faculty->CurrentValue;
		$this->doc_author_name->CurrentValue = NULL;
		$this->doc_author_name->OldValue = $this->doc_author_name->CurrentValue;
		$this->doc_publisher->CurrentValue = NULL;
		$this->doc_publisher->OldValue = $this->doc_publisher->CurrentValue;
		$this->subject_general_faculty_id->CurrentValue = NULL;
		$this->subject_general_faculty_id->OldValue = $this->subject_general_faculty_id->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->doc_url->FldIsDetailKey) {
			$this->doc_url->setFormValue($objForm->GetValue("x_doc_url"));
		}
		if (!$this->doc_name->FldIsDetailKey) {
			$this->doc_name->setFormValue($objForm->GetValue("x_doc_name"));
		}
		if (!$this->doc_scribd_id->FldIsDetailKey) {
			$this->doc_scribd_id->setFormValue($objForm->GetValue("x_doc_scribd_id"));
		}
		if (!$this->doc_description->FldIsDetailKey) {
			$this->doc_description->setFormValue($objForm->GetValue("x_doc_description"));
		}
		if (!$this->doc_title->FldIsDetailKey) {
			$this->doc_title->setFormValue($objForm->GetValue("x_doc_title"));
		}
		if (!$this->doc_status->FldIsDetailKey) {
			$this->doc_status->setFormValue($objForm->GetValue("x_doc_status"));
		}
		if (!$this->doc_author->FldIsDetailKey) {
			$this->doc_author->setFormValue($objForm->GetValue("x_doc_author"));
		}
		if (!$this->doc_type->FldIsDetailKey) {
			$this->doc_type->setFormValue($objForm->GetValue("x_doc_type"));
		}
		if (!$this->doc_path->FldIsDetailKey) {
			$this->doc_path->setFormValue($objForm->GetValue("x_doc_path"));
		}
		if (!$this->subject_dept->FldIsDetailKey) {
			$this->subject_dept->setFormValue($objForm->GetValue("x_subject_dept"));
		}
		if (!$this->subject_type->FldIsDetailKey) {
			$this->subject_type->setFormValue($objForm->GetValue("x_subject_type"));
		}
		if (!$this->subject_faculty->FldIsDetailKey) {
			$this->subject_faculty->setFormValue($objForm->GetValue("x_subject_faculty"));
		}
		if (!$this->doc_author_name->FldIsDetailKey) {
			$this->doc_author_name->setFormValue($objForm->GetValue("x_doc_author_name"));
		}
		if (!$this->doc_publisher->FldIsDetailKey) {
			$this->doc_publisher->setFormValue($objForm->GetValue("x_doc_publisher"));
		}
		if (!$this->subject_general_faculty_id->FldIsDetailKey) {
			$this->subject_general_faculty_id->setFormValue($objForm->GetValue("x_subject_general_faculty_id"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->doc_url->CurrentValue = $this->doc_url->FormValue;
		$this->doc_name->CurrentValue = $this->doc_name->FormValue;
		$this->doc_scribd_id->CurrentValue = $this->doc_scribd_id->FormValue;
		$this->doc_description->CurrentValue = $this->doc_description->FormValue;
		$this->doc_title->CurrentValue = $this->doc_title->FormValue;
		$this->doc_status->CurrentValue = $this->doc_status->FormValue;
		$this->doc_author->CurrentValue = $this->doc_author->FormValue;
		$this->doc_type->CurrentValue = $this->doc_type->FormValue;
		$this->doc_path->CurrentValue = $this->doc_path->FormValue;
		$this->subject_dept->CurrentValue = $this->subject_dept->FormValue;
		$this->subject_type->CurrentValue = $this->subject_type->FormValue;
		$this->subject_faculty->CurrentValue = $this->subject_faculty->FormValue;
		$this->doc_author_name->CurrentValue = $this->doc_author_name->FormValue;
		$this->doc_publisher->CurrentValue = $this->doc_publisher->FormValue;
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
		$this->doc_id->setDbValue($rs->fields('doc_id'));
		$this->doc_url->setDbValue($rs->fields('doc_url'));
		$this->doc_name->setDbValue($rs->fields('doc_name'));
		$this->doc_scribd_id->setDbValue($rs->fields('doc_scribd_id'));
		$this->doc_description->setDbValue($rs->fields('doc_description'));
		$this->doc_title->setDbValue($rs->fields('doc_title'));
		$this->doc_status->setDbValue($rs->fields('doc_status'));
		$this->doc_author->setDbValue($rs->fields('doc_author'));
		$this->doc_type->setDbValue($rs->fields('doc_type'));
		$this->doc_path->setDbValue($rs->fields('doc_path'));
		$this->subject_dept->setDbValue($rs->fields('subject_dept'));
		$this->subject_type->setDbValue($rs->fields('subject_type'));
		$this->subject_faculty->setDbValue($rs->fields('subject_faculty'));
		$this->doc_author_name->setDbValue($rs->fields('doc_author_name'));
		$this->doc_publisher->setDbValue($rs->fields('doc_publisher'));
		$this->subject_general_faculty_id->setDbValue($rs->fields('subject_general_faculty_id'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("doc_id")) <> "")
			$this->doc_id->CurrentValue = $this->getKey("doc_id"); // doc_id
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
		// doc_id
		// doc_url
		// doc_name
		// doc_scribd_id
		// doc_description
		// doc_title
		// doc_status
		// doc_author
		// doc_type
		// doc_path
		// subject_dept
		// subject_type
		// subject_faculty
		// doc_author_name
		// doc_publisher
		// subject_general_faculty_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// doc_id
			$this->doc_id->ViewValue = $this->doc_id->CurrentValue;
			$this->doc_id->ViewCustomAttributes = "";

			// doc_url
			$this->doc_url->ViewValue = $this->doc_url->CurrentValue;
			$this->doc_url->ImageAlt = $this->doc_url->FldAlt();
			$this->doc_url->ViewCustomAttributes = "";

			// doc_name
			$this->doc_name->ViewValue = $this->doc_name->CurrentValue;
			$this->doc_name->ViewCustomAttributes = "";

			// doc_scribd_id
			$this->doc_scribd_id->ViewValue = $this->doc_scribd_id->CurrentValue;
			$this->doc_scribd_id->ViewCustomAttributes = "";

			// doc_description
			$this->doc_description->ViewValue = $this->doc_description->CurrentValue;
			$this->doc_description->ViewCustomAttributes = "";

			// doc_title
			$this->doc_title->ViewValue = $this->doc_title->CurrentValue;
			$this->doc_title->ViewCustomAttributes = "";

			// doc_status
			$this->doc_status->ViewValue = $this->doc_status->CurrentValue;
			$this->doc_status->ViewCustomAttributes = "";

			// doc_author
			$this->doc_author->ViewValue = $this->doc_author->CurrentValue;
			$this->doc_author->ViewCustomAttributes = "";

			// doc_type
			$this->doc_type->ViewValue = $this->doc_type->CurrentValue;
			$this->doc_type->ViewCustomAttributes = "";

			// doc_path
			$this->doc_path->ViewValue = $this->doc_path->CurrentValue;
			$this->doc_path->ViewCustomAttributes = "";

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

			// doc_author_name
			$this->doc_author_name->ViewValue = $this->doc_author_name->CurrentValue;
			$this->doc_author_name->ViewCustomAttributes = "";

			// doc_publisher
			$this->doc_publisher->ViewValue = $this->doc_publisher->CurrentValue;
			$this->doc_publisher->ViewCustomAttributes = "";

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

			// doc_url
			$this->doc_url->LinkCustomAttributes = "";
			$this->doc_url->HrefValue = "";
			$this->doc_url->TooltipValue = "";

			// doc_name
			$this->doc_name->LinkCustomAttributes = "";
			$this->doc_name->HrefValue = "";
			$this->doc_name->TooltipValue = "";

			// doc_scribd_id
			$this->doc_scribd_id->LinkCustomAttributes = "";
			$this->doc_scribd_id->HrefValue = "";
			$this->doc_scribd_id->TooltipValue = "";

			// doc_description
			$this->doc_description->LinkCustomAttributes = "";
			$this->doc_description->HrefValue = "";
			$this->doc_description->TooltipValue = "";

			// doc_title
			$this->doc_title->LinkCustomAttributes = "";
			$this->doc_title->HrefValue = "";
			$this->doc_title->TooltipValue = "";

			// doc_status
			$this->doc_status->LinkCustomAttributes = "";
			$this->doc_status->HrefValue = "";
			$this->doc_status->TooltipValue = "";

			// doc_author
			$this->doc_author->LinkCustomAttributes = "";
			$this->doc_author->HrefValue = "";
			$this->doc_author->TooltipValue = "";

			// doc_type
			$this->doc_type->LinkCustomAttributes = "";
			$this->doc_type->HrefValue = "";
			$this->doc_type->TooltipValue = "";

			// doc_path
			$this->doc_path->LinkCustomAttributes = "";
			$this->doc_path->HrefValue = "";
			$this->doc_path->TooltipValue = "";

			// subject_dept
			$this->subject_dept->LinkCustomAttributes = "";
			$this->subject_dept->HrefValue = "";
			$this->subject_dept->TooltipValue = "";

			// subject_type
			$this->subject_type->LinkCustomAttributes = "";
			$this->subject_type->HrefValue = "";
			$this->subject_type->TooltipValue = "";

			// subject_faculty
			$this->subject_faculty->LinkCustomAttributes = "";
			$this->subject_faculty->HrefValue = "";
			$this->subject_faculty->TooltipValue = "";

			// doc_author_name
			$this->doc_author_name->LinkCustomAttributes = "";
			$this->doc_author_name->HrefValue = "";
			$this->doc_author_name->TooltipValue = "";

			// doc_publisher
			$this->doc_publisher->LinkCustomAttributes = "";
			$this->doc_publisher->HrefValue = "";
			$this->doc_publisher->TooltipValue = "";

			// subject_general_faculty_id
			$this->subject_general_faculty_id->LinkCustomAttributes = "";
			$this->subject_general_faculty_id->HrefValue = "";
			$this->subject_general_faculty_id->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// doc_url
			$this->doc_url->EditCustomAttributes = "";
			$this->doc_url->EditValue = ew_HtmlEncode($this->doc_url->CurrentValue);

			// doc_name
			$this->doc_name->EditCustomAttributes = "";
			$this->doc_name->EditValue = ew_HtmlEncode($this->doc_name->CurrentValue);

			// doc_scribd_id
			$this->doc_scribd_id->EditCustomAttributes = "";
			$this->doc_scribd_id->EditValue = ew_HtmlEncode($this->doc_scribd_id->CurrentValue);

			// doc_description
			$this->doc_description->EditCustomAttributes = "";
			$this->doc_description->EditValue = ew_HtmlEncode($this->doc_description->CurrentValue);

			// doc_title
			$this->doc_title->EditCustomAttributes = "";
			$this->doc_title->EditValue = ew_HtmlEncode($this->doc_title->CurrentValue);

			// doc_status
			$this->doc_status->EditCustomAttributes = "";
			$this->doc_status->EditValue = ew_HtmlEncode($this->doc_status->CurrentValue);

			// doc_author
			$this->doc_author->EditCustomAttributes = "";
			$this->doc_author->EditValue = ew_HtmlEncode($this->doc_author->CurrentValue);

			// doc_type
			$this->doc_type->EditCustomAttributes = "";
			$this->doc_type->EditValue = ew_HtmlEncode($this->doc_type->CurrentValue);

			// doc_path
			$this->doc_path->EditCustomAttributes = "";
			$this->doc_path->EditValue = ew_HtmlEncode($this->doc_path->CurrentValue);

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

			// doc_author_name
			$this->doc_author_name->EditCustomAttributes = "";
			$this->doc_author_name->EditValue = ew_HtmlEncode($this->doc_author_name->CurrentValue);

			// doc_publisher
			$this->doc_publisher->EditCustomAttributes = "";
			$this->doc_publisher->EditValue = ew_HtmlEncode($this->doc_publisher->CurrentValue);

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
			// doc_url

			$this->doc_url->HrefValue = "";

			// doc_name
			$this->doc_name->HrefValue = "";

			// doc_scribd_id
			$this->doc_scribd_id->HrefValue = "";

			// doc_description
			$this->doc_description->HrefValue = "";

			// doc_title
			$this->doc_title->HrefValue = "";

			// doc_status
			$this->doc_status->HrefValue = "";

			// doc_author
			$this->doc_author->HrefValue = "";

			// doc_type
			$this->doc_type->HrefValue = "";

			// doc_path
			$this->doc_path->HrefValue = "";

			// subject_dept
			$this->subject_dept->HrefValue = "";

			// subject_type
			$this->subject_type->HrefValue = "";

			// subject_faculty
			$this->subject_faculty->HrefValue = "";

			// doc_author_name
			$this->doc_author_name->HrefValue = "";

			// doc_publisher
			$this->doc_publisher->HrefValue = "";

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
		if (!ew_CheckInteger($this->doc_type->FormValue)) {
			ew_AddMessage($gsFormError, $this->doc_type->FldErrMsg());
		}
		if (!is_null($this->subject_general_faculty_id->FormValue) && $this->subject_general_faculty_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->subject_general_faculty_id->FldCaption());
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

		// doc_url
		$this->doc_url->SetDbValueDef($rsnew, $this->doc_url->CurrentValue, NULL, FALSE);

		// doc_name
		$this->doc_name->SetDbValueDef($rsnew, $this->doc_name->CurrentValue, NULL, FALSE);

		// doc_scribd_id
		$this->doc_scribd_id->SetDbValueDef($rsnew, $this->doc_scribd_id->CurrentValue, NULL, FALSE);

		// doc_description
		$this->doc_description->SetDbValueDef($rsnew, $this->doc_description->CurrentValue, NULL, FALSE);

		// doc_title
		$this->doc_title->SetDbValueDef($rsnew, $this->doc_title->CurrentValue, NULL, FALSE);

		// doc_status
		$this->doc_status->SetDbValueDef($rsnew, $this->doc_status->CurrentValue, NULL, FALSE);

		// doc_author
		$this->doc_author->SetDbValueDef($rsnew, $this->doc_author->CurrentValue, NULL, FALSE);

		// doc_type
		$this->doc_type->SetDbValueDef($rsnew, $this->doc_type->CurrentValue, NULL, FALSE);

		// doc_path
		$this->doc_path->SetDbValueDef($rsnew, $this->doc_path->CurrentValue, NULL, FALSE);

		// subject_dept
		$this->subject_dept->SetDbValueDef($rsnew, $this->subject_dept->CurrentValue, NULL, FALSE);

		// subject_type
		$this->subject_type->SetDbValueDef($rsnew, $this->subject_type->CurrentValue, NULL, FALSE);

		// subject_faculty
		$this->subject_faculty->SetDbValueDef($rsnew, $this->subject_faculty->CurrentValue, NULL, FALSE);

		// doc_author_name
		$this->doc_author_name->SetDbValueDef($rsnew, $this->doc_author_name->CurrentValue, NULL, FALSE);

		// doc_publisher
		$this->doc_publisher->SetDbValueDef($rsnew, $this->doc_publisher->CurrentValue, NULL, FALSE);

		// subject_general_faculty_id
		$this->subject_general_faculty_id->SetDbValueDef($rsnew, $this->subject_general_faculty_id->CurrentValue, 0, FALSE);

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
			$this->doc_id->setDbValue($conn->Insert_ID());
			$rsnew['doc_id'] = $this->doc_id->DbValue;
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
if (!isset($tbl_doc_add)) $tbl_doc_add = new ctbl_doc_add();

// Page init
$tbl_doc_add->Page_Init();

// Page main
$tbl_doc_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_doc_add = new ew_Page("tbl_doc_add");
tbl_doc_add.PageID = "add"; // Page ID
var EW_PAGE_ID = tbl_doc_add.PageID; // For backward compatibility

// Form object
var ftbl_docadd = new ew_Form("ftbl_docadd");

// Validate form
ftbl_docadd.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_doc_type"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_doc->doc_type->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_subject_general_faculty_id"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_doc->subject_general_faculty_id->FldCaption()) ?>");

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
ftbl_docadd.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_docadd.ValidateRequired = true;
<?php } else { ?>
ftbl_docadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_docadd.Lists["x_subject_dept"] = {"LinkField":"x_dept_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_dept_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_docadd.Lists["x_subject_type"] = {"LinkField":"x_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_subject_type_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_docadd.Lists["x_subject_faculty"] = {"LinkField":"x_faculty_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_faculty_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_docadd.Lists["x_subject_general_faculty_id"] = {"LinkField":"x_faculty_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_faculty_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_doc->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $tbl_doc->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $tbl_doc_add->ShowPageHeader(); ?>
<?php
$tbl_doc_add->ShowMessage();
?>
<form name="ftbl_docadd" id="ftbl_docadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="tbl_doc">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_docadd" class="ewTable">
<?php if ($tbl_doc->doc_url->Visible) { // doc_url ?>
	<tr id="r_doc_url"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_url"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_url->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_url->CellAttributes() ?>><span id="el_tbl_doc_doc_url">
<input type="text" name="x_doc_url" id="x_doc_url" size="30" maxlength="200" value="<?php echo $tbl_doc->doc_url->EditValue ?>"<?php echo $tbl_doc->doc_url->EditAttributes() ?>>
</span><?php echo $tbl_doc->doc_url->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_name->Visible) { // doc_name ?>
	<tr id="r_doc_name"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_name"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_name->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_name->CellAttributes() ?>><span id="el_tbl_doc_doc_name">
<input type="text" name="x_doc_name" id="x_doc_name" size="30" maxlength="200" value="<?php echo $tbl_doc->doc_name->EditValue ?>"<?php echo $tbl_doc->doc_name->EditAttributes() ?>>
</span><?php echo $tbl_doc->doc_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_scribd_id->Visible) { // doc_scribd_id ?>
	<tr id="r_doc_scribd_id"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_scribd_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_scribd_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_scribd_id->CellAttributes() ?>><span id="el_tbl_doc_doc_scribd_id">
<input type="text" name="x_doc_scribd_id" id="x_doc_scribd_id" size="30" maxlength="200" value="<?php echo $tbl_doc->doc_scribd_id->EditValue ?>"<?php echo $tbl_doc->doc_scribd_id->EditAttributes() ?>>
</span><?php echo $tbl_doc->doc_scribd_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_description->Visible) { // doc_description ?>
	<tr id="r_doc_description"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_description"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_description->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_description->CellAttributes() ?>><span id="el_tbl_doc_doc_description">
<input type="text" name="x_doc_description" id="x_doc_description" size="30" maxlength="200" value="<?php echo $tbl_doc->doc_description->EditValue ?>"<?php echo $tbl_doc->doc_description->EditAttributes() ?>>
</span><?php echo $tbl_doc->doc_description->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_title->Visible) { // doc_title ?>
	<tr id="r_doc_title"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_title"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_title->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_title->CellAttributes() ?>><span id="el_tbl_doc_doc_title">
<input type="text" name="x_doc_title" id="x_doc_title" size="30" maxlength="200" value="<?php echo $tbl_doc->doc_title->EditValue ?>"<?php echo $tbl_doc->doc_title->EditAttributes() ?>>
</span><?php echo $tbl_doc->doc_title->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_status->Visible) { // doc_status ?>
	<tr id="r_doc_status"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_status"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_status->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_status->CellAttributes() ?>><span id="el_tbl_doc_doc_status">
<input type="text" name="x_doc_status" id="x_doc_status" size="30" maxlength="200" value="<?php echo $tbl_doc->doc_status->EditValue ?>"<?php echo $tbl_doc->doc_status->EditAttributes() ?>>
</span><?php echo $tbl_doc->doc_status->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_author->Visible) { // doc_author ?>
	<tr id="r_doc_author"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_author"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_author->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_author->CellAttributes() ?>><span id="el_tbl_doc_doc_author">
<input type="text" name="x_doc_author" id="x_doc_author" size="30" maxlength="30" value="<?php echo $tbl_doc->doc_author->EditValue ?>"<?php echo $tbl_doc->doc_author->EditAttributes() ?>>
</span><?php echo $tbl_doc->doc_author->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_type->Visible) { // doc_type ?>
	<tr id="r_doc_type"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_type"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_type->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_type->CellAttributes() ?>><span id="el_tbl_doc_doc_type">
<input type="text" name="x_doc_type" id="x_doc_type" size="30" value="<?php echo $tbl_doc->doc_type->EditValue ?>"<?php echo $tbl_doc->doc_type->EditAttributes() ?>>
</span><?php echo $tbl_doc->doc_type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_path->Visible) { // doc_path ?>
	<tr id="r_doc_path"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_path"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_path->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_path->CellAttributes() ?>><span id="el_tbl_doc_doc_path">
<textarea name="x_doc_path" id="x_doc_path" cols="35" rows="4"<?php echo $tbl_doc->doc_path->EditAttributes() ?>><?php echo $tbl_doc->doc_path->EditValue ?></textarea>
</span><?php echo $tbl_doc->doc_path->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->subject_dept->Visible) { // subject_dept ?>
	<tr id="r_subject_dept"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_subject_dept"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->subject_dept->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->subject_dept->CellAttributes() ?>><span id="el_tbl_doc_subject_dept">
<select id="x_subject_dept" name="x_subject_dept"<?php echo $tbl_doc->subject_dept->EditAttributes() ?>>
<?php
if (is_array($tbl_doc->subject_dept->EditValue)) {
	$arwrk = $tbl_doc->subject_dept->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_doc->subject_dept->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_docadd.Lists["x_subject_dept"].Options = <?php echo (is_array($tbl_doc->subject_dept->EditValue)) ? ew_ArrayToJson($tbl_doc->subject_dept->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_doc->subject_dept->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->subject_type->Visible) { // subject_type ?>
	<tr id="r_subject_type"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_subject_type"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->subject_type->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->subject_type->CellAttributes() ?>><span id="el_tbl_doc_subject_type">
<select id="x_subject_type" name="x_subject_type"<?php echo $tbl_doc->subject_type->EditAttributes() ?>>
<?php
if (is_array($tbl_doc->subject_type->EditValue)) {
	$arwrk = $tbl_doc->subject_type->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_doc->subject_type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_docadd.Lists["x_subject_type"].Options = <?php echo (is_array($tbl_doc->subject_type->EditValue)) ? ew_ArrayToJson($tbl_doc->subject_type->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_doc->subject_type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->subject_faculty->Visible) { // subject_faculty ?>
	<tr id="r_subject_faculty"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_subject_faculty"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->subject_faculty->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->subject_faculty->CellAttributes() ?>><span id="el_tbl_doc_subject_faculty">
<select id="x_subject_faculty" name="x_subject_faculty"<?php echo $tbl_doc->subject_faculty->EditAttributes() ?>>
<?php
if (is_array($tbl_doc->subject_faculty->EditValue)) {
	$arwrk = $tbl_doc->subject_faculty->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_doc->subject_faculty->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_docadd.Lists["x_subject_faculty"].Options = <?php echo (is_array($tbl_doc->subject_faculty->EditValue)) ? ew_ArrayToJson($tbl_doc->subject_faculty->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_doc->subject_faculty->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_author_name->Visible) { // doc_author_name ?>
	<tr id="r_doc_author_name"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_author_name"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_author_name->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_author_name->CellAttributes() ?>><span id="el_tbl_doc_doc_author_name">
<textarea name="x_doc_author_name" id="x_doc_author_name" cols="35" rows="4"<?php echo $tbl_doc->doc_author_name->EditAttributes() ?>><?php echo $tbl_doc->doc_author_name->EditValue ?></textarea>
</span><?php echo $tbl_doc->doc_author_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_publisher->Visible) { // doc_publisher ?>
	<tr id="r_doc_publisher"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_publisher"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_publisher->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_publisher->CellAttributes() ?>><span id="el_tbl_doc_doc_publisher">
<input type="text" name="x_doc_publisher" id="x_doc_publisher" size="30" maxlength="255" value="<?php echo $tbl_doc->doc_publisher->EditValue ?>"<?php echo $tbl_doc->doc_publisher->EditAttributes() ?>>
</span><?php echo $tbl_doc->doc_publisher->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->subject_general_faculty_id->Visible) { // subject_general_faculty_id ?>
	<tr id="r_subject_general_faculty_id"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_subject_general_faculty_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->subject_general_faculty_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->subject_general_faculty_id->CellAttributes() ?>><span id="el_tbl_doc_subject_general_faculty_id">
<select id="x_subject_general_faculty_id" name="x_subject_general_faculty_id"<?php echo $tbl_doc->subject_general_faculty_id->EditAttributes() ?>>
<?php
if (is_array($tbl_doc->subject_general_faculty_id->EditValue)) {
	$arwrk = $tbl_doc->subject_general_faculty_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_doc->subject_general_faculty_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_docadd.Lists["x_subject_general_faculty_id"].Options = <?php echo (is_array($tbl_doc->subject_general_faculty_id->EditValue)) ? ew_ArrayToJson($tbl_doc->subject_general_faculty_id->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_doc->subject_general_faculty_id->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
ftbl_docadd.Init();
</script>
<?php
$tbl_doc_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_doc_add->Page_Terminate();
?>
