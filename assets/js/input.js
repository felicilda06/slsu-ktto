$(document).ready(() => {
  const email = document.getElementById("email");
  const password = document.getElementById("password");

  $("#email").focus(() => {
    if (!password.value) {
        $(".txt-password").removeClass("focused");
        $("#password").removeClass("focused");
        $(".icon-password").removeClass("focused");
    } else {
      $(".txt-password").css("color", "black");
      $("#password").removeClass("focused");
      $(".icon-password").removeClass("focused");
    }

    if (!email.value) {
      $(".txt-email").addClass("focused");
      $("#email").addClass("focused");
      $(".icon-email").addClass("focused");
    }
  });
  $("#password").focus(() => {
    if (!email.value) {
        $(".txt-email").removeClass("focused");
        $("#email").removeClass("focused");
        $(".icon-email").removeClass("focused");
    } else {
      $(".txt-email").css("color", "black");
      $("#email").removeClass("focused");
      $(".icon-email").removeClass("focused");
    }

    if (!password.value) {
      $(".txt-password").addClass("focused");
      $("#password").addClass("focused");
      $(".icon-password").addClass("focused");
    }
  });
});


