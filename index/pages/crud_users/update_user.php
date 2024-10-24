<?php
include '../../library/koneksi.php';
include 'alert.php';
$id = $_POST['id'];
$userlama = $_POST['userlama'];
$username = $_POST['username'];
$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
$nama = $_POST['nama'];
$namalama = $_POST['namalama'];
$level = $_POST['level'];
$cekdata = "SELECT username FROM tbl_users WHERE username='$username' AND NOT username='$userlama'";
$ada = mysqli_query($koneksi, $cekdata);
$ceklagi = "SELECT nama_lengkap FROM tbl_users WHERE nama_lengkap='$nama' AND NOT nama_lengkap='$namalama'";
$ada2 = mysqli_query($koneksi, $ceklagi);
if (mysqli_num_rows($ada) > 0) {
  echo "<script type='text/javascript'>
          Swal.fire({
            icon: 'error',
            title: 'Username Sudah Terdaftar!!',
            confirmedButtonText: 'OK'
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              history.go(-1)
            }
          })
        </script>";
} elseif (mysqli_num_rows($ada2) > 0) {
  echo "<script type='text/javascript'>
          Swal.fire({
            icon: 'error',
            title: 'Nama Sudah Terdaftar!!',
            confirmedButtonText: 'OK'
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              history.go(-1)
            }
          })
        </script>";
} else {
  $query = "UPDATE tbl_users SET username='$username', password='$pass', nama_lengkap='$nama', level='$level' WHERE id='$id'";
  $hasil = mysqli_query($koneksi, $query);
  if ($hasil) {
    echo "<script type='text/javascript'>
            Swal.fire({
              icon: 'success',
              title: 'Data Berhasil Diedit!!',
              confirmedButtonText: 'OK'
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                window.location='view_user.php'
              }
            })
          </script>";
  } else {
    echo "<script type='text/javascript'>
            Swal.fire({
              icon: 'error',
              title: 'Data Gagal Diedit!!',
              confirmedButtonText: 'OK'
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                history.go(-1)
              }
            })
          </script>";
  }
}
