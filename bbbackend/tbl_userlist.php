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

$tbl_user_list = NULL; // Initialize page object first

class ctbl_user_list extends ctbl_user {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_user';

	// Page object name
	var $PageObjName = 'tbl_user_list';

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "tbl_useradd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "tbl_userdelete.php";
		$this->MultiUpdateUrl = "tbl_userupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_user', TRUE);

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
			$this->user_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->user_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->user_id_fb, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->username, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->password, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->user_real_name, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->user_avatar, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->user_cover, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->user_student_code, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->user_gender, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->user_dob, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->user_hometown, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->user_phone, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->user_description, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->user_token, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->user_activator, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->user_qoutes, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->user_date_attend, $Keyword);
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
			$this->UpdateSort($this->user_id); // user_id
			$this->UpdateSort($this->user_id_fb); // user_id_fb
			$this->UpdateSort($this->username); // username
			$this->UpdateSort($this->password); // password
			$this->UpdateSort($this->user_real_name); // user_real_name
			$this->UpdateSort($this->user_avatar); // user_avatar
			$this->UpdateSort($this->user_cover); // user_cover
			$this->UpdateSort($this->user_student_code); // user_student_code
			$this->UpdateSort($this->user_university); // user_university
			$this->UpdateSort($this->user_gender); // user_gender
			$this->UpdateSort($this->user_dob); // user_dob
			$this->UpdateSort($this->user_hometown); // user_hometown
			$this->UpdateSort($this->user_phone); // user_phone
			$this->UpdateSort($this->user_description); // user_description
			$this->UpdateSort($this->user_faculty); // user_faculty
			$this->UpdateSort($this->user_class); // user_class
			$this->UpdateSort($this->user_active); // user_active
			$this->UpdateSort($this->user_status); // user_status
			$this->UpdateSort($this->user_group); // user_group
			$this->UpdateSort($this->user_token); // user_token
			$this->UpdateSort($this->user_activator); // user_activator
			$this->UpdateSort($this->user_date_attend); // user_date_attend
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
				$this->user_id->setSort("");
				$this->user_id_fb->setSort("");
				$this->username->setSort("");
				$this->password->setSort("");
				$this->user_real_name->setSort("");
				$this->user_avatar->setSort("");
				$this->user_cover->setSort("");
				$this->user_student_code->setSort("");
				$this->user_university->setSort("");
				$this->user_gender->setSort("");
				$this->user_dob->setSort("");
				$this->user_hometown->setSort("");
				$this->user_phone->setSort("");
				$this->user_description->setSort("");
				$this->user_faculty->setSort("");
				$this->user_class->setSort("");
				$this->user_active->setSort("");
				$this->user_status->setSort("");
				$this->user_group->setSort("");
				$this->user_token->setSort("");
				$this->user_activator->setSort("");
				$this->user_date_attend->setSort("");
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
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->user_id->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(event, this);'>";
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("user_id")) <> "")
			$this->user_id->CurrentValue = $this->getKey("user_id"); // user_id
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
		$item->Body = "<a id=\"emf_tbl_user\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_tbl_user',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.ftbl_userlist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
if (!isset($tbl_user_list)) $tbl_user_list = new ctbl_user_list();

// Page init
$tbl_user_list->Page_Init();

// Page main
$tbl_user_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($tbl_user->Export == "") { ?>
<script type="text/javascript">

// Page object
var tbl_user_list = new ew_Page("tbl_user_list");
tbl_user_list.PageID = "list"; // Page ID
var EW_PAGE_ID = tbl_user_list.PageID; // For backward compatibility

// Form object
var ftbl_userlist = new ew_Form("ftbl_userlist");

// Form_CustomValidate event
ftbl_userlist.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_userlist.ValidateRequired = true;
<?php } else { ?>
ftbl_userlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var ftbl_userlistsrch = new ew_Form("ftbl_userlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$tbl_user_list->TotalRecs = $tbl_user->SelectRecordCount();
	} else {
		if ($tbl_user_list->Recordset = $tbl_user_list->LoadRecordset())
			$tbl_user_list->TotalRecs = $tbl_user_list->Recordset->RecordCount();
	}
	$tbl_user_list->StartRec = 1;
	if ($tbl_user_list->DisplayRecs <= 0 || ($tbl_user->Export <> "" && $tbl_user->ExportAll)) // Display all records
		$tbl_user_list->DisplayRecs = $tbl_user_list->TotalRecs;
	if (!($tbl_user->Export <> "" && $tbl_user->ExportAll))
		$tbl_user_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$tbl_user_list->Recordset = $tbl_user_list->LoadRecordset($tbl_user_list->StartRec-1, $tbl_user_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_user->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $tbl_user_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($tbl_user->Export == "" && $tbl_user->CurrentAction == "") { ?>
<form name="ftbl_userlistsrch" id="ftbl_userlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<a href="javascript:ftbl_userlistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="ftbl_userlistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" style="border: 0;"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="ftbl_userlistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tbl_user">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($tbl_user_list->BasicSearch->getKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $tbl_user_list->PageUrl() ?>cmd=reset" id="a_ShowAll" class="ewLink"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_2" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($tbl_user_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($tbl_user_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($tbl_user_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $tbl_user_list->ShowPageHeader(); ?>
<?php
$tbl_user_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($tbl_user->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($tbl_user->CurrentAction <> "gridadd" && $tbl_user->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager"><tr><td>
<?php if (!isset($tbl_user_list->Pager)) $tbl_user_list->Pager = new cPrevNextPager($tbl_user_list->StartRec, $tbl_user_list->DisplayRecs, $tbl_user_list->TotalRecs) ?>
<?php if ($tbl_user_list->Pager->RecordCount > 0) { ?>
	<table cellspacing="0" class="ewStdTable"><tbody><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($tbl_user_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_user_list->PageUrl() ?>start=<?php echo $tbl_user_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($tbl_user_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_user_list->PageUrl() ?>start=<?php echo $tbl_user_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $tbl_user_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($tbl_user_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_user_list->PageUrl() ?>start=<?php echo $tbl_user_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($tbl_user_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $tbl_user_list->PageUrl() ?>start=<?php echo $tbl_user_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" style="border: 0;"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $tbl_user_list->Pager->PageCount ?></span></td>
	</tr></tbody></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $tbl_user_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $tbl_user_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $tbl_user_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($tbl_user_list->SearchWhere == "0=101") { ?>
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
<?php if ($tbl_user_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $tbl_user_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php if ($tbl_user_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a class="ewGridLink" href="" onclick="ew_SubmitSelected(document.ftbl_userlist, '<?php echo $tbl_user_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="ftbl_userlist" id="ftbl_userlist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="tbl_user">
<div id="gmp_tbl_user" class="ewGridMiddlePanel">
<?php if ($tbl_user_list->TotalRecs > 0) { ?>
<table id="tbl_tbl_userlist" class="ewTable ewTableSeparate">
<?php echo $tbl_user->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$tbl_user_list->RenderListOptions();

// Render list options (header, left)
$tbl_user_list->ListOptions->Render("header", "left");
?>
<?php if ($tbl_user->user_id->Visible) { // user_id ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_id) == "") { ?>
		<td><span id="elh_tbl_user_user_id" class="tbl_user_user_id"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_id->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_id) ?>',1);"><span id="elh_tbl_user_user_id" class="tbl_user_user_id">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_id->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_id_fb->Visible) { // user_id_fb ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_id_fb) == "") { ?>
		<td><span id="elh_tbl_user_user_id_fb" class="tbl_user_user_id_fb"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_id_fb->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_id_fb) ?>',1);"><span id="elh_tbl_user_user_id_fb" class="tbl_user_user_id_fb">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_id_fb->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_id_fb->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_id_fb->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->username->Visible) { // username ?>
	<?php if ($tbl_user->SortUrl($tbl_user->username) == "") { ?>
		<td><span id="elh_tbl_user_username" class="tbl_user_username"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->username->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->username) ?>',1);"><span id="elh_tbl_user_username" class="tbl_user_username">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->username->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->username->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->username->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->password->Visible) { // password ?>
	<?php if ($tbl_user->SortUrl($tbl_user->password) == "") { ?>
		<td><span id="elh_tbl_user_password" class="tbl_user_password"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->password->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->password) ?>',1);"><span id="elh_tbl_user_password" class="tbl_user_password">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->password->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->password->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->password->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_real_name->Visible) { // user_real_name ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_real_name) == "") { ?>
		<td><span id="elh_tbl_user_user_real_name" class="tbl_user_user_real_name"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_real_name->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_real_name) ?>',1);"><span id="elh_tbl_user_user_real_name" class="tbl_user_user_real_name">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_real_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_real_name->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_real_name->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_avatar->Visible) { // user_avatar ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_avatar) == "") { ?>
		<td><span id="elh_tbl_user_user_avatar" class="tbl_user_user_avatar"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_avatar->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_avatar) ?>',1);"><span id="elh_tbl_user_user_avatar" class="tbl_user_user_avatar">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_avatar->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_avatar->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_avatar->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_cover->Visible) { // user_cover ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_cover) == "") { ?>
		<td><span id="elh_tbl_user_user_cover" class="tbl_user_user_cover"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_cover->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_cover) ?>',1);"><span id="elh_tbl_user_user_cover" class="tbl_user_user_cover">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_cover->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_cover->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_cover->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_student_code->Visible) { // user_student_code ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_student_code) == "") { ?>
		<td><span id="elh_tbl_user_user_student_code" class="tbl_user_user_student_code"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_student_code->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_student_code) ?>',1);"><span id="elh_tbl_user_user_student_code" class="tbl_user_user_student_code">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_student_code->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_student_code->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_student_code->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_university->Visible) { // user_university ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_university) == "") { ?>
		<td><span id="elh_tbl_user_user_university" class="tbl_user_user_university"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_university->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_university) ?>',1);"><span id="elh_tbl_user_user_university" class="tbl_user_user_university">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_university->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_university->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_university->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_gender->Visible) { // user_gender ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_gender) == "") { ?>
		<td><span id="elh_tbl_user_user_gender" class="tbl_user_user_gender"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_gender->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_gender) ?>',1);"><span id="elh_tbl_user_user_gender" class="tbl_user_user_gender">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_gender->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_gender->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_gender->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_dob->Visible) { // user_dob ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_dob) == "") { ?>
		<td><span id="elh_tbl_user_user_dob" class="tbl_user_user_dob"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_dob->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_dob) ?>',1);"><span id="elh_tbl_user_user_dob" class="tbl_user_user_dob">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_dob->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_dob->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_dob->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_hometown->Visible) { // user_hometown ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_hometown) == "") { ?>
		<td><span id="elh_tbl_user_user_hometown" class="tbl_user_user_hometown"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_hometown->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_hometown) ?>',1);"><span id="elh_tbl_user_user_hometown" class="tbl_user_user_hometown">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_hometown->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_hometown->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_hometown->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_phone->Visible) { // user_phone ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_phone) == "") { ?>
		<td><span id="elh_tbl_user_user_phone" class="tbl_user_user_phone"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_phone->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_phone) ?>',1);"><span id="elh_tbl_user_user_phone" class="tbl_user_user_phone">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_phone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_phone->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_phone->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_description->Visible) { // user_description ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_description) == "") { ?>
		<td><span id="elh_tbl_user_user_description" class="tbl_user_user_description"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_description->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_description) ?>',1);"><span id="elh_tbl_user_user_description" class="tbl_user_user_description">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_description->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_description->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_description->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_faculty->Visible) { // user_faculty ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_faculty) == "") { ?>
		<td><span id="elh_tbl_user_user_faculty" class="tbl_user_user_faculty"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_faculty->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_faculty) ?>',1);"><span id="elh_tbl_user_user_faculty" class="tbl_user_user_faculty">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_faculty->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_faculty->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_faculty->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_class->Visible) { // user_class ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_class) == "") { ?>
		<td><span id="elh_tbl_user_user_class" class="tbl_user_user_class"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_class->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_class) ?>',1);"><span id="elh_tbl_user_user_class" class="tbl_user_user_class">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_class->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_class->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_class->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_active->Visible) { // user_active ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_active) == "") { ?>
		<td><span id="elh_tbl_user_user_active" class="tbl_user_user_active"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_active->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_active) ?>',1);"><span id="elh_tbl_user_user_active" class="tbl_user_user_active">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_active->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_active->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_active->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_status->Visible) { // user_status ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_status) == "") { ?>
		<td><span id="elh_tbl_user_user_status" class="tbl_user_user_status"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_status->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_status) ?>',1);"><span id="elh_tbl_user_user_status" class="tbl_user_user_status">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_status->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_status->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_status->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_group->Visible) { // user_group ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_group) == "") { ?>
		<td><span id="elh_tbl_user_user_group" class="tbl_user_user_group"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_group->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_group) ?>',1);"><span id="elh_tbl_user_user_group" class="tbl_user_user_group">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_group->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_group->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_group->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_token->Visible) { // user_token ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_token) == "") { ?>
		<td><span id="elh_tbl_user_user_token" class="tbl_user_user_token"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_token->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_token) ?>',1);"><span id="elh_tbl_user_user_token" class="tbl_user_user_token">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_token->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_token->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_token->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_activator->Visible) { // user_activator ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_activator) == "") { ?>
		<td><span id="elh_tbl_user_user_activator" class="tbl_user_user_activator"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_activator->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_activator) ?>',1);"><span id="elh_tbl_user_user_activator" class="tbl_user_user_activator">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_activator->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_activator->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_activator->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($tbl_user->user_date_attend->Visible) { // user_date_attend ?>
	<?php if ($tbl_user->SortUrl($tbl_user->user_date_attend) == "") { ?>
		<td><span id="elh_tbl_user_user_date_attend" class="tbl_user_user_date_attend"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $tbl_user->user_date_attend->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div onmousedown="ew_Sort(event,'<?php echo $tbl_user->SortUrl($tbl_user->user_date_attend) ?>',1);"><span id="elh_tbl_user_user_date_attend" class="tbl_user_user_date_attend">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $tbl_user->user_date_attend->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td class="ewTableHeaderSort"><?php if ($tbl_user->user_date_attend->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($tbl_user->user_date_attend->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$tbl_user_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($tbl_user->ExportAll && $tbl_user->Export <> "") {
	$tbl_user_list->StopRec = $tbl_user_list->TotalRecs;
} else {

	// Set the last record to display
	if ($tbl_user_list->TotalRecs > $tbl_user_list->StartRec + $tbl_user_list->DisplayRecs - 1)
		$tbl_user_list->StopRec = $tbl_user_list->StartRec + $tbl_user_list->DisplayRecs - 1;
	else
		$tbl_user_list->StopRec = $tbl_user_list->TotalRecs;
}
$tbl_user_list->RecCnt = $tbl_user_list->StartRec - 1;
if ($tbl_user_list->Recordset && !$tbl_user_list->Recordset->EOF) {
	$tbl_user_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $tbl_user_list->StartRec > 1)
		$tbl_user_list->Recordset->Move($tbl_user_list->StartRec - 1);
} elseif (!$tbl_user->AllowAddDeleteRow && $tbl_user_list->StopRec == 0) {
	$tbl_user_list->StopRec = $tbl_user->GridAddRowCount;
}

// Initialize aggregate
$tbl_user->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tbl_user->ResetAttrs();
$tbl_user_list->RenderRow();
while ($tbl_user_list->RecCnt < $tbl_user_list->StopRec) {
	$tbl_user_list->RecCnt++;
	if (intval($tbl_user_list->RecCnt) >= intval($tbl_user_list->StartRec)) {
		$tbl_user_list->RowCnt++;

		// Set up key count
		$tbl_user_list->KeyCount = $tbl_user_list->RowIndex;

		// Init row class and style
		$tbl_user->ResetAttrs();
		$tbl_user->CssClass = "";
		if ($tbl_user->CurrentAction == "gridadd") {
		} else {
			$tbl_user_list->LoadRowValues($tbl_user_list->Recordset); // Load row values
		}
		$tbl_user->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$tbl_user->RowAttrs = array_merge($tbl_user->RowAttrs, array('data-rowindex'=>$tbl_user_list->RowCnt, 'id'=>'r' . $tbl_user_list->RowCnt . '_tbl_user', 'data-rowtype'=>$tbl_user->RowType));

		// Render row
		$tbl_user_list->RenderRow();

		// Render list options
		$tbl_user_list->RenderListOptions();
?>
	<tr<?php echo $tbl_user->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tbl_user_list->ListOptions->Render("body", "left", $tbl_user_list->RowCnt);
?>
	<?php if ($tbl_user->user_id->Visible) { // user_id ?>
		<td<?php echo $tbl_user->user_id->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_id" class="tbl_user_user_id">
<span<?php echo $tbl_user->user_id->ViewAttributes() ?>>
<?php echo $tbl_user->user_id->ListViewValue() ?></span>
</span></td>
	<?php } ?>
<a id="<?php echo $tbl_user_list->PageObjName . "_row_" . $tbl_user_list->RowCnt ?>"></a>
	<?php if ($tbl_user->user_id_fb->Visible) { // user_id_fb ?>
		<td<?php echo $tbl_user->user_id_fb->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_id_fb" class="tbl_user_user_id_fb">
<span<?php echo $tbl_user->user_id_fb->ViewAttributes() ?>>
<?php echo $tbl_user->user_id_fb->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->username->Visible) { // username ?>
		<td<?php echo $tbl_user->username->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_username" class="tbl_user_username">
<span<?php echo $tbl_user->username->ViewAttributes() ?>>
<?php echo $tbl_user->username->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->password->Visible) { // password ?>
		<td<?php echo $tbl_user->password->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_password" class="tbl_user_password">
<span<?php echo $tbl_user->password->ViewAttributes() ?>>
<?php echo $tbl_user->password->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_real_name->Visible) { // user_real_name ?>
		<td<?php echo $tbl_user->user_real_name->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_real_name" class="tbl_user_user_real_name">
<span<?php echo $tbl_user->user_real_name->ViewAttributes() ?>>
<?php echo $tbl_user->user_real_name->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_avatar->Visible) { // user_avatar ?>
		<td<?php echo $tbl_user->user_avatar->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_avatar" class="tbl_user_user_avatar">
<span>
<?php if (!ew_EmptyStr($tbl_user->user_avatar->ListViewValue())) { ?><img src="<?php echo $tbl_user->user_avatar->ListViewValue() ?>" alt="" style="border: 0;"<?php echo $tbl_user->user_avatar->ViewAttributes() ?>><?php } ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_cover->Visible) { // user_cover ?>
		<td<?php echo $tbl_user->user_cover->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_cover" class="tbl_user_user_cover">
<span<?php echo $tbl_user->user_cover->ViewAttributes() ?>>
<?php echo $tbl_user->user_cover->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_student_code->Visible) { // user_student_code ?>
		<td<?php echo $tbl_user->user_student_code->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_student_code" class="tbl_user_user_student_code">
<span<?php echo $tbl_user->user_student_code->ViewAttributes() ?>>
<?php echo $tbl_user->user_student_code->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_university->Visible) { // user_university ?>
		<td<?php echo $tbl_user->user_university->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_university" class="tbl_user_user_university">
<span<?php echo $tbl_user->user_university->ViewAttributes() ?>>
<?php echo $tbl_user->user_university->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_gender->Visible) { // user_gender ?>
		<td<?php echo $tbl_user->user_gender->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_gender" class="tbl_user_user_gender">
<span<?php echo $tbl_user->user_gender->ViewAttributes() ?>>
<?php echo $tbl_user->user_gender->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_dob->Visible) { // user_dob ?>
		<td<?php echo $tbl_user->user_dob->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_dob" class="tbl_user_user_dob">
<span<?php echo $tbl_user->user_dob->ViewAttributes() ?>>
<?php echo $tbl_user->user_dob->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_hometown->Visible) { // user_hometown ?>
		<td<?php echo $tbl_user->user_hometown->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_hometown" class="tbl_user_user_hometown">
<span<?php echo $tbl_user->user_hometown->ViewAttributes() ?>>
<?php echo $tbl_user->user_hometown->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_phone->Visible) { // user_phone ?>
		<td<?php echo $tbl_user->user_phone->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_phone" class="tbl_user_user_phone">
<span<?php echo $tbl_user->user_phone->ViewAttributes() ?>>
<?php echo $tbl_user->user_phone->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_description->Visible) { // user_description ?>
		<td<?php echo $tbl_user->user_description->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_description" class="tbl_user_user_description">
<span<?php echo $tbl_user->user_description->ViewAttributes() ?>>
<?php echo $tbl_user->user_description->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_faculty->Visible) { // user_faculty ?>
		<td<?php echo $tbl_user->user_faculty->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_faculty" class="tbl_user_user_faculty">
<span<?php echo $tbl_user->user_faculty->ViewAttributes() ?>>
<?php echo $tbl_user->user_faculty->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_class->Visible) { // user_class ?>
		<td<?php echo $tbl_user->user_class->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_class" class="tbl_user_user_class">
<span<?php echo $tbl_user->user_class->ViewAttributes() ?>>
<?php echo $tbl_user->user_class->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_active->Visible) { // user_active ?>
		<td<?php echo $tbl_user->user_active->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_active" class="tbl_user_user_active">
<span<?php echo $tbl_user->user_active->ViewAttributes() ?>>
<?php echo $tbl_user->user_active->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_status->Visible) { // user_status ?>
		<td<?php echo $tbl_user->user_status->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_status" class="tbl_user_user_status">
<span<?php echo $tbl_user->user_status->ViewAttributes() ?>>
<?php echo $tbl_user->user_status->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_group->Visible) { // user_group ?>
		<td<?php echo $tbl_user->user_group->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_group" class="tbl_user_user_group">
<span<?php echo $tbl_user->user_group->ViewAttributes() ?>>
<?php echo $tbl_user->user_group->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_token->Visible) { // user_token ?>
		<td<?php echo $tbl_user->user_token->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_token" class="tbl_user_user_token">
<span<?php echo $tbl_user->user_token->ViewAttributes() ?>>
<?php echo $tbl_user->user_token->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_activator->Visible) { // user_activator ?>
		<td<?php echo $tbl_user->user_activator->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_activator" class="tbl_user_user_activator">
<span<?php echo $tbl_user->user_activator->ViewAttributes() ?>>
<?php echo $tbl_user->user_activator->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($tbl_user->user_date_attend->Visible) { // user_date_attend ?>
		<td<?php echo $tbl_user->user_date_attend->CellAttributes() ?>><span id="el<?php echo $tbl_user_list->RowCnt ?>_tbl_user_user_date_attend" class="tbl_user_user_date_attend">
<span<?php echo $tbl_user->user_date_attend->ViewAttributes() ?>>
<?php echo $tbl_user->user_date_attend->ListViewValue() ?></span>
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$tbl_user_list->ListOptions->Render("body", "right", $tbl_user_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($tbl_user->CurrentAction <> "gridadd")
		$tbl_user_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($tbl_user->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($tbl_user_list->Recordset)
	$tbl_user_list->Recordset->Close();
?>
</td></tr></table>
<?php if ($tbl_user->Export == "") { ?>
<script type="text/javascript">
ftbl_userlistsrch.Init();
ftbl_userlist.Init();
</script>
<?php } ?>
<?php
$tbl_user_list->ShowPageFooter();
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
$tbl_user_list->Page_Terminate();
?>
