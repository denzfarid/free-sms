<?php

class ShowDatabase {

function ShowPersonalDb($tabel, $argument, $input, $waktu, $nomor, $status) {
	$sql = "SELECT * FROM $tabel WHERE $argument LIKE '%$input' ORDER BY ID DESC";
	$result = mysql_query($sql);
			while($baris = mysql_fetch_array($result)) {
		echo "[".$baris['ID']."] ".$baris[$waktu]." - [".$baris[$nomor]."]<br />\n";
			if ($status >= 1) {
		if ($baris['Status'] == 'SendingOKNoReport') {
		$baris['Status'] = 'SMS Terkirim';
		}
		else {		
		$baris['Status'] = 'SMS Tidak Terkirim';
		}
		$delimiter = array("\n");
		$TextDecoded = str_replace($delimiter, '<br />', $baris['TextDecoded']);
		echo "Pesan: <b>".$TextDecoded."</b><br />\n";
		echo "Status: ".$baris['Status']."<br /><br />\n";
			} else echo "Pesan: <b>".$baris['TextDecoded']."</b><br /><br />\n";
				}		
	print "<hr style='border: 1px solid #000; width:70%' align=left />\n";
	}
	
function ShowAllDatabase($tbl_name, $adjacents, $limit, $waktu, $nomor, $p, $status) {

	$query = "SELECT COUNT(*) as num FROM $tbl_name";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	$targetpage = $_SERVER['PHP_SELF']; 		
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			
	else
		$start = 0;								

	$sql = "SELECT * FROM $tbl_name ORDER BY ID DESC LIMIT $start, $limit";
	$result = mysql_query($sql);
	
	if ($page == 0) $page = 1;					
	$prev = $page - 1;							
	$next = $page + 1;							
	$lastpage = ceil($total_pages/$limit);		
	$lpm1 = $lastpage - 1;						

	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";

		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?m=adm&ms=$p&page=$prev\">« previous</a>";
		else
			$pagination.= "<span class=\"disabled\">« previous</span>";	
		

		if ($lastpage < 7 + ($adjacents * 2))	
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter </span>";
				else
					$pagination.= "<a href=\"$targetpage?m=adm&ms=$p&page=$counter\">$counter </a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	
		{

			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter </span>";
					else
						$pagination.= "<a href=\"$targetpage?m=adm&ms=$p&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?m=adm&ms=$p&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?m=adm&ms=$p&page=$lastpage\">$lastpage</a>";		
			}

			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?m=adm&ms=$p&page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?m=adm&ms=$p&page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?m=adm&ms=$p&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?m=adm&ms=$p&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?m=adm&ms=$p&page=$lastpage\">$lastpage</a>";		
			}

			else
			{
				$pagination.= "<a href=\"$targetpage?m=adm&ms=$p&page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?m=adm&ms=$p&page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?m=adm&ms=$p&page=$counter\">$counter</a>";					
				}
			}
		}
		

		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?m=adm&ms=$p&page=$next\">next »</a>";
		else
			$pagination.= "<span class=\"disabled\">next »</span>";
		$pagination.= "</div>\n";		
	}

			while($baris = mysql_fetch_array($result)) {
		echo "[".$baris['ID']."] ".$baris[$waktu]." - [".$baris[$nomor]."]<br />\n";
			if ($status >= 1) {
		if ($baris['Status'] == 'SendingOKNoReport') {
		$baris['Status'] = 'SMS Terkirim';
		}
		else {		
		$baris['Status'] = 'SMS Tidak Terkirim';
		}
		$delimiter = array("\n");
		$TextDecoded = str_replace($delimiter, '<br />', $baris['TextDecoded']);
		echo "Pesan: <b>".$TextDecoded."</b><br />\n";
		echo "Status: ".$baris['Status']."<br /><br />\n";
			} else echo "Pesan: <b>".$baris['TextDecoded']."</b><br /><br />\n";
				}

echo $pagination."<br />";
}
	
}

class Admin {

function BanNomor() {

	if($_POST['no']) {
	
	$sql=mysql_query("INSERT INTO ban (no_hp) VALUES ('".$_POST['no']."')");
	
	if($sql) {
	
	echo "<b>No Dengan Awalan ".$_POST['no']." Telah diBAN </b><br />";
	
	}
	
	else 	{
	
	echo "<b>Gagal</b><br />";
	
		}
	}

}

}

class SendSMS {

function FilterInternasional($_POST) {
$ganti = array("+1", "+2", "+3", "+4", "+5", "+6", "+7", "+8", "+9", "+0");
$ganti_ke = 'NOVITA VISTARANI ';
$_POST['no'] = str_replace($ganti, $ganti_ke, $_POST['no']);
	}

function ProsedurPemeriksaan($_POST, $a, $b) {

// Nomor Tujuan Kosong?
if($_POST['no'] == ""){
	header ("Location: index.php?w=".$_POST['w']."&s=1");
	mysql_close();
	exit(); 
}

// Cek Numeric Nomor Tujuan
elseif(!is_numeric($_POST['no'])){
	header ("Location: index.php?w=".$_POST['w']."&s=3");
	mysql_close();
	exit();
}

// Cek Minimal No Tujuan 9 Maximal 13
elseif(strlen($_POST['no']) <= $a || strlen($_POST['no']) >= $b){
	header ("Location: index.php?w=".$_POST['w']."&s=4");
	mysql_close();
	exit();
}

// Cek Pesan Kosong
elseif($_POST['pesan'] == ''){
header ("Location: index.php?w=".$_POST['w']."&s=5");
mysql_close();
exit();
	}

}
	
function AntriPesan($a, $nomor) {

$query = "SELECT DestinationNumber, COUNT(DestinationNumber) FROM outbox WHERE DestinationNumber LIKE '%$nomor' GROUP BY DestinationNumber"; 
$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_array($result)){
if ($row['COUNT(DestinationNumber)'] >= 1) {
	header ("Location: index.php?w=".$a."&s=99");
	mysql_close();
	exit();
		}
	}

}

function AntiHotLink($a, $b, $c, $d) {

$sql = "SELECT no_hp FROM ban WHERE no_hp LIKE '%$a'";
$cek = mysql_query($sql) or die (mysql_error());
$cari = mysql_num_rows($cek);

// anti HotLink dan NgeBomb dan BAN Nomor
if ($c!==$d || $cari==1) {
	header ("Location: index.php?w=".$b."&s=1234");
	mysql_close();
	exit();
	}
}

function KirimSms($_POST) {
	
	// Kirim SMS
	$c=substr($_POST['pesan'],0,160);
	$sql=mysql_query("INSERT INTO outbox (DestinationNumber, TextDecoded) VALUES ('".$_POST['no']."','$c')");
	$no = substr($_POST['no'], -7);
	if ($_POST['w'] == 'yes') {
	header ("Location: index.php?w=".$_POST['w']."&s=6");
	}
	else header ("Location: index.php?w=".$_POST['w']."&s=6&n=".$no);
	mysql_close();
	exit();

}

}

?>