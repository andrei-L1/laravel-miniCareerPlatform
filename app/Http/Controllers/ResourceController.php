<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResourceController extends Controller
{
    public function index()
    {
        $resources = DB::table('resources')->get();
        return view('resources.index', compact('resources'));
    }

    public function create()
    {
        return view('resources.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        DB::table('resources')->insert([
            'title' => $request->title,
            'description' => $request->description,
            'created_at' => now(),
        ]);

        return redirect()->route('resources.index')->with('success', 'Resource created.');
    }

    public function edit($id)
    {
        $resource = DB::table('resources')->where('id', $id)->first();
        return view('resources.edit', compact('resource'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        DB::table('resources')->where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('resources.index')->with('success', 'Resource updated.');
    }

    public function destroy($id)
    {
        DB::table('resources')->where('id', $id)->delete();
        return redirect()->route('resources.index')->with('success', 'Resource deleted.');
    }
}
