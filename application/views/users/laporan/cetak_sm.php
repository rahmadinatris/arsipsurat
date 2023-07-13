<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Surat Keluar</title>
    <base href="<?php echo base_url();?>"/>
  </head>
  <body onload="window.print()">

    <table border="0" width="100%">
      <tr>
        <td width="120">
          <img src="assets/logo.png" alt="logo1" width="120">
        </td>
        <td align="center">
          <h1>Sistem Manajemen Surat RA PERISAI BANGSA</h1>
        </td>
        <td width="120">
          <img src="assets/logo.png" alt="logo2" width="120">
        </td>
      </tr>
    </table>

    <hr>

    <h2 align="center">Laporan Surat Masuk</h2>
    <br>
    <table border="1"width="100%">
      <tr>
        <th width="1%">No</th>
              <th width="20%">Asal Surat</th>
              <th width="10%">Tgl. Surat</th>
              <th width="10%">No. Surat</th>
              <th width="20%">Perihal</th>
      </tr>
      <?php
      $no=1;
      foreach ($sql->result() as $baris) {?>
        <tr>
         <td><?php echo $no; ?></td>
                  <td><?php echo $baris->asal_surat; ?></td>
                  <td><?php echo $baris->tgl_surat; ?></td>
                  <td><?php echo $baris->no_surat; ?></td>
                  <td><?php echo $baris->perihal; ?></td>
        </tr>
      <?php
      $no++;
      } ?>
    </table>

  </body>
</html>
