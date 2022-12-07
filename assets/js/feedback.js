$(document).ready(()=>{

    let apiType;
    let isSelected = false;
    const userId = $('#user_id').val()
    const technologyType = $('#type_of_technology').val()

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

    const renderMenus = (studies = [], active) =>{
        if(studies.length){
            $('.feedback_menus > div.feedback_menu').remove();
            studies.map((study, index)=>{
                $('.feedback_menus').append(`
                   <div key="${index}" class="feedback_menu ${active === study?.id ? 'active': ''}" id="${study?.id}">
                     <span>${study?.title}</span>
                   </div>
                `)
            })
        }else{

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
                    // const name = feedback?.sender === userId ? 'Me' : feedback?.sender_name
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
                }else{
                    return;
                }
               
            },
            error: (err)=>{
                console.log(`Error`, err);
            }
        })
    }

    const getStudesByPatentId =(api, technologyType, active)=>{
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
             if(!isSelected){
                const activeId = fetchStudies[0]?.id
                renderMenus(fetchStudies, activeId)
                getFeedabackByStudyId(activeId)
             }else{
                renderMenus(fetchStudies, active)
                getFeedabackByStudyId(active)
             }
            
          },
          error: (err)=>{
            console.log(`Error`,err);
          }
       })
    }


    getStudesByPatentId('get_studies_by_patent_Id', technologyType, undefined)
   // setInterval(()=>  getStudesByPatentId('get_studies_by_patent_Id', technologyType, undefined) , 1200)

    $(document).on('click', '.feedback_menu', event=>{
        isSelected = true;
        getStudesByPatentId('get_studies_by_patent_Id', technologyType, event?.currentTarget.id)
        getFeedabackByStudyId(event?.currentTarget.id)
    })
})