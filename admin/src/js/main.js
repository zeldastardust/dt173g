"use strict"

//variables
let workEl = document.getElementById("work");
let studyEl = document.getElementById("study");

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

//eventlistener
window.addEventListener('load', getWork);
window.addEventListener('load', getStudy);
addWorkbtn.addEventListener('click',addWork);
addStudybtn.addEventListener('click', addStudy);

//functions
function getWork(){
    workEl.innerHTML='';
    fetch("http://localhost/dt173g/api/work.php")
    .then(response => response.json())
    .then(data => {
        data.records.forEach(work =>{
            workEl.innerHTML +=
            `<div class="work">
            <p>
            <b>Arbetsplats:</b> ${work.company}
            </p>
            <p>
            <b>Titel:</b> ${work.title}
            </p>
            <p>
            <b>Period:</b> ${work.startwork}-${work.stopwork}
            </p>
            <button id="${work.id}" onClick="deleteWork(${work.id})">Radera</button>
            </div>`
           
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
