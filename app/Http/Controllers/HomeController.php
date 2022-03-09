<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceRequest;
use App\Models\AttendanceRequestStatus;
use App\Models\AttendanceStatus;
use App\Models\Doctor;
use App\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function arquivoTemporario()
    {
        $retorno = ['success' => false];
        $filename = unique_fileupload_name(request()->file('uploadPDF'));
        $savefile = file_storage_upload('public/temp/', request()->file('uploadPDF'), $filename);
        if ($savefile) {
            $retorno['success'] = true;
            $retorno['arquivo'] = file_storage_url('public/temp/' . $filename);
        }

        return response()->json($retorno);
    }
}
