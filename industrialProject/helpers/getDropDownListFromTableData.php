<?php

	include_once '../helpers/formatString.php';
	/*
	*	create drop down list containing all values under 'column_name' in table 'table_name'
	*/
	function dataDropdown($table_name, $column_name, $echo = false)
	{
		$lower_column_name=strtolower($column_name);
		$selectDropdown = "<select name=\"$lower_column_name\">";
		$query = "SELECT $column_name FROM `$table_name` WHERE Expired IS NULL";
		//echo $query;
		$result = mysql_query($query) or die (mysql_error());

		while ($row = mysql_fetch_array($result)){
			$selectDropdown .= "<option value=\"$row[$column_name]\">$row[$column_name] &nbsp</option>";
		}

		$selectDropdown .= "</select>";

		if ($echo)
			echo $selectDropdown;

		return $selectDropdown;
	}
	
	/*
	*	get columns from table
	*/
	function getColumnsFromTable($table_name, $columns_name_array, $size=1, $echo = false){
		
		$comma_separated = implode(",", $columns_name_array);
		$select_name = $table_name.'Data';
		$query = "SELECT $comma_separated FROM `$table_name` WHERE ".__users_tl_expired." IS NULL";
		
		$selectDropdown = "<select name=\"$select_name\" size=\"$size\">";

		$row_comma_separated = implode(", ", $columns_name_array);
		
		//echo $query;
		$result = mysql_query($query) or die (mysql_error());

		while ($row = mysql_fetch_array($result)){
			$selectDropdown .= '<option>';
			$optionValue = '';
			foreach ($columns_name_array as $value) {
				$formattedValue = niceValue($value).': '.$row[$value].', ';
				//$selectDropdown .= str_replace(" ", "&nbsp;", substr(str_pad($formattedValue, 50, " "), 0, 40)).'.';//str_pad((niceValue($value).': '.$row[$value].', '),35,".");
				$optionValue .= substr(str_pad($formattedValue, 80-strlen($optionValue), "_"), 0, 35);//str_pad((niceValue($value).': '.$row[$value].', '),35,".");
				
			}
			$trimmedVal = trim($optionValue, " \_\,\t\n\0");
			$selectDropdown .= $trimmedVal;
			$selectDropdown .= '</option>';
			
		}

		$selectDropdown .= "</select>";

		if ($echo)
			echo $selectDropdown;

		return $selectDropdown;
	}
	
	/*
	* create drop down list containing all values under 'column_name' in table 'table_name'
	* that fit the given filter.
	* <params>
	*		table_name - the name of the table we want to get the data from
	*		column_name - the name of the column we want to get the data from in the given table.
	*		filter - filter string to filter the data we get. This sould be the continue of the query.
	*				example: " WHERE $column_name LIKE 'a%' " - for all data rows start with char 'a'.
	* </params>
	*/
	function filteredDataDropdown($table_name, $column_name, $filter, $echo = false)
	{
		$lower_column_name=strtolower($column_name);
		$selectDropdown = "<select name=\"$lower_column_name\">";
		$query = 'SELECT $column_name FROM `$table_name` WHERE Expired IS NULL'.$filter;
		//echo $query;
		$result = mysql_query($query) or die (mysql_error());

		while ($row = mysql_fetch_array($result)){
			$selectDropdown .= "<option value=\"$row[$column_name]\">$row[$column_name] &nbsp</option>";
		}

		$selectDropdown .= "</select>";

		if ($echo)
			echo $selectDropdown;

		return $selectDropdown;
	}
?>