<?php

    require_once("includes/header.php");
    require_once("includes/navigation.php");
  ?>

        <div class="row m-2">
            <div class="col-12">
                <h3>Voters Panel</h3>
            <?php
                $fetchingActiveElections=mysqli_query($db,"select * from elections where status='Active'") or die(mysqli_error($db));
                $totalActiveElection= mysqli_num_rows($fetchingActiveElections);

                if($totalActiveElection > 0)
                {    
                    while ($data =mysqli_fetch_assoc($fetchingActiveElections)) 
                    {
                        $election_id= $data['id'];
                        $election_topic = $data['election_topic'];
                        ?>
                     <table class="table">
                        <thead>
                         <tr>
                                <th colspan='3' class="bg-primary text-white"><h5>ELECTION TOPIC : <?php echo strtoupper($election_topic);?></h5></th>
                         </tr>
                         <tr>
                             <th>Photo</th>
                             <th>Candidate Details</th>
                             <th>Action</th>

                          </tr>
                         </thead>
                         <tbody>
                             <?php
                                $fetchingCandidates = mysqli_query($db,"select * from candidate_details where election_id= '".$election_id."'") or die(mysqli_error($db));
                               
                                while($candidatedata = mysqli_fetch_assoc($fetchingCandidates))
                                {
                                    $candidate_id = $candidatedata['id'];
                                    $candidate_photo = $candidatedata['candidate_photo'];
                                    
                                    ?>

                                    <tr>
                                        <td><img src="<?php echo $candidate_photo ?>" class="candidate_photo"></td>
                                        <td><?php echo"<b>". $candidatedata['candidate_name']."</b><br/>".$candidatedata['candidate_details']; ?></td>
                                        <td>
                                        <?php
                                         $checkIfVoteCasted = mysqli_query($db, "SELECT * FROM votings WHERE voters_id = '". $_SESSION['user_id'] ."' AND election_id = '". $election_id ."'") or die(mysqli_error($db));    
                                         $isVoteCasted = mysqli_num_rows($checkIfVoteCasted);

                                        if($isVoteCasted >0)
                                        {
                                            $votecasteddata=mysqli_fetch_assoc($checkIfVoteCasted);
                                            $votecastedtocandidate =$votecasteddata['candidate_id'];
                                            if($votecastedtocandidate == $candidate_id)
                                            {
                                                ?>
                                                <img src="../assets/images/voteicon.avif" width=100px></td>
                                                <?php
                                            }
                                           
                                           

                                        }else{
                                            ?>

                                    <button class='btn btn-md btn-outline-primary' onclick="castvote(<?php echo $election_id;?>,<?php echo $candidate_id;?>,<?php echo $_SESSION['user_id'];?>)" > vote </button></td>
                                            <?php
                                        }
                                        ?> 
                                        
                                    </tr>
                                    <?php
                                }
                             ?>
                         </tbody>
                     </table>

                    <?php    
                    }
                  
                }
                else {
                    echo"No Elections Active!";
                }
            ?>


            
            </div>
        </div>


<script>
    const castvote =(election_id,candidate_id,voters_id)=>
    {
            $.ajax({
            type : "POST",
            url:"includes/ajaxcalls.php",
            data:"e_id="+election_id+"&c_id="+candidate_id+"&v_id="+voters_id,
            success: function (response) {
                if(response=='success')
                {
                    location.assign("index.php?VoteCasted=1");
                }else{
                    location.assign("index.php?VoteNotCasted=1");
                }
            }
        });
    }
</script>

  <?php 
   
    require_once("includes/footer.php");
  


?>