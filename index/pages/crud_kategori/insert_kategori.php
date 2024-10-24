<?php
include '../../library/koneksi.php';
include 'alert.php';
$nama = $_POST['nama'];
$cek = "SELECT nama_kategori FROM tbl_kategori WHERE nama_kategori = '$nama'";
$ada = mysqli_query($koneksi, $cek);
if (mysqli_num_rows($ada) > 0) {
  echo "<script type='text/javascript'>
          Swal.fire({
            icon: 'error',
            title: 'Data Kategori Sudah Terdaftar',
            confirmedButtonText: 'OK'
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              history.go(-1)
            }
          })
        </script>";
} else {
  $query = "INSERT INTO tbl_kategori (nama_kategori) VALUES ('$nama')";
  $hasil = mysqli_query($koneksi, $query);
  if ($hasil) {
    echo "<script type='text/javascript'>
          Swal.fire({
            icon: 'success',
            title: 'Data Berhasil Dibuat',
            confirmedButtonText: 'OK'
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              window.location='view_kategori.php'
            }
          })
        </script>";
  } else {
    echo "<script type='text/javascript'>
          Swal.fire({
            icon: 'error',
            title: 'Data Gagal Dibuat',
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
