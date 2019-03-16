<h3 align=center>Расходы за прошедшие сутки</h3>
<?php 
  foreach($cats_data as $name=>$cat):
     echo $name."<br/>";
     foreach($cat as $one):
         echo "--".$one['name']." => ".$one['q']." шт<br/>";
     endforeach;      
?>
<?php endforeach; ?>