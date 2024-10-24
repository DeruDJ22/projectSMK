<?php

include 'index/library/koneksi.php';
include 'alert.php';

$username = $_POST['username'];
$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
$nama = $_POST['nama'];
$level = $_POST['level'];

if ($username == "") {
    echo "<script type='text/javascript'>
            Swal.fire({
            icon: 'error',
            title: 'Data Username Harus Diisi!!',
            confirmButtonText: 'OK'
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    history.go(-1)
                }
            })
          </script>";
} elseif ($pass == "") {
    echo "<script type='text/javascript'>
            Swal.fire({
            icon: 'error',
            title: 'Data Password Harus Diisi!!',
            confirmButtonText: 'OK'
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    history.go(-1)
                }
            })
          </script>";
} elseif ($nama == "") {
    echo "<script type='text/javascript'>
            Swal.fire({
            icon: 'error',
            title: 'Data Nama Harus Diisi!!',
            confirmButtonText: 'OK'
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    history.go(-1)
                }
            })
          </script>";
} elseif ($level == "") {
    echo "<script type='text/javascript'>
            Swal.fire({
            icon: 'error',
            title: 'Data level Harus Diisi!!',
            confirmButtonText: 'OK'
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    history.go(-1)
                }
            })
          </script>";
} else {
    $cekdata = "SELECT username FROM tbl_users WHERE username='$username'";
    $result = mysqli_query($koneksi, $cekdata);
    $ceklagi = "SELECT nama_lengkap FROM tbl_users WHERE nama_lengkap='$nama'";
    $result2 = mysqli_query($koneksi, $ceklagi);
    if (mysqli_num_rows($result) > 0) {
        echo "<script type='text/javascript'>
                Swal.fire({
                icon: 'error',
                title: 'Data Gagal Dibuat',
                text: 'Username Sudah Terdaftar',
                confirmButtonText: 'OK'
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
                title: 'Data Gagal Dibuat',
                text: 'Nama Sudah Terdaftar',
                confirmButtonText: 'OK'
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
                        window.location='index.php'
                    }
                    })
                  </script>";
        } else {
            echo "<script>
        alert('Data Gagal Dibuat!');
        </script>" . mysqli_error($koneksi);
        }
    }
}
