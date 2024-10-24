<?php

include '../../library/koneksi.php';
include 'alert.php';

$id = $_POST['id'];
$nama = $_POST['nama'];
$namalama = $_POST['namalama'];
$barang = $_POST['barang'];
$beli = $_POST['beli'];
$jual = $_POST['jual'];
$diskon = $_POST['diskon'];
$stok = $_POST['stok'];

$cek = "SELECT nama_barang FROM tbl_barang WHERE nama_barang = '$nama' AND NOT nama_barang = '$namalama'";
$ada = mysqli_query($koneksi, $cek);
if (mysqli_num_rows($ada) > 0) {
  echo "<script type='text/javascript'>
          Swal.fire({
            icon: 'error',
            title: 'Barang Sudah Terdaftar',
            confirmedButtonText: 'OK'
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              history.go(-1)
            }
          })
        </script>";
} else {
  $query = "UPDATE tbl_barang SET nama_barang='$nama', id_kategori='$barang', harga_beli='$beli', harga_jual='$jual', diskon='$diskon', stok='$stok' WHERE id='$id'";
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
                window.location='view_barang.php'
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
