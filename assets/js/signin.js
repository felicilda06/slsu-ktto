$(document).ready(() => {
  const emailRegEx = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
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

  const onChangeInput = (id, value) => {
    arrOfInputs = arrOfInputs.map((input) =>
      input.id === id ? { ...input, value } : input
    );
  };

  const validationMessage = (id, value, status) => {
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
          return {
            id,
            message: ``,
          };
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
          return {
            id,
            message: ``,
          };
        }
      }
    }
  };

  const validator = () => {
    arrOfInputs.map((input) => {
      const isExist = validationResult.find((res) => res?.id === input.id);
      return (
        !isExist &&
        validationResult?.push(validationMessage(input.id, input.value))
      );
    });
    return validationResult;
  };

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
    apiType = "sign-in";
    let messages = [...validator()];
    const messageContainer = $("#message-container");

    if (messages.length > 0) {
      messages.map((e) => {
        if (e?.message) {
          spanElement = document.createElement("span");
          spanElement.innerText = e?.message;
          spanElement.className = "error";
          messageContainer.addClass("error");
          messageContainer.append(spanElement);

          setTimeout(() => {
            messageContainer.removeClass("error");
            messageContainer.children().remove();
          }, [4000]);
        }
      });
    }

    // $.ajax({
    //   url: "./api/auth.php",
    //   type: "POST",
    //   cache: false,
    //   data: {
    //     api: apiType,
    //   },
    //   beforeSend: () => {},
    //   success: (res, status) => {
    //     console.log(status);
    //   },
    //   error: (err) => {},
    // });
  });
});
