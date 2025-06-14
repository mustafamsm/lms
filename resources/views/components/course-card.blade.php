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
            @if ($course->isFree())
                <div class="course-badge green">Free</div>
            @endif
            @if ($course->discount_percentage)
                <div class="course-badge blue">
                    {{ $course->discount_percentage }}%

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
            <a href="{{ route('instructor.details', $course->id) }}">{{ $course->user->name }}</a>
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
            @if ($course->isFree())
                {{-- Case 1: Course is free --}}
                <p class="card-price text-success font-weight-bold">Free</p>
            @elseif ($course->hasDiscount())
                {{-- Case 2: Course has an active discount --}}
                <p class="card-price text-black font-weight-bold">
                    {{-- Display the discounted price --}}
                    ${{ number_format($course->effective_price, 2) }}

                    {{-- Display the original price with a strikethrough --}}
                    <span class="before-price font-weight-medium"
                        style="text-decoration: line-through; margin-left: 5px;">
                        ${{ number_format($course->selling_price, 2) }}
                    </span>

                    {{-- Display the discount percentage --}}
                    <span class="discount-badge text-white bg-green-500 rounded-full px-2 py-1 text-xs ml-2">
                        Save {{ $course->discount_percentage }}%
                    </span>
                </p>
            @else
                {{-- Case 3: No discount, display original selling price --}}
                <p class="card-price text-black font-weight-bold">
                    ${{ number_format($course->selling_price, 2) }}
                </p>
            @endif
            <div class="wishlist-action position-relative d-inline-block">
                <button type="button"
                    class="icon-element icon-element-sm shadow-sm cursor-pointer wishlist-btn {{ $wishlist ? 'wishlisted' : '' }}"
                    data-course-id="{{ $course->id }}"
                    title="{{ $wishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                    <i class="la {{ $wishlist ? 'la-heart' : 'la-heart-o' }}"></i>
                </button>
                <span class="spinner-border spinner-border-sm text-primary wishlist-spinner" style="display:none;"
                    role="status"></span>
            </div>
        </div>
    </div>
</div>
