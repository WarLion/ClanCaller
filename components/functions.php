<?php 
   function title() {
      if (isset($title)) {
         if ($confirm == "1") {
             echo "Member";
         }else if($title == "2"){
			 echo "Elder";
		 }else if($title == "3"){
			 echo "Co-leader";
		 }else if($title == "4"){
			 echo "Leader";
		 }
      }
   }
   
?>