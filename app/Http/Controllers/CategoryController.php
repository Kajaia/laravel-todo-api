<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lists = Category::with('tasks')
            ->when($request->search, function($query) use ($request) {
                $query->where('title', 'LIKE', "%$request->search%");
            })
            ->orderBy($request->sortBy ?? 'id', $request->sortDirection ?? 'desc')
            ->paginate($request->paginate ?? 10);

        return CategoryResource::collection($lists);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $list = Category::create([
            'title' => $request->title,
            'color' => $request->color
        ]);

        return new CategoryResource($list);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $list = Category::with('tasks')
            ->findOrFail($id);

        return new CategoryResource($list);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $list = Category::findOrFail($id);

        $list->update([
            'title' => $request->title,
            'color' => $request->color
        ]);

        return new CategoryResource($list);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $list = Category::findOrFail($id);

        $list->delete();

        return new CategoryResource($list);
    }
}
