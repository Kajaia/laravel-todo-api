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
    public function index()
    {
        $search = request('search') ?? null;
        $sortBy = request('sortBy') ?? 'id';
        $sortDirection = request('sortDirection') ?? 'desc';

        $lists = Category::with('tasks')
            ->where('title', 'LIKE', "%$search%")
            ->orderBy($sortBy, $sortDirection)
            ->get();

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
            ->findorfail($id);

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
        $list = Category::findorfail($id);

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
        $list = Category::findorfail($id);

        $list->delete();

        return new CategoryResource($list);
    }
}
