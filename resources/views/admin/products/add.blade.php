@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm sản phẩm
        </div>
        <div class="card-body">
            <form action="{{url('admin/product/store')}}" method="POST"  enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Tên sản phẩm</label>
                            <input class="form-control" type="text" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="name">Giá</label>
                            <input class="form-control" type="text" name="price" id="price">
                        </div>
                        <div class="form-group">
                            <label for="name">Giá sale</label>
                            <input class="form-control" type="text" name="price_sale" id="price_sale">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="intro">Mô tả sản phẩm</label>
                            <textarea name="description" class="form-control" id="intro" cols="30" rows="5"></textarea>
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
                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status" value="1" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Chờ duyệt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status" value="2">
                        <label class="form-check-label" for="exampleRadios2">
                            Công khai
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Ảnh</label>
                    <br>
                    <input  type="file" name="image" id="image">
                </div>

                <button type="submit" name='btn_add' value="Thêm mới" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection
