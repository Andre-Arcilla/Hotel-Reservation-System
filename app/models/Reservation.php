<?php

class Reservation {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getReservations() {
        $this->db->query('SELECT * FROM reservations ORDER BY id DESC');
        return $this->db->resultSet();
    }

    public function addReservation($data) {
        $this->db->query('INSERT INTO reservations (ref_no, name, contact, email, room_capacity, room_type, checkin_date, checkout_date, total_bill, mop) VALUES (:ref_no, :name, :contact, :email, :room_capacity, :room_type, :checkin_date, :checkout_date, :total_bill, :mop)');
        
        $this->db->bind(':ref_no', $data['ref_no']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':contact', $data['contact']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':room_capacity', $data['room_capacity']);
        $this->db->bind(':room_type', $data['room_type']);
        $this->db->bind(':checkin_date', $data['checkin_date']);
        $this->db->bind(':checkout_date', $data['checkout_date']);
        $this->db->bind(':total_bill', $data['total_bill']);
        $this->db->bind(':mop', $data['mop']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getReservationByRef($ref) {
        $this->db->query('SELECT * FROM reservations WHERE ref_no = :ref');
        $this->db->bind(':ref', $ref);
        return $this->db->single();
    }

    public function deleteReservation($id) {
        $this->db->query('DELETE FROM reservations WHERE id = :id');
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateStatus($id, $status) {
        // Note: The 'status' column might need to be added to the database if it doesn't exist
        $this->db->query('UPDATE reservations SET status = :status WHERE id = :id');
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
