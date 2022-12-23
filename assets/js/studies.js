$(document).ready(()=>{
    const user = $('#user_email').val();
    let apiType = '';
    let arrOfDocuments = [];
    let formData = new FormData()
    let arrOfInputs = [
        {id: 'author', value: user},
        {id: 'doc_title', value:''},
        {id: 'proponent', value:''},
        {id: 'technology_type', value:''},
        {id: 'contact_info', value:''},
        {id: 'intellectual_property', value:''},
        {id: 'file', value:{}},
        {id: 'status', value:'Pending'},
        {id: 'color', value:'e3e5e6'},
    ];
    let validationResult = [];
    let spanElement;
    let timeOut;
    let messages = [];
    let isSubmit = false;
    let arrOfUpdateInputs = [
      {id: 'updt_title', value:''},
      {id: 'updt_proponent', value:''},
      {id: 'updt_technology_type', value:''},
      {id: 'updt_contact_information', value:''},
      {id: 'updt_file', value:{}},
  ];
  const userId = $('#userId').val();

    const renderTable = (documents = [])=>{
       if(documents.length > 0){
            $('#tbl_body_documents tr.studies').remove();
            documents.map((document, i)=>{
              const status = document?.status === 'Pending' || document?.status === 'Decline' ? true : false
              const isSameToUser = document?.authors?.toLowerCase() === user.toLowerCase() ? true : false
              $('#tbl_body_documents').append(`<tr class="studies" id="${!status ? document?.status : ''}" style="background: #${document?.bg_color}">
                <td class="text-center py-3">${i + 1}</td>
                <td class="text-center py-3">${document?.title}</td>
                <td class="text-center py-3">${document?.proponent}</td>
                <td class="text-center py-3">${document?.technology_type}</td>
                <td class="text-center py-3">${document?.contact_information}</td>
                <td class="text-center py-3">${document?.file}</td>
                <td class="text-center py-3">
                  ${isSameToUser ? 'Me' : document?.authors}
                </td>
                <td class="text-center py-3">${document?.created_at}</td>
                <td class="text-center py-3" style="font-size:15px;">
                  <i title="${isSameToUser && status? 'Remove' : ''}" id="${document?.id}" style="${isSameToUser && status? 'cursor:pointer' : 'cursor:not-allowed; text-decoration: line-through'}" class="${isSameToUser && status ? 'btn_remove text-danger' : 'text-secondary'} fa fa-trash mx-2"></i>
                  <i title="${isSameToUser && status? 'Edit' : ''}" id="${document?.id}"   style="${isSameToUser && status? 'cursor:pointer' : 'cursor:not-allowed; text-decoration: line-through'}" class="${isSameToUser && status ? 'btn_edit text-secondary' : 'text-secondary'} fa fa-pencil mx-2"></i>
                </td>
              </tr>`)
            })
           $('#tbl_row_placeholder').addClass('hide')
       }else{
          $('#tbl_body_documents tr.studies').addClass('filtered')
          $('#tbl_row_placeholder').removeClass('hide')
       }
     
    }

    $(document).on('click', '.btn_remove', (event)=>{
       const { id } = event?.currentTarget
       if(id){
          $('#modal_delete').modal({
              backdrop: 'static',
              keyboard: false,            
          });
          $('#study_id').val(id)
       }
    })

    const onUpdateStudy = (arr = [])=>{
       arrOfUpdateInputs = Object.entries(arr[0]).map(([key, value])=> ({id: `updt_${key}`, value}))
      
       arrOfUpdateInputs.map(input=>{
        $(`#${input.id}`).change(event=>{
           const { id, value } = event.target
           if(id === 'updt_file'){
             const file = $(`#${id}`)[0].files
             pushToUpdateArray(id, file)
           }else{
             pushToUpdateArray(id, value)
           }
  
        })
      })
  
      $('#btn_maker_save_changes').click(()=>{
        apiType = 'update_study'
         arrOfUpdateInputs.map(input=> formData.append(input.id, input.id === 'updt_file' ? input.value[0] :input.value))
         formData.append('api', apiType)
         formData.append('rowId', $('#row_id').val())
         $.ajax({
            url: '.././api/maker.php',
            type: 'POST',
            cache:false,
            data: formData,
            processData: false,
            contentType: false,
            success: (res)=>{
              const { status_code, message } = res && JSON.parse(res)
              message_func([{status: status_code, message}])
              $('#modal_maker_edit').modal('hide')
            },
            error: (err)=>{
              message_func([{status: 501, message: err}]);
            }
         })
         
      })
    }

 

    $(document).on('click', '.btn_edit', (event)=>{
      const { id } = event?.currentTarget
      if(id){
        $('#modal_maker_edit').modal({
            backdrop: 'static',
            keyboard: false,            
        });
      }
        $('#row_id').val(id)
        apiType = 'get_study_byId';
        $.ajax({
          url: '.././api/maker.php',
          type:'POST',
          cache: false,
          data: {
            rowId: id,
            api: apiType
          },
          success: (res)=>{
            const study = res && JSON.parse(res)
            onUpdateStudy(study)
            Object.entries(study[0]).map(([key, value])=> {
               $(`#updt_${key}`).val(value)

               $('#btn_edit_file').click(()=>{
                $('#btn_edit_file').addClass('hide');
                $('#btn_edit_cancel').removeClass('hide')
                $('#updt_file').removeAttr('readonly')
                $('#updt_file').attr('type', 'file')
              })

              $('#btn_edit_cancel').click(()=>{
                $('#btn_edit_cancel').addClass('hide');
                $('#btn_edit_file').removeClass('hide')
                $('#updt_file').attr('readonly', true)
                $('#updt_file').attr('type', 'text')
                $('#updt_file').val(study[0]?.file)
              })

              $('#btn_maker_cancel_delete').click(()=>{
                $('#btn_edit_cancel').addClass('hide');
                $('#btn_edit_file').removeClass('hide')
                $('#updt_file').attr('readonly', true)
                $('#updt_file').attr('type', 'text')
                $('#updt_file').val(study[0]?.file)
              })
            })

          },
          error: (err)=>{
            message_func([{status: 501, message: err}]);
          }
        })
    })

   

    const fetchStudies = (api)=>{
       $.ajax({
          url: '.././api/maker.php',
          type:'POST',
          cache: false,
          data: {api},
          success: (res)=>{
            arrOfDocuments = res && JSON.parse(res)
            renderTable(arrOfDocuments);
          },
          error: (err)=>{
            message_func([{status: 501, message: err}]);
          }
       })
    }

    fetchStudies('get_record_studies');
    setInterval(()=> {
      if($('#textfield_document_type').val()){
        return;
      }else{
        fetchStudies('get_record_studies');
      }
    }, 1000)

    $('#document_type').change(event=>{
        const { value } = event?.target

        if(value?.toLowerCase() === 'all'){
           renderTable(arrOfDocuments)
        }else{
            const filterByDocumentType = arrOfDocuments.filter(document=> document?.doc_type === value)
           renderTable(filterByDocumentType)
        }
    })

    $('#textfield_document_type').change(event=>{
       const { value } = event?.target
       if(!value){
             renderTable(arrOfDocuments)
       }else{
          const filterDocument = arrOfDocuments.filter(document => JSON.stringify(document).toLowerCase().match(value?.toLowerCase()))
           renderTable(filterDocument);
       }
    })

    $('#btn_new_document').click(()=>{
        $('#modal_document').modal({
            backdrop: 'static',
            keyboard: false,            
       });
    })

    const validationMessage = (id, value, status, message) => {
        if (status === 400) {
          switch (id) {
            case "doc_title": {
                if (!value) {
                  return {
                    id,
                    message: `Document Title is required.`,
                  };
                } else {
                  return false;
                }
            }
            case "technology_type": {
                if (!value) {
                  return {
                    id,
                    message: `Type of Technology is required.`,
                  };
                } else {
                  return false;
                }
            }
            case "intellectual_property": {
                if (!value) {
                  return {
                    id,
                    message: `Intellectual Property is required.`,
                  };
                } else {
                  return false;
                }
            }
            case "contact_info": {
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
                } else {
                  return false;
                }
            }
            case "file": {
                if (Object.entries(value).length <= 0) {
                  return {
                    id,
                    message: `Please select a file.`,
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
        }else if(status === 200 && message){
          return {
            status,
            message
          };
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
        timeOut = messages.length > 2 ? 4300 : 2500
        messages.map((e) => {
          spanElement = document.createElement("span");
          if (e?.status !== 200) {
            if(e?.message){
              isSubmit = true;
              spanElement.innerText = e?.message;
              spanElement.className = "error";
              messageContainer.addClass("error");
              messageContainer.append(spanElement);

              setTimeout(() => {
                messageContainer.removeClass("error");
                isSubmit = false;
              }, [timeOut]);
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
            }, [timeOut]);
          }
  
          setTimeout(() => messageContainer.children().remove(), timeOut);
        });
      }

    const pushToArray = (id, value) => {
        const newValue = { id, value };
        const isExist = arrOfInputs.find((arr) => arr?.id === id);
    
        if (isExist) {
          arrOfInputs = arrOfInputs.map((arr) =>
            arr?.id === id ? { ...arr, value } : arr
          );
        } else {
          arrOfInputs.push(newValue);
        }
      };

      const pushToUpdateArray = (id, value) => {
        const newValue = { id, value };
        const isExist = arrOfUpdateInputs.find((arr) => arr?.id === id);
    
        if (isExist) {
          arrOfUpdateInputs = arrOfUpdateInputs.map((arr) =>
            arr?.id === id ? { ...arr, value } : arr
          );
        } else {
          arrOfUpdateInputs.push(newValue);
        }
      };

    arrOfInputs.map((arr)=>{
        $(`#${arr.id}`).change(event=>{
          validationResult = [];
          const { id, value } = event?.target
          return pushToArray(id, value)
       })
    })
    
    $('#btn_maker_save').click(()=>{
        apiType = 'add_new_study'
        let file = $('#file')[0].files;
        pushToArray('file', file)
        const created_at = moment(new Date()).format('MMMM DD, y')
       
        messages = [...validator()];
        const hasNoError = messages.filter((res) => !!res?.message)

        if (isSubmit) return;
        if(hasNoError.length){
            message_func(messages);
        }else{
           arrOfInputs.map(arr=> arr.id !== 'file' ? formData.append(`${arr.id}`, arr?.value): formData.append(`${arr.id}`, arr?.value[0]))
           formData.append('api', apiType)
           formData.append('created_at', created_at)
           formData.append('userId', userId)
          
            $.ajax({
                url: '.././api/maker.php',
                type: 'POST',
                cache:false,
                data:formData,
                processData:false,
                contentType: false,
                success: (res)=>{
                    const { status_code, message } = res && JSON.parse(res);
                    // arrOfInputs = arrOfInputs.map((arr, i)=> i > 0 ? {...arr, value: ''} : arr)
                    arrOfInputs.map(arr=> $(`#${arr.id}`).val(''))
                    message_func([validationMessage('', '', status_code, message)])
                    $('#modal_document').modal('hide');
                    fetchStudies('get_record_studies');
                },
                error: (err)=> message_func([{status: 501, message: err}])
            })

        }
    })

    $('#btn_maker_delete').click(()=>{
        apiType = 'remove_study';
        $.ajax({
          url: '.././api/maker.php',
          type: 'POST',
          cache:false,
          data:{
            rowId:$('#study_id').val(),
            api:apiType
          },
          success:(res)=>{
            const { status_code, message } = res && JSON.parse(res)
            message_func([{status: status_code, message}]);
            $('#modal_delete').modal('hide')
          },
          error: (err)=>{
            message_func([{status: 501, message: err}]);
          }
        })
    })
})