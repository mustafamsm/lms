@extends('frontend.dashboard.user_dashboard')
@section('user_content')
    <div class="container-fluid">
        <div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between mb-5">


        </div><!-- end breadcrumb-content -->
        <div class="section-block mb-5"></div>
        <div class="dashboard-heading mb-5">
            <h3 class="fs-22 font-weight-semi-bold">My Bookmarks</h3>
        </div>
        <div id="wishlistCards">
            <div class="row">
                
                @foreach ($wishlists as $ws)
                    <div class="col-lg-4 responsive-column-half">
                        <x-course-card :course="$ws->course"  :wishlist="true" />
                    </div>
                @endforeach
               
            </div>
        </div>
        <div class="text-center py-3">
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
            <p class="fs-14 pt-2">Showing 1-4 of 16 results</p>
        </div>

    </div><!-- end container-fluid -->
@endsection
