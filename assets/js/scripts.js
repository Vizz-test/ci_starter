

// ============================== File related scripts ==================================

$('body').on('change', '#v_doc_file', function(){
    if($(this).val() !== ""){
        let totalFiles = $(this)[0].files.length;
        $(this).prev('label').find('i').addClass('fa-check');
        $(this).prev('label').find('i').removeClass('fa-upload');
        $(this).prev('label').find('i').css('color', 'green');
        $(this).prev('label').find('span').text(`${totalFiles} Files selected`);
    }else{
        $(this).prev('label').find('i').addClass('fa-upload');
        $(this).prev('label').find('i').removeClass('fa-check');
        $(this).prev('label').find('span').text(`Upload Documents`);
    }
})




function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.tk_img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#project_image").on('change',function(){
    readURL(this);
});


$('#vprofileimg').on('change', function(){
    $("label[for='vprofileimg']").text($(this)[0].files[0].name);
    $("label[for='vprofileimg']").css('color', '#ff1982');
})




// ========================= Copy text script ===================================

// ============ HTML =====
/**
 * 
 * <p>Token Address: <span class="address">text content</span><span class="copy-text"><i class="far fa-copy"></i></span></p>
 * 
 */

$('body').on('click','.copy-text',function(){
    navigator.clipboard.writeText($(this).siblings('.address').text());
    let i = $(this).find('i');
    i.addClass('fa-check').removeClass('fa-copy');
    i.css('color', '#FF1982');
    setTimeout(function(){
        i.addClass('fa-copy').removeClass('fa-check');
        i.removeAttr('style');
    }, 1000)
})


// ============================ Time Counter ===================================


function counter(){
    var countDownDate = new Date("Jan 5, 2022 15:37:25").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

    // Get today's date and time
    var now = new Date().getTime();

    // Find the distance between now and the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="demo"
    document.getElementById("demo").innerHTML = days + "d " + hours + "h "
    + minutes + "m " + seconds + "s ";

    // If the count down is finished, write some text
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "EXPIRED";
    }
    }, 1000);
}




