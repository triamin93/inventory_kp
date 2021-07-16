<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "inventori");

// fungsi tanggal dan waktu indonesia
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

// Coding untuk tambah data admin
if (isset($_POST['tambah'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $level = $_POST['level'];

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM admin WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Username Sudah Terdaftar');
            </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Query Tambah admin
    $tambah_admin = mysqli_query($conn, "INSERT INTO admin (nama_lengkap, username, level, password, last_login) values('$nama_lengkap', '$username', '$level', '$password', '')");
    if ($tambah_admin) {
        echo "
        <script>
            alert('Data Berhasil Ditambahkan!');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Gagal Ditambahkan!');
            document.location.href = 'index.php';
        </script>
        ";
    }
}

// Coding untuk hapus data admin
if (isset($_POST['hapus'])) {
    $id_admin = $_POST['id_admin'];

    // query untuk hapus data Admin
    $hapus_admin = mysqli_query($conn, "DELETE FROM admin WHERE id_admin = '$id_admin'");
    if ($hapus_admin) {
        echo "
        <script>
            alert('Data Berhasil Dihapus!');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Gagal Dihapus!');
            document.location.href = 'index.php';
        </script>
        ";
    }
}

// Coding untuk edit data admin
if (isset($_POST['edit'])) {
    $id_admin = $_POST['id_admin'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk edit data
    $edit_admin = mysqli_query($conn, "UPDATE admin set nama_lengkap = '$nama_lengkap', username = '$username', password = '$password', level = '$level' WHERE id_admin = '$id_admin'");
    if ($edit_admin) {
        echo "
        <script>
            alert('Data Berhasil Diedit!');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Gagal Diedit!');
            document.location.href = 'index.php';
        </script>
        ";
    }
}
