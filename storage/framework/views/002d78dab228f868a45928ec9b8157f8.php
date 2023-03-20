<?php $__env->startSection('adminlte_css_pre'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php ($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login')); ?>
<?php ($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register')); ?>
<?php ($password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset')); ?>

<?php if(config('adminlte.use_route_url', false)): ?>
    <?php ($login_url = $login_url ? route($login_url) : ''); ?>
    <?php ($register_url = $register_url ? route($register_url) : ''); ?>
    <?php ($password_reset_url = $password_reset_url ? route($password_reset_url) : ''); ?>
<?php else: ?>
    <?php ($login_url = $login_url ? url($login_url) : ''); ?>
    <?php ($register_url = $register_url ? url($register_url) : ''); ?>
    <?php ($password_reset_url = $password_reset_url ? url($password_reset_url) : ''); ?>
<?php endif; ?>



<?php $__env->startSection('auth_body'); ?>
    <div class="mb-3 row d-flex justify-content-center">
        <img src="logo.png" height="50">
    </div>
    <label class="row d-flex justify-content-center">
        <?php echo e(__('adminlte::adminlte.login_message')); ?>

    </label>
    <form action="<?php echo e($login_url); ?>" method="post">
        <?php echo csrf_field(); ?>

        
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                value="<?php echo e(old('email')); ?>" placeholder="<?php echo e(__('adminlte::adminlte.email')); ?>" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope <?php echo e(config('adminlte.classes_auth_icon', '')); ?>"></span>
                </div>
            </div>

            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-feedback" role="alert">
                    <strong><?php echo e($message); ?></strong>
                </span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                placeholder="<?php echo e(__('adminlte::adminlte.password')); ?>">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock <?php echo e(config('adminlte.classes_auth_icon', '')); ?>"></span>
                </div>
            </div>

            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-feedback" role="alert">
                    <strong><?php echo e($message); ?></strong>
                </span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div class="row">
            

            <div class="col-12">
                <button type=submit class="btn btn-block btn-dark">
                    
                    
                    
                    <?php echo e(__('adminlte::adminlte.enter')); ?>

                </button>
            </div>
        </div>

    </form>
    <?php if($password_reset_url): ?>
        <p class="mt-2 mb-3"><?php echo e(__('adminlte::adminlte.i_forgot_my_password')); ?>

            <a href="<?php echo e($password_reset_url); ?>">
                <?php echo e(__('adminlte::adminlte.password_reset_message')); ?>

            </a>
        </p>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::auth.auth-page', ['auth_type' => 'login'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/n1577460/public_html/rekrutmen/vendor/jeroennoten/laravel-adminlte/src/../resources/views/auth/login.blade.php ENDPATH**/ ?>