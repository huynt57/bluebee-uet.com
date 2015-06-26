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

$tbl_subject_list = NULL; // Initialize page object first

class ctbl_subject_list extends ctbl_subject {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_subject';

	// Page object name
	var $PageObjName = 'tbl_subject_list';

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

		// Table object (tbl_subject)
		if (!isset($GLOBALS["tbl_subject"])) {
			$GLOBALS["tbl_subject"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_subject"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "tbl_subjectadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "tbl_subjectdelete.php";
		$this->MultiUpdateUrl = "tbl_subjectupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_subject', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

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

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Hide all options
			if ($this->Export <> "" ||
				$this->CurrentAction == "gridadd" ||
				$this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ExportOptions->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session if not searching / reset
			if ($this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall")
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search") {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export data only
		if (in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			if ($this->Export == "email")
				$this->Page_Terminate($this->ExportReturnUrl());
			else
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue("k_key"));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->subject_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->subject_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->subject_name, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->subject_code, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->subject_active, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->subject_university, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->subject_credit_hour, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->subject_requirement, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->subject_target, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->subject_info, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->subject_test, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->subject_content, $Keyword);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $Keyword) {
		if ($Keyword == EW_NULL_VALUE) {
			$sWrk = $Fld->FldExpression . " IS NULL";
		} elseif ($Keyword == EW_NOT_NULL_VALUE) {
			$sWrk = $Fld->FldExpression . " IS NOT NULL";
		} else {
			$sFldExpression = ($Fld->FldVirtualExpression <> $Fld->FldExpression) ? $Fld->FldVirtualExpression : $Fld->FldBasicSearchExpression;
			$sWrk = $sFldExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING));
		}
		if ($Where <> "") $Where .= " OR ";
		$Where .= $sWrk;
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere() {
		global $Security;
		$sSearchStr = "";
		$sSearchKeyword = $this->BasicSearch->Keyword;
		$sSearchType = $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				while (strpos($sSearch, "  ") !== FALSE)
					$sSearch = str_replace("  ", " ", $sSearch);
				$arKeyword = explode(" ", trim($sSearch));
				foreach ($arKeyword as $sKeyword) {
					if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
					$sSearchStr .= "(" . $this->BasicSearchSQL($sKeyword) . ")";
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($sSearch);
			}
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->subject_id); // subject_id
			$this->UpdateSort($this->subject_name); // subject_name
			$this->UpdateSort($this->subject_code); // subject_code
			$this->UpdateSort($this->subject_active); // subject_active
			$this->UpdateSort($this->subject_university); // subject_university
			$this->UpdateSort($this->subject_type); // subject_type
			$this->UpdateSort($this->subject_year); // subject_year
			$this->UpdateSort($this->subject_credits); // subject_credits
			$this->UpdateSort($this->subject_credit_hour); // subject_credit_hour
			$this->UpdateSort($this->subject_faculty); // subject_faculty
			$this->UpdateSort($this->subject_dept); // subject_dept
			$this->UpdateSort($this->subject_general_faculty_id); // subject_general_faculty_id
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->SqlOrderBy() <> "") {
				$sOrderBy = $this->SqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->subject_id->setSort("");
				$this->subject_name->setSort("");
				$this->subject_code->setSort("");
				$this->subject_active->setSort("");
				$this->subject_university->setSort("");
				$this->subject_type->setSort("");
				$this->subject_year->setSort("");
				$this->subject_credits->setSort("");
				$this->subject_credit_hour->setSort("");
				$this->subject_faculty->setSort("");
				$this->subject_dept->setSort("");
				$this->subject_general_faculty_id->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->CssStyle = "white-space: nowrap; text-align: center; vertical-align: middle; margin: 0px;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"ew_SelectAllKey(this);\">";

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		if ($Security->IsLoggedIn())
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"" . $this->ViewUrl . "\">" . $Language->Phrase("ViewLink") . "</a>";

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"" . $this->EditUrl . "\">" . $Language->Phrase("EditLink") . "</a>";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"" . $this->CopyUrl . "\">" . $Language->Phrase("CopyLink") . "</a>";
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		if ($Security->IsLoggedIn())
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->subject_id->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(event, this);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("subject_id")) <> "")
			$this->subject_id->CurrentValue = $this->getKey("subject_id"); // subject_id
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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

			// subject_faculty
			$this->subject_faculty->LinkCustomAttributes = "";
			$this->subject_faculty->HrefValue = "";
			$this->subject_faculty->TooltipValue = "";

			// subject_dept
			$this->subject_dept->LinkCustomAttributes = "";
			$this->subject_dept->HrefValue = "";
			$this->subject_dept->TooltipValue = "";

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
		$item->Body = "<a id=\"emf_tbl_subject\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_tbl_subject',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.ftbl_subjectlist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = TRUE;

		// Hide options for export/action
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs < 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs < 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$ExportDoc = ew_ExportDocument($this, "h");
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
		$this->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
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

		// Build QueryString for search
		if ($this->BasicSearch->getKeyword() <> "") {
			$sQry .= "&" . EW_TABLE_BASIC_SEARCH . "=" . $this->BasicSearch->getKeyword() . "&" . EW_TABLE_BASIC_SEARCH_TYPE . "=" . $this->BasicSearch->getType();
		}

		// Build QueryString for pager
		$sQry .= "&" . EW_TABLE_REC_PER_PAGE . "=" . $this->getRecordsPerPage() . "&" . EW_TABLE_START_REC . "=" . $this->getStartRecordNumber();
		return $sQry;
	}

	// Add search QueryString
	function AddSearchQueryString(&$Qry, &$Fld) {
		$FldSearchValue = $Fld->AdvancedSearch->getValue("x");
		$FldParm = substr($Fld->FldVar,2);
		if (strval($FldSearchValue) <> "") {
			$Qry .= "&x_" . $FldParm . "=" . urlencode($FldSearchValue) .
				"&z_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("z"));
		}
		$FldSearchValue2 = $Fld->AdvancedSearch->getValue("y");
		if (strval($FldSearchValue2) <> "") {
			$Qry .= "&v_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("v")) .
				"&y_" . $FldParm . "=" . urlencode($FldSearchValue2) .
				"&w_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("w"));
		}
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tbl_subject_list)) $tbl_subject_list = new ctbl_subject_list();

// Page init
$tbl_subject_list->Page_Init();

// Page main
$tbl_subject_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($tbl_subject->Export == "") { ?>
<script type="text/javascript">

// Page object
var tbl_subject_list = new ew_Page("tbl_subject_list");
tbl_subject_list.PageID = "list"; // Page ID
var EW_PAGE_ID = tbl_subject_list.PageID; // For backward compatibility

// Form object
var ftbl_subjectlist = new ew_Form("ftbl_subjectlist");

// Form_CustomValidate event
ftbl_subjectlist.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_subjectlist.ValidateRequired = true;
<?php } else { ?>
ftbl_subjectlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_subjectlist.Lists["x_subject_type"] = {"LinkField":"x_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_subject_type_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_subjectlist.Lists["x_subject_faculty"] = {"LinkField":"x_faculty_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_faculty_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_subjectlist.Lists["x_subject_dept"] = {"LinkField":"x_dept_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_dept_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_subjectlist.Lists["x_subject_general_faculty_id"] = {"LinkField":"x_faculty_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_faculty_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var ftbl_subjectlistsrch = new ew_Form("ftbl_subjectlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$tbl_subject_list->TotalRecs = $tbl_subject->SelectRecordCount();
	} else {
		if ($tbl_subject_list->Recordset = $tbl_subject_list->LoadRecordset())
			$tbl_subject_list->TotalRecs = $tbl_subject_list->Recordset->RecordCount();
	}
	$tbl_subject_list->StartRec = 1;
	if ($tbl_subject_list->DisplayRecs <= 0 || ($tbl_subject->Export <> "" && $tbl_subject->ExportAll)) // Display all records
		$tbl_subject_list->DisplayRecs = $tbl_subject_list->TotalRecs;
	if (!($tbl_subject->Export <> "" && $tbl_subject->ExportAll))
		$tbl_subject_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$tbl_subject_list->Recordset = $tbl_subject_list->LoadRecordset($tbl_subject_list->StartRec-1, $tbl_subject_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_subject->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $tbl_subject_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($tbl_subject->Export == "" && $tbl_subject->CurrentAction == "") { ?>
<form name="ftbl_subjectlistsrch" id="ftbl_subjectlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<a href="javascript:ftbl_subjectlistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="ftbl_subjectlistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="ftbl_subjectlistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tbl_subject">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($tbl_subject_list->BasicSearch->getKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $tbl_subject_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_2" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($tbl_subject_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($tbl_subject_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($tbl_subject_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $tbl_subject_list->ShowPageHeader(); ?>
<?php
$tbl_subject_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($tbl_subject->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($tbl_subject->CurrentAction <> "gridadd" && $tbl_subject->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($tbl_subject_list->Pager)) $tbl_subject_list->Pager = new cPrevNextPager($tbl_subject_list->StartRec, $tbl_subject_list->DisplayRecs, $tbl_subject_list->TotalRecs) ?>
<?php if ($tbl_subject_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($tbl_subject_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_subject_list->PageUrl() ?>start=<?php echo $tbl_subject_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($tbl_subject_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_subject_list->PageUrl() ?>start=<?php echo $tbl_subject_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $tbl_subject_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($tbl_subject_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_subject_list->PageUrl() ?>start=<?php echo $tbl_subject_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($tbl_subject_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_subject_list->PageUrl() ?>start=<?php echo $tbl_subject_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $tbl_subject_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $tbl_subject_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $tbl_subject_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $tbl_subject_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($tbl_subject_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
	</td>
</tr></table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($tbl_subject_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $tbl_subject_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php if ($tbl_subject_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a class="ewGridLink" href="" onclick="ew_SubmitSelected(document.ftbl_subjectlist, '<?php echo $tbl_subject_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="ftbl_subjectlist" id="ftbl_subjectlist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="tbl_subject">
<div id="gmp_tbl_subject" class="ewGridMiddlePanel">
<?php if ($tbl_subject_list->TotalRecs > 0) { ?>
<table id="tbl_tbl_subjectlist" class="ewTable ewTableSeparate">
<?php echo $tbl_subject->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$tbl_subject_list->RenderListOptions();

// Render list options (header, left)
$tbl_subject_list->ListOptions->Render("header", "left");
?>
<?php if ($tbl_subject->subject_id->Visible) { // subject_id ?>
	<?php if ($tbl_subject->SortUrl($tbl_subject->subject_id) == "") { ?>
		<td><span id="elh_tbl_subject_subject_id" class="tbl_subject_subject_id"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject->subject_id->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject->SortUrl($tbl_subject->subject_id) ?>',1);"><span id="elh_tbl_subject_subject_id" class="tbl_subject_subject_id">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject->subject_id->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject->subject_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject->subject_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_subject->subject_name->Visible) { // subject_name ?>
	<?php if ($tbl_subject->SortUrl($tbl_subject->subject_name) == "") { ?>
		<td><span id="elh_tbl_subject_subject_name" class="tbl_subject_subject_name"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject->subject_name->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject->SortUrl($tbl_subject->subject_name) ?>',1);"><span id="elh_tbl_subject_subject_name" class="tbl_subject_subject_name">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject->subject_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject->subject_name->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject->subject_name->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_subject->subject_code->Visible) { // subject_code ?>
	<?php if ($tbl_subject->SortUrl($tbl_subject->subject_code) == "") { ?>
		<td><span id="elh_tbl_subject_subject_code" class="tbl_subject_subject_code"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject->subject_code->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject->SortUrl($tbl_subject->subject_code) ?>',1);"><span id="elh_tbl_subject_subject_code" class="tbl_subject_subject_code">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject->subject_code->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject->subject_code->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject->subject_code->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_subject->subject_active->Visible) { // subject_active ?>
	<?php if ($tbl_subject->SortUrl($tbl_subject->subject_active) == "") { ?>
		<td><span id="elh_tbl_subject_subject_active" class="tbl_subject_subject_active"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject->subject_active->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject->SortUrl($tbl_subject->subject_active) ?>',1);"><span id="elh_tbl_subject_subject_active" class="tbl_subject_subject_active">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject->subject_active->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject->subject_active->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject->subject_active->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_subject->subject_university->Visible) { // subject_university ?>
	<?php if ($tbl_subject->SortUrl($tbl_subject->subject_university) == "") { ?>
		<td><span id="elh_tbl_subject_subject_university" class="tbl_subject_subject_university"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject->subject_university->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject->SortUrl($tbl_subject->subject_university) ?>',1);"><span id="elh_tbl_subject_subject_university" class="tbl_subject_subject_university">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject->subject_university->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject->subject_university->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject->subject_university->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_subject->subject_type->Visible) { // subject_type ?>
	<?php if ($tbl_subject->SortUrl($tbl_subject->subject_type) == "") { ?>
		<td><span id="elh_tbl_subject_subject_type" class="tbl_subject_subject_type"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject->subject_type->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject->SortUrl($tbl_subject->subject_type) ?>',1);"><span id="elh_tbl_subject_subject_type" class="tbl_subject_subject_type">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject->subject_type->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject->subject_type->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject->subject_type->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_subject->subject_year->Visible) { // subject_year ?>
	<?php if ($tbl_subject->SortUrl($tbl_subject->subject_year) == "") { ?>
		<td><span id="elh_tbl_subject_subject_year" class="tbl_subject_subject_year"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject->subject_year->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject->SortUrl($tbl_subject->subject_year) ?>',1);"><span id="elh_tbl_subject_subject_year" class="tbl_subject_subject_year">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject->subject_year->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject->subject_year->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject->subject_year->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_subject->subject_credits->Visible) { // subject_credits ?>
	<?php if ($tbl_subject->SortUrl($tbl_subject->subject_credits) == "") { ?>
		<td><span id="elh_tbl_subject_subject_credits" class="tbl_subject_subject_credits"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject->subject_credits->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject->SortUrl($tbl_subject->subject_credits) ?>',1);"><span id="elh_tbl_subject_subject_credits" class="tbl_subject_subject_credits">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject->subject_credits->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject->subject_credits->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject->subject_credits->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_subject->subject_credit_hour->Visible) { // subject_credit_hour ?>
	<?php if ($tbl_subject->SortUrl($tbl_subject->subject_credit_hour) == "") { ?>
		<td><span id="elh_tbl_subject_subject_credit_hour" class="tbl_subject_subject_credit_hour"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject->subject_credit_hour->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject->SortUrl($tbl_subject->subject_credit_hour) ?>',1);"><span id="elh_tbl_subject_subject_credit_hour" class="tbl_subject_subject_credit_hour">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject->subject_credit_hour->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject->subject_credit_hour->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject->subject_credit_hour->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_subject->subject_faculty->Visible) { // subject_faculty ?>
	<?php if ($tbl_subject->SortUrl($tbl_subject->subject_faculty) == "") { ?>
		<td><span id="elh_tbl_subject_subject_faculty" class="tbl_subject_subject_faculty"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject->subject_faculty->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject->SortUrl($tbl_subject->subject_faculty) ?>',1);"><span id="elh_tbl_subject_subject_faculty" class="tbl_subject_subject_faculty">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject->subject_faculty->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject->subject_faculty->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject->subject_faculty->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_subject->subject_dept->Visible) { // subject_dept ?>
	<?php if ($tbl_subject->SortUrl($tbl_subject->subject_dept) == "") { ?>
		<td><span id="elh_tbl_subject_subject_dept" class="tbl_subject_subject_dept"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject->subject_dept->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject->SortUrl($tbl_subject->subject_dept) ?>',1);"><span id="elh_tbl_subject_subject_dept" class="tbl_subject_subject_dept">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject->subject_dept->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject->subject_dept->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject->subject_dept->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_subject->subject_general_faculty_id->Visible) { // subject_general_faculty_id ?>
	<?php if ($tbl_subject->SortUrl($tbl_subject->subject_general_faculty_id) == "") { ?>
		<td><span id="elh_tbl_subject_subject_general_faculty_id" class="tbl_subject_subject_general_faculty_id"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject->subject_general_faculty_id->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject->SortUrl($tbl_subject->subject_general_faculty_id) ?>',1);"><span id="elh_tbl_subject_subject_general_faculty_id" class="tbl_subject_subject_general_faculty_id">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject->subject_general_faculty_id->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject->subject_general_faculty_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject->subject_general_faculty_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$tbl_subject_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($tbl_subject->ExportAll && $tbl_subject->Export <> "") {
	$tbl_subject_list->StopRec = $tbl_subject_list->TotalRecs;
} else {

	// Set the last record to display
	if ($tbl_subject_list->TotalRecs > $tbl_subject_list->StartRec + $tbl_subject_list->DisplayRecs - 1)
		$tbl_subject_list->StopRec = $tbl_subject_list->StartRec + $tbl_subject_list->DisplayRecs - 1;
	else
		$tbl_subject_list->StopRec = $tbl_subject_list->TotalRecs;
}
$tbl_subject_list->RecCnt = $tbl_subject_list->StartRec - 1;
if ($tbl_subject_list->Recordset && !$tbl_subject_list->Recordset->EOF) {
	$tbl_subject_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $tbl_subject_list->StartRec > 1)
		$tbl_subject_list->Recordset->Move($tbl_subject_list->StartRec - 1);
} elseif (!$tbl_subject->AllowAddDeleteRow && $tbl_subject_list->StopRec == 0) {
	$tbl_subject_list->StopRec = $tbl_subject->GridAddRowCount;
}

// Initialize aggregate
$tbl_subject->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tbl_subject->ResetAttrs();
$tbl_subject_list->RenderRow();
while ($tbl_subject_list->RecCnt < $tbl_subject_list->StopRec) {
	$tbl_subject_list->RecCnt++;
	if (intval($tbl_subject_list->RecCnt) >= intval($tbl_subject_list->StartRec)) {
		$tbl_subject_list->RowCnt++;

		// Set up key count
		$tbl_subject_list->KeyCount = $tbl_subject_list->RowIndex;

		// Init row class and style
		$tbl_subject->ResetAttrs();
		$tbl_subject->CssClass = "";
		if ($tbl_subject->CurrentAction == "gridadd") {
		} else {
			$tbl_subject_list->LoadRowValues($tbl_subject_list->Recordset); // Load row values
		}
		$tbl_subject->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$tbl_subject->RowAttrs = array_merge($tbl_subject->RowAttrs, array('data-rowindex'=>$tbl_subject_list->RowCnt, 'id'=>'r' . $tbl_subject_list->RowCnt . '_tbl_subject', 'data-rowtype'=>$tbl_subject->RowType));

		// Render row
		$tbl_subject_list->RenderRow();

		// Render list options
		$tbl_subject_list->RenderListOptions();
?>
	<tr<?php echo $tbl_subject->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tbl_subject_list->ListOptions->Render("body", "left", $tbl_subject_list->RowCnt);
?>
	<?php if ($tbl_subject->subject_id->Visible) { // subject_id ?>
		<td<?php echo $tbl_subject->subject_id->CellAttributes() ?>><span id="el<?php echo $tbl_subject_list->RowCnt ?>_tbl_subject_subject_id" class="tbl_subject_subject_id">
<span<?php echo $tbl_subject->subject_id->ViewAttributes() ?>>
<?php echo $tbl_subject->subject_id->ListViewValue() ?></span>
</span></td>
	<?php } ?>
<a id="<?php echo $tbl_subject_list->PageObjName . "_row_" . $tbl_subject_list->RowCnt ?>"></a>
	<?php if ($tbl_subject->subject_name->Visible) { // subject_name ?>
		<td<?php echo $tbl_subject->subject_name->CellAttributes() ?>><span id="el<?php echo $tbl_subject_list->RowCnt ?>_tbl_subject_subject_name" class="tbl_subject_subject_name">
<span<?php echo $tbl_subject->subject_name->ViewAttributes() ?>>
<?php echo $tbl_subject->subject_name->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_subject->subject_code->Visible) { // subject_code ?>
		<td<?php echo $tbl_subject->subject_code->CellAttributes() ?>><span id="el<?php echo $tbl_subject_list->RowCnt ?>_tbl_subject_subject_code" class="tbl_subject_subject_code">
<span<?php echo $tbl_subject->subject_code->ViewAttributes() ?>>
<?php echo $tbl_subject->subject_code->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_subject->subject_active->Visible) { // subject_active ?>
		<td<?php echo $tbl_subject->subject_active->CellAttributes() ?>><span id="el<?php echo $tbl_subject_list->RowCnt ?>_tbl_subject_subject_active" class="tbl_subject_subject_active">
<span<?php echo $tbl_subject->subject_active->ViewAttributes() ?>>
<?php echo $tbl_subject->subject_active->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_subject->subject_university->Visible) { // subject_university ?>
		<td<?php echo $tbl_subject->subject_university->CellAttributes() ?>><span id="el<?php echo $tbl_subject_list->RowCnt ?>_tbl_subject_subject_university" class="tbl_subject_subject_university">
<span<?php echo $tbl_subject->subject_university->ViewAttributes() ?>>
<?php echo $tbl_subject->subject_university->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_subject->subject_type->Visible) { // subject_type ?>
		<td<?php echo $tbl_subject->subject_type->CellAttributes() ?>><span id="el<?php echo $tbl_subject_list->RowCnt ?>_tbl_subject_subject_type" class="tbl_subject_subject_type">
<span<?php echo $tbl_subject->subject_type->ViewAttributes() ?>>
<?php echo $tbl_subject->subject_type->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_subject->subject_year->Visible) { // subject_year ?>
		<td<?php echo $tbl_subject->subject_year->CellAttributes() ?>><span id="el<?php echo $tbl_subject_list->RowCnt ?>_tbl_subject_subject_year" class="tbl_subject_subject_year">
<span<?php echo $tbl_subject->subject_year->ViewAttributes() ?>>
<?php echo $tbl_subject->subject_year->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_subject->subject_credits->Visible) { // subject_credits ?>
		<td<?php echo $tbl_subject->subject_credits->CellAttributes() ?>><span id="el<?php echo $tbl_subject_list->RowCnt ?>_tbl_subject_subject_credits" class="tbl_subject_subject_credits">
<span<?php echo $tbl_subject->subject_credits->ViewAttributes() ?>>
<?php echo $tbl_subject->subject_credits->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_subject->subject_credit_hour->Visible) { // subject_credit_hour ?>
		<td<?php echo $tbl_subject->subject_credit_hour->CellAttributes() ?>><span id="el<?php echo $tbl_subject_list->RowCnt ?>_tbl_subject_subject_credit_hour" class="tbl_subject_subject_credit_hour">
<span<?php echo $tbl_subject->subject_credit_hour->ViewAttributes() ?>>
<?php echo $tbl_subject->subject_credit_hour->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_subject->subject_faculty->Visible) { // subject_faculty ?>
		<td<?php echo $tbl_subject->subject_faculty->CellAttributes() ?>><span id="el<?php echo $tbl_subject_list->RowCnt ?>_tbl_subject_subject_faculty" class="tbl_subject_subject_faculty">
<span<?php echo $tbl_subject->subject_faculty->ViewAttributes() ?>>
<?php echo $tbl_subject->subject_faculty->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_subject->subject_dept->Visible) { // subject_dept ?>
		<td<?php echo $tbl_subject->subject_dept->CellAttributes() ?>><span id="el<?php echo $tbl_subject_list->RowCnt ?>_tbl_subject_subject_dept" class="tbl_subject_subject_dept">
<span<?php echo $tbl_subject->subject_dept->ViewAttributes() ?>>
<?php echo $tbl_subject->subject_dept->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_subject->subject_general_faculty_id->Visible) { // subject_general_faculty_id ?>
		<td<?php echo $tbl_subject->subject_general_faculty_id->CellAttributes() ?>><span id="el<?php echo $tbl_subject_list->RowCnt ?>_tbl_subject_subject_general_faculty_id" class="tbl_subject_subject_general_faculty_id">
<span<?php echo $tbl_subject->subject_general_faculty_id->ViewAttributes() ?>>
<?php echo $tbl_subject->subject_general_faculty_id->ListViewValue() ?></span>
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$tbl_subject_list->ListOptions->Render("body", "right", $tbl_subject_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($tbl_subject->CurrentAction <> "gridadd")
		$tbl_subject_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($tbl_subject->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($tbl_subject_list->Recordset)
	$tbl_subject_list->Recordset->Close();
?>
</td></tr></table>
<?php if ($tbl_subject->Export == "") { ?>
<script type="text/javascript">
ftbl_subjectlistsrch.Init();
ftbl_subjectlist.Init();
</script>
<?php } ?>
<?php
$tbl_subject_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($tbl_subject->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$tbl_subject_list->Page_Terminate();
?>
