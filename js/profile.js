$(document).ready(function(){

    let sessionId =
    localStorage.getItem(
        "sessionId"
    );

    if(!sessionId){

        window.location =
        "login.html";

        return;
    }

    loadProfile();

    function loadProfile(){

        $("#loader")
        .removeClass("d-none");

        $.ajax({

            url:"php/profile.php",

            type:"POST",

            data:{
                sessionId:sessionId
            },

            success:function(response){

                let data =
                JSON.parse(response);

                if(!data.success){

                    localStorage.removeItem(
                        "sessionId"
                    );

                    window.location =
                    "login.html";

                    return;
                }

                $("#fullname")
                .val(data.fullname);

                $("#email")
                .val(data.email);

                $("#age")
                .val(data.age);

                $("#dob")
                .val(data.dob);

                $("#contact")
                .val(data.contact);

                $("#address")
                .val(data.address);

                updateProgress();

            },

            complete:function(){

                $("#loader")
                .addClass("d-none");

            }

        });

    }

    $("#updateBtn").click(function(){

        let age =
        $("#age").val();

        let contact =
        $("#contact").val();

        if(age < 1 || age > 120){

            showError(
                "Enter valid age"
            );

            return;
        }

        if(
        !/^[0-9]{10}$/
        .test(contact)
        ){

            showError(
                "Contact must be 10 digits"
            );

            return;
        }

        $("#loader")
        .removeClass("d-none");

        $.ajax({

            url:"php/updateProfile.php",

            type:"POST",

            data:{

                sessionId:sessionId,

                age:$("#age").val(),

                dob:$("#dob").val(),

                contact:$("#contact").val(),

                address:$("#address").val()

            },

            success:function(response){

                $("#message").html(

                `<div class="alert alert-success">

                ${response}

                </div>`

                );

                updateProgress();

            },

            complete:function(){

                $("#loader")
                .addClass("d-none");

            }

        });

    });

    $("#logoutBtn").click(function(){

        localStorage.removeItem(
            "sessionId"
        );

        window.location =
        "login.html";

    });

    function showError(msg){

        $("#message").html(

        `<div class="alert alert-danger">

        ${msg}

        </div>`

        );

    }

    function updateProgress(){

        let filled = 0;

        if($("#age").val())
        filled++;

        if($("#dob").val())
        filled++;

        if($("#contact").val())
        filled++;

        if($("#address").val())
        filled++;

        let percent =
        (filled/4)*100;

        $("#profileProgress")
        .css(
        "width",
        percent+"%"
        )
        .text(
        percent+"%"
        );

    }

});