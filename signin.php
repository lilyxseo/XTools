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

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
// Tangkap data yang dikirimkan dari form login
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Query untuk memeriksa username dan password di database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Login berhasil, buat cookie yang unik
            $unique_cookie_value = md5(uniqid($user['id'], true));
            setcookie('unique_login_cookie', $unique_cookie_value, time() + 2592000, '/');
            // Cookie akan berakhir dalam 1 jam (3600 detik)
            
             // Tambahkan cookie ke database
             $user_id = $user['id'];
             $insert_query = "INSERT INTO login_cookies (user_id, cookie_value) VALUES ('$user_id', '$unique_cookie_value')";
             mysqli_query($conn, $insert_query);

           // Tampilkan pesan "Login berhasil" sebelum pengalihan
           $response = "Login berhasil. Anda akan diarahkan ke dashboard.";
        } else {
            $response = "Kata sandi salah. Silakan coba lagi.";
        }
    } else {
        $response = "Username tidak ditemukan. Silakan coba lagi.";
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
    <title>Login - <?= $siteTitle ?></title>

    <?php include "view/css.txt"?>
    <?php include 'view/meta.txt'?>
    <style>
      body {
        padding: 0 1rem;
      }
      .logo img {
        padding: 50px 0;
      }
      .wave {
        -webkit-animation-name: wave-animation;
        animation-name: wave-animation;
        -webkit-animation-duration: 2.5s;
        animation-duration: 2.5s;
        -webkit-animation-iteration-count: infinite;
        animation-iteration-count: infinite;
        transform-origin: 70% 70%;
        display: inline-block
      }
      @-webkit-keyframes wave-animation {
        0%,60%,to {
            transform: rotate(0)
        }

        10%,30% {
            transform: rotate(14deg)
        }

        20% {
            transform: rotate(-8deg)
        }

        40% {
            transform: rotate(-4deg)
        }

        50% {
            transform: rotate(10deg)
        }
    }

    @keyframes wave-animation {
        0%,60%,to {
            transform: rotate(0)
        }

        10%,30% {
            transform: rotate(14deg)
        }

        20% {
            transform: rotate(-8deg)
        }

        40% {
            transform: rotate(-4deg)
        }

        50% {
            transform: rotate(10deg)
        }
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
                    <h1 class="h3"> Welcome to <?= $siteTitle ?>! <span class="wave">👋🏻</span> </h1>
                    <p>Please sign-in to your account and start the adventure</p>
                    <!-- Menambahkan elemen untuk menampilkan pesan login -->
                    <?php
                        if (isset($response)) {
                            if (strpos($response, 'berhasil') !== false) {
                                echo '<div class="alert alert-success mb-0">' . $response . '</div>';
                                echo '<script>
                                    setTimeout(function() {
                                        window.location.href = "dashboard";
                                    }, 1500);
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
                    <label for="username" class="mb-1">Username</label>
                    <input id="username" type="text" class="form-control" name="username" tabindex="1" required autofocus placeholder="Enter Username">
                  </div>

                  <div class="form-group mb-4">
                    <div class="d-block">
                    	<label for="password" class="control-label mb-1">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required placeholder="Enter Password">
                  </div>

                  <div class="form-group mt-4 mb-4">
                    <button type="submit" name="login" class="btn btn-primary btn-md btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                    <div class="col-12 text-center mt-3">
                        <p class="fs-6">Don't have an account? <a href="#">Sign up</a>.</p>
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