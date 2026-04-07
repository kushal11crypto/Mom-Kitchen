<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
{
    $transactions = Transaction::paginate(20);
    return view('transactions.index', compact('transactions'));
}

public function show($id)
{
    $transaction = Transaction::findOrFail($id);
    return view('transactions.show', compact('transaction'));
}
}
