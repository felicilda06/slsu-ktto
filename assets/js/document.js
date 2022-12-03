$(document).ready(()=>{
    let apiType;
    let isSelected = false;
    const dir = '../files'
    const imagesExt = ['png', 'jpg', 'jpeg', 'tiff', 'gif']

    const getFeedbacksAndDocumentsById = (id) =>{
        apiType = 'get_documents_by_makerId'

        $.ajax({
            url: '.././api/maker.php',
            type:'POST',
            cache: false,
            data: {
                api: apiType,
                rowId: id,
            },
            beforeSend: ()=>{
                $('.loading').removeClass('hide');
            },
            success: (res)=>{
                isSelected = true;
                const documents = res && JSON.parse(res)
                const docs = documents?.length && Object.entries(documents[0]).map(([_key, value])=> ({file: value})).splice(1)
                const finalDocs = Array.isArray(docs) && docs.filter((_d, index)=> index <= 6 )
                $('.files div.file').remove()
                if(finalDocs?.length){
                    if(!isSelected){
                        $('.loading').addClass('hide')
                        finalDocs?.map((doc, index)=>{
                            $('.files').append(doc?.file ?`
                                <div class="file d-flex align-items-center" key="${index}">
                                   <span class="document_title">${doc?.file}</span>
                                   <i title="Open External Link" class="open_file fa fa-external-link text-primary ml-4 mr-2" id="${doc?.file}"></i>
                                   <a title="Download" href="${dir}/${doc?.file}" download>
                                     <i class="fa fa-download"></i>
                                   </a>
                                </div>
                            `: '')
                        })
                    }else{
                        setTimeout(()=> {
                            finalDocs?.map((doc, index)=>{
                                $('.files').append(doc?.file ? `
                                    <div class="file d-flex align-items-center" key="${index}">
                                       <span class="document_title">${doc?.file}</span>
                                       <i title="Open External Link" class="open_file fa fa-external-link text-primary ml-4 mr-2" id="${doc?.file}"></i>
                                       <a title="Download" href="${dir}/${doc?.file}" download>
                                         <i class="fa fa-download"></i>
                                       </a>
                                    </div>
                                `: '')
                            })
                            $('.loading').addClass('hide')
                            $('.document_body').removeClass('empty')
                        } , 1000)
                    }
                   
                    $('.placeholder').addClass('hide')
                   
                }else{
                   setTimeout(()=> {
                    $('.loading').addClass('hide')
                    $('.placeholder').removeClass('hide')
                    $('.document_body').addClass('empty')
                   }, 1000)
                }
            },
            error:(err)=>{
                console.log(`Error`, err)
            }
        })
    }

    const getFeedbacksById = (id)=>{
        apiType = 'get_feedback_by_id'
    }

    renderMenu = (arrOfStudies = [], activeId)=>{
       $('.document_menus > div.menu').remove();
       arrOfStudies.map((studies, index)=> {
        const [_fn, ext] = studies?.file.split('.')
          $('.document_menus').append(`
            <div class="menu d-flex ${studies?.id === activeId ? 'active': ''}" id="${studies?.id}" key="${index}">
                <i class="mr-2 mt-1 ${imagesExt.includes(ext) ? 'fa fa-file-picture-o' : 'fa fa-file'}"></i>
                <p>${studies?.title}</p>
                <div class="dot"></div>
            </div>
          `)
       })
        if(isSelected){
            return;
        }else{
            getFeedbacksAndDocumentsById(activeId)
        }
    }
    

    const getAcceptedStudies = (api, activeId)=>{
      $.ajax({
        url: '.././api/maker.php',
        type:'POST',
        cache: false,
        data: {
            api: api
        },
        success: (res)=>{
           const arrOfStudies = res && JSON.parse(res)
           if(!isSelected){
             const id = arrOfStudies[0]?.id
             renderMenu(arrOfStudies, id)
           }else{
             renderMenu(arrOfStudies, activeId)
           }
           
        },
        error:(err)=>{
            console.log(`Error`, err)
        }
      })
    }

    getAcceptedStudies('get_accepted_studies', undefined)
    setInterval(()=> {
        if(isSelected){
            return;
        }else{
            getAcceptedStudies('get_accepted_studies')
        }
    } , 1000)


    $(document).on('click', '.menu', event=>{
        isSelected = true;
        const { id } = event?.currentTarget
        getAcceptedStudies('get_accepted_studies', id)
        getFeedbacksAndDocumentsById(id)
    })

    $(document).on('click', '.open_file', event=>{
        const { id } = event?.currentTarget
        window.open(`${dir}/${id}`)
    })
})