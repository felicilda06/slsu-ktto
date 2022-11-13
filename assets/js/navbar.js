$(document).ready(()=>{
    const urlPath = window.location.pathname.split('/')
    const filepath = urlPath.slice(-1).toString();
    const usertype = urlPath[urlPath.length - 2] ?? ''
    const [file, _ext] = filepath.split('.');
    const arrOfMenus = [
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
          id: 'documents',
          active: false
        }
      ]
    },
    {
        usertype: 'maker',
        url: [{

        }]
    }
    ]

    const getUrls = arrOfMenus.find((menu)=> menu.usertype === usertype).urls ?? []

    $('#burger').click(()=>{
       $('.navbar_wrapper').toggleClass('expand')
       $('.navbar_wrapper nav ul').toggleClass('show')
    })

    const redirecToPatentDashboard = ()=>{
        if(filepath && filepath === 'dashboard.php'){
            $.ajax({
                url:'../patent-drafter/main.php',
                type: 'GET',
                cache: false,
                success: (res)=> $('#main').html(res)
            })
        }
    }

    redirecToPatentDashboard();

    const activeMenu = (id)=>{
      getUrls.filter(url=> url.id === id).map(act=> $(`#${act.id}`).addClass('active'))
      getUrls.filter(url=> url.id !== id).map(act=> $(`#${act.id}`).removeClass('active'))
    }

    getUrls.map(url=> {
       return  $(`#${url.id}`).click(event=> {
         const { id } = event?.currentTarget
         activeMenu(id)
         window.location.href = `../${usertype}/${id}.php`
       })

    })

    activeMenu(file)

    $('#caret_down').click(()=> {
        $('.settings').toggleClass('show')
    })

    $('#signout').click(()=> window.location.href = '../logout.php')

})