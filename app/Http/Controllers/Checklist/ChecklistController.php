<?php

namespace App\Http\Controllers\Checklist;

use App\Http\Controllers\Controller;
use App\Models\checklist;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checklist = checklist::query()->get();
        return response()->json([
            'status' => 'success',
            'data' => $checklist
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = validator($request->all(), [
            'name' => 'required|max:255',
        ]);

        if($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first()
            ], 400);
        }

        $checklist = checklist::create([
            'name' => $request->item_name
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $checklist
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $checklist = checklist::where('id', $id)->first();
        if($checklist) {
            $checklist->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Checklist deleted successfully',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Checklist not found',
        ], 404);
    }
}
