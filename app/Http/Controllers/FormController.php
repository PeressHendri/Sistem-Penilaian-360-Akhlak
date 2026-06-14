<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user || !$user->hasPermissionTo('lihat formulir')) {
            abort(403, 'Anda tidak memiliki akses ke modul Formulir Penilaian.');
        }
        return view('forms.index', compact('user'));
    }
}
