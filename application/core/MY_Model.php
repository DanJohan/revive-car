<?php

class MY_Model extends CI_Model
{
  protected $table;
  public $where_arr = NULL;
  public $order_by_arr = NULL;
  public $cols_sel = NULL;
  public $cols_upd = NULL;

  function __construct()
  {
    parent::__construct();
  }

  /** retrieve all records from DB
   *
   * @param array $where_arr
   * @param var|array $order_by_var_arr
   * @param var $select
   * @return object
   */
  public function get_all($where_arr = NULL, $order_by_var_arr = NULL, $select = NULL)
  {
    if(isset($where_arr))
    {
      $this->db->where($where_arr);
    }
    if(isset($order_by_var_arr))
    {
      if(!is_array($order_by_var_arr))
      {
        $order_by[0] = $order_by_var_arr;
        $order_by[1] = 'asc';
      }
      else
      {
        $order_by[0] = $order_by_var_arr[0];
        $order_by[1] = $order_by_var_arr[1];
      }
      $this->db->order_by($order_by[0],$order_by[1]);
    }
    if(isset($select))
    {
      $this->db->select($select);
    }
    $query = $this->db->get($this->table);

    //echo $this->db->last_query();

    if($query->num_rows()>0)
    {
      foreach($query->result_array() as $row)
      {
        $data[] = $row;
        
      }
      return $data;
    }
    else
    {
      return FALSE;
    }
  }

  /**
   * Retrieve one record from DB
   * @param type $where_arr
   * @return object
   */
  public function get($where_arr = NULL)
  {
    if(isset($where_arr))
    {
      $this->db->where($where_arr);
      $this->db->limit(1);
      $query = $this->db->get($this->table);
      if($query->num_rows()>0)
      {
        return $query->row_array();
      }
      else
      {
        return FALSE;
      }
    }
    else
    {
      return FALSE;
    }
  }
  /**
   * Insert a record into DB
   * @param type $columns_arr
   * @return int insert id
  */
  public function insert($columns_arr)
  {
//print_r($columns_arr);die;

    if(is_array($columns_arr))
    {
 
      if($this->db->insert($this->table,$columns_arr))
      {
      
        return $this->db->insert_id();
      }
      else
      {
        return FALSE;
      }
    }
  }

  public function insert_batch($columns_arr){
    if(is_array($columns_arr)) {
      if($this->db->insert_batch($this->table,$columns_arr)){
        return true;
      }
    }
    return false;
  }
  /**
   * Update record(s)
   * @param type $columns_arr
   * @param type $where_arr
   * @return int affected rows
  */
  public function update($columns_arr, $where_arr = NULL)
  {
    if(isset($where_arr))
    {
      $this->db->where($where_arr);
      $this->db->update($this->table,$columns_arr);
      if($this->db->affected_rows()>0)
      {
        return $this->db->affected_rows();
      }
    }
    else
    {
      return FALSE;
    }
  }
  /**
   * Delete row(s)
   * @param type $where_arr
   * @return int affected rows
  */
  public function delete($where_arr = NULL)
  {
   
    if(isset($where_arr))
    {
      $this->db->where($where_arr);
      $this->db->delete($this->table);
      return $this->db->affected_rows();
    }
    else
    {
      return FALSE;
    }
  }

      /*
     * get rows from the users table
     */
    public function search($params = array(),$backtick=true){

        if(array_key_exists('field', $params)){
          $this->db->select($params['field'],$backtick);
        }else{
          $this->db->select('*');
        }

        $this->db->from($this->table);

        if(array_key_exists('join', $params)){
          foreach ($params['join'] as $index => $condition) {
              $this->db->join($condition[0],$condition[1],$condition[2]);
          }
        }
        
        //fetch data by conditions
        if(array_key_exists("conditions",$params)){
            foreach ($params['conditions'] as $key => $value) {
                $this->db->where($key,$value);
            }
        }
        
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
            $result = $query->num_rows();
        }elseif(array_key_exists("returnType",$params) && $params['returnType'] == 'single'){
            $result = ($query->num_rows() > 0)?$query->row_array():FALSE;
        }else{
            $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
        }

        //return fetched data
        return $result;
    }
}