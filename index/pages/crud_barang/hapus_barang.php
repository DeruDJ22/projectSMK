<?php
include '../../library/koneksi.php';
include 'alert.php';

$id = $_GET['id'];
$query = "DELETE FROM tbl_barang WHERE id='$id'";
$hasil = mysqli_query($koneksi, $query);

if ($hasil) {
  echo "<script type='text/javascript'>
          Swal.fire({
            icon: 'success',
            title: 'Data Berhasil Dihapus',
            confirmedButtonText: 'OK'
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              window.location='view_barang.php'
            }
          })
        </script>";
} else {
  echo "<script type='text/javascript'>
          Swal.fire({
            icon: 'error',
            title: 'Data Gagal Dihapus',
            confirmedButtonText: 'OK'
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              window.location='view_barang.php'
            }
          })
        </script>";
}
