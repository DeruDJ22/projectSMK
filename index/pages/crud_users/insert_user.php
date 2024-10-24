<?php

include '../../library/koneksi.php';
include 'alert.php';

$username = $_POST['username'];
$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
$nama = $_POST['nama'];
$level = $_POST['level'];
$cekdata = "SELECT username FROM tbl_users WHERE username='$username'";
$result = mysqli_query($koneksi, $cekdata);
$ceklagi = "SELECT nama_lengkap FROM tbl_users WHERE nama_lengkap='$nama'";
$result2 = mysqli_query($koneksi, $ceklagi);
if (mysqli_num_rows($result) > 0) {
    echo "<script type='text/javascript'>
            Swal.fire({
            icon: 'error',
            title: 'Uername Sudah Terdaftar !!',
            confirmedButtonText: 'OK'
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                history.go(-1)
            }
            })
          </script>";
} elseif (mysqli_num_rows($result2) > 0) {
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
    $query = "INSERT INTO tbl_users (username, password, nama_lengkap, level) VALUES ('$username', '$pass', '$nama', '$level')";
    $hasil = mysqli_query($koneksi, $query);

    if ($hasil) {
        echo "<script type='text/javascript'>
                Swal.fire({
                icon: 'success',
                title: 'Data Berhasil Dibuat!!',
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
                title: 'Data Gagal Dibuat!!',
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
