<?php echo $this->extend('Layouts/default') ?>

<?php $this->section('title') ?> <?php echo $title; ?> <?php echo $this->endSection() ?>


<?php $this->section('styles') ?>

<?php echo $this->endSection() ?>


<?php $this->section('content') ?>

<div class="row">

    <div class="col-lg-4">
        <div class="block">
            
            <div class="text-center">
                <?php if($user->image == null): ?>
                    <img src="<?php echo site_url('resources/img/blankImg.png')?>" class="card-img-top" style="width: 90%;" alt="User without profile picture">
                <?php else: ?>
                    <img src="<?php echo site_url("users/image/$user->image")?>" class="card-img-top" style="width: 90%;" alt="<?php echo esc($user->name)?> profile picture">

                <?php endif; ?>
                <a href="<?php echo site_url("users/changeImg/$user->id")?>" class="btn btn-outline-primary btn-sm mt-3">Change profile picture</a>
            </div>

            <hr class="border-secondary">

            <h5 class="card-title mt-2"><?php echo esc($user->name); ?></h5>
            <p class="card-text"><?php echo esc($user->email); ?></p>
            <p class="card-text">Status: <?php echo ($user->active == true) ? 'Active' : 'Inactive'; ?></p>
            <p class="card-text">Created <?php echo $user->created_at->humanize(); ?></p>
            <p class="card-text">Updated <?php echo $user->updated_at->humanize(); ?></p>
            <!-- Example single danger button -->
            <div class="btn-group">
            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Actions
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="<?php echo site_url("users/edit/$user->id"); ?>">Edit user</a>
                
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo site_url("users/delete/$user->id"); ?>">Delete user</a>
            </div>
            <a href="<?php echo site_url("users") ?>" class="btn btn-secondary ml-2">Back</a>
        </div>
    </div>

    </div>

</div>

<?php echo $this->endSection() ?>


<?php $this->section('scripts') ?>

<?php echo $this->endSection() ?>