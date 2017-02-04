<div class="grey darken-2"> 
    <div class="container">
            <div class="row">
                <h5 class="header col s12 white-text light center-align margin-top">Liste des concours</h5>
                <div class="col s12 margin-top">
                    <a href="#" id="new_button" class="btn-large right lime darken-3">Créer un concours<i class="material-icons right">add</i></a>
                </div>
                <div class="margin-top">
                    <table class="responsive-table">
                      <thead>
                        <tr class="white-text">
                          <th>Concours</th>
                          <th>Date de début</th>
                          <th>Date de fin</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody class="">
                      <?php foreach($concours as $concour): ?>
                          <tr>
                              <td><?php echo $concour->getName(); ?></td>
                              <td><?php echo $concour->getStart(); ?></td>
                              <td><?php echo $concour->getEnd(); ?></td>
                              <td>
                                  <div class="right">
                                      <a class="btn-floating btn-small orange lighten-2" href="<?php echo Router::getUrl("concours", "edit", ["id"=>$concour->getId()])?>"><i class="large material-icons">mode_edit</i></a>
                                      <a class="btn-floating btn-small red lighten-1" href="<?php echo Router::getUrl("concours", "delete", ["id"=>$concour->getId()])?>"><i class="large material-icons">delete_forever</i></a>
                                  </div>
                              </td>
                          </tr>
                      <?php endforeach; ?>


                      </tbody>
                    </table>
                </div>
            </div>         
    </div>
 </div>