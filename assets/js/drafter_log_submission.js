$(document).ready(()=>{
   const spreadSheetId = '1IyuIohoxUs-5917-B_MtoXEy5YD29UvyaT13MTNYfQM';
   const gid = '1415776155';
   const url = `https://docs.google.com/spreadsheets/d/${spreadSheetId}/gviz/tq?tqx=out:json&tq&gid=${gid}`;
   const technology_type = $('#technology_type').val()
   let formData= new FormData()
   let apiType = ''
   let arrOfLogFields = [
    {id: 'application_no', value: ''},
    {id: 'title', value: ''},
    {id: 'creator', value: ''},
    {id: 'ip_type', value: ''},
    {id: 'college', value: ''},
    {id: 'dragon_pay', value: ''},
    {id: 'application_date', value: ''},
    {id: 'agent', value: ''},
    {id: 'drafter', value: ''},
    {id: 'document_where_about', value: ''},
    {id: 'publication_date', value: ''},
    {id: 'publication_vol', value: ''},
    {id: 'publication_no', value: ''},
    {id: 'registration_date', value: ''},
    {id: 'registration_date_vol', value: ''},
    {id: 'registration_date_no', value: ''},
    {id: 'examiner', value: ''},
    {id: 'status', value: ''},
    {id: 'remark_1', value: ''},
    {id: 'remark_2', value: ''},
    {id: 'office_remark', value: ''},
    {id: 'action_step_1', value: ''},
    {id: 'action_step_2', value: ''},
    {id: 'certificate_office', value: ''},
  ]
  let arrOfUpdateDataLogFields = [
    {id: 'updt_application_no', value: ''},
    {id: 'updt_title', value: ''},
    {id: 'updt_creator', value: ''},
    {id: 'updt_ip_type', value: ''},
    {id: 'updt_college', value: ''},
    {id: 'updt_dragon_pay', value: ''},
    {id: 'updt_application_date', value: ''},
    {id: 'updt_agent', value: ''},
    {id: 'updt_drafter', value: ''},
    {id: 'updt_document_where_about', value: ''},
    {id: 'updt_publication_date', value: ''},
    {id: 'updt_publication_vol', value: ''},
    {id: 'updt_publication_no', value: ''},
    {id: 'updt_registration_date', value: ''},
    {id: 'updt_registration_date_vol', value: ''},
    {id: 'updt_registration_date_no', value: ''},
    {id: 'updt_examiner', value: ''},
    {id: 'updt_status', value: ''},
    {id: 'updt_remark_1', value: ''},
    {id: 'updt_remark_2', value: ''},
    {id: 'updt_office_remark', value: ''},
    {id: 'updt_action_step_1', value: ''},
    {id: 'updt_action_step_2', value: ''},
    {id: 'updt_certificate_office', value: ''}
  ]

   let arrOfLogs = []
   const statusColor = [
     {status: 'Registered', color:'#c7fdb5'}, //green
     {status: 'Under Substantive Examination', color:'#2e6bde'}, //blue
     {status: 'Under Formality Examination', color:'#e4e4e4'}, // gray
     {status: 'Published', color:'#83f0fb'}, //lightBlue
     {status: 'Forfeited', color:'#fbafa3'} // red
   ]

   const renderTable = (logs = [], activeRow)=>{
    $('#tbl_body_drafter_log  tr.fetch_logs').remove();
     if(logs.length > 0){
        logs.map((log, i)=> {
            const color = statusColor.find(stat=> stat.status ===log?.status)?.color
            $('#tbl_body_drafter_log').append(`<tr key="${i}" id="${log?.id}" class='fetch_logs ${log?.id === activeRow ? 'selected': ''}' style="background: ${color};">
                <td class="text-center py-4 px-3">${i + 1}</td>
                <td class="text-center py-4 px-3">${log?.application_no}</td>
                <td class="text-center py-4 px-3">${log?.title}</td>
                <td class="text-center py-4 px-3">${log?.creator}</td>
                <td class="text-center py-4 px-3">${log?.ip_type}</td>
                <td class="text-center py-4 px-3">${log?.college}</td>
                <td class="text-center py-4 px-3">${log?.dragon_pay}</td>
                <td class="text-center py-4 px-3">${log?.application_date}</td>
                <td class="text-center py-4 px-3">${log?.agent}</td>
                <td class="text-center py-4 px-3">${log?.drafter}</td>
                <td class="text-center py-4 px-3">${log?.document_where_about}</td>
                <td class="text-center py-4 px-3">${log?.publication_date}</td>
                <td class="text-center py-4 px-3">${log?.publication_vol}</td>
                <td class="text-center py-4 px-3">${log?.publication_no}</td>
                <td class="text-center py-4 px-3">${log?.registration_date}</td>
                <td class="text-center py-4 px-3">${log?.registration_date_vol}</td>
                <td class="text-center py-4 px-3">${log?.registration_date_no}</td>
                <td class="text-center py-4 px-3">${log?.examiner}</td>
                <td class="text-center py-4 px-3">${log?.status}</td>
                <td class="text-center py-4 px-3">${log?.remark_1}</td>
                <td class="text-center py-4 px-3">${log?.remark_2}</td>
                <td class="text-center py-4 px-3">${log?.office_remark}</td>
                <td class="text-center py-4 px-3">${log?.action_step_1}</td>
                <td class="text-center py-4 px-3">${log?.action_step_2}</td>
                <td class="text-center py-4 px-3">${log?.certificate_office}</td>
            </tr>`)
        })
        $('#tbl_row_placeholder').addClass('hide')
     }else{
        $('#tbl_row_placeholder').removeClass('hide')
     }
   }

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

  const getStudiesWithNoLogSubmission = (techType)=>{
    apiType = 'get_studies_with_no_log_submission';
    $.ajax({
      url: '.././api/drafter.php',
      type:'POST',
      cache: false,
      data: {
          api: apiType,
          technology_type: techType
      },
      success: (res)=>{
        const studies = res && JSON.parse(res)
        $('#title .render_option').remove()
        studies?.map((study, i)=>{
           $('#title').append(`
              <option key="${i}" email="${study?.authors}" class="render_option" value="${study?.title}">${study?.title}</option>
           `)
        })
      },
      error: (err)=>{
        console.log(`Error`, err);
      }
    })
  }

   $(document).on('click', '#tbl_body_drafter_log  tr.fetch_logs', event=>{
      const { id } = event?.currentTarget
      const rowId = { id: 'updt_id', value: id }
      arrOfUpdateDataLogFields.unshift(rowId)
      $('#modal_drafter_log_update').modal({
        backdrop: 'static',
        keyboard: false,            
      });
     
      apiType = 'get_data_of_log_submission'
      $.ajax({
        url: '.././api/drafter.php',
        type:'POST',
        cache: false,
        data: {
            id,
            api: apiType
        },
        success: (res)=>{
           const getData = res && JSON.parse(res)
           Object.entries(getData[0]).map(([key, value])=> {
             $(`#updt_${key}`).val(value)
              
              if($(`#updt_title`).val()){
                $('#btn_drafter_next_update_log').removeAttr('disabled')
              }
           })
        },
        error: (err)=>{
            console.log(`Error`, err);
        }
      })
      getListOfLogSubmission(id)

   })

    $('#btn_drafter_next_update_log').click(event=>{
        if(event?.currentTarget?.innerText === 'Next'){
            $('#updt_form_log_2').removeClass('hide')
            $('#updt_form_log_1').addClass('hide')
            $('#btn_drafter_next_update_log').text('Save Changes')
            $('#btn_drafter_next_update_log').css('border', 'none')
            $('#btn_drafter_cancel_update_log').addClass('bg-secondary')
            $('#btn_drafter_cancel_update_log').removeClass('bg-danger')
            $('#btn_drafter_cancel_update_log').css('border', 'none')
            $('#btn_drafter_cancel_update_log').text('Previous')
            $('#btn_drafter_cancel_update_log').removeAttr('data-dismiss')
        }else{
           apiType = 'update_log_submission'
           arrOfUpdateDataLogFields.map(fields=> formData.append(fields?.id, fields?.value ?? ''))
           formData.append('api', apiType)
            $.ajax({
                url: '.././api/drafter.php',
                type:'POST',
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                success: (res)=>{
                    const response = res && JSON.parse(res)
                    getListOfLogSubmission(undefined)
                    $('#modal_drafter_log_update').modal('hide');
                    $('#btn_drafter_next_update_log').text('Next')
                    $('#updt_form_log_2').addClass('hide')
                    $('#updt_form_log_1').removeClass('hide')
                    $('#btn_drafter_cancel_update_log').text('Cancel')
                    $('#btn_drafter_cancel_update_log').addClass('bg-danger')
                    $('#btn_drafter_cancel_update_log').removeClass('bg-secondary')
                    message_func([{...response, status: response?.status_code}])
                },
                error: (err)=>{
                    console.log(`Error`, err);
                }
            })
        }
    })

    $('#btn_drafter_cancel_update_log').click(event=>{
        const { innerText } = event?.currentTarget
        if(innerText === 'Previous'){
           $('#btn_drafter_cancel_update_log').text('Cancel')
           $('#btn_drafter_cancel_update_log').removeClass('bg-secondary')
           $('#btn_drafter_cancel_update_log').addClass('bg-danger')
           $('#updt_form_log_2').addClass('hide')
           $('#updt_form_log_1').removeClass('hide')
           $('#btn_drafter_next_update_log').text('Next')
        }else{
            $('#btn_drafter_cancel_update_log').attr('data-dismiss', 'modal')
            arrOfUpdateDataLogFields = arrOfUpdateDataLogFields.filter((_fields, i)=> i > 0)
            setTimeout(()=> getListOfLogSubmission(undefined), 275)
        }
    })

   getListOfLogSubmission = (activeRow)=>{
      apiType = 'get_list_of_log_submission'
      $.ajax({
        url: '.././api/drafter.php',
        type:'POST',
        cache: false,
        data: {
            api: apiType
        },
        success: (res)=>{
            arrOfLogs = res && JSON.parse(res)
            renderTable(arrOfLogs, activeRow);
        },
        error: (err)=>{
            console.log(`Error`, err);
        }
      })
   }

   getListOfLogSubmission(undefined)
   

   $('#btn_drafter_new_log').click(()=>{
        $('#modal_drafter_log').modal({
            backdrop: 'static',
            keyboard: false,            
        });
        if(technology_type){
          getStudiesWithNoLogSubmission(technology_type)
          return
        }else{
          getStudiesWithNoLogSubmission('')
        }
   })

   $('#btn_drafter_next_log').click(event=>{
        const { innerText } = event?.currentTarget
        if(innerText === 'Next'){
            $('#form_log_2').removeClass('hide')
            $('#form_log_1').addClass('hide')
            $('#btn_drafter_next_log').text('Submit')
            $('#btn_drafter_cancel_log').text('Previous')
            $('#btn_drafter_cancel_log').removeClass('btn-danger')
            $('#btn_drafter_cancel_log').addClass('btn-secondary')
            $('#btn_drafter_cancel_log').removeAttr('data-dismiss')
        }else{
            apiType = 'insert_new_log_submission'
            arrOfLogFields.map(field => formData.append(field.id, field.value ?? '' ))
            formData.append('api', apiType)

            $.ajax({
                url: '.././api/drafter.php',
                type:'POST',
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                success: (res)=>{
                    const { status_code, message } = res && JSON.parse(res)
                    getListOfLogSubmission();
                    $('#modal_drafter_log').modal('hide');
                    arrOfLogFields.map(field=> $(`#${field.id}`).val(''))
                    message_func([{status: status_code, message}])
                    $('#form_log_2').addClass('hide')
                    $('#form_log_1').removeClass('hide')
                    $('#btn_drafter_next_log').text('Next')
                    $('#btn_drafter_cancel_log').text('Cancel')
                    $('#btn_drafter_cancel_log').addClass('btn-danger')
                    $('#btn_drafter_cancel_log').removeClass('btn-secondary')
                    $('#btn_drafter_cancel_log').attr('data-dismiss', true)
                    $('#btn_drafter_next_log').attr('disabled', true)
                    if(technology_type){
                      getStudiesWithNoLogSubmission(technology_type)
                      return
                    }else{
                      getStudiesWithNoLogSubmission('')
                    }
                },
                error: (err)=>{
                    console.log(`Error`, err);
                }
            })
        }
   })

   $('#btn_drafter_cancel_log').click(event=>{
        const { innerText } = event?.currentTarget
        if(innerText === 'Previous'){
            $('#form_log_2').addClass('hide')
            $('#form_log_1').removeClass('hide')
            $('#btn_drafter_next_log').text('Next')
            $('#btn_drafter_cancel_log').text('Cancel')
            $('#btn_drafter_cancel_log').addClass('btn-danger')
            $('#btn_drafter_cancel_log').removeClass('btn-secondary')
        }else{
            $('#btn_drafter_cancel_log').attr('data-dismiss', 'modal')
            arrOfLogFields.map(field=> $(`#${field.id}`).val(''))
        }
   })

   const pushToArray = (id, value) => {
    const newValue = { id, value };
    const isExist = arrOfLogFields.find((arr) => arr?.id === id);

    if (isExist) {
        arrOfLogFields = arrOfLogFields.map((arr) =>
        arr?.id === id ? { ...arr, value } : arr
      );
    } else {
        arrOfLogFields.push(newValue);
    }
  };

    const pushToUpdtArray = (id, value) => {
        const newValue = { id, value };
        const isExist = arrOfUpdateDataLogFields.find((arr) => arr?.id === id);

        if (isExist) {
            arrOfUpdateDataLogFields = arrOfUpdateDataLogFields.map((arr) =>
            arr?.id === id ? { ...arr, value } : arr
        );
        } else {
            arrOfUpdateDataLogFields.push(newValue);
        }
    };


   arrOfLogFields.map(field=>{
      $(`#${field.id}`).change(event=>{
         const { id, value } = event?.target
         const val = $(`#${field.id}`).attr('type') === 'date' ? moment(value).format('MMMM d, y') : value
         pushToArray(id, val)
         
         if(id === 'title'){
            if(value){
                $('#btn_drafter_next_log').removeAttr('disabled')
                const author = $('#title .render_option').attr('email')
                $.ajax({
                    url: '.././api/drafter.php',
                    type:'POST',
                    cache: false,
                    data: {
                      api:'get_author_of_study',
                      email: author
                    },
                    success: (res)=>{
                      pushToArray('creator', res)
                       $('#creator').val(res)
                    },
                    error: (err)=>{
                      console.log(`Error`, err);
                    }
                })
            }else{
                $('#btn_drafter_next_log').attr('disabled', 'true')
                $('#creator').val('')
                pushToArray('creator', '')
            }
         }
      })
   })

   arrOfUpdateDataLogFields.map(fields=>{
        $(`#${fields.id}`).change(event=>{
            const { id, value} = event?.target
            pushToUpdtArray(id ,value)
        })
   })

   $('#log_filter').change(event=>{
     const { value } = event?.target
     const filterBy = arrOfLogs.filter(logs=> JSON.stringify(logs).toLowerCase().match(value?.toLowerCase()))
     renderTable(filterBy)
   })
   
//     const renderTable = (cols = [])=>{
//         if(cols.length > 0){
//             cols.map((col, index)=>{
//                 $('#tbl_head_row').append(`<th key="${index}" class="text-center align-items-center"><span>${col?.label}</span></th>`)
//                     rows.map((row, i)=>{
//                        $('#tbl_body_drafter_log').append(`<tr key="${i}" class="mounted text-center">
//                           ${row?.c?.map((cell, cellIndex)=>{
//                             return `<td key="${cellIndex}" class="text-center">${cell?.v}</td>`
//                           })}
//                     </tr>`)
//                 })
//             })
            
//         }

//     }


//    const getSpreadSheetData = ()=>{
//      $.ajax({
//         url: url,
//         type: 'GET',
//         cache: false,
//         success: (data)=>{
//             const mountedData = JSON.parse(data.substring(47).slice(0, -2))
//             const { cols, rows } = mountedData?.table
//             renderTable(cols, rows)
//         },
//         error: (err)=>{
//             console.log(`Error`, err);
//         }
//      })
//    }

//    getSpreadSheetData();
   
})