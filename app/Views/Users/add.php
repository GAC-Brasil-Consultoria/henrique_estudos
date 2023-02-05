<?php echo $this->extend('Layouts/default') ?>

<?php $this->section('title') ?> <?php echo $title; ?> <?php echo $this->endSection() ?>


<?php $this->section('styles') ?>

<?php echo $this->endSection() ?>


<?php $this->section('content') ?>

<div class="row">

    <div class="col-lg-4">
        <div class="block">

            <div id="response">

            </div>

            <?php echo form_open('/', ['id' => 'form'], ['id'=>"$user->id"]) ?>

            <?php echo $this->include('Users/_form') ?>
            
            <div class="block-body">
                <div class="form-group mt-5 mb-4">
                    <input id="btn-save" type="submit" value="Save" class="btn btn-danger btn-sm mr-2">
                    <a href="<?php echo site_url("users") ?>" class="btn btn-secondary btn-sm ml-2">Back</a>
                </div>
            </div>
            
            <?php echo form_close(); ?>
            
        </div>
    </div>
</div>

<?php echo $this->endSection() ?>


<?php $this->section('scripts') ?>

<script>
    $(document).ready(function(){

        $("#form").on('submit', function(e){
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('users/insert') ?>',
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
                        
                        if(response.info)
                        {
                            $("#response").html('<div class="alert alert-primary">'+response.info+'</div>')
                            
                        }
                        else
                        {
                            window.location.href = "<?php echo site_url("users/show/"); ?>"+response.id;
                        }
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