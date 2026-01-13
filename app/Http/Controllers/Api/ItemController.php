<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return Item::with(['category','user'])->get();
    }

    public function store(Request $request)
    {
        return Item::create($request->all());
    }
}
