<?php $request = app('Illuminate\Http\Request'); ?>


<?php $__env->startSection('content'); ?>
    <h3 class="page-title"><?php echo app('translator')->getFromJson('quickadmin.coursematerials.title'); ?></h3>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coursematerial_create')): ?>
    <p>
        <a href="<?php echo e(route('admin.coursematerials.create')); ?>" class="btn btn-success"><?php echo app('translator')->getFromJson('quickadmin.qa_add_new'); ?></a>
        
    </p>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coursematerial_delete')): ?>
    <p>
        <ul class="list-inline">
            <li><a href="<?php echo e(route('admin.coursematerials.index')); ?>" style="<?php echo e(request('show_deleted') == 1 ? '' : 'font-weight: 700'); ?>"><?php echo app('translator')->getFromJson('quickadmin.qa_all'); ?></a></li> |
            <li><a href="<?php echo e(route('admin.coursematerials.index')); ?>?show_deleted=1" style="<?php echo e(request('show_deleted') == 1 ? 'font-weight: 700' : ''); ?>"><?php echo app('translator')->getFromJson('quickadmin.qa_trash'); ?></a></li>
        </ul>
    </p>
    <?php endif; ?>


    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo app('translator')->getFromJson('quickadmin.qa_list'); ?>
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped <?php echo e(count($coursematerials) > 0 ? 'datatable' : ''); ?> <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coursematerial_delete')): ?> <?php if( request('show_deleted') != 1 ): ?> dt-select <?php endif; ?> <?php endif; ?>">
                <thead>
                    <tr>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coursematerial_delete')): ?>
                            <?php if( request('show_deleted') != 1 ): ?><th style="text-align:center;"><input type="checkbox" id="select-all" /></th><?php endif; ?>
                        <?php endif; ?>

                        <th><?php echo app('translator')->getFromJson('quickadmin.coursematerials.fields.coursename'); ?></th>
                        <th><?php echo app('translator')->getFromJson('quickadmin.coursematerials.fields.title'); ?></th>
                        <th><?php echo app('translator')->getFromJson('quickadmin.coursematerials.fields.slug'); ?></th>
                        <th><?php echo app('translator')->getFromJson('quickadmin.coursematerials.fields.description'); ?></th>
                        <th><?php echo app('translator')->getFromJson('quickadmin.coursematerials.fields.position'); ?></th>
                        <th><?php echo app('translator')->getFromJson('quickadmin.coursematerials.fields.lecture'); ?></th>
                        <th><?php echo app('translator')->getFromJson('quickadmin.coursematerials.fields.tutes'); ?></th>
                        <th><?php echo app('translator')->getFromJson('quickadmin.coursematerials.fields.freelessons'); ?></th>
                        <th><?php echo app('translator')->getFromJson('quickadmin.coursematerials.fields.published'); ?></th>
                        <?php if( request('show_deleted') == 1 ): ?>
                        <th>&nbsp;</th>
                        <?php else: ?>
                        <th>&nbsp;</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                
                <tbody>
                    <?php if(count($coursematerials) > 0): ?>
                        <?php $__currentLoopData = $coursematerials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coursematerial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr data-entry-id="<?php echo e($coursematerial->id); ?>">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coursematerial_delete')): ?>
                                    <?php if( request('show_deleted') != 1 ): ?><td></td><?php endif; ?>
                                <?php endif; ?>

                                <td field-key='coursename'><?php echo e(isset($coursematerial->coursename->coursename) ? $coursematerial->coursename->coursename : ''); ?></td>
                                <td field-key='title'><?php echo e($coursematerial->title); ?></td>
                                <td field-key='slug'><?php echo e($coursematerial->slug); ?></td>
                                <td field-key='description'><?php echo $coursematerial->description; ?></td>
                                <td field-key='position'><?php echo e($coursematerial->position); ?></td>
                                <td field-key='lecture'> <?php $__currentLoopData = $coursematerial->getMedia('lecture'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p class="form-group">
                                    <a href="<?php echo e($media->getUrl()); ?>" target="_blank"><?php echo e($media->name); ?> (<?php echo e($media->size); ?> KB)</a>
                                </p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
                                <td field-key='tutes'> <?php $__currentLoopData = $coursematerial->getMedia('tutes'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p class="form-group">
                                    <a href="<?php echo e($media->getUrl()); ?>" target="_blank"><?php echo e($media->name); ?> (<?php echo e($media->size); ?> KB)</a>
                                </p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
                                <td field-key='freelessons'><?php echo e(Form::checkbox("freelessons", 1, $coursematerial->freelessons == 1 ? true : false, ["disabled"])); ?></td>
                                <td field-key='published'><?php echo e(Form::checkbox("published", 1, $coursematerial->published == 1 ? true : false, ["disabled"])); ?></td>
                                <?php if( request('show_deleted') == 1 ): ?>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coursematerial_delete')): ?>
                                                                        <?php echo Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.coursematerials.restore', $coursematerial->id])); ?>

                                    <?php echo Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')); ?>

                                    <?php echo Form::close(); ?>

                                <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coursematerial_delete')): ?>
                                                                        <?php echo Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.coursematerials.perma_del', $coursematerial->id])); ?>

                                    <?php echo Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')); ?>

                                    <?php echo Form::close(); ?>

                                <?php endif; ?>
                                </td>
                                <?php else: ?>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coursematerial_view')): ?>
                                    <a href="<?php echo e(route('admin.coursematerials.show',[$coursematerial->id])); ?>" class="btn btn-xs btn-primary"><?php echo app('translator')->getFromJson('quickadmin.qa_view'); ?></a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coursematerial_edit')): ?>
                                    <a href="<?php echo e(route('admin.coursematerials.edit',[$coursematerial->id])); ?>" class="btn btn-xs btn-info"><?php echo app('translator')->getFromJson('quickadmin.qa_edit'); ?></a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coursematerial_delete')): ?>
<?php echo Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.coursematerials.destroy', $coursematerial->id])); ?>

                                    <?php echo Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')); ?>

                                    <?php echo Form::close(); ?>

                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="14"><?php echo app('translator')->getFromJson('quickadmin.qa_no_entries_in_table'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?> 
    <script>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coursematerial_delete')): ?>
            <?php if( request('show_deleted') != 1 ): ?> window.route_mass_crud_entries_destroy = '<?php echo e(route('admin.coursematerials.mass_destroy')); ?>'; <?php endif; ?>
        <?php endif; ?>

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>