<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\CentralLogics\Helpers;
use Illuminate\Http\Request;
use App\Model\Branch;
use App\Model\ChefBranch;
use App\Models\Waiter;
use App\User;


class WaiterController extends Controller
{
    public function __construct(
        private Waiter       $waiter,
        private Branch     $branch,
        private User       $user,
        private ChefBranch $chef_branch

    ) {
    }
    /**
     * @return Renderable
     */
    public function add_new(): Renderable
    {
        $branches = $this->branch->orderBy('id', 'DESC')->get();
        return view('admin-views.waiter.add-new', compact('branches'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'f_name' => 'required',
            'l_name' => 'required',
            
            'password' => 'required|min:6',
            'image' => 'required',
            'branch_id' => 'required',
            'confirm_password' => 'same:password'
        ], [
            'f_name.required' => translate('First name is required!'),
            'l_name.required' => translate('Last name is required!'),
            'phone.required' => translate('Phone is required'),
            'phone.unique' => translate('This phone is already taken! please try another one'),
            'email.required' => translate('Email is Required'),
            'email.email' => translate('Field type must be email'),
            'email.unique' => translate('This email is already taken! please try another one'),
            'password.required' => translate('Password is Required'),
            'password.min' => translate('Password length must be 6 character'),
            'image.required' => translate('Image is Required'),
            'branch_id.required' => translate('Branch select is required'),
        ]);

        DB::beginTransaction();
        try {

            $waiter=User::where('user_type','waiter')->where('phone',$request->phone)->first();
            if(!empty($waiter)){
                Toastr::success(translate('Waiter Allready exites!'));

            }else{
            $chef = $this->user;
            $chef->f_name = $request->f_name;
            $chef->l_name = $request->l_name;
            $chef->phone = $request->phone;
            $chef->email = $request->email;
            $chef->user_type = 'waiter';
            $chef->is_active = 1;
            $chef->password = bcrypt($request->password);
            $chef->image = Helpers::upload('kitchen/', 'png', $request->file('image'));
            $chef->save();

            $chef_id = $chef->id;

            $data = [
                'user_id' => $chef_id,
                'branch_id' => $request->branch_id,
            ];
            $this->chef_branch->insert($data);

            DB::commit();
        }
        } catch (\Exception $e) {
            DB::rollback();
        }

        Toastr::success(translate('Waiter added successfully!'));
        return redirect()->route('admin.waiter.list');
    }

    function list(Request $request): Renderable
    {
        $search = $request['search'];
        $key = explode(' ', $request['search']);
        $chefs = $this->user->where('user_type', 'waiter')
            ->when($search != null, function ($query) use ($key) {
                $query->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->where('f_name', 'like', "%{$value}%")
                            ->orWhere('l_name', 'like', "%{$value}%")
                            ->orWhere('phone', 'like', "%{$value}%")
                            ->orWhere('email', 'like', "%{$value}%");
                    }
                });
            })
            ->orderBy('id', 'DESC')
            ->paginate(Helpers::getPagination());

        return view('admin-views.waiter.list', compact('chefs', 'search'));
    }

    public function status(Request $request): RedirectResponse
    {
        $kitchen = $this->user->find($request->id);
        $kitchen->is_active = $request->status;
        $kitchen->save();

        Toastr::success(translate('Waiter status updated!'));
        return back();
    }

    public function edit(Request $request): Renderable
    {
        $branches = $this->branch->orderBy('id', 'DESC')->get();
        $chef = $this->user->find($request->id);
        $chef_branch = $this->chef_branch->where('user_id', $chef->id)->first();

        return view('admin-views.waiter.edit', compact('chef', 'branches', 'chef_branch'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'f_name' => 'required',
            'l_name' => 'required',
            'phone' => 'required|unique:users,phone,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'branch_id' => 'required',
        ], [
            'f_name.required' => translate('First name is required!'),
            'l_name.required' => translate('Last name is required!'),
            'phone.required' => translate('Phone is Required'),
            'phone.unique' => translate('This email is already taken! please try another one'),
            'email.required' => translate('Email is Required'),
            'email.email' => translate('Field type must be email'),
            'email.unique' => translate('This email is already taken! please try another one'),
            'branch_id.required' => translate('Branch select is required'),
        ]);

        $chef = $this->user->find($request->id);

        if ($request['password'] == null) {
            $password = $chef['password'];
        } else {
            $request->validate([
                'confirm_password' => 'same:password'
            ]);
            if (strlen($request['password']) < 5) {
                Toastr::warning(translate('Password length must be 6 character.'));
                return back();
            }
            $password = bcrypt($request['password']);
        }

        DB::beginTransaction();
        try {


            $chef->f_name = $request->f_name;
            $chef->l_name = $request->l_name;
            $chef->phone = $request->phone;
            $chef->email = $request->email;
            $chef->password = $password;
            $chef->image = $request->has('image') ? Helpers::update('kitchen/', $chef->image, 'png', $request->file('image')) : $chef->image;
            $chef->update();

            $chef_branch = ChefBranch::where(['user_id' => $chef->id])->first();
            $chef_branch->branch_id = $request->branch_id;
            $chef_branch->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        Toastr::success(translate('Waiter updated successfully!'));
        return back();
    }

    public function delete(Request $request): RedirectResponse
    {
        $chef = $this->user->find($request->id);
        Helpers::delete('kitchen/' . $chef['image']);
        $chef->delete();
        $this->chef_branch->where('user_id', $chef->id)->delete();

        Toastr::success(translate('Waiter removed!'));
        return back();
    }
}