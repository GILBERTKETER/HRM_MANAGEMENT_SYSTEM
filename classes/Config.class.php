<?php
// this class contains configuration data

class Config
{

	// database

	const DB_HOST = "localhost"; // database host or server
	const DB_NAME = "ntsystem"; // the actual name of the system's database [database name]
	const DB_USER = "root"; // the actual name of database user
	const DB_PASSWORD = ""; // database password


	// SYSTEM 

	const SYSTEM_NAME = "HRM";
	const SLOGAN = "HRM"; // THIS CAN BE SYSTEM'S TITLE\ 



	// they are constant methods that are used all over in the system
	public static function redir($page)
	{
		header("Location: $page");
	}

	public static function includeD()
	{
	}


	// this represents the number of seconds in a month
	public static function getMonth()
	{
		return 2419200;
	}

	// this represents the number of seconds in a month
	public static function getWeek()
	{
		return 604800;
	}
}
