$(document).ready(()=>{
    const urlPath = window.location.pathname.split('/')
    const filepath = urlPath.slice(-1).toString();
    const usertype = urlPath[urlPath.length - 2] ?? ''
    const [file, _ext] = filepath.split('.');
    const userTypeField = $('#profile_user_type').val()

    const arrOfMenus = [
      {
        usertype: 'admin',
        urls: [
        {
          id: 'dashboard',
          active: false
        },
        {
          id: 'log',
          active: false
        },
        {
          id: 'submission',
          active: false
        },
        {
          id: 'studies',
          active: false
        }
      ]
    },
    {
        usertype: 'patent-drafter',
        urls: [
        {
          id: 'dashboard',
          active: false
        },
        {
          id: 'log',
          active: false
        },
        {
          id: 'submission',
          active: false
        },
        {
          id: 'studies',
          active: false
        }
      ]
    },
    {
        usertype: 'maker',
        urls: [
          {
            id: 'dashboard',
            active: false
          },
          {
            id: 'log',
            active: false
          },
          {
            id: 'documents',
            active: false
          },
          {
            id: 'studies',
            active: false
          }
        ]
      },
      {
        usertype: 'clerk',
        urls: [
        {
          id: 'dashboard',
          active: false
        },
        {
          id: 'log',
          active: false
        },
        {
          id: 'submission',
          active: false
        },
        {
          id: 'studies',
          active: false
        }
      ]
    },
    ]

    if(userTypeField){
      $('#logo').attr('src', './assets/images/logo.png')
    }else{
      $('#logo').attr('src', '../assets/images/logo.png')
    }


    const getUrls = arrOfMenus.find((menu)=> userTypeField ? userTypeField === 'patent drafter' ? menu.usertype ===  'patent-drafter' : menu.usertype === userTypeField : menu.usertype === usertype)?.urls ?? []

    $('#burger').click(()=>{
       $('.navbar_wrapper').toggleClass('expand')
       $('.navbar_wrapper nav ul').toggleClass('show')
    })

    const redirecToDashboard = ()=>{
        if(filepath && filepath === 'dashboard.php'){
            $.ajax({
                url:`../${usertype}/main.php`,
                type: 'GET',
                cache: false,
                success: (res)=> $('#main').html(res)
            })
        }
    }

    redirecToDashboard();

    const activeMenu = (id)=>{
      getUrls.filter(url=> url.id === id).map(act=> $(`#${act.id}`).addClass('active'))
      getUrls.filter(url=> url.id !== id).map(act=> $(`#${act.id}`).removeClass('active'))
    }

    getUrls.map(url=> {
       return  $(`#${url.id}`).click(event=> {
         const { id } = event?.currentTarget
         activeMenu(id)
         if(userTypeField){
           window.location.href = `./${userTypeField?.toLowerCase() === 'patent drafter' ? 'patent-drafter': userTypeField}/${id}.php`
         }else{
           window.location.href = `../${usertype}/${id}.php`
         }
       })

    })

    activeMenu(file)

    $('#caret_down').click(()=> {
        $('.settings').toggleClass('show')
    })

    $('#signout').click(()=> {
      if(userTypeField){
        window.location.href = './logout.php'
      }else{
        window.location.href = '../logout.php'
      }
    })

    $('#profile').click(()=> {
      if(userTypeField){
        window.location.href = './profile.php'
      }else{
        window.location.href = '../profile.php'
      }
    })

})