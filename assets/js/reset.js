$(document).ready(()=>{
   let apiType;
   let validationResult = [];
   let spanElement;
   let timeOut;
   let messages = [];
   let isSubmit = false;
   let arrOfInputs = [
      {
        id: "newPass",
        value: "",
      },
      {
        id: "confirmPass",
        value: "",
      },
    ];

   const onChangeInput = (id, value) => {
      arrOfInputs = arrOfInputs.map((input) =>
        input.id === id ? { ...input, value } : input
      );
    };

    arrOfInputs.map(input => {
      $(`#${input.id}`).change(event=>{
         const {id, value} = event?.target
         onChangeInput(id, value)
      })
    })
   
  
    const validationMessage = (id, value, status, message) => {
      if (status === 400) {
        switch (id) {
          case "confirmPass": {
            const originalPass = arrOfInputs.find(
              (arr) => arr.id === "newPass"
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
                message: `Password is required.`,
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

    
   $('#btn-reset').click(event=> {
      event.preventDefault();
      messages = [...validator()];
      apiType = 'reset-password';

      const hasNoError = messages.filter((res) => !!res?.message)
      
      if(isSubmit) return
      if(hasNoError.length){
         message_func(messages)
      }else{
         $.ajax({
            url: './api/auth.php',
            type: 'POST',
            cache: false,
            data: {
               api: apiType,
               newPassword: arrOfInputs.at(0)?.value ?? ''
            },
            success: (res)=>{
               const { status_code, message } = res && JSON.parse(res);
               if(message){
                  message_func([validationMessage('', '', status_code, message)])
               }else{
                  window.location.href = 'sign-in.php';
               }
            },
            error: (err)=>{
               console.log(`Error: ${err}`);
            }
         })
      }
   })
})