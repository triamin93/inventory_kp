<?php
session_start();

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
// jika level bukan pegawai
if ($level != "pegawai") {
    echo "
        <script>
            alert('Anda tidak punya akses pada halaman Pegawai Toko (Admin)');
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
    <title>Data Barang Masuk</title>
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
        <!-- Tombol menampilkan dan menyembunyikan sidebar -->
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
            <!-- Tombol logout -->
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
                        <!-- link barang -->
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsBarang" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                            Barang
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsBarang" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="../barang/index.php">Data Barang</a>
                                <a class="nav-link" href="index.php">Barang Masuk</a>
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
                    <h1 class="mt-4">Data Barang Masuk</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                        <!-- Tombol Tambah Data Barang masuk -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus mr-1"></i>
                                Tambah
                            </button>
                            <!-- Tombol Laporan -->
                            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#laporan" style="float: right;"><i class="fas fa-file-alt mr-1"></i>
                                Laporan
                            </button> -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Harga Beli</th>
                                            <th>Total</th>
                                            <th>Supplier</th>
                                            <!-- <th>Aksi</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Query untuk mengambil data barang masuk
                                        $barangmasuk = mysqli_query($conn, "SELECT * FROM barangmasuk INNER JOIN barang ON barangmasuk.id_barang = barang.id_barang INNER JOIN supplier ON barangmasuk.id_supplier = supplier.id_supplier ORDER BY tanggal_masuk DESC");
                                        $i = 1;
                                        // Pengulangan menampilkan barang keluar
                                        while ($data = mysqli_fetch_assoc($barangmasuk)) :
                                        ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?= dateIndonesian($data['tanggal_masuk']) . " " . date_format(date_create($data['tanggal_masuk']), "H:i"); ?></td>
                                                <td><?= $data['nama_barang']; ?></td>
                                                <td><?= $data['jumlah']; ?></td>
                                                <td><?= rupiah($data['harga_beli']); ?></td>
                                                <td><?= rupiah($data['total']); ?></td>
                                                <td><?= $data['nama_supplier']; ?></td>
                                                <!-- <td> -->
                                                <!-- Tombol Edit barang masuk -->
                                                    <!-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?php echo $data['id_barangmasuk']; ?>">
                                                        <i class="fas fa-edit mr-1"></i>Edit
                                                    </button> -->
                                                <!-- Tombol Hapus Barang Masuk -->
                                                    <!-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapus<?php echo $data['id_barangmasuk']; ?>">
                                                        <i class="fas fa-trash-alt mr-1"></i>Delete
                                                    </button> -->
                                                <!-- </td> -->
                                            </tr>

                                            <!-- modal edit -->
                                            <div class="modal fade" id="edit<?php echo $data['id_barangmasuk']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Barang Masuk</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <!-- Form Edit barang masuk -->
                                                        <form method="POST">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_barangmasuk" value="<?php echo $data['id_barangmasuk']; ?>">

                                                                <input type="hidden" name="id_barang" value="<?php echo $data['id_barang']; ?>">

                                                                <div class="form-group">
                                                                    <label for="barang">Nama Barang</label>
                                                                    <input type="text" name="barang" class="form-control" id="jumlah" value="<?php echo $data['nama_barang']; ?>" readonly>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="jumlah">Jumlah Barang</label>
                                                                    <input type="number" name="jumlah" placeholder="Masukkan Jumlah Barang" class="form-control" id="jumlah" value="<?php echo $data['jumlah']; ?>" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="harga_beli">Harga Beli Satuan</label>
                                                                    <input type="number" name="harga_beli" placeholder="Masukkan Harga Beli Satuan" class="form-control" id="harga_beli" value="<?php echo $data['harga_beli']; ?>" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="supplier">Nama Supplier</label>
                                                                    <select class="form-control" id="supplier" name="supplier">
                                                                        <?php
                                                                        $suppliernya = mysqli_query($conn, "SELECT * FROM supplier");
                                                                        while ($row_supplier = mysqli_fetch_array($suppliernya)) {
                                                                            $nama_supplier = $row_supplier['nama_supplier'];
                                                                            $id_supplier = $row_supplier['id_supplier'];
                                                                        ?>
                                                                            <option value="<?php echo $id_supplier; ?>"><?php echo $nama_supplier; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
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
                                            <div class="modal fade" id="hapus<?php echo $data['id_barangmasuk']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Barang Masuk</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <!-- Form hapus barang masuk -->
                                                        <form method="POST">
                                                            <div class="modal-body">
                                                                <p>Apakah Anda Yakin Menghapus Barang Masuk dengan Nama Barang <b> <?= $data['nama_barang']; ?> ? </b> dengan jumlah sekitar <b> <?= $data['jumlah']; ?></b></p>

                                                                <input type="hidden" name="id_barangmasuk" value="<?php echo $data['id_barangmasuk']; ?>">

                                                                <input type="hidden" name="id_barang" value="<?php echo $data['id_barang']; ?>">

                                                                <input type="hidden" name="jumlah" value="<?php echo $data['jumlah']; ?>">
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
                    <h4 class="modal-title">Tambah Barang Masuk</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <!-- Form tambah barang masuk -->
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="barang">Nama Barang</label>
                            <select class="form-control" id="barang" name="barang">
                                <?php
                                $barangnya = mysqli_query($conn, "SELECT * FROM barang");
                                while ($data = mysqli_fetch_array($barangnya)) {
                                ?>
                                    <option value="<?php echo $data['id_barang']; ?>"><?php echo $data['nama_barang']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah Barang</label>
                            <input type="number" name="jumlah" placeholder="Masukkan Jumlah Barang" class="form-control" id="jumlah" required>
                        </div>
                        <div class="form-group">
                            <label for="harga_beli">Harga Beli Satuan</label>
                            <input type="number" name="harga_beli" placeholder="Masukkan Harga Beli Satuan" class="form-control uang" id="harga_beli" required>
                        </div>
                        <div class="form-group">
                            <label for="supplier">Nama Supplier</label>
                            <select class="form-control" id="supplier" name="supplier">
                                <?php
                                $suppliernya = mysqli_query($conn, "SELECT * FROM supplier");
                                while ($row_supplier = mysqli_fetch_array($suppliernya)) {
                                    $nama_supplier = $row_supplier['nama_supplier'];
                                    $id_supplier = $row_supplier['id_supplier'];
                                ?>
                                    <option value="<?php echo $id_supplier; ?>"><?php echo $nama_supplier; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success btn-lg btn-block" name="tambah">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal laporan -->
    <div class="modal fade" id="laporan">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Laporan Data Masuk</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <!-- Form Laporan -->
                <form method="GET" action="laporan_barangmasuk.php">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tgl_awal">Tanggal Awal</label>
                            <input type="date" name="tgl_awal" class="form-control" id="tgl_awal" required>
                        </div>
                        <div class="form-group">
                            <label for="tgl_akhir">Tanggal Akhir</label>
                            <input type="date" name="tgl_akhir" class="form-control" id="tgl_akhir" required>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary btn-lg btn-block" name="laporan" data-target="black">Laporan</button>
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