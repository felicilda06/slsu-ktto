$(document).ready(()=>{

    let apiType;
    let isSelected = false;
    let isSubmit = false;
    let stopToScrollToBottom = false;
    const userId = $('#user_id').val()
    const userName = $('#user_name').val()
    const technologyType = $('#type_of_technology').val()
    const feedbackDiv = document.getElementById('comments')

    $('#btn_see_feedback').click(()=>{
       $('.feedback_wrapper').removeClass('hide')
       $('.feedback_container').addClass('slide')
       $('#send_feedback_reply').focus()
    })

    $('#btn_hide_feedback').click(()=>{
        $('.feedback_wrapper').addClass('hide')
        $('.feedback_container').removeClass('slide')
        $('#send_feedback_reply').val('')
    })

    $('.comments').click(()=>{
        stopToScrollToBottom = true
    })

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

    const renderMenus = (studies = [], active , studyId, receiverId) =>{
        if(studies.length){
            $('.feedback_menus > div.feedback_menu').remove();
            studies.map((study, index)=>{
                $('#btn_send_reply').attr('receiver', receiverId ?? study?.userId)
                $('#btn_send_reply').attr('study-id', studyId ?? study?.id)
                $('.feedback_menus').append(`
                   <div key="${index}" study-id="${study?.id}" receiver="${study?.userId}" class="feedback_menu ${active === study?.id ? 'active': ''}" id="${study?.id}">
                     <span>${study?.title}</span>
                   </div>
                `)
            })
            $('.placeholder_container').addClass('hide')
        }else{
            $('.placeholder_container').removeClass('hide')
        }
    }

    const getFeedabackByStudyId = (studyId)=>{
        apiType = 'get_feedback_by_study_id';
        $.ajax({
            url: '.././api/feedback-api.php',
            type: 'POST',
            cache: false,
            data:{
                api: apiType,
                studyId
            },
            success: (res)=>{
                const feedbacks = res && JSON.parse(res)
                if(feedbacks?.length){
                   $('.comments > div.comment').remove()
                   feedbacks?.map((feedback, index)=>{
                      $('.comments').append(`
                        <div key="${index}" class="comment">
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
                   feedbackDiv.scrollTop = feedbackDiv.scrollHeight; 
                }else{
                    return;
                }
               
            },
            error: (err)=>{
                console.log(`Error`, err);
            }
        })
    }

    const getStudesByPatentId =(api, technologyType, active, studyId, receiverId)=>{
       $.ajax({
          url: '.././api/feedback-api.php',
          type:'POST',
          cache: false,
          data:{
            api:api,
            technology_type: technologyType
          },
          success: (res)=>{
             const fetchStudies = res && JSON.parse(res)
             setInterval(()=>{
                if(!isSelected){
                    const activeId = fetchStudies[0]?.id
                    renderMenus(fetchStudies, activeId)
                    getFeedabackByStudyId(activeId)
                 }else{
                    renderMenus(fetchStudies, active, studyId, receiverId)
                    getFeedabackByStudyId(active)
                 }
             } , 1200)
            
          },
          error: (err)=>{
            console.log(`Error`,err);
          }
       })
    }


    getStudesByPatentId('get_studies_by_patent_Id', technologyType, undefined)

    $(document).on('click', '.feedback_menu', event=>{
        const { id } = event?.currentTarget
        isSelected = true;
        getStudesByPatentId('get_studies_by_patent_Id', technologyType, id)
        getFeedabackByStudyId(id)
    })

    $('#btn_send_reply').click(event=>{
        event?.preventDefault();
        const feedback = $('#send_feedback_reply').val()
        const receiver = $('#btn_send_reply').attr('receiver')
        const studyId = $('#btn_send_reply').attr('study-id')
        apiType = 'reply_to_feedback';

        if(isSubmit) return
        if(!feedback){
            message_func([{status: 409, message:'Please enter your comment.'}])
            return
        }else{
            $.ajax({
                url: '.././api/drafter.php',
                type:'POST',
                cache: false,
                data:{
                    api: apiType,
                    receiver,
                    studyId,
                    feedback,
                    sender: userId,
                    senderName: userName,
                    createdAt: moment(new Date()).format('MMMM D, y hh:mm:ss')
                },
                success: (_res)=>{
                    $('#send_feedback_reply').val('')
                    getFeedabackByStudyId(studyId)
                },
                error: (err)=>{
                    console.log(`Error`, err);
                }
            })
        }
    })
})