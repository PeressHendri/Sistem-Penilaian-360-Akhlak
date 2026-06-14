<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log($activity, $module = null)
    {
        DB::table('activity_logs')->insert([
            'user_id' => Auth::id(),
            'activity' => $activity,
            'module' => $module,
            'ip_address' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
