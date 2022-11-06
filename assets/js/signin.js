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
  let isSubmit = false;
  const emailRegEx = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

  const onChangeInput = (id, value) => {
    arrOfInputs = arrOfInputs.map((input) =>
      input.id === id ? { ...input, value } : input
    );
  };

  const validationMessage = (id, value, status) => {
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
    } else if (status === 200) {
      return {
        status: 200,
        message: "Successully Login.",
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
  $("#btn-submit").click((event) => {
    event.preventDefault();
    apiType = "login";
    let messages = [...validator()];
    const messageContainer = $("#message-container");
    const hasNoError = messages.map((res) => !!res?.message).every((b) => !b);

    if (isSubmit) return;
    if (!hasNoError) {
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

          setTimeout(() => messageContainer.children().remove(), [4150]);
        }
      });
    } else {
      $.ajax({
        url: "./api/auth.php",
        type: "POST",
        cache: false,
        data: {
          api: apiType,
        },
        success: (res) => {},
        error: (err) => {
          console.log(`Error: ${err}`);
        },
      });
    }
  });
});
