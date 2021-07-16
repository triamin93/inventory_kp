<?php

require_once __DIR__ . '/vendor/autoload.php';

require 'functions.php';
$barang = mysqli_query($conn, "SELECT * FROM barang ORDER BY nama_barang ASC");

$mpdf = new \Mpdf\Mpdf();
$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang</title>
    <style>
    .laporan, .toko, .alamat{
        text-align : center;
    }
    .tanggal {
        text-align : right;
    }
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }
    table thead tr th {
        background: #3ff26f;
    }
    </style>
</head>
<body>
    <h1 class="laporan">Laporan Data Barang</h1>
    <h2 class="toko">Toko Rumah Hidroponik</h2>
    <p class="alamat">Citra Indah Bukit Ravenia, AQ 26 no.5 Jonggol, Bogor, Jawa Barat 16830.</p>
    <hr>
    <p class="tanggal">' . dateIndonesian(date("l,d F Y")) . '</p>

    <div>
        <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Stok</th>
            </tr>
        </thead>';
$i = 1;
foreach ($barang as $row) {
    $html .= '<tbody>
        <tr>
            <td><center>' . $i++ . '</center></td>
            <td>' . $row['nama_barang'] . '</td>
            <td><center>' . $row['stok'] . '</center></td>
        </tr>
    </tbody>';
}

$html .= '</table></div>
</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output('laporan-barang.pdf', \Mpdf\Output\Destination::INLINE);
