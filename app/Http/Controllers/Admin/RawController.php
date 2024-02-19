<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Model\Category;
use App\Models\Raw;
use App\Models\Supplier;


class RawController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $orderQuery = Raw::query();
        // dd($orderQuery);
        if ($search) {
            $orderQuery->where(function ($q) use ($search) {
                foreach (explode(' ', $search) as $value) {
                    $q->where('id', 'like', "%{$value}%")
                        ->orWhere('name', 'like', "%{$value}%")
                        ->orWhere('description', 'like', "%{$value}%")
                        ->orWhere('price', 'like', "%{$value}%")
                        ->orWhere('quantity', 'like', "%{$value}%")
                        ->orWhere('created_at', 'like', "%{$value}%");
                }
            });
        }

        $raws = $orderQuery->with('category')->orderBy('id', 'DESC')->get();

        return view('admin-views.raws.index', compact('raws', 'search'));
    }

    public function add_new()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin-views.raws.add', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            // 'category_id' => 'required|exists:categories,id',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'required|array',
            'supplier_id.*' => 'exists:suppliers,id',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        $raw = Raw::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
            'price' => $validatedData['price'],
            'quantity' => $validatedData['quantity'],
        ]);
        $raw->suppliers()->attach($validatedData['supplier_id']);

        Toastr::success(translate('Raw material added successfully!'));

        return redirect()->route('admin.raw.index');
        // return redirect()->route('admin.raw.index')->with('success', 'Raw material added successfully!');
    }

    public function edit(Request $request, $id)
    {
        $decryptedId = decrypt($id);
        $raw = Raw::find($decryptedId);
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin-views.raws.edit', compact('raw', 'categories', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'required|array',
            'supplier_id.*' => 'exists:suppliers,id',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);
        $raw = Raw::findOrFail($id);

        $raw->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
            'price' => $validatedData['price'],
            'quantity' => $validatedData['quantity'],
        ]);
        $raw->suppliers()->sync($validatedData['supplier_id']);

        // return redirect()->route('admin.raw.index')->with('success', 'Raw material updated successfully!'); // Toastr notification
        Toastr::success(translate('Raw material update successfully!'));

        return redirect()->route('admin.raw.index');
    }

    public function delete(Request $request, $id)
    {
        $raw = Raw::findOrFail($id);
        $raw->delete();
        Toastr::success(translate('Raw material delete successfully!'));
        return redirect()->route('admin.raw.index');
    }
}
