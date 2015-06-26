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

$tbl_user_view = NULL; // Initialize page object first

class ctbl_user_view extends ctbl_user {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_user';

	// Page object name
	var $PageObjName = 'tbl_user_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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
		$KeyUrl = "";
		if (@$_GET["user_id"] <> "") {
			$this->RecKey["user_id"] = $_GET["user_id"];
			$KeyUrl .= "&user_id=" . urlencode($this->RecKey["user_id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_user', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "span";
		$this->ExportOptions->TagClassName = "ewExportOption";
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

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		if (@$_GET["user_id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["user_id"]);
		}

		// Setup export options
		$this->SetupExportOptions();
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
	var $ExportOptions; // Export options
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["user_id"] <> "") {
				$this->user_id->setQueryStringValue($_GET["user_id"]);
				$this->RecKey["user_id"] = $this->user_id->QueryStringValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					$this->StartRec = 1; // Initialize start position
					if ($this->Recordset = $this->LoadRecordset()) // Load records
						$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
					if ($this->TotalRecs <= 0) { // No record found
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$this->Page_Terminate("tbl_userlist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->user_id->CurrentValue) == strval($this->Recordset->fields('user_id'))) {
								$this->setStartRecordNumber($this->StartRec); // Save record position
								$bMatchRecord = TRUE;
								break;
							} else {
								$this->StartRec++;
								$this->Recordset->MoveNext();
							}
						}
					}
					if (!$bMatchRecord) {
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "tbl_userlist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}

			// Export data only
			if (in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				if ($this->Export == "email")
					$this->Page_Terminate($this->ExportReturnUrl());
				else
					$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "tbl_userlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Call Recordset Selecting event
		$this->Recordset_Selecting($this->CurrentFilter);

		// Load List page SQL
		$sSql = $this->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = TRUE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$item->Body = "<a id=\"emf_tbl_user\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_tbl_user',hdr:ewLanguage.Phrase('ExportToEmail'),key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = TRUE;

		// Hide options for export/action
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;
		$this->SetUpStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs < 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$ExportDoc = ew_ExportDocument($this, "v");
		$ParentTable = "";
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs < 0 ? $this->TotalRecs : $this->DisplayRecs;;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$ExportDoc->Text .= $sHeader;
		$this->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "view");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$ExportDoc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Export header and footer
		$ExportDoc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($this->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
		} else {
			$ExportDoc->Export();
		}
	}

	// Export email
	function ExportEmail($EmailContent) {
		global $gTmpImages, $Language;
		$sSender = @$_GET["sender"];
		$sRecipient = @$_GET["recipient"];
		$sCc = @$_GET["cc"];
		$sBcc = @$_GET["bcc"];
		$sContentType = @$_GET["contenttype"];

		// Subject
		$sSubject = ew_StripSlashes(@$_GET["subject"]);
		$sEmailSubject = $sSubject;

		// Message
		$sContent = ew_StripSlashes(@$_GET["message"]);
		$sEmailMessage = $sContent;

		// Check sender
		if ($sSender == "") {
			$this->setFailureMessage($Language->Phrase("EnterSenderEmail"));
			return;
		}
		if (!ew_CheckEmail($sSender)) {
			$this->setFailureMessage($Language->Phrase("EnterProperSenderEmail"));
			return;
		}

		// Check recipient
		if (!ew_CheckEmailList($sRecipient, EW_MAX_EMAIL_RECIPIENT)) {
			$this->setFailureMessage($Language->Phrase("EnterProperRecipientEmail"));
			return;
		}

		// Check cc
		if (!ew_CheckEmailList($sCc, EW_MAX_EMAIL_RECIPIENT)) {
			$this->setFailureMessage($Language->Phrase("EnterProperCcEmail"));
			return;
		}

		// Check bcc
		if (!ew_CheckEmailList($sBcc, EW_MAX_EMAIL_RECIPIENT)) {
			$this->setFailureMessage($Language->Phrase("EnterProperBccEmail"));
			return;
		}

		// Check email sent count
		if (!isset($_SESSION[EW_EXPORT_EMAIL_COUNTER]))
			$_SESSION[EW_EXPORT_EMAIL_COUNTER] = 0;
		if (intval($_SESSION[EW_EXPORT_EMAIL_COUNTER]) > EW_MAX_EMAIL_SENT_COUNT) {
			$this->setFailureMessage($Language->Phrase("ExceedMaxEmailExport"));
			return;
		}

		// Send email
		$Email = new cEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Format = ($sContentType == "url") ? "text" : "html";
		$Email->Charset = EW_EMAIL_CHARSET;
		if ($sEmailMessage <> "") {
			$sEmailMessage = ew_RemoveXSS($sEmailMessage);
			$sEmailMessage .= ($sContentType == "url") ? "\r\n\r\n" : "<br><br>";
		}
		if ($sContentType == "url") {
			$sUrl = ew_ConvertFullUrl(ew_CurrentPage() . "?" . $this->ExportQueryString());
			$sEmailMessage .= $sUrl; // send URL only
		} else {
			foreach ($gTmpImages as $tmpimage)
				$Email->AddEmbeddedImage($tmpimage);
			$sEmailMessage .= $EmailContent; // send HTML
		}
		$Email->Content = $sEmailMessage; // Content
		$EventArgs = array();
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();

		// Check email sent status
		if ($bEmailSent) {

			// Update email sent count
			$_SESSION[EW_EXPORT_EMAIL_COUNTER]++;

			// Sent email success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("SendEmailSuccess")); // Set up success message
		} else {

			// Sent email failure
			$this->setFailureMessage($Email->SendErrDescription);
		}
	}

	// Export QueryString
	function ExportQueryString() {

		// Initialize
		$sQry = "export=html";

		// Add record key QueryString
		$sQry .= "&" . substr($this->KeyUrl("", ""), 1);
		return $sQry;
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tbl_user_view)) $tbl_user_view = new ctbl_user_view();

// Page init
$tbl_user_view->Page_Init();

// Page main
$tbl_user_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($tbl_user->Export == "") { ?>
<script type="text/javascript">

// Page object
var tbl_user_view = new ew_Page("tbl_user_view");
tbl_user_view.PageID = "view"; // Page ID
var EW_PAGE_ID = tbl_user_view.PageID; // For backward compatibility

// Form object
var ftbl_userview = new ew_Form("ftbl_userview");

// Form_CustomValidate event
ftbl_userview.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_userview.ValidateRequired = true;
<?php } else { ?>
ftbl_userview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_user->TableCaption() ?>&nbsp;&nbsp;</span><?php $tbl_user_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($tbl_user->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $tbl_user_view->ListUrl ?>" id="a_BackToList" class="ewLink"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($tbl_user_view->AddUrl <> "") { ?>
<a href="<?php echo $tbl_user_view->AddUrl ?>" id="a_AddLink" class="ewLink"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($tbl_user_view->EditUrl <> "") { ?>
<a href="<?php echo $tbl_user_view->EditUrl ?>" id="a_EditLink" class="ewLink"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($tbl_user_view->CopyUrl <> "") { ?>
<a href="<?php echo $tbl_user_view->CopyUrl ?>" id="a_CopyLink" class="ewLink"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($tbl_user_view->DeleteUrl <> "") { ?>
<a onclick="return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));" href="<?php echo $tbl_user_view->DeleteUrl ?>" id="a_DeleteLink" class="ewLink"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</p>
<?php } ?>
<?php $tbl_user_view->ShowPageHeader(); ?>
<?php
$tbl_user_view->ShowMessage();
?>
<?php if ($tbl_user->Export == "") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($tbl_user_view->Pager)) $tbl_user_view->Pager = new cPrevNextPager($tbl_user_view->StartRec, $tbl_user_view->DisplayRecs, $tbl_user_view->TotalRecs) ?>
<?php if ($tbl_user_view->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($tbl_user_view->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_user_view->PageUrl() ?>start=<?php echo $tbl_user_view->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($tbl_user_view->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_user_view->PageUrl() ?>start=<?php echo $tbl_user_view->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $tbl_user_view->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($tbl_user_view->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_user_view->PageUrl() ?>start=<?php echo $tbl_user_view->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($tbl_user_view->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_user_view->PageUrl() ?>start=<?php echo $tbl_user_view->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $tbl_user_view->Pager->PageCount ?></span></td>
	</tr></tbody></table>
<?php } else { ?>
	<?php if ($tbl_user_view->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
	</td>
</tr></table>
</form>
<br>
<?php } ?>
<form name="ftbl_userview" id="ftbl_userview" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="tbl_user">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_userview" class="ewTable">
<?php if ($tbl_user->user_id->Visible) { // user_id ?>
	<tr id="r_user_id"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_id->CellAttributes() ?>><span id="el_tbl_user_user_id">
<span<?php echo $tbl_user->user_id->ViewAttributes() ?>>
<?php echo $tbl_user->user_id->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_id_fb->Visible) { // user_id_fb ?>
	<tr id="r_user_id_fb"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_id_fb"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_id_fb->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_id_fb->CellAttributes() ?>><span id="el_tbl_user_user_id_fb">
<span<?php echo $tbl_user->user_id_fb->ViewAttributes() ?>>
<?php echo $tbl_user->user_id_fb->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->username->Visible) { // username ?>
	<tr id="r_username"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_username"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->username->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->username->CellAttributes() ?>><span id="el_tbl_user_username">
<span<?php echo $tbl_user->username->ViewAttributes() ?>>
<?php echo $tbl_user->username->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->password->Visible) { // password ?>
	<tr id="r_password"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_password"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->password->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->password->CellAttributes() ?>><span id="el_tbl_user_password">
<span<?php echo $tbl_user->password->ViewAttributes() ?>>
<?php echo $tbl_user->password->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_real_name->Visible) { // user_real_name ?>
	<tr id="r_user_real_name"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_real_name"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_real_name->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_real_name->CellAttributes() ?>><span id="el_tbl_user_user_real_name">
<span<?php echo $tbl_user->user_real_name->ViewAttributes() ?>>
<?php echo $tbl_user->user_real_name->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_avatar->Visible) { // user_avatar ?>
	<tr id="r_user_avatar"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_avatar"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_avatar->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_avatar->CellAttributes() ?>><span id="el_tbl_user_user_avatar">
<span>
<?php if (!ew_EmptyStr($tbl_user->user_avatar->ViewValue)) { ?><img src="<?php echo $tbl_user->user_avatar->ViewValue ?>" alt="" style="border: 0;"<?php echo $tbl_user->user_avatar->ViewAttributes() ?>><?php } ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_cover->Visible) { // user_cover ?>
	<tr id="r_user_cover"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_cover"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_cover->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_cover->CellAttributes() ?>><span id="el_tbl_user_user_cover">
<span<?php echo $tbl_user->user_cover->ViewAttributes() ?>>
<?php echo $tbl_user->user_cover->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_student_code->Visible) { // user_student_code ?>
	<tr id="r_user_student_code"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_student_code"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_student_code->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_student_code->CellAttributes() ?>><span id="el_tbl_user_user_student_code">
<span<?php echo $tbl_user->user_student_code->ViewAttributes() ?>>
<?php echo $tbl_user->user_student_code->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_university->Visible) { // user_university ?>
	<tr id="r_user_university"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_university"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_university->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_university->CellAttributes() ?>><span id="el_tbl_user_user_university">
<span<?php echo $tbl_user->user_university->ViewAttributes() ?>>
<?php echo $tbl_user->user_university->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_gender->Visible) { // user_gender ?>
	<tr id="r_user_gender"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_gender"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_gender->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_gender->CellAttributes() ?>><span id="el_tbl_user_user_gender">
<span<?php echo $tbl_user->user_gender->ViewAttributes() ?>>
<?php echo $tbl_user->user_gender->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_dob->Visible) { // user_dob ?>
	<tr id="r_user_dob"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_dob"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_dob->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_dob->CellAttributes() ?>><span id="el_tbl_user_user_dob">
<span<?php echo $tbl_user->user_dob->ViewAttributes() ?>>
<?php echo $tbl_user->user_dob->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_hometown->Visible) { // user_hometown ?>
	<tr id="r_user_hometown"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_hometown"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_hometown->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_hometown->CellAttributes() ?>><span id="el_tbl_user_user_hometown">
<span<?php echo $tbl_user->user_hometown->ViewAttributes() ?>>
<?php echo $tbl_user->user_hometown->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_phone->Visible) { // user_phone ?>
	<tr id="r_user_phone"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_phone"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_phone->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_phone->CellAttributes() ?>><span id="el_tbl_user_user_phone">
<span<?php echo $tbl_user->user_phone->ViewAttributes() ?>>
<?php echo $tbl_user->user_phone->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_description->Visible) { // user_description ?>
	<tr id="r_user_description"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_description"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_description->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_description->CellAttributes() ?>><span id="el_tbl_user_user_description">
<span<?php echo $tbl_user->user_description->ViewAttributes() ?>>
<?php echo $tbl_user->user_description->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_faculty->Visible) { // user_faculty ?>
	<tr id="r_user_faculty"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_faculty"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_faculty->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_faculty->CellAttributes() ?>><span id="el_tbl_user_user_faculty">
<span<?php echo $tbl_user->user_faculty->ViewAttributes() ?>>
<?php echo $tbl_user->user_faculty->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_class->Visible) { // user_class ?>
	<tr id="r_user_class"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_class"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_class->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_class->CellAttributes() ?>><span id="el_tbl_user_user_class">
<span<?php echo $tbl_user->user_class->ViewAttributes() ?>>
<?php echo $tbl_user->user_class->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_active->Visible) { // user_active ?>
	<tr id="r_user_active"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_active"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_active->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_active->CellAttributes() ?>><span id="el_tbl_user_user_active">
<span<?php echo $tbl_user->user_active->ViewAttributes() ?>>
<?php echo $tbl_user->user_active->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_status->Visible) { // user_status ?>
	<tr id="r_user_status"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_status"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_status->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_status->CellAttributes() ?>><span id="el_tbl_user_user_status">
<span<?php echo $tbl_user->user_status->ViewAttributes() ?>>
<?php echo $tbl_user->user_status->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_group->Visible) { // user_group ?>
	<tr id="r_user_group"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_group"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_group->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_group->CellAttributes() ?>><span id="el_tbl_user_user_group">
<span<?php echo $tbl_user->user_group->ViewAttributes() ?>>
<?php echo $tbl_user->user_group->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_token->Visible) { // user_token ?>
	<tr id="r_user_token"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_token"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_token->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_token->CellAttributes() ?>><span id="el_tbl_user_user_token">
<span<?php echo $tbl_user->user_token->ViewAttributes() ?>>
<?php echo $tbl_user->user_token->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_activator->Visible) { // user_activator ?>
	<tr id="r_user_activator"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_activator"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_activator->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_activator->CellAttributes() ?>><span id="el_tbl_user_user_activator">
<span<?php echo $tbl_user->user_activator->ViewAttributes() ?>>
<?php echo $tbl_user->user_activator->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_qoutes->Visible) { // user_qoutes ?>
	<tr id="r_user_qoutes"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_qoutes"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_qoutes->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_qoutes->CellAttributes() ?>><span id="el_tbl_user_user_qoutes">
<span<?php echo $tbl_user->user_qoutes->ViewAttributes() ?>>
<?php echo $tbl_user->user_qoutes->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->user_date_attend->Visible) { // user_date_attend ?>
	<tr id="r_user_date_attend"<?php echo $tbl_user->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_user_user_date_attend"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_date_attend->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_user->user_date_attend->CellAttributes() ?>><span id="el_tbl_user_user_date_attend">
<span<?php echo $tbl_user->user_date_attend->ViewAttributes() ?>>
<?php echo $tbl_user->user_date_attend->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
</form>
<br>
<script type="text/javascript">
ftbl_userview.Init();
</script>
<?php
$tbl_user_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($tbl_user->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$tbl_user_view->Page_Terminate();
?>
