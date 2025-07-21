<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class ItemController extends Controller
{
    public function index()
    {
        return response()->json(Item::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $item = Item::create($data);
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = Item::find($id);
        if (!$item)
            return response()->json(['error' => 'Item not found'], 404);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('edit-item')) {
        return response()->json(['message' => 'Not authorized.'], 403);
    }

        $item = Item::find($id);
        if (!$item) return response()->json(['error' => 'Item not found'], 404);

        $item->update($request->only(['title', 'description']));
        return response()->json($item);
    }

    public function destroy($id)
    {
        $this->authorize('delete', $id);
        $item = Item::find($id);
        if (!$item) return response()->json(['error' => 'Item not found'], 404);

        $item->delete();
        return response()->json(['message' => 'Item deleted']);
    }
}
