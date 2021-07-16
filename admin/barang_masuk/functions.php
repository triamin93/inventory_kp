<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "inventori");

// Fungsi query 
function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// Fungsi Mata Uang Rupiah
function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

// Fungsi Tanggal Indonesia
function dateIndonesian($date)
{
    $array_hari = array(1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
    $array_bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $date  = strtotime($date);
    $hari  = $array_hari[date('N', $date)];
    $tanggal = date('j', $date);
    $bulan = $array_bulan[date('n', $date)];
    $tahun = date('Y', $date);
    $formatTanggal = $hari . ", " . $tanggal . " " . $bulan . " " . $tahun;
    return $formatTanggal;
}

// Koding Tambah Data Barang Masuk
if (isset($_POST['tambah'])) {
    $barang = $_POST['barang'];
    $jumlah = $_POST['jumlah'];
    $harga_beli = $_POST['harga_beli'];
    $supplier = $_POST['supplier'];

    // untuk mengambil stok berdasarkan id barang
    $cekbarang = mysqli_query($conn, "SELECT * FROM barang where id_barang = '$barang'");
    $ambilbarang = mysqli_fetch_array($cekbarang);
    $stoksekarang = $ambilbarang['stok'];

    // menambah stok dari jumlah
    $tambahstok = $stoksekarang + $jumlah;

    // hasil total harga seluruhnya
    $total_harga = $jumlah * $harga_beli;

    // Query menambah data di barang masuk && menambah stok di barang
    $tambah_barangmasuk = mysqli_query($conn, "INSERT into barangmasuk (id_barang, jumlah, harga_beli, total, id_supplier) VALUES('$barang','$jumlah','$harga_beli','$total_harga','$supplier')");
    $update_stokmasuk = mysqli_query($conn, "UPDATE barang set stok = '$tambahstok' WHERE id_barang = '$barang'");
    if ($tambah_barangmasuk && $update_stokmasuk) {
        echo "
        <script>
            alert('Data Barang Masuk Berhasil Ditambahkan!');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Barang Masuk Gagal Ditambahkan!');
            document.location.href = 'index.php';
        </script>
        ";
    }
}

// Koding Hapus Data Barang Keluar
if (isset($_POST['hapus'])) {
    $id_barangmasuk = $_POST['id_barangmasuk'];
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];

    // Mengambil id barang
    $cekbarang = mysqli_query($conn, "SELECT * FROM barang where id_barang = '$id_barang'");
    $ambilbarang = mysqli_fetch_array($cekbarang);
    $stoksekarang = $ambilbarang['stok'];

    // Jika Stok Barang Mencukupi untuk dihapus
    if ($stoksekarang >= $jumlah) {
        $selisih = $stoksekarang - $jumlah;

        // Query untuk update stok barang dan hapus barang masuk
        $update_barang = mysqli_query($conn, "UPDATE barang SET stok= '$selisih' WHERE id_barang='$id_barang'");
        $hapus_barangmasuk = mysqli_query($conn, "DELETE FROM barangmasuk WHERE id_barangmasuk = '$id_barangmasuk'");
        if ($update_barang && $hapus_barangmasuk) {
            echo "
                <script>
                    alert('Data Barang Masuk Berhasil Dihapuskan!');
                    document.location.href = 'index.php';
                </script>
                ";
        } else {
            echo "
                <script>
                    alert('Data Barang Masuk Gagal Dihapuskan!');
                    document.location.href = 'index.php';
                </script>
                ";
        }
        // Jika barang masuk dihapus dan terjadi stoknya menjadi minus maka akan menampilkan pesan, barang masuk tidak dapat dihapus
    } else {
        echo "
                <script>
                    alert('Stok Menjadi Minus!');
                    document.location.href = 'index.php';
                </script>
                ";
    }
}

// Koding Edit Data Barang Keluar
if (isset($_POST['edit'])) {
    $id_barangmasuk = $_POST['id_barangmasuk'];
    $id_barang = $_POST['id_barang'];
    $barang = $_POST['barang'];
    $jumlah = $_POST['jumlah'];
    $harga_beli = $_POST['harga_beli'];
    $supplier = $_POST['supplier'];

    // untuk mengambil stok berdasarkan id barang
    $cekbarang = mysqli_query($conn, "SELECT * FROM barang where id_barang = '$id_barang'");
    $ambilbarang = mysqli_fetch_array($cekbarang);
    $stoksekarang = $ambilbarang['stok'];

    // untuk mengambil jumlah berdasarkan id barangmasuk
    $cek_barangmasuk = mysqli_query($conn, "SELECT * FROM barangmasuk WHERE id_barangmasuk = '$id_barangmasuk'");
    $ambildata = mysqli_fetch_array($cek_barangmasuk);
    $jumlahsekarang = $ambildata['jumlah'];

    // hasil dari total harga seluruhnya
    $total_harga = $jumlah * $harga_beli;

    // jika jumlah barang masuk lebih besar dari jumlah stok sekarang
    if ($jumlah > $jumlahsekarang) {
        $selisih = $jumlah - $jumlahsekarang;
        $menambahbarang = $stoksekarang + $selisih;

        // kueri untuk edit data barang masuk dan menambah stok barang
        $menambahstoknya = mysqli_query($conn, "UPDATE barang set stok = '$menambahbarang' WHERE id_barang = '$id_barang'");
        $update_barangmasuk = mysqli_query($conn, "UPDATE barangmasuk set jumlah = '$jumlah', harga_beli = '$harga_beli', total = '$total_harga', id_supplier = '$supplier' WHERE id_barangmasuk = '$id_barangmasuk' ");
        if ($menambahstoknya && $update_barangmasuk) {
            echo "
            <script>
                alert('Data Barang Masuk Berhasil Diedit!');
                document.location.href = 'index.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Data Barang Masuk Gagal Diedit!');
                document.location.href = 'index.php';
            </script>
            ";
        }
        // Jika jumlah barang masuk kurang dari jumlah sekarang di barang masuk
    } elseif ($jumlah < $jumlahsekarang) {
        $selisih = $jumlahsekarang - $jumlah;
        $mengurangibarang = $stoksekarang - $selisih;

        // jika stok barang mengcukupi untuk di edit 
        if ($selisih <= $stoksekarang) {
            // kueri untuk edit data barang masuk dan mengurangi stoknya
            $mengurangistoknya = mysqli_query($conn, "UPDATE barang set stok = '$mengurangibarang' WHERE id_barang = '$id_barang'");
            $update_barangmasuk = mysqli_query($conn, "UPDATE barangmasuk set jumlah = '$jumlah', harga_beli = '$harga_beli', total = '$total_harga', id_supplier = '$supplier' WHERE id_barangmasuk = '$id_barangmasuk' ");
            if ($mengurangistoknya && $update_barangmasuk) {
                echo "
                    <script>
                        alert('Data Barang Masuk Berhasil Diedit!');
                        document.location.href = 'index.php';
                    </script>
                    ";
            } else {
                echo "
                    <script>
                        alert('Data Barang Masuk Gagal Diedit!');
                        document.location.href = 'index.php';
                    </script>
                    ";
            }
            // Jika jumlah barang masuk yang diedit dan terjadi stok barang menjadi minus maka terdapat pesan stok barang menjadi minus dan tidak di eksekusi
        } else {
            echo "
                    <script>
                        alert('Stok Barang Menjadi Minus');
                        window.location.href = 'index.php';
                    </script>
            ";
        }
    } else {
        // kueri untuk edit data barang masuk tanpa mengubah stok barangnya
        $update_barangmasuk = mysqli_query($conn, "UPDATE barangmasuk set jumlah = '$jumlah', harga_beli = '$harga_beli', total = '$total_harga', id_supplier = '$supplier' WHERE id_barangmasuk = '$id_barangmasuk' ");
        if ($update_barangmasuk) {
            echo "
            <script>
                alert('Data Barang Masuk Berhasil Diedit!');
                document.location.href = 'index.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Data Barang Masuk Gagal Diedit!');
                document.location.href = 'index.php';
            </script>
            ";
        }
    }
}
