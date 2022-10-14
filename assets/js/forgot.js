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

  const validationMessage = (id, value, status) => {
    if (status === 400) {
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

  $("#btn-continue").click((event) => {
    event.preventDefault();
    apiType = "forgot";
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
          }, [3000]);

          setTimeout(() => messageContainer.children().remove(), [3150]);
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
          success: (res, status, code) => {},
          error: (err) => {
            console.log(`Error: ${err}`);
          },
        });
    }
  });
});
