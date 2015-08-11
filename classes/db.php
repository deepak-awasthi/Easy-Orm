<?php

/*  Project Title: Easy ORM
    Project Description:
    Easy  ORM  is a  class for php mysql  database related functions.
    It utilizes the power of pdo and prepared statements. 
    Users need not to worry about sql injection.It is  a powerful class.
    It can be used on simple dynamic websites to complex ecommerce applications.
    Version:1.0
    Author:Basanta Dhakal

*/

require_once('database/db_constant.php');

class Db extends Db_constant{
private $con;

public function __construct(){
try{
	$this->con=new PDO('mysql:host='.$this->hostname.";dbname=".$this->dbname,$this->username,$this->password);
}
catch (PDOException $e){
	echo $e->getMessage();
}

}

//function number 1
public function select_all($table){

	$sql="select * from $table";
	$q=$this->con->query($sql);
	$data=array();
	while($r=$q->fetch(PDO::FETCH_ASSOC)){
		$data[]=$r;
	}
	return $data;

}

//function number 2
public function count_all ($table) {
	$sql="select * from $table";
	$q=$this->con->prepare($sql);
    $q->execute();
    return $q->rowCount();

}

//function number 3
public function select_all_with_order_by($table,$order){
	if(is_array($order)){
		$order_key= array_keys($order);
		
		
		$sql="select * from $table order by ";
		$i=0;
		foreach ($order_key as $key){
			$i++;
			$sql.=$key." ".$order[$key];
			if($i<count($order)){
				$sql.=",";
			}
		}
		$q=$this->con->query($sql);
		$data=array();
		while($r=$q->fetch(PDO::FETCH_ASSOC)){
			$data[]=$r;
		}
		return $data;
	}
}

//function number 4

public function select_all_with_order_by_limit($table,$order,$offset,$limit){
	if(is_array($order)){
		$order_key=array_keys($order);
		$sql="select * from $table order by ";
		$i=0;
		foreach($order_key as $key){
			$i++;
			$sql.=$key." ".$order[$key];
			if($i<count($order)){
				$sql.=",";
			}
		}
		$sql.=" limit $offset,$limit";
		$q=$this->con->query($sql);
		$data=array();
		while($r=$q->fetch(PDO::FETCH_ASSOC)){
			$data[]=$r;
		}
		return $data;
	}
}


//function number 5
public function select_all_with_condition($table,$condition){

	if(is_array($condition)){
		$condition_key=array_keys($condition);
		$sql="select * from $table where ";
		$i=0;
		foreach($condition_key as $key){
			$i++;
			$sql.=$key."=:".$key;
			if($i<count($condition)){
				$sql.=" and ";
			}
			
			}
		
		$q=$this->con->prepare($sql);
		foreach($condition_key as $key_to_bind){
			$q->bindParam(':'.$key_to_bind,$condition[$key_to_bind]);
		}
		$q->execute();
		//$q->debugDumpParams();
		$data=array();
		while($r=$q->fetch(PDO::FETCH_ASSOC)){
			$data[]=$r;

		}
		return $data;
	}

}

//function number 6

public function count_all_with_condition($table,$condition){

	if(is_array($condition)){
		$condition_key=array_keys($condition);
		$sql="select * from $table where ";
		$i=0;
		foreach($condition_key as $key){
			$i++;
			$sql.=$key."=:".$key;
			if($i<count($condition)){
				$sql.=" and ";
			}
		}
		
		$q=$this->con->prepare($sql);
		foreach($condition_key as $key_to_bind){
			$q->bindParam(':'.$key_to_bind,$condition[$key_to_bind]);
		}
		$q->execute();
		//$q->debugDumpParams();
		return $q->rowCount();

	}
}


//function number 7

public function select_all_with_condition_order_by($table,$condition,$order){
	if(is_array($condition) && is_array($order)){
		$condition_key=array_keys($condition);
		$sql="select * from $table where ";
		$i=0;
		foreach($condition_key as $key){
			$i++;
			$sql.=$key."=:".$key;
			if($i<count($condition)){
				$sql.="and";
			}
		}
		$sql.=" order by ";
		$order_key=array_keys($order);
		$i=0;
		foreach($order_key as $key_order){
			$i++;
			$sql.=$key_order." ".$order[$key_order];
			if($i<count($order)){
				$sql.=",";
			}
		}
		$q=$this->con->prepare($sql);
		foreach($condition_key as $key_to_bind){
			$q->bindParam(':'.$key_to_bind,$condition[$key_to_bind]);
		}
		$q->execute();
		$data=array();
		while($r=$q->fetch(PDO::FETCH_ASSOC)){
			$data[]=$r;
		}
		return $data;
		
	}
}

//function number 8
public function select_all_with_condition_order_by_limit($table,$condition,$order,$offset,$limit){

	if(is_array($condition) && is_array($order)){
		$condition_key=array_keys($condition);
		$sql="select * from $table where ";
		$i=0;
		foreach($condition_key as $key){
			$i++;
			$sql.=$key."=:".$key;
			if($i<count($condition)){
				$sql.="and";
			}
		}
		$sql.=" order by ";
		$order_key=array_keys($order);
		$i=0;
		foreach($order_key as $key_order){
			$i++;
			$sql.=$key_order." ".$order[$key_order];
			if($i<count($order)){
				$sql.=",";
			}
		}
		$sql.=" limit $offset,$limit ";
		$q=$this->con->prepare($sql);
		foreach($condition_key as $key_to_bind){
			$q->bindParam(':'.$key_to_bind,$condition[$key_to_bind]);
		}
		$q->execute();
		$data=array();
		while($r=$q->fetch(PDO::FETCH_ASSOC)){
			$data[]=$r;
		}
		return $data;
		
	}

}


//function number 9
public function select_field($table,$fields){
  if(is_array($fields)){
	$sql="select ";
	$i=0;
    foreach($fields as $field_name){
		
		$i++;
		$sql.="$field_name ";
		if($i<count($fields)){
		$sql.=",";
	}

	}
    $sql.="from $table";
	$q=$this->con->query($sql);
	$data=array();
	while($r=$q->fetch(PDO::FETCH_ASSOC)){
		$data[]=$r;
	}
	return $data;
}

}



//function number 10

public function count_field($table,$fields){
	$sql="select '$fields' from $table";
	$q=$this->con->query($sql);
	return $q->rowCount();
}


//function number 11
public function select_field_with_order_by($table,$fields,$order){
	if(is_array($fields) && is_array($order)){
		$sql=" select ";
		
		$i=0;
		foreach($fields as $field_name){
			$i++;
			$sql.=$field_name;
			if($i<count($fields)){
				$sql.=",";
			}
		}
		$sql.=" from $table order by  ";
		$order_key=array_keys($order);
		$i=0;
		foreach($order_key as $key_order){
			$i++;
			$sql.=$key_order." ".$order[$key_order];
			if($i<count($order)){
				$sql.=",";
			}

		}
		$q=$this->con->prepare($sql);
		$q->execute();
		$data=array();
		while($r=$q->fetch(PDO::FETCH_ASSOC)){
			$data[]=$r;
		}
		return $data;

	}
}


//function number 12

public function select_field_with_order_by_limit($table,$fields,$order,$offset,$limit){
	if(is_array($fields) && is_array($order)){
		$sql=" select ";
		
		$i=0;
		foreach($fields as $field_name){
			$i++;
			$sql.=$field_name;
			if($i<count($fields)){
				$sql.=",";
			}
		}
		$sql.=" from $table order by  ";
		$order_key=array_keys($order);
		$i=0;
		foreach($order_key as $key_order){
			$i++;
			$sql.=$key_order." ".$order[$key_order];
			if($i<count($order)){
				$sql.=",";
			}

		}
		$sql.=" limit $offset,$limit";
		$q=$this->con->prepare($sql);
		$q->execute();
		$data=array();
		while($r=$q->fetch(PDO::FETCH_ASSOC)){
			$data[]=$r;
		}
		return $data;

	}

}


//function number 13
public function select_field_with_condition($table,$fields,$condition){
	if(is_array($fields)&& is_array($condition)){
		$sql="select ";
		$i=0;
		foreach($fields as $field_name){
			$i++;
			$sql.="$field_name ";
			if($i<count($fields)){
				$sql.=",";
			}
		}
		$sql.=" from $table where ";
		$condition_key=array_keys($condition);
		$i=0;
		foreach($condition_key as $key){
			$i++;
			$sql.=$key."=:".$key;
			if($i<count($condition)){
				$sql.=" and ";
			}
		}
		//echo $sql;
		$q=$this->con->prepare($sql);
		foreach($condition_key as $key_to_bind){
			$q->bindParam(':'.$key_to_bind,$condition[$key_to_bind]);

		}
		$q->execute();
		$data=array();
		while($r=$q->fetch(PDO::FETCH_ASSOC)){
			$data[]=$r;
		}
		return $data;

	}
	
}


//function number 14
public function count_field_with_condition($table,$field,$condition){
	if(is_array($condition)){
		$sql="select '$field' from $table where ";
		$condition_key=array_keys($condition);
		$i=0;
		foreach($condition_key as $key){
			$i++;
			$sql.=$key."=:".$key;
			if($i<count($condition)){
				$sql.=" and ";
			}
		}
		$q=$this->con->prepare($sql);
		foreach($condition_key as $key_to_bind){
			$q->bindParam(':'.$key_to_bind,$condition[$key_to_bind]);
		}
		$q->execute();
		return $q->rowCount();
	}
}



//function number 15
public function select_field_with_condition_order_by($table,$fields,$condition,$order){
	if(is_array($fields) && is_array($condition) && is_array($order)){
		$sql=" select ";
		$i=0;
		foreach($fields as $field_name){
			$i++;
			$sql.=$field_name;
			if($i<count($fields)){
				$sql.=",";
			}
		}
		$sql.=" from $table where ";
		$condition_key=array_keys($condition);
		$i=0;
		foreach($condition_key as $key){
			$i++;
			$sql.=$key."=:".$key;
			if($i<count($condition)){
				$sql.=" and ";
			}
		}
		$sql.=" order by ";
		$order_key=array_keys($order);
		$i=0;
		foreach($order_key as $key_order){
			$i++;
			$sql.=$key_order." ".$order[$key_order];
			if($i<count($order)){
				$sql.=",";
			}


		}
		$q=$this->con->prepare($sql);
		
		foreach($condition_key as $key_to_bind){
			$q->bindParam(':'.$key_to_bind,$condition[$key_to_bind]);

		}
		$q->execute();
		$data=array();
		while($r=$q->fetch(PDO::FETCH_ASSOC)){
			$data[]=$r;
		}
		return $data;
	}
}


//function number 16
public function select_field_with_condition_order_by_limit($table,$fields,$condition,$order,$offset,$limit){
	if(is_array($fields) && is_array($condition) && is_array($order)){
		$sql=" select ";
		$i=0;
		foreach($fields as $field_name){
			$i++;
			$sql.=$field_name;
			if($i<count($fields)){
				$sql.=",";
			}
		}
		$sql.=" from $table where ";
		$condition_key=array_keys($condition);
		$i=0;
		foreach($condition_key as $key){
			$i++;
			$sql.=$key."=:".$key;
			if($i<count($condition)){
				$sql.=" and ";
			}
		}
		$sql.=" order by ";
		$order_key=array_keys($order);
		$i=0;
		foreach($order_key as $key_order){
			$i++;
			$sql.=$key_order." ".$order[$key_order];
			if($i<count($order)){
				$sql.=",";
			}


		}
		$sql.=" limit $offset,$limit ";
		$q=$this->con->prepare($sql);
		
		foreach($condition_key as $key_to_bind){
			$q->bindParam(':'.$key_to_bind,$condition[$key_to_bind]);

		}
		$q->execute();
		$data=array();
		while($r=$q->fetch(PDO::FETCH_ASSOC)){
			$data[]=$r;
		}
		return $data;
}
}


//function number 17
public function insert($table,$fields){

	if(is_array($fields)){
		$sql="insert into $table (";
		$fields_key=array_keys($fields);
		$i=0;
		foreach($fields_key as $key){
			$i++;
			$sql.=$key;
			if($i<count($fields)){
				$sql.=",";
			}

		}
		$sql.=") ";
		$sql.="values (";
		$i=0;	
		foreach($fields_key as $insert_value){
			$i++;
			$sql.=":".$insert_value;
			if($i<count($fields)){
				$sql.=",";

			}

		}	
		$sql.=")";	
        $q=$this->con->prepare($sql);
        foreach($fields_key as $key_to_bind){
        	$q->bindParam(':'.$key_to_bind,$fields[$key_to_bind]);
        }
        $q->execute();
        
		}

}

//function number 18
public function latest_inserted_id(){
	return $this->con->lastInsertId();
}


//function number 19

public function update($table,$fields,$condition){
	if(is_array($fields) && is_array($condition)){
		$sql="update $table set ";
		$fields_key=array_keys($fields);
		$i=0;
		foreach($fields_key as $key){
			$i++;
			$sql.=$key."=:".$key;
			if($i<count($fields)){
				$sql.=",";
			}
		}
		$sql.=" where ";
		$condition_key=array_keys($condition);
		$i=0;
		foreach($condition_key as $cond_key){
			$i++;
			$sql.=$cond_key."=".$condition[$cond_key];
			if($i<count($condition)){
				$sql.=" and ";
			}
		}
		//echo $sql;
		$q=$this->con->prepare($sql);
		foreach($fields_key as $key_to_bind){
			$q->bindParam(':'.$key_to_bind,$fields[$key_to_bind]);
		}
		$q->execute();
		//$q->debugDumpParams();
	}

}

//function number 20

public function delete($table,$condition){
	$sql="delete from $table where ";
	$condition_key=array_keys($condition);
	$i=0;
	foreach($condition_key as $key){
		$i++;
		$sql.=$key."=:".$key;
		if($i<count($condition)){
			$sql.=" and ";
		}
	}

	$q=$this->con->prepare($sql);
	foreach($condition_key as $key_to_bind){
		$q->bindParam(':'.$key_to_bind,$condition[$key_to_bind]);
	}
	$q->execute();
}

public function __destruct(){
	$this->con=null;
}


}


