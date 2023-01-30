<?php echo $this->extend('Layouts/default') ?>

<?php $this->section('title') ?> <?php echo $title; ?> <?php echo $this->endSection() ?>


<?php $this->section('content') ?>

<?php echo $this->endSection() ?>


<?php $this->section('content') ?>

<h1>Body content</h1>

<?php echo $this->endSection() ?>


<?php $this->section('scripts') ?>

<?php echo $this->endSection() ?>