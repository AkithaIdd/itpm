<?php

namespace App\Http\Controllers\Admin;

use App\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNoticesRequest;
use App\Http\Requests\Admin\UpdateNoticesRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class NoticesController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Notice.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('notice_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('notice_delete')) {
                return abort(401);
            }
            $notices = Notice::onlyTrashed()->get();
        } else {
            $notices = Notice::all();
        }

        return view('admin.notices.index', compact('notices'));
    }

    /**
     * Show the form for creating new Notice.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('notice_create')) {
            return abort(401);
        }
        return view('admin.notices.create');
    }

    /**
     * Store a newly created Notice in storage.
     *
     * @param  \App\Http\Requests\StoreNoticesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNoticesRequest $request)
    {
        if (! Gate::allows('notice_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $notice = Notice::create($request->all());


        foreach ($request->input('file_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $notice->id;
            $file->save();
        }
        foreach ($request->input('image_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $notice->id;
            $file->save();
        }

        return redirect()->route('admin.notices.index');
    }


    /**
     * Show the form for editing Notice.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('notice_edit')) {
            return abort(401);
        }
        $notice = Notice::findOrFail($id);

        return view('admin.notices.edit', compact('notice'));
    }

    /**
     * Update Notice in storage.
     *
     * @param  \App\Http\Requests\UpdateNoticesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNoticesRequest $request, $id)
    {
        if (! Gate::allows('notice_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $notice = Notice::findOrFail($id);
        $notice->update($request->all());


        $media = [];
        foreach ($request->input('file_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $notice->id;
            $file->save();
            $media[] = $file->toArray();
        }
        $notice->updateMedia($media, 'file');
        $media = [];
        foreach ($request->input('image_id', []) as $index => $id) {
            $model          = config('laravel-medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $notice->id;
            $file->save();
            $media[] = $file->toArray();
        }
        $notice->updateMedia($media, 'image');

        return redirect()->route('admin.notices.index');
    }


    /**
     * Display Notice.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('notice_view')) {
            return abort(401);
        }
        $notice = Notice::findOrFail($id);

        return view('admin.notices.show', compact('notice'));
    }


    /**
     * Remove Notice from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('notice_delete')) {
            return abort(401);
        }
        $notice = Notice::findOrFail($id);
        $notice->deletePreservingMedia();

        return redirect()->route('admin.notices.index');
    }

    /**
     * Delete all selected Notice at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('notice_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Notice::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->deletePreservingMedia();
            }
        }
    }


    /**
     * Restore Notice from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('notice_delete')) {
            return abort(401);
        }
        $notice = Notice::onlyTrashed()->findOrFail($id);
        $notice->restore();

        return redirect()->route('admin.notices.index');
    }

    /**
     * Permanently delete Notice from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('notice_delete')) {
            return abort(401);
        }
        $notice = Notice::onlyTrashed()->findOrFail($id);
        $notice->forceDelete();

        return redirect()->route('admin.notices.index');
    }
}
