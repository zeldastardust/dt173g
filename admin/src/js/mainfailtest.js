const workList = document.querySelector('.work-list');
let workOutput='';
const addWorkForm = document.querySelector('.add-work-form');
const companyValue=document.getElementById('company-value');
const titleValue=document.getElementById('title-value');
const startworkValue=document.getElementById('startwork-value');
const stopworkValue=document.getElementById('stopwork-value');
const btnSubmit= document.querySelector('.btn');

const renderWork =(works)=>{
  works.records.forEach(work => {
    workOutput+=`
    <div class="card mt-4 col-md-6">
            <div class="card-body" data-id=${work.id} >
              <h5 class="card-title">${work.title}</h5>
              <h6 class="card-subtitle mb-2 text-muted">${work.company}</h6>
              <p class="card-text">${work.startwork} - ${work.stopwork}</p>
              <a href="#" class="card-link" id="edit-work">Ändra</a>
              <a href="#" class="card-link" id="delete-work">Radera </a>
            </div>
          </div>`
});
workList.innerHTML=workOutput;
}

const url ='http://localhost/dt173g/api/work.php';

//GET - read works
//method :GET
fetch('http://localhost/dt173g/api/work.php')
.then(res=>res.json())
.then(data=>renderWork(data))

workList.addEventListener('click',(e)=>{
  e.preventDefault();
  let delButtonIsPressed = e.target.id == 'delete-work';
  let editButtonIsPressed = e.target.id == 'edit-work';

  let id = e.target.parentElement.dataset.id;

  //delete remove work
  //method :DELETE
  if(delButtonIsPressed) {
    fetch(`${url}/${id}`,{
      method:'DELETE',
    })
    .then(res => res.text())
    .then(text => console.log(text));
  }
  if(editButtonIsPressed){
    const parent = e.target.parentElement;
    let titleContent = parent.querySelector('.card-title').textContent;
    let subtitleContent=parent.querySelector('.card-subtitle').textContent;
    let textContent=parent.querySelector('.card-text').textContent;
    
    titleValue.value = titleContent;
    companyValue.value=subtitleContent;
  }
    //update
    //method PATCH
    btnSubmit.addEventListener('click',(e) =>{
      e.preventDefault();
      fetch(`'http://localhost/dt173g/api/work.php'/${id}`,{
        method:'PATCH',
        headers:{
          'Content-Type':'application/json'
        },
        body:JSON.stringify({
          title:titleValue.value,
          company:companyValue.value,
          startwork:startworkValue.value,
          stopwork:stopworkValue.value,
        })
      })
      .then(res => res.json())
      .then(()=>location.reload())
    })
});


//create insert new work
//method:POST
addWorkForm.addEventListener('submit',(/*e*/)=>{
  //e.preventDefault();
  fetch('http://localhost/dt173g/api/work.php',{
    method:'POST',
    headers:{
      'Content-Type':'application/json'
    },
    body: JSON.stringify({
      company: companyValue.value,
      title: titleValue.value,
      startwork: startworkValue.value,
      stopwork: stopworkValue.value,
    })
  })
  .then(res => res.json())
  .then(data=>{
    const dataArr =[];
    dataArr.push(data);
    
  })
})
