$(document).ready(()=>{
    let apitType = '';
    let arrOfStudies = [];
    const baseURL = '../uploads/';
    const type_of_technology = $('#type_of_technology').val()
    const imageExt = ['jpg', 'jpeg', 'png', 'tiff', 'gif']
    let isFiltered = false

    const renderTable = (studies = [])=>{
        if(studies.length > 0){
            $('#tbl_body_drafter_studies tr.studies').remove();
            studies.map((study, i)=>{
              $('#tbl_body_drafter_studies').append(`<tr class="studies">
                <td class="text-center py-3">${i + 1}</td>
                <td class="text-center py-3">${study?.doc_type}</td>
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
                </td>
              </tr>`)
            })
          $('#tbl_row_placeholder').addClass('hide')
       }else{
        console.log(`het`);
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
        console.log(filterByDate);
        isFiltered = true;
        renderTable(filterByDate)
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

    $(document).on('click', '.btn_accept', ()=>{
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
})