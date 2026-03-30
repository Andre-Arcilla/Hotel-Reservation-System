<?php
    // --- Database connection ---
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'hotelsogo_db';
    $dbHost = 'localhost';

    try {
        // Establishing the connection
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    date_default_timezone_set('Asia/Manila');

    // --- PHP LOGIC & CALCULATIONS ---
    $showReceipt = false;
    $errorMsg = ""; 
    $refNo = "";
    $dateBooked = "";
    $guestName = "";
    $contact = "";
    $email = "";

    $roomType = "";     
    $roomCapacity = ""; 
    $checkinDate = "";
    $checkoutDate = "";
    $checkinTime = "";  
    $paymentMethod = "";
    $days = 0;

    $ratePerDay = 0;
    $initialAmount = 0;
    $adjustmentAmount = 0; 
    $adjustmentLabel = ""; 
    $totalPrice = 0;

    // Data Matrix
    $rates = [
        'Single' => ['Regency' => 2500, 'Deluxe' => 3500, 'Premium' => 5000],
        'Double' => ['Regency' => 3000, 'Deluxe' => 4000, 'Premium' => 5500],
        'Family' => ['Regency' => 3000, 'Deluxe' => 5000, 'Premium' => 7000],
    ];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validation
        if (empty($_POST['room_capacity']) || $_POST['room_capacity'] == "default") {
            $errorMsg = "No selected room capacity";
        }
        elseif (empty($_POST['room_type'])) {
            $errorMsg = "No selected room type";
        }
        elseif (empty($_POST['payment_method']) || $_POST['payment_method'] == "default") {
            $errorMsg = "No selected type of payment";
        }
        elseif (empty($_POST['checkin_date']) || empty($_POST['checkout_date'])) {
            $errorMsg = "Please complete check-in and check-out dates.";
        }
        elseif (empty($_POST['checkin_date']) || empty($_POST['checkout_date'])) {
            $errorMsg = "Please complete check-in and check-out dates.";
        }
        // NEW: Backend Logic to prevent past dates
        elseif (strtotime($_POST['checkin_date']) < strtotime(date('Y-m-d'))) {
            $errorMsg = "Check-in date cannot be in the past.";
        }
        // NEW: Backend Logic to prevent Checkout <= Checkin
        elseif (strtotime($_POST['checkout_date']) <= strtotime($_POST['checkin_date'])) {
            $errorMsg = "Check-out date must be at least one day after check-in.";
        }
        else {
            // Calculation
            $firstName = htmlspecialchars($_POST['first_name']);
            $lastName = htmlspecialchars($_POST['last_name']);
            $guestName = $firstName . " " . $lastName;
            $contact = htmlspecialchars($_POST['contact']);
            $email = htmlspecialchars($_POST['email']);
            
            $checkinDate = $_POST['checkin_date'];
            $checkoutDate = $_POST['checkout_date'];
            $checkinTime = date("H:i:s"); 
            
            $roomCapacity = $_POST['room_capacity']; 
            $roomType = $_POST['room_type'];         
            $paymentMethod = $_POST['payment_method'];

            $date1 = new DateTime($checkinDate);
            $date2 = new DateTime($checkoutDate);
            $interval = $date1->diff($date2);
            $days = $interval->days;
            if ($days < 1) { $days = 1; } 

            if (isset($rates[$roomCapacity][$roomType])) {
                $ratePerDay = $rates[$roomCapacity][$roomType];
            }

            $initialAmount = $ratePerDay * $days;

            // Payment Logic
            $adjustmentAmount = 0;
            $adjustmentLabel = "None";

            if ($paymentMethod == "Cash") {
                if ($days >= 3 && $days <= 5) {
                    $adjustmentAmount = $initialAmount * 0.10; 
                    $adjustmentLabel = "10% Discount (3-5 Days)";
                    $totalPrice = $initialAmount - $adjustmentAmount;
                } elseif ($days >= 6) {
                    $adjustmentAmount = $initialAmount * 0.15; 
                    $adjustmentLabel = "15% Discount (6+ Days)";
                    $totalPrice = $initialAmount - $adjustmentAmount;
                } else {
                    $adjustmentLabel = "No add'l charge";
                    $totalPrice = $initialAmount;
                }
            } elseif ($paymentMethod == "Check") {
                $adjustmentAmount = $initialAmount * 0.05; 
                $adjustmentLabel = "5% Surcharge (Check)";
                $totalPrice = $initialAmount + $adjustmentAmount;
            } elseif ($paymentMethod == "Credit Card") {
                $adjustmentAmount = $initialAmount * 0.10; 
                $adjustmentLabel = "10% Surcharge (Card)";
                $totalPrice = $initialAmount + $adjustmentAmount;
            }

            $refNo = "SOGO-" . strtoupper(uniqid());
            $dateBooked = date("F j, Y");
            $showReceipt = true;

            // 1. Prepare the SQL template using the column names from your CREATE TABLE
            $sql = "INSERT INTO reservations (
                        ref_no, name, contact, email, 
                        room_capacity, room_type, 
                        checkin_date, checkout_date, 
                        total_bill, mop
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $pdo->prepare($sql);

            // 2. Execute and send the variables in the EXACT same order as the list above
            $stmt->execute([
                $refNo,            // ref_no
                $guestName,        // name
                $contact,          // contact
                $email,            // email
                $roomCapacity,     // room_capacity
                $roomType,         // room_type
                $checkinDate,      // checkin_date
                $checkoutDate,     // checkout_date
                $totalPrice,       // total_bill
                $paymentMethod     // mop
            ]);

            header("Location: client.php?status=success&ref=" . $refNo);
            exit();
        }
    }
?>