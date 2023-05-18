<?php
class Buyer
{
    private $db;
    private $table;
    /**
    * User constructor.
    * @param null $data
    */
    public function __construct()
    {
        $this->db = new Database;
        $this->table = 'buyer';
    }
    public function index()
    {
        $this->db->query('SELECT * FROM '.$this->table);
        $data['data'] = $this->db->resultSet();
        
        $this->db->query('SELECT entry_by FROM '.$this->table.' Group by entry_by');
        $data['users'] = $this->db->resultSet();
        
        return $data;
    }
    public function store($data)
    {
        $this->db->query('INSERT INTO '.$this->table.' (amount, buyer, receipt_id, items, buyer_email, buyer_ip, note, city, phone, hash_key, entry_at, entry_by) VALUES(:amount, :buyer, :receipt_id, :items, :buyer_email, :buyer_ip, :note, :city, :phone, :hash_key, :entry_at, :entry_by)');
        $this->db->bind(':amount', $data['amount'], PDO::PARAM_INT);
        $this->db->bind(':buyer', $data['buyer']);
        $this->db->bind(':receipt_id', $data['receipt_id'], PDO::PARAM_INT);
        $this->db->bind(':items', $data['items']);
        $this->db->bind(':buyer_email', $data['buyer_email']);
        $this->db->bind(':buyer_ip', $data['buyer_ip']);
        $this->db->bind(':note', $data['note']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':phone', $data['phone'], PDO::PARAM_INT);
        $this->db->bind(':hash_key', $data['hash_key']);
        $this->db->bind(':entry_at', $data['entry_at']);
        $this->db->bind(':entry_by', $data['entry_by'], PDO::PARAM_INT);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM '.$this->table.' Where id='.$id);
        return $this->db->execute();
    }

    public function search($datepicker = null, $user_id = null)
    {
        $datepicker = explode(' - ', $datepicker);

        if ($this->validateDate(trim($datepicker[0]))) {
            $star_date = $datepicker[0];
        }

        if ($this->validateDate(trim($datepicker[1]))) {
            $end_date = $datepicker[1];
        }

        if (!is_null($user_id)) {
            $userID = (int) $user_id;
        }

        $query = 'SELECT * FROM '.$this->table;

        if (isset($star_date)) {
            $query .= ' where date(entry_at) >= "'.$star_date.'"';
        }

        if (isset($end_date)) {
            $query .= ' And date(entry_at) <= "'.$end_date.'"';
        }

        if (isset($userID)) {
            $query .= ' And entry_by = '.$userID;
        }
        
        $this->db->query($query);
        $data['data'] = $this->db->resultSet();
        
        $this->db->query('SELECT entry_by FROM '.$this->table.' Group by entry_by');
        $data['users'] = $this->db->resultSet();
        
        return $data;
    }

    private function validateDate($date, $format = 'Y-m-d') {
        $dateTime = DateTime::createFromFormat($format, $date);
        return $dateTime && $dateTime->format($format) === $date;
    }
}
?>