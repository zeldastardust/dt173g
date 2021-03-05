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

let updateWorkEl=document.getElementById("updateWork-form");
let updateStudyEl=document.getElementById("updateStudy-form");
let updateSitesEl=document.getElementById("updateSite-form");


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


//functions
function fetchData() {
    getWork();
   getStudy();
    getSites();
  }

//functions for work objects
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
            <td><a onclick="getWorkbyId(${work.id})"class="btn btn-success">Uppdatera</a></td>
            <td><a onclick="deleteWork(${work.id})" class="btn btn-danger">Radera</a></td>
          </tr>`;
           
        })
    })
}
function getWorkbyId(id){
    fetch(`${urlWork}?id=${id}`)
    .then(response => response.json())
    .then(updateWorkEl.style.display = 'block')
    .then(work => {      
            updateWorkEl.innerHTML +=
            `<form class="form-group" method="get">
            <h3>Uppdatera arbete</h3> <br>
            <label for="place">Arbetsplats</label>
            <input type="text" class="form-control"id="updcompany" value="${work.company}"> <br>
            <label for="title">Titel</label>
            <input type="text" class="form-control"id="updtitle" value="${work.title}"> <br>
            <label for="start">Startdatum</label>
            <input type="date" class="form-control"  id="updstartwork" value="${work.startwork}"> <br>
            <label for="stop">Slutdatum</label>
            <input type="date" class="form-control" id="updstopwork" value="${work.stopwork}"> <br>
            <input type="submit" id="updateBtn" class="btn btn-success" onClick="updateWork(${work.id})" value="Uppdatera"> <br> 
            <input type="submit" class="btn btn-danger" onClick="closeDiv()" value="Avbryt">     
            </form>`     
    })
}

function updateWork(id){
    let newCompany = document.getElementById('updcompany');
    let newTitle = document.getElementById('updtitle');
    let newStartwork = document.getElementById('updstartwork');
    let newStopwork = document.getElementById('updstopwork');

    newCompany = newCompany.value;
    newTitle = newTitle.value;
    newStartwork = newStartwork.value;
    newStopwork = newStopwork.value;

    let work = {'id':id, 'company':newCompany, 'title':newTitle, 'startwork':newStartwork, 'stopwork': newStopwork};

    fetch(`${urlWork}?id=${id}`,{
        method:'PUT',
        body: JSON.stringify(work)
    })
    .then(response => response.json())
    .then(data =>{
        getWork();
    })
    .catch(error=> {
        console.log('Error: ',error);
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

//functions for study objects
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
            <td><a onclick="getStudybyId(${study.id})" class="btn btn-success">Uppdatera</a></td>
            <td><a onclick="deleteStudy(${study.id})" class="btn btn-danger">Radera</a></td>
          </tr>`;
        })
    })
}
function getStudybyId(id){
    fetch(`${urlStudy}?id=${id}`)
    .then(response => response.json())
    .then(updateStudyEl.style.display = 'block')
    .then(data => {
        updateStudyEl.innerHTML +=
            `<form class="form-group" method="get">
            <h3>Uppdatera studier</h3> <br>
            <label for="place">Lärosäte</label>
            <input type="text" class="form-control"id="updplace" value="${data.place}"> <br>
            <label for="coursename">Kurs/program</label>
            <input type="text" class="form-control"  id="updcoursename" value="${data.coursename}"> <br>
            <label for="start">Startdatum</label>
            <input type="date" class="form-control" id="updstartedu" value="${data.startedu}"> <br>
            <label for="stop">Slutdatum</label>
            <input type="date" class="form-control" id="updstopedu" value="${data.stopedu}"> <br>
            <input type="submit" id="updateBtn" class="btn btn-success" onClick="updateStudy(${data.id})" value="Uppdatera"> <br> 
            <input type="submit" class="btn btn-danger" onClick="closeDiv()" value="Avbryt">     
            </form>`     
    })
}

function updateStudy(id){
    let newPlace = document.getElementById('updplace');
    let newCoursename = document.getElementById('updcoursename');
    let newStartedu = document.getElementById('updstartedu');
    let newStopedu = document.getElementById('updstopedu');

    newPlace = newPlace.value;
    newCoursename = newCoursename.value;
    newStartedu = newStartedu.value;
    newStopedu = newStopedu.value;

    let study = {'id':id, 'place':newPlace, 'coursename':newCoursename, 'startedu':newStartedu, 'stopedu': newStopedu};

    fetch(`${urlStudy}?id=${id}`,{
        method:'PUT',
        body: JSON.stringify(study)
    })
    .then(response => response.json())
    .then(data =>{
        getStudy();
    })
    .catch(error=> {
        console.log('Error: ',error);
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


//functions for sites objects
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
              <a onclick="getSitebyId(${sites.id})" class="btn btn-success">Uppdatera</a>
              <a href="#updSiteH" onclick="deleteSite(${sites.id})" class="btn btn-danger">Radera</a></td>
              
            </div>
          </div>
     `
        })
    })
}
function getSitebyId(id){
    fetch(`${urlSites}?id=${id}`)
    .then(response => response.json())
    .then(updateSitesEl.style.display = 'block')
    .then(site => {
        updateSitesEl.innerHTML +=
            `<form class="form-group" method="get">
            <h3 id="updSiteH1">Uppdatera webbplats</h3> <br>
            <label for="webname">Namn</label>
            <input type="text" class="form-control" id="updname" value="${site.webname}"> <br>
            <label for="url">Webadress</label>
            <input type="text" class="form-control" id="updurl" value="${site.url}"> <br>
            <label for="start">Beskrivning</label>
            <input type="text" class="form-control" id="upddescription" value="${site.description}"> <br>
            <input type="submit" id="updateBtn" class="btn btn-success" onClick="updateSite(${site.id})" value="Uppdatera"> <br> 
            <input type="submit" class="btn btn-danger" onClick="closeDiv()" value="Avbryt">     
            </form>`     
    })
}

function updateSite(id){
    let newname = document.getElementById('updname');
    let newurl = document.getElementById('updurl');
    let newdescription = document.getElementById('upddescription');

    newname = newname.value;
    newurl = newurl.value;
    newdescription = newdescription.value;

    let site = {'id':id, 'name':newname, 'url':newurl, 'description':newdescription};

    fetch(`${urlSites}?id=${id}`,{
        method:'PUT',
        body: JSON.stringify(site)
    })
    .then(response => response.json())
    .then(data =>{
        getSites();
    })
    .catch(error=> {
        console.log('Error: ',error);
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
