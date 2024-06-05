<?php

namespace App\Http\Controllers\Checklist;

use App\Http\Controllers\Controller;
use App\Models\checklist;
use App\Models\checklistItem;
use Illuminate\Http\Request;

class ChecklistItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $checklistId)
    {
        $checklist = checklist::where('id', $checklistId)
                                ->with('checklistItems')
                                ->first();

        return response()->json([
            'status' => 'success',
            'data' => $checklist
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $checklistId)
    {
        $validate = validator($request->all(), [
            'itemName' => 'required|max:255',
        ]);

        if($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first()
            ], 400);
        }

        $checklistItem = checklistItem::create([
            'checklist_id' => $checklistId,
            'item_name' => $request->itemName,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $checklistItem
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $checklistId, string $checklistItemId)
    {
        $checklistItem = checklistItem::where('id', $checklistItemId)
                                    ->where('checklist_id', $checklistId)
                                    ->first();

        if (!$checklistItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Checklist item not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $checklistItem
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $checklistId, string $checklistItemId)
    {
        $checklistItem = checklistItem::where('id', $checklistItemId)
                                        ->where('checklist_id', $checklistId)
                                        ->first();
        if(!$checklistItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Checklist item not found'
            ], 404);
        }

        $checklistItem = $checklistItem->update([
            'completed' => true
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Checklist item updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $checklistId, string $checklistItemId)
    {
        $checklistItem = checklistItem::where('id', $checklistItemId)
                                        ->where('checklist_id', $checklistId)
                                        ->first();
        if(!$checklistItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Checklist item not found'
            ], 404);
        }

        $checklistItem->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Checklist item deleted successfully',
        ]);
    }

    public function rename(Request $request, string $checklistId, string $checklistItemId)
    {
        $validate = validator($request->all(), [
            'itemName' => 'required|max:255',
        ]);

        if($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first()
            ], 400);
        }

        $checklistItem = checklistItem::where('id', $checklistItemId)
                                        ->where('checklist_id', $checklistId)
                                        ->first();
        if(!$checklistItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Checklist item not found'
            ], 404);
        }

        $checklistItem->item_name = $request->itemName;
        $checklistItem->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Checklist item updated successfully',
            'data' => $checklistItem
        ]);
    }
}
