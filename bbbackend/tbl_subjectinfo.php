<?php

// Global variable for table object
$tbl_subject = NULL;

//
// Table class for tbl_subject
//
class ctbl_subject extends cTable {
	var $subject_id;
	var $subject_name;
	var $subject_code;
	var $subject_active;
	var $subject_university;
	var $subject_type;
	var $subject_year;
	var $subject_credits;
	var $subject_credit_hour;
	var $subject_requirement;
	var $subject_target;
	var $subject_info;
	var $subject_test;
	var $subject_faculty;
	var $subject_dept;
	var $subject_content;
	var $subject_general_faculty_id;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tbl_subject';
		$this->TableName = 'tbl_subject';
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

		// subject_id
		$this->subject_id = new cField('tbl_subject', 'tbl_subject', 'x_subject_id', 'subject_id', '`subject_id`', '`subject_id`', 3, -1, FALSE, '`subject_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->subject_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['subject_id'] = &$this->subject_id;

		// subject_name
		$this->subject_name = new cField('tbl_subject', 'tbl_subject', 'x_subject_name', 'subject_name', '`subject_name`', '`subject_name`', 200, -1, FALSE, '`subject_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['subject_name'] = &$this->subject_name;

		// subject_code
		$this->subject_code = new cField('tbl_subject', 'tbl_subject', 'x_subject_code', 'subject_code', '`subject_code`', '`subject_code`', 200, -1, FALSE, '`subject_code`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['subject_code'] = &$this->subject_code;

		// subject_active
		$this->subject_active = new cField('tbl_subject', 'tbl_subject', 'x_subject_active', 'subject_active', '`subject_active`', '`subject_active`', 200, -1, FALSE, '`subject_active`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['subject_active'] = &$this->subject_active;

		// subject_university
		$this->subject_university = new cField('tbl_subject', 'tbl_subject', 'x_subject_university', 'subject_university', '`subject_university`', '`subject_university`', 200, -1, FALSE, '`subject_university`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['subject_university'] = &$this->subject_university;

		// subject_type
		$this->subject_type = new cField('tbl_subject', 'tbl_subject', 'x_subject_type', 'subject_type', '`subject_type`', '`subject_type`', 3, -1, FALSE, '`subject_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->subject_type->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['subject_type'] = &$this->subject_type;

		// subject_year
		$this->subject_year = new cField('tbl_subject', 'tbl_subject', 'x_subject_year', 'subject_year', '`subject_year`', '`subject_year`', 3, -1, FALSE, '`subject_year`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->subject_year->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['subject_year'] = &$this->subject_year;

		// subject_credits
		$this->subject_credits = new cField('tbl_subject', 'tbl_subject', 'x_subject_credits', 'subject_credits', '`subject_credits`', '`subject_credits`', 3, -1, FALSE, '`subject_credits`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->subject_credits->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['subject_credits'] = &$this->subject_credits;

		// subject_credit_hour
		$this->subject_credit_hour = new cField('tbl_subject', 'tbl_subject', 'x_subject_credit_hour', 'subject_credit_hour', '`subject_credit_hour`', '`subject_credit_hour`', 200, -1, FALSE, '`subject_credit_hour`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['subject_credit_hour'] = &$this->subject_credit_hour;

		// subject_requirement
		$this->subject_requirement = new cField('tbl_subject', 'tbl_subject', 'x_subject_requirement', 'subject_requirement', '`subject_requirement`', '`subject_requirement`', 201, -1, FALSE, '`subject_requirement`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['subject_requirement'] = &$this->subject_requirement;

		// subject_target
		$this->subject_target = new cField('tbl_subject', 'tbl_subject', 'x_subject_target', 'subject_target', '`subject_target`', '`subject_target`', 201, -1, FALSE, '`subject_target`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['subject_target'] = &$this->subject_target;

		// subject_info
		$this->subject_info = new cField('tbl_subject', 'tbl_subject', 'x_subject_info', 'subject_info', '`subject_info`', '`subject_info`', 201, -1, FALSE, '`subject_info`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['subject_info'] = &$this->subject_info;

		// subject_test
		$this->subject_test = new cField('tbl_subject', 'tbl_subject', 'x_subject_test', 'subject_test', '`subject_test`', '`subject_test`', 201, -1, FALSE, '`subject_test`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['subject_test'] = &$this->subject_test;

		// subject_faculty
		$this->subject_faculty = new cField('tbl_subject', 'tbl_subject', 'x_subject_faculty', 'subject_faculty', '`subject_faculty`', '`subject_faculty`', 3, -1, FALSE, '`subject_faculty`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->subject_faculty->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['subject_faculty'] = &$this->subject_faculty;

		// subject_dept
		$this->subject_dept = new cField('tbl_subject', 'tbl_subject', 'x_subject_dept', 'subject_dept', '`subject_dept`', '`subject_dept`', 3, -1, FALSE, '`subject_dept`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->subject_dept->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['subject_dept'] = &$this->subject_dept;

		// subject_content
		$this->subject_content = new cField('tbl_subject', 'tbl_subject', 'x_subject_content', 'subject_content', '`subject_content`', '`subject_content`', 201, -1, FALSE, '`subject_content`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['subject_content'] = &$this->subject_content;

		// subject_general_faculty_id
		$this->subject_general_faculty_id = new cField('tbl_subject', 'tbl_subject', 'x_subject_general_faculty_id', 'subject_general_faculty_id', '`subject_general_faculty_id`', '`subject_general_faculty_id`', 3, -1, FALSE, '`subject_general_faculty_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->subject_general_faculty_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['subject_general_faculty_id'] = &$this->subject_general_faculty_id;
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
		return "`tbl_subject`";
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
	var $UpdateTable = "`tbl_subject`";

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
			$sql .= ew_QuotedName('subject_id') . '=' . ew_QuotedValue($rs['subject_id'], $this->subject_id->FldDataType) . ' AND ';
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
		return "`subject_id` = @subject_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->subject_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@subject_id@", ew_AdjustSql($this->subject_id->CurrentValue), $sKeyFilter); // Replace key value
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
			return "tbl_subjectlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tbl_subjectlist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("tbl_subjectview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "tbl_subjectadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("tbl_subjectedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("tbl_subjectadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tbl_subjectdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->subject_id->CurrentValue)) {
			$sUrl .= "subject_id=" . urlencode($this->subject_id->CurrentValue);
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
			$arKeys[] = @$_GET["subject_id"]; // subject_id

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
			$this->subject_id->CurrentValue = $key;
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

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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

		// subject_requirement
		$this->subject_requirement->ViewValue = $this->subject_requirement->CurrentValue;
		$this->subject_requirement->ViewCustomAttributes = "";

		// subject_target
		$this->subject_target->ViewValue = $this->subject_target->CurrentValue;
		$this->subject_target->ViewCustomAttributes = "";

		// subject_info
		$this->subject_info->ViewValue = $this->subject_info->CurrentValue;
		$this->subject_info->ViewCustomAttributes = "";

		// subject_test
		$this->subject_test->ViewValue = $this->subject_test->CurrentValue;
		$this->subject_test->ViewCustomAttributes = "";

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

		// subject_content
		$this->subject_content->ViewValue = $this->subject_content->CurrentValue;
		$this->subject_content->ViewCustomAttributes = "";

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

		// subject_requirement
		$this->subject_requirement->LinkCustomAttributes = "";
		$this->subject_requirement->HrefValue = "";
		$this->subject_requirement->TooltipValue = "";

		// subject_target
		$this->subject_target->LinkCustomAttributes = "";
		$this->subject_target->HrefValue = "";
		$this->subject_target->TooltipValue = "";

		// subject_info
		$this->subject_info->LinkCustomAttributes = "";
		$this->subject_info->HrefValue = "";
		$this->subject_info->TooltipValue = "";

		// subject_test
		$this->subject_test->LinkCustomAttributes = "";
		$this->subject_test->HrefValue = "";
		$this->subject_test->TooltipValue = "";

		// subject_faculty
		$this->subject_faculty->LinkCustomAttributes = "";
		$this->subject_faculty->HrefValue = "";
		$this->subject_faculty->TooltipValue = "";

		// subject_dept
		$this->subject_dept->LinkCustomAttributes = "";
		$this->subject_dept->HrefValue = "";
		$this->subject_dept->TooltipValue = "";

		// subject_content
		$this->subject_content->LinkCustomAttributes = "";
		$this->subject_content->HrefValue = "";
		$this->subject_content->TooltipValue = "";

		// subject_general_faculty_id
		$this->subject_general_faculty_id->LinkCustomAttributes = "";
		$this->subject_general_faculty_id->HrefValue = "";
		$this->subject_general_faculty_id->TooltipValue = "";

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
				if ($this->subject_id->Exportable) $Doc->ExportCaption($this->subject_id);
				if ($this->subject_name->Exportable) $Doc->ExportCaption($this->subject_name);
				if ($this->subject_code->Exportable) $Doc->ExportCaption($this->subject_code);
				if ($this->subject_active->Exportable) $Doc->ExportCaption($this->subject_active);
				if ($this->subject_university->Exportable) $Doc->ExportCaption($this->subject_university);
				if ($this->subject_type->Exportable) $Doc->ExportCaption($this->subject_type);
				if ($this->subject_year->Exportable) $Doc->ExportCaption($this->subject_year);
				if ($this->subject_credits->Exportable) $Doc->ExportCaption($this->subject_credits);
				if ($this->subject_credit_hour->Exportable) $Doc->ExportCaption($this->subject_credit_hour);
				if ($this->subject_requirement->Exportable) $Doc->ExportCaption($this->subject_requirement);
				if ($this->subject_target->Exportable) $Doc->ExportCaption($this->subject_target);
				if ($this->subject_info->Exportable) $Doc->ExportCaption($this->subject_info);
				if ($this->subject_test->Exportable) $Doc->ExportCaption($this->subject_test);
				if ($this->subject_faculty->Exportable) $Doc->ExportCaption($this->subject_faculty);
				if ($this->subject_dept->Exportable) $Doc->ExportCaption($this->subject_dept);
				if ($this->subject_content->Exportable) $Doc->ExportCaption($this->subject_content);
				if ($this->subject_general_faculty_id->Exportable) $Doc->ExportCaption($this->subject_general_faculty_id);
			} else {
				if ($this->subject_id->Exportable) $Doc->ExportCaption($this->subject_id);
				if ($this->subject_name->Exportable) $Doc->ExportCaption($this->subject_name);
				if ($this->subject_code->Exportable) $Doc->ExportCaption($this->subject_code);
				if ($this->subject_active->Exportable) $Doc->ExportCaption($this->subject_active);
				if ($this->subject_university->Exportable) $Doc->ExportCaption($this->subject_university);
				if ($this->subject_type->Exportable) $Doc->ExportCaption($this->subject_type);
				if ($this->subject_year->Exportable) $Doc->ExportCaption($this->subject_year);
				if ($this->subject_credits->Exportable) $Doc->ExportCaption($this->subject_credits);
				if ($this->subject_credit_hour->Exportable) $Doc->ExportCaption($this->subject_credit_hour);
				if ($this->subject_faculty->Exportable) $Doc->ExportCaption($this->subject_faculty);
				if ($this->subject_dept->Exportable) $Doc->ExportCaption($this->subject_dept);
				if ($this->subject_general_faculty_id->Exportable) $Doc->ExportCaption($this->subject_general_faculty_id);
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
					if ($this->subject_id->Exportable) $Doc->ExportField($this->subject_id);
					if ($this->subject_name->Exportable) $Doc->ExportField($this->subject_name);
					if ($this->subject_code->Exportable) $Doc->ExportField($this->subject_code);
					if ($this->subject_active->Exportable) $Doc->ExportField($this->subject_active);
					if ($this->subject_university->Exportable) $Doc->ExportField($this->subject_university);
					if ($this->subject_type->Exportable) $Doc->ExportField($this->subject_type);
					if ($this->subject_year->Exportable) $Doc->ExportField($this->subject_year);
					if ($this->subject_credits->Exportable) $Doc->ExportField($this->subject_credits);
					if ($this->subject_credit_hour->Exportable) $Doc->ExportField($this->subject_credit_hour);
					if ($this->subject_requirement->Exportable) $Doc->ExportField($this->subject_requirement);
					if ($this->subject_target->Exportable) $Doc->ExportField($this->subject_target);
					if ($this->subject_info->Exportable) $Doc->ExportField($this->subject_info);
					if ($this->subject_test->Exportable) $Doc->ExportField($this->subject_test);
					if ($this->subject_faculty->Exportable) $Doc->ExportField($this->subject_faculty);
					if ($this->subject_dept->Exportable) $Doc->ExportField($this->subject_dept);
					if ($this->subject_content->Exportable) $Doc->ExportField($this->subject_content);
					if ($this->subject_general_faculty_id->Exportable) $Doc->ExportField($this->subject_general_faculty_id);
				} else {
					if ($this->subject_id->Exportable) $Doc->ExportField($this->subject_id);
					if ($this->subject_name->Exportable) $Doc->ExportField($this->subject_name);
					if ($this->subject_code->Exportable) $Doc->ExportField($this->subject_code);
					if ($this->subject_active->Exportable) $Doc->ExportField($this->subject_active);
					if ($this->subject_university->Exportable) $Doc->ExportField($this->subject_university);
					if ($this->subject_type->Exportable) $Doc->ExportField($this->subject_type);
					if ($this->subject_year->Exportable) $Doc->ExportField($this->subject_year);
					if ($this->subject_credits->Exportable) $Doc->ExportField($this->subject_credits);
					if ($this->subject_credit_hour->Exportable) $Doc->ExportField($this->subject_credit_hour);
					if ($this->subject_faculty->Exportable) $Doc->ExportField($this->subject_faculty);
					if ($this->subject_dept->Exportable) $Doc->ExportField($this->subject_dept);
					if ($this->subject_general_faculty_id->Exportable) $Doc->ExportField($this->subject_general_faculty_id);
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
