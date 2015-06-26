<?php

// Global variable for table object
$tbl_dept = NULL;

//
// Table class for tbl_dept
//
class ctbl_dept extends cTable {
	var $dept_id;
	var $dept_name;
	var $dept_active;
	var $dept_faculty;
	var $dept_target;
	var $dept_knowleadge;
	var $dept_behavior;
	var $dept_out_standard;
	var $dept_contact;
	var $dept_in_standart;
	var $dept_language;
	var $dept_credits;
	var $dept_code;
	var $dept_link_download;
	var $dept_skill;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tbl_dept';
		$this->TableName = 'tbl_dept';
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

		// dept_id
		$this->dept_id = new cField('tbl_dept', 'tbl_dept', 'x_dept_id', 'dept_id', '`dept_id`', '`dept_id`', 3, -1, FALSE, '`dept_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->dept_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dept_id'] = &$this->dept_id;

		// dept_name
		$this->dept_name = new cField('tbl_dept', 'tbl_dept', 'x_dept_name', 'dept_name', '`dept_name`', '`dept_name`', 200, -1, FALSE, '`dept_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['dept_name'] = &$this->dept_name;

		// dept_active
		$this->dept_active = new cField('tbl_dept', 'tbl_dept', 'x_dept_active', 'dept_active', '`dept_active`', '`dept_active`', 3, -1, FALSE, '`dept_active`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->dept_active->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dept_active'] = &$this->dept_active;

		// dept_faculty
		$this->dept_faculty = new cField('tbl_dept', 'tbl_dept', 'x_dept_faculty', 'dept_faculty', '`dept_faculty`', '`dept_faculty`', 3, -1, FALSE, '`dept_faculty`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->dept_faculty->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dept_faculty'] = &$this->dept_faculty;

		// dept_target
		$this->dept_target = new cField('tbl_dept', 'tbl_dept', 'x_dept_target', 'dept_target', '`dept_target`', '`dept_target`', 201, -1, FALSE, '`dept_target`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['dept_target'] = &$this->dept_target;

		// dept_knowleadge
		$this->dept_knowleadge = new cField('tbl_dept', 'tbl_dept', 'x_dept_knowleadge', 'dept_knowleadge', '`dept_knowleadge`', '`dept_knowleadge`', 201, -1, FALSE, '`dept_knowleadge`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['dept_knowleadge'] = &$this->dept_knowleadge;

		// dept_behavior
		$this->dept_behavior = new cField('tbl_dept', 'tbl_dept', 'x_dept_behavior', 'dept_behavior', '`dept_behavior`', '`dept_behavior`', 201, -1, FALSE, '`dept_behavior`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['dept_behavior'] = &$this->dept_behavior;

		// dept_out_standard
		$this->dept_out_standard = new cField('tbl_dept', 'tbl_dept', 'x_dept_out_standard', 'dept_out_standard', '`dept_out_standard`', '`dept_out_standard`', 201, -1, FALSE, '`dept_out_standard`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['dept_out_standard'] = &$this->dept_out_standard;

		// dept_contact
		$this->dept_contact = new cField('tbl_dept', 'tbl_dept', 'x_dept_contact', 'dept_contact', '`dept_contact`', '`dept_contact`', 201, -1, FALSE, '`dept_contact`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['dept_contact'] = &$this->dept_contact;

		// dept_in_standart
		$this->dept_in_standart = new cField('tbl_dept', 'tbl_dept', 'x_dept_in_standart', 'dept_in_standart', '`dept_in_standart`', '`dept_in_standart`', 201, -1, FALSE, '`dept_in_standart`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['dept_in_standart'] = &$this->dept_in_standart;

		// dept_language
		$this->dept_language = new cField('tbl_dept', 'tbl_dept', 'x_dept_language', 'dept_language', '`dept_language`', '`dept_language`', 201, -1, FALSE, '`dept_language`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['dept_language'] = &$this->dept_language;

		// dept_credits
		$this->dept_credits = new cField('tbl_dept', 'tbl_dept', 'x_dept_credits', 'dept_credits', '`dept_credits`', '`dept_credits`', 3, -1, FALSE, '`dept_credits`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->dept_credits->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dept_credits'] = &$this->dept_credits;

		// dept_code
		$this->dept_code = new cField('tbl_dept', 'tbl_dept', 'x_dept_code', 'dept_code', '`dept_code`', '`dept_code`', 200, -1, FALSE, '`dept_code`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['dept_code'] = &$this->dept_code;

		// dept_link_download
		$this->dept_link_download = new cField('tbl_dept', 'tbl_dept', 'x_dept_link_download', 'dept_link_download', '`dept_link_download`', '`dept_link_download`', 201, -1, FALSE, '`dept_link_download`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['dept_link_download'] = &$this->dept_link_download;

		// dept_skill
		$this->dept_skill = new cField('tbl_dept', 'tbl_dept', 'x_dept_skill', 'dept_skill', '`dept_skill`', '`dept_skill`', 201, -1, FALSE, '`dept_skill`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['dept_skill'] = &$this->dept_skill;
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
		return "`tbl_dept`";
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
	var $UpdateTable = "`tbl_dept`";

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
			$sql .= ew_QuotedName('dept_id') . '=' . ew_QuotedValue($rs['dept_id'], $this->dept_id->FldDataType) . ' AND ';
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
		return "`dept_id` = @dept_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->dept_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@dept_id@", ew_AdjustSql($this->dept_id->CurrentValue), $sKeyFilter); // Replace key value
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
			return "tbl_deptlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tbl_deptlist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("tbl_deptview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "tbl_deptadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("tbl_deptedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("tbl_deptadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tbl_deptdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->dept_id->CurrentValue)) {
			$sUrl .= "dept_id=" . urlencode($this->dept_id->CurrentValue);
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
			$arKeys[] = @$_GET["dept_id"]; // dept_id

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
			$this->dept_id->CurrentValue = $key;
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
		$this->dept_id->setDbValue($rs->fields('dept_id'));
		$this->dept_name->setDbValue($rs->fields('dept_name'));
		$this->dept_active->setDbValue($rs->fields('dept_active'));
		$this->dept_faculty->setDbValue($rs->fields('dept_faculty'));
		$this->dept_target->setDbValue($rs->fields('dept_target'));
		$this->dept_knowleadge->setDbValue($rs->fields('dept_knowleadge'));
		$this->dept_behavior->setDbValue($rs->fields('dept_behavior'));
		$this->dept_out_standard->setDbValue($rs->fields('dept_out_standard'));
		$this->dept_contact->setDbValue($rs->fields('dept_contact'));
		$this->dept_in_standart->setDbValue($rs->fields('dept_in_standart'));
		$this->dept_language->setDbValue($rs->fields('dept_language'));
		$this->dept_credits->setDbValue($rs->fields('dept_credits'));
		$this->dept_code->setDbValue($rs->fields('dept_code'));
		$this->dept_link_download->setDbValue($rs->fields('dept_link_download'));
		$this->dept_skill->setDbValue($rs->fields('dept_skill'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// dept_id
		// dept_name
		// dept_active
		// dept_faculty
		// dept_target
		// dept_knowleadge
		// dept_behavior
		// dept_out_standard
		// dept_contact
		// dept_in_standart
		// dept_language
		// dept_credits
		// dept_code
		// dept_link_download
		// dept_skill
		// dept_id

		$this->dept_id->ViewValue = $this->dept_id->CurrentValue;
		$this->dept_id->ViewCustomAttributes = "";

		// dept_name
		$this->dept_name->ViewValue = $this->dept_name->CurrentValue;
		$this->dept_name->ViewCustomAttributes = "";

		// dept_active
		$this->dept_active->ViewValue = $this->dept_active->CurrentValue;
		$this->dept_active->ViewCustomAttributes = "";

		// dept_faculty
		if (strval($this->dept_faculty->CurrentValue) <> "") {
			$sFilterWrk = "`faculty_id`" . ew_SearchString("=", $this->dept_faculty->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `faculty_id`, `faculty_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_faculty`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->dept_faculty->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->dept_faculty->ViewValue = $this->dept_faculty->CurrentValue;
			}
		} else {
			$this->dept_faculty->ViewValue = NULL;
		}
		$this->dept_faculty->ViewCustomAttributes = "";

		// dept_target
		$this->dept_target->ViewValue = $this->dept_target->CurrentValue;
		$this->dept_target->ViewCustomAttributes = "";

		// dept_knowleadge
		$this->dept_knowleadge->ViewValue = $this->dept_knowleadge->CurrentValue;
		$this->dept_knowleadge->ViewCustomAttributes = "";

		// dept_behavior
		$this->dept_behavior->ViewValue = $this->dept_behavior->CurrentValue;
		$this->dept_behavior->ViewCustomAttributes = "";

		// dept_out_standard
		$this->dept_out_standard->ViewValue = $this->dept_out_standard->CurrentValue;
		$this->dept_out_standard->ViewCustomAttributes = "";

		// dept_contact
		$this->dept_contact->ViewValue = $this->dept_contact->CurrentValue;
		$this->dept_contact->ViewCustomAttributes = "";

		// dept_in_standart
		$this->dept_in_standart->ViewValue = $this->dept_in_standart->CurrentValue;
		$this->dept_in_standart->ViewCustomAttributes = "";

		// dept_language
		$this->dept_language->ViewValue = $this->dept_language->CurrentValue;
		$this->dept_language->ViewCustomAttributes = "";

		// dept_credits
		$this->dept_credits->ViewValue = $this->dept_credits->CurrentValue;
		$this->dept_credits->ViewCustomAttributes = "";

		// dept_code
		$this->dept_code->ViewValue = $this->dept_code->CurrentValue;
		$this->dept_code->ViewCustomAttributes = "";

		// dept_link_download
		$this->dept_link_download->ViewValue = $this->dept_link_download->CurrentValue;
		$this->dept_link_download->ViewCustomAttributes = "";

		// dept_skill
		$this->dept_skill->ViewValue = $this->dept_skill->CurrentValue;
		$this->dept_skill->ViewCustomAttributes = "";

		// dept_id
		$this->dept_id->LinkCustomAttributes = "";
		$this->dept_id->HrefValue = "";
		$this->dept_id->TooltipValue = "";

		// dept_name
		$this->dept_name->LinkCustomAttributes = "";
		$this->dept_name->HrefValue = "";
		$this->dept_name->TooltipValue = "";

		// dept_active
		$this->dept_active->LinkCustomAttributes = "";
		$this->dept_active->HrefValue = "";
		$this->dept_active->TooltipValue = "";

		// dept_faculty
		$this->dept_faculty->LinkCustomAttributes = "";
		$this->dept_faculty->HrefValue = "";
		$this->dept_faculty->TooltipValue = "";

		// dept_target
		$this->dept_target->LinkCustomAttributes = "";
		$this->dept_target->HrefValue = "";
		$this->dept_target->TooltipValue = "";

		// dept_knowleadge
		$this->dept_knowleadge->LinkCustomAttributes = "";
		$this->dept_knowleadge->HrefValue = "";
		$this->dept_knowleadge->TooltipValue = "";

		// dept_behavior
		$this->dept_behavior->LinkCustomAttributes = "";
		$this->dept_behavior->HrefValue = "";
		$this->dept_behavior->TooltipValue = "";

		// dept_out_standard
		$this->dept_out_standard->LinkCustomAttributes = "";
		$this->dept_out_standard->HrefValue = "";
		$this->dept_out_standard->TooltipValue = "";

		// dept_contact
		$this->dept_contact->LinkCustomAttributes = "";
		$this->dept_contact->HrefValue = "";
		$this->dept_contact->TooltipValue = "";

		// dept_in_standart
		$this->dept_in_standart->LinkCustomAttributes = "";
		$this->dept_in_standart->HrefValue = "";
		$this->dept_in_standart->TooltipValue = "";

		// dept_language
		$this->dept_language->LinkCustomAttributes = "";
		$this->dept_language->HrefValue = "";
		$this->dept_language->TooltipValue = "";

		// dept_credits
		$this->dept_credits->LinkCustomAttributes = "";
		$this->dept_credits->HrefValue = "";
		$this->dept_credits->TooltipValue = "";

		// dept_code
		$this->dept_code->LinkCustomAttributes = "";
		$this->dept_code->HrefValue = "";
		$this->dept_code->TooltipValue = "";

		// dept_link_download
		$this->dept_link_download->LinkCustomAttributes = "";
		$this->dept_link_download->HrefValue = "";
		$this->dept_link_download->TooltipValue = "";

		// dept_skill
		$this->dept_skill->LinkCustomAttributes = "";
		$this->dept_skill->HrefValue = "";
		$this->dept_skill->TooltipValue = "";

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
				if ($this->dept_id->Exportable) $Doc->ExportCaption($this->dept_id);
				if ($this->dept_name->Exportable) $Doc->ExportCaption($this->dept_name);
				if ($this->dept_active->Exportable) $Doc->ExportCaption($this->dept_active);
				if ($this->dept_faculty->Exportable) $Doc->ExportCaption($this->dept_faculty);
				if ($this->dept_target->Exportable) $Doc->ExportCaption($this->dept_target);
				if ($this->dept_knowleadge->Exportable) $Doc->ExportCaption($this->dept_knowleadge);
				if ($this->dept_behavior->Exportable) $Doc->ExportCaption($this->dept_behavior);
				if ($this->dept_out_standard->Exportable) $Doc->ExportCaption($this->dept_out_standard);
				if ($this->dept_contact->Exportable) $Doc->ExportCaption($this->dept_contact);
				if ($this->dept_in_standart->Exportable) $Doc->ExportCaption($this->dept_in_standart);
				if ($this->dept_language->Exportable) $Doc->ExportCaption($this->dept_language);
				if ($this->dept_credits->Exportable) $Doc->ExportCaption($this->dept_credits);
				if ($this->dept_code->Exportable) $Doc->ExportCaption($this->dept_code);
				if ($this->dept_link_download->Exportable) $Doc->ExportCaption($this->dept_link_download);
				if ($this->dept_skill->Exportable) $Doc->ExportCaption($this->dept_skill);
			} else {
				if ($this->dept_id->Exportable) $Doc->ExportCaption($this->dept_id);
				if ($this->dept_name->Exportable) $Doc->ExportCaption($this->dept_name);
				if ($this->dept_active->Exportable) $Doc->ExportCaption($this->dept_active);
				if ($this->dept_faculty->Exportable) $Doc->ExportCaption($this->dept_faculty);
				if ($this->dept_credits->Exportable) $Doc->ExportCaption($this->dept_credits);
				if ($this->dept_code->Exportable) $Doc->ExportCaption($this->dept_code);
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
					if ($this->dept_id->Exportable) $Doc->ExportField($this->dept_id);
					if ($this->dept_name->Exportable) $Doc->ExportField($this->dept_name);
					if ($this->dept_active->Exportable) $Doc->ExportField($this->dept_active);
					if ($this->dept_faculty->Exportable) $Doc->ExportField($this->dept_faculty);
					if ($this->dept_target->Exportable) $Doc->ExportField($this->dept_target);
					if ($this->dept_knowleadge->Exportable) $Doc->ExportField($this->dept_knowleadge);
					if ($this->dept_behavior->Exportable) $Doc->ExportField($this->dept_behavior);
					if ($this->dept_out_standard->Exportable) $Doc->ExportField($this->dept_out_standard);
					if ($this->dept_contact->Exportable) $Doc->ExportField($this->dept_contact);
					if ($this->dept_in_standart->Exportable) $Doc->ExportField($this->dept_in_standart);
					if ($this->dept_language->Exportable) $Doc->ExportField($this->dept_language);
					if ($this->dept_credits->Exportable) $Doc->ExportField($this->dept_credits);
					if ($this->dept_code->Exportable) $Doc->ExportField($this->dept_code);
					if ($this->dept_link_download->Exportable) $Doc->ExportField($this->dept_link_download);
					if ($this->dept_skill->Exportable) $Doc->ExportField($this->dept_skill);
				} else {
					if ($this->dept_id->Exportable) $Doc->ExportField($this->dept_id);
					if ($this->dept_name->Exportable) $Doc->ExportField($this->dept_name);
					if ($this->dept_active->Exportable) $Doc->ExportField($this->dept_active);
					if ($this->dept_faculty->Exportable) $Doc->ExportField($this->dept_faculty);
					if ($this->dept_credits->Exportable) $Doc->ExportField($this->dept_credits);
					if ($this->dept_code->Exportable) $Doc->ExportField($this->dept_code);
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
