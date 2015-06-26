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

$tbl_doc_view = NULL; // Initialize page object first

class ctbl_doc_view extends ctbl_doc {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_doc';

	// Page object name
	var $PageObjName = 'tbl_doc_view';

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

		// Table object (tbl_doc)
		if (!isset($GLOBALS["tbl_doc"])) {
			$GLOBALS["tbl_doc"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_doc"];
		}
		$KeyUrl = "";
		if (@$_GET["doc_id"] <> "") {
			$this->RecKey["doc_id"] = $_GET["doc_id"];
			$KeyUrl .= "&doc_id=" . urlencode($this->RecKey["doc_id"]);
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
			define("EW_TABLE_NAME", 'tbl_doc', TRUE);

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
		if (@$_GET["doc_id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["doc_id"]);
		}

		// Setup export options
		$this->SetupExportOptions();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"];
		$this->doc_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
			if (@$_GET["doc_id"] <> "") {
				$this->doc_id->setQueryStringValue($_GET["doc_id"]);
				$this->RecKey["doc_id"] = $this->doc_id->QueryStringValue;
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
						$this->Page_Terminate("tbl_doclist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->doc_id->CurrentValue) == strval($this->Recordset->fields('doc_id'))) {
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
						$sReturnUrl = "tbl_doclist.php"; // No matching record, return to list
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
			$sReturnUrl = "tbl_doclist.php"; // Not page request, return to list
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

			// doc_id
			$this->doc_id->LinkCustomAttributes = "";
			$this->doc_id->HrefValue = "";
			$this->doc_id->TooltipValue = "";

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
		$item->Body = "<a id=\"emf_tbl_doc\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_tbl_doc',hdr:ewLanguage.Phrase('ExportToEmail'),key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
if (!isset($tbl_doc_view)) $tbl_doc_view = new ctbl_doc_view();

// Page init
$tbl_doc_view->Page_Init();

// Page main
$tbl_doc_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($tbl_doc->Export == "") { ?>
<script type="text/javascript">

// Page object
var tbl_doc_view = new ew_Page("tbl_doc_view");
tbl_doc_view.PageID = "view"; // Page ID
var EW_PAGE_ID = tbl_doc_view.PageID; // For backward compatibility

// Form object
var ftbl_docview = new ew_Form("ftbl_docview");

// Form_CustomValidate event
ftbl_docview.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_docview.ValidateRequired = true;
<?php } else { ?>
ftbl_docview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_docview.Lists["x_subject_dept"] = {"LinkField":"x_dept_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_dept_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_docview.Lists["x_subject_type"] = {"LinkField":"x_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_subject_type_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_docview.Lists["x_subject_faculty"] = {"LinkField":"x_faculty_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_faculty_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_docview.Lists["x_subject_general_faculty_id"] = {"LinkField":"x_faculty_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_faculty_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_doc->TableCaption() ?>&nbsp;&nbsp;</span><?php $tbl_doc_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($tbl_doc->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $tbl_doc_view->ListUrl ?>" id="a_BackToList" class="ewLink"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($tbl_doc_view->AddUrl <> "") { ?>
<a href="<?php echo $tbl_doc_view->AddUrl ?>" id="a_AddLink" class="ewLink"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($tbl_doc_view->EditUrl <> "") { ?>
<a href="<?php echo $tbl_doc_view->EditUrl ?>" id="a_EditLink" class="ewLink"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($tbl_doc_view->CopyUrl <> "") { ?>
<a href="<?php echo $tbl_doc_view->CopyUrl ?>" id="a_CopyLink" class="ewLink"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($tbl_doc_view->DeleteUrl <> "") { ?>
<a onclick="return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));" href="<?php echo $tbl_doc_view->DeleteUrl ?>" id="a_DeleteLink" class="ewLink"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</p>
<?php } ?>
<?php $tbl_doc_view->ShowPageHeader(); ?>
<?php
$tbl_doc_view->ShowMessage();
?>
<?php if ($tbl_doc->Export == "") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($tbl_doc_view->Pager)) $tbl_doc_view->Pager = new cPrevNextPager($tbl_doc_view->StartRec, $tbl_doc_view->DisplayRecs, $tbl_doc_view->TotalRecs) ?>
<?php if ($tbl_doc_view->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($tbl_doc_view->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_doc_view->PageUrl() ?>start=<?php echo $tbl_doc_view->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($tbl_doc_view->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_doc_view->PageUrl() ?>start=<?php echo $tbl_doc_view->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $tbl_doc_view->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($tbl_doc_view->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_doc_view->PageUrl() ?>start=<?php echo $tbl_doc_view->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($tbl_doc_view->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_doc_view->PageUrl() ?>start=<?php echo $tbl_doc_view->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $tbl_doc_view->Pager->PageCount ?></span></td>
	</tr></tbody></table>
<?php } else { ?>
	<?php if ($tbl_doc_view->SearchWhere == "0=101") { ?>
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
<form name="ftbl_docview" id="ftbl_docview" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="tbl_doc">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_docview" class="ewTable">
<?php if ($tbl_doc->doc_id->Visible) { // doc_id ?>
	<tr id="r_doc_id"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_id->CellAttributes() ?>><span id="el_tbl_doc_doc_id">
<span<?php echo $tbl_doc->doc_id->ViewAttributes() ?>>
<?php echo $tbl_doc->doc_id->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_url->Visible) { // doc_url ?>
	<tr id="r_doc_url"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_url"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_url->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_url->CellAttributes() ?>><span id="el_tbl_doc_doc_url">
<span>
<?php if (!ew_EmptyStr($tbl_doc->doc_url->ViewValue)) { ?><img src="<?php echo $tbl_doc->doc_url->ViewValue ?>" alt="" style="border: 0;"<?php echo $tbl_doc->doc_url->ViewAttributes() ?>><?php } ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_name->Visible) { // doc_name ?>
	<tr id="r_doc_name"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_name"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_name->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_name->CellAttributes() ?>><span id="el_tbl_doc_doc_name">
<span<?php echo $tbl_doc->doc_name->ViewAttributes() ?>>
<?php echo $tbl_doc->doc_name->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_scribd_id->Visible) { // doc_scribd_id ?>
	<tr id="r_doc_scribd_id"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_scribd_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_scribd_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_scribd_id->CellAttributes() ?>><span id="el_tbl_doc_doc_scribd_id">
<span<?php echo $tbl_doc->doc_scribd_id->ViewAttributes() ?>>
<?php echo $tbl_doc->doc_scribd_id->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_description->Visible) { // doc_description ?>
	<tr id="r_doc_description"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_description"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_description->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_description->CellAttributes() ?>><span id="el_tbl_doc_doc_description">
<span<?php echo $tbl_doc->doc_description->ViewAttributes() ?>>
<?php echo $tbl_doc->doc_description->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_title->Visible) { // doc_title ?>
	<tr id="r_doc_title"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_title"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_title->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_title->CellAttributes() ?>><span id="el_tbl_doc_doc_title">
<span<?php echo $tbl_doc->doc_title->ViewAttributes() ?>>
<?php echo $tbl_doc->doc_title->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_status->Visible) { // doc_status ?>
	<tr id="r_doc_status"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_status"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_status->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_status->CellAttributes() ?>><span id="el_tbl_doc_doc_status">
<span<?php echo $tbl_doc->doc_status->ViewAttributes() ?>>
<?php echo $tbl_doc->doc_status->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_author->Visible) { // doc_author ?>
	<tr id="r_doc_author"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_author"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_author->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_author->CellAttributes() ?>><span id="el_tbl_doc_doc_author">
<span<?php echo $tbl_doc->doc_author->ViewAttributes() ?>>
<?php echo $tbl_doc->doc_author->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_type->Visible) { // doc_type ?>
	<tr id="r_doc_type"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_type"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_type->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_type->CellAttributes() ?>><span id="el_tbl_doc_doc_type">
<span<?php echo $tbl_doc->doc_type->ViewAttributes() ?>>
<?php echo $tbl_doc->doc_type->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_path->Visible) { // doc_path ?>
	<tr id="r_doc_path"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_path"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_path->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_path->CellAttributes() ?>><span id="el_tbl_doc_doc_path">
<span<?php echo $tbl_doc->doc_path->ViewAttributes() ?>>
<?php echo $tbl_doc->doc_path->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->subject_dept->Visible) { // subject_dept ?>
	<tr id="r_subject_dept"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_subject_dept"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->subject_dept->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->subject_dept->CellAttributes() ?>><span id="el_tbl_doc_subject_dept">
<span<?php echo $tbl_doc->subject_dept->ViewAttributes() ?>>
<?php echo $tbl_doc->subject_dept->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->subject_type->Visible) { // subject_type ?>
	<tr id="r_subject_type"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_subject_type"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->subject_type->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->subject_type->CellAttributes() ?>><span id="el_tbl_doc_subject_type">
<span<?php echo $tbl_doc->subject_type->ViewAttributes() ?>>
<?php echo $tbl_doc->subject_type->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->subject_faculty->Visible) { // subject_faculty ?>
	<tr id="r_subject_faculty"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_subject_faculty"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->subject_faculty->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->subject_faculty->CellAttributes() ?>><span id="el_tbl_doc_subject_faculty">
<span<?php echo $tbl_doc->subject_faculty->ViewAttributes() ?>>
<?php echo $tbl_doc->subject_faculty->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_author_name->Visible) { // doc_author_name ?>
	<tr id="r_doc_author_name"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_author_name"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_author_name->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_author_name->CellAttributes() ?>><span id="el_tbl_doc_doc_author_name">
<span<?php echo $tbl_doc->doc_author_name->ViewAttributes() ?>>
<?php echo $tbl_doc->doc_author_name->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->doc_publisher->Visible) { // doc_publisher ?>
	<tr id="r_doc_publisher"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_doc_publisher"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->doc_publisher->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->doc_publisher->CellAttributes() ?>><span id="el_tbl_doc_doc_publisher">
<span<?php echo $tbl_doc->doc_publisher->ViewAttributes() ?>>
<?php echo $tbl_doc->doc_publisher->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($tbl_doc->subject_general_faculty_id->Visible) { // subject_general_faculty_id ?>
	<tr id="r_subject_general_faculty_id"<?php echo $tbl_doc->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_tbl_doc_subject_general_faculty_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_doc->subject_general_faculty_id->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $tbl_doc->subject_general_faculty_id->CellAttributes() ?>><span id="el_tbl_doc_subject_general_faculty_id">
<span<?php echo $tbl_doc->subject_general_faculty_id->ViewAttributes() ?>>
<?php echo $tbl_doc->subject_general_faculty_id->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
</form>
<br>
<script type="text/javascript">
ftbl_docview.Init();
</script>
<?php
$tbl_doc_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($tbl_doc->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$tbl_doc_view->Page_Terminate();
?>
