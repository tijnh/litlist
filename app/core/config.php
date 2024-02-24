<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') 
{
	/** database config for development **/
	define('DBNAME', 'litlist');
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBDRIVER', '');
	
	define('ROOT', 'http://localhost/litlist/public');

} 
else 
{
	/** database config for segbroek**/
	define('DBNAME', 'wae_litlist');
	define('DBHOST', 'localhost');
	define('DBUSER', 'wae_admin');
	define('DBPASS', 'll0Kbbgxnc');
	define('DBDRIVER', '');
	
	define('ROOT', 'http://inf.segbroek.nl/~wae/public');
}

/** true means show errors **/
define('DEBUG', true);

DEBUG ? ini_set('display_errors', 1) : ini_set('display_errors', 0);

