$(document).ready(() => {
  $("#btn-submit").addClass("disabled");

  let codes = [];
  let apiType;
  let codeStr = "";

  const arrOfInput = [`code1`, `code2`, `code3`, `code4`];

  const disabledSubmit = () => {
    codeStr = codes.map((code) => code?.value ?? "").join("");
    if (codeStr.length >= 4) {
      $("#btn-submit").focus();
      $("#btn-submit").prop("disabled", false);
      $("#btn-submit").removeClass("disabled");
    } else {
      $("#btn-submit").prop("disabled", true);
      $("#btn-submit").addClass("disabled");
    }
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

  const pushToCodes = (id, value) => {
    const codeVal = { id, value };
    const isCodeExist = codes.find((code) => code?.id === id);

    if (isCodeExist) {
      codes = codes.map((code) =>
        code?.id === id ? { ...code, value } : code
      );
    } else {
      codes.push(codeVal);
    }
    disabledSubmit();
  };

  arrOfInput.map((input) => {
    $(`#${input}`).change((event) => {
      const regChars = /[!@#$%^&*()_+:"|<>?.,]/
      const regWhiteSpace = `^\\s+$`
      const regLetters = /[a-z]/gi
      const { id, value } = event?.target;
      if(regLetters.test(value)) {
        $(`#${input}`).val('');
      }else if(regChars.test(value)){
        $(`#${input}`).val('');
      }else if(value?.match(regWhiteSpace)){
        $(`#${input}`).val('');
      }else{
        pushToCodes(id, value)
      }
      
    });
  });

  $("#btn-submit").click((event) => {
    event?.preventDefault();
    apiType = "verify";
    const code = codes.map(code=> code?.value).join('');

    $.ajax({
      url: "./api/auth.php",
      type: "POST",
      cache: false,
      data: {
        api: apiType,
        code
      },
      success: (res) => {
        const res_obj = res && JSON.parse(res);
        const { status_code, message } = res_obj;

        if(message){
          message_func([validationMessage('', '', status_code, message)]);
          return;
        }else{
          window.location.href = 'reset-password.php';
          arrOfInput.map(input=> $(`${input}`).val(''));
        }

      },
      
      error: (err) => {
        console.log(`Error: ${err}`);
      },
    });
  });
});
