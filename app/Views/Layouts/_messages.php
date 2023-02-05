<?php if(session()->has('sucess')): ?>

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Sucess!</strong> <?php echo session('sucess'); ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<?php endif; ?>

<?php if(session()->has('info')): ?>

<div class="alert alert-info alert-dismissible fade show" role="alert">
    <strong>Info:</strong> <?php echo session('info'); ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<?php endif; ?>

<?php if(session()->has('errors_model')): ?>

<ul>
    <?php foreach($errors_model as $error): ?>
    <li class="text-danger"><?php echo $error; ?></li>
    <?php endforeach; ?>
</ul>

<?php endif; ?>

<?php if(session()->has('error')): ?>

<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> <?php echo session('error'); ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<?php endif; ?>