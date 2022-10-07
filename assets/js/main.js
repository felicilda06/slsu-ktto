$(document).ready(() => {
  let done = false
  const onLoadPage = ()=>{
    setTimeout(()=>{
      if(!done){
        console.log(`hey`)
        done = true
      }
      $('.loader').addClass('done')
    }, 900)
  }
  onLoadPage()

  $("#signup-link").click(() => {
    window.location.href = "sign-up.php";
  });
  $(".forgot-link").click(() => {
    window.location.href = "forgot.php";
  });
  $("#signin-link").click(() => {
    window.location.href = "sign-in.php";
  });
});
