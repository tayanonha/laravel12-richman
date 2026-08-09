<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function sport()
    {
        return "<h1>This is sport Category Page</h1>";
    }

    public function politic()
    {
        return "<h1>This is politic Category Page</h1>";
    }

    public function entertain()
    {
        return "<h1>This is entertain Category Page</h1>";
    }

    public function auto()
    {
        return "<h1>This is auto Category Page</h1>";
    }
}