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
                    <li class="breadcrumb-item active" aria-current="page">All Categorye</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
              <a href="{{route('category.add')}}" class="btn btn-primary">Add Category</a>  
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
                            <th>Category Image</th>
                            <th>Category Name</th>
                            <th>Action</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $keys=> $category )
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>
                                    <img src="{{ asset($category->image) }}" alt="" style="width: 70px; height: 40px;">    
                                </td>
                                <td>{{$category->category_name}}</td>
                                
                                <td>
                                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No Category Found</td>
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