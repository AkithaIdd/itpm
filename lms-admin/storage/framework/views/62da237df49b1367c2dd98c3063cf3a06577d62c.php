<?php $__env->startSection('content'); ?>
    <h3 class="page-title"><?php echo app('translator')->getFromJson('quickadmin.assignments.title'); ?></h3>
    <?php echo Form::open(['method' => 'POST', 'route' => ['admin.assignments.store'], 'files' => true,]); ?>


    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo app('translator')->getFromJson('quickadmin.qa_create'); ?>
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    <?php echo Form::label('coursename_id', trans('quickadmin.assignments.fields.coursename').'*', ['class' => 'control-label']); ?>

                    <?php echo Form::select('coursename_id', $coursenames, old('coursename_id'), ['class' => 'form-control select2', 'required' => '']); ?>

                    <p class="help-block"></p>
                    <?php if($errors->has('coursename_id')): ?>
                        <p class="help-block">
                            <?php echo e($errors->first('coursename_id')); ?>

                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <?php echo Form::label('assignmenttitle', trans('quickadmin.assignments.fields.assignmenttitle').'*', ['class' => 'control-label']); ?>

                    <?php echo Form::text('assignmenttitle', old('assignmenttitle'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']); ?>

                    <p class="help-block"></p>
                    <?php if($errors->has('assignmenttitle')): ?>
                        <p class="help-block">
                            <?php echo e($errors->first('assignmenttitle')); ?>

                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <?php echo Form::label('question', trans('quickadmin.assignments.fields.question').'', ['class' => 'control-label']); ?>

                    <?php echo Form::textarea('question', old('question'), ['class' => 'form-control editor', 'placeholder' => '']); ?>

                    <p class="help-block"></p>
                    <?php if($errors->has('question')): ?>
                        <p class="help-block">
                            <?php echo e($errors->first('question')); ?>

                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <?php echo Form::label('file', trans('quickadmin.assignments.fields.file').'*', ['class' => 'control-label']); ?>

                    <?php echo Form::file('file[]', [
                        'multiple',
                        'class' => 'form-control file-upload',
                        'data-url' => route('admin.media.upload'),
                        'data-bucket' => 'file',
                        'data-filekey' => 'file',
                        ]); ?>

                    <p class="help-block"></p>
                    <div class="photo-block">
                        <div class="progress-bar form-group">&nbsp;</div>
                        <div class="files-list"></div>
                    </div>
                    <?php if($errors->has('file')): ?>
                        <p class="help-block">
                            <?php echo e($errors->first('file')); ?>

                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <?php echo Form::label('submittion', trans('quickadmin.assignments.fields.submittion').'*', ['class' => 'control-label']); ?>

                    <?php echo Form::text('submittion', old('submittion'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']); ?>

                    <p class="help-block"></p>
                    <?php if($errors->has('submittion')): ?>
                        <p class="help-block">
                            <?php echo e($errors->first('submittion')); ?>

                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <?php echo Form::label('marks', trans('quickadmin.assignments.fields.marks').'', ['class' => 'control-label']); ?>

                    <?php echo Form::file('marks[]', [
                        'multiple',
                        'class' => 'form-control file-upload',
                        'data-url' => route('admin.media.upload'),
                        'data-bucket' => 'marks',
                        'data-filekey' => 'marks',
                        ]); ?>

                    <p class="help-block"></p>
                    <div class="photo-block">
                        <div class="progress-bar form-group">&nbsp;</div>
                        <div class="files-list"></div>
                    </div>
                    <?php if($errors->has('marks')): ?>
                        <p class="help-block">
                            <?php echo e($errors->first('marks')); ?>

                        </p>
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
    </div>

    <?php echo Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']); ?>

    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    ##parent-placeholder-b6e13ad53d8ec41b034c49f131c64e99cf25207a##
    <script src="//cdn.ckeditor.com/4.5.4/full/ckeditor.js"></script>
    <script>
        $('.editor').each(function () {
                  CKEDITOR.replace($(this).attr('id'),{
                    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=<?php echo e(csrf_token()); ?>',
                    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=<?php echo e(csrf_token()); ?>'
            });
        });
    </script>

    <script src="<?php echo e(asset('quickadmin/plugins/fileUpload/js/jquery.iframe-transport.js')); ?>"></script>
    <script src="<?php echo e(asset('quickadmin/plugins/fileUpload/js/jquery.fileupload.js')); ?>"></script>
    <script>
        $(function () {
            $('.file-upload').each(function () {
                var $this = $(this);
                var $parent = $(this).parent();

                $(this).fileupload({
                    dataType: 'json',
                    formData: {
                        model_name: 'Assignment',
                        bucket: $this.data('bucket'),
                        file_key: $this.data('filekey'),
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    add: function (e, data) {
                        data.submit();
                    },
                    done: function (e, data) {
                        $.each(data.result.files, function (index, file) {
                            var $line = $($('<p/>', {class: "form-group"}).html(file.name + ' (' + file.size + ' bytes)').appendTo($parent.find('.files-list')));
                            $line.append('<a href="#" class="btn btn-xs btn-danger remove-file">Remove</a>');
                            $line.append('<input type="hidden" name="' + $this.data('bucket') + '_id[]" value="' + file.id + '"/>');
                            if ($parent.find('.' + $this.data('bucket') + '-ids').val() != '') {
                                $parent.find('.' + $this.data('bucket') + '-ids').val($parent.find('.' + $this.data('bucket') + '-ids').val() + ',');
                            }
                            $parent.find('.' + $this.data('bucket') + '-ids').val($parent.find('.' + $this.data('bucket') + '-ids').val() + file.id);
                        });
                        $parent.find('.progress-bar').hide().css(
                            'width',
                            '0%'
                        );
                    }
                }).on('fileuploadprogressall', function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $parent.find('.progress-bar').show().css(
                        'width',
                        progress + '%'
                    );
                });
            });
            $(document).on('click', '.remove-file', function () {
                var $parent = $(this).parent();
                $parent.remove();
                return false;
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>