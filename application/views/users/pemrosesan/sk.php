<!-- Main content -->
<div class="content-wrapper">
  <!-- Content area -->
  <div class="content">
    <?php
    echo $this->session->flashdata('msg');
    ?>
    <!-- Dashboard content -->
    <div class="row">
      <!-- Basic datatable -->
      <div class="panel panel-flat">
        <div class="panel-heading">
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Data Surat Keluar</h5>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>


<br>
                    <a href="users/sk" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Surat Keluar Baru</a>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th width="30px;">No. Agenda</th>
              <th>Nomor Surat</th>
              <th>Tujuan Surat</th>
              <th>Perihal</th>
              <th>Klasifikasi</th>
              <th>Tgl Surat</th>
              <th>File Surat</th>
              <th>Keterangan</th>
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($sk->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.';?></td>
                  <td><?php echo $baris->no_surat; ?></td>
                  <td><?php echo $baris->tujuan_surat; ?></td>
                  <td><?php echo $baris->perihal; ?></td>
                  <td><?php echo $baris->klasifikasi; ?></td>
                  <td><?php echo $baris->tgl_surat; ?></td>
                  <td><?php echo $baris->file_surat; ?></td>
                  <td><?php echo $baris->keterangan; ?></td>
                 
                  <td>
                    <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalbro<?= $baris->id_sk; ?>"><i class="icon-eye"></i></button>
                  <a href="users/editsk/<?php echo $baris->id_sk; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>
                    <a href="users/deletesk/<?php echo $baris->id_sk; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin?')"><i class="icon-trash"></i></a>
                  </td>
                </tr>
                  <!-- Modal -->
<div class="modal fade" id="modalbro<?= $baris->id_sk; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background:aqua;">
        <h5 class="modal-title" id="exampleModalLongTitle">Detail Surat Keluar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="row"">
         <div class="col-6">No Surat    :</div>
         <div class="col-6"><?php echo $baris->no_surat; ?></div>
           <div class="col-6">Tujuan Surat    :</div>
         <div class="col-6"><?php echo $baris->tujuan_surat; ?></div>
           <div class="col-6">Perihal Surat    :</div>
         <div class="col-6"><?php echo $baris->perihal; ?></div>
           <div class="col-6">Klasifikasi    :</div>
         <div class="col-6"><?php echo $baris->klasifikasi; ?></div>
           <div class="col-6">Tanggal Surat    :</div>
         <div class="col-6"><?php echo $baris->tgl_surat; ?></div>
           <div class="col-6">File Surat    :</div>
         <div class="col-6"><a href="/uploads/suratmasuk/<?php echo $baris->file_surat; ?>"><?php echo $baris->file_surat; ?></a></div>
           <div class="col-6">Keterangan    :</div>
         <div class="col-6"><?php echo $baris->keterangan; ?></div>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
              <?php
              $no++;
              } ?>
          </tbody>
        </table>
      </div>
      <!-- /basic datatable -->
    </div>
    <!-- /dashboard content -->

