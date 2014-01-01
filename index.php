<?php 
require 'config.php';
echo '<html>'; 
// Header
echo '<body>';
$m = isset($_GET['m']) ? $_GET['m'] : null;
if (!isset($m) || empty($m)) {
$html->head_html('INDEX'); 
// Deskripsi Atas (Banner)
if ($_GET['w'] == 'no' || !isset($_GET['w']) || empty($_GET['w'])) {
	$html->DescNormal();
} else $html->DescWidget();
// Tampilkan Status
$html->Status($_GET['w'], $_GET['s'], $_GET['n']);
// Tampilkan Form
$html->Index_Form($_GET, $_SESSION[$nama_session]);
// Footer
if ($_GET['w'] == 'no' || !isset($_GET['w']) || empty($_GET['w'])) {
$html->FooterNormal($version);
	}
else $html->FooterWidget($version);
}
switch($m) {

// Tampilkan Menu Personal
case 'p':
$html->head_html('PERSONAL BOX'); 
if (!empty($_GET['no']) && is_numeric($_GET['no']) && strlen($_GET['no']) == 7) {
	$html->personal_show($_GET['no']);
if ($_GET['in'] == 'y') {		
	$showDb->ShowPersonalDb('inbox', 'SenderNumber', $_GET['no'], 'ReceivingDateTime', 'SenderNumber', 0);
	}		
if ($_GET['st'] == 'y') {	
	$showDb->ShowPersonalDb('sentitems', 'DestinationNumber', $_GET['no'], 'SendingDateTime', 'DestinationNumber', 1);
	}
}
else {
	$html->personal_form();	
}
$html->FooterNormal($version);
break;

// About or Bantuan
case 'a':
$html->head_html('BANTUAN DAN TENTANG SMS FREE GXRG');
include 'about.php';
$html->FooterNormal($version);
break;

// Admin
case 'adm':
$html->head_html('HALAMAN ADMINISTRATOR');
if (isset($_POST['log'])) {
if ($_POST['log'] == $formula_admin) {
$_SESSION[$nama_session_admin] = $_POST['log'];
	}
	else echo '<b>Salah Password</b> <br />';
}
if (isset($_SESSION[$nama_session_admin]) && $_SESSION[$nama_session_admin] == $formula_admin) {
echo "
<a href='".$_SERVER['PHP_SELF']."?m=adm&logout=yes'><blink>Logout</blink></a> | <a href='".$_SERVER['PHP_SELF']."?m=adm'>Beranda</a> | <a href='".$_SERVER['PHP_SELF']."?m=adm&ms=2'>Kotak Keluar</a> | <a href='".$_SERVER['PHP_SELF']."?m=adm&ms=1'>Kotak Masuk</a><br /><br />
	";
if (!isset($_GET['logout']) && !isset($_GET['ms'])) {
$html->AdminIndex();
	}
elseif ($_GET['ms'] == '1') {
$showDb->ShowAllDatabase('inbox', 10, 20, 'ReceivingDateTime', 'SenderNumber', $_GET['ms'], 0);
	}
elseif ($_GET['ms'] == '2') {
$showDb->ShowAllDatabase('sentitems', 10, 20, 'SendingDateTime', 'DestinationNumber', $_GET['ms'], 1);
	}
}
else {
$html->LoginAdmin();
}
if ($_GET['logout'] == 'yes') {
echo "
Sedang Logout ....<br /><br />
<meta http-equiv='refresh' content='2;url=".$_SERVER['PHP_SELF']."?m=adm'>"
	;
unset($_SESSION[$nama_session_admin]);
session_destroy();
}
$html->FooterNormal($version);
break;

} 
echo '</body>
</html>';
?>