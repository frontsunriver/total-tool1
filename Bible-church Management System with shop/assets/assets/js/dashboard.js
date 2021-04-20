
//Dashboard's and Other Notification Auto Hide FlashData Notification
$("div#success_notifi").delay(5000).hide("Slow");
$("div#warning_notifi").delay(5000).hide("Slow");

$(document).ready(function () {

    $(".delete").click(function () {
        if (!confirm("Do you want to delete it?")) {
            return false;
        }
    });

    $("#selectshortcode").on('change', function () {
        var selectshortcode = $("#selectshortcode").val();
        $("#shortcode").val(selectshortcode);
        console.log(selectshortcode);
    });

    $("#selectsmsapi").on('change', function () {

        var selectsmsapi = $("#selectsmsapi").val();
        if(selectsmsapi == 1){
            $(".nexmoDiv").show();
            $(".twilioDiv").hide();
        }else if(selectsmsapi == 2){
            $(".twilioDiv").show();
            $(".nexmoDiv").hide();
        }

    });


    $("select.roletype").on('change', function () {

        var roletype = $(this).val();
        console.log(roletype);

        if(roletype){
            var url = baseurl + 'dashboard/user/checkroles';
            jQuery.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: {"roletype": roletype},
                async: true,
                beforeSend: function () {
                    $("div#loading").delay(100).fadeIn();
                },
                success: function (data) {
                    $("div#loading").delay(100).fadeOut("slow");

                    if(data[0].website == "on"){
                        $("input#website").prop('checked', true);
                    }else{
                        $("input#website").prop('checked', false);
                    }

                    if(data[0].finance == "on"){
                        $("input#finance").prop('checked', true);
                    }else{
                        $("input#finance").prop('checked', false);
                    }

                    if(data[0].sermon == "on"){
                        $("input#sermons").prop('checked', true);
                    }else{
                        $("input#sermons").prop('checked', false);
                    }

                    if(data[0].event == "on"){
                        $("input#events").prop('checked', true);
                    }else{
                        $("input#events").prop('checked', false);
                    }

                    if(data[0].prayer == "on"){
                        $("input#prayers").prop('checked', true);
                    }else{
                        $("input#prayers").prop('checked', false);
                    }

                    if(data[0].notice == "on"){
                        $("input#notice").prop('checked', true);
                    }else{
                        $("input#notice").prop('checked', false);
                    }

                    if(data[0].speech == "on"){
                        $("input#speech").prop('checked', true);
                    }else{
                        $("input#speech").prop('checked', false);
                    }
                    if(data[0].family == "on"){
                        $("input#family").prop('checked', true);
                    }else{
                        $("input#family").prop('checked', false);
                    }
                    if(data[0].department == "on"){
                        $("input#department").prop('checked', true);
                    }else{
                        $("input#department").prop('checked', false);
                    }
                    if(data[0].committee == "on"){
                        $("input#committee").prop('checked', true);
                    }else{
                        $("input#committee").prop('checked', false);
                    }
                    if(data[0].member == "on"){
                        $("input#members").prop('checked', true);
                    }else{
                        $("input#members").prop('checked', false);
                    }
                    if(data[0].pastor == "on"){
                        $("input#pastors").prop('checked', true);
                    }else{
                        $("input#pastors").prop('checked', false);
                    }
                    if(data[0].clans == "on"){
                        $("input#clans").prop('checked', true);
                    }else{
                        $("input#clans").prop('checked', false);
                    }
                    if(data[0].chorus == "on"){
                        $("input#chorus").prop('checked', true);
                    }else{
                        $("input#chorus").prop('checked', false);
                    }
                    if(data[0].staff == "on"){
                        $("input#staff").prop('checked', true);
                    }else{
                        $("input#staff").prop('checked', false);
                    }
                    if(data[0].staff == "on"){
                        $("input#staffs").prop('checked', true);
                    }else{
                        $("input#staffs").prop('checked', false);
                    }
                    if(data[0].school == "on"){
                        $("input#sundays").prop('checked', true);
                    }else{
                        $("input#sundays").prop('checked', false);
                    }
                    if(data[0].user == "on"){
                        $("input#users").prop('checked', true);
                    }else{
                        $("input#users").prop('checked', false);
                    }
                    if(data[0].seminar == "on"){
                        $("input#seminar").prop('checked', true);
                    }else{
                        $("input#seminar").prop('checked', false);
                    }
                    if(data[0].attendance == "on"){
                        $("input#attendance").prop('checked', true);
                    }else{
                        $("input#attendance").prop('checked', false);
                    }
                    if(data[0].communication == "on"){
                        $("input#communication").prop('checked', true);
                    }else{
                        $("input#communication").prop('checked', false);
                    }
                    if(data[0].blog == "on"){
                        $("input#blog").prop('checked', true);
                    }else{
                        $("input#blog").prop('checked', false);
                    }
                    if(data[0].shop == "on"){
                        $("input#shop").prop('checked', true);
                    }else{
                        $("input#shop").prop('checked', false);
                    }
                    if(data[0].import == "on"){
                        $("input#import").prop('checked', true);
                    }else{
                        $("input#import").prop('checked', false);
                    }



                }
            });
        }


    });


});

//Website Basic Info UPDATE
$(document).ready(function () {
    $("#webBasicSubmit ").click(function (event) {
        event.preventDefault();

        var form = $('form#webBasicForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/website/updatebasic';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.logo_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.logo_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.favicon_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.favicon_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


//Website Basic API Update
$(document).ready(function () {
    $("#webApiSubmit ").click(function (event) {
        event.preventDefault();

        var form = $('form#webApiForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/website/updateapis';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }

            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});



/********************************/
/********* Adding User **********/
/********************************/
$(document).ready(function () {
    $("#addUserFormSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addUserForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/user/addnewuser';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


/********************************/
/********* Updating User **********/
/********************************/
$(document).ready(function () {
    $("#updateUserSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateUserForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/user/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


/********************************/
/********* Adding Committee Member **********/
/********************************/
$(document).ready(function () {
    $("#addCommitteeSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addCommitteeForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/committee/addnewcommittee';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/********************************/
/********* Update Committee Member **********/
/********************************/
$(document).ready(function () {
    $("#updateCommitteeSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateCommitteeForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/committee/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});



/********************************/
/********* Adding Member Of Member **********/
/********************************/
$(document).ready(function () {
    $("#addMemberSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addMemberForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/member/addnewmember';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/********************************/
/********* Update Member Of Member **********/
/********************************/
$(document).ready(function () {
    $("#updateMemberSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateMemberForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/member/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});




/********************************/
/********* Adding Family  **********/
/********************************/
$(document).ready(function () {
    $("#addFamilySubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addFamilyForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/family/addnewfamily';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/********************************/
/********* Update Family **********/
/********************************/
$(document).ready(function () {
    $("#updateFamilySubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateFamilyForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/family/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});




/********************************/
/********* Adding Department  **********/
/********************************/
$(document).ready(function () {
    $("#addDepartmentSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addDepartmentForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/department/addnewdepartment';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/********************************/
/********* Update Family **********/
/********************************/
$(document).ready(function () {
    $("#updateDepartmentSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateDepartmentForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/department/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/********************************/
/********* Adding Pastor **********/
/********************************/
$(document).ready(function () {
    $("#addPastorSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addPastorForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/pastor/addnewpastor';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/********************************/
/********* Update Pastor **********/
/********************************/
$(document).ready(function () {
    $("#updatePastorSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updatePastorForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/pastor/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});



/********************************/
/********* Adding Clan **********/
/********************************/
$(document).ready(function () {
    $("#addClanSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addClanForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/clan/addnewclan';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/********************************/
/********* Update Clan **********/
/********************************/
$(document).ready(function () {
    $("#updateClanSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateClanForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/clan/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});



/********************************/
/********* Adding Chorus **********/
/********************************/
$(document).ready(function () {
    $("#addChorusSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addChorusForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/chorus/addnewchorus';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/********************************/
/********* Update Chorus **********/
/********************************/
$(document).ready(function () {
    $("#updateChorusSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateChorusForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/chorus/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


/********************************/
/********* Adding Event **********/
/********************************/
$(document).ready(function () {
    $("#addEventSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addEventForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/event/addnewevent';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/********************************/
/********* Update Event **********/
/********************************/
$(document).ready(function () {
    $("#updateEventSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateEventForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/event/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


/********************************/
/********* Adding Event **********/
/********************************/
$(document).ready(function () {
    $("#addPrayerSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addPrayerForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/prayer/addnewprayer';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/********************************/
/********* Update Event **********/
/********************************/
$(document).ready(function () {
    $("#updatePrayerSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updatePrayerForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/prayer/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


/********************************/
/********* Adding Event **********/
/********************************/
$(document).ready(function () {
    $("#addNoticeSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addNoticeForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/notice/addnewnotice';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/********************************/
/********* Update Event **********/
/********************************/
$(document).ready(function () {
    $("#updateNoticeSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateNoticeForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/notice/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});



/********************************/
/********* Adding Staff **********/
/********************************/
$(document).ready(function () {
    $("#addStaffSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addStaffForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/staff/addnewstaff';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/********************************/
/********* Update Staff **********/
/********************************/
$(document).ready(function () {
    $("#updateStaffSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateStaffForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/staff/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


/*************************************************/
/********* Adding Sunday School Studnet **********/
/*************************************************/
$(document).ready(function () {
    $("#addStudentSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addStudentForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/school/addnewstudent';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/**************************************************/
/********* Update Sunday School Student  **********/
/**************************************************/
$(document).ready(function () {
    $("#updateStudentSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateStudentForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/school/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


/***********************************/
/********* Adding Seminar **********/
/***********************************/
$(document).ready(function () {
    $("#addSeminarSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addSeminarForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/seminar/addnewseminar';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/************************************/
/********* Update Seminar  **********/
/************************************/
$(document).ready(function () {
    $("#updateSeminarSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateSeminarForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/seminar/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


/***********************************/
/********* Adding Seminar **********/
/***********************************/
$(document).ready(function () {
    $("#addSeminarSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addSeminarForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/seminar/addnewseminar';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/************************************/
/********* Update Seminar Reg *******/
/************************************/
$(document).ready(function () {
    $("#updateSeminarRegSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateSeminarRegForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/seminar/updateaplicant';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


/***********************************/
/********* Adding Web Page **********/
/***********************************/
$(document).ready(function () {
    $("#webPageAddSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#webPageAddForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/page/add';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/************************************/
/********* Update Page **************/
/************************************/
$(document).ready(function () {
    $("#webPageUpdateSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#webPageUpdateForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/page/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


/***********************************/
/********* Adding Web Menu **********/
/***********************************/
$(document).ready(function () {
    $("#menuAddSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#menuAddForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/menu/add';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/************************************/
/********* Update Menu **************/
/************************************/
$(document).ready(function () {
    $("#menuUpdateSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#menuUpdateForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/menu/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


/***********************************/
/********* Adding Speech **********/
/***********************************/
$(document).ready(function () {
    $("#addSpeechSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addSpeechForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/speech/addnewspeech';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/***********************************/
/********* Upate Speech **********/
/***********************************/
$(document).ready(function () {
    $("#updateSpeechSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateSpeechForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/speech/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


/***********************************/
/********* Adding Section **********/
/***********************************/
$(document).ready(function () {
    $("#addSectionSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addSectionForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/section/addnewsection';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/***********************************/
/********* Upate Section  **********/
/***********************************/
$(document).ready(function () {
    $("#updateSectionSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateSectionForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/section/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});



/***********************************/
/********* Adding Sermon **********/
/***********************************/
$(document).ready(function () {
    $("#addSermonSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addSermonForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/sermon/addnewsermon';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/***********************************/
/********* Upate Section  **********/
/***********************************/
$(document).ready(function () {
    $("#updateSermonSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateSermonForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/sermon/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


/***********************************/
/********* Adding Blog **********/
/***********************************/
$(document).ready(function () {
    $("#addBlogSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addBlogForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/blog/addnewblog';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(500).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(500).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(500).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/************************************/
/********* Update Seminar Reg *******/
/************************************/
$(document).ready(function () {
    $("#updateBlogSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateBlogForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/blog/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(500).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(500).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(500).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});



/***********************************/
/********* Adding Product **********/
/***********************************/
$(document).ready(function () {
    $("#addProductFormSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addProductForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/shop/addnewproduct';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(500).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(500).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(500).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/************************************/
/********* Update Seminar Reg *******/
/************************************/
$(document).ready(function () {
    $("#updateProductFormSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateProductForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/shop/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(500).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(500).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(500).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});



/***********************************/
/********* Adding Attendance Type **/
/***********************************/
$(document).ready(function () {
    $("#attendanceTypeSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#attendanceTypeForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/attendance/addnewattendancetype';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


/***********************************/
/********* Adding Blog **********/
/***********************************/
$(document).ready(function () {
    $("#addUserBlogSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#addUserBlogForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/userpanel/blog/addnewblog';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(500).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(500).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(500).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

/************************************/
/********* Update Seminar Reg *******/
/************************************/
$(document).ready(function () {
    $("#updateUserBlogSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#updateUserBlogForm');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'dashboard/userpanel/blog/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(500).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(500).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(500).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailerror) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailerror + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.profileimage_error) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.profileimage_error + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.emailexist) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.emailexist + "</p>");
                    $("div#warning_notifi").delay(500).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});



/***********************************/
/********* Attendance  *************/
/***********************************/
$(document).ready(function () {
    $(".checkbox-material .check").on('click', function () {
        var userID = $(this).parent().parent().children('input.attendanceCheckBox').attr('data-id');
        var time = $(this).parent().parent().children('input.attendanceCheckBox').attr('data-time');
        var type = $(this).parent().parent().children('input.attendanceCheckBox').attr('data-type');
        var group = $(this).parent().parent().children('input.attendanceCheckBox').attr('data-group');

//        if ($(this).parent().parent().children('input.attendanceCheckBox').is(':checked')) {
//            var currentStatus = 1;
//        } else {
//            var currentStatus = 0;
//        }

        //alert(currentStatusValue);
        var url = baseurl + 'dashboard/attendance/update';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {"userID": userID, "time": time, "type": type, "group": group},
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                //alert(data.success);

                $("div#loading").delay(100).fadeOut("slow");
                if (data.success) {
                    $("div#success_notifi").html("<p><i class='material-icons'>check_box</i> Success : " + data.success + "</p>");
                    $("div#success_notifi").delay(100).show();
                    $("div#success_notifi").delay(5000).hide("Slow");
                } else if (data.errorFormValidation) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.errorFormValidation + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                } else if (data.notsuccess) {
                    $("div#warning_notifi").html("<p><i class='material-icons'>error</i> Error : " + data.notsuccess + "</p>");
                    $("div#warning_notifi").delay(100).show();
                    $("div#warning_notifi").delay(5000).hide("Slow");
                }
            }
        });
    });
});
