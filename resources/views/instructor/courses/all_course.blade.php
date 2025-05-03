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
                        <li class="breadcrumb-item active" aria-current="page">All Course</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('add.course') }}" class="btn btn-primary px-5">Add Course </a>
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
                                <th>Image </th>
                                <th>Course Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($courses as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td> <img src="{{ asset($item->course_image) }}" alt=""
                                            style="width: 70px; height:40px;"> </td>
                                    <td>{{ $item->course_name }}</td>
                                    <td>{{ $item->category_id }}</td>
                                    <td>{{ $item->selling_price }}</td>
                                    <td>{{ $item->discount_price }}</td>
                                    <td>
                                        <a href="{{ route('edit.course', $item->id) }}" class="btn btn-info px-5">Edit </a>
                                        <button class="btn btn-primary px-5" data-bs-toggle="modal"
                                            data-bs-target="#goalsModal" data-id="{{ $item->id }}"
                                            data-name="{{ $item->course_name }}" data-goals="{{ $item->goals }}">
                                            View Goals
                                        </button>
                                        <a href="{{ route('delete.course', $item->id) }}" class="btn btn-danger px-5"
                                            id="delete">Delete </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>


        <!-- Goals Modal -->
        <div class="modal fade" id="goalsModal" tabindex="-1" aria-labelledby="goalsModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="goalsModalLabel">Course Goals</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6 id="courseName"></h6>
                        <ul id="goalsList">
                            <!-- Goals will be dynamically added here -->
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Pass data to the modal
            const goalsModal = document.getElementById('goalsModal');
            goalsModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // Button that triggered the modal
                const courseName = button.getAttribute('data-name'); // Extract course name
                const goals = JSON.parse(button.getAttribute('data-goals')); // Extract goals (JSON)

                // Update the modal content
                const courseNameElement = document.getElementById('courseName');
                const goalsListElement = document.getElementById('goalsList');

                courseNameElement.textContent = `Goals for: ${courseName}`;
                goalsListElement.innerHTML = ''; // Clear previous goals

                // Add goals to the list with edit/delete options
                goals.forEach(goal => {
                    const li = document.createElement('li');
                    li.classList.add('d-flex', 'justify-content-between', 'align-items-center');
                    li.innerHTML = `
                        <span class="goal-name">${goal.goal_name}</span>
                        <div class="goal-actions">
                            <!-- Edit Button -->
                            <button class="btn btn-sm btn-warning edit-goal">Edit</button>
                            <!-- Delete Form -->
                            <form method="POST" action="/goals/${goal.id}" class="d-inline delete-goal-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    `;
                    goalsListElement.appendChild(li);

                    // Add event listener for the Edit button
                    const editButton = li.querySelector('.edit-goal');
                    editButton.addEventListener('click', function () {
                        const goalNameElement = li.querySelector('.goal-name');
                        const goalActionsElement = li.querySelector('.goal-actions');

                        // Replace the goal name with an input field
                        goalNameElement.innerHTML = `
                            <form method="POST" action="/goals/${goal.id}" class="d-inline edit-goal-form">
                                @csrf
                                @method('PUT')
                                <input type="text" name="goal_name" value="${goal.goal_name}" class="form-control d-inline-block" style="width: auto;">
                                <button type="submit" class="btn btn-sm btn-success">Save</button>
                                <button type="button" class="btn btn-sm btn-secondary cancel-edit">Cancel</button>
                            </form>
                        `;

                        // Hide the Edit and Delete buttons
                        goalActionsElement.style.display = 'none';

                        // Add event listener for the Cancel button
                        const cancelButton = goalNameElement.querySelector('.cancel-edit');
                        cancelButton.addEventListener('click', function () {
                            // Restore the original goal name and actions
                            goalNameElement.textContent = goal.goal_name;
                            goalActionsElement.style.display = 'flex';
                        });
                    });
                });
            });
        </script>
    </div>
@endsection
