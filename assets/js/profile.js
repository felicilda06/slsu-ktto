$(document).ready(()=>{
    const userId = $('#user_id').val()
    let arrOfInputs = [
      
    ]

    const renderValue = (values = [])=>{

    }

    const getAccountInfo = ()=>{
       $.ajax({
           url:'./api/profile-api.php',
           type:'POST',
           cache: false,
           data:{
            api: 'get_account_info',
            userId
           },
           success: (res)=>{
             console.log(res);
           },
           error: (err)=>{
            console.log(`Error`, err);
           }
       })
    }

    getAccountInfo()
})