"use strict"


let workEl = document.getElementById("work");
let studyEl = document.getElementById("study");
let sitesEl = document.getElementById("sites");



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



 
//functions


function getWork(){
    workEl.innerHTML='';
    fetch("http://localhost/dt173g/api/work.php")
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
    fetch('http://localhost/dt173g/api/work.php?id='+id, {
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
    fetch('http://localhost/dt173g/api/work.php', {
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
    fetch('http://localhost/dt173g/api/study.php', {
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
function updateStudy(id){

    let place = companyInput.value;
        let coursename = titleInput.value;
        let startedu = startworkInput.value;
        let stopedu = stopworkInput.value;
    
        let study = {'place':place, 'coursename':coursename, 'startedu':startedu, 'stopedu':stopedu};
        fetch('http://localhost/dt173g/api/study.php?id='+id, {
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


 

function getStudy(){
    studyEl.innerHTML='';

    fetch("http://localhost/dt173g/api/study.php")
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



function deleteStudy(id){
    fetch('http://localhost/dt173g/api/study.php?id='+id, {
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


/*function addStudy(){
    let place = placeInput.value;
    let coursename = coursenameInput.value;
    let startedu = starteduInput.value;
    let stopedu = stopeduInput.value;

    let study = {'place':place, 'coursename':coursename, 'startedu':startedu, 'stopedu':stopedu};
    fetch('http://localhost/dt173g/api/study.php', {
        method:'POST',
        body:JSON.stringify(study),
    })
    .then(response=>response.json())
    .then(data=>{
        getStudy();
    })
    .catch(error =>{
        console.log("Error:", error);
    })
}*/

function getSites(){
    sitesEl.innerHTML='';
    fetch("http://localhost/dt173g/api/sites.php")
    .then(response => response.json())
    .then(data => {
        data.records.forEach(sites =>{
            sitesEl.innerHTML +=
            `<div class="card m-4 col-md-8 " >
            <div class="card-body">
              <h5 class="card-title">${sites.webname}</h5>
              <h6 class="card-subtitle mb-2 text-muted">${sites.url}</h6>
              <p class="card-text">${sites.description}</p>
              <a href="#" class="card-link">Uppdatera</a>
              <a href="#" id="${sites.id}" onClick="deleteSite(${sites.id})" class="card-link">Radera</a>
              
            </div>
          </div>
     `
        })
    })
}

function deleteSite(id){
    fetch('http://localhost/dt173g/api/sites.php?id='+id, {
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
    fetch('http://localhost/dt173g/api/sites.php', {
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
