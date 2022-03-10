<?php

namespace App\Http\Controllers;
// use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Image;
class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request , $next){
            session(['module_active'=>'category']);
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $categories=Category::paginate(10);
        return view('admin.categories.list',['categories'=> $categories]);
    }

    public function create(Request $request)
    {
        $path=null;

        if(request()->input('btn_submit'))
        {
            $path = $request->file('image')->store('uploads');
             Category::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $path,
                'slug' => $request->slug,
                'user_id'      => Auth::id(),
                'status' => $request->status
            ]);
            return redirect('admin/category/list')->with('status','Thêm thành viên thành công ');
        }
    }

    public function edit($id)
    {
        $categories=Category::paginate(10);
        $category= Category::find($id);
        return view('admin.categories.edit',['categories'=> $categories,'category'=>$category]);
    }

    public function update(Request $request, $id)
    {

        if($request->image){
            $path = $request->file('image')->store('uploads');
        }
        else {
            $path = Category::find($id)->image;
        }

        Category::where('id',$id)->update(array_merge($request->only('name','description','slug','status'),['image'=>$path]));
        return redirect('admin/category/list')->with('status','Cập nhật thành công ');
    }

    public function delete($id)
    {

        if(!empty($id))
        {
            $category=Category::find($id);
            $category->delete();
            return redirect('admin/category/list')->with('status','Xóa  thành công ');
        }
        else
        {
            return redirect('admin/category/list')->with('status','không tồn tại danh mục bạn chọn để xóa');
        }
    }
}
