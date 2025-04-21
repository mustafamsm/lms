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
                        <li class="breadcrumb-item active" aria-current="page">Add SubCategorye</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Add SubCategorye</h5>
                <form id="myForm" class="row g-3" method="POST" action="{{ route('subcategory.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">SubCategory Name</label>
                        <input type="text" class="form-control" id="input1" placeholder="SubCategory Name"
                            name="category_name">
                        @error('category_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Category Name</label>
                        <select class="form-select" name="category_id" id="input1" aria-label="Default select example">
                            <option selected="" disabled>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group col-md-6">
                        <label for="image" class="form-label">SubCategory Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <img id="showImage" src="{{ url('upload/no_image.jpg') }}" alt=""
                            class="rounded-circle p-1 bg-primary" width="80">
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
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    category_name: {

                        required: true,
                    },
                    category_id: {

                        required: true,

                    },
                    image: {
                        required: true,
                    }


                },
                messages: {
                    category_name: {
                        required: 'Please Enter SubCategory Name',
                    },
                    category_id: {
                        required: 'Please Select Category Name',
                    },
                    image: {
                        required: "Please Select Category Image"
                    }




                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(e) {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>
@endsection
