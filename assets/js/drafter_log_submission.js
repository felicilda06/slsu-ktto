$(document).ready(()=>{
   const spreadSheetId = '1IyuIohoxUs-5917-B_MtoXEy5YD29UvyaT13MTNYfQM';
   const gid = '1415776155';
   const url = `https://docs.google.com/spreadsheets/d/${spreadSheetId}/gviz/tq?tqx=out:json&tq&gid=${gid}`;


    const renderTable = (cols = [], rows = [])=>{
        if(cols.length > 0){
            cols.map((col, index)=>{
                $('#tbl_head_row').append(`<th key="${index}" class="text-center align-items-center"><span>${col?.label}</span></th>`)
                    rows.map((row, i)=>{
                       $('#tbl_body_drafter_log').append(`<tr key="${i}" class="mounted text-center">
                          ${row?.c?.map((cell, cellIndex)=>{
                            return `<td key="${cellIndex}" class="text-center">${cell?.v}</td>`
                          })}
                    </tr>`)
                })
            })
            
        }

    }


   const getSpreadSheetData = ()=>{
     $.ajax({
        url: url,
        type: 'GET',
        cache: false,
        success: (data)=>{
            const mountedData = JSON.parse(data.substring(47).slice(0, -2))
            const { cols, rows } = mountedData?.table
            renderTable(cols, rows)
        },
        error: (err)=>{
            console.log(`Error`, err);
        }
     })
   }

   getSpreadSheetData();
   
})