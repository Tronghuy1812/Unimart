<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{

    public function __construct()
    {
        $this->middleware(function($request , $next){
            session(['module_active'=>'user']);
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $list_act= [
            'delete' =>'Xóa tạm thời',
        ];

        $status= $request->input('status');

        if($status=='trash')
        {
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa Vĩnh Viễn'
            ];
            $users= User::onlyTrashed()->paginate(5);
        }
        else
        {
            $keyword="";
            if($request->input('keyword'))
            {
                $keyword=$request->input('keyword');
            }
            $users= User::where('name','LIKE',"%{$keyword}%")->paginate(5);
        }

        $count_user_active=User::count();
        $count_user_trash =User::onlyTrashed()->count();

        $count=[$count_user_active,$count_user_trash];

        return view('admin.user.list',compact('users','count','list_act'));
    }

    public function add()
    {

        return view('admin.user.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'required'=>':attribute không được để trống',
                'min'      => ':attribute có độ dài ít nhất :min ký tự',
                'max'      => ':attribute có độ dài ít nhất :max ký tự',
            ],
            [
                'name' =>'Tên người dùng',
                'email' =>'Email',
                'password' => 'Mật khẩu',
            ]
        );
        if(request()->input('btn_add'))
        {

             User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            return redirect('admin/user/list')->with('status','Thêm thành viên thành công ');
        }


    }

    public function delete($id)
    {

        if(Auth::id() !=$id)
        {
            $user=User::find($id);
            $user->delete();
            return redirect('admin/user/list')->with('status','Xóa thành viên thành công ');
        }
        else
        {
            return redirect('admin/user/list')->with('status','Không thể xóa thành viên  ');
        }

    }

    public function action(Request $request)
    {
        $list_check= $request->input('list_check');

        // dd($list_check);
        if($list_check)
        {
            foreach($list_check as $k=> $id)
            {
                if(Auth::id()==$id)
                {
                    unset($list_check[$k]);
                }
            }

            if(!empty($list_check))
            {
                $act= $request->input('act');

                if($act == 'delete')
                {
                    User::destroy($list_check);
                    return redirect('admin/user/list')->with('status','Bạn đã xóa thành công');
                }

                if($act == 'restore')
                {
                    User::withTrashed()
                    ->whereIn('id',$list_check)
                    ->restore();

                    return redirect('admin/user/list')->with('status','Bạn đã khôi phục thành công');
                }

                if($act == 'forceDelete')
                {
                    User::withTrashed()
                    ->whereIn('id',$list_check)
                    ->forceDelete();

                    return redirect('admin/user/list')->with('status','Bạn đã xóa vĩnh viễn thành viên ');
                }
            }

            return redirect('admin/user/list')->with('status','Bạn không thể thao tác trên tài khoản của bạn');
        }
        else
        {
            return redirect('admin/user/list')->with('status','Bạn cần chọn phần tử cần thực thi');
        }
    }


    public function edit($id)
    {
        $user= User::find($id);
        return view('admin.user.edit',compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'required'=>':attribute không được để trống',
                'min'      => ':attribute có độ dài ít nhất :min ký tự',
                'max'      => ':attribute có độ dài ít nhất :max ký tự',
            ],
            [
                'name' =>'Tên người dùng',
                'email' =>'Email',
                'password' => 'Mật khẩu',
            ]
        );

        User::where('id',$id)->update([
            'name' => $request->name,
            'password' => Hash::make($request->password)
        ]);
        return redirect('admin/user/list')->with('status','Bạn edit thanh cong');
    }
}
