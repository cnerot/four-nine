 <div class="container">
            <div class="row">
                <div class="col s12 p_pageStat <?php echo $themeApplicated->getPageStat(); ?>">
                    <p>Liste des concours</p>
                </div>
                <div class="col s12 margin-top">
                    <a href="<?php echo Router::getUrl("Concours", "New"); ?>" id="new_button" class="btn-large right lime darken-3">Créer un concours<i class="material-icons right">add</i></a>
                </div>
                <div class="margin-top">
                    <table class="table">
                      <thead>
                        <tr class="<?php echo $themeApplicated->getPageStat(); ?>">
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