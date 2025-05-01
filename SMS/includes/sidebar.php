<?php
SESSION_START();
if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != null){
    $user_id = $_SESSION['user_id'];
}else{
    header('location:login.php');
}
?>
<section>
    <div class="sidebar">
        <ul>
            <li><a href="index.php">Home</a></li>
           <?php 
           if($_SESSION['user_type'] == 'admin'){
                echo(' <li><a href="add_student.php">Add Student</a></li>
                       <li><a href="view_student.php">View Student</a></li>
                       <li><a href="add_teacher.php">Add Teacher</a></li>
                       <li><a href="view_teacher.php">View Teacher</a></li>
                       <li><a href="add_class.php">Add Class</a></li>
                       <li><a href="view_class.php">View Class</a></li>
                       <li><a href="add_subject.php">Add Subject</a></li>
                       <li><a href="view_subject.php">View Subject</a></li>
                       <li><a href="view_results.php">View Results</a></li>
                        <li><a href="View_reports.php">View Reports</a></li>
                       ');
                      
            }
            else if($_SESSION['user_type'] == 'teacher'){
                echo(' <li><a href="view_student.php">View Student</a></li>
                       <li><a href="view_class.php">View Class</a></li>
                       <li><a href="view_subject.php">View Subjects</a></li>
                       <li><a href="view_results.php">View Results</a></li
                       <li><a href="add_results.php">Add Result</a></li>
                    ');
            }
            ?>
           
        </ul>
    </div>
</section>