<?php

// Global variable for table object
$tbl_doc = NULL;

//
// Table class for tbl_doc
//
class ctbl_doc extends cTable {
	var $doc_id;
	var $doc_url;
	var $doc_name;
	var $doc_scribd_id;
	var $doc_description;
	var $doc_title;
	var $doc_status;
	var $doc_author;
	var $doc_type;
	var $doc_path;
	var $subject_dept;
	var $subject_type;
	var $subject_faculty;
	var $doc_author_name;
	var $doc_publisher;
	var $subject_general_faculty_id;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tbl_doc';
		$this->TableName = 'tbl_doc';
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

		// doc_id
		$this->doc_id = new cField('tbl_doc', 'tbl_doc', 'x_doc_id', 'doc_id', '`doc_id`', '`doc_id`', 3, -1, FALSE, '`doc_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->doc_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['doc_id'] = &$this->doc_id;

		// doc_url
		$this->doc_url = new cField('tbl_doc', 'tbl_doc', 'x_doc_url', 'doc_url', '`doc_url`', '`doc_url`', 200, -1, FALSE, '`doc_url`', FALSE, FALSE, FALSE, 'IMAGE');
		$this->fields['doc_url'] = &$this->doc_url;

		// doc_name
		$this->doc_name = new cField('tbl_doc', 'tbl_doc', 'x_doc_name', 'doc_name', '`doc_name`', '`doc_name`', 200, -1, FALSE, '`doc_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['doc_name'] = &$this->doc_name;

		// doc_scribd_id
		$this->doc_scribd_id = new cField('tbl_doc', 'tbl_doc', 'x_doc_scribd_id', 'doc_scribd_id', '`doc_scribd_id`', '`doc_scribd_id`', 200, -1, FALSE, '`doc_scribd_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['doc_scribd_id'] = &$this->doc_scribd_id;

		// doc_description
		$this->doc_description = new cField('tbl_doc', 'tbl_doc', 'x_doc_description', 'doc_description', '`doc_description`', '`doc_description`', 200, -1, FALSE, '`doc_description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['doc_description'] = &$this->doc_description;

		// doc_title
		$this->doc_title = new cField('tbl_doc', 'tbl_doc', 'x_doc_title', 'doc_title', '`doc_title`', '`doc_title`', 200, -1, FALSE, '`doc_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['doc_title'] = &$this->doc_title;

		// doc_status
		$this->doc_status = new cField('tbl_doc', 'tbl_doc', 'x_doc_status', 'doc_status', '`doc_status`', '`doc_status`', 200, -1, FALSE, '`doc_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['doc_status'] = &$this->doc_status;

		// doc_author
		$this->doc_author = new cField('tbl_doc', 'tbl_doc', 'x_doc_author', 'doc_author', '`doc_author`', '`doc_author`', 200, -1, FALSE, '`doc_author`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['doc_author'] = &$this->doc_author;

		// doc_type
		$this->doc_type = new cField('tbl_doc', 'tbl_doc', 'x_doc_type', 'doc_type', '`doc_type`', '`doc_type`', 3, -1, FALSE, '`doc_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->doc_type->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['doc_type'] = &$this->doc_type;

		// doc_path
		$this->doc_path = new cField('tbl_doc', 'tbl_doc', 'x_doc_path', 'doc_path', '`doc_path`', '`doc_path`', 201, -1, FALSE, '`doc_path`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['doc_path'] = &$this->doc_path;

		// subject_dept
		$this->subject_dept = new cField('tbl_doc', 'tbl_doc', 'x_subject_dept', 'subject_dept', '`subject_dept`', '`subject_dept`', 3, -1, FALSE, '`subject_dept`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->subject_dept->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['subject_dept'] = &$this->subject_dept;

		// subject_type
		$this->subject_type = new cField('tbl_doc', 'tbl_doc', 'x_subject_type', 'subject_type', '`subject_type`', '`subject_type`', 3, -1, FALSE, '`subject_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->subject_type->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['subject_type'] = &$this->subject_type;

		// subject_faculty
		$this->subject_faculty = new cField('tbl_doc', 'tbl_doc', 'x_subject_faculty', 'subject_faculty', '`subject_faculty`', '`subject_faculty`', 3, -1, FALSE, '`subject_faculty`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->subject_faculty->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['subject_faculty'] = &$this->subject_faculty;

		// doc_author_name
		$this->doc_author_name = new cField('tbl_doc', 'tbl_doc', 'x_doc_author_name', 'doc_author_name', '`doc_author_name`', '`doc_author_name`', 201, -1, FALSE, '`doc_author_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['doc_author_name'] = &$this->doc_author_name;

		// doc_publisher
		$this->doc_publisher = new cField('tbl_doc', 'tbl_doc', 'x_doc_publisher', 'doc_publisher', '`doc_publisher`', '`doc_publisher`', 200, -1, FALSE, '`doc_publisher`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['doc_publisher'] = &$this->doc_publisher;

		// subject_general_faculty_id
		$this->subject_general_faculty_id = new cField('tbl_doc', 'tbl_doc', 'x_subject_general_faculty_id', 'subject_general_faculty_id', '`subject_general_faculty_id`', '`subject_general_faculty_id`', 3, -1, FALSE, '`subject_general_faculty_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
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
		return "`tbl_doc`";
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
	var $UpdateTable = "`tbl_doc`";

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
			$sql .= ew_QuotedName('doc_id') . '=' . ew_QuotedValue($rs['doc_id'], $this->doc_id->FldDataType) . ' AND ';
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
		return "`doc_id` = @doc_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->doc_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@doc_id@", ew_AdjustSql($this->doc_id->CurrentValue), $sKeyFilter); // Replace key value
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
			return "tbl_doclist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tbl_doclist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("tbl_docview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "tbl_docadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("tbl_docedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("tbl_docadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tbl_docdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->doc_id->CurrentValue)) {
			$sUrl .= "doc_id=" . urlencode($this->doc_id->CurrentValue);
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
			$arKeys[] = @$_GET["doc_id"]; // doc_id

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
			$this->doc_id->CurrentValue = $key;
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
		$this->doc_id->setDbValue($rs->fields('doc_id'));
		$this->doc_url->setDbValue($rs->fields('doc_url'));
		$this->doc_name->setDbValue($rs->fields('doc_name'));
		$this->doc_scribd_id->setDbValue($rs->fields('doc_scribd_id'));
		$this->doc_description->setDbValue($rs->fields('doc_description'));
		$this->doc_title->setDbValue($rs->fields('doc_title'));
		$this->doc_status->setDbValue($rs->fields('doc_status'));
		$this->doc_author->setDbValue($rs->fields('doc_author'));
		$this->doc_type->setDbValue($rs->fields('doc_type'));
		$this->doc_path->setDbValue($rs->fields('doc_path'));
		$this->subject_dept->setDbValue($rs->fields('subject_dept'));
		$this->subject_type->setDbValue($rs->fields('subject_type'));
		$this->subject_faculty->setDbValue($rs->fields('subject_faculty'));
		$this->doc_author_name->setDbValue($rs->fields('doc_author_name'));
		$this->doc_publisher->setDbValue($rs->fields('doc_publisher'));
		$this->subject_general_faculty_id->setDbValue($rs->fields('subject_general_faculty_id'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// doc_id
		// doc_url
		// doc_name
		// doc_scribd_id
		// doc_description
		// doc_title
		// doc_status
		// doc_author
		// doc_type
		// doc_path
		// subject_dept
		// subject_type
		// subject_faculty
		// doc_author_name
		// doc_publisher
		// subject_general_faculty_id
		// doc_id

		$this->doc_id->ViewValue = $this->doc_id->CurrentValue;
		$this->doc_id->ViewCustomAttributes = "";

		// doc_url
		$this->doc_url->ViewValue = $this->doc_url->CurrentValue;
		$this->doc_url->ImageAlt = $this->doc_url->FldAlt();
		$this->doc_url->ViewCustomAttributes = "";

		// doc_name
		$this->doc_name->ViewValue = $this->doc_name->CurrentValue;
		$this->doc_name->ViewCustomAttributes = "";

		// doc_scribd_id
		$this->doc_scribd_id->ViewValue = $this->doc_scribd_id->CurrentValue;
		$this->doc_scribd_id->ViewCustomAttributes = "";

		// doc_description
		$this->doc_description->ViewValue = $this->doc_description->CurrentValue;
		$this->doc_description->ViewCustomAttributes = "";

		// doc_title
		$this->doc_title->ViewValue = $this->doc_title->CurrentValue;
		$this->doc_title->ViewCustomAttributes = "";

		// doc_status
		$this->doc_status->ViewValue = $this->doc_status->CurrentValue;
		$this->doc_status->ViewCustomAttributes = "";

		// doc_author
		$this->doc_author->ViewValue = $this->doc_author->CurrentValue;
		$this->doc_author->ViewCustomAttributes = "";

		// doc_type
		$this->doc_type->ViewValue = $this->doc_type->CurrentValue;
		$this->doc_type->ViewCustomAttributes = "";

		// doc_path
		$this->doc_path->ViewValue = $this->doc_path->CurrentValue;
		$this->doc_path->ViewCustomAttributes = "";

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

		// doc_author_name
		$this->doc_author_name->ViewValue = $this->doc_author_name->CurrentValue;
		$this->doc_author_name->ViewCustomAttributes = "";

		// doc_publisher
		$this->doc_publisher->ViewValue = $this->doc_publisher->CurrentValue;
		$this->doc_publisher->ViewCustomAttributes = "";

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

		// doc_id
		$this->doc_id->LinkCustomAttributes = "";
		$this->doc_id->HrefValue = "";
		$this->doc_id->TooltipValue = "";

		// doc_url
		$this->doc_url->LinkCustomAttributes = "";
		$this->doc_url->HrefValue = "";
		$this->doc_url->TooltipValue = "";

		// doc_name
		$this->doc_name->LinkCustomAttributes = "";
		$this->doc_name->HrefValue = "";
		$this->doc_name->TooltipValue = "";

		// doc_scribd_id
		$this->doc_scribd_id->LinkCustomAttributes = "";
		$this->doc_scribd_id->HrefValue = "";
		$this->doc_scribd_id->TooltipValue = "";

		// doc_description
		$this->doc_description->LinkCustomAttributes = "";
		$this->doc_description->HrefValue = "";
		$this->doc_description->TooltipValue = "";

		// doc_title
		$this->doc_title->LinkCustomAttributes = "";
		$this->doc_title->HrefValue = "";
		$this->doc_title->TooltipValue = "";

		// doc_status
		$this->doc_status->LinkCustomAttributes = "";
		$this->doc_status->HrefValue = "";
		$this->doc_status->TooltipValue = "";

		// doc_author
		$this->doc_author->LinkCustomAttributes = "";
		$this->doc_author->HrefValue = "";
		$this->doc_author->TooltipValue = "";

		// doc_type
		$this->doc_type->LinkCustomAttributes = "";
		$this->doc_type->HrefValue = "";
		$this->doc_type->TooltipValue = "";

		// doc_path
		$this->doc_path->LinkCustomAttributes = "";
		$this->doc_path->HrefValue = "";
		$this->doc_path->TooltipValue = "";

		// subject_dept
		$this->subject_dept->LinkCustomAttributes = "";
		$this->subject_dept->HrefValue = "";
		$this->subject_dept->TooltipValue = "";

		// subject_type
		$this->subject_type->LinkCustomAttributes = "";
		$this->subject_type->HrefValue = "";
		$this->subject_type->TooltipValue = "";

		// subject_faculty
		$this->subject_faculty->LinkCustomAttributes = "";
		$this->subject_faculty->HrefValue = "";
		$this->subject_faculty->TooltipValue = "";

		// doc_author_name
		$this->doc_author_name->LinkCustomAttributes = "";
		$this->doc_author_name->HrefValue = "";
		$this->doc_author_name->TooltipValue = "";

		// doc_publisher
		$this->doc_publisher->LinkCustomAttributes = "";
		$this->doc_publisher->HrefValue = "";
		$this->doc_publisher->TooltipValue = "";

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
				if ($this->doc_id->Exportable) $Doc->ExportCaption($this->doc_id);
				if ($this->doc_url->Exportable) $Doc->ExportCaption($this->doc_url);
				if ($this->doc_name->Exportable) $Doc->ExportCaption($this->doc_name);
				if ($this->doc_scribd_id->Exportable) $Doc->ExportCaption($this->doc_scribd_id);
				if ($this->doc_description->Exportable) $Doc->ExportCaption($this->doc_description);
				if ($this->doc_title->Exportable) $Doc->ExportCaption($this->doc_title);
				if ($this->doc_status->Exportable) $Doc->ExportCaption($this->doc_status);
				if ($this->doc_author->Exportable) $Doc->ExportCaption($this->doc_author);
				if ($this->doc_type->Exportable) $Doc->ExportCaption($this->doc_type);
				if ($this->doc_path->Exportable) $Doc->ExportCaption($this->doc_path);
				if ($this->subject_dept->Exportable) $Doc->ExportCaption($this->subject_dept);
				if ($this->subject_type->Exportable) $Doc->ExportCaption($this->subject_type);
				if ($this->subject_faculty->Exportable) $Doc->ExportCaption($this->subject_faculty);
				if ($this->doc_author_name->Exportable) $Doc->ExportCaption($this->doc_author_name);
				if ($this->doc_publisher->Exportable) $Doc->ExportCaption($this->doc_publisher);
				if ($this->subject_general_faculty_id->Exportable) $Doc->ExportCaption($this->subject_general_faculty_id);
			} else {
				if ($this->doc_id->Exportable) $Doc->ExportCaption($this->doc_id);
				if ($this->doc_url->Exportable) $Doc->ExportCaption($this->doc_url);
				if ($this->doc_name->Exportable) $Doc->ExportCaption($this->doc_name);
				if ($this->doc_scribd_id->Exportable) $Doc->ExportCaption($this->doc_scribd_id);
				if ($this->doc_description->Exportable) $Doc->ExportCaption($this->doc_description);
				if ($this->doc_title->Exportable) $Doc->ExportCaption($this->doc_title);
				if ($this->doc_status->Exportable) $Doc->ExportCaption($this->doc_status);
				if ($this->doc_author->Exportable) $Doc->ExportCaption($this->doc_author);
				if ($this->doc_type->Exportable) $Doc->ExportCaption($this->doc_type);
				if ($this->subject_dept->Exportable) $Doc->ExportCaption($this->subject_dept);
				if ($this->subject_type->Exportable) $Doc->ExportCaption($this->subject_type);
				if ($this->subject_faculty->Exportable) $Doc->ExportCaption($this->subject_faculty);
				if ($this->doc_publisher->Exportable) $Doc->ExportCaption($this->doc_publisher);
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
					if ($this->doc_id->Exportable) $Doc->ExportField($this->doc_id);
					if ($this->doc_url->Exportable) $Doc->ExportField($this->doc_url);
					if ($this->doc_name->Exportable) $Doc->ExportField($this->doc_name);
					if ($this->doc_scribd_id->Exportable) $Doc->ExportField($this->doc_scribd_id);
					if ($this->doc_description->Exportable) $Doc->ExportField($this->doc_description);
					if ($this->doc_title->Exportable) $Doc->ExportField($this->doc_title);
					if ($this->doc_status->Exportable) $Doc->ExportField($this->doc_status);
					if ($this->doc_author->Exportable) $Doc->ExportField($this->doc_author);
					if ($this->doc_type->Exportable) $Doc->ExportField($this->doc_type);
					if ($this->doc_path->Exportable) $Doc->ExportField($this->doc_path);
					if ($this->subject_dept->Exportable) $Doc->ExportField($this->subject_dept);
					if ($this->subject_type->Exportable) $Doc->ExportField($this->subject_type);
					if ($this->subject_faculty->Exportable) $Doc->ExportField($this->subject_faculty);
					if ($this->doc_author_name->Exportable) $Doc->ExportField($this->doc_author_name);
					if ($this->doc_publisher->Exportable) $Doc->ExportField($this->doc_publisher);
					if ($this->subject_general_faculty_id->Exportable) $Doc->ExportField($this->subject_general_faculty_id);
				} else {
					if ($this->doc_id->Exportable) $Doc->ExportField($this->doc_id);
					if ($this->doc_url->Exportable) $Doc->ExportField($this->doc_url);
					if ($this->doc_name->Exportable) $Doc->ExportField($this->doc_name);
					if ($this->doc_scribd_id->Exportable) $Doc->ExportField($this->doc_scribd_id);
					if ($this->doc_description->Exportable) $Doc->ExportField($this->doc_description);
					if ($this->doc_title->Exportable) $Doc->ExportField($this->doc_title);
					if ($this->doc_status->Exportable) $Doc->ExportField($this->doc_status);
					if ($this->doc_author->Exportable) $Doc->ExportField($this->doc_author);
					if ($this->doc_type->Exportable) $Doc->ExportField($this->doc_type);
					if ($this->subject_dept->Exportable) $Doc->ExportField($this->subject_dept);
					if ($this->subject_type->Exportable) $Doc->ExportField($this->subject_type);
					if ($this->subject_faculty->Exportable) $Doc->ExportField($this->subject_faculty);
					if ($this->doc_publisher->Exportable) $Doc->ExportField($this->doc_publisher);
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
