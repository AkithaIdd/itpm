<?php $__env->startSection('content'); ?>
    <h3 class="page-title"><?php echo app('translator')->getFromJson('quickadmin.courses.title'); ?></h3>
    <?php echo Form::open(['method' => 'POST', 'route' => ['admin.courses.store'], 'files' => true,]); ?>


    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo app('translator')->getFromJson('quickadmin.qa_create'); ?>
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    <?php echo Form::label('coursename', trans('quickadmin.courses.fields.coursename').'*', ['class' => 'control-label']); ?>

                    <?php echo Form::text('coursename', old('coursename'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']); ?>

                    <p class="help-block"></p>
                    <?php if($errors->has('coursename')): ?>
                        <p class="help-block">
                            <?php echo e($errors->first('coursename')); ?>

                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <?php echo Form::label('teacher', trans('quickadmin.courses.fields.teacher').'', ['class' => 'control-label']); ?>

                    <button type="button" class="btn btn-primary btn-xs" id="selectbtn-teacher">
                        <?php echo e(trans('quickadmin.qa_select_all')); ?>

                    </button>
                    <button type="button" class="btn btn-primary btn-xs" id="deselectbtn-teacher">
                        <?php echo e(trans('quickadmin.qa_deselect_all')); ?>

                    </button>
                    <?php echo Form::select('teacher[]', $teachers, old('teacher'), ['class' => 'form-control select2', 'multiple' => 'multiple', 'id' => 'selectall-teacher' ]); ?>

                    <p class="help-block"></p>
                    <?php if($errors->has('teacher')): ?>
                        <p class="help-block">
                            <?php echo e($errors->first('teacher')); ?>

                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <?php echo Form::label('description', trans('quickadmin.courses.fields.description').'', ['class' => 'control-label']); ?>

                    <?php echo Form::textarea('description', old('description'), ['class' => 'form-control editor', 'placeholder' => '']); ?>

                    <p class="help-block"></p>
                    <?php if($errors->has('description')): ?>
                        <p class="help-block">
                            <?php echo e($errors->first('description')); ?>

                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <?php echo Form::label('price', trans('quickadmin.courses.fields.price').'', ['class' => 'control-label']); ?>

                    <?php echo Form::text('price', old('price'), ['class' => 'form-control', 'placeholder' => '']); ?>

                    <p class="help-block"></p>
                    <?php if($errors->has('price')): ?>
                        <p class="help-block">
                            <?php echo e($errors->first('price')); ?>

                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <?php echo Form::label('image', trans('quickadmin.courses.fields.image').'*', ['class' => 'control-label']); ?>

                    <?php echo Form::file('image[]', [
                        'multiple',
                        'class' => 'form-control file-upload',
                        'data-url' => route('admin.media.upload'),
                        'data-bucket' => 'image',
                        'data-filekey' => 'image',
                        ]); ?>

                    <p class="help-block"></p>
                    <div class="photo-block">
                        <div class="progress-bar form-group">&nbsp;</div>
                        <div class="files-list"></div>
                    </div>
                    <?php if($errors->has('image')): ?>
                        <p class="help-block">
                            <?php echo e($errors->first('image')); ?>

                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <?php echo Form::label('startdate', trans('quickadmin.courses.fields.startdate').'', ['class' => 'control-label']); ?>

                    <?php echo Form::text('startdate', old('startdate'), ['class' => 'form-control datetime', 'placeholder' => '']); ?>

                    <p class="help-block"></p>
                    <?php if($errors->has('startdate')): ?>
                        <p class="help-block">
                            <?php echo e($errors->first('startdate')); ?>

                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <?php echo Form::label('published', trans('quickadmin.courses.fields.published').'', ['class' => 'control-label']); ?>

                    <?php echo Form::hidden('published', 0); ?>

                    <?php echo Form::checkbox('published', 1, old('published', false), []); ?>

                    <p class="help-block"></p>
                    <?php if($errors->has('published')): ?>
                        <p class="help-block">
                            <?php echo e($errors->first('published')); ?>

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

    <script src="<?php echo e(url('adminlte/plugins/datetimepicker/moment-with-locales.min.js')); ?>"></script>
    <script src="<?php echo e(url('adminlte/plugins/datetimepicker/bootstrap-datetimepicker.min.js')); ?>"></script>
    <script>
        $(function(){
            moment.updateLocale('<?php echo e(App::getLocale()); ?>', {
                week: { dow: 1 } // Monday is the first day of the week
            });
            
            $('.datetime').datetimepicker({
                format: "<?php echo e(config('app.datetime_format_moment')); ?>",
                locale: "<?php echo e(App::getLocale()); ?>",
                sideBySide: true,
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
                        model_name: 'Course',
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
    <script>
        $("#selectbtn-teacher").click(function(){
            $("#selectall-teacher > option").prop("selected","selected");
            $("#selectall-teacher").trigger("change");
        });
        $("#deselectbtn-teacher").click(function(){
            $("#selectall-teacher > option").prop("selected","");
            $("#selectall-teacher").trigger("change");
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>