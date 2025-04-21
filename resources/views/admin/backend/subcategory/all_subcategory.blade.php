@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">All SubCategorye</li>
                </ol>
            </nav>w
        </div>
        <div class="ms-auto">
            <div class="btn-group">
              <a href="{{route('subcategory.add')}}" class="btn btn-primary">Add SubCategory</a>  
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
  
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>SubCategory Image</th>
                            <th>SubCategory Name</th>
                            <th>Category Name</th>
                            <th>Action</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subcategories as $key=> $subcategory )
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>
                                    <img src="{{ asset($subcategory->image) }}" alt="" style="width: 70px; height: 40px;">    
                                </td>
                                 <td>{{$subcategory->category_name}}</td>
                                <td>{{$subcategory->category->category_name}}</td>
                                <td>
                                    <a href="{{ route('subcategory.edit', $subcategory->category_slug) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('subcategory.delete', $subcategory->id) }}" method="POST" style="display:inline;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger delete-btn">Delete</button>
                                    </form>              
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No subCategory Found</td>
                            </tr>
                            
                        @endforelse
                      
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sl</th>
                            <th>Category Image</th>
                            <th>Category Name</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>


</div>


@endsection