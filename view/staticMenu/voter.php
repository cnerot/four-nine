<div id="rating">
    <?php 
        $_SESSION['etat']= false;
        if ($_SESSION['etat']){
            $display = false;
        }else{
            $display = true;
        }
        if ($display){
            $_SESSION['etat'] = true;
            if($_SESSION['etat']==true){
                $voteform->display('','',1);
                $_SESSION['etat'] = false;
            }
            $_SESSION['etat']= false;
        }
        
        
        //echo $voteForm;
    ?>
</div>
