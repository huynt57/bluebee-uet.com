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

$tbl_teacher_delete = NULL; // Initialize page object first

class ctbl_teacher_delete extends ctbl_teacher {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_teacher';

	// Page object name
	var $PageObjName = 'tbl_teacher_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("tbl_teacherlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tbl_teacher class, tbl_teacherinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		} else {
			$this->LoadRowValues($rs); // Load row values
		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['teacher_id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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
if (!isset($tbl_teacher_delete)) $tbl_teacher_delete = new ctbl_teacher_delete();

// Page init
$tbl_teacher_delete->Page_Init();

// Page main
$tbl_teacher_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_teacher_delete = new ew_Page("tbl_teacher_delete");
tbl_teacher_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = tbl_teacher_delete.PageID; // For backward compatibility

// Form object
var ftbl_teacherdelete = new ew_Form("ftbl_teacherdelete");

// Form_CustomValidate event
ftbl_teacherdelete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_teacherdelete.ValidateRequired = true;
<?php } else { ?>
ftbl_teacherdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_teacherdelete.Lists["x_teacher_faculty"] = {"LinkField":"x_faculty_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_faculty_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_teacherdelete.Lists["x_teacher_dept"] = {"LinkField":"x_dept_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_dept_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($tbl_teacher_delete->Recordset = $tbl_teacher_delete->LoadRecordset())
	$tbl_teacher_deleteTotalRecs = $tbl_teacher_delete->Recordset->RecordCount(); // Get record count
if ($tbl_teacher_deleteTotalRecs <= 0) { // No record found, exit
	if ($tbl_teacher_delete->Recordset)
		$tbl_teacher_delete->Recordset->Close();
	$tbl_teacher_delete->Page_Terminate("tbl_teacherlist.php"); // Return to list
}
?>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_teacher->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $tbl_teacher->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $tbl_teacher_delete->ShowPageHeader(); ?>
<?php
$tbl_teacher_delete->ShowMessage();
?>
<form name="ftbl_teacherdelete" id="ftbl_teacherdelete" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<br>
<input type="hidden" name="t" value="tbl_teacher">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tbl_teacher_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_teacherdelete" class="ewTable ewTableSeparate">
<?php echo $tbl_teacher->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_tbl_teacher_teacher_id" class="tbl_teacher_teacher_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_id->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_teacher_teacher_name" class="tbl_teacher_teacher_name"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_name->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_teacher_teacher_personal_page" class="tbl_teacher_teacher_personal_page"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_personal_page->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_teacher_teacher_avatar" class="tbl_teacher_teacher_avatar"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_avatar->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_teacher_teacher_work_place" class="tbl_teacher_teacher_work_place"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_work_place->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_teacher_teacher_active" class="tbl_teacher_teacher_active"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_active->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_teacher_teacher_acadamic_title" class="tbl_teacher_teacher_acadamic_title"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_acadamic_title->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_teacher_teacher_birthday" class="tbl_teacher_teacher_birthday"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_birthday->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_teacher_teacher_sex" class="tbl_teacher_teacher_sex"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_sex->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_teacher_teacher_faculty" class="tbl_teacher_teacher_faculty"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_faculty->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_teacher_teacher_dept" class="tbl_teacher_teacher_dept"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_dept->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_teacher_teacher_rate" class="tbl_teacher_teacher_rate"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_teacher->teacher_rate->FldCaption() ?></td></tr></table></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$tbl_teacher_delete->RecCnt = 0;
$i = 0;
while (!$tbl_teacher_delete->Recordset->EOF) {
	$tbl_teacher_delete->RecCnt++;
	$tbl_teacher_delete->RowCnt++;

	// Set row properties
	$tbl_teacher->ResetAttrs();
	$tbl_teacher->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tbl_teacher_delete->LoadRowValues($tbl_teacher_delete->Recordset);

	// Render row
	$tbl_teacher_delete->RenderRow();
?>
	<tr<?php echo $tbl_teacher->RowAttributes() ?>>
		<td<?php echo $tbl_teacher->teacher_id->CellAttributes() ?>><span id="el<?php echo $tbl_teacher_delete->RowCnt ?>_tbl_teacher_teacher_id" class="tbl_teacher_teacher_id">
<span<?php echo $tbl_teacher->teacher_id->ViewAttributes() ?>>
<?php echo $tbl_teacher->teacher_id->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_teacher->teacher_name->CellAttributes() ?>><span id="el<?php echo $tbl_teacher_delete->RowCnt ?>_tbl_teacher_teacher_name" class="tbl_teacher_teacher_name">
<span<?php echo $tbl_teacher->teacher_name->ViewAttributes() ?>>
<?php echo $tbl_teacher->teacher_name->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_teacher->teacher_personal_page->CellAttributes() ?>><span id="el<?php echo $tbl_teacher_delete->RowCnt ?>_tbl_teacher_teacher_personal_page" class="tbl_teacher_teacher_personal_page">
<span<?php echo $tbl_teacher->teacher_personal_page->ViewAttributes() ?>>
<?php echo $tbl_teacher->teacher_personal_page->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_teacher->teacher_avatar->CellAttributes() ?>><span id="el<?php echo $tbl_teacher_delete->RowCnt ?>_tbl_teacher_teacher_avatar" class="tbl_teacher_teacher_avatar">
<span>
<?php if ($tbl_teacher->teacher_avatar->LinkAttributes() <> "") { ?>
<?php if (!empty($tbl_teacher->teacher_avatar->Upload->DbValue)) { ?>
<img src="<?php echo $tbl_teacher->teacher_avatar->ListViewValue() ?>" alt="" style="border: 0;"<?php echo $tbl_teacher->teacher_avatar->ViewAttributes() ?>>
<?php } elseif (!in_array($tbl_teacher->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($tbl_teacher->teacher_avatar->Upload->DbValue)) { ?>
<img src="<?php echo $tbl_teacher->teacher_avatar->ListViewValue() ?>" alt="" style="border: 0;"<?php echo $tbl_teacher->teacher_avatar->ViewAttributes() ?>>
<?php } elseif (!in_array($tbl_teacher->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span></td>
		<td<?php echo $tbl_teacher->teacher_work_place->CellAttributes() ?>><span id="el<?php echo $tbl_teacher_delete->RowCnt ?>_tbl_teacher_teacher_work_place" class="tbl_teacher_teacher_work_place">
<span<?php echo $tbl_teacher->teacher_work_place->ViewAttributes() ?>>
<?php echo $tbl_teacher->teacher_work_place->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_teacher->teacher_active->CellAttributes() ?>><span id="el<?php echo $tbl_teacher_delete->RowCnt ?>_tbl_teacher_teacher_active" class="tbl_teacher_teacher_active">
<span<?php echo $tbl_teacher->teacher_active->ViewAttributes() ?>>
<?php echo $tbl_teacher->teacher_active->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_teacher->teacher_acadamic_title->CellAttributes() ?>><span id="el<?php echo $tbl_teacher_delete->RowCnt ?>_tbl_teacher_teacher_acadamic_title" class="tbl_teacher_teacher_acadamic_title">
<span<?php echo $tbl_teacher->teacher_acadamic_title->ViewAttributes() ?>>
<?php echo $tbl_teacher->teacher_acadamic_title->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_teacher->teacher_birthday->CellAttributes() ?>><span id="el<?php echo $tbl_teacher_delete->RowCnt ?>_tbl_teacher_teacher_birthday" class="tbl_teacher_teacher_birthday">
<span<?php echo $tbl_teacher->teacher_birthday->ViewAttributes() ?>>
<?php echo $tbl_teacher->teacher_birthday->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_teacher->teacher_sex->CellAttributes() ?>><span id="el<?php echo $tbl_teacher_delete->RowCnt ?>_tbl_teacher_teacher_sex" class="tbl_teacher_teacher_sex">
<span<?php echo $tbl_teacher->teacher_sex->ViewAttributes() ?>>
<?php echo $tbl_teacher->teacher_sex->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_teacher->teacher_faculty->CellAttributes() ?>><span id="el<?php echo $tbl_teacher_delete->RowCnt ?>_tbl_teacher_teacher_faculty" class="tbl_teacher_teacher_faculty">
<span<?php echo $tbl_teacher->teacher_faculty->ViewAttributes() ?>>
<?php echo $tbl_teacher->teacher_faculty->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_teacher->teacher_dept->CellAttributes() ?>><span id="el<?php echo $tbl_teacher_delete->RowCnt ?>_tbl_teacher_teacher_dept" class="tbl_teacher_teacher_dept">
<span<?php echo $tbl_teacher->teacher_dept->ViewAttributes() ?>>
<?php echo $tbl_teacher->teacher_dept->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_teacher->teacher_rate->CellAttributes() ?>><span id="el<?php echo $tbl_teacher_delete->RowCnt ?>_tbl_teacher_teacher_rate" class="tbl_teacher_teacher_rate">
<span<?php echo $tbl_teacher->teacher_rate->ViewAttributes() ?>>
<?php echo $tbl_teacher->teacher_rate->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$tbl_teacher_delete->Recordset->MoveNext();
}
$tbl_teacher_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script type="text/javascript">
ftbl_teacherdelete.Init();
</script>
<?php
$tbl_teacher_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_teacher_delete->Page_Terminate();
?>
