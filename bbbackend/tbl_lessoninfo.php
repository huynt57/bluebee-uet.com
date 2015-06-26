<?php

// Global variable for table object
$tbl_lesson = NULL;

//
// Table class for tbl_lesson
//
class ctbl_lesson extends cTable {
	var $lesson_id;
	var $lesson_active;
	var $lesson_weeks;
	var $lesson_subject;
	var $lesson_name;
	var $lesson_info;
	var $lesson_doc;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tbl_lesson';
		$this->TableName = 'tbl_lesson';
		$this->TableType = 'TABLE';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// lesson_id
		$this->lesson_id = new cField('tbl_lesson', 'tbl_lesson', 'x_lesson_id', 'lesson_id', '`lesson_id`', '`lesson_id`', 3, -1, FALSE, '`lesson_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->lesson_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['lesson_id'] = &$this->lesson_id;

		// lesson_active
		$this->lesson_active = new cField('tbl_lesson', 'tbl_lesson', 'x_lesson_active', 'lesson_active', '`lesson_active`', '`lesson_active`', 3, -1, FALSE, '`lesson_active`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->lesson_active->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['lesson_active'] = &$this->lesson_active;

		// lesson_weeks
		$this->lesson_weeks = new cField('tbl_lesson', 'tbl_lesson', 'x_lesson_weeks', 'lesson_weeks', '`lesson_weeks`', '`lesson_weeks`', 200, -1, FALSE, '`lesson_weeks`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['lesson_weeks'] = &$this->lesson_weeks;

		// lesson_subject
		$this->lesson_subject = new cField('tbl_lesson', 'tbl_lesson', 'x_lesson_subject', 'lesson_subject', '`lesson_subject`', '`lesson_subject`', 3, -1, FALSE, '`lesson_subject`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->lesson_subject->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['lesson_subject'] = &$this->lesson_subject;

		// lesson_name
		$this->lesson_name = new cField('tbl_lesson', 'tbl_lesson', 'x_lesson_name', 'lesson_name', '`lesson_name`', '`lesson_name`', 201, -1, FALSE, '`lesson_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['lesson_name'] = &$this->lesson_name;

		// lesson_info
		$this->lesson_info = new cField('tbl_lesson', 'tbl_lesson', 'x_lesson_info', 'lesson_info', '`lesson_info`', '`lesson_info`', 201, -1, FALSE, '`lesson_info`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['lesson_info'] = &$this->lesson_info;

		// lesson_doc
		$this->lesson_doc = new cField('tbl_lesson', 'tbl_lesson', 'x_lesson_doc', 'lesson_doc', '`lesson_doc`', '`lesson_doc`', 200, -1, FALSE, '`lesson_doc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['lesson_doc'] = &$this->lesson_doc;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`tbl_lesson`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "";
	}

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (@$this->PageID) {
			case "add":
			case "register":
			case "addopt":
				return FALSE;
			case "edit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return FALSE;
			case "delete":
				return FALSE;
			case "view":
				return FALSE;
			case "search":
				return FALSE;
			default:
				return FALSE;
		}
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		return TRUE;
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(), $this->SqlGroupBy(),
			$this->SqlHaving(), $this->SqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->SqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		global $conn;
		$cnt = -1;
		if ($this->TableType == 'TABLE' || $this->TableType == 'VIEW') {
			$sSql = "SELECT COUNT(*) FROM" . substr($sSql, 13);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		global $conn;
		$origFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Update Table
	var $UpdateTable = "`tbl_lesson`";

	// INSERT statement
	function InsertSQL(&$rs) {
		global $conn;
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		global $conn;
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "") {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "") {
		global $conn;
		return $conn->Execute($this->UpdateSQL($rs, $where));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "") {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if ($rs) {
			$sql .= ew_QuotedName('lesson_id') . '=' . ew_QuotedValue($rs['lesson_id'], $this->lesson_id->FldDataType) . ' AND ';
		}
		if (substr($sql, -5) == " AND ") $sql = substr($sql, 0, -5);
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " AND " . $filter;
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "") {
		global $conn;
		return $conn->Execute($this->DeleteSQL($rs, $where));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`lesson_id` = @lesson_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->lesson_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@lesson_id@", ew_AdjustSql($this->lesson_id->CurrentValue), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "tbl_lessonlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tbl_lessonlist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("tbl_lessonview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "tbl_lessonadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("tbl_lessonedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("tbl_lessonadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tbl_lessondelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->lesson_id->CurrentValue)) {
			$sUrl .= "lesson_id=" . urlencode($this->lesson_id->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET)) {
			$arKeys[] = @$_GET["lesson_id"]; // lesson_id

			//return $arKeys; // do not return yet, so the values will also be checked by the following code
		}

		// check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->lesson_id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->lesson_id->setDbValue($rs->fields('lesson_id'));
		$this->lesson_active->setDbValue($rs->fields('lesson_active'));
		$this->lesson_weeks->setDbValue($rs->fields('lesson_weeks'));
		$this->lesson_subject->setDbValue($rs->fields('lesson_subject'));
		$this->lesson_name->setDbValue($rs->fields('lesson_name'));
		$this->lesson_info->setDbValue($rs->fields('lesson_info'));
		$this->lesson_doc->setDbValue($rs->fields('lesson_doc'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// lesson_id
		// lesson_active
		// lesson_weeks
		// lesson_subject
		// lesson_name
		// lesson_info
		// lesson_doc
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

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;

		// Write header
		$Doc->ExportTableHeader();
		if ($Doc->Horizontal) { // Horizontal format, write header
			$Doc->BeginExportRow();
			if ($ExportPageType == "view") {
				if ($this->lesson_id->Exportable) $Doc->ExportCaption($this->lesson_id);
				if ($this->lesson_active->Exportable) $Doc->ExportCaption($this->lesson_active);
				if ($this->lesson_weeks->Exportable) $Doc->ExportCaption($this->lesson_weeks);
				if ($this->lesson_subject->Exportable) $Doc->ExportCaption($this->lesson_subject);
				if ($this->lesson_name->Exportable) $Doc->ExportCaption($this->lesson_name);
				if ($this->lesson_info->Exportable) $Doc->ExportCaption($this->lesson_info);
				if ($this->lesson_doc->Exportable) $Doc->ExportCaption($this->lesson_doc);
			} else {
				if ($this->lesson_id->Exportable) $Doc->ExportCaption($this->lesson_id);
				if ($this->lesson_active->Exportable) $Doc->ExportCaption($this->lesson_active);
				if ($this->lesson_weeks->Exportable) $Doc->ExportCaption($this->lesson_weeks);
				if ($this->lesson_subject->Exportable) $Doc->ExportCaption($this->lesson_subject);
				if ($this->lesson_doc->Exportable) $Doc->ExportCaption($this->lesson_doc);
			}
			$Doc->EndExportRow();
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
				if ($ExportPageType == "view") {
					if ($this->lesson_id->Exportable) $Doc->ExportField($this->lesson_id);
					if ($this->lesson_active->Exportable) $Doc->ExportField($this->lesson_active);
					if ($this->lesson_weeks->Exportable) $Doc->ExportField($this->lesson_weeks);
					if ($this->lesson_subject->Exportable) $Doc->ExportField($this->lesson_subject);
					if ($this->lesson_name->Exportable) $Doc->ExportField($this->lesson_name);
					if ($this->lesson_info->Exportable) $Doc->ExportField($this->lesson_info);
					if ($this->lesson_doc->Exportable) $Doc->ExportField($this->lesson_doc);
				} else {
					if ($this->lesson_id->Exportable) $Doc->ExportField($this->lesson_id);
					if ($this->lesson_active->Exportable) $Doc->ExportField($this->lesson_active);
					if ($this->lesson_weeks->Exportable) $Doc->ExportField($this->lesson_weeks);
					if ($this->lesson_subject->Exportable) $Doc->ExportField($this->lesson_subject);
					if ($this->lesson_doc->Exportable) $Doc->ExportField($this->lesson_doc);
				}
				$Doc->EndExportRow();
			}
			$Recordset->MoveNext();
		}
		$Doc->ExportTableFooter();
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
