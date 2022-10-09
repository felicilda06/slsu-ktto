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
    if (s === 0) {
      return;
    }
    timerStart();
  }, 1000);
});
