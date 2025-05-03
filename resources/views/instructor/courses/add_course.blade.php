@extends('instructor.instructor_dashboard')
@section('instructor')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Course</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card shadow rounded-3 border-0">
            <div class="card-body p-5">
                <h4 class="mb-4 text-primary fw-bold">Add New Course</h4>
                <form id="myForm" class="row g-4" method="POST" action="{{ route('store.course') }}"
                    enctype="multipart/form-data">
                    @csrf

                    {{-- Course Details --}}
                    <div class="col-md-6">
                        <x-input 
                        id="course_name" 
                        name="course_name" 
                        label="Course Name" 
                        placeholder="Enter course name" 
                        value="{{ old('course_name') }}" 
                        icon="bx bx-pencil" 
                        type="text"
                    />
                    

                        
                    </div>

                    <div class="col-md-6">
                        <x-input 
                         id="course_title"
                         name="course_title"
                         label="Course Title"
                         placeholder="Enter course title"
                         value="{{old('course_title')}}"
                        icon="bx bx-book"
                        type="text"
                        />
                       
                    </div>

                    {{-- Category & Subcategory --}}
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select select2" id="category_id" name="category_id">
                            <option selected disabled>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="subcategory_id" class="form-label">Subcategory</label>
                        <select class="form-select select2" id="subcategory_id" name="subcategory_id">
                            <option selected disabled>Select Subcategory</option>
                        </select>
                        <div id="subcategory-loader" style="display: none;">
                            <i class="spinner-border text-primary"></i> Loading...
                        </div>
                    </div>

                    {{-- Course Media --}}
                    <div class="col-md-6">
                        {{-- Course Video --}}
                        <x-input 
                            id="video" 
                            name="video" 
                            label="Intro Video" 
                            placeholder="Upload course video" 
                            icon="bx bx-video" 
                            type="file" 
                            accept="video/*" 
                        />
                    </div>

                    <div class="col-md-6">
                        {{-- Course Image --}}
                        <x-input 
                            id="course_image" 
                            name="course_image" 
                            label="Course Image" 
                            placeholder="Upload course image" 
                            icon="bx bx-image" 
                            type="file" 
                            accept="image/*" 
                        />
                    </div>

                    {{-- Preview Image --}}
                    <div class="col-md-6 text-center">
                        <img id="showImage" src="{{ url('upload/no_image.jpg') }}" class="img-thumbnail mt-2 shadow"
                            width="120" alt="Preview" loading="lazy">
                    </div>

                    {{-- Pricing --}}
                    <div class="col-md-4">
                        <x-input 
                        id="selling_price" 
                        name="selling_price" 
                        label="Course Price" 
                        placeholder="Enter price" 
                        value="{{ old('selling_price') }}" 
                        icon="bx bx-dollar" 
                        type="number" 
                    />
                
                    </div>

                    <div class="col-md-4">
                        <x-input 
                        id="discount_price" 
                        name="discount_price" 
                        label="Discount Price" 
                        placeholder="Enter discount price" 
                        value="{{ old('discount_price') }}" 
                        icon="bx bx-tag" 
                        type="number" 
                    />
                    </div>

                    <div class="col-md-4">
                        <label for="final_price" class="form-label">Final Price</label>
                        <p id="final_price" class="form-control-plaintext">$0.00</p>
                    </div>

                    {{-- Course Details --}}
                    <div class="col-md-6">
                        <x-input 
                         id="duration"
                         name="duration"
                         placeholder="e.g. 6 weeks"
                         type="text"
                         icon="bx bx-time"
                         value="{{ old('duration') }}"
                         label="Duration"
                        
                        />

                        
                    </div>

                    <div class="col-md-6">
                        <x-input
                            id="resources" 
                            name="resources" 
                            label="Resources" 
                            placeholder="Resource links" 
                            value="{{ old('resources') }}" 
                            icon="bx bx-globe" 
                            type="text"

                        />
                       
                    </div>

                    <div class="col-md-6">
                        <label for="label" class="form-label">Course Label</label>
                        <select class="form-select" id="label" name="label">
                            <option selected disabled>Select Label</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="certificate" class="form-label">Certificate Avalilable</label>
                        <select class="form-select" id="certificate" name="certificate">
                            <option selected disabled>Open this select menu</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                         </select>
                    </div>

                    <div class="col-12">

                        <label for="prerequisites" class="form-label">Prerequisites</label>
                        <textarea class="form-control" id="prerequisites" name="prerequisites" rows="3"
                            placeholder="E.g., basic math skills..."></textarea>
                    </div>

                    {{-- Rich Text Editor --}}
                    <div class="col-12">
                        <label for="myeditorinstance" class="form-label">Course Description</label>
                        <textarea id="myeditorinstance" name="description" class="form-control" rows="5"></textarea>
                    </div>
                    <p>Course Goals</p>
                    <div class="row add_item">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="goals" class="form-label"> Goals </label>
                                <input type="text" name="course_goals[]" id="goals" class="form-control"
                                    placeholder="Goals ">
                            </div>
                        </div>
                        <div class="form-group col-md-6" style="padding-top: 30px;">
                            <a class="btn btn-success addeventmore"><i class="fa fa-plus-circle"></i> Add More..</a>
                        </div>
                    </div> <!---end row-->
                    <!--========== Start of add multiple class with ajax ==============-->
                    <div style="visibility: hidden">
                        <div class="whole_extra_item_add" id="whole_extra_item_add">
                            <div class="whole_extra_item_delete" id="whole_extra_item_delete">
                                <div class="container mt-2">
                                    <div class="row">


                                        <div class="form-group col-md-6">
                                            <label for="goals">Goals</label>
                                            <input type="text" name="course_goals[]" id="goals"
                                                class="form-control" placeholder="Goals  ">
                                        </div>
                                        <div class="form-group col-md-6" style="padding-top: 20px">
                                            <span class="btn btn-success btn-sm addeventmore"><i
                                                    class="fa fa-plus-circle">Add</i></span>
                                            <span class="btn btn-danger btn-sm removeeventmore"><i
                                                    class="fa fa-minus-circle">Remove</i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Checkboxes --}}
                    <div class="col-12 mt-4">
                        <div class="row">
                            @foreach (['bestseller' => 'Best Seller', 'featured' => 'Featured', 'highestreated' => 'Highest Rated'] as $key => $label)
                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="{{ $key }}"
                                            name="{{ $key }}" value="1">
                                        <label class="form-check-label"
                                            for="{{ $key }}">{{ $label }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-4">Save Course</button>
                    </div>
                </form>
            </div>
        </div>



    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {


            $('.select2').select2({
                placeholder: "Select an option",
                width: '100%'
            });

            $('#discount_price, #selling_price').on('input', function() {
                const sellingPrice = parseFloat($('#selling_price').val()) || 0;
                const discountPrice = parseFloat($('#discount_price').val()) || 0;
                const finalPrice = sellingPrice - discountPrice;
                $('#final_price').text(finalPrice > 0 ? `$${finalPrice.toFixed(2)}` : 'Free');
            });

            $('#myForm').validate({
                rules: {
                    course_name: {

                        required: true,
                    },
                    course_image: {
                        required: true,
                    },
                    course_title: {
                        required: true,
                    },
                    



                },
                messages: {
                    course_name: {
                        required: 'Please Enter Course Name',
                    },
                    course_image: { // Corrected variable name here
                        required: "Please Select Course Image" // Updated message to reflect correct context
                    },
                    course_title: {
                        required: 'Please Enter Course Title',
                    },


                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });

            $('#myForm').on('submit', function() {
                if (!$(this).valid()) {
                    e.preventDefault(); // Prevent form submission
                    return; // Exit the function without disabling the button
                }
                $('button[type="submit"]').prop('disabled', true).html(
                    '<i class="spinner-border spinner-border-sm"></i> Saving...');
            });

        });

        $(document).ready(function(e) {
            $('#course_image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });


            $('select[name="category_id"]').on('change', function() {

                var category_id = $(this).val();

                if (category_id) {
                    $.ajax({
                        url: "{{ url('/subcategory/ajax') }}/" + category_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#subcategory_id').empty().append(
                                '<option value="" disabled selected>Select Subcategory</option>'
                            );
                            $.each(data, function(key, value) {
                                $('#subcategory_id').append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                            $('#subcategory-loader').hide();
                        },
                        beforeSend: function() {
                            $('#subcategory-loader').show();
                        },
                        complete: function() {
                            $('#subcategory-loader').hide();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Failed to load subcategories. Please try again later.',
                            });
                        }
                    });
                } else {
                    alert('danger');
                }
            });

        });

        $(document).ready(function() {
            var counter = 0;
            $(document).on("click", ".addeventmore", function() {
                var whole_extra_item_add = $("#whole_extra_item_add").html();
                $(this).closest(".add_item").append(whole_extra_item_add);
                counter++;
            });
            $(document).on("click", ".removeeventmore", function(event) {
                $(this).closest("#whole_extra_item_delete").remove();
                counter -= 1
            });
        });
    </script>
@endsection
