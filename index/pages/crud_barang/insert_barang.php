<?php

include '../../library/koneksi.php';
include 'alert.php';

$nama = $_POST['nama'];
$barang = $_POST['barang'];
$beli = $_POST['beli'];
$jual = $_POST['jual'];
$diskon = $_POST['diskon'];
$stok = $_POST['stok'];

$cek = "SELECT nama_barang FROM tbl_barang WHERE nama_barang = '$nama'";
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
  $query = "INSERT INTO tbl_barang (nama_barang, id_kategori, harga_beli, harga_jual, diskon, stok) VALUES ('$nama', '$barang', '$beli', '$jual', '$diskon', '$stok')";
  $hasil = mysqli_query($koneksi, $query);

  if ($hasil) {
    echo "<script type='text/javascript'>
          Swal.fire({
            icon: 'success',
            title: 'Data Berhasil Disimpan',
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
              title: 'Data Gagal Disimpan',
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
