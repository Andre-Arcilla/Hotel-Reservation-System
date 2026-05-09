<?php

class Pages extends Controller {
    private $reservationModel;

    public function __construct() {
        $this->reservationModel = $this->model('Reservation');
    }

    public function index() {
        $data = [
            'showReceipt' => false,
            'errorMsg' => '',
            'rates' => [
                'Single' => ['Regency' => 2500, 'Deluxe' => 3500, 'Premium' => 5000],
                'Double' => ['Regency' => 3000, 'Deluxe' => 4000, 'Premium' => 5500],
                'Family' => ['Regency' => 3000, 'Deluxe' => 5000, 'Premium' => 7000],
            ]
        ];

        if (isset($_GET['status']) && $_GET['status'] == 'success' && isset($_GET['ref'])) {
            $reservation = $this->reservationModel->getReservationByRef($_GET['ref']);
            if ($reservation) {
                $data['showReceipt'] = true;
                $data['reservation'] = $reservation;
            }
        }

        $this->view('pages/index', $data);
    }

    public function reserve() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Logic from client_submit.php
            $rates = [
                'Single' => ['Regency' => 2500, 'Deluxe' => 3500, 'Premium' => 5000],
                'Double' => ['Regency' => 3000, 'Deluxe' => 4000, 'Premium' => 5500],
                'Family' => ['Regency' => 3000, 'Deluxe' => 5000, 'Premium' => 7000],
            ];

            // Validation (simplified for now, but should match client_submit.php)
            $firstName = htmlspecialchars($_POST['first_name']);
            $lastName = htmlspecialchars($_POST['last_name']);
            $guestName = $firstName . " " . $lastName;
            $contact = htmlspecialchars($_POST['contact']);
            $email = htmlspecialchars($_POST['email']);
            
            $checkinDate = $_POST['checkin_date'];
            $checkoutDate = $_POST['checkout_date'];
            
            $roomCapacity = $_POST['room_capacity']; 
            $roomType = $_POST['room_type'];         
            $paymentMethod = $_POST['payment_method'];

            $date1 = new DateTime($checkinDate);
            $date2 = new DateTime($checkoutDate);
            $interval = $date1->diff($date2);
            $days = $interval->days;
            if ($days < 1) { $days = 1; } 

            $ratePerDay = $rates[$roomCapacity][$roomType] ?? 0;
            $initialAmount = $ratePerDay * $days;

            $totalPrice = $initialAmount;
            if ($paymentMethod == "Cash") {
                if ($days >= 3 && $days <= 5) {
                    $totalPrice = $initialAmount * 0.90; 
                } elseif ($days >= 6) {
                    $totalPrice = $initialAmount * 0.85; 
                }
            } elseif ($paymentMethod == "Check") {
                $totalPrice = $initialAmount * 1.05; 
            } elseif ($paymentMethod == "Credit Card") {
                $totalPrice = $initialAmount * 1.10; 
            }

            $refNo = "SOGO-" . strtoupper(uniqid());

            $reservationData = [
                'ref_no' => $refNo,
                'name' => $guestName,
                'contact' => $contact,
                'email' => $email,
                'room_capacity' => $roomCapacity,
                'room_type' => $roomType,
                'checkin_date' => $checkinDate,
                'checkout_date' => $checkoutDate,
                'total_bill' => $totalPrice,
                'mop' => $paymentMethod
            ];

            if ($this->reservationModel->addReservation($reservationData)) {
                if (isset($_POST['from_admin']) && $_POST['from_admin'] == '1') {
                    header('Location: ' . URLROOT . '/admin/index?page=booking&status=success&ref=' . $refNo);
                } else {
                    header('Location: ' . URLROOT . '/pages/index?status=success&ref=' . $refNo);
                }
            } else {
                die('Something went wrong');
            }
        } else {
            header('Location: ' . URLROOT . '/pages/index');
        }
    }
}
