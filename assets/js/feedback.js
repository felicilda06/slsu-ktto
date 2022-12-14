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
       feedbackDiv.scrollTop = feedbackDiv.scrollHeight;
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

    const renderMenus = (studies = [], active, _studyId) =>{
      $('.feedback_menus > div.feedback_menu').remove();
        if(studies.length){
            studies.map((study, index)=>{
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
                $('.comments > div.comment').remove()
                if(feedbacks?.length){
                   const unread = feedbacks?.filter(feedback=> feedback?.sender !== userId)?.length
                   if(unread){
                        $('#feedback_counter').text(unread)
                        $('#feedback_counter').removeClass('hide')
                    }else{
                        $('#feedback_counter').addClass('hide')
                    } 
                   feedbacks?.map((feedback, index)=>{
                      const userType = feedback?.usertype === 'admin' ? 'Director' : feedback?.usertype?.at(0).toUpperCase() + feedback?.usertype.slice(1)
                      $('.comments').append(`
                        <div key="${index}" class="comment">
                            <img src="../assets/images/profile.jpg" alt="Profile" id="profile"/>
                            <div class="info">
                            <div class="comment_information">
                                <span id="account_name">${feedback?.usertype === 'admin'? userType : `${feedback?.sender_name} - ${userType}`}</span>
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
             const activeId = fetchStudies[0]?.id
             if(!isSelected){
               $('#study_id').val(activeId)
               renderMenus(fetchStudies, activeId, activeId, activeId)
               getFeedabackByStudyId(activeId)
               return
             }else{
               $('#study_id').val(studyId)
               renderMenus(fetchStudies, active, studyId, receiverId)
               getFeedabackByStudyId(active)
             }           
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
        getStudesByPatentId('get_studies_by_patent_Id', technologyType, id, id)
        feedbackDiv.scrollTop = feedbackDiv.scrollHeight;
    })

    $('#btn_send_reply').click(event=>{
        event?.preventDefault();
        const studyId = $('#study_id').val()
        const feedback = $('#send_feedback_reply').val()
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
                    receiver: studyId,
                    studyId,
                    feedback,
                    sender: userId,
                    senderName: userName,
                    createdAt: moment(new Date()).format('MMMM D, y hh:mm:ss')
                },
                success: (_res)=>{
                    $('#send_feedback_reply').val('')
                    getFeedabackByStudyId(studyId)
                    $('#send_feedback_reply').val('')
                    feedbackDiv.scrollTop = feedbackDiv.scrollHeight;
                },
                error: (err)=>{
                    console.log(`Error`, err);
                }
            })
        }
    })
})