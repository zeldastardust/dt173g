"use strict"
/*let urlWork = 'http://studenter.miun.se/~mali1910/dt173g/projekt/api/work.php';
let urlStudy='http://studenter.miun.se/~mali1910/dt173g/projekt/api/study.php';
let urlSites='http://studenter.miun.se/~mali1910/dt173g/projekt/api/sites.php';
*/

let urlWork = 'http://localhost/dt173g/api/work.php';
let urlStudy  = 'http://localhost/dt173g/api/study.php';
let urlSites ='http://localhost/dt173g/api/sites.php';



let workEl = document.getElementById("work");
let studyEl = document.getElementById("study");
let sitesEl = document.getElementById("sites");
let updateStudyEl=document.getElementById("updateStudy-form");
let updateWorkEl=document.getElementById(" updateWork-form");

let addWorkbtn= document.getElementById("addWork");
let companyInput= document.getElementById("company"); 
let titleInput= document.getElementById("title");
let startworkInput= document.getElementById("startwork");
let stopworkInput= document.getElementById("stopwork");

let addStudybtn=document.getElementById("addStudy");
let placeInput=document.getElementById("place");
let coursenameInput=document.getElementById("coursename");
let starteduInput=document.getElementById("startedu");
let stopeduInput=document.getElementById("stopedu");
let updateStudyform = document.getElementById('updateStudy-form');

let addSitesbtn=document.getElementById("addSites");
let webnameInput=document.getElementById("webname");
let urlInput=document.getElementById("url");
let descriptionInput=document.getElementById("description");

let updatePlaceInput=document.getElementById("updatePlace");
let updateCourseInput=document.getElementById("updateCourse");
let updateStarteduInput=document.getElementById("updateStartedu");
let updateStopeduInput=document.getElementById("updateStopedu");


//eventlistener
window.addEventListener('load', getWork);
window.addEventListener('load', getStudy);
window.addEventListener('load', getSites);
addWorkbtn.addEventListener('click',addWork);
addStudybtn.addEventListener('click', addStudy);
addSitesbtn.addEventListener('click', addSites);
//document.getElementById('getStudybyidbtn').addEventListener('click',  getStudybyID(id));

//functions
function fetchData() {
    getWork();
   getStudy();
    getSites();
  }


function getWork(){
    workEl.innerHTML='';
    fetch(urlWork)
    .then(response => response.json())
    .then(data => {
        data.worklist.forEach(work =>{
            workEl.innerHTML +=
            `<tr>
            <td>${work.company}</td>
            <td>${work.title}</td>
            <td>${work.startwork} - ${work.stopwork}</td>
            <td><a onclick="updateWork(${work.id})" class="update">Uppdatera</a></td>
            <td><a onclick="deleteWork(${work.id})" class="delete">Radera</a></td>
          </tr>`;
           
        })
    })
}

function deleteWork(id){
    fetch(`${urlWork}?id=${id}`, {
        method:'DELETE',
    })
    .then(response=>response.json())
    .then(data=>{
        getWork();
    })
    .catch(error =>{
        console.log("Error:", error);
    })
}

function addWork(){
    let company = companyInput.value;
    let title = titleInput.value;
    let startwork = startworkInput.value;
    let stopwork = stopworkInput.value;

    let work = {'company':company, 'title':title, 'startwork':startwork, 'stopwork':stopwork};
    fetch(urlWork, {
        method:'POST',
        body:JSON.stringify(work),
    })
    .then(response=>response.json())
    .then(data=>{
        getWork();
    })
    .catch(error =>{
        console.log("Error:", error);
    });
}

function addStudy(){

    let place = companyInput.value;
    let coursename = titleInput.value;
    let startedu = startworkInput.value;
    let stopedu = stopworkInput.value;

    let study = {'place':place, 'coursename':coursename, 'startedu':startedu, 'stopedu':stopedu};
    fetch(urlStudy, {
        method:'POST',
        body:JSON.stringify(study),
    })
    .then(response=>response.json())
    .then(data=>{
        getWork();
    })
    .catch(error =>{
        console.log("Error:", error);
    })
}

function getStudy(){
    studyEl.innerHTML='';

    fetch(urlStudy)
    .then(response => response.json())
    .then(data => {
        data.studylist.forEach(study =>{
            studyEl.innerHTML +=
            `<tr>
            <td>${study.place}</td>
            <td>${study.coursename}</td>
            <td>${study.startedu} - ${study.stopedu}</td>
            <td><a onclick="updateStudy(${study.id})" class="update">Uppdatera</a></td>
            <td><a onclick="deleteStudy(${study.id})" class="delete">Radera</a></td>
          </tr>`;
        })
    })
}

function updateStudy(id){
    //läser in data utifrån id från apiet
    fetch(`${urlStudy}?id=${id}`)
    //gör om responsen till json 
    .then(response => response.json())
    //data=json objektet
    .then(data => {
        //console.log(data);
        let output ='';

    //här vill jag att ett formulär blir synligt där det aktuella objektet är ifyllt
        data.studylist.forEach(study =>{
            output += `
            <div class="col">
            <input type="text" class="form-control" id="updatePlace" placeholder="Läroverk" value="${study.place}">
            </div>
            <div class="col">
            <input type="text" class="form-control" id="updateCourse" placeholder="Kurs/utbildning" value="${study.coursename}">
            </div>
            <div class="col">
            <input type="date" id="updateStartedu" class="form-control" placeholder="ÅÅÅÅ-MM-DD" value="${study.startedu}">
            </div>
            <div class="col">
            <input type="date" id="updateStopedu" class="form-control" placeholder="ÅÅÅÅ-MM -DD" value="${study.stopedu}">
            </div>
            <a id="updatebtn" onclick="sendStudyupd(${study.id})" class="btn btn-primary"/>Spara</a>`;

      });
      updateStudyEl.innerHTML = output;
    });
}
//här skickas ett put request när formuläret är ifyllt
function sendStudyupd(id){

        let place = updatePlaceInput.value;
        let coursename = updateCourseInput.value;
        let startedu = updateStarteduInput.value;
        let stopedu = updateStopeduInput.value;
    
        let study = {'place':place, 'coursename':coursename, 'startedu':startedu, 'stopedu':stopedu, 'id':id};
        
        fetch(`${urlStudy}?id=${id}`, {
            method:'PUT',
            body:JSON.stringify(study),
        })
        .then(response=>response.json())
        .then(data=>{
            getStudy();
                })        
        .catch(error =>{
            console.log("Error:", error);
        })
    }
    
function deleteStudy(id){
    fetch(`${urlStudy}?id=${id}`, {
        method:"DELETE",
    })
    .then(response=>response.json())
    .then(data=>{
        getStudy();
    })
    .catch(error =>{
        console.log("Error:", error);
    })
}



function getSites(){
    sitesEl.innerHTML='';
    fetch(urlSites)
    .then(response => response.json())
    .then(data => {
        data.sitelist.forEach(sites =>{
            sitesEl.innerHTML +=
            `<div class="card m-4 col-md-8 " >
            <div class="card-body">
              <h5 class="card-title">${sites.webname}</h5>
              <h6 class="card-subtitle mb-2 text-muted">${sites.url}</h6>
              <p class="card-text">${sites.description}</p>
              <a onclick="updateSite(${sites.id})" class="update">Uppdatera</a>
              <a onclick="deleteSite(${sites.id})" class="delete">Radera</a></td>
              
              
            </div>
          </div>
     `
        })
    })
}

function deleteSite(id){
    fetch(`${urlSites}?id=${id}`, {
        method:'DELETE',
    })
    .then(response=>response.json())
    .then(data=>{
        getSites();
    })
    .catch(error =>{
        console.log("Error:", error);
    })
}



function addSites(){
    let webname = webnameInput.value;
    let url = urlInput.value;
    let description = descriptionInput.value;
    

    let sites = {'webname':webname, 'url':url, 'description':description};
    fetch(urlSites, {
        method:'POST',
        body:JSON.stringify(sites),
    })
    .then(response=>response.json())
    .then(data=>{
        getSites();
    })
    .catch(error =>{
        console.log("Error:", error);
    })
}
