$(document).ready(function () {

    $("#loginBtn").click(function () {

        let email =
            $("#email").val().trim();

        let password =
            $("#password").val().trim();

        let emailPattern =
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(email)) {

            showError(
                "Enter a valid email address"
            );

            return;
        }

        if (password === "") {

            showError(
                "Password is required"
            );

            return;
        }

        $.ajax({

            url: "php/login.php",

            type: "POST",

            data: {

                email: email,
                password: password

            },

            beforeSend: function () {

                $("#loader")
                    .removeClass("d-none");

                $("#loginBtn")
                    .prop("disabled", true)
                    .text("Logging In...");

            },

            success: function (response) {

                let data =
                    JSON.parse(response);

                if (data.success) {

                    $("#message").html(

                        `<div class="alert alert-success">

                            Login Successful

                        </div>`

                    );

                    localStorage.setItem(
                        "sessionId",
                        data.sessionId
                    );

                    setTimeout(function () {

                        window.location =
                            "profile.html";

                    }, 1000);

                }
                else {

                    showError(
                        data.message
                    );

                }

            },

            error: function () {

                showError(
                    "Server Error"
                );

            },

            complete: function () {

                $("#loader")
                    .addClass("d-none");

                $("#loginBtn")
                    .prop("disabled", false)
                    .text("Login");

            }

        });

    });

    function showError(message) {

        $("#message").html(

            `<div class="alert alert-danger">

                ${message}

            </div>`

        );

    }

});