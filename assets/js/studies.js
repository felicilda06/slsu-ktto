$(document).ready(()=>{
    let apiType = '';
    let arrOfDocuments = [];
    let arrOfInputs = [
        {id: 'tbl_document_type', value:''},
        {id: 'doc_title', value:''},
        {id: 'proponent', value:''},
        {id: 'technology_type', value:''},
        {id: 'contact_info', value:''},
        {id: 'file', value:{}},
    ];
    let validationResult = [];
    let spanElement;
    let timeOut;
    let messages = [];
    let isSubmit = false;

    const renderTable = (documents = [])=>{
       if(documents.length > 0){
            $('#tbl_body_documents').empty();
            documents.map(document=> $('#tbl_body_documents').append(`<tr>
            <td>${document.id}</td>
            <td>${document.title}</td>
            <td>${document.author}</td>
            <td>${document.docType}</td>
            <td>${document.date_created}</td>
            </tr>`))
       }
    }

    if(arrOfDocuments.length <= 0){
        $('#tbl_row_placeholder').removeClass('hide')
    }else{
        renderTable(arrOfDocuments);
    }

    $('#document_type').change(event=>{
        const { value } = event?.target

        if(value?.toLowerCase() === 'all'){
            renderTable(arrOfDocuments)
        }else{
            const filterByDocumentType = arrOfDocuments.filter(document=> document.docType === value)
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
            case "tbl_document_type": {
              if (!value) {
                return {
                  id,
                  message: `Document Type is required.`,
                };
              } else {
                return false;
              }
            }
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
            case "contact_info": {
                if (!value) {
                  return {
                    id,
                    message: `Contact Information is required.`,
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

    arrOfInputs.map((arr)=>{
       $(`#${arr.id}`).change(event=>{
            const { id, value } = event?.target
            pushToArray(id, value)
       })
    })
    
    $('#btn_maker_save').click(()=>{
        apiType = 'add_new_study'
        let formData = new FormData()
        let file = $('#file')[0].files;
        pushToArray('file', file)
       
        messages = [...validator()];
        const hasNoError = messages.filter((res) => !!res?.message)

        if (isSubmit) return;
        if(hasNoError.length){
            message_func(messages);
        }else{
           arrOfInputs.map(arr=> arr.id !== 'file' ? formData.append(`${arr.id}`, `${arr.value}`): formData.append(`${arr.id}`, arr.value[0]))
           formData.append('api', apiType)
          
            $.ajax({
                url: '.././api/drafter.php',
                type: 'POST',
                cache:false,
                data:formData,
                processData:false,
                contentType: false,
                success: (res)=>{
                    arrOfInputs = arrOfInputs.map((arr, i)=> i > 0 ? {...arr, value: ''} : arr)
                    arrOfInputs.map(arr=> $(`#${arr.id}`).val(''))
                    $('#modal_document').modal('hide');
                },
                error: (err)=> console.log(`Error: ${err}`)
            })


        }
    })

})