<section class="course-area pb-120px">
    <div class="container">
        <div class="section-heading text-center">
            <h5 class="ribbon ribbon-lg mb-2">Choose your desired courses</h5>
            <h2 class="section__title">The world's largest selection of courses</h2>
            <span class="section-divider"></span>
        </div><!-- end section-heading -->
        <ul class="nav nav-tabs generic-tab justify-content-center pb-4" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab"
                    aria-controls="all" aria-selected="true">All</a>
            </li>
            @foreach ($categories as $cat)
                <li class="nav-item">
                    <a class="nav-link" id="{{ $cat->category_name }}-tab" data-toggle="tab"
                        href="#{{ $cat->category_name }}" role="tab" aria-controls="{{ $cat->category_name }}"
                        aria-selected="false">{{ $cat->category_name }}</a>
                </li>
            @endforeach
        </ul>
    </div><!-- end container -->
    <div class="card-content-wrapper bg-gray pt-50px pb-120px">
        <div class="container">
            <div class="tab-content" id="myTabContent">
                <!-- All Tab -->
                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                    <div class="row">
                        @foreach ($allCourses->take(6) as $course)
                            <div class="col-lg-4 responsive-column-half">
                                <div class="card card-item card-preview"
                                    data-tooltip-content="#tooltip_content_{{ $course->id }}">
                                    <div class="card-image">
                                        <a href="{{url('course/details/'.$course->id.'/'.$course->course_name_slug)}}" class="d-block">
                                            <img class="card-img-top lazy" src="{{ asset($course->course_image) }}"
                                                data-src="{{ $course->course_image }}"
                                                alt="{{ $course->course_title }}">
                                        </a>
                                        <div class="course-badge-labels">
                                            @if ($course->bestseller == 1)
                                                <div class="course-badge">Bestseller</div>
                                            @endif
                                            @if ($course->highestreated == 1)
                                                <div class="course-badge sky-blue">Highestreated</div>
                                            @endif
                                            @if ($course->discount_price == null)
                                                <div class="course-badge">New</div>
                                            @endif
                                            <div class="course-badge blue">
                                                {{ round((($course->selling_price - $course->discount_price) / $course->selling_price) * 100) }}%
                                            </div>
                                        </div>
                                    </div><!-- end card-image -->
                                    <div class="card-body">
                                        <h6 class="ribbon ribbon-blue-bg fs-14 mb-3">{{ $course->label }}</h6>
                                        <h5 class="card-title"><a
                                                href="{{url('course/details/'.$course->id.'/'.$course->course_name_slug)}}">{{ $course->course_name }}</a></h5>
                                        <p class="card-text"><a
                                                href="teacher-detail.html">{{ $course->user->name }}</a></p>
                                        <div class="rating-wrap d-flex align-items-center py-2">
                                            <div class="review-stars">
                                                <span class="rating-number">{{ $course->rating }}</span>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span
                                                        class="la {{ $i <= $course->rating ? 'la-star' : 'la-star-o' }}"></span>
                                                @endfor
                                            </div>
                                            <span class="rating-total pl-1">({{ $course->reviews_count }})</span>
                                        </div><!-- end rating-wrap -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            @if ($course->discount_price == null)
                                                <p class="card-price text-black font-weight-bold">
                                                    ${{ $course->selling_price }}</p>
                                            @else
                                                <p class="card-price text-black font-weight-bold">
                                                    ${{ $course->discount_price }}
                                                    <span
                                                        class="before-price font-weight-medium">{{ $course->selling_price }}</span>
                                                </p>
                                            @endif

                                            <div class="icon-element icon-element-sm shadow-sm cursor-pointer"
                                                title="Add to Wishlist"><i class="la la-heart-o"></i></div>
                                        </div>
                                    </div><!-- end card-body -->
                                </div><!-- end card -->
                            </div><!-- end col-lg-4 -->
                        @endforeach
                    </div><!-- end row -->
                </div><!-- end All Tab -->

                <!-- Category Tabs -->
                @foreach ($categories as $cat)
                    <div class="tab-pane fade" id="{{ $cat->category_name }}" role="tabpanel"
                        aria-labelledby="{{ $cat->category_name }}-tab">
                        <div class="row">
                            @foreach ($cat->courses->take(6) as $course)
                            <div class="col-lg-4 responsive-column-half">
                               <x-course-card :course="$course"/>
                            </div>
                            @endforeach
                        </div><!-- end row -->
                    </div><!-- end tab-pane -->
                @endforeach
            </div><!-- end tab-content -->
            <div class="more-btn-box mt-4 text-center">
                <a href="course-grid.html" class="btn theme-btn">Browse all Courses <i
                        class="la la-arrow-right icon ml-1"></i></a>
            </div><!-- end more-btn-box -->
        </div><!-- end container -->
    </div><!-- end card-content-wrapper -->
</section><!-- end courses-area -->


{{-- tooltip_templates --}}
@foreach ($allCourses as $course)
    
<div class="tooltip_templates">
    <div id="tooltip_content_{{ $course->id }}">
        <div class="card card-item">
            <div class="card-body">
                <p class="card-text pb-2">By <a href="teacher-detail.html">{{$course->user->name}}</a></p>
                <h5 class="card-title pb-1"><a href="{{url('course/details/'.$course->id.'/'.$course->course_name_slug)}}">{{$course->course_title}}</a></h5>
                <div class="d-flex align-items-center pb-1">
                    @if($course->bestseller)
                    <h6 class="ribbon fs-14 mr-2">Bestseller</h6>
                    @else
                    <h6 class="ribbon fs-14 mr-2">New</h6>
                    @endif
                    <p class="text-success fs-14 font-weight-medium">Updated<span class="font-weight-bold pl-1">{{$course->created_at->format('M d Y')}}</span></p>
                </div>
                <ul class="generic-list-item generic-list-item-bullet generic-list-item--bullet d-flex align-items-center fs-14">
                    <li>{{$course->duration  }} total hours</li>
                    <li>{{$course->label}}</li>
                </ul>
                <p class="card-text pt-1 fs-14 lh-22">{{$course->prerequisites}}</p>
                <ul class="generic-list-item fs-14 py-3">
                    @foreach ($course->goals as $goal )
                      <li><i class="la la-check mr-1 text-black"></i> {{$goal->goal_name}}</li>
                    @endforeach
                    
                </ul>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="#" class="btn theme-btn flex-grow-1 mr-3"><i class="la la-shopping-cart mr-1 fs-18"></i> Add to Cart</a>
                    <div class="icon-element icon-element-sm shadow-sm cursor-pointer" title="Add to Wishlist"><i class="la la-heart-o"></i></div>
                </div>
            </div>
        </div><!-- end card -->
    </div>
</div><!-- end tooltip_templates -->
@endforeach
