$(document).ready(() => {
  let arrOfInputs = [
    {
      id: "email",
      value: "",
    },
    {
      id: "password",
      value: "",
    },
  ];
  let apiType;
  let validationResult = [];
  let spanElement;
  let messages = [];
  let isSubmit = false;
  const emailRegEx = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

  setTimeout(()=> $('#email').focus(), 1000);

  const onChangeInput = (id, value) => {
    arrOfInputs = arrOfInputs.map((input) =>
      input.id === id ? { ...input, value } : input
    );
  };

  const validationMessage = (id, value, status, message) => {
    if (status === 400) {
      switch (id) {
        case "email": {
          if (!value) {
            return {
              id,
              message: `${
                id?.charAt(0).toUpperCase() + id.slice(1)
              } address is required.`,
            };
          } else if (!emailRegEx.test(value)) {
            return {
              id,
              message: `Must be valid email address.`,
            };
          } else {
            return false;
          }
        }
        default: {
          if (!value) {
            return {
              id,
              message: `${
                id?.charAt(0).toUpperCase() + id.slice(1)
              }  is required.`,
            };
          } else {
            return false;
          }
        }
      }
    }else{
      return {
        message: message ?? `An error occur in saving data.`,
      };
    }
  };

  const validator = () => {
    arrOfInputs.map((input) => {
      const isExist = validationResult.find((res) => res?.id === input.id);
      return (
        !isExist &&
        validationResult?.push(validationMessage(input.id, input.value, 400))
      );
    });
    return validationResult;
  };

  $("#toggle-icon").click(() => {
    const type = $("#password").attr("type");
    if (type === "password") {
      $("#password").attr("type", "text");
      $("#toggle-icon").attr("class", "fa fa-eye");
    } else {
      $("#password").attr("type", "password");
      $("#toggle-icon").attr("class", "fa fa-eye-slash");
    }
  });
  $("#email").change((event) => {
    const { id, value } = event?.target;
    validationResult = [];
    onChangeInput(id, value);
  });
  $("#password").change((event) => {
    const { id, value } = event?.target;
    validationResult = [];
    onChangeInput(id, value);
  });

  const message_func = (messages = []) => {
    const messageContainer = $("#message-container");
    timeOut = messages.length > 2 ? 4150 : 2500
    messages.map((e) => {
      spanElement = document.createElement("span");
      if (e?.message) {
        isSubmit = true;
        spanElement.innerText = e?.message;
        spanElement.className = "error";
        messageContainer.addClass("error");
        messageContainer.append(spanElement);

        setTimeout(() => {
          messageContainer.removeClass("error");
          isSubmit = false;
        }, [4000]);

        setTimeout(() => messageContainer.children().remove(), timeOut);
      }
    });
  }


  $("#btn-submit").click((event) => {
    event.preventDefault();
    apiType = "login";
    messages = [...validator()];
    const hasNoError = messages.filter((res) => !!res?.message)

    if (isSubmit) return;
    if (hasNoError.length) {
     message_func(messages);
    } else {
      $.ajax({
        url: "./api/auth.php",
        type: "POST",
        cache: false,
        data: {
          api: apiType,
          email:  arrOfInputs.find((arr) => arr.id === "email")?.value ?? '',
          password:  arrOfInputs.find((arr) => arr.id === "password")?.value ?? '',
        },
        success: (res) => {
          const res_obj = res && JSON.parse(res)
          const { status_code, message, usertype } = res_obj
          
          if(status_code !== 200 && message){
            message_func([validationMessage('', '', status_code, message)]);
          }else{
            if(usertype === 'patent drafter'){
              window.location.href = './patent-drafter/dashboard.php';
            }else if(usertype === 'admin'){
              window.location.href = './admin/dashboard.php';
            }else if(usertype === 'maker'){
              window.location.href = './maker/dashboard.php';
            }else if(usertype === 'clerk'){
              window.location.href = './clerk/dashboard.php';
            }
            else{return}
          }
          
          
        },
        error: (err) => {
          console.log(`Error: ${err}`);
        },
      });
    }
  });
});