<?php

class Admin extends Controller {
    private $reservationModel;

    public function __construct() {
        $this->reservationModel = $this->model('Reservation');
    }

    public function index() {
        $reservations = $this->reservationModel->getReservations();
        $data = [
            'reservations' => $reservations,
            'page' => $_GET['page'] ?? 'dashboard',
            'tab' => $_GET['tab'] ?? 'pending'
        ];
        $this->view('admin/index', $data);
    }

    public function delete($id) {
        if ($this->reservationModel->deleteReservation($id)) {
            header('Location: ' . URLROOT . '/admin/index?page=booking&status=deleted');
        } else {
            die('Something went wrong');
        }
    }

    public function update_status() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $status = $_POST['status'];
            if ($this->reservationModel->updateStatus($id, $status)) {
                echo "Done";
            } else {
                echo "Error";
            }
        }
    }
}
