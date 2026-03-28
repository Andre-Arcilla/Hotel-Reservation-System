<?php
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
    'Single' => ['Regular' => 100, 'De Luxe' => 300, 'Suite' => 500],
    'Double' => ['Regular' => 200, 'De Luxe' => 500, 'Suite' => 800],
    'Family' => ['Regular' => 500, 'De Luxe' => 750, 'Suite' => 1000],
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
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Sogo | Machine Problem 1</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="sogohotelstlyes.css?v=<?php echo time(); ?>">
</head>
<body>

    <header>
        <a href="#home"><img src="./assets/sogo_logo.jpg" alt="Hotel Sogo Logo"></a>
        <nav>
            <ul>
                <li><a href="#home" class="nav-link">Home</a></li>
                <li><a href="#rooms" class="nav-link">Rooms</a></li>
                <li><a href="#about" class="nav-link">About</a></li>
                <li><a href="#contact" class="nav-link">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php if (!empty($errorMsg)): ?>
            <div class="error-banner" id="errorBanner">
                ⚠️ Error: <?php echo $errorMsg; ?>
                <br>
                <button onclick="window.history.back()" style="margin-top:10px; padding:5px 10px;">Go Back</button>
            </div>
        <?php endif; ?>

        <section id="home">
            <div id="home-text" class="hidden hidden-bottom">
                <h1 id="welcome">Welcome to</h1> 
                <h1 id="hotel-name">Hotel Sogo</h1>
            </div>
            <p class="hidden hidden-bottom">So Clean... So Good</p>
            <button id="explore" class="hidden hidden-bottom" onclick="document.getElementById('rooms').scrollIntoView({behavior: 'smooth'})">
                Explore Rooms
            </button>
        </section>

       <section id="rooms">
    <h1 class="hidden hidden-bottom">Select a Room Type</h1>
    <div class="room-container">
        
        <div class="room-card hidden hidden-bottom">
            <img src="./assets/regency.jpg" alt="Regency Room" class="room-img">
            <h3 class="top-label">REGENCY</h3>
            <div class="room-content">
                <h2 class="room-title">REGENCY</h2>
                <p>Mapped to: <strong>Regular</strong></p>
                <p>Enjoy a fully air-conditioned stay featuring an LED TV with cable and in-house movies. This room is also equipped with a dining table, hot and cold bath, and a relaxing bathtub.</p>
                <button class="price-btn" onclick="openMappedModal('Regency', 'Regular')">
                    <span class="book-text">Select This Type</span>
                </button>
            </div>
        </div>

        <div class="room-card hidden hidden-bottom">
            <img src="./assets/deluxe.jpg" alt="Deluxe Room" class="room-img">
            <h3 class="top-label">DELUXE</h3>
            <div class="room-content">
                <h2 class="room-title">DELUXE</h2>
                <p>Mapped to: <strong>De Luxe</strong></p>
                <p>The Deluxe Room offers spacious accommodation with all the essential amenities. It features air-conditioning, an LED TV with cable channels and in-house movies, plus a hot and cold shower.</p>
                <button class="price-btn" onclick="openMappedModal('Deluxe', 'De Luxe')">
                    <span class="book-text">Select This Type</span>
                </button>
            </div>
        </div>

        <div class="room-card hidden hidden-bottom">
            <img src="./assets/premium.jpg" alt="PREMIUM Room" class="room-img">
            <h3 class="top-label">PREMIUM</h3>
            <div class="room-content">
                <h2 class="room-title">PREMIUM</h2>
                <p>Mapped to: <strong>Suite</strong></p>
                <p>Perfect for travelers seeking a snug and cozy atmosphere. This room comes fully equipped with air-conditioning, an LED TV with cable channels and in-house movies, and a hot and cold shower.</p>
                <button class="price-btn" onclick="openMappedModal('PREMIUM', 'Suite')">
                    <span class="book-text">Select This Type</span>
                </button>
            </div>
        </div>

    </div>
</section>

        <section id="about">
            <div class="about-container">
                <div class="about-text hidden hidden-bottom">
                    <h1>About Us</h1>
                    <p>
                        Founded in 1992 by a hotel veteran and a master contractor, 
                        Hotel Sogo opened its first branch in 1993 to redefine low-cost lodging. 
                        Built on the core values of cleanliness, innovation, and courtesy, 
                        we provide Japanese-standard service—from our traditional welcoming bow 
                        to our industry-first 24-hour Guest Assistance SMS Center.
                    </p>
                </div>
                <div class="about-image hidden hidden-bottom">
                    <img src="./assets/sogo_aboutus.jpg" alt="Hotel Sogo Building">
                </div>
            </div>
        </section>

        <section id="contact">
            <div class="contact-us-container">
                <div class="contact-us-text hidden hidden-bottom">
                    <h1>Contact Us</h1>
                    <p>
                        We are here to serve you 24/7. Whether you have a question about our rates,
                        need to make a reservation, or want to share your experience,
                        our team is ready to assist.
                    </p>
                </div>
                <div class="hotline hidden hidden-right">
                    <ul>
                        <li><strong>Central Hotline:</strong> 87900-900</li>
                        <li><strong>Mobile (Global):</strong> +63 922-857-7646</li>
                        <li><strong>Email:</strong> reservations@hotelsogo.com</li>
                        <li><strong>Operating Hours:</strong> 24 Hours a day, 7 days a week</li>
                    </ul>
                </div>
            </div>
        </section>

    </main>

    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Reservation: <span id="displayRoomName"></span></h2>
            <p style="font-size: 0.9rem; color: #666;">Type: <span id="displayMappedType" style="font-weight:bold;"></span></p>
            
            <form id="bookingForm" action="" method="POST">
                <input type="hidden" id="hiddenRoomType" name="room_type">

                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" required>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" required>
                </div>
                
                <div class="form-group">
                    <label>Room Capacity <span style="color:red">*</span></label>
                    <select name="room_capacity" required>
                        <option value="default" disabled selected>-- Select Capacity --</option>
                        <option value="Single">Single</option>
                        <option value="Double">Double</option>
                        <option value="Family">Family</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="tel" name="contact" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email">
                </div>
                <div class="form-group">
                    <label>Check-in Date</label>
                    <input type="date" id="checkinDate" name="checkin_date" required>
                </div>
                <div class="form-group">
                    <label>Check-out Date</label>
                    <input type="date" id="checkoutDate" name="checkout_date" required>
                </div>

                <div class="form-group">
                    <label>Type of Payment <span style="color:red">*</span></label>
                    <select name="payment_method" required>
                        <option value="default" disabled selected>-- Select Payment --</option>
                        <option value="Cash">Cash</option>
                        <option value="Check">Check</option>
                        <option value="Credit Card">Credit Card</option>
                    </select>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="submit-btn">Submit Reservation</button>
                    <button type="button" class="clear-btn" onclick="clearForm()">Clear</button>
                </div>
            </form>
        </div>
    </div>

    <?php if ($showReceipt): ?>
    <div id="receiptModal" class="modal" style="display: block;">
        <div class="modal-content" style="text-align: center;">
            <span class="close-btn" onclick="document.getElementById('receiptModal').style.display='none'">&times;</span>
            
            <img src="./assets/sogo_logo.jpg" alt="Logo" style="height: 60px;">
            <h2 style="color: #a00000; margin: 10px 0;">Booking Receipt</h2>
            
            <div class="receipt-box">
                <p><strong>Ref No:</strong> <?php echo $refNo; ?></p>
                <p><strong>Date Booked:</strong> <?php echo $dateBooked; ?></p>
                <hr>
                <p><strong>Guest:</strong> <?php echo $guestName; ?></p>
                <p><strong>Capacity:</strong> <?php echo $roomCapacity; ?></p>
                <p><strong>Type:</strong> <?php echo $roomType; ?></p>
                <p><strong>Duration:</strong> <?php echo $days; ?> Night(s)</p>
                <p><strong>Check-in:</strong> <?php echo $checkinDate . " @ " . date("g:i a", strtotime($checkinTime)); ?></p>
                <p><strong>Check-out:</strong> <?php echo $checkoutDate; ?></p>
                <hr>
                <p><strong>Rate per Day:</strong> ₱<?php echo number_format($ratePerDay, 2); ?></p>
                <p><strong>Subtotal:</strong> ₱<?php echo number_format($initialAmount, 2); ?></p>
                <p><strong>Payment:</strong> <?php echo $paymentMethod; ?></p>
                <p><strong>Adjustments:</strong> <?php echo $adjustmentLabel; ?> 
                   (<?php echo ($paymentMethod == "Cash" && $days >= 3) ? '-' : '+'; ?>₱<?php echo number_format($adjustmentAmount, 2); ?>)
                </p>
                <br>
                <p style="font-size: 1.3rem; color: #a00000; font-weight: bold; text-align: right;">
                    TOTAL BILL: ₱<?php echo number_format($totalPrice, 2); ?>
                </p>
            </div>

            <button class="submit-btn" onclick="window.print()" style="margin-top: 20px;">Print</button>
            <button class="clear-btn" onclick="window.location.href='index.php'" style="margin-top: 10px;">New Booking</button>
        </div>
    </div>
    <?php endif; ?>

    <script src="hotelsogoscript.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>