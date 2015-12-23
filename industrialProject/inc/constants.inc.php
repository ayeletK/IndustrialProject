<?php

    // Database credentials
    define("dbhost", "localhost");
	define("dbuser", "root");
	define("dbpass", "hila&ayelet");
	define("db", "industrial_project");
	
	//TODO: add tables names constants
	
	// Users table fields credentials
	define("__users_tl_user_id", "user_id");
	define("__users_tl_real_name", "real_name");
	define("__users_tl_user_name", "user_name");
	define("__users_tl_password", "password");
	define("__users_tl_amdocs_mail", "amdocs_mail");
	define("__users_tl_phone", "phone");
	define("__users_tl_role", "role");
	define("__users_tl_account", "account");
	define("__users_tl_date_modified", "date_modified");
	define("__users_tl_modifying_user", "modifying_user");
	define("__users_tl_date_created", "date_created");
	define("__users_tl_creating_user", "creating_user");
	define("__users_tl_expired", "expired");
	
	//cluster table fields credentials
    define("__cluster_tl_cluster_name", "cluster_name");
    define("__cluster_tl_account_name", "account_name");
    define("__cluster_tl_account_id", "account_id");
    define("__cluster_tl_expired_date", "expired");
	
	
	// Schedule table fields credentials
	define("__clusters_tl_schedule_name", "schedule_name");
	define("__clusters_tl_schedule_id", "schedule_id");
	define("__clusters_tl_start_date", "start_date");
	define("__clusters_tl_start_time", "start_time");
	define("__clusters_tl_end_date", "end_date");
	define("__clusters_tl_end_time", "end_time");
	define("__clusters_tl_account_id", "account_id");
	define("__clusters_tl_manager", "manager");
	define("__clusters_tl_expired", "expired");
	
	// Tasks table fields credentials
	
	
?>