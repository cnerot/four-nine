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
         </div>
         <div class="col s12 m4 l2"></div>
         </div>
    </div>
</div>