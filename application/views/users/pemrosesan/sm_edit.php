<script src="assets/js/select2.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>
<script>

$( function() {
  $( "#tgl_surat" ).datepicker();
} );

</script>
<script type="text/javascript" src="assets/js/core/app.js"></script>

<link rel="stylesheet" type="text/css" href="assets/upload/dropzone.min.css">
<!-- <link rel="stylesheet" type="text/css" href="assets/upload/basic.min.css"> -->
<script type="text/javascript" src="assets/upload/dropzone.min.js"></script>

<style>
.dropzone {
  margin-top: 10px;
  border: 2px dashed #0087F7;
}
</style>

<!-- Main content -->
<div class="content-wrapper">
  <!-- Content area -->
  <div class="content">

    <!-- Dashboard content -->
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <div class="panel panel-flat">

            <div class="panel-body">

              <fieldset class="content-group">
                <legend class="text-bold"><i class="icon-folder-download2"></i> Edit Surat Masuk Baru</legend>
                <?php
                echo $this->session->flashdata('msg');
                ?>
                <div class="msg"></div>
                <?php foreach ($query as $query) { ?>
                <form class="form-horizontal" action="users/editsmm" enctype="multipart/form-data" method="post">
                    <!-- <div class="form-group">
                      <label class="control-label col-lg-3">Nomor</label>
                      <div class="col-lg-5">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="icon-database"></i></span>
                          <select class="form-control cari_ns" name="ns" id="ns" required>
                            <option value=""></option>
                            <?php foreach ($sm as $baris): ?>
                                <option value="<?php echo $baris->no_surat; ?>"><?php echo $baris->no_surat; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="icon-calendar"></i></span>
                          <input type="text" name="tgl_ns" class="form-control daterange-single" id="tgl_ns" value="<?php echo date('d-m-Y'); ?>" maxlength="10" required placeholder="Masukkan Tanggal">
                        </div>
                      </div>
                    </div> -->
  <input type="hidden" name="id_sm" id="id_sm" class="form-control" placeholder="" value="<?= $query->id_sm;  ?>" required>
                    <div class="form-group">
                      <label class="control-label col-lg-3">No. Surat</label>
                      <div class="col-lg-5">
    												<input type="text" name="no_asalx" id="no_asalx" class="form-control" placeholder="" value="<?= $query->no_surat;  ?>" required readonly>
                            <input type="hidden" name="no_asal" id="no_asal" class="form-control" placeholder="" value="<?= $query->no_surat;  ?>" required>
    									</div>
                      </div>
                   
                    <div class="form-group">
                      <label class="control-label col-lg-3">Asal Surat</label>
                      <div class="col-lg-9">
    												<input type="text" name="asal_surat" id="asal_surat" class="form-control" value="<?= $query->asal_surat;  ?>" placeholder="">
    									</div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-lg-3">Perihal</label>
                      <div class="col-lg-9">
    												<input type="text" name="perihal" id="perihal" class="form-control" value="<?= $query->perihal;  ?>" placeholder="">
    									</div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Klasifikasi</label>
                      <div class="col-lg-9">
    												<input type="text" name="klasifikasi" id="klasifikasi" class="form-control" value="<?= $query->klasifikasi;  ?>" placeholder="">
    									</div>
                    </div>

                     <div class="col-lg-4">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="icon-calendar"></i></span>
                          <input type="text" name="tgl_surat" class="form-control daterange-single" id="tgl_surat"value="<?= $query->tgl_surat;  ?>" maxlength="10" required placeholder="Masukkan Tanggal">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
    <label for="exampleFormControlFile1">Example file input</label>
    <input type="file" class="form-control-file" id="fileupload1" name="fileupload1" value="<?= $query->file_surat;  ?>">
    <br />
    <?= $query->file_surat;  ?>
  </div>

  <?php if (isset($error)) : ?>
					<div class="invalid-feedback"><?= $error ?></div>
				<?php endif; ?>
                          <i style="color:red">*File Surat wajib diisi</i>
    									

                    <div class="form-group">
                      <label class="control-label col-lg-3">Keterangan</label>
                      <div class="col-lg-9">
    												<input type="text" name="keterangan" id="keterangan" class="form-control" value="<?= $query->keterangan;  ?>" placeholder="">
    									</div>
                    </div>

                    <hr>
                    
                    <a href="users/sm" class="btn btn-default"><< Kembali</a>
                    <button type="submit" class="btn btn-primary" style="float:right;">Kirim</button>
                </form>

                 <?php } ?>
              </fieldset>


            </div>

        </div>
      </div>
    </div>
    <!-- /dashboard content -->

<script type="text/javascript">

$('.msg').html('');

Dropzone.options.myDropzone = {

  // Prevents Dropzone from uploading dropped files immediately
  url: "<?php echo base_url('users/sm') ?>",
  paramName:"userfile",
  // acceptedFiles:"'file/doc','file/xls','file/xlsx','file/docx','file/pdf','file/txt',image/jpg,image/jpeg,image/png,image/bmp",
  autoProcessQueue: false,
  maxFilesize: 10, //MB
  parallelUploads: 10,
  maxFiles: 10,
  addRemoveLinks:true,
  dictCancelUploadConfirmation: "Yakin ingin membatalkan upload ini?",
  dictInvalidFileType: "Type file ini tidak dizinkan",
  dictFileTooBig: "File yang Anda Upload terlalu besar {{filesize}} MB. Maksimal Upload {{maxFilesize}} MB",
  dictRemoveFile: "Hapus",

  init: function() {
    var submitButton = document.querySelector("#submit-all")
        myDropzone = this; // closure

    submitButton.addEventListener("click", function(e) {
      // if ($("#ns").val() == '' || $("#tgl_ns").val() == '' || $("#no_asal").val() == '' || ("#tgl_no_asal").val() == '') {
      //     alert('Nomor dan No. Surat wajib diisi!');
      // }
      e.preventDefault();
      e.stopPropagation();
      myDropzone.processQueue(); // Tell Dropzone to process all queued files.
    });

    // You might want to show the submit button only when

    this.on("error", function(file, message) {
                alert(message);
                this.removeFile(file);
                errors = true;
    });

    // files are dropped here:
    this.on("addedfile", function(file) {
      // Show submit button here and/or inform user to click it.
      //  alert("Apakah anda yakin");
    });

    this.on("sending", function(data, xhr, formData) {
            formData.append("nomor_surat", jQuery("#nomor_surat").val());
            formData.append("asal_surat", jQuery("#asal_surat").val());
            formData.append("perihal", jQuery("#perihal").val());
            formData.append("klasifikasi", jQuery("#klasifikasi").val());
            formData.append("tgl_surat", jQuery("#tgl_surat").val());
            formData.append("keterangan", jQuery("#keterangan").val());
    });

    this.on("complete", function(file) {
      //Event ketika Memulai mengupload
      myDropzone.removeFile(file);
    });

      this.on("success", function (file, response) {
      //Event ketika Memulai mengupload
      // console.log(response);
      //           $(response).each(function (index, element) {
      //               if (element.status) {
      //               }
      //               else {

      $(".sm").select2({
        placeholder: "Pilih nomor",
        allowClear: true
      });
      $(".sm").val('').trigger('change');
                            $('.form-horizontal')[0].reset();
                            $('.msg').html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                          '     <button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                          '       <span aria-hidden="true">&times;&nbsp; &nbsp;</span>'+
                                          '     </button>'+
                                          '     <strong>Sukses!</strong> Surat Masuk berhasil dikirim.'+
                                          '  </div>');
                            $("#no_asal").focus();

                            alert('Sukses, Surat Masuk berhasil dikirim');
                            
                //     }
                // });


      myDropzone.removeFile(file);
    });

  }
};

</script>
