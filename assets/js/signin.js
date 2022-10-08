$(document).ready(() => {
  $("#toggle-icon").click(() => {
    const type = document.getElementById("password").getAttribute("type");
    if (type === "password") {
      $("#password").attr("type", "text");
      $("#toggle-icon").attr("class", "fa fa-eye");
    } else {
      $("#password").attr("type", "password");
      $("#toggle-icon").attr("class", "fa fa-eye-slash");
    }
  });
});
