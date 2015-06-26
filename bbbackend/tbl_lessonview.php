<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "tbl_lessoninfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$tbl_lesson_view = NULL; // Initialize page object first

class ctbl_lesson_view extends ctbl_lesson {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_lesson';

	// Page object name
	var $PageObjName = 'tbl_lesson_view';

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

		// Table object (tbl_lesson)
		if (!isset($GLOBALS["tbl_lesson"])) {
			$GLOBALS["tbl_lesson"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_lesson"];
		}
		$KeyUrl = "";
		if (@$_GET["lesson_id"] <> "") {
			$this->RecKey["lesson_id"] = $_GET["lesson_id"];
			$KeyUrl .= "&lesson_id=" . urlencode($this->RecKey["lesson_id"]);
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
			define("EW_TABLE_NAME", 'tbl_lesson', TRUE);

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
		if (@$_GET["lesson_id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["lesson_id"]);
		}

		// Setup export options
		$this->SetupExportOptions();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"];
		$this->lesson_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
			if (@$_GET["lesson_id"] <> "") {
				$this->lesson_id->setQueryStringValue($_GET["lesson_id"]);
				$this->RecKey["lesson_id"] = $this->lesson_id->QueryStringValue;
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
						$this->Page_Terminate("tbl_lessonlist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->lesson_id->CurrentValue) == strval($this->Recordset->fields('lesson_id'))) {
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
						$sReturnUrl = "tbl_lessonlist.php"; // No matching record, return to list
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
			$sReturnUrl = "tbl_lessonlist.php"; // Not page request, return to list
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
		$this->lesson_id->setDbValue($rs->fields('lesson_id'));
		$this->lesson_active->setDbValue($rs->fields('lesson_active'));
		$this->lesson_weeks->setDbValue($rs->fields('lesson_weeks'));
		$this->lesson_subject->setDbValue($rs->fields('lesson_subject'));
		$this->lesson_name->setDbValue($rs->fields('lesson_name'));
		$this->lesson_info->setDbValue($rs->fields('lesson_info'));
		$this->lesson_doc->setDbValue($rs->fields('lesson_doc'));
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
		// lesson_id
		// lesson_active
		// lesson_weeks
		// lesson_subject
		// lesson_name
		// lesson_info
		// lesson_doc

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// lesson_id
			$this->lesson_id->ViewValue = $this->lesson_id->CurrentValue;
			$this->lesson_id->ViewCustomAttributes = "";

			// lesson_active
			$this->lesson_active->ViewValue = $this->lesson_active->CurrentValue;
			$this->lesson_active->ViewCustomAttributes = "";

			// lesson_weeks
			$this->lesson_weeks->ViewValue = $this->lesson_weeks->CurrentValue;
			$this->lesson_weeks->ViewCustomAttributes = "";

			// lesson_subject
			if (strval($this->lesson_subject->CurrentValue) <> "") {
				$sFilterWrk = "`subject_id`" . ew_SearchString("=", $this->lesson_subject->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `subject_id`, `subject_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_subject`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->lesson_subject->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->lesson_subject->ViewValue = $this->lesson_subject->CurrentValue;
				}
			} else {
				$this->lesson_subject->ViewValue = NULL;
			}
			$this->lesson_subject->ViewCustomAttributes = "";

			// lesson_name
			$this->lesson_name->ViewValue = $this->lesson_name->CurrentValue;
			$this->lesson_name->ViewCustomAttributes = "";

			// lesson_info
			$this->lesson_info->ViewValue = $this->lesson_info->CurrentValue;
			$this->lesson_info->ViewCustomAttributes = "";

			// lesson_doc
			$this->lesson_doc->ViewValue = $this->lesson_doc->CurrentValue;
			$this->lesson_doc->ViewCustomAttributes = "";

			// lesson_id
			$this->lesson_id->LinkCustomAttributes = "";
			$this->lesson_id->HrefValue = "";
			$this->lesson_id->TooltipValue = "";

			// lesson_active
			$this->lesson_active->LinkCustomAttributes = "";
			$this->lesson_active->HrefValue = "";
			$this->lesson_active->TooltipValue = "";

			// lesson_weeks
			$this->lesson_weeks->LinkCustomAttributes = "";
			$this->lesson_weeks->HrefValue = "";
			$this->lesson_weeks->TooltipValue = "";

			// lesson_subject
			$this->lesson_subject->LinkCustomAttributes = "";
			$this->lesson_subject->HrefValue = "";
			$this->lesson_subject->TooltipValue = "";

			// lesson_name
			$this->lesson_name->LinkCustomAttributes = "";
			$this->lesson_name->HrefValue = "";
			$this->lesson_name->TooltipValue = "";

			// lesson_info
			$this->lesson_info->LinkCustomAttributes = "";
			$this->lesson_info->HrefValue = "";
			$this->lesson_info->TooltipValue = "";

			// lesson_doc
			$this->lesson_doc->LinkCustomAttributes = "";
			$this->lesson_doc->HrefValue = "";
			$this->lesson_doc->TooltipValue = "";
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
		$item->Body = "<a id=\"emf_tbl_lesson\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_tbl_lesson',hdr:ewLanguage.Phrase('ExportToEmail'),key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
if (!isset($tbl_lesson_view)) $tbl_lesson_view = new ctbl_lesson_view();

// Page init
$tbl_lesson_view->Page_Init();

// Page main
$tbl_lesson_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($tbl_lesson->Export == "") { ?>
<script type="text/javascript">

// Page object
var tbl_lesson_view = new ew_Page("tbl_lesson_view");
tbl_lesson_view.PageID = "view"; // Page ID
var EW_PAGE_ID = tbl_lesson_view.PageID; // For backward compatibility

// Form object
var ftbl_lessonview = new ew_Form("ftbl_lessonview");

// Form_CustomValidate event
ftbl_lessonview.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_lessonview.ValidateRequired = true;
<?php } else { ?>
ftbl_lessonview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_lessonview.Lists["x_lesson_subject"] = {"LinkField":"x_subject_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_subject_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_lesson->TableCaption() ?>&nbsp;&nbsp;</span><?php $tbl_lesson_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($tbl_lesson->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $tbl_lesson_view->ListUrl ?>" id="a_BackToList" class="ewLink"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($tbl_lesson_view->AddUrl <> "") { ?>
<a href="<?php echo $tbl_lesson_view->AddUrl ?>" id="a_AddLink" class="ewLink"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($tbl_lesson_view->EditUrl <> "") { ?>
<a href="<?php echo $tbl_lesson_view->EditUrl ?>" id="a_EditLink" class="ewLink"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($tbl_lesson_view->CopyUrl <> "") { ?>
<a href="<?php echo $tbl_lesson_view->CopyUrl ?>" id="a_CopyLink" class="ewLink"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($tbl_lesson_view->DeleteUrl <> "") { ?>
<a onclick="return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));" href="<?php echo $tbl_lesson_view->DeleteUrl ?>" id="a_DeleteLink" class="ewLink"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</p>
<?php } ?>
<?php $tbl_lesson_view->ShowPageHeader(); ?>
<?php
$tbl_lesson_view->ShowMessage();
?>
<?php if ($tbl_lesson->Export == "") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($tbl_lesson_view->Pager)) $tbl_lesson_view->Pager = new cPrevNextPager($tbl_lesson_view->StartRec, $tbl_lesson_view->DisplayRecs, $tbl_lesson_view->TotalRecs) ?>
<?php if ($tbl_lesson_view->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($tbl_lesson_view->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_lesson_view->PageUrl() ?>start=<?php echo $tbl_lesson_view->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($tbl_lesson_view->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_lesson_view->PageUrl() ?>start=<?php echo $tbl_lesson_view->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $tbl_lesson_view->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($tbl_lesson_view->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_lesson_view->PageUrl() ?>start=<?php echo $tbl_lesson_view->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($tbl_lesson_view->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_lesson_view->PageUrl() ?>start=<?php echo $tbl_lesson_view->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $tbl_lesson_view->Pager->PageCount ?></span></td>
	</tr></tbody></table>
<?php } else { ?>
	<?php if ($tbl_lesson_view->SearchWhere == "0=101") { ?>
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
<form name="ftbl_lessonview" id="ftbl_lessonview" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="tbl_lesson">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_lessonview" class="ewTable">
<?php if ($tbl_lesson->lesson_id->Visible) { // lesson_id ?>
	<tr id="r_lesson_id"<?php echo $tbl_lesson->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_lesson_lesson_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_lesson->lesson_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_lesson->lesson_id->CellAttributes() ?>><span id="el_tbl_lesson_lesson_id">
<span<?php echo $tbl_lesson->lesson_id->ViewAttributes() ?>>
<?php echo $tbl_lesson->lesson_id->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_lesson->lesson_active->Visible) { // lesson_active ?>
	<tr id="r_lesson_active"<?php echo $tbl_lesson->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_lesson_lesson_active"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_lesson->lesson_active->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_lesson->lesson_active->CellAttributes() ?>><span id="el_tbl_lesson_lesson_active">
<span<?php echo $tbl_lesson->lesson_active->ViewAttributes() ?>>
<?php echo $tbl_lesson->lesson_active->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_lesson->lesson_weeks->Visible) { // lesson_weeks ?>
	<tr id="r_lesson_weeks"<?php echo $tbl_lesson->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_lesson_lesson_weeks"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_lesson->lesson_weeks->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_lesson->lesson_weeks->CellAttributes() ?>><span id="el_tbl_lesson_lesson_weeks">
<span<?php echo $tbl_lesson->lesson_weeks->ViewAttributes() ?>>
<?php echo $tbl_lesson->lesson_weeks->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_lesson->lesson_subject->Visible) { // lesson_subject ?>
	<tr id="r_lesson_subject"<?php echo $tbl_lesson->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_lesson_lesson_subject"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_lesson->lesson_subject->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_lesson->lesson_subject->CellAttributes() ?>><span id="el_tbl_lesson_lesson_subject">
<span<?php echo $tbl_lesson->lesson_subject->ViewAttributes() ?>>
<?php echo $tbl_lesson->lesson_subject->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_lesson->lesson_name->Visible) { // lesson_name ?>
	<tr id="r_lesson_name"<?php echo $tbl_lesson->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_lesson_lesson_name"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_lesson->lesson_name->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_lesson->lesson_name->CellAttributes() ?>><span id="el_tbl_lesson_lesson_name">
<span<?php echo $tbl_lesson->lesson_name->ViewAttributes() ?>>
<?php echo $tbl_lesson->lesson_name->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_lesson->lesson_info->Visible) { // lesson_info ?>
	<tr id="r_lesson_info"<?php echo $tbl_lesson->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_lesson_lesson_info"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_lesson->lesson_info->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_lesson->lesson_info->CellAttributes() ?>><span id="el_tbl_lesson_lesson_info">
<span<?php echo $tbl_lesson->lesson_info->ViewAttributes() ?>>
<?php echo $tbl_lesson->lesson_info->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_lesson->lesson_doc->Visible) { // lesson_doc ?>
	<tr id="r_lesson_doc"<?php echo $tbl_lesson->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_lesson_lesson_doc"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_lesson->lesson_doc->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_lesson->lesson_doc->CellAttributes() ?>><span id="el_tbl_lesson_lesson_doc">
<span<?php echo $tbl_lesson->lesson_doc->ViewAttributes() ?>>
<?php echo $tbl_lesson->lesson_doc->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
</form>
<br>
<script type="text/javascript">
ftbl_lessonview.Init();
</script>
<?php
$tbl_lesson_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($tbl_lesson->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$tbl_lesson_view->Page_Terminate();
?>
