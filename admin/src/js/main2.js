//test function
//api url
const api_url=
"http://localhost/dt173g/api/work.php";

//async funktion
async function getapi(url){
    //store response
    const response = await fetch(url);
    //storing it in json
    var data = await response.json();
    console.log(data);
    if(response){
        hideloader();
    }
    show(data);
}
//calling async function
getapi(api_url);

//function to hide the loader
function hideloader()
{
document.getElementById('loading').style.display='none';
}
//function to define inner HTML for table
function show(data){
    let tab =
    `<tr>
    <th>Arbetsplats</th>
    <th>Titel</th>
    <th>start</th>
    <th>stop</th>
    </tr>`;
    //loop to acces rows
    for(let r of data.list){
        tab += `<tr>
        <td>${r.company}</td>
        <td>${r.title}</td>
        <td>${r.startwork}</td>
        <td>${r.stopwork}</td>
        </tr>`;
        //setting inner html as tab variable
        document.getElementById("work").innerHTML=tab;
    }
}
