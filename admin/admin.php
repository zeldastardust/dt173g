<?php 
include_once("includes/header.php");?>
<section id="worksection" class="m-5">
        
        <h2 class="m-3">Yrken</h2>
        <table class="table table-hover table">
            <thead class="table-head">
              <tr>
                
                <th>Företag</th>
                <th>Titel</th>
                <th>Period</th>
                <th>Ändra</th>
                <th>Radera</th>
              </tr>
            </thead>
            <tbody id="work">
            </tbody>       
          </table>
          <div class="m-5">
          <div id="updateWork-form"></div>
          </div>
        </section><!--end of worksection-->
    
        <section id="studysektion" class="m-5">
          <h2 class="m-3">Utbildningar</h2>
        <table class="table table-hover table">
            <thead class="table-head">
              <tr>            
                <th>Lärosäte</th>
                <th>Kurs/Program</th>
                <th>Period</th>
                <th>Ändra</th>
                <th>Radera</th>
              </tr>
            </thead>
            <tbody id="study">
            </tbody> 
          </table>
          <div class="m-5">
          <div id="updateStudy-form"></div>
          </div>
        </section><!--end of studysection-->
        
    
     <div class="m-5">
            <div >
            <h2>Lägg till erfarenhet</h2>
            <form class="addWorkform">
                <div class="form-group">
                <label for="company">Arbetsplats/Lärosäte</label>
                <input type="text" class="form-control" name="company" id="company">
                </div>
                <div class="form-group">
                <label for="title">Yrkestitel/kursnamn</label>
                <input type="text" class="form-control" name="title" id="title">
            </div>
            <div class="form-group">
                <label for="startwork">Start datum</label>
                <input type="date" class="form-control" name="startwork" id="startwork">
                </div>
                <div class="form-group">
                <label for="stopwork">Slut datum</label>
                <input type="date" class="form-control" name="stopwork" id="stopwork">
                <button type="submit" class="btn btn-primary m-2" id="addWork">Lägg till arbetsplats</button>
                <button type="submit" class="btn btn-primary" id="addStudy">Lägg till Studier</button>
            </div>
            </form>
        </div>
        </div>
      
        <div class="m-5">      
    <section id="sitessection">
      <h2 class="m-3">Webbplatser</h2>
        <div id="sites" ></div>
        <div class="m-5">
          <div id="updateSite-form"></div>
          </div>
              
        </div>
    
      <div class="m-5">
            <div >
            <h2>Lägg till webbplats</h2>
            <form class="addSitesform">
                <div class="form-group">
                <label for="webname">Namn</label>
                <input type="text" class="form-control" name="webname" id="webname">
                </div>
                <div class="form-group">
                <label for="url">Webadress</label>
                <input type="text" class="form-control" name="url" id="url">
                </div>
                <div class="form-group">
                <label for="description">Beskrivning</label>
                <textarea class="form-control" name="description" id="description"></textarea>
                </div>         
                <button type="submit" class="btn btn-primary mt-2" id="addSites">Lägg till webbplats</button>
            </form>
        </div>
        </div>
        
        </section><!--end of sitessection-->
    
    
    
    
<?php 
include_once("includes/footer.php");?>