"use strict"
/*let urlWork = 'http://studenter.miun.se/~mali1910/dt173g/projekt/api/work.php';
let urlWorkDel='http://studenter.miun.se/~mali1910/dt173g/projekt/api/work.php?id=';

let urlStudy='http://studenter.miun.se/~mali1910/dt173g/projekt/api/study.php';
let urlStudyDel ='http://studenter.miun.se/~mali1910/dt173g/projekt/api/study.php?id=';

let urlSites='http://studenter.miun.se/~mali1910/dt173g/projekt/api/sites.php';
let urlSitesDel ='http://studenter.miun.se/~mali1910/dt173g/projekt/api/sites.php?=id';
*/

let urlWork = 'http://localhost/dt173g/api/work.php';
let urlWorkDel = 'http://localhost/dt173g/api/work.php?id=';

let urlStudy  = 'http://localhost/dt173g/api/study.php';
let urlStudyDel='http://localhost/dt173g/api/study.php?id=';

let urlSites ='http://localhost/dt173g/api/sites.php';
let urlSitesDel ='http://localhost/dt173g/api/sites.php?id=';


let workEl = document.getElementById("work");
let studyEl = document.getElementById("study");
let sitesEl = document.getElementById("sites");
let updateStudyEl=document.getElementById("updateStudy-form");



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
        data.records.forEach(work =>{
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
    fetch(urlWorkDel+id, {
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
        data.records.forEach(study =>{
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

    let place = companyInput.value;
        let coursename = titleInput.value;
        let startedu = startworkInput.value;
        let stopedu = stopworkInput.value;
    
        let study = {'place':place, 'coursename':coursename, 'startedu':startedu, 'stopedu':stopedu, 'id':id};
        fetch('http://localhost/dt173g/api/study.php?id='+id, {
            method:'PUT',
            body:JSON.stringify(study),
        })
        .then(response=>response.json())
        .then(data=>{
            //getStudy();
            //console.log('hej');
            
                data.records.forEach(study =>{
                    updateStudyform.innerHTML +=
                    `<div class="col">
                    <input type="text" class="form-control" value="${study.place}"></div>
                    <div class="col">
                  <input type="text" class="form-control"  value="${study.coursename}">
                  </div>
                  <div class="col">
                  <input type="date" class="form-control" value="${study.startedu} - ${study.stopedu}">
                  </div>
                    `;
                })
            })
        
        .catch(error =>{
            console.log("Error:", error);
        })
    }




function deleteStudy(id){
    fetch(urlStudyDel+id, {
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
        data.records.forEach(sites =>{
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
    fetch(urlSitesDel+id, {
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
