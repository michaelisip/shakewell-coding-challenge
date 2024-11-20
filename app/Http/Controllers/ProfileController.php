<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Get user details
     *
     * @group Profile
     */
    public function __invoke(Request $request)
    {
        return $request->user();
    }
}
