<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "inventori");

// Fungsi Query
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

// fungsi tanggal indonesia
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

// fungsi angka rupiah
function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

// Koding untuk Tambah barang keluar
if (isset($_POST['tambah'])) {
    $barang = $_POST['barang'];
    $jumlah = $_POST['jumlah'];
    $harga_jual = $_POST['harga_jual'];
    $customer = $_POST['customer'];

    // untuk mengambil stok berdasarkan id barang
    $cekbarang = mysqli_query($conn, "SELECT * FROM barang where id_barang = '$barang'");
    $ambilbarang = mysqli_fetch_array($cekbarang);
    $stoksekarang = $ambilbarang['stok'];

    // Jika Stok sekarang mencukupi dari keluar (Stok sekarang lebih besar atau sama dengan jumlah daripada jumlah yang dikeluarkan )
    if ($stoksekarang >= $jumlah) {
        // mengurangi stok dari jumlah
        $kurangstok = $stoksekarang - $jumlah;

        // hasil total harga seluruhnya
        $total_harga = $jumlah * $harga_jual;

        // query menambah data di barang masuk && menambah stok di barang
        $tambah_barangkeluar = mysqli_query($conn, "INSERT into barangkeluar (id_barang, jumlah, harga_jual, total, id_customer) VALUES('$barang','$jumlah','$harga_jual','$total_harga','$customer')");
        $update_stokmasuk = mysqli_query($conn, "UPDATE barang set stok = '$kurangstok' WHERE id_barang = '$barang'");
        if ($tambah_barangkeluar && $update_stokmasuk) {
            echo "
                <script>
                    alert('Data Barang Keluar Berhasil Ditambahkan!');
                    document.location.href = 'index.php';
                </script>
                ";
        } else {
            echo "
                <script>
                    alert('Data Barang Keluar Gagal Ditambahkan!');
                    document.location.href = 'index.php';
                </script>
                ";
        }
        // Jika Stok barang tidak mencukupi agar terhindar dari stok barang menjadi minus
    } else {
        echo "
                <script>
                    alert('Stok Saat Ini Tidak Mencukupi!');
                    document.location.href = 'index.php';
                </script>
                ";
    }
}

// Koding untuk hapus barang keluar
if (isset($_POST['hapus'])) {
    $id_barangkeluar = $_POST['id_barangkeluar'];
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];

    // query untuk mengambil stok barang bedasarkan id barang
    $cekbarang = mysqli_query($conn, "SELECT * FROM barang where id_barang = '$id_barang'");
    $ambilbarang = mysqli_fetch_array($cekbarang);
    $stoksekarang = $ambilbarang['stok'];

    // Selisih stok sekarang yang dijumlahkan jumlah di barang keluar
    $selisih = $stoksekarang + $jumlah;

    // query untuk update stok barang dan menghapus dari data barang keluar
    $update_barang = mysqli_query($conn, "UPDATE barang SET stok= '$selisih' WHERE id_barang='$id_barang'");
    $hapus_barangkeluar = mysqli_query($conn, "DELETE FROM barangkeluar WHERE id_barangkeluar = '$id_barangkeluar'");

    // Jika update stok dan hapus barang keluar terpenuhi
    if ($hapus_barangkeluar && $update_barang) {
        echo "
        <script>
            alert('Data Barang Keluar Berhasil Dihapuskan!');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Barang Keluar Gagal Dihapuskan!');
            document.location.href = 'index.php';
        </script>
        ";
    }
}

// Koding untuk edit barang keluar
if (isset($_POST['edit'])) {
    $id_barangkeluar = $_POST['id_barangkeluar'];
    $id_barang = $_POST['id_barang'];
    $barang = $_POST['barang'];
    $jumlah = $_POST['jumlah'];
    $harga_jual = $_POST['harga_jual'];
    $customer = $_POST['customer'];

    // untuk mengambil stok berdasarkan id barang
    $cekbarang = mysqli_query($conn, "SELECT * FROM barang where id_barang = '$id_barang'");
    $ambilbarang = mysqli_fetch_array($cekbarang);
    $stoksekarang = $ambilbarang['stok'];

    // untuk mengambil jumlah berdasarkan id barangmasuk
    $cek_barangkeluar = mysqli_query($conn, "SELECT * FROM barangkeluar WHERE id_barangkeluar = '$id_barangkeluar'");
    $ambildata = mysqli_fetch_array($cek_barangkeluar);
    $jumlahsekarang = $ambildata['jumlah'];

    // hasil dari total harga seluruhnya
    $total_harga = $jumlah * $harga_jual;

    // jika jumlah lebih besar daripada jumlah sekarang dari barang keluar
    if ($jumlah > $jumlahsekarang) {
        $selisih = $jumlah - $jumlahsekarang;
        $mengurangibarang = $stoksekarang - $selisih;

        // jika stok barang mencukupi untuk di edit
        if ($selisih <= $stoksekarang) {

            // kueri untuk edit data barang keluar dan mengurangi stok barang
            $mengurangistoknya = mysqli_query($conn, "UPDATE barang set stok = '$mengurangibarang' WHERE id_barang = '$id_barang'");
            $update_barangkeluar = mysqli_query($conn, "UPDATE barangkeluar set jumlah = '$jumlah', harga_jual = '$harga_jual', total = '$total_harga', id_customer = '$customer' WHERE id_barangkeluar = '$id_barangkeluar' ");
            if ($mengurangistoknya && $update_barangkeluar) {
                echo "
                        <script>
                            alert('Data Barang Keluar Berhasil Diedit!');
                            document.location.href = 'index.php';
                        </script>
                        ";
            } else {
                echo "
                        <script>
                            alert('Data Barang Keluar Gagal Diedit!');
                            document.location.href = 'index.php';
                        </script>
                        ";
            }
            // Jika stok barang yang diedit tidak mencukupi agar terhindar dari stok minus
        } else {
            echo "
                    <script>
                        alert('Stok Barang Tidak Mencukupi');
                        window.location.href = 'index.php';
                    </script>
            ";
        }
        // Jika jumlah yang dikeluarkan lebih kecil daripada jumlah sekarang dari barang keluar
    } elseif ($jumlah < $jumlahsekarang) {
        $selisih = $jumlahsekarang - $jumlah;
        $menambahbarang = $stoksekarang + $selisih;

        // kueri untuk edit data barang keluar dan stoknya menjadi bertambah
        $menambahstoknya = mysqli_query($conn, "UPDATE barang set stok = '$menambahbarang' WHERE id_barang = '$id_barang'");
        $update_barangkeluar = mysqli_query($conn, "UPDATE barangkeluar set jumlah = '$jumlah', harga_jual = '$harga_jual', total = '$total_harga', id_customer = '$customer' WHERE id_barangkeluar = '$id_barangkeluar' ");
        if ($menambahstoknya && $update_barangkeluar) {
            echo "
            <script>
                alert('Data Barang Keluar Berhasil Diedit!');
                document.location.href = 'index.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Data Barang Keluar Gagal Diedit!');
                document.location.href = 'index.php';
            </script>
            ";
        }
    } else {
        // kueri untuk edit data barang keluar tanpa mengubah stoknya
        $update_barangkeluar = mysqli_query($conn, "UPDATE barangkeluar set jumlah = '$jumlah', harga_jual = '$harga_jual', total = '$total_harga', id_customer = '$customer' WHERE id_barangkeluar = '$id_barangkeluar' ");
        if ($update_barangkeluar) {
            echo "
            <script>
                alert('Data Barang Keluar Berhasil Diedit!');
                document.location.href = 'index.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Data Barang Keluar Gagal Diedit!');
                document.location.href = 'index.php';
            </script>
            ";
        }
    }
}
