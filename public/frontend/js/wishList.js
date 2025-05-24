$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
    },
});

$(document).on("click", ".wishlist-btn", function () {
    var courseId = $(this).data("course-id");
    if ($(this).hasClass("wishlisted")) {
        removeFromWishlist(courseId, this);
    } else {
        addToWishlist(courseId, this);
    }
});

function addToWishlist(course_id, el) {
    var $btn = $(el);
    var $spinner = $btn.siblings('.wishlist-spinner');
    $btn.prop('disabled', true);
    $spinner.show();

    $.ajax({
        type: "POST",
        url: "/add-to-wishlist/" + course_id,
        success: function (data) {
            $btn.addClass("wishlisted")
                .attr("title", "Remove from Wishlist")
                .find("i")
                .removeClass("la-heart-o")
                .addClass("la-heart");
            if (data.success) {
                toastr.success(data.success);
            } else if (data.info) {
                toastr.info(data.info);
            } else if (data.error) {
                toastr.error(data.error);
            }
        },
        error: function (xhr) {
            toastr.error(xhr.responseJSON?.error || "Something went wrong!");
        },
        complete: function () {
            $spinner.hide();
            $btn.prop('disabled', false);
        },
    });
}

function removeFromWishlist(course_id, el) {
    var $btn = $(el);
    var $spinner = $btn.siblings('.wishlist-spinner');
    $btn.prop('disabled', true);
    $spinner.show();

    $.ajax({
        type: "POST",
        url: "/remove-from-wishlist/" + course_id,
        data: { _method: "DELETE" },
        success: function (data) {
            $btn.removeClass("wishlisted")
                .attr("title", "Add to Wishlist")
                .find("i")
                .removeClass("la-heart")
                .addClass("la-heart-o");
            if (data.success) {
                toastr.success(data.success);
            } else if (data.info) {
                toastr.info(data.info);
            } else if (data.error) {
                toastr.error(xhr.responseJSON?.error || "Something went wrong!");
            }
        },
        error: function (xhr) {
            toastr.error(xhr.responseJSON?.error || "Something went wrong!");
        },
        complete: function () {
            $spinner.hide();
            $btn.prop('disabled', false);
        },
    });
}
