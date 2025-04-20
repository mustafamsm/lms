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
                    <li class="breadcrumb-item active" aria-current="page">Edit Categorye</li>
                </ol>
            </nav>
        </div>
       
    </div>
    <!--end breadcrumb-->
  
    <div class="card">
        <div class="card-body p-4">
            <h5 class="mb-4">Edit {{$category->category_name}}</h5>
            <form id="myForm" class="row g-3" method="POST" action="{{ route('category.update',$category->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group col-md-6">
                    <label for="input1" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="input1" placeholder="Category Name" name="category_name" value="{{$category->category_name}}">
                </div>
                <div class="col-md-6">

                </div>
                <div class="form-group col-md-6">
                    <label for="image" class="form-label">Category Image</label>
                    <input type="file" class="form-control" id="image"  name="image" >
                </div>
                <div class="col-md-6">
                    <img id="showImage" src="{{asset($category->image)}}" alt="" class="rounded-circle p-1 bg-primary" width="80">
                </div>
                
               
                <div class="col-md-12">
                    <div class="d-md-flex d-grid align-items-center gap-3">
                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                category_name: {  
                    
                    required : true,
                }, 
                

                
            },
            messages :{
                category_name: { 
                    required : 'Please Enter Category Name',
                }, 
               

             
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>
<script type="text/javascript">
    $(document).ready(function(e) {
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    });



</script>

@endsection