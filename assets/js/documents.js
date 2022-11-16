$(document).ready(()=>{
    let arrOfDocuments = [
        {id: 1, title: 'Game of Thrones', docType: 'formality', author: 'Peter',  date_created: new Date(new Date().setDate(21)).toDateString()},
        {id: 2, title: 'Amazing Spider Man',  docType: 'formality', author: 'John Doe',  date_created: new Date(new Date().setDate(18)).toDateString()},
        {id: 3, title: 'Troll', author: 'Mark',  docType: 'drafted',  date_created: new Date(new Date().setDate(12)).toDateString()}
    ];
    let apiType = '';

    const renderTable = (documents = [])=>{
        $('#tbl_body_documents').empty();
        documents.map(document=> $('#tbl_body_documents').append(`<tr>
        <td>${document.id}</td>
        <td>${document.title}</td>
        <td>${document.author}</td>
        <td>${document.docType}</td>
        <td>${document.date_created}</td>
        </tr>`))
    }

    renderTable(arrOfDocuments)

    $('#document_type').change(event=>{
        const { value } = event?.target

        if(value?.toLowerCase() === 'all'){
            renderTable(arrOfDocuments)
        }else{
            const filterByDocumentType = arrOfDocuments.filter(document=> document.docType === value)
            renderTable(filterByDocumentType)
        }
    })

    $('#textfield_document_type').change(event=>{
       const { value } = event?.target
       if(!value){
             renderTable(arrOfDocuments)
       }else{
            const filterDocument = arrOfDocuments.filter(document => JSON.stringify(document).toLowerCase().match(value?.toLowerCase()))
            renderTable(filterDocument);
       }
    })

    $('#btn_new_document').click(()=>{
        $('#modal_document').modal({
            backdrop: 'static',
            keyboard: false,            
       });
    })


})