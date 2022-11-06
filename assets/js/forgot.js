$(document).ready(() => {
  let arrOfInputs = [
    {
      id: "email",
      value: "",
    },
  ];
  let apiType;
  let validationResult = [];
  let spanElement;
  let isSubmit = false;
  const emailRegEx = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

  const onChangeInput = (id, value) => {
    arrOfInputs = arrOfInputs.map((input) =>
      input.id === id ? { ...input, value } : input
    );
  };

  $("#email").change((event) => {
    const { id, value } = event?.target;
    validationResult = [];
    onChangeInput(id, value);
  });

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

  const randomNumbers = ()=>{
    const numbers = '0123456789';
    let code = '';

    for (let i = 0; i <= 3; i++) {
      var randomNumber = Math.floor(Math.random() * numbers.length);
      code +=  numbers.substring(randomNumber, randomNumber + 1);
     }

     return code;
  }

  $("#btn-continue").click((event) => {
    event.preventDefault();
    apiType = "forgot";
    let messages = [...validator()];
    const hasNoError = messages.filter((res) => res?.message)

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
            code: randomNumbers() ?? '',
            email: arrOfInputs.find((arr) => arr.id === "email")?.value ?? '',
          },
          success: (res) => {
            const res_obj = res && JSON.parse(res);
            const { status_code, message } = res_obj

            if(message) {
              message_func([validationMessage('', '', status_code, message)]);
            }else{
              window.location.href = 'confirmation.php';
            }
          },
          error: (err) => {
            console.log(`Error: ${err}`);
          },
        });
    }
  });
});
