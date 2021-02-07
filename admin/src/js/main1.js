"use strict"

//variables

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
            `<div class="card mt-4 col-md-4" >
            <div class="card-body">
              <h5 class="card-title">${work.title}</h5>
              <h6 class="card-subtitle mb-2 text-muted">${work.company}</h6>
              <p class="card-text">${work.startwork} - ${work.stopwork}</p>
              <a href="#" class="card-link">Uppdatera</a>
              <a href="#" class="card-link">Radera</a>
            </div>
          </div>
     `
           
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
    })
}

function getStudy(){
    studyEl.innerHTML='';

    fetch("http://localhost/dt173g/api/study.php")
    .then(response => response.json())
    .then(data => {
        data.records.forEach(study =>{
            studyEl.innerHTML +=
            `<div class="study">
            <p>
            <b>Lärosäte:</b> ${study.place}
            </p>
            <p>
            <b>Kurs/utbildning:</b> ${study.coursename}
            </p>
            <p>
            <b>Period:</b> ${study.startedu}-${study.stopedu}
            </p>
            <button id="${study.id}" onClick="deleteStudy(${study.id})">Radera</button>
            </div>`
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

function addStudy(){
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
}

function getSites(){
    sitesEl.innerHTML='';
    fetch("http://localhost/dt173g/api/sites.php")
    .then(response => response.json())
    .then(data => {
        data.records.forEach(sites =>{
            sitesEl.innerHTML +=
            `<div class="sites">
            <p>
            <b>Webbplats:</b> ${sites.webname}
            </p>
            <p>
            <b>url:</b> ${sites.url}
            </p>
            <p>
            <b>Beskrivning:</b> ${sites.description}
            </p>
            <button id="${sites.id}" onClick="deleteSite(${sites.id})">Radera</button>
            </div>`
           
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
