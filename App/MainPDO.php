<?php

/*
   Dibuat oleh Rizky Maulana untuk keperluan PDO pada php
 */


class MainPDO
{
    private $conn;
    private $ds_name;

    public function __construct($config)
    {
	try
	{
	    $host = $config["host"];
	    $dbname = $config["dbname"];
	    $user = $config["user"];
	    $password = $config["password"];
	    
	    $this->ds_name = "mysql:host=".$host.";dbname=".$dbname;
	    $this->conn = new PDO($this->ds_name, $user, $password);
	    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	}
	catch(PDOException $e)
	{
	    echo "Koneksi bermasalah: ".$e->getMessage()."<br/>";
	    die();
	}
    }

    public function __destruct()
    {
	$this->conn = null;
    }

    public function ExecuteFetchMethod($query, $data = null, $fetchall=FALSE)
    {
	try
	{
	    if($data == null)
	    {
		$p_stmt = $this->conn->query($query);
		$items = $p_stmt->fetchAll();
		return $items;
	    }
	    else
	    {
		$p_stmt = $this->conn->prepare($query);
		$p_stmt->execute($data);
		if($fetchall == TRUE)
		{
		    $item = $p_stmt->fetchAll();
		}
		else
		{    
		    $item = $p_stmt->fetch();
		}
		
		return $item;
	    }
	}
	catch(PDOException $e)
	{
	    echo "Terjadi kesalahan<br/>";
	    return null;
	}
    }    

    public function ExecuteQueryMethod($query, $data, $update = false)
    {
	try
	{
	    $p_stmt = $this->conn->prepare($query);
	    $p_stmt->execute($data);
	    if($update == false)
	    {
		return $this->conn->lastInsertId();
	    }
	    else
	    {
		return -2;
	    }
	    
	}
	catch(PDOException $e)
	{
	    echo "Terjadi kesalahan dalam eksekusi";
	    return -1;
	}
    }


    // JSON stuff, LOL selalu lupa kalau fungsi ini ada...
    public function JsonResult_ExecuteFetchMethod($query)
    {
	$data = $this->ExecuteFetchMethod($query);
	return json_encode($data);
    }
}

?>
