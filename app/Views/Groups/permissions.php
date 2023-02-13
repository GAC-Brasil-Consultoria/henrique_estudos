<?php echo $this->extend('Layouts/default') ?>

<?php $this->section('title') ?> <?php echo $title; ?> <?php echo $this->endSection() ?>


<?php $this->section('styles') ?>
<link rel="stylesheet" type="text/css" href="<?php echo site_url('resources/vendor/selectize/selectize.bootstrap4.css') ?>" />

<style>
/* Estilizando o select para acompanhar a formatação do template */

.selectize-input,
.selectize-control.single .selectize-input.input-active {
    background: #2d3035 !important;
}

.selectize-dropdown,
.selectize-input,
.selectize-input input {
    color: #777;
}

.selectize-input {
    /*        height: calc(2.4rem + 2px);*/
    border: 1px solid #444951;
    border-radius: 0;
}
</style>

<?php echo $this->endSection() ?>


<?php $this->section('content') ?>

<div class="row">

    <div class="col-lg-8">

        <div class="user-block block">
            <?php if(empty($avaliablePerms)): ?>
            <p class="contributions mt-0">This group already have all avaliable permissions</p>

            <?php else: ?>

            <div id="response">

            </div>

            <?php echo form_open('/', ['id' => 'form'], ['id'=>"$group->id"]) ?>

            <div class="form-group">
                <label class="form-control-label">Choose one or more permissions</label>
                <select name="permission_id[]" id="selectize" multiple>
                    <?php foreach($avaliablePerms as $perm): ?>
                    <option value="<?php echo $perm->id ?>"><?php echo esc($perm->name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="block-body">
                <div class="form-group mt-5 mb-4">
                    <input id="btn-save" type="submit" value="Save" class="btn btn-danger btn-sm mr-2">
                    <a href="<?php echo site_url("groups/show/$group->id") ?>"
                        class="btn btn-secondary btn-sm ml-2">Back</a>
                </div>
            </div>

            <?php echo form_close(); ?>

            <?php endif; ?>


        </div>

    </div>

    <div class="col-lg-4">

        <div class="user-block block">


            <?php if(empty($group->permissions)): ?>
            <p class="contributions text-warning mt-0">This group don't have permissions yet</p>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Permission</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($group->permissions as $perm): ?>
                        <tr>
                            <td><?php echo esc($perm->name) ?></td>
                            <td>

                                <?php
                                    $atributes = [
                                        'onSubmit' => "return confirm('Are you sure?');"
                                    ];
                                ?>

                                <?php echo form_open("groups/removePerm/$group->id", $atributes) ?>
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                <?php echo form_close(); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-2">
                    <?php echo $group->pager->links(); ?>
                </div>
            </div>
            <?php endif; ?>


            <!-- Example single danger button -->

        </div>

    </div>

</div>

<?php echo $this->endSection() ?>


<?php $this->section('scripts') ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
$(document).ready(function() {
    $('#selectize').selectize();

    $("#form").on('submit', function(e){
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('groups/savePerms') ?>',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $("#response").html('');
                    $("#btn-save").val('Wait..');
                },
                success: function(response){
                    $("#btn-save").val('Save');
                    $("#btn-save").removeAttr("disabled");

                    $('[name=csrf_test_name ]').val(response.token);

                    if(!response.error)
                    {
                        
                        window.location.href = "<?php echo site_url("groups/permissions/$group->id"); ?>";
                    }
                    if(response.error)
                    {
                        $("#response").html('<div class="alert alert-danger">'+response.error+'</div>');
                        if(response.errors_model)
                        {
                            $.each(response.errors_model, function(key, value){
                                $('#response').append('<ul class="list-unstyled"><li class="text-danger">'+value+'</li></ul>')
                            })
                        }
                    }
                },
                error: function(e){
                    alert('Error');
                    var r = jQuery.parseJSON(e.responseText);
                    console.log("Message: " + r.Message);
                    console.log("StackTrace: " + r.StackTrace);
                    console.log("ExceptionType: " + r.ExceptionType);
                    $('#btn-salvar').val('Save');
                }
            })
        });
        $("#form").submit(function(){
            $(this).find(":submit").attr('disabled', 'disabled');
        });
});
</script>

<?php echo $this->endSection() ?>