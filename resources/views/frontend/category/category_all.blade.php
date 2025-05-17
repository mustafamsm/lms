@extends('frontend.master')
@section('content')
    <section class="breadcrumb-area section-padding img-bg-2">
        <div class="overlay"></div>
        <div class="container">
            <div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between">
                <div class="section-heading">
                    <h2 class="section__title text-white">{{ $category->category_name }}</h2>
                </div>
                <ul
                    class="generic-list-item generic-list-item-white generic-list-item-arrow d-flex flex-wrap align-items-center">
                    <li><a href="index.html">Home</a></li>
                    <li>{{ $category->category_name }}</li>
                </ul>
            </div><!-- end breadcrumb-content -->
        </div><!-- end container -->
    </section><!-- end breadcrumb-area -->
    <!-- ================================
                END BREADCRUMB AREA
            ================================= -->

    <!--======================================
                    START COURSE AREA
            ======================================-->
    <section class="course-area section--padding">
        <div class="container">
            <div class="filter-bar mb-4">
                <div class="filter-bar-inner d-flex flex-wrap align-items-center justify-content-between">
                    <p class="fs-14">We found <span class="text-black">{{ count($courses) }}</span> courses available for
                        you</p>
                    <div class="d-flex flex-wrap align-items-center">
                        <ul class="filter-nav mr-3">
                            <li><a href="course-grid.html" data-toggle="tooltip" data-placement="top" title="Grid View"
                                    class="active"><span class="la la-th-large"></span></a></li>
                            <li><a href="course-list.html" data-toggle="tooltip" data-placement="top"
                                    title="List View"><span class="la la-list"></span></a></li>
                        </ul>
                        <form method="GET" id="filterForm">
                            <select class="select-container-select" name="sort"id="sortSelect">
                                <option value="">All Category</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest courses
                                </option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest courses
                                </option>
                                <option value="high-rated" {{ request('sort') == 'high-rated' ? 'selected' : '' }}>Highest
                                    rated</option>
                                <option value="popular-courses"
                                    {{ request('sort') == 'popular-courses' ? 'selected' : '' }}>Popular courses</option>
                                <option value="high-to-low" {{ request('sort') == 'high-to-low' ? 'selected' : '' }}>Price:
                                    high to low</option>
                                <option value="low-to-high" {{ request('sort') == 'low-to-high' ? 'selected' : '' }}>Price:
                                    low to high</option>
                            </select>
                        </form>
                    </div>
                </div><!-- end filter-bar-inner -->
            </div><!-- end filter-bar -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="sidebar mb-5">
                        <div class="card card-item">
                            <div class="card-body">
                                <h3 class="card-title fs-18 pb-2">Search Field</h3>
                                <div class="divider"><span></span></div>
                                <form method="post">
                                    <div class="form-group mb-0">
                                        <input class="form-control form--control pl-3" type="text" name="search"
                                            placeholder="Search courses">
                                        <span class="la la-search search-icon"></span>
                                    </div>
                                </form>
                            </div>
                        </div><!-- end card -->
                        <form method="GET" id="filterForm">
                         <div class="card card-item">
                            <div class="card-body">
                                <h3 class="card-title fs-18 pb-2">Ratings</h3>
                                <div class="divider"><span></span></div>
                                <div class="custom-control custom-radio mb-1 fs-15">
                                    <input type="radio" class="custom-control-input" id="fiveStarRating"
                                        name="radio-stacked" required>
                                    <label class="custom-control-label custom--control-label" for="fiveStarRating">
                                        <span class="rating-wrap d-flex align-items-center">
                                            <span class="review-stars">
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                            </span>
                                            <span class="rating-total pl-1"><span
                                                    class="mr-1 text-black">5.0</span>(20,230)</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="custom-control custom-radio mb-1 fs-15">
                                    <input type="radio" class="custom-control-input" id="fourStarRating"
                                        name="radio-stacked" required>
                                    <label class="custom-control-label custom--control-label" for="fourStarRating">
                                        <span class="rating-wrap d-flex align-items-center">
                                            <span class="review-stars">
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                            </span>
                                            <span class="rating-total pl-1"><span class="mr-1 text-black">4.5 &
                                                    up</span>(10,230)</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="custom-control custom-radio mb-1 fs-15">
                                    <input type="radio" class="custom-control-input" id="threeStarRating"
                                        name="radio-stacked" required>
                                    <label class="custom-control-label custom--control-label" for="threeStarRating">
                                        <span class="rating-wrap d-flex align-items-center">
                                            <span class="review-stars">
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                            </span>
                                            <span class="rating-total pl-1"><span class="mr-1 text-black">3.0 &
                                                    up</span>(7,230)</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="custom-control custom-radio mb-1 fs-15">
                                    <input type="radio" class="custom-control-input" id="twoStarRating"
                                        name="radio-stacked" required>
                                    <label class="custom-control-label custom--control-label" for="twoStarRating">
                                        <span class="rating-wrap d-flex align-items-center">
                                            <span class="review-stars">
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                            </span>
                                            <span class="rating-total pl-1"><span class="mr-1 text-black">2.0 &
                                                    up</span>(5,230)</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="custom-control custom-radio mb-1 fs-15">
                                    <input type="radio" class="custom-control-input" id="oneStarRating"
                                        name="radio-stacked" required>
                                    <label class="custom-control-label custom--control-label" for="oneStarRating">
                                        <span class="rating-wrap d-flex align-items-center">
                                            <span class="review-stars">
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                                <span class="la la-star"></span>
                                            </span>
                                            <span class="rating-total pl-1"><span class="mr-1 text-black">1.0 &
                                                    up</span>(3,230)</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                    </div><!-- end card -->

                    <div class="card card-item">
                        <div class="card-body">
                            <h3 class="card-title fs-18 pb-2">Video Duration</h3>
                            <div class="divider"><span></span></div>
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox" class="custom-control-input" id="videoDurationCheckbox" required>
                                <label class="custom-control-label custom--control-label text-black"
                                    for="videoDurationCheckbox">
                                    0-2 Hours<span class="ml-1 text-gray">(12,300)</span>
                                </label>
                            </div><!-- end custom-control -->
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox" class="custom-control-input" id="videoDurationCheckbox2" required>
                                <label class="custom-control-label custom--control-label text-black"
                                    for="videoDurationCheckbox2">
                                    3-6 Hours<span class="ml-1 text-gray">(12,300)</span>
                                </label>
                            </div><!-- end custom-control -->
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox" class="custom-control-input" id="videoDurationCheckbox3" required>
                                <label class="custom-control-label custom--control-label text-black"
                                    for="videoDurationCheckbox3">
                                    7-14 Hours<span class="ml-1 text-gray">(12,300)</span>
                                </label>
                            </div><!-- end custom-control -->
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox" class="custom-control-input" id="videoDurationCheckbox4" required>
                                <label class="custom-control-label custom--control-label text-black"
                                    for="videoDurationCheckbox4">
                                    16+ Hours<span class="ml-1 text-gray">(12,300)</span>
                                </label>
                            </div><!-- end custom-control -->
                        </div>
                    </div><!-- end card -->
                    <div class="card card-item">
                        <div class="card-body">
                            <h3 class="card-title fs-18 pb-2">Level</h3>
                            <div class="divider"><span></span></div>

                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox"  class="custom-control-input" id="levelCheckbox"
                                    required>
                                <label class="custom-control-label custom--control-label text-black" for="levelCheckbox">
                                    All Levels<span class="ml-1 text-gray">(20,300)</span>
                                </label>
                            </div><!-- end custom-control -->
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox"   class="custom-control-input"
                                    id="levelCheckbox2" required>
                                <label class="custom-control-label custom--control-label text-black" for="levelCheckbox2">
                                    Beginner<span class="ml-1 text-gray">(5,300)</span>
                                </label>
                            </div><!-- end custom-control -->
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox"   class="custom-control-input"
                                    id="levelCheckbox3" required>
                                <label class="custom-control-label custom--control-label text-black" for="levelCheckbox3">
                                    Intermediate<span class="ml-1 text-gray">(3,300)</span>
                                </label>
                            </div><!-- end custom-control -->
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox"  class="custom-control-input"
                                    id="levelCheckbox4" required>
                                <label class="custom-control-label custom--control-label text-black" for="levelCheckbox4">
                                    Expert<span class="ml-1 text-gray">(1,300)</span>
                                </label>
                            </div><!-- end custom-control -->
                        </div>
                    </div><!-- end card -->

                    <div class="card card-item">
                        <div class="card-body">
                            <h3 class="card-title fs-18 pb-2">By Cost</h3>
                            <div class="divider"><span></span></div>
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox" class="custom-control-input" id="priceCheckbox" required>
                                <label class="custom-control-label custom--control-label text-black" for="priceCheckbox">
                                    Paid<span class="ml-1 text-gray">(19,300)</span>
                                </label>
                            </div><!-- end custom-control -->
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox" class="custom-control-input" id="priceCheckbox2" required>
                                <label class="custom-control-label custom--control-label text-black" for="priceCheckbox2">
                                    Free<span class="ml-1 text-gray">(1,300)</span>
                                </label>
                            </div><!-- end custom-control -->
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox" class="custom-control-input" id="priceCheckbox3" required>
                                <label class="custom-control-label custom--control-label text-black" for="priceCheckbox3">
                                    All<span class="ml-1 text-gray">(20,300)</span>
                                </label>
                            </div><!-- end custom-control -->
                        </div>
                    </div><!-- end card -->
                    <div class="card card-item">
                        <div class="card-body">
                            <h3 class="card-title fs-18 pb-2">Instructors</h3>
                            <div class="divider"><span></span></div>
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox" class="custom-control-input" id="instructorCheckbox" required>
                                <label class="custom-control-label custom--control-label text-black"
                                    for="instructorCheckbox">
                                    All Instructor
                                </label>
                            </div><!-- end custom-control -->
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox" class="custom-control-input" id="instructorCheckbox2" required>
                                <label class="custom-control-label custom--control-label text-black"
                                    for="instructorCheckbox2">
                                    Aatef Jaberi
                                </label>
                            </div><!-- end custom-control -->
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox" class="custom-control-input" id="instructorCheckbox3" required>
                                <label class="custom-control-label custom--control-label text-black"
                                    for="instructorCheckbox3">
                                    Emilee Logan
                                </label>
                            </div><!-- end custom-control -->
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox" class="custom-control-input" id="instructorCheckbox4" required>
                                <label class="custom-control-label custom--control-label text-black"
                                    for="instructorCheckbox4">
                                    Harley Ferrell
                                </label>
                            </div><!-- end custom-control -->
                            <div class="collapse" id="collapseMoreThree">
                                <div class="custom-control custom-checkbox mb-1 fs-15">
                                    <input type="checkbox" class="custom-control-input" id="instructorCheckbox5"
                                        required>
                                    <label class="custom-control-label custom--control-label text-black"
                                        for="instructorCheckbox5">
                                        Nahla Jones
                                    </label>
                                </div><!-- end custom-control -->
                                <div class="custom-control custom-checkbox mb-1 fs-15">
                                    <input type="checkbox" class="custom-control-input" id="instructorCheckbox6"
                                        required>
                                    <label class="custom-control-label custom--control-label text-black"
                                        for="instructorCheckbox6">
                                        Tomi Hensley
                                    </label>
                                </div><!-- end custom-control -->
                                <div class="custom-control custom-checkbox mb-1 fs-15">
                                    <input type="checkbox" class="custom-control-input" id="instructorCheckbox7"
                                        required>
                                    <label class="custom-control-label custom--control-label text-black"
                                        for="instructorCheckbox7">
                                        Foley Patrik
                                    </label>
                                </div><!-- end custom-control -->
                                <div class="custom-control custom-checkbox mb-1 fs-15">
                                    <input type="checkbox" class="custom-control-input" id="instructorCheckbox8"
                                        required>
                                    <label class="custom-control-label custom--control-label text-black"
                                        for="instructorCheckbox8">
                                        Oliver Porter
                                    </label>
                                </div><!-- end custom-control -->
                                <div class="custom-control custom-checkbox mb-1 fs-15">
                                    <input type="checkbox" class="custom-control-input" id="instructorCheckbox9"
                                        required>
                                    <label class="custom-control-label custom--control-label text-black"
                                        for="instructorCheckbox9">
                                        Fahad Chaudhry
                                    </label>
                                </div><!-- end custom-control -->
                            </div><!-- end collapse -->
                            <a class="collapse-btn collapse--btn fs-15" data-toggle="collapse" href="#collapseMoreThree"
                                role="button" aria-expanded="false" aria-controls="collapseMoreThree">
                                <span class="collapse-btn-hide">Show more<i
                                        class="la la-angle-down ml-1 fs-14"></i></span>
                                <span class="collapse-btn-show">Show less<i class="la la-angle-up ml-1 fs-14"></i></span>
                            </a>
                        </div>
                    </div><!-- end card -->
                    <div class="card card-item">
                        <div class="card-body">
                            <h3 class="card-title fs-18 pb-2">Features</h3>
                            <div class="divider"><span></span></div>
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox" class="custom-control-input" id="featureCheckbox" required>
                                <label class="custom-control-label custom--control-label text-black"
                                    for="featureCheckbox">
                                    Captions<span class="ml-1 text-gray">(20,300)</span>
                                </label>
                            </div><!-- end custom-control -->
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox" class="custom-control-input" id="featureCheckbox2" required>
                                <label class="custom-control-label custom--control-label text-black"
                                    for="featureCheckbox2">
                                    Quizzes<span class="ml-1 text-gray">(5,300)</span>
                                </label>
                            </div><!-- end custom-control -->
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox" class="custom-control-input" id="featureCheckbox3" required>
                                <label class="custom-control-label custom--control-label text-black"
                                    for="featureCheckbox3">
                                    Coding Exercises<span class="ml-1 text-gray">(12)</span>
                                </label>
                            </div><!-- end custom-control -->
                            <div class="custom-control custom-checkbox mb-1 fs-15">
                                <input type="checkbox" class="custom-control-input" id="featureCheckbox4" required>
                                <label class="custom-control-label custom--control-label text-black"
                                    for="featureCheckbox4">
                                    Practice Tests<span class="ml-1 text-gray">(200)</span>
                                </label>
                            </div><!-- end custom-control -->
                        </div>
                    </div><!-- end card -->
                    
                </div><!-- end sidebar -->
            </div><!-- end col-lg-4 -->
            <div class="col-lg-8">
                <div id="coursesContainer">
                    <div id="loadingSpinner" style="display:none; text-align:center;">
                        <span class="spinner-border text-primary" role="status"></span>
                    </div>
                    <div class="row">

                        @foreach ($courses as $course)
                            <div class="col-lg-6 responsive-column-half">
                                <x-course-card :course='$course' />
                            </div><!-- end col-lg-6 -->
                        @endforeach
                    </div>

                </div><!-- end row -->

                <div class="text-center pt-3">
                    <nav aria-label="Page navigation example" class="pagination-box">
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true"><i class="la la-arrow-left"></i></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true"><i class="la la-arrow-right"></i></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <p class="fs-14 pt-2">Showing 1-10 of 56 results</p>
                </div>
            </div><!-- end col-lg-8 -->
        </div><!-- end row -->
        </div><!-- end container -->
    </section><!-- end courses-area -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#sortSelect').on('change', function() {
            $('#loadingSpinner').show(); // Show spinner
            $.ajax({
                url: '{{ url()->current() }}',
                type: 'GET',
                data: $('#filterForm').serialize(),
                success: function(data) {
                    // Replace the course list with the new HTML
                    $('#coursesContainer').html($(data).find('#coursesContainer').html());
                },
                complete: function() {
                    $('#loadingSpinner').hide(); // Hide spinner after AJAX completes
                }
            });
        });

        
    </script>
@endsection
