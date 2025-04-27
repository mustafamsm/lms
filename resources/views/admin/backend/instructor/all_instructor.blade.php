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
                        <li class="breadcrumb-item active" aria-current="page">All Instructor</li>
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
                                <th>Instructor Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Address</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($instructors as $key=> $instructor)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $instructor->name }}</td>
                                    <td>{{ $instructor->username }}</td>
                                    <td>{{ $instructor->email }}</td>
                                    <td>{{ $instructor->phone }}</td>
                                    <td>
                                        @if ($instructor->status == 1)
                                            <span class="badge bg-success status{{$instructor->id}}" >Active</span>
                                        @else
                                            <span class="badge bg-danger status{{$instructor->id}}">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <img src="{{ asset($instructor->user_image) }}" alt=""
                                            class="rounded-circle -bottom-30" style="width: 60px; height: 60px;">
                                    </td>
                                    <td>{{ $instructor->address }}</td>
                                    <td>
                                        <div class="form-check-danger form-check form-switch">
                                            <input class="form-check-input status-toggle large-checkbox" type="checkbox"
                                                id="flexSwitchCheckChecked" data-user-id="{{ $instructor->id }}"
                                                {{ $instructor->status == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                        </div>


                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No Instructor Found</td>
                                </tr>
                            @endforelse

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl</th>
                                <th>Instructor Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Address</th>
                                <th>Action</th>
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
                var userId = $(this).data('user-id');
                var status = $(this).is(':checked') ? 1 : 0;
                $.ajax({
                    url: "{{ route('update.user.status') }}",
                    method: 'POST',

                    data: {
                        user_id: userId,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {

                        toastr.success(response.message, 'Success', {
                            closeButton: true,
                            progressBar: true,
                        });
                        // Optionally, you can update the UI or perform other actions here
                    $('.status' + userId).text(status === 1 ? 'Active' : 'Inactive')
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
