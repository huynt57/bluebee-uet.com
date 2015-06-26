<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "tbl_facultyinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$tbl_faculty_delete = NULL; // Initialize page object first

class ctbl_faculty_delete extends ctbl_faculty {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_faculty';

	// Page object name
	var $PageObjName = 'tbl_faculty_delete';

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

		// Table object (tbl_faculty)
		if (!isset($GLOBALS["tbl_faculty"])) {
			$GLOBALS["tbl_faculty"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_faculty"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_faculty', TRUE);

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
		$this->faculty_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
			$this->Page_Terminate("tbl_facultylist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tbl_faculty class, tbl_facultyinfo.php

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
		$this->faculty_id->setDbValue($rs->fields('faculty_id'));
		$this->faculty_university->setDbValue($rs->fields('faculty_university'));
		$this->faculty_name->setDbValue($rs->fields('faculty_name'));
		$this->faculty_code->setDbValue($rs->fields('faculty_code'));
		$this->faculty_active->setDbValue($rs->fields('faculty_active'));
		$this->faculty_research->setDbValue($rs->fields('faculty_research'));
		$this->faculty_lab->setDbValue($rs->fields('faculty_lab'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// faculty_id
		// faculty_university
		// faculty_name
		// faculty_code
		// faculty_active
		// faculty_research
		// faculty_lab

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// faculty_id
			$this->faculty_id->ViewValue = $this->faculty_id->CurrentValue;
			$this->faculty_id->ViewCustomAttributes = "";

			// faculty_university
			$this->faculty_university->ViewValue = $this->faculty_university->CurrentValue;
			$this->faculty_university->ViewCustomAttributes = "";

			// faculty_name
			$this->faculty_name->ViewValue = $this->faculty_name->CurrentValue;
			$this->faculty_name->ViewCustomAttributes = "";

			// faculty_code
			$this->faculty_code->ViewValue = $this->faculty_code->CurrentValue;
			$this->faculty_code->ViewCustomAttributes = "";

			// faculty_active
			$this->faculty_active->ViewValue = $this->faculty_active->CurrentValue;
			$this->faculty_active->ViewCustomAttributes = "";

			// faculty_id
			$this->faculty_id->LinkCustomAttributes = "";
			$this->faculty_id->HrefValue = "";
			$this->faculty_id->TooltipValue = "";

			// faculty_university
			$this->faculty_university->LinkCustomAttributes = "";
			$this->faculty_university->HrefValue = "";
			$this->faculty_university->TooltipValue = "";

			// faculty_name
			$this->faculty_name->LinkCustomAttributes = "";
			$this->faculty_name->HrefValue = "";
			$this->faculty_name->TooltipValue = "";

			// faculty_code
			$this->faculty_code->LinkCustomAttributes = "";
			$this->faculty_code->HrefValue = "";
			$this->faculty_code->TooltipValue = "";

			// faculty_active
			$this->faculty_active->LinkCustomAttributes = "";
			$this->faculty_active->HrefValue = "";
			$this->faculty_active->TooltipValue = "";
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
				$sThisKey .= $row['faculty_id'];
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
if (!isset($tbl_faculty_delete)) $tbl_faculty_delete = new ctbl_faculty_delete();

// Page init
$tbl_faculty_delete->Page_Init();

// Page main
$tbl_faculty_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_faculty_delete = new ew_Page("tbl_faculty_delete");
tbl_faculty_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = tbl_faculty_delete.PageID; // For backward compatibility

// Form object
var ftbl_facultydelete = new ew_Form("ftbl_facultydelete");

// Form_CustomValidate event
ftbl_facultydelete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_facultydelete.ValidateRequired = true;
<?php } else { ?>
ftbl_facultydelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($tbl_faculty_delete->Recordset = $tbl_faculty_delete->LoadRecordset())
	$tbl_faculty_deleteTotalRecs = $tbl_faculty_delete->Recordset->RecordCount(); // Get record count
if ($tbl_faculty_deleteTotalRecs <= 0) { // No record found, exit
	if ($tbl_faculty_delete->Recordset)
		$tbl_faculty_delete->Recordset->Close();
	$tbl_faculty_delete->Page_Terminate("tbl_facultylist.php"); // Return to list
}
?>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_faculty->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $tbl_faculty->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $tbl_faculty_delete->ShowPageHeader(); ?>
<?php
$tbl_faculty_delete->ShowMessage();
?>
<form name="ftbl_facultydelete" id="ftbl_facultydelete" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<br>
<input type="hidden" name="t" value="tbl_faculty">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tbl_faculty_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_facultydelete" class="ewTable ewTableSeparate">
<?php echo $tbl_faculty->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_tbl_faculty_faculty_id" class="tbl_faculty_faculty_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_faculty->faculty_id->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_faculty_faculty_university" class="tbl_faculty_faculty_university"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_faculty->faculty_university->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_faculty_faculty_name" class="tbl_faculty_faculty_name"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_faculty->faculty_name->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_faculty_faculty_code" class="tbl_faculty_faculty_code"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_faculty->faculty_code->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_faculty_faculty_active" class="tbl_faculty_faculty_active"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_faculty->faculty_active->FldCaption() ?></td></tr></table></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$tbl_faculty_delete->RecCnt = 0;
$i = 0;
while (!$tbl_faculty_delete->Recordset->EOF) {
	$tbl_faculty_delete->RecCnt++;
	$tbl_faculty_delete->RowCnt++;

	// Set row properties
	$tbl_faculty->ResetAttrs();
	$tbl_faculty->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tbl_faculty_delete->LoadRowValues($tbl_faculty_delete->Recordset);

	// Render row
	$tbl_faculty_delete->RenderRow();
?>
	<tr<?php echo $tbl_faculty->RowAttributes() ?>>
		<td<?php echo $tbl_faculty->faculty_id->CellAttributes() ?>><span id="el<?php echo $tbl_faculty_delete->RowCnt ?>_tbl_faculty_faculty_id" class="tbl_faculty_faculty_id">
<span<?php echo $tbl_faculty->faculty_id->ViewAttributes() ?>>
<?php echo $tbl_faculty->faculty_id->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_faculty->faculty_university->CellAttributes() ?>><span id="el<?php echo $tbl_faculty_delete->RowCnt ?>_tbl_faculty_faculty_university" class="tbl_faculty_faculty_university">
<span<?php echo $tbl_faculty->faculty_university->ViewAttributes() ?>>
<?php echo $tbl_faculty->faculty_university->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_faculty->faculty_name->CellAttributes() ?>><span id="el<?php echo $tbl_faculty_delete->RowCnt ?>_tbl_faculty_faculty_name" class="tbl_faculty_faculty_name">
<span<?php echo $tbl_faculty->faculty_name->ViewAttributes() ?>>
<?php echo $tbl_faculty->faculty_name->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_faculty->faculty_code->CellAttributes() ?>><span id="el<?php echo $tbl_faculty_delete->RowCnt ?>_tbl_faculty_faculty_code" class="tbl_faculty_faculty_code">
<span<?php echo $tbl_faculty->faculty_code->ViewAttributes() ?>>
<?php echo $tbl_faculty->faculty_code->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_faculty->faculty_active->CellAttributes() ?>><span id="el<?php echo $tbl_faculty_delete->RowCnt ?>_tbl_faculty_faculty_active" class="tbl_faculty_faculty_active">
<span<?php echo $tbl_faculty->faculty_active->ViewAttributes() ?>>
<?php echo $tbl_faculty->faculty_active->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$tbl_faculty_delete->Recordset->MoveNext();
}
$tbl_faculty_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script type="text/javascript">
ftbl_facultydelete.Init();
</script>
<?php
$tbl_faculty_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_faculty_delete->Page_Terminate();
?>
