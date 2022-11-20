$(document).ready(()=>{
    let apiType = '';
    let formData = new FormData()
    let arrOfStudies = [];
    const baseURL = '../uploads/';
    const type_of_technology = $('#type_of_technology').val()
    const imageExt = ['jpg', 'jpeg', 'png', 'tiff', 'gif']
    let isFiltered = false;
    let hasError = false;
    let isSubmit = false
    let isEmptyFile = false;
    let isFileExist = false;
    let arrOfInputFiles = [
      {id: 'formality', value: ''},
      {id: 'acknowledgement', value: ''},
      {id: 'withdrawal', value: ''},
      {id: 'publication', value: ''},
      {id: 'certification', value: ''},
      {id: 'log_submission', value: ''},
      {id: 'response', value: ''},
    ];
    const userId = $('#user_id').val()

    const renderTable = (studies = [])=>{
        if(studies.length > 0){
            $('#tbl_body_drafter_studies tr.studies').remove();
            studies.map((study, i)=>{
              $('#tbl_body_drafter_studies').append(`<tr class="studies">
                <td class="text-center py-3">${i + 1}</td>
                <td class="text-center py-3">${study?.title}</td>
                <td class="text-center py-3">${study?.proponent}</td>
                <td class="text-center py-3">${study?.technology_type}</td>
                <td class="text-center py-3">${study?.contact_information}</td>
                <td class="text-center py-3">${study?.file}</td>
                <td class="text-center py-3">${study?.authors}</td>
                <td class="text-center py-3">${study?.created_at}</td>
                <td class="text-center py-3" style="font-size:14px;">
                    <a href='#' class="btn_view" id="${study?.file}" style='text-decoration:none;'>
                        <i title="View" class="fa fa-external-link mx-2 text-secondary"></i>
                    </a>
                    <a href='../uploads/${study?.file}' download style='text-decoration:none;'>
                        <i title="Download" class="fa fa-download mx-2 text-primary"></i>
                    </a>
                    <i title="Accept" id="${study?.id}" class="btn_accept fa fa-check mx-2 text-success" data-toggle="modal" data-backdrop="static" data-keyboard="false"></i>
                    <i title="Decline" id="${study?.id}" class="btn_decline fa fa-times mx-2 text-danger" data-toggle="modal" data-backdrop="static" data-keyboard="false"></i>
                    <i title="Comments" class="fa fa-comments text-info mr-2"></i>
                    <i title="Edit" class="fa fa-pencil text-warning"></i>
                </td>
              </tr>`)
            })
          $('#tbl_row_placeholder').addClass('hide')
       }else{
          $('#tbl_body_drafter_studies tr.studies').addClass('filtered')
          $('#tbl_row_placeholder').removeClass('hide')
       }
     
    }

    const getListOfStudies = (api)=>{
       $.ajax({
          url: '.././api/drafter.php',
          type: 'POST',
          cache:false,
          data: {
            api,
            status: 'Pending',
            technology_type: type_of_technology
          },
          success: (res)=>{
            arrOfStudies = res && JSON.parse(res);
            renderTable(arrOfStudies)
          },
          error: (err)=>{
            console.log(`Error`, err);
          }
       })
    }

    getListOfStudies('get_list_of_studies');

    $('#filter_by_date').change(event=>{
        const { value } = event?.target
        const date = moment(value).format('MMMM DD, y')
        const filterByDate = arrOfStudies.filter(studies=> studies?.created_at === date)
        isFiltered = true;
        renderTable(filterByDate)
    })

    $('#input_anything').change(event=>{
      const { value } = event?.target
      const inputFiltered = arrOfStudies.filter(studies=> JSON.stringify(studies).toLowerCase().match(value?.toLowerCase()))
      isFiltered = true;
      renderTable(inputFiltered)
    })
    
    $(document).on('click', '.btn_view', (event)=>{
        const { id } = event?.currentTarget
        const [_fileName, ext] = id?.split('.')

        if(imageExt.includes(ext) || ext === 'pdf'){
            window.open(`${baseURL}${id}`);
        }else{
            // window.open(`${baseURL}${id}`);
        }
    })

    $(document).on('click', '.btn_accept', (event)=>{
      const { id } = event?.currentTarget
      $('#maker_id').val(id)
      $('#maker_id').val(id)
        $('#modal_accept').modal({
            backdrop: 'static',
            keyboard: false,            
       });
    })

    $(document).on('click', '.btn_decline', ()=>{
        $('#modal_decline').modal({
            backdrop: 'static',
            keyboard: false,            
       });
    })

    const message_func = (messages = []) => {
      const messageContainer = $("#message-container");
      timeOut = 3500
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

    const validationMessage = (_id, _value, status, message) => {
      if (status === 400) {
          return {
            message: message ?? `An error occur in saving data.`,
          };
      }else{
        return {
          message: message ?? `An error occur in saving data.`,
        };
      }
    };

    const pushToArray = (id, value) => {
      const newValue = { id, value };
      const isExist = arrOfInputFiles.find((arr) => arr?.id === id);
      isFileExist = arrOfInputFiles.find(arr => arr.value[0]?.name === value[0]?.name)
      isEmptyFile = false;
      if(isFileExist){
          $(`#label_wrapper span#${id}`).removeClass('hide')
          $(`.input_wrapper > input#${id}`).addClass('border-danger')
          hasError = true
      }else{
        if (isExist) {
          arrOfInputFiles = arrOfInputFiles.map((arr) =>
            arr?.id === id ? { ...arr, value } : arr
          );
        } else {
          arrOfInputFiles.push(newValue);
        }
        $(`#label_wrapper span#${id}`).addClass('hide')
        $(`.input_wrapper > input#${id}`).removeClass('border-danger')
        hasError = false
      }
    };

    const saveDocument = (api)=>{
        const getFile = arrOfInputFiles.find(files=> files.id === api)
        formData.append(getFile?.id, getFile?.value[0])
        formData.append('api', api)
        formData.append('patent_id', $('#user_id').val())
        formData.append('maker_id', $('#maker_id').val())
        formData.append('status', 'Accept')
        formData.append('color', 'a5ffc5')

        $.ajax({
          url: '.././api/drafter.php',
          type: 'POST',
          cache: false,
          data: formData,
          processData: false,
          contentType: false,
          success: (res)=>{
            console.log(res, `res`);
          },
          error: (err)=>{
            console.log(`Error`, err);
          }
        })
    }

    arrOfInputFiles.map(input=>{
      $(`.input_wrapper > input#${input.id}`).change((event)=>{
          const { id } = event?.target
          const file =  $(`.input_wrapper input#${input.id}`)[0].files;
          isFileExist = false;
          $(`.input_wrapper .icon_wrapper i.btn_save#${input.id}`).removeClass('disable')
          pushToArray(id, file)
      })

      $(`.input_wrapper .icon_wrapper i.btn_save#${input.id}`).click((event)=>{
          const { id } = event?.currentTarget
          const dataTitle = $(`.input#${input.id}`).attr('data-title')

          if(hasError) return
          $(`.input#${input.id}`).addClass('hide')
          $('#notification').removeClass('hide');
          $(`#notification_message`).text(`${dataTitle} is now successfully added.`)
          $('#btn_done_accept_modal').removeAttr('disabled');
          $('#btn_close_accept_modal').prop('disabled', true)
          saveDocument(id)

          setTimeout(()=> $('#notification').addClass('hide'), 3200)
      })

      $(`.input_wrapper .icon_wrapper i.btn_cancel#${input.id}`).click((event)=>{
          const { id } = event?.currentTarget
          $(`.input_wrapper > input#${id}`).val('')
          $(`#label_wrapper span#${id}`).addClass('hide')
          $(`.input_wrapper > input#${id}`).removeClass('border-danger')
          const value =  $(`.input_wrapper > input#${id}`).val()

          if(value){
            $(`.input_wrapper .icon_wrapper i.btn_save#${id}`).removeClass('disable')
          }else{
            $(`.input_wrapper .icon_wrapper i.btn_save#${id}`).addClass('disable')
          }
         
      })

      $('#btn_close_accept_modal').click(()=>{
          arrOfInputFiles.map(files=>{
            $(`.input_wrapper > input#${files.id}`).val('')
            $(`#label_wrapper span#${files.id}`).addClass('hide')
            $(`.input_wrapper > input#${files.id}`).removeClass('border-danger')
            $(`.input_wrapper .icon_wrapper i.btn_save#${files.id}`).addClass('disable')
            
          })
      })
    })

    $('#btn_done_accept_modal').click(()=>{
      getListOfStudies('get_list_of_studies');
    })

    $('#btn_cancel_accept').click(()=>{
       $('#feedback').val('')
    })
})