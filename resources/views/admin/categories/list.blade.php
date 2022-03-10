@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    @if(session('status'))
        <div class="alert alert-success">{{session('status')}}</div>
    @endif
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh mục sản phẩm
                </div>
                <div class="card-body">
                    <form action="{{route('category.create')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên danh mục</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{old('name')}}">
                        </div>
                        <div class="form-group">
                            <label for="name">Slug</label>
                            <input class="form-control" type="text" name="slug" id="slug" value="{{old('slug')}}">
                        </div>
                        <div class="form-group">
                            <label for="name">Mô tả</label>
                            <input class="form-control" type="text" name="description" id="description"
                                value="{{old('description')}}">
                        </div>
                        <div class="form-group">
                            <input type="file" name="image" id="image">
                        </div>

                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="0"
                                    checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Hiển thị
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="exampleRadios2"
                                    value="1">
                                <label class="form-check-label" for="exampleRadios2">
                                    Ẩn
                                </label>
                            </div>
                        </div>
                        <button type="submit" name="btn_submit" value="Thêm mới" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">description</th>
                                <th scope="col">image</th>
                                <th scope="col">slug</th>
                                <th scope="col">user_id </th>
                                <th scope="col">created_at </th>
                                <th scope="col">status </th>
                                <th scope="col">Action </th>
                            </tr>
                        </thead>
                        @if($categories->total()>0)
                        <tbody>
                            @php
                                $t=0;
                            @endphp
                            @foreach($categories as $category)
                            @php
                                $t++;
                            @endphp
                            <tr >
                                <th scope="row">{{$t}}</th>
                                <td>{{$category->name}}</td>
                                <td>{{$category->description}}</td>
                                <td><img src="{{asset('storage/'.$category->image)}}" alt="img" width="100"></td>
                                <td>{{$category->slug}}</td>
                                <td>{{$category->user_id }}</td>
                                <td>{{$category->created_at }}</td>
                                <td>{{$category->status==0 ? 'Hiển thị' : 'Ẩn' }}</td>
                                <td class="d-flex">
                                    <a href="{{route('edit.category',$category->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('delete.category',$category->id)}}" onclick="return confirm('Bạn có chắc chắn muốn xóa không ?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="9" align="center"><p>Không có dữ liệu </p></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
