<?php
if(isset($_GET['added']))
{
    ?>
<div id='my-alert' class="alert alert-success m-3" role="alert">
  Election has been added successfully.
</div>
<script>
      const alert = document.getElementById('my-alert');
      setTimeout(() => {
         $('#my-alert').alert('close')
      }, 2000)
     
   </script>
    <?php
}else if(isset($_GET['delete_id']))
{
    $d_id = $_GET['delete_id'];
    mysqli_query($db,"DELETE FROM elections WHERE id ='".$d_id."'") OR die(mysqli_error($db));
    mysqli_query($db,"DELETE FROM candidate_details WHERE election_id ='".$d_id."'") OR die(mysqli_error($db));
    mysqli_query($db,"DELETE FROM votings WHERE election_id ='".$d_id."'") OR die(mysqli_error($db));
    ?>
    <div id='alert' class="alert alert-danger m-3" role="alert">
  Election has been deleted successfully.
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
        <h3>Add New Election</h3>
        <form method="post">
            <div class="form-group">
                <input type="text" name="election_topic" placeholder="Election Topic" class="form-control" required/>
            </div>
            <div class="form-group">
                <input type="number" name="no_of_candidates" placeholder="Number Of Candidates" class="form-control" required/>
            </div>
            <div class="form-group">
                <input type="text" onfocus="this.type='date'" name="starting_date" placeholder="Starting Date" class="form-control" required/>
            </div>
            <div class="form-group">
                <input type="text" onfocus="this.type='date'" name="ending_date" placeholder="Ending Date" class="form-control" required/>
            </div>
         <input type="reset" value="Reset" name="reset" class="btn btn-outline-primary"/>
         <input type="submit" value="Add Election" name="addelection" class="btn btn-outline-primary"/>
        </form>
    </div>
    <div class="col-8">
        <h3>Upcoming Elections</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.no</th>
                    <th scope="col">Election Name</th>
                    <th scope="col">#Candidates</th>
                    <th scope="col">Starting On</th>
                    <th scope="col">Ending On</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $fetchingData= mysqli_query($db,"SELECT * from elections") or die(mysqli_error($db));
                    $isanyelectionadded=mysqli_num_rows($fetchingData);

                    if($isanyelectionadded > 0)
                    {
                        $sno=1;
                        while ($row=mysqli_fetch_assoc($fetchingData))
                         {
                            $election_id = $row['id'];
                          ?>
                          <tr>
                            <td><?php echo $sno++ ?></td>
                            <td><?php echo $row['election_topic']; ?></td>
                            <td><?php echo $row['no_of_candidates']; ?></td>
                            <td><?php echo $row['starting_date']; ?></td>
                            <td><?php echo $row['ending_date']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td> 
                                    <button class="btn btn-sm btn-danger" onclick="DeleteData(<?php echo $election_id; ?>)"> Delete </button>
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
    const DeleteData = (e_id) => 
    {
        let c = confirm("Are you really want to delete it?");

        if(c == true)
        {
            location.assign("index.php?addelectionpage=1&delete_id=" + e_id);
        }
    }
</script>

<?php
    // election_topic no_of_candidates starting_date ending_date 

    if(isset($_POST['addelection']))
    {
        $election_topic = mysqli_real_escape_string($db,$_POST['election_topic']);
        $no_of_candidates = mysqli_real_escape_string($db,$_POST['no_of_candidates']);
        $starting_date = mysqli_real_escape_string($db,$_POST['starting_date']);
        $ending_date = mysqli_real_escape_string($db,$_POST['ending_date']);
       $inserted_by = $_SESSION['username'];
       $inserted_on =date("y-m-d");

       $date1=date_create($inserted_on);
       $date2=date_create($starting_date);
       $diff=date_diff($date1,$date2);


       if((int) $diff->format("%R%a")>0)
        {
            $status="InActive";
        }else{
            $status="Active";
        }

        //inserting into database
        mysqli_query($db,"insert into elections(election_topic,no_of_candidates,starting_date,ending_date,status,inserted_by,inserted_on) values('". $election_topic."','". $no_of_candidates."','". $starting_date ."','". $ending_date."','". $status."','". $inserted_by."','". $inserted_on."')")or die(mysqli_error($db));
        ?>
        <script>location.assign("index.php?addelectionpage=1&added=1")</script>
        <?php
    }

?>