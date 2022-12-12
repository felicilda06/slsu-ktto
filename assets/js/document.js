$(document).ready(()=>{
    let apiType;
    let isSelected = false;
    let isSubmit = false;
    const dir = '../files'
    const imagesExt = ['png', 'jpg', 'jpeg', 'tiff', 'gif']
    const userName = $('#user_name').val()
    const userId = $('#user_id').val()
    const commentsDiv = document.getElementById("comments");

    const message_func = (messages = []) => {
        const messageContainer = $("#message-container");
        timeOut = 3500
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
          }
  
          setTimeout(() => messageContainer.children().remove(), timeOut);
        });
      }

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
                const documents = res && JSON.parse(res)
                const docs = documents?.length && Object.entries(documents[0]).map(([_key, value])=> ({file: value})).splice(1)
                const finalDocs = Array.isArray(docs) && docs.filter((_d, index)=> index <= 6 )
                $('.files div.file').remove()
                $('.comments_wrapper').removeClass('bordered')
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
                        $('.comments_wrapper').addClass('bordered')
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
                            $('.comments_wrapper').addClass('bordered')
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
        isSelected = true;
        apiType = 'get_feedback_by_id'
        $.ajax({
            url: '.././api/maker.php',
            type:'POST',
            cache: false,
            data: {
                api: apiType,
                rowId: id
            },
            success: (res)=>{
              const fetchFeedbacks = res && JSON.parse(res)
              $('.comments .comment').remove();
              fetchFeedbacks?.map((feedback, index)=>{
                $('#btn_send_comment').attr('study-id',feedback?.maker_id)
                $('#btn_send_comment').attr('patent-id',feedback?.patent_id)
                $('#btn_send_comment').attr('sender',feedback?.sender === userId ? feedback?.sender : feedback?.receiver )
                $('#btn_send_comment').attr('receiver',feedback?.receiver === userId ? feedback?.sender : userId)
                $('.comments').append(`
                    <div key="${index}" class="comment d-flex">
                        <img src="../assets/images/profile.jpg" alt="Profile" id="profile"/>
                        <div class="info">
                        <div class="comment_information">
                            <span id="account_name">${feedback?.sender_name} - ${feedback?.usertype?.at(0).toUpperCase() + feedback?.usertype.slice(1)}</span>
                            <p>${feedback?.comments}</p>
                        </div>
                        <small>${feedback?.created_at}</small>
                        </div>
                    </div>
                `)
              })
              commentsDiv.scrollTop = commentsDiv.scrollHeight;
            },
            error:(err)=>{
                console.log(`Error`, err)
            }
        })
        
    }
    //<div class="dot"></div>
    renderMenu = (arrOfStudies = [], activeId, status, bgColor)=>{
       if(arrOfStudies.length){
            $('.document_menus > div.menu').remove();
            arrOfStudies.map((studies, index)=> {
                console.log(studies);
                const [_fn, ext] = studies?.file.split('.')
                $('#study_status').css('background-color', `#${bgColor}`)
                $('#study_status').css('color', status === 'Decline' ? '#e21e1e' : '#28e16a')
                $('#study_status').text(status === 'Decline' ? 'Declined' : 'Accepted')
                $('.document_menus').append(`
                    <div status="${studies?.status}" color="${studies?.bg_color}" class="menu d-flex ${studies?.id === activeId ? 'active': ''}" id="${studies?.id}" key="${index}">
                        <i class="mr-2 mt-1 ${imagesExt.includes(ext) ? 'fa fa-file-picture-o' : 'fa fa-file'}"></i>
                        <p>${studies?.title}</p>
                    </div>
                `)
            })
            if(isSelected){
                return;
            }else{
                getFeedbacksAndDocumentsById(activeId)
            }
            $('.main_placeholder').addClass('hide')
            $('.document_maker_wrapper').removeClass('hide')
       }else{
        $('.document_maker_wrapper').addClass('hide')
        $('.main_placeholder').removeClass('hide')
       }
    }
    

    const getAcceptedStudies = (api, activeId, status, bgColor)=>{
      $.ajax({
        url: '.././api/maker.php',
        type:'POST',
        cache: false,
        data: {
            userId,
            api: api
        },
        success: (res)=>{
           const arrOfStudies = res && JSON.parse(res)
           if(!isSelected){
             const id = arrOfStudies[0]?.id
             renderMenu(arrOfStudies, id, arrOfStudies[0]?.status, arrOfStudies[0]?.bg_color)
             getFeedbacksById(id)
           }else{
             renderMenu(arrOfStudies, activeId, status, bgColor)
           }
           
        },
        error:(err)=>{
            console.log(`Error`, err)
        }
      })
    }

    getAcceptedStudies('get_all_studies', undefined)
    setInterval(()=> {
        if(isSelected){
            return;
        }else{
            getAcceptedStudies('get_all_studies')
        }
    } , 1500)


    $(document).on('click', '.menu', event=>{
        isSelected = true;
        const { id } = event?.currentTarget
        getAcceptedStudies('get_all_studies', id, event?.currentTarget.getAttribute('status'), event?.currentTarget.getAttribute('color'))
        getFeedbacksAndDocumentsById(id)
        getFeedbacksById(id)
        $('#comment_field').val('')
    })

    $(document).on('click', '.open_file', event=>{
        const { id } = event?.currentTarget
        window.open(`${dir}/${id}`)
    })

    $('#comment_field').focus(()=>{
       isSelected = true;
    })

    $('#btn_send_comment').click((event)=>{
        event?.preventDefault();
        const feedback = $('#comment_field').val()
        const studyId =  $('#btn_send_comment').attr('study-id')
        const patentId = $('#btn_send_comment').attr('patent-id')
        apiType = 'reply_to_comment';

        if(isSubmit) return
        if(!feedback){
            message_func([{status: 409, message: 'Please enter your comment.'}])
            $('#comment_field').focus();
        }else{
            $.ajax({
                url: '.././api/maker.php',
                type:'POST',
                cache: false,
                data: {
                    api: apiType,
                    sender: userId,
                    receiver: studyId,
                    feedback,
                    studyId,
                    patentId,
                    senderName: userName,
                    createdAt: moment(new Date()).format('MMMM D, y hh:mm:ss'),

                },
                success: (res)=>{
                    getFeedbacksById(res)
                    $('#comment_field').focus();
                    $('#comment_field').val('');
                },
                error: (err)=>{
                    console.log(`Error`, err);
                }
            })

        }
    
    })
})