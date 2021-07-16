<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "inventori");

// Fungsi Tanggal Indonesia
function dateIndonesian($date)
{
    $array_hari = array(1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
    $array_bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $date  = strtotime($date);
    $hari  = $array_hari[date('N', $date)];
    $tanggal = date('d', $date);
    $bulan = $array_bulan[date('n', $date)];
    $tahun = date('Y', $date);
    $formatTanggal = $hari . ", " . $tanggal . " " . $bulan . " " . $tahun;
    return $formatTanggal;
}

// koding tambah data barang
if (isset($_POST['tambah'])) {
    $nama_barang = $_POST['nama_barang'];
    $deskripsi = $_POST['deskripsi'];

    //Query untuk tambah data barang 
    $tambah_barang = mysqli_query($conn, "INSERT INTO barang (nama_barang, deskripsi) values('$nama_barang', '$deskripsi')");
    if ($tambah_barang) {
        echo "
        <script>
            alert('Data Barang Berhasil Ditambahkan!');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Barang Gagal Ditambahkan!');
            document.location.href = 'index.php';
        </script>
        ";
    }
}

// koding hapus data barang
if (isset($_POST['hapus'])) {
    $id_barang = $_POST['id_barang'];

    // Query untuk hapus data barang
    $hapus_barang = mysqli_query($conn, "DELETE FROM barang WHERE id_barang = '$id_barang'");
    if ($hapus_barang) {
        echo "
        <script>
            alert('Data Barang Berhasil Dihapuskan!');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Barang Gagal Dihapuskan!');
            document.location.href = 'index.php';
        </script>
        ";
    }
}

// koding Edit barang
if (isset($_POST['edit'])) {
    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $deskripsi = $_POST['deskripsi'];

    // Query untuk edit data barang
    $edit_barang = mysqli_query($conn, "UPDATE barang set nama_barang = '$nama_barang', deskripsi = '$deskripsi' WHERE id_barang = '$id_barang'");
    if ($edit_barang) {
        echo "
        <script>
            alert('Data Barang Berhasil Diedit!');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Barang Gagal Diedit!');
            document.location.href = 'index.php';
        </script>
        ";
    }
}
