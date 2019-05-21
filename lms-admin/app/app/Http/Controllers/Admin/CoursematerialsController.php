<?php

namespace App\Http\Controllers\Admin;

use App\Coursematerial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCoursematerialsRequest;
use App\Http\Requests\Admin\UpdateCoursematerialsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class CoursematerialsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Coursematerial.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('coursematerial_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('coursematerial_delete')) {
                return abort(401);
            }
            $coursematerials = Coursematerial::onlyTrashed()->get();
        } else {
            $coursematerials = Coursematerial::all();
        }

        return view('admin.coursematerials.index', compact('coursematerials'));
    }

    /**
     * Show the form for creating new Coursematerial.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('coursematerial_create')) {
            return abort(401);
        }
        
        $coursenames = \App\Course::get()->pluck('coursename', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.coursematerials.create', compact('coursenames'));
    }

    /**
     * Store a newly created Coursematerial in storage.
     *
     * @param  \App\Http\Requests\StoreCoursematerialsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCoursematerialsRequest $request)
    {
        if (! Gate::allows('coursematerial_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $coursematerial = Coursematerial::create($request->all() + ['position' => Coursematerial::where('coursename_id', $request->coursename_id)->max('position') + 3]);


        foreach ($request->input('lecture_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $coursematerial->id;
            $file->save();
        }
        foreach ($request->input('tutes_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $coursematerial->id;
            $file->save();
        }

        return redirect()->route('admin.coursematerials.index');
    }


    /**
     * Show the form for editing Coursematerial.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('coursematerial_edit')) {
            return abort(401);
        }
        
        $coursenames = \App\Course::get()->pluck('coursename', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $coursematerial = Coursematerial::findOrFail($id);

        return view('admin.coursematerials.edit', compact('coursematerial', 'coursenames'));
    }

    /**
     * Update Coursematerial in storage.
     *
     * @param  \App\Http\Requests\UpdateCoursematerialsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCoursematerialsRequest $request, $id)
    {
        if (! Gate::allows('coursematerial_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $coursematerial = Coursematerial::findOrFail($id);
        $coursematerial->update($request->all());


        $media = [];
        foreach ($request->input('lecture_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $coursematerial->id;
            $file->save();
            $media[] = $file->toArray();
        }
        $coursematerial->updateMedia($media, 'lecture');
        $media = [];
        foreach ($request->input('tutes_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $coursematerial->id;
            $file->save();
            $media[] = $file->toArray();
        }
        $coursematerial->updateMedia($media, 'tutes');

        return redirect()->route('admin.coursematerials.index');
    }


    /**
     * Display Coursematerial.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('coursematerial_view')) {
            return abort(401);
        }
        $coursematerial = Coursematerial::findOrFail($id);

        return view('admin.coursematerials.show', compact('coursematerial'));
    }


    /**
     * Remove Coursematerial from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('coursematerial_delete')) {
            return abort(401);
        }
        $coursematerial = Coursematerial::findOrFail($id);
        $coursematerial->deletePreservingMedia();

        return redirect()->route('admin.coursematerials.index');
    }

    /**
     * Delete all selected Coursematerial at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('coursematerial_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Coursematerial::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->deletePreservingMedia();
            }
        }
    }


    /**
     * Restore Coursematerial from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('coursematerial_delete')) {
            return abort(401);
        }
        $coursematerial = Coursematerial::onlyTrashed()->findOrFail($id);
        $coursematerial->restore();

        return redirect()->route('admin.coursematerials.index');
    }

    /**
     * Permanently delete Coursematerial from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('coursematerial_delete')) {
            return abort(401);
        }
        $coursematerial = Coursematerial::onlyTrashed()->findOrFail($id);
        $coursematerial->forceDelete();

        return redirect()->route('admin.coursematerials.index');
    }
}
