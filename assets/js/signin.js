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
  let apiType = "";
  let validationResult = [];

  const onChangeInput = (id, value) => {
    arrOfInputs = arrOfInputs.map((input) =>
      input.id === id ? { ...input, value } : input
    );
  };

  const validatorMessage = (id, value) => {
    switch (id) {
      case "email": {
        if (!value) {
          return {
            id,
            message: `${
              id?.charAt(0).toUpperCase() + id.slice(1)
            } address is required.`,
          };
        }
      }
      default:
        return {
          id,
          message: `${id?.charAt(0).toUpperCase() + id.slice(1)}  is required.`,
        };
    }
  };

  const validator = () => {
    arrOfInputs.map((input) => {
      return !input.value
        ? validationResult?.push(validatorMessage(input.id, input.value))
        : [];
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
    onChangeInput(id, value);
  });
  $("#password").change((event) => {
    const { id, value } = event?.target;
    onChangeInput(id, value);
  });
  $("#btn-submit").click((event) => {
    event.preventDefault();
    apiType = "sign-in";
    if (validator()?.length > 0) {
      validator()?.map((res) => {
        console.log(res?.message, `message`)
        $("#message-container").addClass("error");
        $("#message").html(res?.message);

        setTimeout(() => {
          $("#message-container").removeClass("error");
          $("#message").html("");
        }, 3500);
      });
    } else {
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
