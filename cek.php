<?php
include 'index/library/koneksi.php';
include 'alert.php';
if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = "SELECT * FROM tbl_users WHERE username='$username'";
  $hasil = mysqli_query($koneksi, $query);
  $data = mysqli_fetch_array($hasil);
  if (mysqli_num_rows($hasil) > 0 && password_verify($password, $data['password'])) {
    session_start();
    $_SESSION['id'] = $data['id'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['password'] = $data['password'];
    $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
    $_SESSION['level'] = $data['level'];
    if ($data['level'] == "admin") {
      echo "<script type='text/javascript'>
              Swal.fire({
                icon: 'success',
                title: 'Login berhasil',
                text: 'Anda Login Sebagai $data[nama_lengkap]',
                confirmButtonText: 'OK'
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                  window.location='index'
                }
              })
            </script>";
    } elseif ($data['level'] == "kasir") {
      echo "<script type='text/javascript'>
              Swal.fire({
                icon: 'success',
                title: 'Login berhasil',
                text: 'Anda Login Sebagai $data[nama_lengkap]',
                confirmButtonText: 'OK'
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                  window.location='main'
                }
              })
            </script>";
    }
  } else {
    echo "<script type='text/javascript'>
            Swal.fire({
              icon: 'error',
              title: 'Login Gagal',
              text: 'Password Atau Username Salah',
              confirmButtonText: 'OK'
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                history.go(-1)
              }
            })
          </script>";
  }
} else {
  echo "<script type='text/javascript'>
          Swal.fire({
            icon: 'error',
            title: 'Login Gagal',
            text: 'Masukkan Username dan Password',
            confirmButtonText: 'OK'
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              history.go(-1)
            }
          })
        </script>";
}
