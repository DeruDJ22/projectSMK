<?php
include '../index/library/koneksi.php';
include 'alert.php';
$id = $_GET['id'];
$query = "DELETE FROM tbl_keranjang WHERE id = '$id'";
$hasil = mysqli_query($koneksi, $query);
if ($hasil) {
  echo "<script type='text/javascript'>
          Swal.fire({
            icon: 'success',
            title: 'Berhasil Dihapus',
            text: 'Data Berhasil Dihapus',
            confirmButtonText: 'OK'
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              window.location='index.php'
            }
          })
        </script>";
} else {
  echo "<script type='text/javascript'>
          Swal.fire({
            icon: 'error',
            title: 'Gagal Dihapus',
            text: 'Data Gagal Terhapus',
            confirmButtonText: 'OK'
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              window.location='index.php'
            }
          })
        </script>";
}
