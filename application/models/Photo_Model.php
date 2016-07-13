<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Photo_Model extends CI_Model
{
  public $id;
  public $name;
  public $desc;
  public $date;
  public $location;
  public $link_thumb;
  public $link_small;

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function get($offset = 0, $order_field, $order)
  {
    $limit = 18;
    //$offset = $offset * 12;
    $this->db->limit($limit, $offset);
    $this->db->order_by($order_field, $order);
    $query = $this->db->get('photos');

    return $query->result_array();
  }

  public function get_by_id($id)
  {
    $query = $this->db->get_where('photos', array('id'=>$id));

    return $query->row_array();
  }

  public function persist($photo)
  {
    $photo['date'] = date('Y-m-d', strtotime($photo['date']));
    $bool = $this->db->insert('photos', $photo);

    return $bool;
  }

  public function delete($id)
  {
    $bool = $this->db->delete('photos', array('id' => $id));

    return $bool;
  }

  public function update($id, $photo)
  {
    $this->db->where('id', $id);
    $photo['date'] = date('Y-m-d', strtotime($photo['date']));
    $bool = $this->db->update('photos', $photo);

    return $bool;
  }

  public function record_count() {
    return $this->db->count_all('photos');
  }
}
