<?php echo $this->extend('Layouts/default') ?>

<?php $this->section('title') ?> <?php echo $title; ?> <?php echo $this->endSection() ?>


<?php $this->section('styles') ?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.13.1/r-2.4.0/datatables.min.css"/>

<?php echo $this->endSection() ?>


<?php $this->section('content') ?>

<div class="row">

<div class="col-lg-12">
                <div class="block">
                  <div class="table-responsive"> 
                    <table id="ajaxTable" class="table table-striped table-sm" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>Image</th>
                          <th>Name</th>
                          <th>e-mail</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>

</div>

<?php echo $this->endSection() ?>


<?php $this->section('scripts') ?>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/r-2.4.0/datatables.min.js"></script>

<script>
    $(document).ready(function () {
    $('#ajaxTable').DataTable({
        ajax: '<?php echo site_url('users/getUsers') ?>',
        columns: [
            { data: 'image' },
            { data: 'name' },
            { data: 'email' },
            { data: 'active' }
        ],
        "deferRender" : true,
        "processing" : true,
        "language" : {
          processing : '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>'
        },
        "responsive": true,
        "pagingType" : $(window).width() < 768 ? "simple" : "simple_numbers"
    });
});
</script>

<?php echo $this->endSection() ?>