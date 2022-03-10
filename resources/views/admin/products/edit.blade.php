@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm sản phẩm
        </div>
        <div class="card-body">
            <form action="{{route('update.product', $product->id)}}" method="POST"  enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Tên sản phẩm</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{$product->name}}">
                        </div>
                        <div class="form-group">
                            <label for="name">Giá</label>
                            <input class="form-control" type="text" name="price" id="price" value="{{$product->price}}">
                        </div>
                        <div class="form-group">
                            <label for="name">Giá sale</label>
                            <input class="form-control" type="text" name="price_sale" id="price_sale" value="{{$product->price_sale}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="intro">Mô tả sản phẩm</label>
                            <textarea name="description" class="form-control" id="intro" cols="30" rows="5" >{{$product->description}}</textarea>
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label for="intro">Chi tiết sản phẩm</label>
                    <textarea name="" class="form-control" id="intro" cols="30" rows="5"></textarea>
                </div> -->
                <div class="form-group">
                    <label for="">Danh mục</label>
                    <select name="category_id" class="form-control" id="">
                        <option>Chọn danh mục</option>

                        @php
                        foreach($categories as $category):

                          if (!empty($product['category_id']) && $category['id'] == $product['category_id']) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }
                        @endphp

                         <option value="{{$category->id}}" {{$selected}}>{{$category->name}}</option>
                        @php
                         endforeach;
                        @endphp
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status" value="1" {{$product->status==1 ? 'checked' : ''}}>
                        <label class="form-check-label" for="exampleRadios1">
                            Còn Hàng
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status" value="2" {{$product->status==2 ? 'checked' : ''}}>
                        <label class="form-check-label" for="exampleRadios2">
                            Hết hàng
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Ảnh</label>
                    <br>
                    <input  type="file" name="image" id="image">


                        <img src="{{asset('storage/'.$product->image)}}" alt="" width="100">

                </div>

                <button type="submit" name='btn_add' value="Thêm mới" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection
