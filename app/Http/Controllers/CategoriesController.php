<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->get();

        return ApiResponse::success(200, 'Categories list', $categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(422, $validator->errors()->first());
        }

        $category = Category::create([
            'name' => $request->name
        ]);

        return ApiResponse::success(200, 'Category created successfully', $category);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return ApiResponse::error(404, 'Category not found');
        }

        return ApiResponse::success(200, 'Category details', $category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return ApiResponse::error(404, 'Category not found');
        }

        return ApiResponse::success(200, 'Category details', $category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(422, $validator->errors()->first());
        }

        $category = Category::find($id);

        if (!$category) {
            return ApiResponse::error(404, 'Category not found');
        }

        $category->name = $request->name;
        $category->save();

        return ApiResponse::success(200, 'Category updated successfully', $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return ApiResponse::error(404, 'Category not found');
        }

        $category->delete();

        return ApiResponse::success(200, 'Category deleted successfully');
    }
}
