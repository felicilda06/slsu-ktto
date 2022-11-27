$(document).ready(()=>{
    let apiType = '';
    let arrOfStudies = [];
    const type_of_technology = $('#type_of_technology').val()

    const renderTable = (studies = [])=>{
       if(studies.length > 0){
         $('#tbl_drafter_studies tr.studies').remove();
         studies.map((study, i)=>{
                $('#tbl_drafter_studies').append(`<tr class="studies">
                <td class="text-center py-3">${i + 1}</td>
                <td class="text-center py-3">${study?.title}</td>
                <td class="text-center py-3">${study?.proponent}</td>
                <td class="text-center py-3">${study?.technology_type}</td>
                <td class="text-center py-3">${study?.contact_information}</td>
                <td class="text-center py-3">${study?.file}</td>
                <td class="text-center py-3">${study?.authors}</td>
                <td class="text-center py-3">${study?.created_at}</td>
                <td class="text-center py-3">${study?.status}</td>
                <td class="text-center py-3 align-items-center" style="font-size:14px;">
                    <i title="Edit" id="${study?.id}" class="btn_drafter_studies_edit fa fa-pencil-square-o mx-2 text-info" data-toggle="modal" data-backdrop="static" data-keyboard="false"></i>
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

    $(document).on('click', '.btn_drafter_studies_edit', (event)=>{
        const { id } = event?.currentTarget
        $('#modal_drafter_upload_new_modal').modal({
            backdrop: 'static',
            keyboard: false,            
       });
        
    })


    filter_date_accepted
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