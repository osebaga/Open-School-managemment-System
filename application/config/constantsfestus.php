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


define("HTTP_PROJECT_PATH",'http://'.$_SERVER['HTTP_HOST'].'/iae-oas/');
define("HTTP_UPLOAD_FOLDER",HTTP_PROJECT_PATH.'uploads/');
define("HTTP_PROFILE_IMG",HTTP_UPLOAD_FOLDER.'profile/');
define('UPLOAD_FOLDER','./uploads/');
define("SIMS_LOG_GENERAL",1);
define("REFERENCE_START",'016');
define("APPLICATION_FEE",10000);
define("APPLICATION_FEE_POSTGRADUATE",10000);
define("ONLINE_SUPPORT",'IT Support : +255 718 703 003, Admission Support : +255 767 071 727');
define("ADMISSION_REQUIREMENT",HTTP_UPLOAD_FOLDER.'docs/');
define('ADMISSION_REQUIREMENT_UNDERGRADUATE',ADMISSION_REQUIREMENT.'certificate_diploma_programme.pdf');
define('ADMISSION_REQUIREMENT_POSTGRADUATE',ADMISSION_REQUIREMENT.'bachelor_programme.pdf');

define('NECTA_API','http://api.necta.go.tz/api/public/');
define('NECTA_KEY','MjAxNzA3MTgxNTMxNTBFaGJxJFQyVUc5JHM1dTNsTUpiNXBiLlRWbUVUNWJPdXZDVGVYQ0QySmRPMk0zajZULlY4QnhFeGZUaHMwRE1ULkMkQUVVNXgzOC5FcnhUblVwQkp1dTNoVzJtYmtFNjZ5TDZjSXdnLnNieGRUMlAkR3ZtMnhwJE4kTGUudmZQQXB4aTBtSDl0LnpHb1VDdjVubTVZQVJ5dXlFMjFrdFVUeWltcHUkMVI4Q2J1JG1WR0lUZW4=');


define('NACTE_API','http://41.93.40.137/nacte_api/index.php/api/results/');
define('NACTE_TOKEN','fe7163fdc9abfd0e600c7fd3569993c848105a83');
define('NACTE_API_KEY','4Vh92fRmcL3dEO');
define('NACTE_API_EXTRA','15006302010101');

