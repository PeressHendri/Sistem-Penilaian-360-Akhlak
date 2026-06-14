<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class HCOrganizationController extends Controller
{
    public function index()
    {
        // Fetch root nodes (e.g. CEO / Director with no manager above them)
        $roots = Employee::whereNull('atasan_id')
            ->with('bawahan')
            ->get();

        return view('hc.org_chart', compact('roots'));
    }
}
