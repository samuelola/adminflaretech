<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request){
        
        // if ($request->hasFile('upload')) {
        //     $file = $request->file('upload');
        // } elseif ($request->hasFile('upload')[0] ?? false) {
        //     $file = $request->file('upload')[0];
        // } else {
        //     return response()->json(['error' => 'No file uploaded'], 400);
        // }

        // $filename = time() . '_' . $file->getClientOriginalName();
        // $file->move(public_path('uploads'), $filename);

        // return response()->json([
        //     'url' => asset('uploads/' . $filename)
        // ]);

        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);

            $url = asset('uploads/' . $filename);

            return response()->json([
                'uploaded' => 1,
                'fileName' => $filename,
                'url' => $url
            ]);
        }

        return response()->json([
            'uploaded' => 0,
            'error' => ['message' => 'No file uploaded']
        ]);
            
        }


        
}
