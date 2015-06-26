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

$tbl_subject_group_type_delete = NULL; // Initialize page object first

class ctbl_subject_group_type_delete extends ctbl_subject_group_type {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_subject_group_type';

	// Page object name
	var $PageObjName = 'tbl_subject_group_type_delete';

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

		// Table object (tbl_subject_group_type)
		if (!isset($GLOBALS["tbl_subject_group_type"])) {
			$GLOBALS["tbl_subject_group_type"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_subject_group_type"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_subject_group_type', TRUE);

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
			$this->Page_Terminate("tbl_subject_group_typelist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tbl_subject_group_type class, tbl_subject_group_typeinfo.php

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
		$this->subject_type_id->setDbValue($rs->fields('subject_type_id'));
		$this->subject_group_type->setDbValue($rs->fields('subject_group_type'));
		$this->active->setDbValue($rs->fields('active'));
		$this->detail->setDbValue($rs->fields('detail'));
		$this->subject_group->setDbValue($rs->fields('subject_group'));
		$this->subject_dept->setDbValue($rs->fields('subject_dept'));
		$this->subject_faculty->setDbValue($rs->fields('subject_faculty'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
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
				$sThisKey .= $row['subject_type_id'];
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
if (!isset($tbl_subject_group_type_delete)) $tbl_subject_group_type_delete = new ctbl_subject_group_type_delete();

// Page init
$tbl_subject_group_type_delete->Page_Init();

// Page main
$tbl_subject_group_type_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_subject_group_type_delete = new ew_Page("tbl_subject_group_type_delete");
tbl_subject_group_type_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = tbl_subject_group_type_delete.PageID; // For backward compatibility

// Form object
var ftbl_subject_group_typedelete = new ew_Form("ftbl_subject_group_typedelete");

// Form_CustomValidate event
ftbl_subject_group_typedelete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_subject_group_typedelete.ValidateRequired = true;
<?php } else { ?>
ftbl_subject_group_typedelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_subject_group_typedelete.Lists["x_subject_group"] = {"LinkField":"x_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_subject_group_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_subject_group_typedelete.Lists["x_subject_dept"] = {"LinkField":"x_dept_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_dept_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_subject_group_typedelete.Lists["x_subject_faculty"] = {"LinkField":"x_faculty_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_faculty_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($tbl_subject_group_type_delete->Recordset = $tbl_subject_group_type_delete->LoadRecordset())
	$tbl_subject_group_type_deleteTotalRecs = $tbl_subject_group_type_delete->Recordset->RecordCount(); // Get record count
if ($tbl_subject_group_type_deleteTotalRecs <= 0) { // No record found, exit
	if ($tbl_subject_group_type_delete->Recordset)
		$tbl_subject_group_type_delete->Recordset->Close();
	$tbl_subject_group_type_delete->Page_Terminate("tbl_subject_group_typelist.php"); // Return to list
}
?>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_subject_group_type->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $tbl_subject_group_type->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $tbl_subject_group_type_delete->ShowPageHeader(); ?>
<?php
$tbl_subject_group_type_delete->ShowMessage();
?>
<form name="ftbl_subject_group_typedelete" id="ftbl_subject_group_typedelete" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<br>
<input type="hidden" name="t" value="tbl_subject_group_type">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tbl_subject_group_type_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_subject_group_typedelete" class="ewTable ewTableSeparate">
<?php echo $tbl_subject_group_type->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_tbl_subject_group_type_subject_type_id" class="tbl_subject_group_type_subject_type_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject_group_type->subject_type_id->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_subject_group_type_subject_group_type" class="tbl_subject_group_type_subject_group_type"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject_group_type->subject_group_type->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_subject_group_type_active" class="tbl_subject_group_type_active"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject_group_type->active->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_subject_group_type_subject_group" class="tbl_subject_group_type_subject_group"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject_group_type->subject_group->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_subject_group_type_subject_dept" class="tbl_subject_group_type_subject_dept"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject_group_type->subject_dept->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_subject_group_type_subject_faculty" class="tbl_subject_group_type_subject_faculty"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_subject_group_type->subject_faculty->FldCaption() ?></td></tr></table></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$tbl_subject_group_type_delete->RecCnt = 0;
$i = 0;
while (!$tbl_subject_group_type_delete->Recordset->EOF) {
	$tbl_subject_group_type_delete->RecCnt++;
	$tbl_subject_group_type_delete->RowCnt++;

	// Set row properties
	$tbl_subject_group_type->ResetAttrs();
	$tbl_subject_group_type->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tbl_subject_group_type_delete->LoadRowValues($tbl_subject_group_type_delete->Recordset);

	// Render row
	$tbl_subject_group_type_delete->RenderRow();
?>
	<tr<?php echo $tbl_subject_group_type->RowAttributes() ?>>
		<td<?php echo $tbl_subject_group_type->subject_type_id->CellAttributes() ?>><span id="el<?php echo $tbl_subject_group_type_delete->RowCnt ?>_tbl_subject_group_type_subject_type_id" class="tbl_subject_group_type_subject_type_id">
<span<?php echo $tbl_subject_group_type->subject_type_id->ViewAttributes() ?>>
<?php echo $tbl_subject_group_type->subject_type_id->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_subject_group_type->subject_group_type->CellAttributes() ?>><span id="el<?php echo $tbl_subject_group_type_delete->RowCnt ?>_tbl_subject_group_type_subject_group_type" class="tbl_subject_group_type_subject_group_type">
<span<?php echo $tbl_subject_group_type->subject_group_type->ViewAttributes() ?>>
<?php echo $tbl_subject_group_type->subject_group_type->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_subject_group_type->active->CellAttributes() ?>><span id="el<?php echo $tbl_subject_group_type_delete->RowCnt ?>_tbl_subject_group_type_active" class="tbl_subject_group_type_active">
<span<?php echo $tbl_subject_group_type->active->ViewAttributes() ?>>
<?php echo $tbl_subject_group_type->active->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_subject_group_type->subject_group->CellAttributes() ?>><span id="el<?php echo $tbl_subject_group_type_delete->RowCnt ?>_tbl_subject_group_type_subject_group" class="tbl_subject_group_type_subject_group">
<span<?php echo $tbl_subject_group_type->subject_group->ViewAttributes() ?>>
<?php echo $tbl_subject_group_type->subject_group->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_subject_group_type->subject_dept->CellAttributes() ?>><span id="el<?php echo $tbl_subject_group_type_delete->RowCnt ?>_tbl_subject_group_type_subject_dept" class="tbl_subject_group_type_subject_dept">
<span<?php echo $tbl_subject_group_type->subject_dept->ViewAttributes() ?>>
<?php echo $tbl_subject_group_type->subject_dept->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_subject_group_type->subject_faculty->CellAttributes() ?>><span id="el<?php echo $tbl_subject_group_type_delete->RowCnt ?>_tbl_subject_group_type_subject_faculty" class="tbl_subject_group_type_subject_faculty">
<span<?php echo $tbl_subject_group_type->subject_faculty->ViewAttributes() ?>>
<?php echo $tbl_subject_group_type->subject_faculty->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$tbl_subject_group_type_delete->Recordset->MoveNext();
}
$tbl_subject_group_type_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script type="text/javascript">
ftbl_subject_group_typedelete.Init();
</script>
<?php
$tbl_subject_group_type_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_subject_group_type_delete->Page_Terminate();
?>