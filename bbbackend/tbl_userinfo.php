<?php

// Global variable for table object
$tbl_user = NULL;

//
// Table class for tbl_user
//
class ctbl_user extends cTable {
	var $user_id;
	var $user_id_fb;
	var $username;
	var $password;
	var $user_real_name;
	var $user_avatar;
	var $user_cover;
	var $user_student_code;
	var $user_university;
	var $user_gender;
	var $user_dob;
	var $user_hometown;
	var $user_phone;
	var $user_description;
	var $user_faculty;
	var $user_class;
	var $user_active;
	var $user_status;
	var $user_group;
	var $user_token;
	var $user_activator;
	var $user_qoutes;
	var $user_date_attend;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tbl_user';
		$this->TableName = 'tbl_user';
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

		// user_id
		$this->user_id = new cField('tbl_user', 'tbl_user', 'x_user_id', 'user_id', '`user_id`', '`user_id`', 3, -1, FALSE, '`user_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->user_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['user_id'] = &$this->user_id;

		// user_id_fb
		$this->user_id_fb = new cField('tbl_user', 'tbl_user', 'x_user_id_fb', 'user_id_fb', '`user_id_fb`', '`user_id_fb`', 200, -1, FALSE, '`user_id_fb`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['user_id_fb'] = &$this->user_id_fb;

		// username
		$this->username = new cField('tbl_user', 'tbl_user', 'x_username', 'username', '`username`', '`username`', 200, -1, FALSE, '`username`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['username'] = &$this->username;

		// password
		$this->password = new cField('tbl_user', 'tbl_user', 'x_password', 'password', '`password`', '`password`', 200, -1, FALSE, '`password`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['password'] = &$this->password;

		// user_real_name
		$this->user_real_name = new cField('tbl_user', 'tbl_user', 'x_user_real_name', 'user_real_name', '`user_real_name`', '`user_real_name`', 200, -1, FALSE, '`user_real_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['user_real_name'] = &$this->user_real_name;

		// user_avatar
		$this->user_avatar = new cField('tbl_user', 'tbl_user', 'x_user_avatar', 'user_avatar', '`user_avatar`', '`user_avatar`', 200, -1, FALSE, '`user_avatar`', FALSE, FALSE, FALSE, 'IMAGE');
		$this->fields['user_avatar'] = &$this->user_avatar;

		// user_cover
		$this->user_cover = new cField('tbl_user', 'tbl_user', 'x_user_cover', 'user_cover', '`user_cover`', '`user_cover`', 200, -1, FALSE, '`user_cover`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['user_cover'] = &$this->user_cover;

		// user_student_code
		$this->user_student_code = new cField('tbl_user', 'tbl_user', 'x_user_student_code', 'user_student_code', '`user_student_code`', '`user_student_code`', 200, -1, FALSE, '`user_student_code`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['user_student_code'] = &$this->user_student_code;

		// user_university
		$this->user_university = new cField('tbl_user', 'tbl_user', 'x_user_university', 'user_university', '`user_university`', '`user_university`', 3, -1, FALSE, '`user_university`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->user_university->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['user_university'] = &$this->user_university;

		// user_gender
		$this->user_gender = new cField('tbl_user', 'tbl_user', 'x_user_gender', 'user_gender', '`user_gender`', '`user_gender`', 200, -1, FALSE, '`user_gender`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['user_gender'] = &$this->user_gender;

		// user_dob
		$this->user_dob = new cField('tbl_user', 'tbl_user', 'x_user_dob', 'user_dob', '`user_dob`', '`user_dob`', 200, -1, FALSE, '`user_dob`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['user_dob'] = &$this->user_dob;

		// user_hometown
		$this->user_hometown = new cField('tbl_user', 'tbl_user', 'x_user_hometown', 'user_hometown', '`user_hometown`', '`user_hometown`', 200, -1, FALSE, '`user_hometown`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['user_hometown'] = &$this->user_hometown;

		// user_phone
		$this->user_phone = new cField('tbl_user', 'tbl_user', 'x_user_phone', 'user_phone', '`user_phone`', '`user_phone`', 200, -1, FALSE, '`user_phone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['user_phone'] = &$this->user_phone;

		// user_description
		$this->user_description = new cField('tbl_user', 'tbl_user', 'x_user_description', 'user_description', '`user_description`', '`user_description`', 200, -1, FALSE, '`user_description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['user_description'] = &$this->user_description;

		// user_faculty
		$this->user_faculty = new cField('tbl_user', 'tbl_user', 'x_user_faculty', 'user_faculty', '`user_faculty`', '`user_faculty`', 3, -1, FALSE, '`user_faculty`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->user_faculty->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['user_faculty'] = &$this->user_faculty;

		// user_class
		$this->user_class = new cField('tbl_user', 'tbl_user', 'x_user_class', 'user_class', '`user_class`', '`user_class`', 3, -1, FALSE, '`user_class`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->user_class->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['user_class'] = &$this->user_class;

		// user_active
		$this->user_active = new cField('tbl_user', 'tbl_user', 'x_user_active', 'user_active', '`user_active`', '`user_active`', 3, -1, FALSE, '`user_active`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->user_active->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['user_active'] = &$this->user_active;

		// user_status
		$this->user_status = new cField('tbl_user', 'tbl_user', 'x_user_status', 'user_status', '`user_status`', '`user_status`', 3, -1, FALSE, '`user_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->user_status->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['user_status'] = &$this->user_status;

		// user_group
		$this->user_group = new cField('tbl_user', 'tbl_user', 'x_user_group', 'user_group', '`user_group`', '`user_group`', 3, -1, FALSE, '`user_group`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->user_group->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['user_group'] = &$this->user_group;

		// user_token
		$this->user_token = new cField('tbl_user', 'tbl_user', 'x_user_token', 'user_token', '`user_token`', '`user_token`', 200, -1, FALSE, '`user_token`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['user_token'] = &$this->user_token;

		// user_activator
		$this->user_activator = new cField('tbl_user', 'tbl_user', 'x_user_activator', 'user_activator', '`user_activator`', '`user_activator`', 200, -1, FALSE, '`user_activator`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['user_activator'] = &$this->user_activator;

		// user_qoutes
		$this->user_qoutes = new cField('tbl_user', 'tbl_user', 'x_user_qoutes', 'user_qoutes', '`user_qoutes`', '`user_qoutes`', 201, -1, FALSE, '`user_qoutes`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['user_qoutes'] = &$this->user_qoutes;

		// user_date_attend
		$this->user_date_attend = new cField('tbl_user', 'tbl_user', 'x_user_date_attend', 'user_date_attend', '`user_date_attend`', '`user_date_attend`', 200, -1, FALSE, '`user_date_attend`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['user_date_attend'] = &$this->user_date_attend;
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
		return "`tbl_user`";
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
	var $UpdateTable = "`tbl_user`";

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
			$sql .= ew_QuotedName('user_id') . '=' . ew_QuotedValue($rs['user_id'], $this->user_id->FldDataType) . ' AND ';
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
		return "`user_id` = @user_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->user_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@user_id@", ew_AdjustSql($this->user_id->CurrentValue), $sKeyFilter); // Replace key value
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
			return "tbl_userlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tbl_userlist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("tbl_userview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "tbl_useradd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("tbl_useredit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("tbl_useradd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tbl_userdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->user_id->CurrentValue)) {
			$sUrl .= "user_id=" . urlencode($this->user_id->CurrentValue);
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
			$arKeys[] = @$_GET["user_id"]; // user_id

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
			$this->user_id->CurrentValue = $key;
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

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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

		// user_qoutes
		$this->user_qoutes->ViewValue = $this->user_qoutes->CurrentValue;
		$this->user_qoutes->ViewCustomAttributes = "";

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

		// user_qoutes
		$this->user_qoutes->LinkCustomAttributes = "";
		$this->user_qoutes->HrefValue = "";
		$this->user_qoutes->TooltipValue = "";

		// user_date_attend
		$this->user_date_attend->LinkCustomAttributes = "";
		$this->user_date_attend->HrefValue = "";
		$this->user_date_attend->TooltipValue = "";

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
				if ($this->user_id->Exportable) $Doc->ExportCaption($this->user_id);
				if ($this->user_id_fb->Exportable) $Doc->ExportCaption($this->user_id_fb);
				if ($this->username->Exportable) $Doc->ExportCaption($this->username);
				if ($this->password->Exportable) $Doc->ExportCaption($this->password);
				if ($this->user_real_name->Exportable) $Doc->ExportCaption($this->user_real_name);
				if ($this->user_avatar->Exportable) $Doc->ExportCaption($this->user_avatar);
				if ($this->user_cover->Exportable) $Doc->ExportCaption($this->user_cover);
				if ($this->user_student_code->Exportable) $Doc->ExportCaption($this->user_student_code);
				if ($this->user_university->Exportable) $Doc->ExportCaption($this->user_university);
				if ($this->user_gender->Exportable) $Doc->ExportCaption($this->user_gender);
				if ($this->user_dob->Exportable) $Doc->ExportCaption($this->user_dob);
				if ($this->user_hometown->Exportable) $Doc->ExportCaption($this->user_hometown);
				if ($this->user_phone->Exportable) $Doc->ExportCaption($this->user_phone);
				if ($this->user_description->Exportable) $Doc->ExportCaption($this->user_description);
				if ($this->user_faculty->Exportable) $Doc->ExportCaption($this->user_faculty);
				if ($this->user_class->Exportable) $Doc->ExportCaption($this->user_class);
				if ($this->user_active->Exportable) $Doc->ExportCaption($this->user_active);
				if ($this->user_status->Exportable) $Doc->ExportCaption($this->user_status);
				if ($this->user_group->Exportable) $Doc->ExportCaption($this->user_group);
				if ($this->user_token->Exportable) $Doc->ExportCaption($this->user_token);
				if ($this->user_activator->Exportable) $Doc->ExportCaption($this->user_activator);
				if ($this->user_qoutes->Exportable) $Doc->ExportCaption($this->user_qoutes);
				if ($this->user_date_attend->Exportable) $Doc->ExportCaption($this->user_date_attend);
			} else {
				if ($this->user_id->Exportable) $Doc->ExportCaption($this->user_id);
				if ($this->user_id_fb->Exportable) $Doc->ExportCaption($this->user_id_fb);
				if ($this->username->Exportable) $Doc->ExportCaption($this->username);
				if ($this->password->Exportable) $Doc->ExportCaption($this->password);
				if ($this->user_real_name->Exportable) $Doc->ExportCaption($this->user_real_name);
				if ($this->user_avatar->Exportable) $Doc->ExportCaption($this->user_avatar);
				if ($this->user_cover->Exportable) $Doc->ExportCaption($this->user_cover);
				if ($this->user_student_code->Exportable) $Doc->ExportCaption($this->user_student_code);
				if ($this->user_university->Exportable) $Doc->ExportCaption($this->user_university);
				if ($this->user_gender->Exportable) $Doc->ExportCaption($this->user_gender);
				if ($this->user_dob->Exportable) $Doc->ExportCaption($this->user_dob);
				if ($this->user_hometown->Exportable) $Doc->ExportCaption($this->user_hometown);
				if ($this->user_phone->Exportable) $Doc->ExportCaption($this->user_phone);
				if ($this->user_description->Exportable) $Doc->ExportCaption($this->user_description);
				if ($this->user_faculty->Exportable) $Doc->ExportCaption($this->user_faculty);
				if ($this->user_class->Exportable) $Doc->ExportCaption($this->user_class);
				if ($this->user_active->Exportable) $Doc->ExportCaption($this->user_active);
				if ($this->user_status->Exportable) $Doc->ExportCaption($this->user_status);
				if ($this->user_group->Exportable) $Doc->ExportCaption($this->user_group);
				if ($this->user_token->Exportable) $Doc->ExportCaption($this->user_token);
				if ($this->user_activator->Exportable) $Doc->ExportCaption($this->user_activator);
				if ($this->user_date_attend->Exportable) $Doc->ExportCaption($this->user_date_attend);
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
					if ($this->user_id->Exportable) $Doc->ExportField($this->user_id);
					if ($this->user_id_fb->Exportable) $Doc->ExportField($this->user_id_fb);
					if ($this->username->Exportable) $Doc->ExportField($this->username);
					if ($this->password->Exportable) $Doc->ExportField($this->password);
					if ($this->user_real_name->Exportable) $Doc->ExportField($this->user_real_name);
					if ($this->user_avatar->Exportable) $Doc->ExportField($this->user_avatar);
					if ($this->user_cover->Exportable) $Doc->ExportField($this->user_cover);
					if ($this->user_student_code->Exportable) $Doc->ExportField($this->user_student_code);
					if ($this->user_university->Exportable) $Doc->ExportField($this->user_university);
					if ($this->user_gender->Exportable) $Doc->ExportField($this->user_gender);
					if ($this->user_dob->Exportable) $Doc->ExportField($this->user_dob);
					if ($this->user_hometown->Exportable) $Doc->ExportField($this->user_hometown);
					if ($this->user_phone->Exportable) $Doc->ExportField($this->user_phone);
					if ($this->user_description->Exportable) $Doc->ExportField($this->user_description);
					if ($this->user_faculty->Exportable) $Doc->ExportField($this->user_faculty);
					if ($this->user_class->Exportable) $Doc->ExportField($this->user_class);
					if ($this->user_active->Exportable) $Doc->ExportField($this->user_active);
					if ($this->user_status->Exportable) $Doc->ExportField($this->user_status);
					if ($this->user_group->Exportable) $Doc->ExportField($this->user_group);
					if ($this->user_token->Exportable) $Doc->ExportField($this->user_token);
					if ($this->user_activator->Exportable) $Doc->ExportField($this->user_activator);
					if ($this->user_qoutes->Exportable) $Doc->ExportField($this->user_qoutes);
					if ($this->user_date_attend->Exportable) $Doc->ExportField($this->user_date_attend);
				} else {
					if ($this->user_id->Exportable) $Doc->ExportField($this->user_id);
					if ($this->user_id_fb->Exportable) $Doc->ExportField($this->user_id_fb);
					if ($this->username->Exportable) $Doc->ExportField($this->username);
					if ($this->password->Exportable) $Doc->ExportField($this->password);
					if ($this->user_real_name->Exportable) $Doc->ExportField($this->user_real_name);
					if ($this->user_avatar->Exportable) $Doc->ExportField($this->user_avatar);
					if ($this->user_cover->Exportable) $Doc->ExportField($this->user_cover);
					if ($this->user_student_code->Exportable) $Doc->ExportField($this->user_student_code);
					if ($this->user_university->Exportable) $Doc->ExportField($this->user_university);
					if ($this->user_gender->Exportable) $Doc->ExportField($this->user_gender);
					if ($this->user_dob->Exportable) $Doc->ExportField($this->user_dob);
					if ($this->user_hometown->Exportable) $Doc->ExportField($this->user_hometown);
					if ($this->user_phone->Exportable) $Doc->ExportField($this->user_phone);
					if ($this->user_description->Exportable) $Doc->ExportField($this->user_description);
					if ($this->user_faculty->Exportable) $Doc->ExportField($this->user_faculty);
					if ($this->user_class->Exportable) $Doc->ExportField($this->user_class);
					if ($this->user_active->Exportable) $Doc->ExportField($this->user_active);
					if ($this->user_status->Exportable) $Doc->ExportField($this->user_status);
					if ($this->user_group->Exportable) $Doc->ExportField($this->user_group);
					if ($this->user_token->Exportable) $Doc->ExportField($this->user_token);
					if ($this->user_activator->Exportable) $Doc->ExportField($this->user_activator);
					if ($this->user_date_attend->Exportable) $Doc->ExportField($this->user_date_attend);
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
