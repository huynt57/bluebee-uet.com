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

$tbl_user_delete = NULL; // Initialize page object first

class ctbl_user_delete extends ctbl_user {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9095E487-4467-4C46-97C7-01D1A378652D}";

	// Table name
	var $TableName = 'tbl_user';

	// Page object name
	var $PageObjName = 'tbl_user_delete';

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

		// Table object (tbl_user)
		if (!isset($GLOBALS["tbl_user"])) {
			$GLOBALS["tbl_user"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_user"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_user', TRUE);

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
			$this->Page_Terminate("tbl_userlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tbl_user class, tbl_userinfo.php

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
				$sThisKey .= $row['user_id'];
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
if (!isset($tbl_user_delete)) $tbl_user_delete = new ctbl_user_delete();

// Page init
$tbl_user_delete->Page_Init();

// Page main
$tbl_user_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_user_delete = new ew_Page("tbl_user_delete");
tbl_user_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = tbl_user_delete.PageID; // For backward compatibility

// Form object
var ftbl_userdelete = new ew_Form("ftbl_userdelete");

// Form_CustomValidate event
ftbl_userdelete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_userdelete.ValidateRequired = true;
<?php } else { ?>
ftbl_userdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($tbl_user_delete->Recordset = $tbl_user_delete->LoadRecordset())
	$tbl_user_deleteTotalRecs = $tbl_user_delete->Recordset->RecordCount(); // Get record count
if ($tbl_user_deleteTotalRecs <= 0) { // No record found, exit
	if ($tbl_user_delete->Recordset)
		$tbl_user_delete->Recordset->Close();
	$tbl_user_delete->Page_Terminate("tbl_userlist.php"); // Return to list
}
?>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $tbl_user->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $tbl_user->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $tbl_user_delete->ShowPageHeader(); ?>
<?php
$tbl_user_delete->ShowMessage();
?>
<form name="ftbl_userdelete" id="ftbl_userdelete" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<br>
<input type="hidden" name="t" value="tbl_user">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tbl_user_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_userdelete" class="ewTable ewTableSeparate">
<?php echo $tbl_user->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_tbl_user_user_id" class="tbl_user_user_id"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_id->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_id_fb" class="tbl_user_user_id_fb"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_id_fb->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_username" class="tbl_user_username"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->username->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_password" class="tbl_user_password"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->password->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_real_name" class="tbl_user_user_real_name"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_real_name->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_avatar" class="tbl_user_user_avatar"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_avatar->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_cover" class="tbl_user_user_cover"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_cover->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_student_code" class="tbl_user_user_student_code"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_student_code->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_university" class="tbl_user_user_university"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_university->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_gender" class="tbl_user_user_gender"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_gender->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_dob" class="tbl_user_user_dob"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_dob->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_hometown" class="tbl_user_user_hometown"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_hometown->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_phone" class="tbl_user_user_phone"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_phone->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_description" class="tbl_user_user_description"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_description->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_faculty" class="tbl_user_user_faculty"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_faculty->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_class" class="tbl_user_user_class"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_class->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_active" class="tbl_user_user_active"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_active->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_status" class="tbl_user_user_status"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_status->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_group" class="tbl_user_user_group"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_group->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_token" class="tbl_user_user_token"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_token->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_activator" class="tbl_user_user_activator"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_activator->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_tbl_user_user_date_attend" class="tbl_user_user_date_attend"><table class="ewTableHeaderBtn"><tr><td><?php echo $tbl_user->user_date_attend->FldCaption() ?></td></tr></table></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$tbl_user_delete->RecCnt = 0;
$i = 0;
while (!$tbl_user_delete->Recordset->EOF) {
	$tbl_user_delete->RecCnt++;
	$tbl_user_delete->RowCnt++;

	// Set row properties
	$tbl_user->ResetAttrs();
	$tbl_user->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tbl_user_delete->LoadRowValues($tbl_user_delete->Recordset);

	// Render row
	$tbl_user_delete->RenderRow();
?>
	<tr<?php echo $tbl_user->RowAttributes() ?>>
		<td<?php echo $tbl_user->user_id->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_id" class="tbl_user_user_id">
<span<?php echo $tbl_user->user_id->ViewAttributes() ?>>
<?php echo $tbl_user->user_id->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_id_fb->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_id_fb" class="tbl_user_user_id_fb">
<span<?php echo $tbl_user->user_id_fb->ViewAttributes() ?>>
<?php echo $tbl_user->user_id_fb->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->username->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_username" class="tbl_user_username">
<span<?php echo $tbl_user->username->ViewAttributes() ?>>
<?php echo $tbl_user->username->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->password->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_password" class="tbl_user_password">
<span<?php echo $tbl_user->password->ViewAttributes() ?>>
<?php echo $tbl_user->password->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_real_name->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_real_name" class="tbl_user_user_real_name">
<span<?php echo $tbl_user->user_real_name->ViewAttributes() ?>>
<?php echo $tbl_user->user_real_name->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_avatar->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_avatar" class="tbl_user_user_avatar">
<span>
<?php if (!ew_EmptyStr($tbl_user->user_avatar->ListViewValue())) { ?><img src="<?php echo $tbl_user->user_avatar->ListViewValue() ?>" alt="" style="border: 0;"<?php echo $tbl_user->user_avatar->ViewAttributes() ?>><?php } ?></span>
</span></td>
		<td<?php echo $tbl_user->user_cover->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_cover" class="tbl_user_user_cover">
<span<?php echo $tbl_user->user_cover->ViewAttributes() ?>>
<?php echo $tbl_user->user_cover->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_student_code->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_student_code" class="tbl_user_user_student_code">
<span<?php echo $tbl_user->user_student_code->ViewAttributes() ?>>
<?php echo $tbl_user->user_student_code->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_university->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_university" class="tbl_user_user_university">
<span<?php echo $tbl_user->user_university->ViewAttributes() ?>>
<?php echo $tbl_user->user_university->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_gender->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_gender" class="tbl_user_user_gender">
<span<?php echo $tbl_user->user_gender->ViewAttributes() ?>>
<?php echo $tbl_user->user_gender->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_dob->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_dob" class="tbl_user_user_dob">
<span<?php echo $tbl_user->user_dob->ViewAttributes() ?>>
<?php echo $tbl_user->user_dob->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_hometown->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_hometown" class="tbl_user_user_hometown">
<span<?php echo $tbl_user->user_hometown->ViewAttributes() ?>>
<?php echo $tbl_user->user_hometown->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_phone->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_phone" class="tbl_user_user_phone">
<span<?php echo $tbl_user->user_phone->ViewAttributes() ?>>
<?php echo $tbl_user->user_phone->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_description->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_description" class="tbl_user_user_description">
<span<?php echo $tbl_user->user_description->ViewAttributes() ?>>
<?php echo $tbl_user->user_description->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_faculty->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_faculty" class="tbl_user_user_faculty">
<span<?php echo $tbl_user->user_faculty->ViewAttributes() ?>>
<?php echo $tbl_user->user_faculty->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_class->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_class" class="tbl_user_user_class">
<span<?php echo $tbl_user->user_class->ViewAttributes() ?>>
<?php echo $tbl_user->user_class->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_active->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_active" class="tbl_user_user_active">
<span<?php echo $tbl_user->user_active->ViewAttributes() ?>>
<?php echo $tbl_user->user_active->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_status->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_status" class="tbl_user_user_status">
<span<?php echo $tbl_user->user_status->ViewAttributes() ?>>
<?php echo $tbl_user->user_status->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_group->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_group" class="tbl_user_user_group">
<span<?php echo $tbl_user->user_group->ViewAttributes() ?>>
<?php echo $tbl_user->user_group->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_token->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_token" class="tbl_user_user_token">
<span<?php echo $tbl_user->user_token->ViewAttributes() ?>>
<?php echo $tbl_user->user_token->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_activator->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_activator" class="tbl_user_user_activator">
<span<?php echo $tbl_user->user_activator->ViewAttributes() ?>>
<?php echo $tbl_user->user_activator->ListViewValue() ?></span>
</span></td>
		<td<?php echo $tbl_user->user_date_attend->CellAttributes() ?>><span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_date_attend" class="tbl_user_user_date_attend">
<span<?php echo $tbl_user->user_date_attend->ViewAttributes() ?>>
<?php echo $tbl_user->user_date_attend->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$tbl_user_delete->Recordset->MoveNext();
}
$tbl_user_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script type="text/javascript">
ftbl_userdelete.Init();
</script>
<?php
$tbl_user_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_user_delete->Page_Terminate();
?>
