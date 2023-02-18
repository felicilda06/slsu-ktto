$(document).ready(()=>{
    let apiType;
    const getTotatCountUserByUserType = ( userType)=>{
        apiType = 'getTotalCountDrafters';
        $.ajax({
            url: '.././api/counts.php',
            type:'POST',
            cache:false,
            data: {
                userType,
                api: apiType
                
            },
            success: (res)=>{
               const fetchData = res && JSON.parse(res)
               if(userType === 'patent drafter'){
                 $('#count_patent').text(fetchData?.length)
                 return
               }else{
                 $('#count_makers').text(fetchData?.length)
               }
              
            },
            error: (err)=>{
                console.log(`Error`, err);
            }
        })
    }

    const getTotatCountStudiesByStatus = (status)=>{
        apiType = 'getTotatCountStudiesByStatus';
        $.ajax({
            url: '.././api/counts.php',
            type:'POST',
            cache:false,
            data: {
                status,
                api: apiType
                
            },
            success: (res)=>{
               const fetchData = res && JSON.parse(res)
                if(status === 'Registered'){
                    $('#count_registered').text(fetchData?.length)
                } else if(status === 'Under Substantive Examination'){
                    $('#count_substantive').text(fetchData?.length)
                } else if(status === 'Under Formality Examination'){
                    $('#count_formality').text(fetchData?.length)
                } else if(status === 'Published'){
                    $('#count_published').text(fetchData?.length)
                } else if(status === 'Forfeited'){
                    $('#count_forfeited').text(fetchData?.length)
                } else if(status === 'Withdrawn'){
                    $('#count_withdrawn').text(fetchData?.length)
                }
            },
            error: (err)=>{
                console.log(`Error`, err);
            }
        })

    }


   getTotatCountUserByUserType('patent drafter');
   getTotatCountUserByUserType('maker');
   getTotatCountStudiesByStatus('Registered');
   getTotatCountStudiesByStatus('Published');
   getTotatCountStudiesByStatus('Forfeited');
   getTotatCountStudiesByStatus('Under Substantive Examination');
   getTotatCountStudiesByStatus('Under Formality Examination');
   getTotatCountStudiesByStatus('Withdrawn');

  setInterval(()=> {
    getTotatCountUserByUserType('patent drafter');
    getTotatCountUserByUserType('maker');
    getTotatCountStudiesByStatus('Registered');
    getTotatCountStudiesByStatus('Published');
    getTotatCountStudiesByStatus('Forfeited');
    getTotatCountStudiesByStatus('Under Substantive Examination');
    getTotatCountStudiesByStatus('Under Formality Examination');
    getTotatCountStudiesByStatus('Withdrawn');
  } , 1000)
})

