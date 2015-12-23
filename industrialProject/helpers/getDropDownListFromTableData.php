<?php

	/*
	*	create drop down list containing all values under 'column_name' in table 'table_name'
	*/
	function dataDropdown($table_name, $column_name, $pred="",$echo = false)
	{

		$lower_column_name=strtolower($column_name);
		$selectDropdown = "<select name=\"$lower_column_name\">";
		$query = "SELECT $column_name FROM `$table_name`".$pred;// WHERE Expired IS NULL";
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
		$query = "SELECT $comma_separated FROM `$table_name` WHERE Expired IS NULL";
		
		$selectDropdown = "<select name=\"$select_name\" size=\"$size\">";

		$row_comma_separated = implode(", ", $columns_name_array);
		
		//echo $query;
		$result = mysql_query($query) or die (mysql_error());

		while ($row = mysql_fetch_array($result)){
			$selectDropdown .= '<option>';
			foreach ($columns_name_array as $value) {
				$selectDropdown .= $value.': '.$row[$value].', ';
			}
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