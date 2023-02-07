<?php echo $this->extend('Layouts/default') ?>

<?php $this->section('title') ?> <?php echo $title; ?> <?php echo $this->endSection() ?>


<?php $this->section('styles') ?>

<?php echo $this->endSection() ?>


<?php $this->section('content') ?>

<div class="row">

    
    <?php if($group->id < 3): ?>
        <div class="col-md-12">
            <div class="alert alert-info" role="alert">
                <h4 class="alert-heading">Important!</h4>
                <p>The <b><?php echo esc($group->name) ?></b> group cannot be deleted</p>
                <hr>
                <p class="mb-0">Dont't worry, the others groups can be edited or deleted if you want</p>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="col-lg-3">      

        <div class="user-block block">

            <h4 class="card-title mt-2"><?php echo esc($group->name); ?></h5>
                <p class="card-text">Description: <?php echo $group->description ?></p>
                <p class="contributions mt-0">Status: <?php echo $group->showStatus() ?>

                    <?php if($group->deleted_at == null): ?>
                    <a tabindex="0" style="text-decoration: none;" role="button" data-toggle="popover"
                        data-trigger="hover" title="Important" data-content="This group will 
                    <?php echo $group->show == true ? '' : 'not'?> displayed as option">&nbsp;&nbsp;<i
                            class="fa fa-question-circle fa-lg text-danger"></i></a>
                    <?php endif; ?>
                </p>
                <p class="card-text">Created <?php echo $group->created_at->humanize(); ?></p>
                <p class="card-text">Updated <?php echo $group->updated_at->humanize(); ?></p>

                <?php if($group->id > 2): ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?php echo site_url("groups/edit/$group->id"); ?>">Edit group</a>

                        <div class="dropdown-divider"></div>
                        <?php if($group->deleted_at == null): ?>
                        <a class="dropdown-item" href="<?php echo site_url("groups/delete/$group->id"); ?>">Delete
                            group</a>
                        <?php else: ?>
                        <a class="dropdown-item"
                            href="<?php echo site_url("groups/restoregroup/$group->id"); ?>">Restore group</a>
                        <?php endif; ?>
                    </div>

                </div>
                <?php endif; ?>
                <a href="<?php echo site_url("groups") ?>" class="btn btn-secondary ml-2">Back</a>
                <!-- Example single danger button -->

        </div>

    </div>

</div>

<?php echo $this->endSection() ?>


<?php $this->section('scripts') ?>

<?php echo $this->endSection() ?>