<?php

// Global variable for table object
$tbl_subject_group_type = NULL;

//
// Table class for tbl_subject_group_type
//
class ctbl_subject_group_type extends cTable {
	var $subject_type_id;
	var $subject_group_type;
	var $active;
	var $detail;
	var $subject_group;
	var $subject_dept;
	var $subject_faculty;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tbl_subject_group_type';
		$this->TableName = 'tbl_subject_group_type';
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

		// subject_type_id
		$this->subject_type_id = new cField('tbl_subject_group_type', 'tbl_subject_group_type', 'x_subject_type_id', 'subject_type_id', '`subject_type_id`', '`subject_type_id`', 3, -1, FALSE, '`subject_type_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->subject_type_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['subject_type_id'] = &$this->subject_type_id;

		// subject_group_type
		$this->subject_group_type = new cField('tbl_subject_group_type', 'tbl_subject_group_type', 'x_subject_group_type', 'subject_group_type', '`subject_group_type`', '`subject_group_type`', 200, -1, FALSE, '`subject_group_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['subject_group_type'] = &$this->subject_group_type;

		// active
		$this->active = new cField('tbl_subject_group_type', 'tbl_subject_group_type', 'x_active', 'active', '`active`', '`active`', 3, -1, FALSE, '`active`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->active->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['active'] = &$this->active;

		// detail
		$this->detail = new cField('tbl_subject_group_type', 'tbl_subject_group_type', 'x_detail', 'detail', '`detail`', '`detail`', 201, -1, FALSE, '`detail`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['detail'] = &$this->detail;

		// subject_group
		$this->subject_group = new cField('tbl_subject_group_type', 'tbl_subject_group_type', 'x_subject_group', 'subject_group', '`subject_group`', '`subject_group`', 3, -1, FALSE, '`subject_group`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->subject_group->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['subject_group'] = &$this->subject_group;

		// subject_dept
		$this->subject_dept = new cField('tbl_subject_group_type', 'tbl_subject_group_type', 'x_subject_dept', 'subject_dept', '`subject_dept`', '`subject_dept`', 3, -1, FALSE, '`subject_dept`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->subject_dept->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['subject_dept'] = &$this->subject_dept;

		// subject_faculty
		$this->subject_faculty = new cField('tbl_subject_group_type', 'tbl_subject_group_type', 'x_subject_faculty', 'subject_faculty', '`subject_faculty`', '`subject_faculty`', 3, -1, FALSE, '`subject_faculty`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->subject_faculty->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['subject_faculty'] = &$this->subject_faculty;
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
		return "`tbl_subject_group_type`";
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
	var $UpdateTable = "`tbl_subject_group_type`";

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
			$sql .= ew_QuotedName('subject_type_id') . '=' . ew_QuotedValue($rs['subject_type_id'], $this->subject_type_id->FldDataType) . ' AND ';
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
		return "`subject_type_id` = @subject_type_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->subject_type_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@subject_type_id@", ew_AdjustSql($this->subject_type_id->CurrentValue), $sKeyFilter); // Replace key value
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
			return "tbl_subject_group_typelist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tbl_subject_group_typelist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("tbl_subject_group_typeview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "tbl_subject_group_typeadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("tbl_subject_group_typeedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("tbl_subject_group_typeadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tbl_subject_group_typedelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->subject_type_id->CurrentValue)) {
			$sUrl .= "subject_type_id=" . urlencode($this->subject_type_id->CurrentValue);
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
			$arKeys[] = @$_GET["subject_type_id"]; // subject_type_id

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
			$this->subject_type_id->CurrentValue = $key;
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
		$this->subject_type_id->setDbValue($rs->fields('subject_type_id'));
		$this->subject_group_type->setDbValue($rs->fields('subject_group_type'));
		$this->active->setDbValue($rs->fields('active'));
		$this->detail->setDbValue($rs->fields('detail'));
		$this->subject_group->setDbValue($rs->fields('subject_group'));
		$this->subject_dept->setDbValue($rs->fields('subject_dept'));
		$this->subject_faculty->setDbValue($rs->fields('subject_faculty'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// subject_type_id
		// subject_group_type
		// active
		// detail
		// subject_group
		// subject_dept
		// subject_faculty
		// subject_type_id

		$this->subject_type_id->ViewValue = $this->subject_type_id->CurrentValue;
		$this->subject_type_id->ViewCustomAttributes = "";

		// subject_group_type
		$this->subject_group_type->ViewValue = $this->subject_group_type->CurrentValue;
		$this->subject_group_type->ViewCustomAttributes = "";

		// active
		$this->active->ViewValue = $this->active->CurrentValue;
		$this->active->ViewCustomAttributes = "";

		// detail
		$this->detail->ViewValue = $this->detail->CurrentValue;
		$this->detail->ViewCustomAttributes = "";

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

		// detail
		$this->detail->LinkCustomAttributes = "";
		$this->detail->HrefValue = "";
		$this->detail->TooltipValue = "";

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
				if ($this->subject_type_id->Exportable) $Doc->ExportCaption($this->subject_type_id);
				if ($this->subject_group_type->Exportable) $Doc->ExportCaption($this->subject_group_type);
				if ($this->active->Exportable) $Doc->ExportCaption($this->active);
				if ($this->detail->Exportable) $Doc->ExportCaption($this->detail);
				if ($this->subject_group->Exportable) $Doc->ExportCaption($this->subject_group);
				if ($this->subject_dept->Exportable) $Doc->ExportCaption($this->subject_dept);
				if ($this->subject_faculty->Exportable) $Doc->ExportCaption($this->subject_faculty);
			} else {
				if ($this->subject_type_id->Exportable) $Doc->ExportCaption($this->subject_type_id);
				if ($this->subject_group_type->Exportable) $Doc->ExportCaption($this->subject_group_type);
				if ($this->active->Exportable) $Doc->ExportCaption($this->active);
				if ($this->subject_group->Exportable) $Doc->ExportCaption($this->subject_group);
				if ($this->subject_dept->Exportable) $Doc->ExportCaption($this->subject_dept);
				if ($this->subject_faculty->Exportable) $Doc->ExportCaption($this->subject_faculty);
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
					if ($this->subject_type_id->Exportable) $Doc->ExportField($this->subject_type_id);
					if ($this->subject_group_type->Exportable) $Doc->ExportField($this->subject_group_type);
					if ($this->active->Exportable) $Doc->ExportField($this->active);
					if ($this->detail->Exportable) $Doc->ExportField($this->detail);
					if ($this->subject_group->Exportable) $Doc->ExportField($this->subject_group);
					if ($this->subject_dept->Exportable) $Doc->ExportField($this->subject_dept);
					if ($this->subject_faculty->Exportable) $Doc->ExportField($this->subject_faculty);
				} else {
					if ($this->subject_type_id->Exportable) $Doc->ExportField($this->subject_type_id);
					if ($this->subject_group_type->Exportable) $Doc->ExportField($this->subject_group_type);
					if ($this->active->Exportable) $Doc->ExportField($this->active);
					if ($this->subject_group->Exportable) $Doc->ExportField($this->subject_group);
					if ($this->subject_dept->Exportable) $Doc->ExportField($this->subject_dept);
					if ($this->subject_faculty->Exportable) $Doc->ExportField($this->subject_faculty);
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
