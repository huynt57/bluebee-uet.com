<?php

// Global variable for table object
$tbl_teacher = NULL;

//
// Table class for tbl_teacher
//
class ctbl_teacher extends cTable {
	var $teacher_id;
	var $teacher_name;
	var $teacher_personal_page;
	var $teacher_avatar;
	var $teacher_description;
	var $teacher_work_place;
	var $teacher_active;
	var $teacher_acadamic_title;
	var $teacher_birthday;
	var $teacher_sex;
	var $teacher_faculty;
	var $teacher_dept;
	var $teacher_rate;
	var $teacher_personality;
	var $advices;
	var $teacher_research;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tbl_teacher';
		$this->TableName = 'tbl_teacher';
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

		// teacher_id
		$this->teacher_id = new cField('tbl_teacher', 'tbl_teacher', 'x_teacher_id', 'teacher_id', '`teacher_id`', '`teacher_id`', 3, -1, FALSE, '`teacher_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->teacher_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['teacher_id'] = &$this->teacher_id;

		// teacher_name
		$this->teacher_name = new cField('tbl_teacher', 'tbl_teacher', 'x_teacher_name', 'teacher_name', '`teacher_name`', '`teacher_name`', 200, -1, FALSE, '`teacher_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['teacher_name'] = &$this->teacher_name;

		// teacher_personal_page
		$this->teacher_personal_page = new cField('tbl_teacher', 'tbl_teacher', 'x_teacher_personal_page', 'teacher_personal_page', '`teacher_personal_page`', '`teacher_personal_page`', 200, -1, FALSE, '`teacher_personal_page`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['teacher_personal_page'] = &$this->teacher_personal_page;

		// teacher_avatar
		$this->teacher_avatar = new cField('tbl_teacher', 'tbl_teacher', 'x_teacher_avatar', 'teacher_avatar', '`teacher_avatar`', '`teacher_avatar`', 200, -1, TRUE, '`teacher_avatar`', FALSE, FALSE, FALSE, 'IMAGE');
		$this->fields['teacher_avatar'] = &$this->teacher_avatar;

		// teacher_description
		$this->teacher_description = new cField('tbl_teacher', 'tbl_teacher', 'x_teacher_description', 'teacher_description', '`teacher_description`', '`teacher_description`', 201, -1, FALSE, '`teacher_description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['teacher_description'] = &$this->teacher_description;

		// teacher_work_place
		$this->teacher_work_place = new cField('tbl_teacher', 'tbl_teacher', 'x_teacher_work_place', 'teacher_work_place', '`teacher_work_place`', '`teacher_work_place`', 200, -1, FALSE, '`teacher_work_place`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['teacher_work_place'] = &$this->teacher_work_place;

		// teacher_active
		$this->teacher_active = new cField('tbl_teacher', 'tbl_teacher', 'x_teacher_active', 'teacher_active', '`teacher_active`', '`teacher_active`', 3, -1, FALSE, '`teacher_active`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->teacher_active->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['teacher_active'] = &$this->teacher_active;

		// teacher_acadamic_title
		$this->teacher_acadamic_title = new cField('tbl_teacher', 'tbl_teacher', 'x_teacher_acadamic_title', 'teacher_acadamic_title', '`teacher_acadamic_title`', '`teacher_acadamic_title`', 200, -1, FALSE, '`teacher_acadamic_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['teacher_acadamic_title'] = &$this->teacher_acadamic_title;

		// teacher_birthday
		$this->teacher_birthday = new cField('tbl_teacher', 'tbl_teacher', 'x_teacher_birthday', 'teacher_birthday', '`teacher_birthday`', '`teacher_birthday`', 200, -1, FALSE, '`teacher_birthday`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['teacher_birthday'] = &$this->teacher_birthday;

		// teacher_sex
		$this->teacher_sex = new cField('tbl_teacher', 'tbl_teacher', 'x_teacher_sex', 'teacher_sex', '`teacher_sex`', '`teacher_sex`', 3, -1, FALSE, '`teacher_sex`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->teacher_sex->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['teacher_sex'] = &$this->teacher_sex;

		// teacher_faculty
		$this->teacher_faculty = new cField('tbl_teacher', 'tbl_teacher', 'x_teacher_faculty', 'teacher_faculty', '`teacher_faculty`', '`teacher_faculty`', 3, -1, FALSE, '`teacher_faculty`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->teacher_faculty->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['teacher_faculty'] = &$this->teacher_faculty;

		// teacher_dept
		$this->teacher_dept = new cField('tbl_teacher', 'tbl_teacher', 'x_teacher_dept', 'teacher_dept', '`teacher_dept`', '`teacher_dept`', 3, -1, FALSE, '`teacher_dept`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->teacher_dept->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['teacher_dept'] = &$this->teacher_dept;

		// teacher_rate
		$this->teacher_rate = new cField('tbl_teacher', 'tbl_teacher', 'x_teacher_rate', 'teacher_rate', '`teacher_rate`', '`teacher_rate`', 4, -1, FALSE, '`teacher_rate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->teacher_rate->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['teacher_rate'] = &$this->teacher_rate;

		// teacher_personality
		$this->teacher_personality = new cField('tbl_teacher', 'tbl_teacher', 'x_teacher_personality', 'teacher_personality', '`teacher_personality`', '`teacher_personality`', 201, -1, FALSE, '`teacher_personality`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['teacher_personality'] = &$this->teacher_personality;

		// advices
		$this->advices = new cField('tbl_teacher', 'tbl_teacher', 'x_advices', 'advices', '`advices`', '`advices`', 201, -1, FALSE, '`advices`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['advices'] = &$this->advices;

		// teacher_research
		$this->teacher_research = new cField('tbl_teacher', 'tbl_teacher', 'x_teacher_research', 'teacher_research', '`teacher_research`', '`teacher_research`', 201, -1, FALSE, '`teacher_research`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['teacher_research'] = &$this->teacher_research;
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
		return "`tbl_teacher`";
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
	var $UpdateTable = "`tbl_teacher`";

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
			$sql .= ew_QuotedName('teacher_id') . '=' . ew_QuotedValue($rs['teacher_id'], $this->teacher_id->FldDataType) . ' AND ';
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
		return "`teacher_id` = @teacher_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->teacher_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@teacher_id@", ew_AdjustSql($this->teacher_id->CurrentValue), $sKeyFilter); // Replace key value
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
			return "tbl_teacherlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tbl_teacherlist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("tbl_teacherview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "tbl_teacheradd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("tbl_teacheredit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("tbl_teacheradd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tbl_teacherdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->teacher_id->CurrentValue)) {
			$sUrl .= "teacher_id=" . urlencode($this->teacher_id->CurrentValue);
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
			$arKeys[] = @$_GET["teacher_id"]; // teacher_id

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
			$this->teacher_id->CurrentValue = $key;
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

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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

		// teacher_description
		$this->teacher_description->ViewValue = $this->teacher_description->CurrentValue;
		$this->teacher_description->ViewCustomAttributes = "";

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

		// teacher_personality
		$this->teacher_personality->ViewValue = $this->teacher_personality->CurrentValue;
		$this->teacher_personality->ViewCustomAttributes = "";

		// advices
		$this->advices->ViewValue = $this->advices->CurrentValue;
		$this->advices->ViewCustomAttributes = "";

		// teacher_research
		$this->teacher_research->ViewValue = $this->teacher_research->CurrentValue;
		$this->teacher_research->ViewCustomAttributes = "";

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

		// teacher_description
		$this->teacher_description->LinkCustomAttributes = "";
		$this->teacher_description->HrefValue = "";
		$this->teacher_description->TooltipValue = "";

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

		// teacher_personality
		$this->teacher_personality->LinkCustomAttributes = "";
		$this->teacher_personality->HrefValue = "";
		$this->teacher_personality->TooltipValue = "";

		// advices
		$this->advices->LinkCustomAttributes = "";
		$this->advices->HrefValue = "";
		$this->advices->TooltipValue = "";

		// teacher_research
		$this->teacher_research->LinkCustomAttributes = "";
		$this->teacher_research->HrefValue = "";
		$this->teacher_research->TooltipValue = "";

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
				if ($this->teacher_id->Exportable) $Doc->ExportCaption($this->teacher_id);
				if ($this->teacher_name->Exportable) $Doc->ExportCaption($this->teacher_name);
				if ($this->teacher_personal_page->Exportable) $Doc->ExportCaption($this->teacher_personal_page);
				if ($this->teacher_avatar->Exportable) $Doc->ExportCaption($this->teacher_avatar);
				if ($this->teacher_description->Exportable) $Doc->ExportCaption($this->teacher_description);
				if ($this->teacher_work_place->Exportable) $Doc->ExportCaption($this->teacher_work_place);
				if ($this->teacher_active->Exportable) $Doc->ExportCaption($this->teacher_active);
				if ($this->teacher_acadamic_title->Exportable) $Doc->ExportCaption($this->teacher_acadamic_title);
				if ($this->teacher_birthday->Exportable) $Doc->ExportCaption($this->teacher_birthday);
				if ($this->teacher_sex->Exportable) $Doc->ExportCaption($this->teacher_sex);
				if ($this->teacher_faculty->Exportable) $Doc->ExportCaption($this->teacher_faculty);
				if ($this->teacher_dept->Exportable) $Doc->ExportCaption($this->teacher_dept);
				if ($this->teacher_rate->Exportable) $Doc->ExportCaption($this->teacher_rate);
				if ($this->teacher_personality->Exportable) $Doc->ExportCaption($this->teacher_personality);
				if ($this->advices->Exportable) $Doc->ExportCaption($this->advices);
				if ($this->teacher_research->Exportable) $Doc->ExportCaption($this->teacher_research);
			} else {
				if ($this->teacher_id->Exportable) $Doc->ExportCaption($this->teacher_id);
				if ($this->teacher_name->Exportable) $Doc->ExportCaption($this->teacher_name);
				if ($this->teacher_personal_page->Exportable) $Doc->ExportCaption($this->teacher_personal_page);
				if ($this->teacher_avatar->Exportable) $Doc->ExportCaption($this->teacher_avatar);
				if ($this->teacher_work_place->Exportable) $Doc->ExportCaption($this->teacher_work_place);
				if ($this->teacher_active->Exportable) $Doc->ExportCaption($this->teacher_active);
				if ($this->teacher_acadamic_title->Exportable) $Doc->ExportCaption($this->teacher_acadamic_title);
				if ($this->teacher_birthday->Exportable) $Doc->ExportCaption($this->teacher_birthday);
				if ($this->teacher_sex->Exportable) $Doc->ExportCaption($this->teacher_sex);
				if ($this->teacher_faculty->Exportable) $Doc->ExportCaption($this->teacher_faculty);
				if ($this->teacher_dept->Exportable) $Doc->ExportCaption($this->teacher_dept);
				if ($this->teacher_rate->Exportable) $Doc->ExportCaption($this->teacher_rate);
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
					if ($this->teacher_id->Exportable) $Doc->ExportField($this->teacher_id);
					if ($this->teacher_name->Exportable) $Doc->ExportField($this->teacher_name);
					if ($this->teacher_personal_page->Exportable) $Doc->ExportField($this->teacher_personal_page);
					if ($this->teacher_avatar->Exportable) $Doc->ExportField($this->teacher_avatar);
					if ($this->teacher_description->Exportable) $Doc->ExportField($this->teacher_description);
					if ($this->teacher_work_place->Exportable) $Doc->ExportField($this->teacher_work_place);
					if ($this->teacher_active->Exportable) $Doc->ExportField($this->teacher_active);
					if ($this->teacher_acadamic_title->Exportable) $Doc->ExportField($this->teacher_acadamic_title);
					if ($this->teacher_birthday->Exportable) $Doc->ExportField($this->teacher_birthday);
					if ($this->teacher_sex->Exportable) $Doc->ExportField($this->teacher_sex);
					if ($this->teacher_faculty->Exportable) $Doc->ExportField($this->teacher_faculty);
					if ($this->teacher_dept->Exportable) $Doc->ExportField($this->teacher_dept);
					if ($this->teacher_rate->Exportable) $Doc->ExportField($this->teacher_rate);
					if ($this->teacher_personality->Exportable) $Doc->ExportField($this->teacher_personality);
					if ($this->advices->Exportable) $Doc->ExportField($this->advices);
					if ($this->teacher_research->Exportable) $Doc->ExportField($this->teacher_research);
				} else {
					if ($this->teacher_id->Exportable) $Doc->ExportField($this->teacher_id);
					if ($this->teacher_name->Exportable) $Doc->ExportField($this->teacher_name);
					if ($this->teacher_personal_page->Exportable) $Doc->ExportField($this->teacher_personal_page);
					if ($this->teacher_avatar->Exportable) $Doc->ExportField($this->teacher_avatar);
					if ($this->teacher_work_place->Exportable) $Doc->ExportField($this->teacher_work_place);
					if ($this->teacher_active->Exportable) $Doc->ExportField($this->teacher_active);
					if ($this->teacher_acadamic_title->Exportable) $Doc->ExportField($this->teacher_acadamic_title);
					if ($this->teacher_birthday->Exportable) $Doc->ExportField($this->teacher_birthday);
					if ($this->teacher_sex->Exportable) $Doc->ExportField($this->teacher_sex);
					if ($this->teacher_faculty->Exportable) $Doc->ExportField($this->teacher_faculty);
					if ($this->teacher_dept->Exportable) $Doc->ExportField($this->teacher_dept);
					if ($this->teacher_rate->Exportable) $Doc->ExportField($this->teacher_rate);
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
