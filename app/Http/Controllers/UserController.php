<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use App\Jobs\ImportFile;

class UserController extends Controller
{

    public function fileImportExport()
    {
       return view('file-import');
    }


    public function fileImport(Request $request)
    {
        $fileType= $request->file->getClientOriginalExtension();

        $fileName = time().'.'.$fileType;

        $request->file->move(public_path('uploads'), $fileName);

        $fileData = public_path('uploads/').$fileName;
        dispatch(new ImportFile(
            ($fileData)
        ))->onQueue('default');
        return back()->with('message','File Uploaded Successfully');
    }

    public function fileExport()
    {
        return Excel::download(new UsersExport, 'users-collection.csv');
    }
}
