<?php

namespace App\Http\Api\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * @param Request $request
     *
     * @return string
     */
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|image'
        ]);

        $file = $request->file('file')->store('comments');

        return [
            'name' => pathinfo($file, PATHINFO_FILENAME),
            'file_url' => asset(
                'app/'.$file
            )
        ];
    }
}