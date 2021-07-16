<?php
// mengaktifkan session
session_start();

// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "inventori");

// jika Tombol login ditekan
if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    // memanggil query admin
    $result = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
    //cek username
    if (mysqli_num_rows($result) === 1) {
        // cek password 
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // cek login untuk pemilik toko
            if ($row["level"] == "pemilik") {
                // membuat sessionnya pemilik
                $_SESSION["username"] = $username;
                $_SESSION["level"] = "pemilik";
                $last_login = mysqli_query($conn, "UPDATE admin set last_login = now() WHERE username = '$username'");
                header("location: admin/dashboard.php");
                exit;
                // cek login untuk pegawai
            } else if ($row["level"] == "pegawai") {
                // membuat sessionnya pegawai
                $_SESSION["username"] = $username;
                $_SESSION["level"] = "pegawai";
                $last_login = mysqli_query($conn, "UPDATE admin set last_login = now() WHERE username = '$username'");
                header("location: operator/dashboard.php");
                exit;
            }
        }
    }
    // Jika salah username atau password
    $error = true;
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
    <title>Login</title>
    <link href="assets/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body style="background-image: url('assets/hidroponik_new.jpg'); background-size:1350px 1000px; background-repeat: no-repeat;">
    <h2 style="text-align: center; padding-top: 10px; padding-bottom: 10px; color: white;" class="bg-success">Sistem Inventory Toko Rumah Hidroponik</h2>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4"><b>Login</b></h3>
                                </div>
                                <div class="card-body">
                                    <!-- Alert jika salah username atau password -->
                                    <?php if (isset($error)) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            Username atau Password Salah
                                        </div>
                                    <?php endif; ?>
                                    <!-- Form untuk Login -->
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label class="small mb-1" for="username">Username</label>
                                            <input class="form-control py-4" id="username" name="username" type="text" placeholder="Masukkan username" autocomplete="off" required />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="password">Password</label>
                                            <input class="form-control py-4" id="password" name="password" type="password" placeholder="Masukkan password" />
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0"></div>
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" name="login">Login</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </main>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>