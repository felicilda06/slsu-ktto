$(document).ready(()=>{
    const userId = $('#user_id').val()
    const userType = $('#profile_user_type').val();
    const emailRegEx = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    let timeOut;
    let validationResult = [];
    let spanElement;
    let messages = [];
    let isSubmit = false;
    let arrOfInputs = [
      {id: 'age', value:''},
      {id: 'contact_no', value:''},
      {id: 'gender', value:''},
      {id: 'profile', value:[]},
    ]
    let formData = new FormData()

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
          case "contact_no": {
              if (!value) {
                return {
                  id,
                  message: `Contact Information is required.`,
                };
              }else if(value?.length !== 11){
                return {
                  id,
                  message: `Must be valid Contact Number.`,
                };
              } else if(!value?.match(/^([\d]+)/g)){
                return {
                  id,
                  message: `Contact No allowed only digits.`,
                };
              } else {
                return false;
              }
          }
          default: {
            return false;
          }
        }
      }else{
        return {
          message: message ?? `An error occur in updating data.`,
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
        if(e?.status !== 200){
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
        }else{
            isSubmit = true;
            spanElement.innerText = e?.message;
            spanElement.className = "success";
            messageContainer.addClass("success");
            messageContainer.append(spanElement);
    
            setTimeout(() => {
              messageContainer.removeClass("success");
              isSubmit = false;
            }, [4000]);
    
            setTimeout(() => messageContainer.children().remove(), timeOut);
          }
      });
    }

    const onChangeInput = (id, value) => {
      const isHasPassword = arrOfInputs.find(arr=> arr?.id === id)
      validationResult = [];
      if(!isHasPassword){
        arrOfInputs.push({id, value})
      }else{
        arrOfInputs = arrOfInputs.map((input) =>
          input.id === id ? { ...input, value } : input
        );
      }
    };

    const renderValue = (values = [])=>{
       if(values.length){
         if(userType === 'patent drafter'){
           $('#technology_type').removeClass('d-none')
         }else{
            $('#technology_type').addClass('d-none')
         }
         if(!Object.keys(values[0]).includes('profile')){
          $('#user_profile').attr('src', './assets/images/profile.jpg');
         }
         else{
            Object.entries(values[0]).map(([key, value])=>{
              if(key === 'profile'){
                $('#user_profile').attr('src', `./profiles/${value}`)
              }else{
                $(`#${key}`).val(value)
              }
              arrOfInputs.push({id: key, value})
              onChangeInput(key, value)
              $(`#${key}`).change(event=>{
                validationResult = [];
                $('#btn_update_profile').removeAttr('disabled');
                onChangeInput(event?.target.id, event?.target.value)
              })
          })
         }
       }
    }

    $('#password').change(event=>{
      const { id, value }  = event?.target
       onChangeInput(id, value)
       $('#btn_update_profile').removeAttr('disabled');
    })
    

    arrOfInputs.map(arr=>{
      $(`#${arr?.id}`).change(event=>{
        validationResult = [];
        onChangeInput(event?.target.id, event?.target.value)
        $('#btn_update_profile').removeAttr('disabled');
      })
    })


    const getAccountInfo = ()=>{
       $.ajax({
           url:'./api/profile-api.php',
           type:'POST',
           cache: false,
           data:{
            api: 'get_account_info',
            userId
           },
           success: (res)=>{
             const accountData = res && JSON.parse(res)
             renderValue(accountData)
           },
           error: (err)=>{
            console.log(`Error`, err);
           }
       })
    }

    getAccountInfo()

    function openDialog() {
       $('#upload_profile #profile').remove()
       const profile = document.createElement('input')
       profile.id = 'profile'
       profile.type = 'file'
       profile.className = 'd-none'
       profile.accept = 'image/*'
       profile.click()
       profile.onchange = _ => {
         // you can use this method to get file and perform respective operations
                let files =   Array.from(profile.files);
                arrOfInputs = arrOfInputs.map(arr=> arr?.id === 'profile' ? {...arr, value: files} : arr)
                $('#btn_update_profile').removeAttr('disabled');
             };
       $('#upload_profile').append(profile)
    }

    $(document).on('click', '#btn_upload_image', openDialog)

    $(document).on('change', '#profile', function(e){
      const myProfile = URL.createObjectURL(e.target.files[0]);
      $('#user_profile').attr('src', myProfile);
    })

    $('#btn_show_pass').click(()=>{
        if($('#password').attr('type') === 'password'){
          $('#password').attr('type', 'text')
          $('#btn_show_pass').removeClass('fa-eye-slash')
          $('#btn_show_pass').addClass('fa-eye')
        }else{
          $('#password').attr('type', 'password')
          $('#btn_show_pass').removeClass('fa-eye')
          $('#btn_show_pass').addClass('fa-eye-slash')
        }
    })

    setTimeout(()=> $('#studentId').focus() , 1000)

    $('#btn_update_profile').click(()=>{
      messages = [...validator()];
      const hasNoError = messages.filter((res) => !!res?.message)
      if (isSubmit) return;
      if (hasNoError.length) {
       message_func(messages);
      }else{
          arrOfInputs.map(arr=> formData.append(arr?.id, arr?.id !== 'profile' ? arr?.value ?? '' : arr?.value[0]))
          formData.append('api', 'update_profile');
          formData.append('userId', userId);
          $.ajax({
            url:'./api/profile-api.php',
            type:'POST',
            cache: false,
            data:formData,
            processData: false,
            contentType: false,
            success: (res)=>{
              console.log(res);
               const { status_code, message } = res && JSON.parse(res)
               message_func([{status: status_code, message}])
               $('#btn_update_profile').attr('disabled', true);
               getAccountInfo();
            },
            error: (err)=>{
              message_func([{status: 500, message: err}])
            }
        })
      }
    })
})