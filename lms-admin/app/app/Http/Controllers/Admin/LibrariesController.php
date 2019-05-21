<?php

namespace App\Http\Controllers\Admin;

use App\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLibrariesRequest;
use App\Http\Requests\Admin\UpdateLibrariesRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class LibrariesController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Library.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('library_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('library_delete')) {
                return abort(401);
            }
            $libraries = Library::onlyTrashed()->get();
        } else {
            $libraries = Library::all();
        }

        return view('admin.libraries.index', compact('libraries'));
    }

    /**
     * Show the form for creating new Library.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('library_create')) {
            return abort(401);
        }
        
        $coursenames = \App\Course::get()->pluck('coursename', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.libraries.create', compact('coursenames'));
    }

    /**
     * Store a newly created Library in storage.
     *
     * @param  \App\Http\Requests\StoreLibrariesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLibrariesRequest $request)
    {
        if (! Gate::allows('library_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $library = Library::create($request->all());


        foreach ($request->input('references_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $library->id;
            $file->save();
        }
        foreach ($request->input('pastpapers_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $library->id;
            $file->save();
        }
        foreach ($request->input('other_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $library->id;
            $file->save();
        }

        return redirect()->route('admin.libraries.index');
    }


    /**
     * Show the form for editing Library.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('library_edit')) {
            return abort(401);
        }
        
        $coursenames = \App\Course::get()->pluck('coursename', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $library = Library::findOrFail($id);

        return view('admin.libraries.edit', compact('library', 'coursenames'));
    }

    /**
     * Update Library in storage.
     *
     * @param  \App\Http\Requests\UpdateLibrariesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLibrariesRequest $request, $id)
    {
        if (! Gate::allows('library_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $library = Library::findOrFail($id);
        $library->update($request->all());


        $media = [];
        foreach ($request->input('references_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $library->id;
            $file->save();
            $media[] = $file->toArray();
        }
        $library->updateMedia($media, 'references');
        $media = [];
        foreach ($request->input('pastpapers_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $library->id;
            $file->save();
            $media[] = $file->toArray();
        }
        $library->updateMedia($media, 'pastpapers');
        $media = [];
        foreach ($request->input('other_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $library->id;
            $file->save();
            $media[] = $file->toArray();
        }
        $library->updateMedia($media, 'other');

        return redirect()->route('admin.libraries.index');
    }


    /**
     * Display Library.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('library_view')) {
            return abort(401);
        }
        $library = Library::findOrFail($id);

        return view('admin.libraries.show', compact('library'));
    }


    /**
     * Remove Library from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('library_delete')) {
            return abort(401);
        }
        $library = Library::findOrFail($id);
        $library->deletePreservingMedia();

        return redirect()->route('admin.libraries.index');
    }

    /**
     * Delete all selected Library at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('library_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Library::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->deletePreservingMedia();
            }
        }
    }


    /**
     * Restore Library from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('library_delete')) {
            return abort(401);
        }
        $library = Library::onlyTrashed()->findOrFail($id);
        $library->restore();

        return redirect()->route('admin.libraries.index');
    }

    /**
     * Permanently delete Library from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('library_delete')) {
            return abort(401);
        }
        $library = Library::onlyTrashed()->findOrFail($id);
        $library->forceDelete();

        return redirect()->route('admin.libraries.index');
    }
}
