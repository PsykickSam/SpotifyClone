$(document).ready(function () {

    // events
    $("#hideLogin").click(function () {
        $("#loginForm").hide()
        $("#registerForm").show()
    })

    $("#hideRegister").click(function () {
        $("#registerForm").hide()
        $("#loginForm").show()
    })

})