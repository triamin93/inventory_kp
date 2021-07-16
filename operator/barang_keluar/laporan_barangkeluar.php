<?php

require_once __DIR__ . '/vendor/autoload.php';

require 'functions.php';

if (isset($_GET["laporan"])) {
    $tgl_awal = $_GET["tgl_awal"];
    $tgl_akhir = $_GET["tgl_akhir"];
    if ($tgl_awal > $tgl_akhir) {
        echo "
        <script>
            alert('Tanggal Awal Tidak Boleh Lebih Besar Daripada Tanggal Akhir');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        $laporan = mysqli_query($conn, "SELECT * 
                                        FROM 
                                                barangkeluar 
                                        INNER JOIN 
                                                barang ON barangkeluar.id_barang = barang.id_barang
                                        INNER JOIN 
                                                customer ON barangkeluar.id_customer = customer.id_customer
                                        WHERE 
                                                tanggal_keluar 
                                        BETWEEN 
                                                '$tgl_awal' and DATE_ADD('$tgl_akhir',INTERVAL 1 DAY)");
    }
}

$total_seluruh = 0;

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
        text-align : center;
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
    .total {
        background: #3ff26f;
    }
    </style>
</head>
<body>
    <h2 class="laporan">Laporan Data Barang Masuk</h2>
    <h3 class="toko">Toko Rumah Hidroponik</h3>
    <p class="alamat">Citra Indah Bukit Ravenia, AQ 26 no.5 Jonggol, Bogor, Jawa Barat 16830.</p>
    <p class="tanggal">' . dateIndonesian($tgl_awal) . ' - ' . dateIndonesian($tgl_akhir) . '</p>
    <hr><br><br>
    <div>
        <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Barang</th>
                <th>Customer</th>
                <th>Jumlah</th>
                <th>Harga Jual</th>
                <th>Total</th>
            </tr>
        </thead>';
$i = 1;
foreach ($laporan as $row) :
    $total_seluruh += $row["total"];
    $html .= '<tbody>
        <tr>
            <td><center>' . $i++ . '</center></td>
            <td>' . dateIndonesian($row["tanggal_keluar"]) . '</td>
            <td><center>' . $row["nama_barang"] . '</center></td>
            <td><center>' . $row["nama_customer"] . '</center></td>
            <td><center>' . $row["jumlah"] . '</center></td>
            <td style="text-align:right;">' . rupiah($row['harga_jual']) . '</td>
            <td style="text-align:right;">' . rupiah($row['total']) . '</td>
        </tr>';
endforeach;

$html .= '<tr class="total">
    <td colspan="6"><center><b> TOTAL SEMUA </b></center></td>
    <td style="text-align:right;"><b>' . rupiah($total_seluruh) . '</b></td>
</tr>';

$html .= '</tbody></table></div>

</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output('laporan-barang-keluar.pdf', \Mpdf\Output\Destination::INLINE);
