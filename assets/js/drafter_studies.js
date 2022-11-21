$(document).ready(()=>{
    let apiType = '';
    let arrOfStudies = [];
    const type_of_technology = $('#type_of_technology').val()

    const renderTable = (studies = [])=>{
       if(studies.length > 0){
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
         })
       }else{
         console.log(`test`);
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

    getAcceptedStudies('accepted_studies')

    $(document).on('click', '.btn_drafter_studies_edit', (event)=>{
        const { id } = event?.currentTarget
        $('#modal_drafter_upload_new_modal').modal({
            backdrop: 'static',
            keyboard: false,            
       });
        
    })
})