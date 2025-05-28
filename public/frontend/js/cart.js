// add to cart
function addToCart(courseId, courseName, instructorId, slug) {
    console.log(courseId, courseName, instructorId, slug);
    $.ajax({
        type: "POST",
        datatype: "json",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            course_name: courseName,
            course_name_slug: slug,
            instructor: instructorId,
        },
        url: "/cart/data/store/" + courseId,
        success: function (data) {
            if (data.success) {
                toastr.success(data.success);
                miniCart();
            } else if (data.info) {
                toastr.info(data.info);
            } else if (data.error) {
                toastr.error(data.error);
            }
        },
        error: function (xhr) {
            toastr.error(xhr.responseJSON?.error || "Something went wrong!");
        },
    });
}

// start mini cart
function miniCart() {
    $.ajax({
        type: "GET",
        datatype: "json",
        url: "/course/mini/cart",
        success: function (data) {
            if (data) {
               $('#cartSubTotal').text(data.cartTotal + "$");
                $('#cartQty').text(data.cartCount);
                var miniCart = "";
                $.each(data.carts, function (key, value) {
                     miniCart += `  <li class="media media-card">
                                                <a href="shopping-cart.html" class="media-img">
                                                    <img src="/${value.options.image}" alt="Cart image">
                                                </a>
                                                <div class="media-body">
                                                    <h5><a href="/course/details/${value.id}/${value.options.slug}">${value.name}</a></h5>

                                                      <p class="text-black font-weight-semi-bold lh-18">${value.price}$
                                                          <a type="submit" id="${value.rowId}" onclick="miniCartRemove(this.id)"><i class="la la-times"></i></a>
                                                      </p>
                                                 </div>
                                            </li>
                                            `;
                });
                $('#miniCart').html(miniCart);
            } else if (data.error) {
                toastr.error(data.error);
            }
        },
        error: function (xhr) {
            toastr.error(xhr.responseJSON?.error || "Something went wrong!");
        },
    });
}

miniCart();


function miniCartRemove(rowId){
    $.ajax(
        {

            type:'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/minicart/course/remove/'+rowId,
            dataType:"json",
             success: function (data) {
            if (data.success) {
                toastr.success(data.success);
                miniCart();
            } else if (data.info) {
                toastr.info(data.info);
            } else if (data.error) {
                toastr.error(data.error);
            }
        },
        error: function (xhr) {
            toastr.error(xhr.responseJSON?.error || "Something went wrong!");
        },
    })
}