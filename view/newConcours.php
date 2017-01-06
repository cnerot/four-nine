   <div class="grey darken-2">
    <div class="container">
     <div class="row">
       <div class="col s12 m4 l2"></div>
        <div class="col s12 m4 l8 margin-top">
            <?php
            if (isset($concours)){
                /* prepare data */
                $data = [
                  'start'       => $concours->getStart(),
                  'end'         => $concours->getEnd(),
                  'name'        => $concours->getName(),
                  'description' => $concours->getDescription(),
                ];
                $form->display("",$data);
            } else {
                $form->display();
            }
             ?>
            <!--<form>
                 <label for="datepicker" class="label">Date de début </label>
                 <input type="date" class="datepicker">
                 <label for="datepicker" class="label">Date de fin</label>
                 <input type="date" class="datepicker">
                <div class="input-field">
                  <input type="text"  class="validate">
                  <label for="titleConcours">Titre de concours</label>
                </div>
                <div class="input-field">
                  <input type="text"  class="validate">
                   <label for="lot">Lot</label>
                </div>
                <div class="file-field input-field">
                     <div class="btn  amber accent-4">
                         <i class="material-icons left">add_a_photo</i>
                         <span>Image de lot</span>
                         <input type="file">
                     </div>
                     <div class="file-path-wrapper">
                       <input class="file-path validate" type="text">
                     </div>
                 </div>
                     <div class="input-field">
                         <textarea id="textarea1" class="materialize-textarea"></textarea>
                         <label for="textarea1">Description</label>
                    </div>
                 <div class='row'>
                     <div class="col s4">
                         <a class="waves-effect waves-light btn left grey lighten-2 black-text"><i class="material-icons left">subdirectory_arrow_left</i>Retour</a>
                     </div>
                     <div class="col s4"></div>
                     <div class="col s4">
                         <button name="submit" id="submit" type="submit" class="btn right green accent-4">Valider<i class="material-icons right">arrow_forward</i></button>
                     </div>
                 </div>
                <div class="clear"></div>
             </form>-->
         </div>
         <div class="col s12 m4 l2"></div>
         </div>
    </div>
</div>