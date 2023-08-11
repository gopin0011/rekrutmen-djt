
<?php $__env->startComponent('mail::message'); ?>
# Undangan Interview

Anda mendapatkan undangan interview dari PT. Dwida Jaya Tama:

<?php $__env->startComponent('mail::button', ['url' => $url]); ?>
    Daftar akun
<?php echo $__env->renderComponent(); ?>

## Detail undangan:

<?php $__env->startComponent('mail::table'); ?>
    |                 |                           |
    | --------------- | -------------------------:|
    | Nama kandidat   | <?php echo e($name); ?>               |
    | Posisi          | <?php echo e($vacancy); ?>            |
    | Bertemu dengan  | <?php echo e($sender); ?>             |
    | Tanggal         | <?php echo e($date); ?>               |
    | Waktu           | <?php echo e($time); ?>               |
    | Jenis interview | <?php echo e($type); ?>               |
    | Link interview  | <?php echo e($online_url); ?>         |
    | Invitation code | <?php echo e($code); ?>               |
<?php echo $__env->renderComponent(); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /home/n1577460/public_html/rekrutmen/resources/views/pages/invitation/invite.blade.php ENDPATH**/ ?>