<?php
$election_id = $_GET['viewresult'];
?>


<div class="row m-2">
            <div class="col-12">
                <h3>Election Result :</h3>
            <?php
                $fetchingActiveElections=mysqli_query($db,"select * from elections where id = '".$election_id."'") or die(mysqli_error($db));
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
                                <th colspan='4' class="bg-primary text-white"><h5>ELECTION TOPIC : <?php echo strtoupper($election_topic);?></h5></th>
                         </tr>
                         <tr>
                             <th>Photo</th>
                             <th>Candidate Details</th>
                             <th>#no of votes</th>
                            <th>Result</th>

                          </tr>
                         </thead>
                         <tbody>
                             <?php
                                $fetchingCandidates = mysqli_query($db,"select * from candidate_details where election_id= '".$election_id."'") or die(mysqli_error($db));
                               
                                while($candidatedata = mysqli_fetch_assoc($fetchingCandidates))
                                {
                                    $candidate_id = $candidatedata['id'];
                                    $candidate_photo = $candidatedata['candidate_photo'];
                                    

                                     // Fetching Candidate Votes 
                                     $fetchingVotes = mysqli_query($db, "SELECT * FROM votings WHERE candidate_id = '". $candidate_id . "'") or die(mysqli_error($db));
                                     $totalVotes = mysqli_num_rows($fetchingVotes);

                                    //maximum vote
                                 
                                   $updatetotalvotes =mysqli_query($db,"UPDATE `candidate_details` SET `totalvotes` = '$totalVotes' WHERE `candidate_details`.`id` = $candidate_id;
                                   ") or die(mysqli_error($db));

                                    
                                    $maxvotefetching = mysqli_query($db,"SELECT election_id,id,MAX(totalvotes) as max_vote FROM candidate_details where election_id ='".$election_id."'") or die(mysqli_error($db));
                                    $row = mysqli_fetch_assoc($maxvotefetching);
                                    $maxvote = $row['max_vote'];
                                    
                                    //echo $maxvote;
                             ?>

                                    <tr>
                                        <td><img src="<?php echo $candidate_photo ?>" class="candidate_photo"></td>
                                        <td><?php echo"<b>". $candidatedata['candidate_name']."</b><br/>".$candidatedata['candidate_details']; ?></td>
                                        <td><?php echo $totalVotes; ?></td>
                                        <td><?php
                                            if ($maxvote ==0) {
                                                echo "";
                                            }elseif($maxvote == $totalVotes)
                                            {
                                                echo "<img src='../assets/images/winner.jpg' width =100 alt=''>";
                                            }
                                            
                                        ?></td>

                             <?php
                                }
                             ?>
                         </tbody>
                     </table>
                     <?php
                    
                }
            }else {
                echo "No any active election.";
            }
        ?>

<hr>
            <h3>Voting Details :</h3>
            <?php 
                $fetchingVoteDetails = mysqli_query($db, "SELECT * FROM votings WHERE election_id = '". $election_id ."'");
                $number_of_votes = mysqli_num_rows($fetchingVoteDetails);

                if($number_of_votes > 0)
                {
                    $sno = 1;
            ?>
                    <table class="table">
                        <tr>
                            <th>S.No</th>
                            <th>Voter Name</th>
                            <th>Contact No</th>
                            <th>Voted To</th>
                            <th>Date </th>
                            <th>Time</th>
                        </tr>

            <?php
                    while($data = mysqli_fetch_assoc($fetchingVoteDetails))
                        {
                            $voters_id = $data['voters_id'];
                            $candidate_id = $data['candidate_id'];
                            $fetchingUsername = mysqli_query($db, "SELECT * FROM users WHERE id = '". $voters_id ."'") or die(mysqli_error($db));
                            $isDataAvailable = mysqli_num_rows($fetchingUsername);
                            $userData = mysqli_fetch_assoc($fetchingUsername);
                            if($isDataAvailable > 0)
                            {
                                $username = $userData['username'];
                                $contact_no = $userData['contact_no'];
                            }else {
                                $username = "No_Data";
                                $contact_no = $userData['contact_no'];
                            }


                            $fetchingCandidateName = mysqli_query($db, "SELECT * FROM candidate_details WHERE id = '". $candidate_id ."'") or die(mysqli_error($db));
                            $isDataAvailable = mysqli_num_rows($fetchingCandidateName);
                            $candidateData = mysqli_fetch_assoc($fetchingCandidateName);
                            if($isDataAvailable > 0)
                            {
                                $candidate_name = $candidateData['candidate_name'];
                            }else {
                                $candidate_name = "No_Data";
                            }
                ?>
                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td><?php echo $username; ?></td>
                                <td><?php echo $contact_no; ?></td>
                                <td><?php echo $candidate_name; ?></td>
                                <td><?php echo $data['vote_date']; ?></td>
                                <td><?php echo $data['vote_time']; ?></td>
                            </tr>
                <?php
                        }
                        echo "</table>";
                    }else {
                        echo "No any vote detail is available!";
                    }







                ?>
            </table>
            


            </div>
        </div>