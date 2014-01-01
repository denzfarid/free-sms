<?php
// Maintenance Mode
if ($maintenance > 0){
	echo $pesan_maintenance;
	exit();
	mysql_close();
}

// HTML Class
class Html {

function head_html($title) {
echo "
	<head>
	<title>FREE SMS - ".$title." | GXRG</title>
	<link rel='stylesheet' type='text/css' href='style.css' />
<link REL='SHORTCUT ICON' HREF='http://s1.gxrg.org/favicon.ico'>
	</head>
	";
}

function Status($a, $b, $c) {

if ($b == '1'){
	print ("<font size='2'><b>(1) No Tujuan Kosong</b></font>\n");}
if ($b == '2'){
	print ("<font size='2'><b>(2) Isi Pesan Kosong</b></font>\n");}
if ($b == '3'){
	print ("<font size='2'><b>(3) No Tujuan Salah, Cek Menu <a href='".$_SERVER['PHP_SELF']."?m=a'>Bantuan</a></b></font>\n");}
if ($b == '4'){
	print ("<font size='2'><b>(4) No Tujuan Minimal 10 Angka, Max 13 Angka</b></font>\n");}
if ($b == '5'){
	print ("<font size='2'><b>(5) Isi Pesan Tidak Boleh Kosong</b></font>\n");}
if ($b == '6'){
if ($a == 'yes'){
	echo "<font size='2'><b>(6) SMS Terkirim</b></font>\n";
}
else echo "<font size='2'><b>(6) SMS Terkirim, cek Reply dari SMS <a href='".$_SERVER['PHP_SELF']."?m=p&no=".$c."&in=y'>disini</a></b></font>\n";
}
if ($b == '7'){
	print ("<font size='2'><b>(7) Jumlah SMS Harus Angka</b></font>\n");}
if ($b == '8'){
	print ("<font size='2'><b>(8) Maximal Jumlah SMS Adalah 2</b></font>\n");}
if ($b == '99'){
	print ("<font size='2'><b>(99) Anti BOMB</b></font>\n");}
if ($b == '1234'){
	print ("<font size='2'><b>(1234) Kamu Tidak Dapat Melakukan Itu</b></font>\n");}
	
}

function Index_Form($a, $b) {

echo "
	<form method='POST' action='send_sms.php'/>
	Tujuan:<br /> 
	<input type='text' class='input' name='no' size='17' /><br />
	Pesan: <br/>
	<textarea name='pesan' class='input' cols='20' rows='4'></textarea>
	<input type='hidden' value='";
if (empty($_GET['w']) || !isset($_GET['w'])) {echo 'no';} else echo $_GET['w'];
echo "' name='w' />
	<input type='hidden' value='".$b."' name='AntiHotLink' />
	<!-- Untuk Donasi
	<br />
	Jumlah Pesan:<br />
	<input type='text' name='jml' value='1' size='2'>
	Akhir Untuk Donasi!-->
	<br />
	<br />
	<input type='submit' name='kirim' value='Send' class='button' />
	</form>
	";

}

function personal_form() {
echo "
	Masukkan 7 angka akhir no handphone yang ingin dicek.<br />
	Contoh: <br />
	<i>0219<u>8765432</u></i> : <i>7865432</i><br />
	<i>+62856<u>4775821</u></i> : <i>4775821</i><br /><br />
	No handphone:<br />
	<form method='get' action='".$_SERVER['PHP_SELF']."'>
	<input type='hidden' value='p' name='m' />
	<input type='text' class='input' size='18' name='no' >   
	<input type='submit' value='Send' class='button' />
	</form>
	";
}

function personal_show($a) {

echo "	
		<script type='text/javascript'>
		function SendBaru() {
		window.open( 'index.php?w=yes', 'NewSMS',
		'status = 1, height = 300, width = 280, resizable = 1, scrollbars=1' )
		}
		</script>

			
		<a href='".$_SERVER['PHP_SELF']."?m=p&no=".$a."&st=y'>Pesan Terkirim</a> | <a href='".$_SERVER['PHP_SELF']."?m=p&no=".$a."&in=y'>Kotak Masuk</a> | <input type='button' class='button' onClick='SendBaru()' value='Kirim SMS Baru'> <br /><br />

		Pilih Menu Diatas Untuk Pesan Terkirim atau Pesan Masuk di Kotak Masuk<br />

		Apabila Kosong dan Tidak Tampil berarti Nomor Salah, atau Tidak Ada Pesan Masuk atau Pesan Terkirim ;p<br />

		<hr style='border: 1px solid #000; width:70%' align='left' /><br />
		";
}

function FooterNormal($version) {
$sql = mysql_query("SELECT COUNT(*) FROM sentitems");
list($mysql_fetch) = mysql_fetch_row($sql);

$sql2 = mysql_query("SELECT COUNT(*) FROM inbox");
list($mysql_fetch2) = mysql_fetch_row($sql2);

$total_sql = $mysql_fetch+$mysql_fetch2;

echo "
	<a href='".$_SERVER['PHP_SELF']."?m=p'>Personal Box</a> | <a href='".$_SERVER['PHP_SELF']."?m=a' />Bantuan</a> | <a href='".$_SERVER['PHP_SELF']."' />Index</a><br />
	Telah Melayani <b>".$total_sql."</b> SMS<br />
	Free SMS ".$version." - <a href='".$_SERVER['PHP_SELF']."?m=adm' />Login</a><br />
	(c) May 2010 - GXRG
	";
}

function FooterWidget($version) {

echo "
	<a href='".$_SERVER['PHP_SELF']."?m=p' target='_blank' />Personal Box</a> | <a href='".$_SERVER['PHP_SELF']."?m=a' />Bantuan</a><br />
	Free SMS ".$version."<br />
	(c) May 2010 - GXRG
	";
}

function DescNormal() {
$input = array(
"Akses Web ini di <a href='http://s1.gxrg.org/'/>s1.gxrg.org</a>.", 
"Cek Pesan Masuk dan Pesan Terkirim di Menu <a href='?m=p' />Personal Box</a>.", 
"Thanks for <a href='http://m.twitter.com/bebek_gila' target='_blank' />@bebek_terbang</a> untuk donasi Modemnya :).",
"Kamu baru menggunakan layanan ini? Klik Menu <a href='?m=a' />Bantuan</a>.");
$rand_keys = array_rand($input, 2);
echo $input[$rand_keys[0]] . "\n<br />";
echo "happy Texting :)<br /><br />";
	}

function DescWidget() {
echo "happy Texting :)<br /><br />";
	}

function LoginAdmin() {
echo "	
	Masukkan Password Admin:<br />
	<form method='POST' action='".$_SERVER['PHP_SELF']."?m=adm'>
	<input type='text' class='input' size='18' name='log' Autocomplete='off'>   
	<input type='submit' value='Send' class='button' />
	</form>
	";
	
}

function AdminIndex() {

echo "
Pilih Menu Kotak Keluar Untuk Menampilkan SEMUA Pesan Keluar
<br />
Atau Pilih Menu Kotak Masuk Untuk Menampilkan SEMUA Pesan Masuk
<br /><br />
	";

}	

}

?>