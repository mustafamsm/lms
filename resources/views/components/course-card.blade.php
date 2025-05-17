{{-- filepath: resources/views/components/course-card.blade.php --}}

<div class="card card-item card-preview" data-tooltip-content="#tooltip_content_{{ $course->id }}">
    <div class="card-image">
        <a href="{{ url('course/details/' . $course->id . '/' . $course->course_name_slug) }}" class="d-block">
            <img class="card-img-top lazy" src="{{ asset($course->course_image) }}" data-src="{{ $course->course_image }}"
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
            @if ($course->selling_price == $course->discount_price)
                <div class="course-badge green">Free</div>
            @endif
            @if ($course->discount_price !== null && $course->selling_price > $course->discount_price)
                <div class="course-badge blue">
                    {{ round((($course->selling_price - $course->discount_price) / $course->selling_price) * 100) }}%

                </div>
            @endif
        </div>
    </div>
    <div class="card-body">
        <h6 class="ribbon ribbon-blue-bg fs-14 mb-3">{{ $course->label }}</h6>
        <h5 class="card-title">
            <a
                href="{{ url('course/details/' . $course->id . '/' . $course->course_name_slug) }}">{{ $course->course_title }}</a>
        </h5>
        <p class="card-text">
            <a href="teacher-detail.html">{{ $course->user->name }}</a>
        </p>
        <div class="rating-wrap d-flex align-items-center py-2">
            <div class="review-stars">
                <span class="rating-number">{{ $course->rating }}</span>
                @for ($i = 1; $i <= 5; $i++)
                    <span class="la {{ $i <= $course->rating ? 'la-star' : 'la-star-o' }}"></span>
                @endfor
            </div>
            <span class="rating-total pl-1">({{ $course->reviews_count }})</span>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            @if ($course->selling_price == $course->discount_price)
                <p class="card-price text-success font-weight-bold">Free</p>
            @elseif ($course->discount_price == null)
                <p class="card-price text-black font-weight-bold">
                    ${{ $course->selling_price }}</p>
            @else
                <p class="card-price text-black font-weight-bold">
                    ${{ $course->discount_price }}
                    <span class="before-price font-weight-medium">{{ $course->selling_price }}</span>
                </p>
            @endif
            <div class="icon-element icon-element-sm shadow-sm cursor-pointer" title="Add to Wishlist"><i
                    class="la la-heart-o"></i></div>
        </div>
    </div>
</div>
