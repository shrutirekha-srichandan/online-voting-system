
<div class="row my-3">
    <div class="col-12">
        <h3>Elections</h3>
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
                            $election_id =$row['id'];
                          ?>
                          <tr>
                            <td><?php echo $sno++ ?></td>
                            <td><?php echo $row['election_topic']; ?></td>
                            <td><?php echo $row['no_of_candidates']; ?></td>
                            <td><?php echo $row['starting_date']; ?></td>
                            <td><?php echo $row['ending_date']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <a href="index.php?viewresult=<?php echo $election_id; ?>" class="btn btn-sm btn-outline-primary">View Result</a>
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


