<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Контроллер загрузки изображений
 */
class UploadController extends Controller
{
    /**
     * Метод загрузки изображений
     * @param  Request $request
     * @return string           returns json object
     */
    public function uploadImage(Request $request)
    {
        $user = Auth::user();
        $path = $request->file('file')->store($user->id . '/' . date('dmY'), 'images');

        return response()->json('/images/' . $path);
    }

    /**
     * Метод по удалению изображений с проверкой владельца по user->id
     * @param  Request $request
     * @return string
     */
    public function deleteImage(Request $request)
    {
        // сверить до слэша user id и если они совпадают то можно удалять.
        // /images/{user_id}/{date}/{file_name}
        $request->validate([
            'src'    => 'required|string',
        ]);
        $fileName = $request->src;
        list(,,$userId) = explode('/',$fileName);
        /* @var $user \App\Models\User */
        $user = Auth::user();
        if ((int)$userId === $user->id || $user->hasPermissionTo('manage images')) {
            Storage::delete($fileName);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'У вас нет прав на удаление данного файла'], 422);
        }
    }
}
