{{-- resources/views/frontend/category/partials/courses.blade.php --}}
<div id="coursesContainer" style="position:relative;">
    <div id="loadingOverlay" style="display:none; position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:1000; display:flex; justify-content:center; align-items:center;">
        <span class="spinner-border text-primary" role="status" style="width:3rem; height:3rem;"></span>
    </div>
    <div class="row">
        @foreach ($courses as $course)
            <div class="col-lg-6 responsive-column-half">
                <x-course-card :course="$course" />
            </div>
        @endforeach
    </div>
    <div class="text-center pt-3">
        {{ $courses->withQueryString()->links() }}
        <p class="fs-14 pt-2">
            Showing {{ $courses->firstItem() }}-{{ $courses->lastItem() }} of {{ $courses->total() }} results
        </p>
    </div>
</div>