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
                        <li class="breadcrumb-item active" aria-current="page">Edit Lecture</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('add.course.lecture',$lecture->course_id) }}" class="btn btn-primary px-5">Back </a>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Edit Lecture </h5>
                <form id="myForm" class="row g-3" method="POST" action="{{ route('update.lecture',$lecture->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group col-md-6">
                        <x-input name="lecture_title" label="Lecture Title" type="text" id="lecture_title"
                            placeholder="Enter Lecture Title" value="{{ old('lecture_title', $lecture->lecture_title) }}" />

                    </div>
                    <div class="form-group col-md-6">
                        <x-input name="url" label="Lecture URL" type="text" id="url"
                            placeholder="Enter Lecture URL" value="{{ old('url', $lecture->url) }}" />

                    </div>

                    <div class="form-group col-md-12">
                        <label for="content">Lecture Content</label>
                        <textarea name="content" id="content" class="form-control "  >{{$lecture->content}}</textarea>
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
@endsection
