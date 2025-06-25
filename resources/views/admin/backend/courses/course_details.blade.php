@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Course Details</div>

            <div class="ms-auto">

            </div>
        </div>
        <!--end breadcrumb-->
        <div class="container">
            <div class="card radius-10">


                <div class="card-body">


                    <div class="d-flex align-items-center">


                        <img src="{{ asset($course->course_image) }}" class="rounded-circle p-1 border" width="90"
                            height="90" alt="...">


                        <div class="flex-grow-1 ms-3">


                            <h5 class="mt-0">{{ $course->course_name }}</h5>


                            <p class="mb-0">{{ $course->course_title }}</p>


                        </div>


                    </div>


                </div>


            </div>
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <table class="table mb-0">


                                <tbody>
                                    <tr>
                                        <th>Category : </th>
                                        <td>{{ $course->category->category_name ?? N / A }}</td>

                                    </tr>
                                    <tr>
                                        <th>SubCategory : </th>
                                        <td>{{ $course->subcategory->category_name ?? N / A }}</td>

                                    </tr>
                                    <tr>
                                        <th>Instructor : </th>
                                        <td>{{ $course->user->name }}</td>
                                    </tr>

                                    <tr>
                                        <th>Label : </th>
                                        <td>{{ $course->label }}</td>
                                    </tr>
                                    <tr>
                                        <th>Duration : </th>
                                        <td>{{ $course->duration }}</td>
                                    </tr>
                                    <tr>
                                        <th>Video : </th>
                                        <td>
                                            <video width="320" height="240" src="{{ asset($course->video) }}"
                                                controls></video>
                                        </td>
                                    </tr>



                                </tbody>


                            </table>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <table class="table mb-0">


                                <tbody>
                                    <tr>



                                        <td><strong>Resources : </strong></td>


                                        <td> {{ $course->resources }} </td>


                                    </tr>


                                    <tr>


                                        <td><strong>certificate :</strong> </td>


                                        <td> {{ $course->certificate }}</td>


                                    </tr>


                                    <tr>


                                        <td><strong>Selling Price :</strong> </td>


                                        <td> ${{ $course->selling_price }}</td>

                                    </tr>
                                    <tr>



                                        <td><strong> Discount Price :</strong> </td>


                                        <td>${{ $course->discount_price }}</td>

                                    </tr>
                                    <tr>



                                        <td><strong> Final Price :</strong> </td>


                                        <td>${{ $course->effective_price }}</td>

                                    </tr>
                                    <tr>


                                        <td><strong>Status :</strong> </td>


                                        <td>


                                            @if ($course->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif


                                        </td>

                                    </tr>
                                </tbody>


                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
