<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function save(Request $request)
    {
        //return $request->all();
        //return $request->all();
        //$file = $request->file;

        //$file->move(public_path('uploads/android_version'),$request->name);

        //return response()->json(['success' => 1, 'data' => 333]);

        //if ($request->)

        // 文件临时目录
        $tmp_file_path = storage_path('app/tmp/' . md5($request->name));
        //  临时文件名
        $tmp_name = '1000000' . $request->chunk . '.tmp';

        $file = $request->file;
        $file->move($tmp_file_path, $tmp_name);
        /*Storage::putFileAs(
            $tmp_file_path, $request->file, $tmp_name
        );*/

        $files = Storage::disk('local')->files('tmp/' . md5($request->name));
        //return count($files)."====".$request->chunks;
        if (count($files) == $request->chunks) {
            sort($files);

            // 目录不存在则创建目录
            if (!is_dir(public_path() . '/uploads/android_version')) {
                mkdir(public_path() . '/uploads/android_version', 0777,true);
            }
            // 完整文件存储地址
//            $fp = public_path() . '/uploads/android_version/' . $request->name;

            $fp = fopen(public_path() . '/uploads/android_version/' . $request->name, "ab");
            foreach ($files as $file) {
                //return $file;
                $tempFile = storage_path('app/' . $file);
                $size = filesize($tempFile);
                $handle = fopen($tempFile, "rb");
                fwrite($fp,fread($handle, $size));
                fclose($handle);
                //$size = 5242880;
                /*$str = file_get_contents($tempFile);
                file_put_contents($fp,$str,FILE_APPEND);*/
                //return $tempFile;

                //unset($handle);
            }
            fclose($fp);
            Storage::deleteDirectory($files);
            return response()->json(['status' => 1, 'data' => '上传完成', 'address' => config('app.url').'/uploads/android_version/' . $request->name]);
        }
        //return $request->name;
        //$file_path = public_path().'/uploads/android_version/'.date("Ym/d",time());

        //$file = $request->file;
        //$file->move($file_path,$request->name);
        return response()->json(['status' => 2, 'data' => '上传中']);
    }
}