<?php

namespace App\Http\Controllers\Admin;

use App\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAssignmentsRequest;
use App\Http\Requests\Admin\UpdateAssignmentsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class AssignmentsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Assignment.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('assignment_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('assignment_delete')) {
                return abort(401);
            }
            $assignments = Assignment::onlyTrashed()->get();
        } else {
            $assignments = Assignment::all();
        }

        return view('admin.assignments.index', compact('assignments'));
    }

    /**
     * Show the form for creating new Assignment.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('assignment_create')) {
            return abort(401);
        }
        
        $coursenames = \App\Course::get()->pluck('coursename', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.assignments.create', compact('coursenames'));
    }

    /**
     * Store a newly created Assignment in storage.
     *
     * @param  \App\Http\Requests\StoreAssignmentsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssignmentsRequest $request)
    {
        if (! Gate::allows('assignment_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $assignment = Assignment::create($request->all());


        foreach ($request->input('file_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $assignment->id;
            $file->save();
        }
        foreach ($request->input('marks_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $assignment->id;
            $file->save();
        }

        return redirect()->route('admin.assignments.index');
    }


    /**
     * Show the form for editing Assignment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('assignment_edit')) {
            return abort(401);
        }
        
        $coursenames = \App\Course::get()->pluck('coursename', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $assignment = Assignment::findOrFail($id);

        return view('admin.assignments.edit', compact('assignment', 'coursenames'));
    }

    /**
     * Update Assignment in storage.
     *
     * @param  \App\Http\Requests\UpdateAssignmentsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssignmentsRequest $request, $id)
    {
        if (! Gate::allows('assignment_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $assignment = Assignment::findOrFail($id);
        $assignment->update($request->all());


        $media = [];
        foreach ($request->input('file_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $assignment->id;
            $file->save();
            $media[] = $file->toArray();
        }
        $assignment->updateMedia($media, 'file');
        $media = [];
        foreach ($request->input('marks_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $assignment->id;
            $file->save();
            $media[] = $file->toArray();
        }
        $assignment->updateMedia($media, 'marks');

        return redirect()->route('admin.assignments.index');
    }


    /**
     * Display Assignment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('assignment_view')) {
            return abort(401);
        }
        $assignment = Assignment::findOrFail($id);

        return view('admin.assignments.show', compact('assignment'));
    }


    /**
     * Remove Assignment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('assignment_delete')) {
            return abort(401);
        }
        $assignment = Assignment::findOrFail($id);
        $assignment->deletePreservingMedia();

        return redirect()->route('admin.assignments.index');
    }

    /**
     * Delete all selected Assignment at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('assignment_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Assignment::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->deletePreservingMedia();
            }
        }
    }


    /**
     * Restore Assignment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('assignment_delete')) {
            return abort(401);
        }
        $assignment = Assignment::onlyTrashed()->findOrFail($id);
        $assignment->restore();

        return redirect()->route('admin.assignments.index');
    }

    /**
     * Permanently delete Assignment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('assignment_delete')) {
            return abort(401);
        }
        $assignment = Assignment::onlyTrashed()->findOrFail($id);
        $assignment->forceDelete();

        return redirect()->route('admin.assignments.index');
    }
}
