<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Branch;
use App\Model\Table;
use App\Model\Category;
use App\Models\Supplier;
use App\CentralLogics\Helpers;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;



class InventoryController extends Controller
{
    public function __construct(
        private Branch $branch,
        private Table $table,
        private Supplier $supplier,
    ) {}


    /**
     * @param Request $request
     * @return Renderable
     */
    public function list(Request $request): Renderable
    {

$category=Category::orderBy('id', 'DESC')
        ->where('supplier',1)
    ->get();
    $supplier=Supplier::with('categorydata')->orderBy('id', 'DESC')
    ->paginate(Helpers::getPagination());

 
       $search = $request['search'];
        $key = explode(' ', $request['search']);

        
           

        return view('admin-views.supplier.list', compact('search', 'supplier','category'));
    }
    public function catogry(Request $request): Renderable
    {
       
      $category=Category::orderBy('id', 'DESC')
                ->where('supplier',1)
            ->paginate(Helpers::getPagination());

        

        return view('admin-views.supplier.category', compact('category'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'phonenumber'  => [
                'required',
                Rule::unique('suppliers')->where(function ($query) use ($request) {
                    return $query->where(['phonenumbner' => $request->phonenumbner]);
                }),
            ],
            'phonenumber' => 'required|min:10|max:10',
            'whatappsnumber' => 'required|min:10|max:10',
        ], [
            
            'phonenumber.unique' => translate('Phone number is already exists!'),
        
        ]);
        $suppllier= new Supplier();
        $suppllier->name = $request->name;
        $suppllier->gmail = $request->gmail;
        $suppllier->phonenumber = $request->phonenumber;
        $suppllier->whatappsnumber = $request->whatappsnumber;
        $suppllier->address = $request->address ?? '';
        $suppllier->category_id = $request->category_id;
        $suppllier->save();
         Toastr::success(translate('Supplier added successfully!'));
        return redirect()->route('admin.inventory.list');
    }

    public function  categorystore(Request $request){

       $category= new Category();
        $category->name = $request->name;
        $category->status = 1;
        $category->supplier =1;
        $category->parent_id = 0;
        $category->position = 0;
        $category->save();
        Toastr::success(translate('Category added successfully!'));
        return redirect()->route('admin.inventory.categorylist');

    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function status(Request $request): RedirectResponse
    {
        $table = $this->table->find($request->id);
        $table->is_active = $request->status;
        $table->save();

        Toastr::success(translate('Table status updated!'));
        return back();
    }

    /**
     * @param $id
     * @return Renderable
     */
    public function edit($id): Renderable
    {
        $branches = $this->branch->orderBy('id', 'DESC')->get();
        $table = $this->table->where(['id' => $id])->first();

        return view('admin-views.table.edit', compact('table', 'branches'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'number'  => [
                'required',
                Rule::unique('tables')->where(function ($query) use ($request, $id) {
                    return $query->where(['number' => $request->number, 'branch_id' => $request->branch_id])
                        ->whereNotIn('id', [$id]);
                }),
            ],
            'branch_id' => 'required',
            'capacity' => 'required|min:1|max:99',
        ], [
            'number.required' => translate('Table number is required!'),
            'number.unique' => translate('Table number is already exist in this branch!'),
            'capacity.required' => translate('Table capacity is required!'),
            'branch_id.required' => translate('Branch select is required!'),
        ]);

        $table = $this->table->find($id);
        $table->number = $request->number;
        $table->capacity = $request->capacity;
        $table->branch_id = $request->branch_id;
        $table->update();

        Toastr::success(translate('Table updated successfully!'));
        return redirect()->route('admin.table.list');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        $table = $this->supplier->find($request->id);
        $table->delete();

        Toastr::success(translate('Supplier removed!'));
        return back();
    }

    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $branches = $this->branch->orderBy('id', 'DESC')->get();
        return view('admin-views.table.index2', compact('branches'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getTableListByBranch(Request $request): JsonResponse
    {
        $tables = $this->table
            ->with(['order'=> function ($q){
                $q->whereHas('table_order', function($q){
                    $q->where('branch_table_token_is_expired', 0);
                });
            }])
            ->where(['branch_id' => $request->branch_id, 'is_active' => '1'])
            ->get()
            ->toArray();

        $view = view('admin-views.table.table_available_card2', compact('tables'))->render();

        return response()->json([
            'view' => $view,
        ]);
    }

    

}
