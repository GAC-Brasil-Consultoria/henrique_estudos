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
                                <a href="#" class="btn btn-sm btn-danger">Delete</a>
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
});
</script>

<?php echo $this->endSection() ?>