<?php
include 'conn.php';
// Baca cookie dan ambil ID pengguna
if (isset($_COOKIE['unique_login_cookie'])) {
  $unique_login_cookie = $_COOKIE['unique_login_cookie'];
  // Gunakan nilai $unique_login_cookie di sini
} else {
  // Kunci 'unique_login_cookie' tidak terdefinisi
  // Lakukan tindakan penggantian atau berikan nilai default jika diperlukan
  $unique_login_cookie = "xxx"; // Gantilah dengan nilai default yang sesuai
}

// Query untuk mengambil informasi pengguna dari database
$query = "SELECT * FROM users WHERE id = (SELECT user_id FROM login_cookies WHERE cookie_value = '$unique_login_cookie')";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    header("Location: dashboard");
} else {

}

// Tangkap data yang dikirimkan dari form registrasi
if (isset($_POST['register'])) {
  $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $confirm_password = $_POST['confirm_password'];
  $registration_date = date('Y-m-d H:i');
  $randomNumber = rand(1, 8);
  $extension = "jpg";
  $randomFileName = $randomNumber . "." . $extension;

  // Periksa apakah password dan konfirmasi password sesuai
  if ($_POST['password'] !== $_POST['confirm_password']) {
      $response = "Password dan konfirmasi password tidak sesuai.";
  } else {
      // Periksa apakah username sudah digunakan sebelumnya
      $query = "SELECT * FROM users WHERE username = '$username'";
      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) > 0) {
          $response = "Username sudah digunakan. Silakan pilih username lain.";
      } else {
          // Jika username tersedia, tambahkan pengguna baru ke database
          $insert_query = "INSERT INTO users (full_name, username, password, registration_date, pic) VALUES ('$full_name', '$username', '$password', '$registration_date', '$randomFileName')";

          if (mysqli_query($conn, $insert_query)) {
              $response = "Registrasi berhasil. Silakan login.";
          } else {
              $response = "Terjadi kesalahan saat registrasi. Silakan coba lagi.";
          }
      }
  }
}

// Buat query SQL untuk mengambil data
$sql = "SELECT * FROM settings";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $siteTitle = $row['site_title'];
        $siteDescription = $row['site_description'];
        $siteLogo = $row['site_logo'];
        $siteFavicon = $row['favicon'];
    }
} else {
    echo "Tidak ada data ditemukan.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - <?= $siteTitle ?></title>

    <?php include 'view/css.txt'?>
    <?php include 'view/meta.txt'?>
    <style>
      body {
        padding: 0 1rem;
      }
      .logo img {
        padding: 50px 0;
      }
    </style>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

            <div class="text-center mx-auto d-block my-4 logo">
                <img src="assets/compiled/png/XT.png" alt="Logo" width="140">
            </div>
            <div class="card card-primary" style="border-top:2px solid #6777ef">
                <div class="card-header pb-0 my-3">
                    <h1 class="h3">Adventure starts here 🚀</h1>
                    <p>Make your app management easy and fun!</p>
                    <!-- Menambahkan elemen untuk menampilkan pesan login -->
                    <?php
                        if (isset($response)) {
                            if (strpos($response, 'berhasil') !== false) {
                                echo '<div class="alert alert-success mb-0">' . $response . '</div>';
                                echo '<script>
                                    setTimeout(function() {
                                        window.location.href = "index.php";
                                    }, 2000);
                                </script>';
                            } else {
                                echo '<div class="alert alert-danger mb-0">' . $response . '</div>';
                            }
                        }
                    ?>
                </div>
              <div class="card-body mt-0">
                <form method="POST" action="">
                  <div class="form-group mb-4">
                        <label for="full_name" class="mb-1">Full Name</label>
                        <input id="full_name" type="text" class="form-control" name="full_name" tabindex="1" required autofocus placeholder="Enter Full Name">
                  </div>
                  <div class="form-group mb-4">
                        <label for="username" class="mb-1">Username</label>
                        <input id="username" type="text" class="form-control" name="username" tabindex="1" required autofocus placeholder="Enter Username">
                  </div>
                  <div class="row">
                    <div class="form-group col-6">
                      <div class="d-block">
                        <label for="password" class="control-label mb-1">Password</label>
                          <input id="password" type="password" class="form-control" name="password" tabindex="2" required placeholder="Enter Password">
                      </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="confirm_password" class="control-label mb-1">Confirm Password</label>
                        <input id="confirm_password" type="password" class="form-control" name="confirm_password" tabindex="3" required placeholder="Confirm Password">
                    </div>
                  </div>
                  <div class="form-check"><input class="form-check-input" id="termsService" type="checkbox" ><label class="form-label fs--1 text-none" for="termsService">I accept the <a href="#">terms </a>and <a href="#">privacy policy</a></label></div>
                  <div class="form-group mt-2 mb-4">
                    <button type="submit" name="register" class="btn btn-primary btn-md btn-block" tabindex="4">
                      Register
                    </button>
                  </div>
                    <div class="col-12 text-center mt-3">
                        <p class="fs-6">Already have account? <a href="signin">Sign in</a>.</p>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
    <script src="assets/static/js/components/dark.js"></script>
    <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/compiled/js/app.js"></script>
</body>

</html>