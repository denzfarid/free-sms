<?php
/* 
@Author 	: ray16.info
@Email		: l0g [at] ray16.info
@Homepage	: http://ray16.info/
@Twitter	: @rey_jerk
@Versi		: v3.26
@Deskripsi 	: Aplikasi Buat Send SMS dengan Gammu dan database Mysql
			  Dibuat Sebagai Aplikasi bulanan untuk http://projects.gxrg.org/
*/
session_start();
date_default_timezone_set('Asia/Jakarta');
// error_reporting(0);

// Isi Integer mulai dari 1 untuk disable
$maintenance = '0';
$pesan_maintenance = '<b> Server SMS Sedang Maintenance 5 Menit</b>';
$version = "v3.26";

// Password Administrator
$formula_admin = '';

// database server
define('SERVER', "");
define('USER', "");
define('PASS', "");
define('DB', "sms");

mysql_connect(SERVER,USER,PASS) or die ('mysql server is dead, please contact webmaster for funeral ;p');
mysql_select_db(DB) or die ('mysql db is dead, please contact webmaster for funeral ;p');

// Start Sesi
require 'html.php';
$html = new Html();

// Nama Session
$nama_session = 'FreeSMS';
$nama_session_admin = 'AdminFreeSMS';

// Session Set
$formula = strrev(substr(md5(base64_encode('Novita Vistarani - '.session_id())), 2, 15));
$_SESSION[$nama_session] = $formula;
$nomor = substr($_POST['no'], -7);


// Semua Fungsi
require 'lib.php';
$showDb = new ShowDatabase();
$kirim = new SendSMS();

?>
