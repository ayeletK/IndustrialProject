<?php
	function enumDropdown($table_name, $column_name, $echo = false)
	{
		$lower_column_name=strtolower($column_name);
		$selectDropdown = "<select name=\"$lower_column_name\">";
		$result = mysql_query("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
			WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name'")
		or die (mysql_error());

		$row = mysql_fetch_array($result);
		$enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));

		foreach($enumList as $value)
			$selectDropdown .= "<option value=\"$value\">$value</option>";

		$selectDropdown .= "</select>";

		if ($echo)
			echo $selectDropdown;

		return $selectDropdown;
	}
?>