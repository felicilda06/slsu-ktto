$(document).ready(() => {
  let time = "00:90";
  let [m, s] = time.split(":");

  const timerStart = () => {
    s--;
    if (s <= 5) {
      time = `${m}:0${s}`;
      $("#timer").css("color", "red");
      $("#timer").html(time);
    } else if (s < 10) {
      time = `${m}:0${s}`;
      $("#timer").html(time);
    } else {
      time = `${m}:${s}`;
      $("#timer").html(time);
    }
  };

  setInterval(() => {
    const isShow = $(".alert-message").hasClass("show");
    if (s === 0) {
      $("#resend").css("font-weight", "bold");
      return;
    }
    if (isShow) {
      return;
    } else {
      timerStart();
    }
  }, 1000);

  $("#resend").click(() => {
    $(".alert-message").addClass("show");
    $("#resend").css("font-weight", "normal");
  });

  $("#icon-close").click(() => {
    $(".alert-message").removeClass("show");
    window.location.href = "confirmation.php";
  });
});
