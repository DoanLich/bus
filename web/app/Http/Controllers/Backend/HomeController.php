<?php

namespace App\Http\Controllers\Backend;

use DB;
use File;
use Storage;
use Session;
use Exception;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Exceptions\ModelSaveFailedException;
use App\Http\Requests\Backend\ProfileRequest;
use App\Http\Controllers\Backend\BackendController;

class HomeController extends BackendController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.homes.index');
    }

    public function getProfile()
    {
        $user = $this->authUser;
        $this->authorizeForAdmin('profile', $user);

        return view('backend.homes.profile', compact('user'));
    }
    public function postProfile(ProfileRequest $request)
    {
        $user = $this->authUser;
        $this->authorizeForAdmin('profile', $user);

        DB::beginTransaction();

        try {
            $updated = $user->update($request->all());
            if(!$updated) {
                throw new ModelSaveFailedException();
            }

            $file = $request->file('avatar');
            if($file != null) {
                $this->uploadAvatar($user, $file);
            }

            DB::commit();
            Session::flash('success', trans('backend/messages.save_success', ['entity' => 'profile']));
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error', trans('backend/messages.save_failed', ['entity' => 'profile']));
            return redirect()->back()->withInput();
        }

        return redirect()->back();
    }

    public function uploadAvatar(Admin $user, $file)
    {
        try {
            $oldAvatar = $user->getAvatarPath();
            $extension = $file->getClientOriginalExtension();
            $fileName = str_random(32).$user->id.'.'.$extension;
            $put = Storage::disk('avatar')->put($fileName,  File::get($file));

            if($put <= 0) {
                throw new ModelSaveFailedException();
            }

            $user->avatar = $fileName;
            $saved = $user->save();

            if(!$saved) {
                throw new ModelSaveFailedException();
            }

            if(is_file($oldAvatar)) {
                if(!unlink($oldAvatar)) {
                    $newAvatar = $user->getAvatarPath();
                    if(is_file($newAvatar)) {
                        unlink($newAvatar);
                    }
                    throw new ModelSaveFailedException();
                }
            }

            return $saved;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1);
        }
    }
}
