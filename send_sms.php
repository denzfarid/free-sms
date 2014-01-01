<?
require_once 'config.php';

// Anti HotLink
$kirim->AntiHotLink($nomor, $_POST['w'], $_POST['AntiHotLink'], $formula);

// Proses Pesan Hanya Dalam 1 Antrian 
$kirim->AntriPesan($_POST['w'], $nomor);

// Filter Nomor Internasional
$kirim->FilterInternasional($_POST);

// Periksa semua $_POST
$kirim->ProsedurPemeriksaan($_POST, 9, 13);

// Proses Permintaan Pengiriman SMS
if(isset($_POST['kirim'])){
$kirim->KirimSms($_POST);
}
?>
