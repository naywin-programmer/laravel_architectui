<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Helper\ResponseHelper;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategory;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $categories = Category::anyTrash($request->trash)->get();
            return DataTables::of($categories)
                        ->addColumn('name_my', function($category) {
                            $name_str = json_decode($category->name);
                            return $name_str->my;
                        })
                        ->addColumn('name_en', function ($category) {
                            $name_str = json_decode($category->name);
                            return $name_str->en;
                        })
                        ->editColumn('parent_id', function($category) {
                            if($category->parent_id) {
                                $encoded = json_decode($category->parent->name);
                                return $encoded->my . ' (' . $encoded->en . ')';
                            }
                            return '-';
                        })
                        ->addColumn('plus-icon', function() {
                            return null;
                        })
                        ->addColumn('action', function ($category) use ($request) {
                            $detail_btn = '';
                            $restore_btn = '';
                            $edit_btn = '<a class="edit text text-primary mr-2" href="' . route('admin.categories.edit', ['category' => $category->id]) . '"><i class="far fa-edit fa-lg"></i></a>';

                            if ($request->trash == 1) {
                                $restore_btn = '<a class="restore text text-warning mr-2" href="#" data-id="' . $category->id . '"><i class="fa fa-trash-restore fa-lg"></i></a>';
                                $trash_or_delete_btn = '<a class="destroy text text-danger mr-2" href="#" data-id="' . $category->id . '"><i class="fa fa-minus-circle fa-lg"></i></a>';
                            } else {
                                $trash_or_delete_btn = '<a class="trash text text-danger mr-2" href="#" data-id="' . $category->id . '"><i class="fas fa-trash fa-lg"></i></a>';
                            }

                            return "${detail_btn} ${edit_btn} ${restore_btn} ${trash_or_delete_btn}";
                        })
                        ->rawColumns(['plus-icon', 'name_my', 'name_en', 'action'])
                        ->make(true);
        }
        return view('backend.admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active_categories = Category::noTrash();
        $main_categories = $active_categories->main()->get();
        $suggest_rank = $active_categories->max('rank') + 1;
        return view('backend.admin.categories.create', compact('main_categories', 'suggest_rank'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategory $request)
    {
        $name_str = json_encode(['my' => $request->name_my, 'en' => $request->name_en]);
        $slug = Str::slug($request->slug ?? $request->name_en);
        $parent_id = $request->parent_id;
        $found = false;
        
        $check_slug = Category::where('slug', $slug)->first();
        if($check_slug) {
            return back()->withErrors(['msg' => 'Link is already exist.'])->withInput();
        }

        if(! empty($parent_id)) {
            $found = Category::find($parent_id);
        }

        Category::create([
            'name' => $name_str,
            'slug' => $slug,
            'rank' => abs($request->rank) ?? (Category::maxRank() + 1),
            'parent_id' => ($found) ? $parent_id : 0
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'New Category Successfully Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('backend.admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $main_categories = Category::noTrash()->main()->get();
        return view('backend.admin.categories.edit', compact('category', 'main_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategory $request, Category $category)
    {
        $name_str = json_encode(['my' => $request->name_my, 'en' => $request->name_en]);
        $slug = Str::slug($request->slug ?? $request->name_en);
        $parent_id = $request->parent_id;
        $found = false;

        $check_slug = Category::whereNotIn('id', [$category->id])->where('slug', $slug)->first();
        if ($check_slug) {
            return back()->withErrors(['msg' => 'Link is already exist.'])->withInput();
        }

        if (!empty($parent_id)) {
            $found = Category::find($parent_id);
        }

        $category->update([
            'name' => $name_str,
            'slug' => $slug,
            'rank' => abs($request->rank) ?? (Category::maxRank() + 1),
            'parent_id' => ($found) ? $parent_id : 0
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Successfully Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return ResponseHelper::success();
    }

    public function trash(Category $category)
    {
        $category->trash();
        return ResponseHelper::success();
    }

    public function restore(Category $category)
    {
        $category->restore();
        return ResponseHelper::success();
    }
}
