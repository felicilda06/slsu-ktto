$(document).ready(()=>{
    $('#burger').click(()=>{
       $('.navbar_wrapper').toggleClass('expand')
       $('.navbar_wrapper nav ul').toggleClass('show')

    })

    const ajaxRequest = (type = '')=>{
        if(!type) return

    }

    // document.addEventListener('click', ()=>{
    //   if($('.settings').hasClass('show')){
    //     $('.settings').removeClass('show');
    //   }
    // })

    $('.navbar_wrapper nav ul li#menu:nth-child(1)').addClass('active')

    $('.navbar_wrapper nav ul li#menu:nth-child(1)').click(()=>{
        $('.navbar_wrapper nav ul li#menu:nth-child(1)').addClass('active')
        $('.navbar_wrapper nav ul li#menu:nth-child(2)').removeClass('active')
        $('.navbar_wrapper nav ul li#menu:nth-child(3)').removeClass('active')
        $('.navbar_wrapper nav ul li#menu:nth-child(4)').removeClass('active')
        ajaxRequest('dashboard')
    })

    $('.navbar_wrapper nav ul li#menu:nth-child(2)').click(()=>{
        $('.navbar_wrapper nav ul li#menu:nth-child(2)').addClass('active')
        $('.navbar_wrapper nav ul li#menu:nth-child(1)').removeClass('active')
        $('.navbar_wrapper nav ul li#menu:nth-child(3)').removeClass('active')
        $('.navbar_wrapper nav ul li#menu:nth-child(4)').removeClass('active')
        ajaxRequest('log_submission')
    })

    $('.navbar_wrapper nav ul li#menu:nth-child(3)').click(()=>{
        $('.navbar_wrapper nav ul li#menu:nth-child(3)').addClass('active')
        $('.navbar_wrapper nav ul li#menu:nth-child(1)').removeClass('active')
        $('.navbar_wrapper nav ul li#menu:nth-child(2)').removeClass('active')
        $('.navbar_wrapper nav ul li#menu:nth-child(4)').removeClass('active')
        ajaxRequest('view_submission')
    })

    $('.navbar_wrapper nav ul li#menu:nth-child(4)').click(()=>{
        $('.navbar_wrapper nav ul li#menu:nth-child(4)').addClass('active')
        $('.navbar_wrapper nav ul li#menu:nth-child(1)').removeClass('active')
        $('.navbar_wrapper nav ul li#menu:nth-child(2)').removeClass('active')
        $('.navbar_wrapper nav ul li#menu:nth-child(3)').removeClass('active')
        ajaxRequest('documents')
    })

    $('#caret_down').click(()=>{
        $('.settings').toggleClass('show')
    })
})