<?php 
    if(getIndex("mod") == "editCourse" || getIndex("mod") == "editLession"){
        include("module/CourseManager/editCourse.php");
    }else{
        include("module/CourseManager/showInfomation.php");
    }
?>