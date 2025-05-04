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
                        <li class="breadcrumb-item active" aria-current="page">Edit Course</li>
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
                <h4 class="mb-4 text-primary fw-bold">Edit Course</h4>
                <form id="myForm" class="row g-4" method="POST" action="{{ route('update.course', $course->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    {{-- Course Details --}}
                    <div class="col-md-6">
                        <x-input id="course_name" name="course_name" label="Course Name" placeholder="Enter course name"
                            value="{{ old('course_name', $course->course_name) }}" icon="bx bx-pencil" type="text" />



                    </div>

                    <div class="col-md-6">
                        <x-input id="course_title" name="course_title" label="Course Title" placeholder="Enter course title"
                            value="{{ old('course_title', $course->course_title) }}" icon="bx bx-book" type="text" />

                    </div>

                    {{-- Category & Subcategory --}}
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select select2" id="category_id" name="category_id">
                            <option selected disabled>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($course->category_id == $category->id)>
                                    {{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="subcategory_id" class="form-label">Subcategory</label>
                        <select class="form-select select2" id="subcategory_id" name="subcategory_id">
                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" @selected($course->subcategory_id == $subcategory->id)>
                                    {{ $subcategory->category_name }}</option>
                            @endforeach
                        </select>
                        <div id="subcategory-loader" style="display: none;">
                            <i class="spinner-border text-primary"></i> Loading...
                        </div>
                    </div>



                    {{-- Pricing --}}
                    <div class="col-md-4">
                        <x-input id="selling_price" name="selling_price" label="Course Price" placeholder="Enter price"
                            value="{{ old('selling_price', $course->selling_price) }}" icon="bx bx-dollar" type="number" />

                    </div>

                    <div class="col-md-4">
                        <x-input id="discount_price" name="discount_price" label="Discount Price"
                            placeholder="Enter discount price" value="{{ old('discount_price', $course->discount_price) }}"
                            icon="bx bx-tag" type="number" />
                    </div>

                    <div class="col-md-4">
                        <label for="final_price" class="form-label">Final Price</label>
                        <p id="final_price" class="form-control-plaintext">
                            ${{ $course->selling_price - $course->discount_price }}</p>
                    </div>

                    {{-- Course Details --}}
                    <div class="col-md-6">
                        <x-input id="duration" name="duration" placeholder="e.g. 6 weeks" type="text" icon="bx bx-time"
                            value="{{ old('duration', $course->duration) }}" label="Duration" />


                    </div>

                    <div class="col-md-6">
                        <x-input id="resources" name="resources" label="Resources" placeholder="Resource links"
                            value="{{ old('resources', $course->resources) }}" icon="bx bx-globe" type="text" />

                    </div>

                    <div class="col-md-6">
                        <label for="label" class="form-label">Course Label</label>
                        <select class="form-select" id="label" name="label">
                            <option selected disabled>Select Label</option>
                            <option value="Beginner" @selected($course->label === 'Beginner')>Beginner</option>
                            <option value="Intermediate" @selected($course->label === 'Intermediate')>Intermediate</option>
                            <option value="Expert" @selected($course->label === 'Expert')>Expert</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="certificate" class="form-label">Certificate Avalilable</label>
                        <select class="form-select" id="certificate" name="certificate">
                            <option selected disabled>Open this select menu</option>
                            <option value="Yes" @selected($course->certificate === 'Yes')>Yes</option>
                            <option value="No" @selected($course->certificate === 'No')>No</option>
                        </select>
                    </div>

                    <div class="col-12">

                        <label for="prerequisites" class="form-label">Prerequisites</label>
                        <textarea class="form-control" id="prerequisites" name="prerequisites" rows="3"
                            placeholder="E.g., basic math skills...">{{ $course->prerequisites }}</textarea>
                    </div>

                    {{-- Rich Text Editor --}}
                    <div class="col-12">
                        <label for="myeditorinstance" class="form-label">Course Description</label>
                        <textarea id="myeditorinstance" name="description" class="form-control" rows="5">{!! $course->description !!}</textarea>
                    </div>


                    {{-- Checkboxes --}}
                    <div class="col-12 mt-4">
                        <div class="row">
                            @foreach (['bestseller' => 'Best Seller', 'featured' => 'Featured', 'highestreated' => 'Highest Rated'] as $key => $label)
                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="{{ $key }}"
                                            name="{{ $key }}" value="1" @checked($course->$key)>
                                        <label class="form-check-label"
                                            for="{{ $key }}">{{ $label }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-4">Update Course</button>
                    </div>
                </form>
            </div>






        </div>
    </div>
    <div class="page-content">
        <div class="card shadow rounded-3 border-0">
            <div class="card-body p-5">
                <h4 class="mb-4 text-primary fw-bold">Course Image</h4>
                <form id="myForm" class="row g-4" method="POST"
                    action="{{ route('update.course.image', $course->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="col-md-6">
                        <x-input id="course_image" name="course_image" label="Course Image" type="file"
                            icon="bx bx-image" accept=".jpg, .jpeg, .png" placeholder="Upload course image" />
                    </div>

                    <div class="col-md-6">
                        <img id="showImage" src="{{ asset($course->course_image) ?? asset('upload/no_image.jpg') }}"
                            alt="Course Image" style="width: 100px; height: 100px; border-radius: 5px;">
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-4">Update Image</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="page-content">
        <div class="card shadow rounded-3 border-0">
            <div class="card-body p-5">
                <h4 class="mb-4 text-primary fw-bold">Course Video</h4>
                <form id="myForm" class="row g-4" method="POST"
                    action="{{ route('update.course.video', $course->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="col-md-6">
                        <x-input id="course_video" name="video" label="Course Video" type="file"
                            icon="bx bx-video" accept=".mp4, .avi, .mov" placeholder="Upload course video" />
                    </div>

                    <div class="col-md-6">
                        <video id="showVideo" src="{{ asset($course->video) ?? '' }}" alt="Course Video"
                            style="width: 300px; height: 130px; border-radius: 5px;" controls></video>
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-4">Update Video</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card shadow rounded-3 border-0">
            <div class="card-body p-5">
                <h4 class="mb-4 text-primary fw-bold">Course Goals</h4>
                <form id="myForm" class="row g-4" method="POST"
                    action="{{ route('update.course.goals', $course->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    @foreach ($course_goals as $goal)
                        <div class="row add_item">
                            <div class="whole_extra_item_delete" id="whole_extra_item_delete">
                                <div class="container mt-2">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="goals" class="form-label"> Goals </label>
                                                <input type="text" name="course_goals[]" id="goals"
                                                    class="form-control" value="{{ $goal->goal_name }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6" style="padding-top: 30px;">
                                            <a class="btn btn-success addeventmore"><i class="fa fa-plus-circle"></i> Add
                                                More..</a>
                                                <span class="btn btn-danger btn-sm removeeventmore"><i
                                                    class="fa fa-minus-circle">Remove</i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!---end row-->
                    @endforeach

                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-4">Update Goals</button>
                    </div>
                </form>
            </div>
        </div>


        <div style="visibility: hidden">
            <div class="whole_extra_item_add" id="whole_extra_item_add">
                <div class="whole_extra_item_delete" id="whole_extra_item_delete">
                    <div class="container mt-2">
                        <div class="row">


                            <div class="form-group col-md-6">
                                <label for="goals">Goals</label>
                                <input type="text" name="course_goals[]" id="goals" class="form-control"
                                    placeholder="Goals  ">
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

                        course_title: {
                            required: true,
                        },




                    },
                    messages: {
                        course_name: {
                            required: 'Please Enter Course Name',
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
                    }
                });

            });

            $(document).ready(function() {
            var counter = 0;

            // Add more goals
            $(document).on("click", ".addeventmore", function() {
                var whole_extra_item_add = $("#whole_extra_item_add").html();
                $(this).closest(".add_item").append(whole_extra_item_add);
                counter++;
            });

            // Remove goals
            $(document).on("click", ".removeeventmore", function(event) {
                $(this).closest(".whole_extra_item_delete").remove();
                counter -= 1;
            });

            // Prevent empty goals from being submitted
            $('#myForm').on('submit', function(e) {
                $('input[name="course_goals[]"]').each(function() {
                    if (!$(this).val().trim()) {
                        $(this).remove();
                    }
                });
            });
        });
        </script>
    @endsection
