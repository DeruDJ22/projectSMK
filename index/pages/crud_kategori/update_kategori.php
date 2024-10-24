<?php
include '../../library/koneksi.php';
include 'alert.php';
$id = $_POST['id'];
$namalama = $_POST['namalama'];
$nama = $_POST['nama'];
$cek = "SELECT nama_kategori FROM tbl_kategori WHERE nama_kategori = '$nama' AND NOT nama_kategori = '$namalama'";
$ada = mysqli_query($koneksi, $cek);
if (mysqli_num_rows($ada) == 1) {
  echo "<script type='text/javascript'>
          Swal.fire({
            icon: 'error',
            title: 'Data Gagal Diupdate',
            confirmedButtonText: 'OK'
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              history.go(-1)
            }
          })
        </script>";
} else {
  $query = "UPDATE tbl_kategori SET nama_kategori='$nama' WHERE id='$id'";
  $hasil = mysqli_query($koneksi, $query);
  if ($hasil) {
    echo "<script type='text/javascript'>
          Swal.fire({
            icon: 'success',
            title: 'Data Berhasil Diupdate',
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
            title: 'Data Gagal Diupdate',
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
