<?php 
    require_once('includes/header.php');
    require_once('includes/navigation.php');


    if(isset($_GET['homepage']))
    {
        require_once('includes/homepage.php');
    }
    elseif(isset($_GET['addelectionpage']))
    {
        require_once('includes/addelection.php');
    }
    elseif (isset($_GET['addcandidatespage'])) {

        require_once('includes/addcandidates.php');
        
    }
    elseif (isset($_GET['viewresult'])) {

        require_once('includes/viewresult.php');
        
    }

?>



<?php 
    require_once('includes/footer.php');

?>
