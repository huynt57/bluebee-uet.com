<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "tbl_teacherinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$tbl_teacher_edit = NULL; // Initialize page object first

class ctbl_teacher_edit extends ctbl_teacher {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_teacher';

	// Page object name
	var $PageObjName = 'tbl_teacher_edit';

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

		// Table object (tbl_teacher)
		if (!isset($GLOBALS["tbl_teacher"])) {
			$GLOBALS["tbl_teacher"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_teacher"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_teacher', TRUE);

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
		$this->teacher_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		if (@$_GET["teacher_id"] <> "")
			$this->teacher_id->setQueryStringValue($_GET["teacher_id"]);

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->teacher_id->CurrentValue == "")
			$this->Page_Terminate("tbl_teacherlist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("tbl_teacherlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tbl_teacherview.php")
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
		$this->teacher_avatar->Upload->Index = $objForm->Index;
		$this->teacher_avatar->Upload->RestoreDbFromSession();
		if ($confirmPage) { // Post from confirm page
			$this->teacher_avatar->Upload->RestoreFromSession();
		} else {
			if ($this->teacher_avatar->Upload->UploadFile()) {

				// No action required
			} else {
				echo $this->teacher_avatar->Upload->Message;
				$this->Page_Terminate();
				exit();
			}
			$this->teacher_avatar->Upload->SaveToSession();
			$this->teacher_avatar->CurrentValue = $this->teacher_avatar->Upload->FileName;
		}
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->teacher_id->FldIsDetailKey)
			$this->teacher_id->setFormValue($objForm->GetValue("x_teacher_id"));
		if (!$this->teacher_name->FldIsDetailKey) {
			$this->teacher_name->setFormValue($objForm->GetValue("x_teacher_name"));
		}
		if (!$this->teacher_personal_page->FldIsDetailKey) {
			$this->teacher_personal_page->setFormValue($objForm->GetValue("x_teacher_personal_page"));
		}
		if (!$this->teacher_description->FldIsDetailKey) {
			$this->teacher_description->setFormValue($objForm->GetValue("x_teacher_description"));
		}
		if (!$this->teacher_work_place->FldIsDetailKey) {
			$this->teacher_work_place->setFormValue($objForm->GetValue("x_teacher_work_place"));
		}
		if (!$this->teacher_active->FldIsDetailKey) {
			$this->teacher_active->setFormValue($objForm->GetValue("x_teacher_active"));
		}
		if (!$this->teacher_acadamic_title->FldIsDetailKey) {
			$this->teacher_acadamic_title->setFormValue($objForm->GetValue("x_teacher_acadamic_title"));
		}
		if (!$this->teacher_birthday->FldIsDetailKey) {
			$this->teacher_birthday->setFormValue($objForm->GetValue("x_teacher_birthday"));
		}
		if (!$this->teacher_sex->FldIsDetailKey) {
			$this->teacher_sex->setFormValue($objForm->GetValue("x_teacher_sex"));
		}
		if (!$this->teacher_faculty->FldIsDetailKey) {
			$this->teacher_faculty->setFormValue($objForm->GetValue("x_teacher_faculty"));
		}
		if (!$this->teacher_dept->FldIsDetailKey) {
			$this->teacher_dept->setFormValue($objForm->GetValue("x_teacher_dept"));
		}
		if (!$this->teacher_rate->FldIsDetailKey) {
			$this->teacher_rate->setFormValue($objForm->GetValue("x_teacher_rate"));
		}
		if (!$this->teacher_personality->FldIsDetailKey) {
			$this->teacher_personality->setFormValue($objForm->GetValue("x_teacher_personality"));
		}
		if (!$this->advices->FldIsDetailKey) {
			$this->advices->setFormValue($objForm->GetValue("x_advices"));
		}
		if (!$this->teacher_research->FldIsDetailKey) {
			$this->teacher_research->setFormValue($objForm->GetValue("x_teacher_research"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->teacher_id->CurrentValue = $this->teacher_id->FormValue;
		$this->teacher_name->CurrentValue = $this->teacher_name->FormValue;
		$this->teacher_personal_page->CurrentValue = $this->teacher_personal_page->FormValue;
		$this->teacher_description->CurrentValue = $this->teacher_description->FormValue;
		$this->teacher_work_place->CurrentValue = $this->teacher_work_place->FormValue;
		$this->teacher_active->CurrentValue = $this->teacher_active->FormValue;
		$this->teacher_acadamic_title->CurrentValue = $this->teacher_acadamic_title->FormValue;
		$this->teacher_birthday->CurrentValue = $this->teacher_birthday->FormValue;
		$this->teacher_sex->CurrentValue = $this->teacher_sex->FormValue;
		$this->teacher_faculty->CurrentValue = $this->teacher_faculty->FormValue;
		$this->teacher_dept->CurrentValue = $this->teacher_dept->FormValue;
		$this->teacher_rate->CurrentValue = $this->teacher_rate->FormValue;
		$this->teacher_personality->CurrentValue = $this->teacher_personality->FormValue;
		$this->advices->CurrentValue = $this->advices->FormValue;
		$this->teacher_research->CurrentValue = $this->teacher_research->FormValue;
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
		$this->teacher_id->setDbValue($rs->fields('teacher_id'));
		$this->teacher_name->setDbValue($rs->fields('teacher_name'));
		$this->teacher_personal_page->setDbValue($rs->fields('teacher_personal_page'));
		$this->teacher_avatar->Upload->DbValue = $rs->fields('teacher_avatar');
		$this->teacher_description->setDbValue($rs->fields('teacher_description'));
		$this->teacher_work_place->setDbValue($rs->fields('teacher_work_place'));
		$this->teacher_active->setDbValue($rs->fields('teacher_active'));
		$this->teacher_acadamic_title->setDbValue($rs->fields('teacher_acadamic_title'));
		$this->teacher_birthday->setDbValue($rs->fields('teacher_birthday'));
		$this->teacher_sex->setDbValue($rs->fields('teacher_sex'));
		$this->teacher_faculty->setDbValue($rs->fields('teacher_faculty'));
		$this->teacher_dept->setDbValue($rs->fields('teacher_dept'));
		$this->teacher_rate->setDbValue($rs->fields('teacher_rate'));
		$this->teacher_personality->setDbValue($rs->fields('teacher_personality'));
		$this->advices->setDbValue($rs->fields('advices'));
		$this->teacher_research->setDbValue($rs->fields('teacher_research'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->teacher_rate->FormValue == $this->teacher_rate->CurrentValue && is_numeric(ew_StrToFloat($this->teacher_rate->CurrentValue)))
			$this->teacher_rate->CurrentValue = ew_StrToFloat($this->teacher_rate->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// teacher_id
		// teacher_name
		// teacher_personal_page
		// teacher_avatar
		// teacher_description
		// teacher_work_place
		// teacher_active
		// teacher_acadamic_title
		// teacher_birthday
		// teacher_sex
		// teacher_faculty
		// teacher_dept
		// teacher_rate
		// teacher_personality
		// advices
		// teacher_research

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// teacher_id
			$this->teacher_id->ViewValue = $this->teacher_id->CurrentValue;
			$this->teacher_id->ViewCustomAttributes = "";

			// teacher_name
			$this->teacher_name->ViewValue = $this->teacher_name->CurrentValue;
			$this->teacher_name->ViewCustomAttributes = "";

			// teacher_personal_page
			$this->teacher_personal_page->ViewValue = $this->teacher_personal_page->CurrentValue;
			$this->teacher_personal_page->ViewCustomAttributes = "";

			// teacher_avatar
			$this->teacher_avatar->UploadPath = 'themes\classic\assets\img\Teacher_img';
			if (!ew_Empty($this->teacher_avatar->Upload->DbValue)) {
				$this->teacher_avatar->ImageAlt = $this->teacher_avatar->FldAlt();
				$this->teacher_avatar->ViewValue = ew_UploadPathEx(FALSE, $this->teacher_avatar->UploadPath) . $this->teacher_avatar->Upload->DbValue;
			} else {
				$this->teacher_avatar->ViewValue = "";
			}
			$this->teacher_avatar->ViewCustomAttributes = "";

			// teacher_description
			$this->teacher_description->ViewValue = $this->teacher_description->CurrentValue;
			$this->teacher_description->ViewCustomAttributes = "";

			// teacher_work_place
			$this->teacher_work_place->ViewValue = $this->teacher_work_place->CurrentValue;
			$this->teacher_work_place->ViewCustomAttributes = "";

			// teacher_active
			$this->teacher_active->ViewValue = $this->teacher_active->CurrentValue;
			$this->teacher_active->ViewCustomAttributes = "";

			// teacher_acadamic_title
			$this->teacher_acadamic_title->ViewValue = $this->teacher_acadamic_title->CurrentValue;
			$this->teacher_acadamic_title->ViewCustomAttributes = "";

			// teacher_birthday
			$this->teacher_birthday->ViewValue = $this->teacher_birthday->CurrentValue;
			$this->teacher_birthday->ViewCustomAttributes = "";

			// teacher_sex
			$this->teacher_sex->ViewValue = $this->teacher_sex->CurrentValue;
			$this->teacher_sex->ViewCustomAttributes = "";

			// teacher_faculty
			if (strval($this->teacher_faculty->CurrentValue) <> "") {
				$sFilterWrk = "`faculty_id`" . ew_SearchString("=", $this->teacher_faculty->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `faculty_id`, `faculty_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_faculty`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->teacher_faculty->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->teacher_faculty->ViewValue = $this->teacher_faculty->CurrentValue;
				}
			} else {
				$this->teacher_faculty->ViewValue = NULL;
			}
			$this->teacher_faculty->ViewCustomAttributes = "";

			// teacher_dept
			if (strval($this->teacher_dept->CurrentValue) <> "") {
				$sFilterWrk = "`dept_id`" . ew_SearchString("=", $this->teacher_dept->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `dept_id`, `dept_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_dept`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->teacher_dept->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->teacher_dept->ViewValue = $this->teacher_dept->CurrentValue;
				}
			} else {
				$this->teacher_dept->ViewValue = NULL;
			}
			$this->teacher_dept->ViewCustomAttributes = "";

			// teacher_rate
			$this->teacher_rate->ViewValue = $this->teacher_rate->CurrentValue;
			$this->teacher_rate->ViewCustomAttributes = "";

			// teacher_personality
			$this->teacher_personality->ViewValue = $this->teacher_personality->CurrentValue;
			$this->teacher_personality->ViewCustomAttributes = "";

			// advices
			$this->advices->ViewValue = $this->advices->CurrentValue;
			$this->advices->ViewCustomAttributes = "";

			// teacher_research
			$this->teacher_research->ViewValue = $this->teacher_research->CurrentValue;
			$this->teacher_research->ViewCustomAttributes = "";

			// teacher_id
			$this->teacher_id->LinkCustomAttributes = "";
			$this->teacher_id->HrefValue = "";
			$this->teacher_id->TooltipValue = "";

			// teacher_name
			$this->teacher_name->LinkCustomAttributes = "";
			$this->teacher_name->HrefValue = "";
			$this->teacher_name->TooltipValue = "";

			// teacher_personal_page
			$this->teacher_personal_page->LinkCustomAttributes = "";
			$this->teacher_personal_page->HrefValue = "";
			$this->teacher_personal_page->TooltipValue = "";

			// teacher_avatar
			$this->teacher_avatar->LinkCustomAttributes = "";
			$this->teacher_avatar->HrefValue = "";
			$this->teacher_avatar->TooltipValue = "";

			// teacher_description
			$this->teacher_description->LinkCustomAttributes = "";
			$this->teacher_description->HrefValue = "";
			$this->teacher_description->TooltipValue = "";

			// teacher_work_place
			$this->teacher_work_place->LinkCustomAttributes = "";
			$this->teacher_work_place->HrefValue = "";
			$this->teacher_work_place->TooltipValue = "";

			// teacher_active
			$this->teacher_active->LinkCustomAttributes = "";
			$this->teacher_active->HrefValue = "";
			$this->teacher_active->TooltipValue = "";

			// teacher_acadamic_title
			$this->teacher_acadamic_title->LinkCustomAttributes = "";
			$this->teacher_acadamic_title->HrefValue = "";
			$this->teacher_acadamic_title->TooltipValue = "";

			// teacher_birthday
			$this->teacher_birthday->LinkCustomAttributes = "";
			$this->teacher_birthday->HrefValue = "";
			$this->teacher_birthday->TooltipValue = "";

			// teacher_sex
			$this->teacher_sex->LinkCustomAttributes = "";
			$this->teacher_sex->HrefValue = "";
			$this->teacher_sex->TooltipValue = "";

			// teacher_faculty
			$this->teacher_faculty->LinkCustomAttributes = "";
			$this->teacher_faculty->HrefValue = "";
			$this->teacher_faculty->TooltipValue = "";

			// teacher_dept
			$this->teacher_dept->LinkCustomAttributes = "";
			$this->teacher_dept->HrefValue = "";
			$this->teacher_dept->TooltipValue = "";

			// teacher_rate
			$this->teacher_rate->LinkCustomAttributes = "";
			$this->teacher_rate->HrefValue = "";
			$this->teacher_rate->TooltipValue = "";

			// teacher_personality
			$this->teacher_personality->LinkCustomAttributes = "";
			$this->teacher_personality->HrefValue = "";
			$this->teacher_personality->TooltipValue = "";

			// advices
			$this->advices->LinkCustomAttributes = "";
			$this->advices->HrefValue = "";
			$this->advices->TooltipValue = "";

			// teacher_research
			$this->teacher_research->LinkCustomAttributes = "";
			$this->teacher_research->HrefValue = "";
			$this->teacher_research->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// teacher_id
			$this->teacher_id->EditCustomAttributes = "";
			$this->teacher_id->EditValue = $this->teacher_id->CurrentValue;
			$this->teacher_id->ViewCustomAttributes = "";

			// teacher_name
			$this->teacher_name->EditCustomAttributes = "";
			$this->teacher_name->EditValue = ew_HtmlEncode($this->teacher_name->CurrentValue);

			// teacher_personal_page
			$this->teacher_personal_page->EditCustomAttributes = "";
			$this->teacher_personal_page->EditValue = ew_HtmlEncode($this->teacher_personal_page->CurrentValue);

			// teacher_avatar
			$this->teacher_avatar->EditCustomAttributes = "";
			$this->teacher_avatar->UploadPath = 'themes\classic\assets\img\Teacher_img';
			if (!ew_Empty($this->teacher_avatar->Upload->DbValue)) {
				$this->teacher_avatar->ImageAlt = $this->teacher_avatar->FldAlt();
				$this->teacher_avatar->EditValue = ew_UploadPathEx(FALSE, $this->teacher_avatar->UploadPath) . $this->teacher_avatar->Upload->DbValue;
			} else {
				$this->teacher_avatar->EditValue = "";
			}

			// teacher_description
			$this->teacher_description->EditCustomAttributes = "";
			$this->teacher_description->EditValue = ew_HtmlEncode($this->teacher_description->CurrentValue);

			// teacher_work_place
			$this->teacher_work_place->EditCustomAttributes = "";
			$this->teacher_work_place->EditValue = ew_HtmlEncode($this->teacher_work_place->CurrentValue);

			// teacher_active
			$this->teacher_active->EditCustomAttributes = "";
			$this->teacher_active->EditValue = ew_HtmlEncode($this->teacher_active->CurrentValue);

			// teacher_acadamic_title
			$this->teacher_acadamic_title->EditCustomAttributes = "";
			$this->teacher_acadamic_title->EditValue = ew_HtmlEncode($this->teacher_acadamic_title->CurrentValue);

			// teacher_birthday
			$this->teacher_birthday->EditCustomAttributes = "";
			$this->teacher_birthday->EditValue = ew_HtmlEncode($this->teacher_birthday->CurrentValue);

			// teacher_sex
			$this->teacher_sex->EditCustomAttributes = "";
			$this->teacher_sex->EditValue = ew_HtmlEncode($this->teacher_sex->CurrentValue);

			// teacher_faculty
			$this->teacher_faculty->EditCustomAttributes = "";
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
			$this->teacher_faculty->EditValue = $arwrk;

			// teacher_dept
			$this->teacher_dept->EditCustomAttributes = "";
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
			$this->teacher_dept->EditValue = $arwrk;

			// teacher_rate
			$this->teacher_rate->EditCustomAttributes = "";
			$this->teacher_rate->EditValue = ew_HtmlEncode($this->teacher_rate->CurrentValue);
			if (strval($this->teacher_rate->EditValue) <> "" && is_numeric($this->teacher_rate->EditValue)) $this->teacher_rate->EditValue = ew_FormatNumber($this->teacher_rate->EditValue, -2, -1, -2, 0);

			// teacher_personality
			$this->teacher_personality->EditCustomAttributes = "";
			$this->teacher_personality->EditValue = ew_HtmlEncode($this->teacher_personality->CurrentValue);

			// advices
			$this->advices->EditCustomAttributes = "";
			$this->advices->EditValue = ew_HtmlEncode($this->advices->CurrentValue);

			// teacher_research
			$this->teacher_research->EditCustomAttributes = "";
			$this->teacher_research->EditValue = ew_HtmlEncode($this->teacher_research->CurrentValue);

			// Edit refer script
			// teacher_id

			$this->teacher_id->HrefValue = "";

			// teacher_name
			$this->teacher_name->HrefValue = "";

			// teacher_personal_page
			$this->teacher_personal_page->HrefValue = "";

			// teacher_avatar
			$this->teacher_avatar->HrefValue = "";

			// teacher_description
			$this->teacher_description->HrefValue = "";

			// teacher_work_place
			$this->teacher_work_place->HrefValue = "";

			// teacher_active
			$this->teacher_active->HrefValue = "";

			// teacher_acadamic_title
			$this->teacher_acadamic_title->HrefValue = "";

			// teacher_birthday
			$this->teacher_birthday->HrefValue = "";

			// teacher_sex
			$this->teacher_sex->HrefValue = "";

			// teacher_faculty
			$this->teacher_faculty->HrefValue = "";

			// teacher_dept
			$this->teacher_dept->HrefValue = "";

			// teacher_rate
			$this->teacher_rate->HrefValue = "";

			// teacher_personality
			$this->teacher_personality->HrefValue = "";

			// advices
			$this->advices->HrefValue = "";

			// teacher_research
			$this->teacher_research->HrefValue = "";
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
		if (!ew_CheckFileType($this->teacher_avatar->Upload->FileName)) {
			ew_AddMessage($gsFormError, $Language->Phrase("WrongFileType"));
		}
		if ($this->teacher_avatar->Upload->FileSize > 0 && EW_MAX_FILE_SIZE > 0 && $this->teacher_avatar->Upload->FileSize > EW_MAX_FILE_SIZE) {
			ew_AddMessage($gsFormError, str_replace("%s", EW_MAX_FILE_SIZE, $Language->Phrase("MaxFileSize")));
		}
		if (in_array($this->teacher_avatar->Upload->Error, array(1, 2, 3, 6, 7, 8))) {
			ew_AddMessage($gsFormError, $Language->Phrase("PhpUploadErr" . $this->teacher_avatar->Upload->Error));
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckInteger($this->teacher_active->FormValue)) {
			ew_AddMessage($gsFormError, $this->teacher_active->FldErrMsg());
		}
		if (!ew_CheckInteger($this->teacher_sex->FormValue)) {
			ew_AddMessage($gsFormError, $this->teacher_sex->FldErrMsg());
		}
		if (!ew_CheckNumber($this->teacher_rate->FormValue)) {
			ew_AddMessage($gsFormError, $this->teacher_rate->FldErrMsg());
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

			// teacher_name
			$this->teacher_name->SetDbValueDef($rsnew, $this->teacher_name->CurrentValue, NULL, $this->teacher_name->ReadOnly);

			// teacher_personal_page
			$this->teacher_personal_page->SetDbValueDef($rsnew, $this->teacher_personal_page->CurrentValue, NULL, $this->teacher_personal_page->ReadOnly);

			// teacher_avatar
			if (!($this->teacher_avatar->ReadOnly)) {
			$this->teacher_avatar->UploadPath = 'themes\classic\assets\img\Teacher_img';
			if ($this->teacher_avatar->Upload->Action == "1") { // Keep
			} elseif ($this->teacher_avatar->Upload->Action == "2" || $this->teacher_avatar->Upload->Action == "3") { // Update/Remove
			$this->teacher_avatar->Upload->DbValue = $rs->fields('teacher_avatar'); // Get original value
			if (is_null($this->teacher_avatar->Upload->Value)) {
				$rsnew['teacher_avatar'] = NULL;
			} else {
				$rsnew['teacher_avatar'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->teacher_avatar->UploadPath), $this->teacher_avatar->Upload->FileName);
			}
			}
			}

			// teacher_description
			$this->teacher_description->SetDbValueDef($rsnew, $this->teacher_description->CurrentValue, NULL, $this->teacher_description->ReadOnly);

			// teacher_work_place
			$this->teacher_work_place->SetDbValueDef($rsnew, $this->teacher_work_place->CurrentValue, NULL, $this->teacher_work_place->ReadOnly);

			// teacher_active
			$this->teacher_active->SetDbValueDef($rsnew, $this->teacher_active->CurrentValue, NULL, $this->teacher_active->ReadOnly);

			// teacher_acadamic_title
			$this->teacher_acadamic_title->SetDbValueDef($rsnew, $this->teacher_acadamic_title->CurrentValue, NULL, $this->teacher_acadamic_title->ReadOnly);

			// teacher_birthday
			$this->teacher_birthday->SetDbValueDef($rsnew, $this->teacher_birthday->CurrentValue, NULL, $this->teacher_birthday->ReadOnly);

			// teacher_sex
			$this->teacher_sex->SetDbValueDef($rsnew, $this->teacher_sex->CurrentValue, NULL, $this->teacher_sex->ReadOnly);

			// teacher_faculty
			$this->teacher_faculty->SetDbValueDef($rsnew, $this->teacher_faculty->CurrentValue, NULL, $this->teacher_faculty->ReadOnly);

			// teacher_dept
			$this->teacher_dept->SetDbValueDef($rsnew, $this->teacher_dept->CurrentValue, NULL, $this->teacher_dept->ReadOnly);

			// teacher_rate
			$this->teacher_rate->SetDbValueDef($rsnew, $this->teacher_rate->CurrentValue, NULL, $this->teacher_rate->ReadOnly);

			// teacher_personality
			$this->teacher_personality->SetDbValueDef($rsnew, $this->teacher_personality->CurrentValue, NULL, $this->teacher_personality->ReadOnly);

			// advices
			$this->advices->SetDbValueDef($rsnew, $this->advices->CurrentValue, NULL, $this->advices->ReadOnly);

			// teacher_research
			$this->teacher_research->SetDbValueDef($rsnew, $this->teacher_research->CurrentValue, NULL, $this->teacher_research->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				if (!ew_Empty($this->teacher_avatar->Upload->Value)) {
					$this->teacher_avatar->Upload->SaveToFile($this->teacher_avatar->UploadPath, $rsnew['teacher_avatar'], FALSE);
				}
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

		// teacher_avatar
		$this->teacher_avatar->Upload->RemoveFromSession(); // Remove file value from Session
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
if (!isset($tbl_teacher_edit)) $tbl_teacher_edit = new ctbl_teacher_edit();

// Page init
$tbl_teacher_edit->Page_Init();

// Page main
$tbl_teacher_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_teacher_edit = new ew_Page("tbl_teacher_edit");
tbl_teacher_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = tbl_teacher_edit.PageID; // For backward compatibility

// Form object
var ftbl_teacheredit = new ew_Form("ftbl_teacheredit");

// Validate form
ftbl_teacheredit.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_teacher_avatar"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, ewLanguage.Phrase("WrongFileType"));
		elm = fobj.elements["x" + infix + "_teacher_active"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_teacher->teacher_active->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_teacher_sex"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_teacher->teacher_sex->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_teacher_rate"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($tbl_teacher->teacher_rate->FldErrMsg()) ?>");

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
ftbl_teacheredit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_teacheredit.ValidateRequired = true;
<?php } else { ?>
ftbl_teacheredit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_teacheredit.Lists["x_teacher_faculty"] = {"LinkField":"x_faculty_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_faculty_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_teacheredit.Lists["x_teacher_dept"] = {"LinkField":"x_dept_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_dept_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_teacher->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $tbl_teacher->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $tbl_teacher_edit->ShowPageHeader(); ?>
<?php
$tbl_teacher_edit->ShowMessage();
?>
<form name="ftbl_teacheredit" id="ftbl_teacheredit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" enctype="multipart/form-data" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="tbl_teacher">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_teacheredit" class="ewTable">
<?php if ($tbl_teacher->teacher_id->Visible) { // teacher_id ?>
	<tr id="r_teacher_id"<?php echo $tbl_teacher->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_teacher_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher->teacher_id->CellAttributes() ?>><span id="el_tbl_teacher_teacher_id">
<span<?php echo $tbl_teacher->teacher_id->ViewAttributes() ?>>
<?php echo $tbl_teacher->teacher_id->EditValue ?></span>
<input type="hidden" name="x_teacher_id" id="x_teacher_id" value="<?php echo ew_HtmlEncode($tbl_teacher->teacher_id->CurrentValue) ?>">
</span><?php echo $tbl_teacher->teacher_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher->teacher_name->Visible) { // teacher_name ?>
	<tr id="r_teacher_name"<?php echo $tbl_teacher->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_teacher_name"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_name->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher->teacher_name->CellAttributes() ?>><span id="el_tbl_teacher_teacher_name">
<textarea name="x_teacher_name" id="x_teacher_name" cols="undefined" rows="undefined"<?php echo $tbl_teacher->teacher_name->EditAttributes() ?>><?php echo $tbl_teacher->teacher_name->EditValue ?></textarea>
</span><?php echo $tbl_teacher->teacher_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher->teacher_personal_page->Visible) { // teacher_personal_page ?>
	<tr id="r_teacher_personal_page"<?php echo $tbl_teacher->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_teacher_personal_page"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_personal_page->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher->teacher_personal_page->CellAttributes() ?>><span id="el_tbl_teacher_teacher_personal_page">
<textarea name="x_teacher_personal_page" id="x_teacher_personal_page" cols="undefined" rows="undefined"<?php echo $tbl_teacher->teacher_personal_page->EditAttributes() ?>><?php echo $tbl_teacher->teacher_personal_page->EditValue ?></textarea>
</span><?php echo $tbl_teacher->teacher_personal_page->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher->teacher_avatar->Visible) { // teacher_avatar ?>
	<tr id="r_teacher_avatar"<?php echo $tbl_teacher->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_teacher_avatar"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_avatar->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher->teacher_avatar->CellAttributes() ?>><span id="el_tbl_teacher_teacher_avatar">
<div id="old_x_teacher_avatar">
<?php if ($tbl_teacher->teacher_avatar->LinkAttributes() <> "") { ?>
<?php if (!empty($tbl_teacher->teacher_avatar->Upload->DbValue)) { ?>
<img src="<?php echo $tbl_teacher->teacher_avatar->EditValue ?>" alt="" style="border: 0;"<?php echo $tbl_teacher->teacher_avatar->ViewAttributes() ?>>
<?php } elseif (!in_array($tbl_teacher->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($tbl_teacher->teacher_avatar->Upload->DbValue)) { ?>
<img src="<?php echo $tbl_teacher->teacher_avatar->EditValue ?>" alt="" style="border: 0;"<?php echo $tbl_teacher->teacher_avatar->ViewAttributes() ?>>
<?php } elseif (!in_array($tbl_teacher->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x_teacher_avatar">
<?php if ($tbl_teacher->teacher_avatar->ReadOnly) { ?>
<?php if (!empty($tbl_teacher->teacher_avatar->Upload->DbValue)) { ?>
<input type="hidden" name="a_teacher_avatar" id="a_teacher_avatar" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($tbl_teacher->teacher_avatar->Upload->DbValue)) { ?>
<label><input type="radio" name="a_teacher_avatar" id="a_teacher_avatar" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a_teacher_avatar" id="a_teacher_avatar" value="2"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a_teacher_avatar" id="a_teacher_avatar" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $tbl_teacher->teacher_avatar->EditAttrs["onchange"] = "this.form.a_teacher_avatar[2].checked=true;" . @$tbl_teacher->teacher_avatar->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a_teacher_avatar" id="a_teacher_avatar" value="3">
<?php } ?>
<input type="file" name="x_teacher_avatar" id="x_teacher_avatar" size="30"<?php echo $tbl_teacher->teacher_avatar->EditAttributes() ?>>
<?php } ?>
</div>
</span><?php echo $tbl_teacher->teacher_avatar->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher->teacher_description->Visible) { // teacher_description ?>
	<tr id="r_teacher_description"<?php echo $tbl_teacher->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_teacher_description"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_description->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher->teacher_description->CellAttributes() ?>><span id="el_tbl_teacher_teacher_description">
<textarea name="x_teacher_description" id="x_teacher_description" cols="35" rows="4"<?php echo $tbl_teacher->teacher_description->EditAttributes() ?>><?php echo $tbl_teacher->teacher_description->EditValue ?></textarea>
</span><?php echo $tbl_teacher->teacher_description->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher->teacher_work_place->Visible) { // teacher_work_place ?>
	<tr id="r_teacher_work_place"<?php echo $tbl_teacher->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_teacher_work_place"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_work_place->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher->teacher_work_place->CellAttributes() ?>><span id="el_tbl_teacher_teacher_work_place">
<textarea name="x_teacher_work_place" id="x_teacher_work_place" cols="undefined" rows="undefined"<?php echo $tbl_teacher->teacher_work_place->EditAttributes() ?>><?php echo $tbl_teacher->teacher_work_place->EditValue ?></textarea>
</span><?php echo $tbl_teacher->teacher_work_place->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher->teacher_active->Visible) { // teacher_active ?>
	<tr id="r_teacher_active"<?php echo $tbl_teacher->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_teacher_active"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_active->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher->teacher_active->CellAttributes() ?>><span id="el_tbl_teacher_teacher_active">
<input type="text" name="x_teacher_active" id="x_teacher_active" size="30" value="<?php echo $tbl_teacher->teacher_active->EditValue ?>"<?php echo $tbl_teacher->teacher_active->EditAttributes() ?>>
</span><?php echo $tbl_teacher->teacher_active->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher->teacher_acadamic_title->Visible) { // teacher_acadamic_title ?>
	<tr id="r_teacher_acadamic_title"<?php echo $tbl_teacher->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_teacher_acadamic_title"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_acadamic_title->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher->teacher_acadamic_title->CellAttributes() ?>><span id="el_tbl_teacher_teacher_acadamic_title">
<textarea name="x_teacher_acadamic_title" id="x_teacher_acadamic_title" cols="undefined" rows="undefined"<?php echo $tbl_teacher->teacher_acadamic_title->EditAttributes() ?>><?php echo $tbl_teacher->teacher_acadamic_title->EditValue ?></textarea>
</span><?php echo $tbl_teacher->teacher_acadamic_title->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher->teacher_birthday->Visible) { // teacher_birthday ?>
	<tr id="r_teacher_birthday"<?php echo $tbl_teacher->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_teacher_birthday"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_birthday->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher->teacher_birthday->CellAttributes() ?>><span id="el_tbl_teacher_teacher_birthday">
<textarea name="x_teacher_birthday" id="x_teacher_birthday" cols="undefined" rows="undefined"<?php echo $tbl_teacher->teacher_birthday->EditAttributes() ?>><?php echo $tbl_teacher->teacher_birthday->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_teacheredit", "x_teacher_birthday", 0, 0, <?php echo ($tbl_teacher->teacher_birthday->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_teacher->teacher_birthday->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher->teacher_sex->Visible) { // teacher_sex ?>
	<tr id="r_teacher_sex"<?php echo $tbl_teacher->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_teacher_sex"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_sex->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher->teacher_sex->CellAttributes() ?>><span id="el_tbl_teacher_teacher_sex">
<input type="text" name="x_teacher_sex" id="x_teacher_sex" size="30" value="<?php echo $tbl_teacher->teacher_sex->EditValue ?>"<?php echo $tbl_teacher->teacher_sex->EditAttributes() ?>>
</span><?php echo $tbl_teacher->teacher_sex->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher->teacher_faculty->Visible) { // teacher_faculty ?>
	<tr id="r_teacher_faculty"<?php echo $tbl_teacher->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_teacher_faculty"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_faculty->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher->teacher_faculty->CellAttributes() ?>><span id="el_tbl_teacher_teacher_faculty">
<select id="x_teacher_faculty" name="x_teacher_faculty"<?php echo $tbl_teacher->teacher_faculty->EditAttributes() ?>>
<?php
if (is_array($tbl_teacher->teacher_faculty->EditValue)) {
	$arwrk = $tbl_teacher->teacher_faculty->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_teacher->teacher_faculty->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_teacheredit.Lists["x_teacher_faculty"].Options = <?php echo (is_array($tbl_teacher->teacher_faculty->EditValue)) ? ew_ArrayToJson($tbl_teacher->teacher_faculty->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_teacher->teacher_faculty->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher->teacher_dept->Visible) { // teacher_dept ?>
	<tr id="r_teacher_dept"<?php echo $tbl_teacher->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_teacher_dept"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_dept->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher->teacher_dept->CellAttributes() ?>><span id="el_tbl_teacher_teacher_dept">
<select id="x_teacher_dept" name="x_teacher_dept"<?php echo $tbl_teacher->teacher_dept->EditAttributes() ?>>
<?php
if (is_array($tbl_teacher->teacher_dept->EditValue)) {
	$arwrk = $tbl_teacher->teacher_dept->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_teacher->teacher_dept->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_teacheredit.Lists["x_teacher_dept"].Options = <?php echo (is_array($tbl_teacher->teacher_dept->EditValue)) ? ew_ArrayToJson($tbl_teacher->teacher_dept->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $tbl_teacher->teacher_dept->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher->teacher_rate->Visible) { // teacher_rate ?>
	<tr id="r_teacher_rate"<?php echo $tbl_teacher->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_teacher_rate"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_rate->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher->teacher_rate->CellAttributes() ?>><span id="el_tbl_teacher_teacher_rate">
<input type="text" name="x_teacher_rate" id="x_teacher_rate" size="30" value="<?php echo $tbl_teacher->teacher_rate->EditValue ?>"<?php echo $tbl_teacher->teacher_rate->EditAttributes() ?>>
</span><?php echo $tbl_teacher->teacher_rate->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher->teacher_personality->Visible) { // teacher_personality ?>
	<tr id="r_teacher_personality"<?php echo $tbl_teacher->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_teacher_personality"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_personality->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher->teacher_personality->CellAttributes() ?>><span id="el_tbl_teacher_teacher_personality">
<textarea name="x_teacher_personality" id="x_teacher_personality" cols="35" rows="4"<?php echo $tbl_teacher->teacher_personality->EditAttributes() ?>><?php echo $tbl_teacher->teacher_personality->EditValue ?></textarea>
</span><?php echo $tbl_teacher->teacher_personality->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher->advices->Visible) { // advices ?>
	<tr id="r_advices"<?php echo $tbl_teacher->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_advices"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->advices->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher->advices->CellAttributes() ?>><span id="el_tbl_teacher_advices">
<textarea name="x_advices" id="x_advices" cols="35" rows="4"<?php echo $tbl_teacher->advices->EditAttributes() ?>><?php echo $tbl_teacher->advices->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_teacheredit", "x_advices", 35, 4, <?php echo ($tbl_teacher->advices->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_teacher->advices->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_teacher->teacher_research->Visible) { // teacher_research ?>
	<tr id="r_teacher_research"<?php echo $tbl_teacher->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_teacher_teacher_research"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_research->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_teacher->teacher_research->CellAttributes() ?>><span id="el_tbl_teacher_teacher_research">
<textarea name="x_teacher_research" id="x_teacher_research" cols="35" rows="4"<?php echo $tbl_teacher->teacher_research->EditAttributes() ?>><?php echo $tbl_teacher->teacher_research->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftbl_teacheredit", "x_teacher_research", 35, 4, <?php echo ($tbl_teacher->teacher_research->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $tbl_teacher->teacher_research->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
ftbl_teacheredit.Init();
</script>
<?php
$tbl_teacher_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_teacher_edit->Page_Terminate();
?>
