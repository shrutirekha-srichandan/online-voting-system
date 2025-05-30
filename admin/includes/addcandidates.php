<?php
if(isset($_GET['added']))
{
    ?>
<div id='my-alert' class="alert alert-success m-3" role="alert">
  candidate has been added successfully.
</div>
<script>
      const alert = document.getElementById('my-alert');
      setTimeout(() => {
         $('#my-alert').alert('close')
      }, 2000)
   </script>
    <?php
}
else if(isset($_GET['largefile']))
{
    ?>
<div class="alert alert-danger m-3" role="alert">
  candidate image is too large (You can upload image upto 2mb size).
</div>

    <?php
}
else if(isset($_GET['invalidfile']))
{
    ?>
<div class="alert alert-danger m-3" role="alert">
    invalid type of image (only .jpg ,.png,.jpeg allowed)
</div>

    <?php
}

else if(isset($_GET['failed']))
{
    ?>
<div class="alert alert-danger m-3" role="alert">
    Image uploading failed,please try again.
</div>

<?php
} else if(isset($_GET['delete_id'])){
    $d_id = $_GET['delete_id'];
    mysqli_query($db,"DELETE FROM candidate_details WHERE id ='".$d_id."'") OR die(mysqli_error($db));
    mysqli_query($db,"DELETE FROM votings WHERE candidate_id ='".$d_id."'") OR die(mysqli_error($db));
   
    ?>
    <div id='alert' class="alert alert-danger m-3" role="alert">
  candidate has been deleted successfully.
 </div>
    <?php
}
?>
 <script>
      const alert = document.getElementById('alert');
      setTimeout(() => {
         $('#alert').alert('close')
      }, 2000)
   </script>

<div class="row my-3">
    <div class="col-4 pl-4">
        <h3>Add New Candidate</h3>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <select name="election_id" class="form-control" required>
                    <option value="">Select Election</option>
                    <?php
                        $fetchingElections = mysqli_query($db,"select * from elections") or die(mysqli_error($db));
                        $isanyelectionadded = mysqli_num_rows($fetchingElections);

                        if($isanyelectionadded > 0)
                        {
                            while($row = mysqli_fetch_assoc($fetchingElections))
                            {
                                $election_id =$row['id'];
                                $election_name = $row['election_topic'];
                                $allowedcandidates = $row['no_of_candidates'];
                                //Now checking how many candidates are added in this election
                                $fetchingcandidate = mysqli_query($db,"select * from candidate_details where election_id= '".$election_id."'") or die(mysqli_error($db));
                                $added_candidates =mysqli_num_rows($fetchingcandidate);
                                
                                if($added_candidates < $allowedcandidates)
                                {
                                     ?>
                                    <option value="<?php echo $election_id?>"><?php echo $election_name?></option>
                                <?php
                                }


                               
                            }

                        }else{
                            ?>
                            <option value="">Please Add Election First</option>
                            <?php
                        }

                    ?>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="candidatename" placeholder="Candidate Name" class="form-control" required/>
            </div>
            <div class="form-group">
                <input type="file" name="candidatephoto"  class="form-control" required/>
            </div>
            <div class="form-group">
                <input type="text"  name="candidatedetails" placeholder="Candidate Details" class="form-control" required/>
            </div>
         <input type="reset" value="Reset" name="reset" class="btn btn-outline-primary"/>
         <input type="submit" value="Add Candidates" name="addcandidatebtn" class="btn btn-outline-primary"/>
        </form>
    </div>
               
    
    <div class="col-8">
        <h3>Candidate Details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.no</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Details</th>
                    <th scope="col">Election</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $fetchingData= mysqli_query($db,"SELECT * from candidate_details") or die(mysqli_error($db));
                    $isanycandidateadded=mysqli_num_rows($fetchingData);

                    if($isanycandidateadded > 0)
                    {

                        $sno=1;
                        while ($row=mysqli_fetch_assoc($fetchingData))
                         {
                            $candidate_id = $row['id'];
                            $election_id =$row['election_id'];
                            $fetchingelectionname=mysqli_query($db,"select * from elections where id = '".$election_id."'")or die(mysqli_error($db));
                            $fetchingelectionnamequery = mysqli_fetch_assoc($fetchingelectionname);
                            $election_name =$fetchingelectionnamequery['election_topic'];
                            $candidate_photo = $row['candidate_photo'];
                          
                          ?>
                          <tr>
                            <td><?php echo $sno++ ?></td>
                            <td><img  src="<?php echo $candidate_photo; ?>" 
                            class = "candidate_photo" /></td>
                         <td><?php echo $row['candidate_name']; ?></td>
                            <td><?php echo $row['candidate_details']; ?></td>
                            <td><?php echo $election_name; ?></td>
                            <td>
                              <button class="btn btn-sm btn-danger" onclick="DeleteData(<?php echo $candidate_id; ?>)"> Delete </button>
                            </td>
                          </tr>
                          <?php
                        }
                    }else{
                        ?>
                        <tr>
                            <td colspan="7">No Elections Available</td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>

</div>

<script>
    const DeleteData = (c_id) => 
    {
        let c = confirm("Are you really want to delete it?");

        if(c == true)
        {
            location.assign("index.php?addcandidatespage=1&delete_id=" + c_id);
        }
    }
</script>

<?php
//  candidatedetails candidatephoto candidatename 
    if(isset($_POST['addcandidatebtn']))
    {
        $election_id = mysqli_real_escape_string($db,$_POST['election_id']);
        $candidatename = mysqli_real_escape_string($db,$_POST['candidatename']);
        $candidatedetails = mysqli_real_escape_string($db,$_POST['candidatedetails']);
        $inserted_by = $_SESSION['username'];
        $inserted_on =date("y-m-d");

        //photograph logic starts
        $target_folder="../assets/images/candidates_photo/";
        $candidatephoto = $target_folder.rand(1111111111,9999999999)."_".rand(1111111111,9999999999).$_FILES['candidatephoto']['name'];
        $candidate_photo_tmp_name = $_FILES['candidatephoto']['tmp_name'];
        $candidate_photo_type = strtolower(pathinfo($candidatephoto, PATHINFO_EXTENSION));
        $allowed_types = array("jpg","png","jpeg");
        $image_size = $_FILES['candidatephoto']['size'];

        if($image_size < 2000000) //2mb
        {
            if(in_array($candidate_photo_type,$allowed_types))
            {
                if(move_uploaded_file($candidate_photo_tmp_name,$candidatephoto))
                {
                    //inserting into database
                    mysqli_query($db,"insert into candidate_details(election_id,candidate_name,candidate_details,candidate_photo,inserted_by,inserted_on) values('". $election_id."','". $candidatename."','". $candidatedetails ."','". $candidatephoto."','". $inserted_by."','". $inserted_on."')")or die(mysqli_error($db));
                    ?>
                    <script>location.assign("index.php?addcandidatespage=1&added=1")</script>
                    <?php

                }else{
                  
                    echo"<script>location.assign('index.php?addcandidatespage=1&failed=1');</script>";

                }

            }else{
                echo"<script>location.assign('index.php?addcandidatespage=1&invalidfile=1');</script>";
            }

        }else {
            echo"<script>location.assign('index.php?addcandidatespage=1&largefile=1');</script>";
        }

        
        // photograph logic ends

       
    }

?>