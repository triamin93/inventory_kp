<?php
session_start();

// Menamnggil fungsi
require 'functions.php';

// jika tidak ada username yang masuk
if (!isset($_SESSION["username"])) {
    echo "
        <script>
            alert('Anda Harus Login Dulu!');
            document.location.href = '../../index.php';
        </script>
        ";
    exit;
}

$level = $_SESSION["level"];
// jika level bukan pemilik toko (Super Admin)
if ($level != "pemilik") {
    echo "
        <script>
            alert('Anda tidak punya akses pada halaman Pemilik Toko (Super Admin)');
            document.location.href = '../logout.php';
        </script>
        ";
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Customer</title>
    <style>
        table thead tr th,
        td {
            text-align: center;
        }
    </style>
    <link href="../assets/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
</head>

<body class="sb-nav-fixed">
    <!-- headernya -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Sistem Inventory</a>
        <!-- Tombol untuk menampilkan dan menyembunyikan sidebar -->
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <!-- Tombol untuk logout -->
                <a class="btn btn-danger" href="../logout.php" role="button"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
            </div>
        </form>
    </nav>
    <!-- sidebarnya -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <!-- link Dashboard -->
                        <a class="nav-link" href="../dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <!-- link admin -->
                        <a class="nav-link" href="../admin/index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Admin
                        </a>
                        <!-- link barang -->
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsBarang" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                            Barang
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsBarang" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="../barang/index.php">Data Barang</a>
                                <a class="nav-link" href="../barang_masuk/index.php">Barang Masuk</a>
                                <a class="nav-link" href="../barang_keluar/index.php">Barang Keluar</a>
                            </nav>
                        </div>
                        <!-- link Supplier -->
                        <a class="nav-link" href="../supplier/index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-people-carry"></i></div>
                            Supplier
                        </a>
                        <!-- link Customer -->
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-dolly-flatbed"></i></div>
                            Customer
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <!-- kontennya -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Data Customer</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Tombol Tambah Data Customer -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus mr-1"></i>
                                Tambah
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Customer</th>
                                            <th>Alamat</th>
                                            <th>Telepon</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // query untuk memanggil data customer
                                        $customer = mysqli_query($conn, "SELECT * FROM customer");
                                        $i = 1;
                                        // pengullangan untuk menampilkan data customer
                                        while ($data = mysqli_fetch_array($customer)) :
                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $data['nama_customer']; ?></td>
                                                <td><?= $data['alamat']; ?></td>
                                                <td><?= $data['telp_customer']; ?></td>
                                                <td>
                                                    <!-- Tombol Edit Customer -->
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?php echo $data['id_customer']; ?>">
                                                        <i class="fas fa-edit mr-1"></i>Edit
                                                    </button>
                                                    <!-- Tombol Hapus Customer -->
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?php echo $data['id_customer']; ?>">
                                                        <i class="fas fa-trash-alt mr-1"></i>Delete
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- modal edit -->
                                            <div class="modal fade" id="edit<?php echo $data['id_customer']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Customer</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <!-- Form untuk edit data customer -->
                                                        <form method="POST">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_customer" value="<?php echo $data['id_customer']; ?>">
                                                                <div class="form-group">
                                                                    <label for="nama_customer">Nama Customer</label>
                                                                    <input type="text" name="nama_customer" placeholder="Masukkan Nama Customer" class="form-control" id="nama_customer" value="<?php echo $data['nama_customer']; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="alamat">Alamat</label>
                                                                    <textarea class="form-control" name="alamat" id="alamat" rows="7" placeholder="Masukkan Alamat Supplier" required><?php echo $data['alamat']; ?></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="telp_customer">Telepon Customer</label>
                                                                    <input type="number" name="telp_customer" placeholder="Masukkan Telepon Customer" class="form-control" id="telp_customer" value="<?php echo $data['telp_customer']; ?>" required>
                                                                </div>
                                                                <br>
                                                                <button type="submit" class="btn btn-warning btn-lg btn-block" name="edit">Edit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- modal hapus -->
                                            <div class="modal fade" id="delete<?php echo $data['id_customer']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Customer</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <!-- Form hapus data customer -->
                                                        <form method="POST">
                                                            <div class="modal-body">
                                                                <p>Apakah Anda Yakin Menghapus <b> <?= $data['nama_customer']; ?> ? </b></p>
                                                                <input type="hidden" name="id_customer" value="<?php echo $data['id_customer']; ?>">
                                                                <br>
                                                                <button type="submit" class="btn btn-danger btn-lg btn-block" name="hapus">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        endwhile;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- All modal -->
    <!-- Modal tambah -->
    <div class="modal fade" id="tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Customer</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <!-- Form Tambah customer -->
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_customer">Nama Customer</label>
                            <input type="text" name="nama_customer" placeholder="Masukkan Nama Customer" class="form-control" id="nama_customer" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" rows="7" placeholder="Masukkan Alamat Customer" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="telp_customer">Telepon Customer</label>
                            <input type="number" name="telp_customer" placeholder="Masukkan Telepon Customer" class="form-control" id="telp_customer" required>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success btn-lg btn-block" name="tambah">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../assets/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $('#dataTable').DataTable({
                // datatable bahasa indonesia
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
                }
            });
        });
    </script>
</body>

</html>