<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "inventori");

// Koding untuk tambah data customer
if (isset($_POST['tambah'])) {
    $nama_customer = $_POST['nama_customer'];
    $alamat = $_POST['alamat'];
    $telp_customer = $_POST['telp_customer'];

    // Query untuk Tambah data
    $tambah_customer = mysqli_query($conn, "INSERT INTO customer (nama_customer, alamat, telp_customer) values('$nama_customer', '$alamat', '$telp_customer')");
    if ($tambah_customer) {
        echo "
        <script>
            alert('Data Customer Berhasil Ditambahkan!');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Customer Gagal Ditambahkan!');
            document.location.href = 'index.php';
        </script>
        ";
    }
}

// koding untuk hapus data customer
if (isset($_POST['hapus'])) {
    $id_customer = $_POST['id_customer'];

    // Query untuk hapus customer
    $hapus_customer = mysqli_query($conn, "DELETE FROM customer WHERE id_customer = '$id_customer'");
    if ($hapus_customer) {
        echo "
        <script>
            alert('Data Customer Berhasil Dihapuskan!');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Customer Gagal Dihapuskan!');
            document.location.href = 'index.php';
        </script>
        ";
    }
}

// koding untuk edit data customer
if (isset($_POST['edit'])) {
    $id_customer = $_POST['id_customer'];
    $nama_customer = $_POST['nama_customer'];
    $alamat = $_POST['alamat'];
    $telp_customer = $_POST['telp_customer'];

    // query untuk edit customer
    $edit_customer = mysqli_query($conn, "UPDATE customer set nama_customer = '$nama_customer', alamat = '$alamat', telp_customer = '$telp_customer' WHERE id_customer = '$id_customer'");
    if ($edit_customer) {
        echo "
        <script>
            alert('Data Customer Berhasil Diedit!');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Customer Gagal Diedit!');
            document.location.href = 'index.php';
        </script>
        ";
    }
}
