<?php
require('classes/db.php');
$db=new Db;

/*our db object has 20 diferent methods.Two of them are used here.
similarly users can try working with the same table for other different methods/functions.

*/



//reading  id and title column  of the blog table

echo "Reading id and title column of the blog table <br>";
$read_blog=$db->select_field('tbl_blog',array('id','title'));
foreach($read_blog as $content){
	echo "Id:".$content['id']."<br>";
	echo  "Title:".$content['title']."<br>";
	echo "<br>";
}

//reading all column of the blog table

echo "<br>Reading all column of the blog table <br>";
$read_all_blog=$db->select_all('tbl_blog');
foreach($read_all_blog as $content){
	echo "Id:".$content['id']."<br>";
	echo  "Title:".$content['title']."<br>";
	echo "Description:".$content['description']."<br>";
	echo "<br>";
}



?>