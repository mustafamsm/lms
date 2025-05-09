@extends('instructor.instructor_dashboard')
@section('instructor')
    <div class="page-content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset($course->course_image) }}" class="rounded-circle p-1 border" width="90"
                                height="90" alt="...">
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mt-0">{{ $course->course_name }}</h5>
                                <p class="mb-0">{{ $course->course_title }}</p>
                            </div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">Add Section</button>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="main-body">
                        <div class="row">
                            @foreach ($course->sections as $key => $section)
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body p-4 d-flex justify-content-between">
                                            <h6>{{ $section->section_title }}</h6>
                                            <div class="d-flex justify-content-end">
                                                <a href="#" class="btn btn-primary"
                                                    onclick="addLectureDiv({{ $course->id }}, {{ $section->id }}, 'lectureContainer{{ $key }}')">
                                                    <i class="bx bx-plus"></i> Add Lecture
                                                </a>
                                                <form action="{{route('delete.section',$section->id)}}" method="POST" class="ms-2 delete-form ">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger delete-btn">
                                                        <i class="bx bx-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="courseHide" id="lectureContainer{{ $key }}">
                                            <div class="container p-3 border rounded bg-light">
                                                @foreach ($section->lectures as $lecture)
                                              
                                                    <div class="lectureDiv mb-3 d-flex align-items-center justify-content-between">
                                                        <div>
                                                            <strong>{{ $loop->iteration }}. {{$lecture->lecture_title}}</strong>
                                                            
                                                        </div>
                                                        <div class="btn-group">
                                                            <a href="{{route('edit.lecture',$lecture->id)}}" class="btn btn-sm btn-primary"><i class="bx bx-eraser"></i>Edit</a>&nbsp;
                                                            <form action="{{route('delete.lecture',$lecture->id)}}" method="POST" class="delete-form">
                                                                @csrf
                                                            @method('delete')
                                                                <button type="submit" class="btn btn-sm btn-danger delete-btn"><i class="bx bx-trash"></i>Delete</button>
                                                            </form>
                                                         </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Section</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('add.course.section', $course->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="section_title" class="form-label">Course Section</label>
                                <input type="text" class="form-control" id="section_title" name="section_title"
                                    placeholder="Enter course section" value="{{ old('section_title') }}">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function addLectureDiv(courseId, sectionId, containerId) {
                event.preventDefault();

                const lectureContainer = document.getElementById(containerId);

                const newLectureDiv = document.createElement('div');
                newLectureDiv.className = 'lectureDiv mb-3 p-3 border rounded bg-light';

                newLectureDiv.innerHTML = `
                    <div class="mb-3">
                        <label for="lecture_title" class="form-label">Lecture Title</label>
                        <input type="text" class="form-control" id="lecture_title" name="lecture_title" placeholder="Enter lecture title">
                    </div>
                    <div class="mb-3">
                        <label for="lecture_description" class="form-label">Lecture Description</label>
                        <textarea class="form-control" id="lecture_description" name="content" rows="3" placeholder="Enter lecture description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="lecture_url" class="form-label">Lecture Video URL</label>
                        <input type="text" class="form-control" id="lecture_url" name="url" placeholder="Enter lecture video URL">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary me-2" onclick="saveLecture(${courseId}, ${sectionId}, this)">Save Lecture</button>
                        <button class="btn btn-secondary" onclick="hideLectureContainer('${containerId}', this)">Cancel</button>
                    </div>
                `;

                lectureContainer.appendChild(newLectureDiv);
            }

            function hideLectureContainer(containerId, button) {
                const lectureDiv = button.closest('.lectureDiv');
                lectureDiv.remove();
            }

            function saveLecture(courseId, sectionId, button) {
                const lectureDiv = button.closest('.lectureDiv');
                const lecture_title = lectureDiv.querySelector('input[name="lecture_title"]').value;
                const content = lectureDiv.querySelector('textarea[name="content"]').value;
                const url = lectureDiv.querySelector('input[name="url"]').value;

                // Perform AJAX request to save the lecture
                fetch(`/course/${courseId}/section/${sectionId}/lecture`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ lecture_title, content, url })
                })
                .then(response => response.json())
                .then(data => {
                    
                    if (data.status=='success') {
                    toastr.success('Lecture saved successfully!');
                         lectureDiv.remove();
                    } else {
                        toastr.error('Failed to save lecture. Please try again.');
                    }
                })
                .catch(error => {
                
                    console.error('Error:', error);
                });
                 
            }
        </script>
    @endsection
