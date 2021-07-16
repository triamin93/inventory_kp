<?php
session_start();
// memanggil fungsi 
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
    <title>Data Admin</title>
    <style>
        table thead tr th {
            text-align: center;
        }
    </style>
    <link href="../assets/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <!-- headernya -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Sistem Inventory</a>
        <!-- tombol menampilkan dan menghilangkan sidebar -->
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
            <!-- tombol logout -->
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
                        <a class="nav-link" href="index.php">
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
                        <a class="nav-link" href="../customer/index.php">
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
                    <h1 class="mt-4">Data Admin</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Tombol Tambah Admin -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus mr-1"></i>
                                Tambah
                            </button>
                        </div>
                        <div class="card-body">
                            <!-- Table Data Admin -->
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Lengkap</th>
                                            <th>Username</th>
                                            <th>Level</th>
                                            <th>Last Login</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // mengambil query data admin
                                        $admin = mysqli_query($conn, "SELECT * FROM admin");
                                        $i = 1;
                                        // Pengulangan data admin
                                        while ($data = mysqli_fetch_array($admin)) :
                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $data['nama_lengkap']; ?></td>
                                                <td><?= $data['username']; ?></td>
                                                <td><?= ucwords($data['level']); ?></td>
                                                <td><?= dateIndonesian($data['last_login']) . " " . date_format(date_create($data['last_login']), "H:i"); ?></td>
                                                <td>
                                                    <!-- Tombol untuk edit data admin -->
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?php echo $data['id_admin']; ?>">
                                                        <i class="fas fa-edit mr-1"></i>Edit
                                                    </button>
                                                    <!-- tombol untuk hapus data admin -->
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?php echo $data['id_admin']; ?>">
                                                        <i class="fas fa-trash-alt mr-1"></i>Delete
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- modal edit -->
                                            <div class="modal fade" id="edit<?php echo $data['id_admin']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Admin</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <!-- Form untuk edit -->
                                                        <form method="POST">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_admin" value="<?php echo $data['id_admin']; ?>">

                                                                <div class="form-group">
                                                                    <label for="nama_lengkap">Nama Lengkap</label>
                                                                    <input type="text" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" class="form-control" id="nama_lengkap" value="<?= $data['nama_lengkap']; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="username">Username</label>
                                                                    <input type="text" name="username" placeholder="Masukkan username" class="form-control" id="username" value="<?= $data['username']; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="password">Password</label>
                                                                    <input type="password" name="password" placeholder="Masukkan password" class="form-control" id="password" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="level">Sebagai</label>
                                                                    <select class="form-control" name="level" id="level">
                                                                        <option value="pemilik">Pemilik</option>
                                                                        <option value="pegawai" selected>Pegawai</option>
                                                                    </select>
                                                                </div>
                                                                <br>
                                                                <button type="submit" class="btn btn-warning btn-lg btn-block" name="edit">Edit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- modal hapus -->
                                            <div class="modal fade" id="delete<?php echo $data['id_admin']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Admin</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <!-- Form untuk hapus -->
                                                        <form method="POST">
                                                            <div class="modal-body">
                                                                <p>Apakah Anda Yakin Menghapus <?= $data['nama_lengkap']; ?> ?</p>
                                                                <input type="hidden" name="id_admin" value="<?php echo $data['id_admin']; ?>">
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
                    <h4 class="modal-title">Tambah Admin</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <!-- Form untuk tambah -->
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" class="form-control" id="nama_lengkap" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" placeholder="Masukkan username" class="form-control" id="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" placeholder="Masukkan password" class="form-control" id="password" required>
                        </div>
                        <div class="form-group">
                            <label for="level">Sebagai</label>
                            <select class="form-control" name="level" id="level">
                                <option value="pemilik">Pemilik</option>
                                <option value="pegawai" selected>Pegawai</option>
                            </select>
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
                language: {
                    // DataTable Bahasa Indonesia
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
                }
            });
        });
    </script>
</body>

</html>