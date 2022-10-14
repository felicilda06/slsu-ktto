$(document).ready(() => {
  let arrOfInputs = [
    {
      id: "usertype",
      value: "patent drafter",
    },
    {
      id: "email",
      value: "",
    },
    {
      id: "fullname",
      value: "",
    },
    {
      id: "password",
      value: "",
    },
    {
      id: "confirmPass",
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
        case "confirmPass": {
          const originalPass = arrOfInputs.find(
            (arr) => arr.id === "password"
          )?.value;
          if (!value || value !== originalPass) {
            return {
              id,
              message: `Password does'nt match.`,
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
            return false;
          }
        }
      }
    } else if (status === 500) {
      return {
        message: `An error occur in saving data.`,
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

  $("#form-input-student-id").css("display", "none");
  $("#usertype").change((event) => {
    const { id, value } = event.target;
    validationResult = [];
    onChangeInput(id, value);

    const studentInput = {
      id: "studentId",
      value: "",
    };

    if (value === "maker") {
      $("#form-input-student-id").css("display", "flex");
      arrOfInputs.unshift(studentInput);
    } else {
      $("#form-input-student-id").css("display", "none");
      $("#studentId").val("");
      arrOfInputs = arrOfInputs.filter((arr) => arr.id !== "studentId");
    }
  });
  $("#studentId").change((event) => {
    const { id, value } = event.target;
    validationResult = [];
    onChangeInput(id, value);
  });
  $("#email").change((event) => {
    const { id, value } = event.target;
    validationResult = [];
    onChangeInput(id, value);
  });
  $("#fullname").change((event) => {
    const { id, value } = event.target;
    validationResult = [];
    onChangeInput(id, value);
  });
  $("#password").change((event) => {
    const { id, value } = event.target;
    validationResult = [];
    onChangeInput(id, value);
  });
  $("#confirmPass").change((event) => {
    const { id, value } = event.target;
    validationResult = [];
    onChangeInput(id, value);
  });
  $("#btn-submit").click((event) => {
    event.preventDefault();
    apiType = "register";
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

          setTimeout(() => messageContainer.children().remove(), 4150);
        }
      });
    } else {
      $.ajax({
        url: "./api/auth.php",
        method: "POST",
        cache: false,
        data: {
          api: apiType,
          usertype: arrOfInputs.find((arr) => arr.id === "usertype")?.value,
          studentId:
            arrOfInputs.find((arr) => arr.id === "studentId")?.value ?? "",
          fullname: arrOfInputs.find((arr) => arr.id === "name")?.value,
          password: arrOfInputs.find((arr) => arr.id === "password")?.value,
          email: arrOfInputs.find((arr) => arr.id === "email")?.value,
        },
        beforeSend: () => {
          $("#spinner").addClass("load");
          $("#btn-submit").prop("disabled", true);
        },
        success: (res, status, code) => {
          setTimeout(() => {
            $("#spinner").removeClass("load");
            $("#btn-submit").prop("disabled", false);
          }, 1200);

          console.log(res, status, code, `logs`);
        },
        error: (err) => {
          if (err) {
            setTimeout(() => {
              $("#spinner").removeClass("load");
              $("#btn-submit").prop("disabled", false);
            }, 2500);
          }

          if (!$("#spinner").hasClass("load")) {
            validationMessage("", "", 500);
          }
        },
      });
    }
  });
});
