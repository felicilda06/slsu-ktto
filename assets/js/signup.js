$(document).ready(()=>{
    $('#form-input-student-id').css('display', 'none')
    $('#usertype').change((e)=>{
        const value = e?.target?.value

        if(value === 'maker'){
            $('#form-input-student-id').css('display', 'flex')
        }else{
            $('#form-input-student-id').css('display', 'none')
        }
    })
})