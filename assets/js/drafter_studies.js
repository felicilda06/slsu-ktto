$(document).ready(()=>{
    let apiType = '';
    let arrOfStudies = [];
    let formData = new FormData()
    let arrOfDocuments = [
      {id: 'formality_result', value: {}},
      {id: 'acknowledgement_receipt', value: {}},
      {id: 'notice_of_withdrawal', value: {}},
      {id: 'notice_of_publication', value: {}},
      {id: 'certification', value: {}},
      {id: 'log_submission_status', value: {}},
      {id: 'response', value: {}},
      {id: 'drafted_documents', value: {}}
    ]
    const type_of_technology = $('#type_of_technology').val()
    const patent_id = $('#patent_id').val()
    const userName = $('#user_name').val()

    const renderTable = (studies = [])=>{
      $('#tbl_drafter_studies tr.studies').remove();
       if(studies.length > 0){
         studies.map((study, i)=>{
                $('#tbl_drafter_studies').append(`<tr class="studies">
                <td class="text-center py-3">${i + 1}</td>
                <td class="text-center py-3">${study?.title}</td>
                <td class="text-center py-3">${study?.proponent}</td>
                <td class="text-center py-3">${study?.technology_type}</td>
                <td class="text-center py-3">${study?.contact_information}</td>
                <td class="text-center py-3">${study?.intellectual_property}</td>
                <td class="text-center py-3">${study?.college}</td>
                <td class="text-center py-3">${study?.file}</td>
                <td class="text-center py-3">${study?.authors}</td>
                <td class="text-center py-3">${study?.created_at}</td>
                <td class="text-center py-3">${study?.status}</td>
                <td class="text-center py-3 align-items-center" style="font-size:14px;">
                    <i title="Edit" id="${study?.id}" user-id="${study?.userId}" class="btn_drafter_studies_edit fa fa-pencil-square-o mx-2 text-info" data-toggle="modal" data-backdrop="static" data-keyboard="false"></i>
                </td>
            </tr>`)
            $('#tbl_row_placeholder').addClass('hide')
         })
       }else{
          $('#tbl_body_documents tr.studies').addClass('filtered')
          $('#tbl_row_placeholder').removeClass('hide')
       }
    }

    const getAcceptedStudies = (api)=>{
        $.ajax({
            url: '.././api/drafter.php',
            type: 'POST',
            cache:false,
            data: {
              api,
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

   getAcceptedStudies('accepted_studies');
   setInterval(()=> {
     if($('#filter_input_accepted').val() || $('#filter_date_accepted').val()){
      return;
     }else{
      getAcceptedStudies('accepted_studies')
     }
   }, 3800);

   const pushToArray = (id, value) => {
    const newValue = { id, value };
    const isExist = arrOfDocuments.find((arr) => arr?.id === id);

    if (isExist) {
      arrOfDocuments = arrOfDocuments.map((arr) =>
        arr?.id === id ? { ...arr, value } : arr
      );
    } else {
      arrOfDocuments.push(newValue);
    }
  };

    $(document).on('click', '.btn_drafter_studies_edit', (event)=>{
        apiType = 'get_list_of_document_by_id'
        const { id } = event?.currentTarget
        $('#modal_drafter_update_doc_modal').modal({
            backdrop: 'static',
            keyboard: false,            
       });
       $('#maker_id_update_studies').val(id)

       $.ajax({
        url: '.././api/drafter.php',
        type: 'POST',
        cache:false,
        data: {
          rowId: id,
          api: apiType,
        },
        success: (res)=>{
          const documents = res && JSON.parse(res)
          console.log(documents);
          Object.entries(documents[0] ?? []).map(([key, value])=>{
             $(`.input_wrapper > input#${key}`).val(value)
             $(document).on('click', `.fa-pencil#${key}`, (event)=>{
                const { id } = event?.currentTarget
                $(`.input_wrapper > input#${id}`).removeAttr('readonly')
                $(`.input_wrapper > input#${id}`).attr('type', 'file')
                $(`.input_wrapper .icon_wrapper#${id}`).removeClass('hide')
                $(`.input_wrapper .fa-pencil#${id}`).addClass('hide')
             })

             $(document).on('click', `.btn_cancel#${key}`, (event)=>{
                const { id } = event?.currentTarget
                $(`.input_wrapper > input#${id}`).attr('readonly', true)
                $(`.input_wrapper > input#${id}`).attr('type', 'text')
                $(`.input_wrapper > input#${key}`).val(value)
                $(`.input_wrapper .fa-pencil#${id}`).removeClass('hide')
                $(`.input_wrapper .icon_wrapper#${id}`).addClass('hide')
                $(`.btn_save#${key}`).addClass('disable')
             })

             $(document).on('click', `.btn_save#${key}`, (event)=>{
                const { id } = event?.currentTarget
                const getFile = arrOfDocuments.find(doc=> doc.id === id)
                formData.append('api', getFile.id === 'certification' ||  getFile.id === 'response' ? `updt_${getFile.id}` : `updt_${getFile.id}`)
                formData.append(getFile.id, getFile.value[0])
                formData.append('maker_id',  $('#maker_id_update_studies').val())
                formData.append('patent_id', patent_id)
                formData.append('senderName', userName)
                formData.append('createdAt', moment(new Date()).format('MMMM D, y hh:mm:ss'))
                const fileName = `${getFile.id}_${$('#maker_id_update_studies').val()}_${getFile.value[0]?.name}`;
                $.ajax({
                  url: '.././api/drafter.php',
                  type: 'POST',
                  cache:false,
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: (_res)=>{
                    console.log(_res);
                      $('#notification').removeClass('hide');
                      $('#notification_message').text('Document Successfully Updated.');
                      $(`.input_wrapper > input#${id}`).attr('readonly', true)
                      $(`.input_wrapper > input#${id}`).attr('type', 'text')
                      $(`.input_wrapper > input#${id}`).val(fileName)
                      $(`.input_wrapper .fa-pencil#${id}`).removeClass('hide')
                      $(`.input_wrapper .icon_wrapper#${id}`).addClass('hide')
                      
                      $('#btn_drafer_upload_done').removeAttr('disabled')
                      setTimeout(()=>  $('#notification').addClass('hide'), 3000)
                  },
                  error: (err)=>{
                    console.log(`Error`, err);
                  }
                })
             })
          })
         
        },
        error: (err)=>{
          console.log(`Error`, err);
        }
     })        
    })

    $('#btn_drafer_cancel_update_doc').click(()=>{
      $(`.input_wrapper .fa-pencil`).removeClass('hide')
      $(`.input_wrapper .icon_wrapper`).addClass('hide')
      $(`.input_wrapper > input`).attr('readonly', true)
      $(`.input_wrapper > input`).attr('type', 'text')
      $(`.btn_save`).addClass('disable')
      arrOfDocuments.map(doc=> $(`.input_wrapper > input#${doc.id}`).val(''))
    })

    arrOfDocuments.map(doc=>{
      $(`.input_wrapper > input#${doc.id}`).change((event)=>{
         const file = $(`.input_wrapper > input#${doc.id}`)[0].files
        
         if(file){
           $(`.btn_save#${doc.id}`).removeClass('disable')
         }
         pushToArray(event?.currentTarget.id, file)
      })
    })

    $('#filter_input_accepted').change(event=>{
       const { value } = event?.target

       if(value){
         const filterByInput = arrOfStudies.filter(studies=> JSON.stringify(studies)?.toLowerCase().match(value?.toLowerCase()))
         renderTable(filterByInput);
       }else{
         renderTable(arrOfStudies);
       }
    })

    $('#filter_date_accepted').change(event=>{
      const { value } = event?.target
      const date = moment(value).format('MMMM d, y')

      if(value){
        const filterByDate = arrOfStudies.filter(studies=> studies?.created_at === date)
        renderTable(filterByDate);
      }else{
        renderTable(arrOfStudies);
      }
   })
})