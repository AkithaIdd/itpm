<?php $request = app('Illuminate\Http\Request'); ?>


<?php $__env->startSection('content'); ?>
    <h3 class="page-title"><?php echo app('translator')->getFromJson('quickadmin.assignments.title'); ?></h3>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assignment_create')): ?>
    <p>
        <a href="<?php echo e(route('admin.assignments.create')); ?>" class="btn btn-success"><?php echo app('translator')->getFromJson('quickadmin.qa_add_new'); ?></a>
        
    </p>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assignment_delete')): ?>
    <p>
        <ul class="list-inline">
            <li><a href="<?php echo e(route('admin.assignments.index')); ?>" style="<?php echo e(request('show_deleted') == 1 ? '' : 'font-weight: 700'); ?>"><?php echo app('translator')->getFromJson('quickadmin.qa_all'); ?></a></li> |
            <li><a href="<?php echo e(route('admin.assignments.index')); ?>?show_deleted=1" style="<?php echo e(request('show_deleted') == 1 ? 'font-weight: 700' : ''); ?>"><?php echo app('translator')->getFromJson('quickadmin.qa_trash'); ?></a></li>
        </ul>
    </p>
    <?php endif; ?>


    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo app('translator')->getFromJson('quickadmin.qa_list'); ?>
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped <?php echo e(count($assignments) > 0 ? 'datatable' : ''); ?> <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assignment_delete')): ?> <?php if( request('show_deleted') != 1 ): ?> dt-select <?php endif; ?> <?php endif; ?>">
                <thead>
                    <tr>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assignment_delete')): ?>
                            <?php if( request('show_deleted') != 1 ): ?><th style="text-align:center;"><input type="checkbox" id="select-all" /></th><?php endif; ?>
                        <?php endif; ?>

                        <th><?php echo app('translator')->getFromJson('quickadmin.assignments.fields.coursename'); ?></th>
                        <th><?php echo app('translator')->getFromJson('quickadmin.assignments.fields.assignmenttitle'); ?></th>
                        <th><?php echo app('translator')->getFromJson('quickadmin.assignments.fields.question'); ?></th>
                        <th><?php echo app('translator')->getFromJson('quickadmin.assignments.fields.file'); ?></th>
                        <th><?php echo app('translator')->getFromJson('quickadmin.assignments.fields.submittion'); ?></th>
                        <th><?php echo app('translator')->getFromJson('quickadmin.assignments.fields.marks'); ?></th>
                        <?php if( request('show_deleted') == 1 ): ?>
                        <th>&nbsp;</th>
                        <?php else: ?>
                        <th>&nbsp;</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                
                <tbody>
                    <?php if(count($assignments) > 0): ?>
                        <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr data-entry-id="<?php echo e($assignment->id); ?>">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assignment_delete')): ?>
                                    <?php if( request('show_deleted') != 1 ): ?><td></td><?php endif; ?>
                                <?php endif; ?>

                                <td field-key='coursename'><?php echo e(isset($assignment->coursename->coursename) ? $assignment->coursename->coursename : ''); ?></td>
                                <td field-key='assignmenttitle'><?php echo e($assignment->assignmenttitle); ?></td>
                                <td field-key='question'><?php echo $assignment->question; ?></td>
                                <td field-key='file'> <?php $__currentLoopData = $assignment->getMedia('file'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p class="form-group">
                                    <a href="<?php echo e($media->getUrl()); ?>" target="_blank"><?php echo e($media->name); ?> (<?php echo e($media->size); ?> KB)</a>
                                </p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
                                <td field-key='submittion'><?php echo e($assignment->submittion); ?></td>
                                <td field-key='marks'> <?php $__currentLoopData = $assignment->getMedia('marks'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p class="form-group">
                                    <a href="<?php echo e($media->getUrl()); ?>" target="_blank"><?php echo e($media->name); ?> (<?php echo e($media->size); ?> KB)</a>
                                </p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
                                <?php if( request('show_deleted') == 1 ): ?>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assignment_delete')): ?>
                                                                        <?php echo Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.assignments.restore', $assignment->id])); ?>

                                    <?php echo Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')); ?>

                                    <?php echo Form::close(); ?>

                                <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assignment_delete')): ?>
                                                                        <?php echo Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.assignments.perma_del', $assignment->id])); ?>

                                    <?php echo Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')); ?>

                                    <?php echo Form::close(); ?>

                                <?php endif; ?>
                                </td>
                                <?php else: ?>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assignment_view')): ?>
                                    <a href="<?php echo e(route('admin.assignments.show',[$assignment->id])); ?>" class="btn btn-xs btn-primary"><?php echo app('translator')->getFromJson('quickadmin.qa_view'); ?></a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assignment_edit')): ?>
                                    <a href="<?php echo e(route('admin.assignments.edit',[$assignment->id])); ?>" class="btn btn-xs btn-info"><?php echo app('translator')->getFromJson('quickadmin.qa_edit'); ?></a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assignment_delete')): ?>
<?php echo Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.assignments.destroy', $assignment->id])); ?>

                                    <?php echo Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')); ?>

                                    <?php echo Form::close(); ?>

                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11"><?php echo app('translator')->getFromJson('quickadmin.qa_no_entries_in_table'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?> 
    <script>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assignment_delete')): ?>
            <?php if( request('show_deleted') != 1 ): ?> window.route_mass_crud_entries_destroy = '<?php echo e(route('admin.assignments.mass_destroy')); ?>'; <?php endif; ?>
        <?php endif; ?>

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>