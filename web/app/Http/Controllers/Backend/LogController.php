<?php

namespace App\Http\Controllers\Backend;

use File;
use Session;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;
use App\Http\Controllers\Backend\BackendController;

class LogController extends BackendController
{
    public function index(Request $request)
    {
        if(!$this->authUser->hasSystemRole()) {
            abort(403);
        }

        if ($request->file) {
            LogRepository::setFile(base64_decode($request->file));
        }

        if ($request->download) {
            return response()->download(LogRepository::pathToLogFile(base64_decode($request->download)));
        } elseif ($request->has('delete')) {
            File::delete(LogRepository::pathToLogFile(base64_decode($request->delete)));
            Session::flash('success', trans('backend/messages.delete_success', ['entity' => 'log file']));
            $result = ['res' => 1, 'url' => $request->url()];
            return json_encode($result);
        }

        $logs = LogRepository::all();
        $max = LogRepository::MAX_FILE_SIZE >= (1024 * 1024) ? (round(LogRepository::MAX_FILE_SIZE / 1024 / 1024, 2)) . ' MB' : (round(LogRepository::MAX_FILE_SIZE / 1024, 2)) . ' KB';

        return view('backend.logs.index', [
            'logs' => $logs,
            'files' => LogRepository::getFiles(true),
            'current_file' => LogRepository::getFileName(),
            'max' => $max
        ]);
    }
}
