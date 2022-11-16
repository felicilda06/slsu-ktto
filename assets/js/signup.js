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
    {
      id: "techology_type",
      value: "chemical",
    },
  ];
  let apiType;
  let validationResult = [];
  let spanElement;
  let timeOut;
  let messages = [];
  let isSubmit = false;
  const emailRegEx = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

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
      $('#technology_wrapper').addClass('hide')
      $('#techology_type').val('chemical')
      $('#usertype').addClass('show');
      arrOfInputs = arrOfInputs.filter((arr)=> arr.id !== "techology_type" )
    } else {
      $("#form-input-student-id").css("display", "none");
      $("#studentId").val("");
      $('#technology_wrapper').removeClass('hide')
      $('#usertype').removeClass('show');
      arrOfInputs = arrOfInputs.filter((arr) => arr.id !== "studentId");
      arrOfInputs[5] = {
        ... arrOfInputs[5],
        value:'chemical'
      }
    }
  });
  $("#techology_type").change((event) => {
    const { id, value } = event.target;
    validationResult = [];
    onChangeInput(id, value);
  })
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
    const capitalizeValue = value?.split(' ').map(str=> str.at(0).toUpperCase() + str.slice(1)).join(' ')
    $('#fullname').val(capitalizeValue)
    onChangeInput(id, capitalizeValue);
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

  const saveUser = (api)=>{
    $.ajax({
        url: "./api/auth.php",
        method: "POST",
        cache: false,
        data: {
          api: api,
          usertype: arrOfInputs.find((arr) => arr.id === "usertype")?.value,
          technology_type: arrOfInputs.find((arr) => arr.id === "techology_type")?.value ?? '',
          studentId:
            arrOfInputs.find((arr) => arr.id === "studentId")?.value ?? null,
          fullname: arrOfInputs.find((arr) => arr.id === "fullname")?.value,
          password: arrOfInputs.find((arr) => arr.id === "password")?.value,
          email: arrOfInputs.find((arr) => arr.id === "email")?.value,
        },
        beforeSend: () => {
          if(!$('#verify_container').hasClass('hide')) return
          $("#spinner").addClass("load");
          $("#btn-submit").prop("disabled", true);
        },
        success: (res) => {
          setTimeout(() => {
            $("#spinner").removeClass("load");
            $("#btn-submit").prop("disabled", false);
          }, 1200);

         if(!res) setTimeout(()=> {
           window.location.href = "sign-in.php";
           $('#verify_container').addClass('hide')
           $('#verificaition_code').val('')
         }, 300)

         message_func([validationMessage('', '', 500, res)])

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

  $("#btn-submit").click((event) => {
    console.log(arrOfInputs);
    event.preventDefault();
    apiType = "register";
    messages = [...validator()];
    const hasNoError = messages.filter((res) => !!res?.message)
    const userType = arrOfInputs.find(user=> user.id === 'usertype')?.value ?? ''

    if (isSubmit) return;
    if (hasNoError.length) {
       message_func(messages);
    } else {
      if(userType === 'patent drafter'){
        $('#verify_container').removeClass('hide')
      }else{
        saveUser(apiType)
      }
    }
  });

  $(document).on('click', '#btn_verify', (event)=>{
     event.preventDefault();
     const verification_code = $('#verificaition_code').val()

     if (isSubmit) return;
     if(verification_code?.toLowerCase() === 'ktto'){
      saveUser('register');
     }else if(!verification_code){
      return message_func([validationMessage('', '', 500, 'Please Enter Verification Code.')]);
     }else{
        return message_func([validationMessage('', '', 500, 'Incorrect Verification Code.')]);
     }
  })
});

  $(document).on('click', '#btn_close', ()=>{
    $('#verify_container').addClass('hide')
    $('#verificaition_code').val('')
})

$("#toggle-icon").click(() => {
  const type = $("#password").attr("type");
  if (type === "password") {
    $("#password").attr("type", "text");
    $("#confirmPass").attr("type", "text");
    $("#toggle-icon").attr("class", "fa fa-eye");
  } else {
    $("#password").attr("type", "password");
    $("#confirmPass").attr("type", "password");
    $("#toggle-icon").attr("class", "fa fa-eye-slash");
  }
});

