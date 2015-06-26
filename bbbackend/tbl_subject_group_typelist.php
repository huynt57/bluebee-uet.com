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

$tbl_subject_group_type_list = NULL; // Initialize page object first

class ctbl_subject_group_type_list extends ctbl_subject_group_type {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_subject_group_type';

	// Page object name
	var $PageObjName = 'tbl_subject_group_type_list';

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

		// Table object (tbl_subject_group_type)
		if (!isset($GLOBALS["tbl_subject_group_type"])) {
			$GLOBALS["tbl_subject_group_type"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_subject_group_type"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "tbl_subject_group_typeadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "tbl_subject_group_typedelete.php";
		$this->MultiUpdateUrl = "tbl_subject_group_typeupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_subject_group_type', TRUE);

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
		$this->subject_type_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
			$this->subject_type_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->subject_type_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->subject_group_type, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->detail, $Keyword);
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
			$this->UpdateSort($this->subject_type_id); // subject_type_id
			$this->UpdateSort($this->subject_group_type); // subject_group_type
			$this->UpdateSort($this->active); // active
			$this->UpdateSort($this->subject_group); // subject_group
			$this->UpdateSort($this->subject_dept); // subject_dept
			$this->UpdateSort($this->subject_faculty); // subject_faculty
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
				$this->subject_type_id->setSort("");
				$this->subject_group_type->setSort("");
				$this->active->setSort("");
				$this->subject_group->setSort("");
				$this->subject_dept->setSort("");
				$this->subject_faculty->setSort("");
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
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->subject_type_id->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(event, this);'>";
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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

			// subject_type_id
			$this->subject_type_id->LinkCustomAttributes = "";
			$this->subject_type_id->HrefValue = "";
			$this->subject_type_id->TooltipValue = "";

			// subject_group_type
			$this->subject_group_type->LinkCustomAttributes = "";
			$this->subject_group_type->HrefValue = "";
			$this->subject_group_type->TooltipValue = "";

			// active
			$this->active->LinkCustomAttributes = "";
			$this->active->HrefValue = "";
			$this->active->TooltipValue = "";

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
		$item->Body = "<a id=\"emf_tbl_subject_group_type\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_tbl_subject_group_type',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.ftbl_subject_group_typelist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
if (!isset($tbl_subject_group_type_list)) $tbl_subject_group_type_list = new ctbl_subject_group_type_list();

// Page init
$tbl_subject_group_type_list->Page_Init();

// Page main
$tbl_subject_group_type_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($tbl_subject_group_type->Export == "") { ?>
<script type="text/javascript">

// Page object
var tbl_subject_group_type_list = new ew_Page("tbl_subject_group_type_list");
tbl_subject_group_type_list.PageID = "list"; // Page ID
var EW_PAGE_ID = tbl_subject_group_type_list.PageID; // For backward compatibility

// Form object
var ftbl_subject_group_typelist = new ew_Form("ftbl_subject_group_typelist");

// Form_CustomValidate event
ftbl_subject_group_typelist.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_subject_group_typelist.ValidateRequired = true;
<?php } else { ?>
ftbl_subject_group_typelist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_subject_group_typelist.Lists["x_subject_group"] = {"LinkField":"x_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_subject_group_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_subject_group_typelist.Lists["x_subject_dept"] = {"LinkField":"x_dept_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_dept_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_subject_group_typelist.Lists["x_subject_faculty"] = {"LinkField":"x_faculty_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_faculty_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var ftbl_subject_group_typelistsrch = new ew_Form("ftbl_subject_group_typelistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$tbl_subject_group_type_list->TotalRecs = $tbl_subject_group_type->SelectRecordCount();
	} else {
		if ($tbl_subject_group_type_list->Recordset = $tbl_subject_group_type_list->LoadRecordset())
			$tbl_subject_group_type_list->TotalRecs = $tbl_subject_group_type_list->Recordset->RecordCount();
	}
	$tbl_subject_group_type_list->StartRec = 1;
	if ($tbl_subject_group_type_list->DisplayRecs <= 0 || ($tbl_subject_group_type->Export <> "" && $tbl_subject_group_type->ExportAll)) // Display all records
		$tbl_subject_group_type_list->DisplayRecs = $tbl_subject_group_type_list->TotalRecs;
	if (!($tbl_subject_group_type->Export <> "" && $tbl_subject_group_type->ExportAll))
		$tbl_subject_group_type_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$tbl_subject_group_type_list->Recordset = $tbl_subject_group_type_list->LoadRecordset($tbl_subject_group_type_list->StartRec-1, $tbl_subject_group_type_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_subject_group_type->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $tbl_subject_group_type_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($tbl_subject_group_type->Export == "" && $tbl_subject_group_type->CurrentAction == "") { ?>
<form name="ftbl_subject_group_typelistsrch" id="ftbl_subject_group_typelistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<a href="javascript:ftbl_subject_group_typelistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="ftbl_subject_group_typelistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="ftbl_subject_group_typelistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tbl_subject_group_type">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($tbl_subject_group_type_list->BasicSearch->getKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $tbl_subject_group_type_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_2" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($tbl_subject_group_type_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($tbl_subject_group_type_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($tbl_subject_group_type_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $tbl_subject_group_type_list->ShowPageHeader(); ?>
<?php
$tbl_subject_group_type_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($tbl_subject_group_type->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($tbl_subject_group_type->CurrentAction <> "gridadd" && $tbl_subject_group_type->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($tbl_subject_group_type_list->Pager)) $tbl_subject_group_type_list->Pager = new cPrevNextPager($tbl_subject_group_type_list->StartRec, $tbl_subject_group_type_list->DisplayRecs, $tbl_subject_group_type_list->TotalRecs) ?>
<?php if ($tbl_subject_group_type_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($tbl_subject_group_type_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_subject_group_type_list->PageUrl() ?>start=<?php echo $tbl_subject_group_type_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($tbl_subject_group_type_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_subject_group_type_list->PageUrl() ?>start=<?php echo $tbl_subject_group_type_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $tbl_subject_group_type_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($tbl_subject_group_type_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_subject_group_type_list->PageUrl() ?>start=<?php echo $tbl_subject_group_type_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($tbl_subject_group_type_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_subject_group_type_list->PageUrl() ?>start=<?php echo $tbl_subject_group_type_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $tbl_subject_group_type_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $tbl_subject_group_type_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $tbl_subject_group_type_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $tbl_subject_group_type_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($tbl_subject_group_type_list->SearchWhere == "0=101") { ?>
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
<?php if ($tbl_subject_group_type_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $tbl_subject_group_type_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php if ($tbl_subject_group_type_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a class="ewGridLink" href="" onclick="ew_SubmitSelected(document.ftbl_subject_group_typelist, '<?php echo $tbl_subject_group_type_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="ftbl_subject_group_typelist" id="ftbl_subject_group_typelist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="tbl_subject_group_type">
<div id="gmp_tbl_subject_group_type" class="ewGridMiddlePanel">
<?php if ($tbl_subject_group_type_list->TotalRecs > 0) { ?>
<table id="tbl_tbl_subject_group_typelist" class="ewTable ewTableSeparate">
<?php echo $tbl_subject_group_type->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$tbl_subject_group_type_list->RenderListOptions();

// Render list options (header, left)
$tbl_subject_group_type_list->ListOptions->Render("header", "left");
?>
<?php if ($tbl_subject_group_type->subject_type_id->Visible) { // subject_type_id ?>
	<?php if ($tbl_subject_group_type->SortUrl($tbl_subject_group_type->subject_type_id) == "") { ?>
		<td><span id="elh_tbl_subject_group_type_subject_type_id" class="tbl_subject_group_type_subject_type_id"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject_group_type->subject_type_id->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject_group_type->SortUrl($tbl_subject_group_type->subject_type_id) ?>',1);"><span id="elh_tbl_subject_group_type_subject_type_id" class="tbl_subject_group_type_subject_type_id">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject_group_type->subject_type_id->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject_group_type->subject_type_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject_group_type->subject_type_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_subject_group_type->subject_group_type->Visible) { // subject_group_type ?>
	<?php if ($tbl_subject_group_type->SortUrl($tbl_subject_group_type->subject_group_type) == "") { ?>
		<td><span id="elh_tbl_subject_group_type_subject_group_type" class="tbl_subject_group_type_subject_group_type"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject_group_type->subject_group_type->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject_group_type->SortUrl($tbl_subject_group_type->subject_group_type) ?>',1);"><span id="elh_tbl_subject_group_type_subject_group_type" class="tbl_subject_group_type_subject_group_type">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject_group_type->subject_group_type->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject_group_type->subject_group_type->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject_group_type->subject_group_type->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_subject_group_type->active->Visible) { // active ?>
	<?php if ($tbl_subject_group_type->SortUrl($tbl_subject_group_type->active) == "") { ?>
		<td><span id="elh_tbl_subject_group_type_active" class="tbl_subject_group_type_active"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject_group_type->active->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject_group_type->SortUrl($tbl_subject_group_type->active) ?>',1);"><span id="elh_tbl_subject_group_type_active" class="tbl_subject_group_type_active">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject_group_type->active->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject_group_type->active->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject_group_type->active->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_subject_group_type->subject_group->Visible) { // subject_group ?>
	<?php if ($tbl_subject_group_type->SortUrl($tbl_subject_group_type->subject_group) == "") { ?>
		<td><span id="elh_tbl_subject_group_type_subject_group" class="tbl_subject_group_type_subject_group"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject_group_type->subject_group->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject_group_type->SortUrl($tbl_subject_group_type->subject_group) ?>',1);"><span id="elh_tbl_subject_group_type_subject_group" class="tbl_subject_group_type_subject_group">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject_group_type->subject_group->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject_group_type->subject_group->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject_group_type->subject_group->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_subject_group_type->subject_dept->Visible) { // subject_dept ?>
	<?php if ($tbl_subject_group_type->SortUrl($tbl_subject_group_type->subject_dept) == "") { ?>
		<td><span id="elh_tbl_subject_group_type_subject_dept" class="tbl_subject_group_type_subject_dept"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject_group_type->subject_dept->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject_group_type->SortUrl($tbl_subject_group_type->subject_dept) ?>',1);"><span id="elh_tbl_subject_group_type_subject_dept" class="tbl_subject_group_type_subject_dept">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject_group_type->subject_dept->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject_group_type->subject_dept->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject_group_type->subject_dept->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_subject_group_type->subject_faculty->Visible) { // subject_faculty ?>
	<?php if ($tbl_subject_group_type->SortUrl($tbl_subject_group_type->subject_faculty) == "") { ?>
		<td><span id="elh_tbl_subject_group_type_subject_faculty" class="tbl_subject_group_type_subject_faculty"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_subject_group_type->subject_faculty->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_subject_group_type->SortUrl($tbl_subject_group_type->subject_faculty) ?>',1);"><span id="elh_tbl_subject_group_type_subject_faculty" class="tbl_subject_group_type_subject_faculty">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_subject_group_type->subject_faculty->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_subject_group_type->subject_faculty->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_subject_group_type->subject_faculty->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$tbl_subject_group_type_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($tbl_subject_group_type->ExportAll && $tbl_subject_group_type->Export <> "") {
	$tbl_subject_group_type_list->StopRec = $tbl_subject_group_type_list->TotalRecs;
} else {

	// Set the last record to display
	if ($tbl_subject_group_type_list->TotalRecs > $tbl_subject_group_type_list->StartRec + $tbl_subject_group_type_list->DisplayRecs - 1)
		$tbl_subject_group_type_list->StopRec = $tbl_subject_group_type_list->StartRec + $tbl_subject_group_type_list->DisplayRecs - 1;
	else
		$tbl_subject_group_type_list->StopRec = $tbl_subject_group_type_list->TotalRecs;
}
$tbl_subject_group_type_list->RecCnt = $tbl_subject_group_type_list->StartRec - 1;
if ($tbl_subject_group_type_list->Recordset && !$tbl_subject_group_type_list->Recordset->EOF) {
	$tbl_subject_group_type_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $tbl_subject_group_type_list->StartRec > 1)
		$tbl_subject_group_type_list->Recordset->Move($tbl_subject_group_type_list->StartRec - 1);
} elseif (!$tbl_subject_group_type->AllowAddDeleteRow && $tbl_subject_group_type_list->StopRec == 0) {
	$tbl_subject_group_type_list->StopRec = $tbl_subject_group_type->GridAddRowCount;
}

// Initialize aggregate
$tbl_subject_group_type->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tbl_subject_group_type->ResetAttrs();
$tbl_subject_group_type_list->RenderRow();
while ($tbl_subject_group_type_list->RecCnt < $tbl_subject_group_type_list->StopRec) {
	$tbl_subject_group_type_list->RecCnt++;
	if (intval($tbl_subject_group_type_list->RecCnt) >= intval($tbl_subject_group_type_list->StartRec)) {
		$tbl_subject_group_type_list->RowCnt++;

		// Set up key count
		$tbl_subject_group_type_list->KeyCount = $tbl_subject_group_type_list->RowIndex;

		// Init row class and style
		$tbl_subject_group_type->ResetAttrs();
		$tbl_subject_group_type->CssClass = "";
		if ($tbl_subject_group_type->CurrentAction == "gridadd") {
		} else {
			$tbl_subject_group_type_list->LoadRowValues($tbl_subject_group_type_list->Recordset); // Load row values
		}
		$tbl_subject_group_type->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$tbl_subject_group_type->RowAttrs = array_merge($tbl_subject_group_type->RowAttrs, array('data-rowindex'=>$tbl_subject_group_type_list->RowCnt, 'id'=>'r' . $tbl_subject_group_type_list->RowCnt . '_tbl_subject_group_type', 'data-rowtype'=>$tbl_subject_group_type->RowType));

		// Render row
		$tbl_subject_group_type_list->RenderRow();

		// Render list options
		$tbl_subject_group_type_list->RenderListOptions();
?>
	<tr<?php echo $tbl_subject_group_type->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tbl_subject_group_type_list->ListOptions->Render("body", "left", $tbl_subject_group_type_list->RowCnt);
?>
	<?php if ($tbl_subject_group_type->subject_type_id->Visible) { // subject_type_id ?>
		<td<?php echo $tbl_subject_group_type->subject_type_id->CellAttributes() ?>><span id="el<?php echo $tbl_subject_group_type_list->RowCnt ?>_tbl_subject_group_type_subject_type_id" class="tbl_subject_group_type_subject_type_id">
<span<?php echo $tbl_subject_group_type->subject_type_id->ViewAttributes() ?>>
<?php echo $tbl_subject_group_type->subject_type_id->ListViewValue() ?></span>
</span></td>
	<?php } ?>
<a id="<?php echo $tbl_subject_group_type_list->PageObjName . "_row_" . $tbl_subject_group_type_list->RowCnt ?>"></a>
	<?php if ($tbl_subject_group_type->subject_group_type->Visible) { // subject_group_type ?>
		<td<?php echo $tbl_subject_group_type->subject_group_type->CellAttributes() ?>><span id="el<?php echo $tbl_subject_group_type_list->RowCnt ?>_tbl_subject_group_type_subject_group_type" class="tbl_subject_group_type_subject_group_type">
<span<?php echo $tbl_subject_group_type->subject_group_type->ViewAttributes() ?>>
<?php echo $tbl_subject_group_type->subject_group_type->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_subject_group_type->active->Visible) { // active ?>
		<td<?php echo $tbl_subject_group_type->active->CellAttributes() ?>><span id="el<?php echo $tbl_subject_group_type_list->RowCnt ?>_tbl_subject_group_type_active" class="tbl_subject_group_type_active">
<span<?php echo $tbl_subject_group_type->active->ViewAttributes() ?>>
<?php echo $tbl_subject_group_type->active->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_subject_group_type->subject_group->Visible) { // subject_group ?>
		<td<?php echo $tbl_subject_group_type->subject_group->CellAttributes() ?>><span id="el<?php echo $tbl_subject_group_type_list->RowCnt ?>_tbl_subject_group_type_subject_group" class="tbl_subject_group_type_subject_group">
<span<?php echo $tbl_subject_group_type->subject_group->ViewAttributes() ?>>
<?php echo $tbl_subject_group_type->subject_group->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_subject_group_type->subject_dept->Visible) { // subject_dept ?>
		<td<?php echo $tbl_subject_group_type->subject_dept->CellAttributes() ?>><span id="el<?php echo $tbl_subject_group_type_list->RowCnt ?>_tbl_subject_group_type_subject_dept" class="tbl_subject_group_type_subject_dept">
<span<?php echo $tbl_subject_group_type->subject_dept->ViewAttributes() ?>>
<?php echo $tbl_subject_group_type->subject_dept->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_subject_group_type->subject_faculty->Visible) { // subject_faculty ?>
		<td<?php echo $tbl_subject_group_type->subject_faculty->CellAttributes() ?>><span id="el<?php echo $tbl_subject_group_type_list->RowCnt ?>_tbl_subject_group_type_subject_faculty" class="tbl_subject_group_type_subject_faculty">
<span<?php echo $tbl_subject_group_type->subject_faculty->ViewAttributes() ?>>
<?php echo $tbl_subject_group_type->subject_faculty->ListViewValue() ?></span>
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$tbl_subject_group_type_list->ListOptions->Render("body", "right", $tbl_subject_group_type_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($tbl_subject_group_type->CurrentAction <> "gridadd")
		$tbl_subject_group_type_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($tbl_subject_group_type->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($tbl_subject_group_type_list->Recordset)
	$tbl_subject_group_type_list->Recordset->Close();
?>
</td></tr></table>
<?php if ($tbl_subject_group_type->Export == "") { ?>
<script type="text/javascript">
ftbl_subject_group_typelistsrch.Init();
ftbl_subject_group_typelist.Init();
</script>
<?php } ?>
<?php
$tbl_subject_group_type_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($tbl_subject_group_type->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$tbl_subject_group_type_list->Page_Terminate();
?>
