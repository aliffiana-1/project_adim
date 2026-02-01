<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriesModel;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $query = CategoriesModel::orderBy('id_category', 'desc');

        if ($search) {
            $query->where('category_name', 'like', '%' . $search . '%');
        }

        return view('category_editor', [
            'title' => 'Category Center',   
            'category_data' => $query->paginate($request->sortir ?? 10),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255'
        ]);

        CategoriesModel::create([
            'category_name' => $request->category_name
        ]);

        session()->flash('success', 'Add category success!');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_category'   => 'required',
            'category_name' => 'required|string|max:255'
        ]);

        CategoriesModel::where('id_category', $request->id_category)
            ->update([
                'category_name' => $request->category_name
            ]);

        session()->flash('success', 'Update category success!');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        CategoriesModel::where('id_category', $request->id_category)->delete();

        session()->flash('success', 'Delete category success!');
        return redirect()->back();
    }
}
