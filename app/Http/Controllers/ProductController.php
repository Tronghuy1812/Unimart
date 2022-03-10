<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request , $next){
            session(['module_active'=>'product']);
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
            $products= Product::onlyTrashed()->paginate(3);
        }
        else
        {
            $keyword="";
            if($request->input('keyword'))
            {
                $keyword=$request->input('keyword');
            }
            $products= Product::where('name','LIKE',"%{$keyword}%")->paginate(3);
        }

        $count_user_active=Product::count();
        $count_user_trash =Product::onlyTrashed()->count();

        $count=[$count_user_active,$count_user_trash];
        return view('admin.products.list', compact('products','count','list_act'));
    }

    public function add()
    {
        $categories= Category::get();
        return view('admin.products.add',[
            'categories'=> $categories
        ]);
    }

    public function store( Request $request)
    {
        $path=null;

        if(request()->input('btn_add'))
        {
                $path = $request->file('image')->store('uploads');
                Product::create([
                   'name' => $request->name,
                   'description' => $request->description,
                   'price' => $request->price,
                   'price_sale' => $request->sale,
                   'category_id'=> $request->category_id,
                   'status' => $request->status,
                   'image' => $path,
                   'user_id'      => Auth::id(),

               ]);
               return redirect('admin/product/list')->with('status','Thêm thành viên thành công ');

        }
    }

    public function delete($id)
    {

        if(!empty($id))
        {
            $product=Product::find($id);
            $product->delete();
            return redirect('admin/product/list')->with('status','Xóa  thành công ');
        }
        else
        {
            return redirect('admin/product/list')->with('status','không tồn tại danh mục bạn chọn để xóa');
        }
    }

    public function edit($id)
    {
        $categories= Category::get();
        $product= Product::find($id);
        return view('admin.products.edit',[
            'product'=>$product,
            'categories'=> $categories
        ]);
    }

    public function update(Request $request, $id)
    {

        if($request->image){
            $path = $request->file('image')->store('uploads');
        }
        else {
            $path = Product::find($id)->image;
        }

        Product::where('id',$id)->update(array_merge($request->only('name','description','price','price_sale','category_id','status'),['image'=>$path]));
        return redirect('admin/product/list')->with('status','Cập nhật thành công ');
    }

    public function action(Request $request)
    {
        $list_check= $request->input('list_check');

        // dd($list_check);
        if($list_check)
        {
            // foreach($list_check as $k=> $id)
            // {
            //     if(Auth::id()==$id)
            //     {
            //         unset($list_check[$k]);
            //     }
            // }

            if(!empty($list_check))
            {
                $act= $request->input('act');

                if($act == 'delete')
                {
                    Product::destroy($list_check);
                    return redirect('admin/product/list')->with('status','Bạn đã xóa thành công');
                }

                if($act == 'restore')
                {
                    Product::withTrashed()
                    ->whereIn('id',$list_check)
                    ->restore();

                    return redirect('admin/product/list')->with('status','Bạn đã khôi phục thành công');
                }

                if($act == 'forceDelete')
                {
                    Product::withTrashed()
                    ->whereIn('id',$list_check)
                    ->forceDelete();

                    return redirect('admin/product/list')->with('status','Bạn đã xóa vĩnh viễn thành viên ');
                }
            }

            return redirect('admin/product/list')->with('status','Bạn không thể thao tác trên tài khoản của bạn');
        }
        else
        {
            return redirect('admin/product/list')->with('status','Bạn cần chọn phần tử cần thực thi');
        }
    }

}
