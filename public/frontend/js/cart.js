function addToCart(courseId,courseName,instructorId,slug){
    console.log(courseId, courseName, instructorId, slug);
    $.ajax({
        type:'POST',
        datatype:'json',
        data:{
            _token:$('meta[name="csrf-token"]').attr('content'),
            course_name:courseName,
            course_name_slug:slug,
            instructor:instructorId,
            
        },
        url:"/cart/data/store/"+courseId,
        success:function(data){
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
    })
}