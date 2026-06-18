$(document).ready(function () {

    $("#registerBtn").click(function () {

        let fullname = $("#fullname").val().trim();
        let email = $("#email").val().trim();
        let password = $("#password").val().trim();

        if (fullname === "") {

            showError("Full Name is required");
            return;
        }

        if (fullname.length < 3) {

            showError("Full Name must be at least 3 characters");
            return;
        }

        let emailPattern =
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(email)) {

            showError("Enter a valid email address");
            return;
        }

        if (password.length < 8) {

            showError(
                "Password must be at least 8 characters"
            );

            return;
        }

        if (
            !/[A-Z]/.test(password) ||
            !/[a-z]/.test(password) ||
            !/[0-9]/.test(password)
        ) {

            showError(
                "Password must contain uppercase, lowercase and a number"
            );

            return;
        }

        $.ajax({

            url: "php/register.php",

            type: "POST",

            data: {
                fullname: fullname,
                email: email,
                password: password
            },

            beforeSend: function () {

                $("#loader")
                    .removeClass("d-none");

                $("#registerBtn")
                    .prop("disabled", true)
                    .text("Registering...");

            },

            success: function (response) {

                $("#message").html(

                    `<div class="alert alert-success">

                        ${response}

                    </div>`

                );

                $("#fullname").val("");
                $("#email").val("");
                $("#password").val("");

            },

            error: function () {

                showError(
                    "Something went wrong. Please try again."
                );

            },

            complete: function () {

                $("#loader")
                    .addClass("d-none");

                $("#registerBtn")
                    .prop("disabled", false)
                    .text("Register");

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