<?php
namespace App\Http\Controllers;

use App\Models\Corte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CortesController extends Controller

{
    public function chunkStore(Request $request)
    {

        $_REQUEST["name"];
        $input = $request->all();
        // THE UPLOAD DESITINATION - CHANGE THIS TO YOUR OWN

        $filePath = storage_path('app/public/upload/testChunk');

        if (!file_exists($filePath)) {

            if (!mkdir($filePath, 0777, true)) {
                return response()->json(["ok"=>0, "info"=>"Failed to create $filePath"]);
            }
        }

        $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES["file"]["name"];
        $filePath = $filePath . DIRECTORY_SEPARATOR . $fileName;

        // DEAL WITH CHUNKS

        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        $out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");

        if ($out) {
            $in = fopen($_FILES['file']['tmp_name'], "rb");
            if ($in) {
                while ($buff = fread($in, 4096)) { fwrite($out, $buff); }
            } else {
                return response()->json(["ok"=>0, "info"=>'Failed to open input stream']);
            }

            fclose($in);
            fclose($out);
            unlink($_FILES['file']['tmp_name']);
        }
        // CHECK IF FILE HAS BEEN UPLOADED
        if (!$chunks || $chunk == $chunks - 1) {
            rename("{$filePath}.part", $filePath);
            $array = ['file' => $fileName];

            Corte::create([
                'path' => $fileName,
                'user_id' => auth()->user()->id,
                'title' => 'tst',
            ]);
        }
        $info = "Upload OK";
        $ok =1;
        return response()->json(["ok"=>$ok, "info"=>$info])->header('Content-Type', "video/mp4");
        // return back();
    }
}
