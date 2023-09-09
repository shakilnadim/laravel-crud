<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestRequest;
use App\Models\Test;

class TestController extends Controller
{
    public function index()
    {
        return view('test.index', ['tests' => Test::orderBy('id', 'desc')->get()]);
    }

    public function create()
    {
        return view('test.create');
    }

    public function store(TestRequest $request)
    {
        Test::create($request->validated());
        return redirect(route('test'))->with('success', 'Test created successfully');
    }

    public function edit(Test $test)
    {
        return view('test.edit', ['test' => $test]);
    }

    public function update(TestRequest $request, Test $test)
    {
        $test->update($request->validated());
        return redirect(route('test'))->with('success', 'Test updated successfully');
    }

    public function delete(int $id)
    {
        Test::where('id', $id)->delete();
        return redirect(route('test'))->with('success', 'Test deleted successfully');
    }
}
