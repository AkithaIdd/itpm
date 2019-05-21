<?php $request = app('Illuminate\Http\Request'); ?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">

             

            <li class="<?php echo e($request->segment(1) == 'home' ? 'active' : ''); ?>">
                <a href="<?php echo e(url('/')); ?>">
                    <i class="fa fa-wrench"></i>
                    <span class="title"><?php echo app('translator')->getFromJson('quickadmin.qa_dashboard'); ?></span>
                </a>
            </li>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_management_access')): ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span><?php echo app('translator')->getFromJson('quickadmin.user-management.title'); ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role_access')): ?>
                    <li>
                        <a href="<?php echo e(route('admin.roles.index')); ?>">
                            <i class="fa fa-briefcase"></i>
                            <span><?php echo app('translator')->getFromJson('quickadmin.roles.title'); ?></span>
                        </a>
                    </li><?php endif; ?>
                    
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_access')): ?>
                    <li>
                        <a href="<?php echo e(route('admin.users.index')); ?>">
                            <i class="fa fa-user"></i>
                            <span><?php echo app('translator')->getFromJson('quickadmin.users.title'); ?></span>
                        </a>
                    </li><?php endif; ?>
                    
                </ul>
            </li><?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('course_access')): ?>
            <li>
                <a href="<?php echo e(route('admin.courses.index')); ?>">
                    <i class="fa fa-align-left"></i>
                    <span><?php echo app('translator')->getFromJson('quickadmin.courses.title'); ?></span>
                </a>
            </li><?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coursematerial_access')): ?>
            <li>
                <a href="<?php echo e(route('admin.coursematerials.index')); ?>">
                    <i class="fa fa-paperclip"></i>
                    <span><?php echo app('translator')->getFromJson('quickadmin.coursematerials.title'); ?></span>
                </a>
            </li><?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assignment_access')): ?>
            <li>
                <a href="<?php echo e(route('admin.assignments.index')); ?>">
                    <i class="fa fa-flag-checkered"></i>
                    <span><?php echo app('translator')->getFromJson('quickadmin.assignments.title'); ?></span>
                </a>
            </li><?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('library_access')): ?>
            <li>
                <a href="<?php echo e(route('admin.libraries.index')); ?>">
                    <i class="fa fa-gears"></i>
                    <span><?php echo app('translator')->getFromJson('quickadmin.library.title'); ?></span>
                </a>
            </li><?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('notice_access')): ?>
            <li>
                <a href="<?php echo e(route('admin.notices.index')); ?>">
                    <i class="fa fa-gears"></i>
                    <span><?php echo app('translator')->getFromJson('quickadmin.notices.title'); ?></span>
                </a>
            </li><?php endif; ?>
            

            

            



            <li class="<?php echo e($request->segment(1) == 'change_password' ? 'active' : ''); ?>">
                <a href="<?php echo e(route('auth.change_password')); ?>">
                    <i class="fa fa-key"></i>
                    <span class="title"><?php echo app('translator')->getFromJson('quickadmin.qa_change_password'); ?></span>
                </a>
            </li>

            <li>
                <a href="#logout" onclick="$('#logout').submit();">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title"><?php echo app('translator')->getFromJson('quickadmin.qa_logout'); ?></span>
                </a>
            </li>
        </ul>
    </section>
</aside>

