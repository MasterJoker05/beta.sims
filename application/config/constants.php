<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


// encrypt_key
defined('ENCRYPT_KEY')      OR define('ENCRYPT_KEY', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855'); 

/*
|---------------------------------------------------------------------------
| User Defined Constant
|---------------------------------------------------------------------------
*/

define('FIVE_HUNDRED'		,	500);
define('SEVEN_HUNDRED'		,	700);
define('ONE_THOUSAND'		,	1000);
define('TWO_THOUSAND'		,	2000);
define('THREE_THOUSAND'		,	3000);
define('ONE_THOUSAND_FIVE'	,	1500);
define('TWO_THOUSAND_FIVE'	,	2500);

define('DECIMAL_PLACES'	,	2);
define('LANDBANK_OTC'	,	2);
define('LANDBANK_ATM'	,	1);
define('LANDBANK_MSC'	,	1);
define('LANDBANK_TKN'	,	2);
define('TUITION_FEE'	,	10000);

define('DBHSU'			, 	'umakunil_hsu_enrollment.');
define('DBTASC'			, 	'umakunil_new_hsu_database.');
define('DBFE'			, 	'umakunil_feval.');

define('MASTER_KEY'		,	'BAMBINO041517');

define('MKT_TOKEN_FEE_ID'	,	20);
define('NONMKT_TOKEN_FEE_ID',	21);
define('TUITION_FEE_ID'		,	47);
define('CMAT_ID'			, 	38);
define('NSTP_ID'			, 	51);
define('UNIVERSITY_ID'		, 	37);
define('IBAYAD_FEE_ID'		, 	77);
define('IBAYAD_FEE_AMOUNT'	, 	10.00);
define('IBAYAD_10P_AMOUNT'	, 	0.01);
define('IBAYAD_FEE_NAME'	, 	'Convenience Fee - iBayad');

define('PIA_ID'		, 	57);
define('PIA2_ID'	, 	26);

define('LAB_FEE1_ID'	, 	19);
define('LAB_FEE2_ID'	, 	27);
define('LAB_FEE3_ID'	, 	30);

define('FUND_TYPE_GEN'		, 	1);
define('FUND_TYPE_UNIV'		, 	2);
define('FUND_TYPE_NSTP'		, 	3);
define('FUND_TYPE_ORG'		, 	4);
define('FUND_TYPE_PAYING'	, 	5);
define('FUND_TYPE_PIA'		, 	6);
define('FUND_TYPE_LAB_FEE'	, 	7);
define('FUND_TYPE_IBAYAD'	, 	8);

// define('MASTER_KEY'	,	'ITCTEST123');