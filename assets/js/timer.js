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

  const randomNumbers = ()=>{
    const numbers = '0123456789';
    let code = '';

    for (let i = 0; i <= 3; i++) {
      var randomNumber = Math.floor(Math.random() * numbers.length);
      code +=  numbers.substring(randomNumber, randomNumber + 1);
     }

     return code.length < 4 ? `${code}0`: code;
  }
  
  const resendOTPCode = ()=>{
    const email = $('#email').val();
    $.ajax({
      url: './api/auth.php',
      type:'POST',
      cache: false,
      data: {
        api: 'resend_code',
        code: randomNumbers() ?? '',
        email
      },
      success: (_res)=>{},
      error: (err)=>{
         console.log(`Error: ${err}`);
      }
   })
  }

  setInterval(() => {
    const isShow = $(".alert-message").hasClass("show");
    if (s === 0) {
      $("#resend").css("font-weight", "bold");
      $('.expiration').text('The OTP Code has expired. Please re-send the OTP Code to try again.');
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
    resendOTPCode();
  });

  $("#icon-close").click(() => {
    $(".alert-message").removeClass("show");
    window.location.href = "confirmation.php";
  });
});
