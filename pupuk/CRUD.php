<?php 

/**
* 
*/
include 'database.php';
class CRUD 
{
    private $db;
    function __construct()
    {
        $this->db = DB::connect();
    }

    public function log_in($username, $password) {
        $sql = "SELECT * FROM admin where username = :username AND password = :password";
        try {
            $pdo = $this->db->prepare($sql);

            $pdo->execute(array(':username' => $username, ':password' => $password));
            $pdo->fetchAll();

            return $pdo->rowCount() > 0 ? true : false;
            

        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
    public function getRows($table,$conditions = array()){
        $sql = 'SELECT ';
        $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
        $sql .= ' FROM '.$table;
        if(array_key_exists("where",$conditions)){
            $sql .= ' WHERE ';
            $i = 0;
            foreach($conditions['where'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }

        if(array_key_exists("order_by",$conditions)){
            $sql .= ' ORDER BY '.$conditions['order_by']; 
        }

        if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit']; 
        }elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['limit']; 
        }

        $query = $this->db->prepare($sql);
        $query->execute();

        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
            switch($conditions['return_type']){
                case 'count':
                $data = $query->rowCount();
                break;
                case 'single':
                $data = $query->fetch(PDO::FETCH_ASSOC);
                break;
                default:
                $data = '';
            }
        }else{
            if($query->rowCount() > 0){
                $data = $query->fetchAll();
            }
        }
        return !empty($data)?$data:false;
    }

    /*
     * Insert data into the database
     * @param string name of the table
     * @param array the data for inserting into the table
     */
    
    public function insert($table,$data){
        if(!empty($data) && is_array($data)){
            $columns = '';
            $values  = '';
            $i = 0;
            // if(!array_key_exists('created',$data)){
            //     $data['created'] = date("Y-m-d H:i:s");
            // }
            // if(!array_key_exists('modified',$data)){
            //     $data['modified'] = date("Y-m-d H:i:s");
            // }

            $columnString = implode(',', array_keys($data));
            $valueString = ":".implode(',:', array_keys($data));
            $sql = "INSERT INTO ".$table." (".$columnString.") VALUES (".$valueString.")";
            $query = $this->db->prepare($sql);
            foreach($data as $key=>$val){
                $query->bindValue(':'.$key, $val);
            }
            $insert = $query->execute();
            return $insert?$this->db->lastInsertId():false;
        }else{
            return false;
        }
    }
    
    /*
     * Update data into the database
     * @param string name of the table
     * @param array the data for updating into the table
     * @param array where condition on updating data
     */
    public function update($table,$data,$conditions){
        if(!empty($data) && is_array($data)){
            $colvalSet = '';
            $whereSql = '';
            $i = 0;
            // if(!array_key_exists('modified',$data)){
            //     $data['modified'] = date("Y-m-d H:i:s");
            // }
            foreach($data as $key=>$val){
                $pre = ($i > 0)?', ':'';
                $colvalSet .= $pre.$key."='".$val."'";
                $i++;
            }
            if(!empty($conditions)&& is_array($conditions)){
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach($conditions as $key => $value){
                    $pre = ($i > 0)?' AND ':'';
                    $whereSql .= $pre.$key." = '".$value."'";
                    $i++;
                }
            }
            $sql = "UPDATE ".$table." SET ".$colvalSet.$whereSql;
            $query = $this->db->prepare($sql);
            $update = $query->execute();
            return $update?$query->rowCount():false;
        }else{
            return false;
        }
    }
    
    /*
     * Delete data from the database
     * @param string name of the table
     * @param array where condition on deleting data
     */
    public function delete($table,$conditions){
        $whereSql = '';
        if(!empty($conditions)&& is_array($conditions)){
            $whereSql .= ' WHERE ';
            $i = 0;
            foreach($conditions as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $whereSql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }
        $sql = "DELETE FROM ".$table.$whereSql;
        $delete = $this->db->exec($sql);
        return $delete?$delete:false;
    }


    public function get_anggota() {
        $sql = 'SELECT * FROM anggota';
        try {
            $pdo = $this->db->prepare($sql);
            $pdo->execute();
            return $pdo->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function get_pupuk_by_id($id_pupuk) {
        $sql = "SELECT * from pupuk WHERE id_pupuk = '$id_pupuk' ";
        try {
            $pdo = $this->db->prepare($sql);
            $pdo->execute();
            return $pdo->fetch();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function create_tmp_penjualan() {
        $sql = "
        CREATE TEMPORARY TABLE tmp_penjualan (
        `id_pupuk` int(11) NOT NULL,
        `nama_pupuk` varchar(50) NOT NULL,
        `stock_pupuk` mediumint(9) NOT NULL,
        `kuantitas` mediumint(9) NOT NULL,
        `harga_per_kg` mediumint(9) NOT NULL

        )";
        $pdo = $this->db->prepare($sql);
        $pdo->execute();
    }

    public function insert_tmp_penjualan($id_pupuk, $kuantitas) {
        $sql = "INSERT INTO tmp_penjualan (id_pupuk, nama_pupuk, stock_pupuk, harga_per_kg, kuantitas) SELECT id_pupuk, nama_pupuk, stock_pupuk, harga_per_kg, $kuantitas FROM pupuk where id_pupuk = $id_pupuk";
        try {

            $pdo = $this->db->prepare($sql);
            $pdo->execute();
            return $id_pupuk;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function insert_tmp_penyediaan($id_pupuk, $kuantitas, $harga_per_kg) {
        $sql = "INSERT INTO tmp_penyediaan (id_pupuk, nama_pupuk, kuantitas, harga_per_kg) SELECT id_pupuk, nama_pupuk, $kuantitas, $harga_per_kg FROM pupuk where id_pupuk = $id_pupuk";
        try {

            $pdo = $this->db->prepare($sql);
            $pdo->execute();
            return $id_pupuk;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function get_tmp_penjualan () {
        $sql = "SELECT * FROM  tmp_penjualan";
        $pdo = $this->db->prepare($sql);
        $pdo->execute();
        return $pdo->fetchAll();
    }


    public function delete_table($table) {
        $sql = "DELETE * FROM $table";
        $pdo = $this->db->prepare($sql);
        $pdo->execute();
        return execute();
    }
}
?>