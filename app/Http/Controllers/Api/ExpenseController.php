<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        return Expense::all();
    }

    public function store(Request $request)
    {
        Expense::create($request->all());
    }

    public function update(Request $request, string $id)
    {
        Expense::where('id', $id)->update($request->all(), [$id]);
    }

    public function destroy(string $id): void
    {
        Expense::destroy($id);
    }
}