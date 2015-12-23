<?php
	function niceValue($value){
		$value = trim($value);
		$wordsArray = explode("_", $value);
		$wordsArray = array_map(function($word) {return ucfirst($word);}, $wordsArray);
		$result = implode(" ", $wordsArray);
		return $result;
	}
?>