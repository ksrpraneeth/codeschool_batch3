<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    function getModule(Module $module)
    {
        $module->load('menuItems');
        return response()->json([
            "status" => true,
            "message" => "Success",
            "data" => $module
        ]);
    }
}
