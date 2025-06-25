@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .large-checkbox {
            transform: scale(1.5);
            margin: 10px;
            cursor: pointer;

        }
    </style>
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Course</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">

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
                                <th>Image</th>
                                <th>Course Name</th>
                                <th>Instructor</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Action</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($course as $key=> $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><img src="{{ asset($item->course_image) }}" alt=""
                                            style="width:70px;height:40px"></td>
                                    <td>{{ $item->course_name }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->category->category_name }}</td>
                                    <td>{{ $item->effective_Price }}</td>
                                    <td>
                                        <a href="{{route('admin.course.details',$item->id)}}" class="btn btn-info "><i class="lni lni-eye"></i></a>
                                    </td>

                                   
                                    <td>
                                        <div class="form-check-danger form-check form-switch">
                                            <input class="form-check-input status-toggle large-checkbox" type="checkbox"
                                                id="flexSwitchCheckChecked" data-course-id="{{ $item->id }}"
                                                {{ $item->status == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                        </div>


                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No Courses Found</td>
                                </tr>
                            @endforelse

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Course Name</th>
                                <th>Instructor</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Action</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>


    </div>

    <script>
        $(document).ready(function() {
            $('.status-toggle').on('change', function() {
                var courseId = $(this).data('course-id');
                var status = $(this).is(':checked') ? 1 : 0;
                $.ajax({
                    url: "{{ route('update.course.status') }}",
                    method: 'POST',

                    data: {
                        course_id: courseId,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {

                        toastr.success(response.message, 'Success', {
                            closeButton: true,
                            progressBar: true,
                        });
                        // Optionally, you can update the UI or perform other actions here
                        $('.status' + courseId).text(status === 1 ? 'Active' : 'Inactive')
                            .removeClass(status === 1 ? 'bg-danger' : 'bg-success')
                            .addClass(status === 1 ? 'bg-success' : 'bg-danger');
                    },
                    error: function(xhr) {

                        toastr.error(xhr.responseJSON.error, 'Error', {
                            closeButton: true,
                            progressBar: true,
                        });
                    }
                });
            });
        });
    </script>
@endsection
