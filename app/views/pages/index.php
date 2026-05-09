<?php
/**
 * Pages/Index View
 * 
 * @var array $data - Data passed from controller containing:
 *      - showReceipt (bool)
 *      - errorMsg (string)
 *      - rates (array)
 *      - reservation (object)
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo SITENAME; ?> | Home</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/sogohotelstlyes.css">
    </head>
    <body>

        <header>
            <a href="<?php echo URLROOT; ?>/admin/index"><img src="<?php echo URLROOT; ?>/assets/img/sogo_logo.jpg" alt="Hotel Sogo Logo"></a>
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
            <?php if (!empty($data['errorMsg'])): ?>
                <div class="error-banner" id="errorBanner">
                    Error: <?php echo $data['errorMsg']; ?>
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
                        <img src="<?php echo URLROOT; ?>/assets/img/regency.jpg" alt="Regency Room" class="room-img">
                        <h3 class="top-label">REGENCY</h3>
                        <div class="room-content">
                            <h2 class="room-title">REGENCY</h2>
                            <p>Enjoy a fully air-conditioned stay featuring an LED TV with cable and in-house movies. This room is also equipped with a dining table, hot and cold bath, and a relaxing bathtub.</p>
                            <button class="price-btn" onclick="openMappedModal('Regency', 'Regency')">
                                <span class="book-text">Select This Type</span>
                            </button>
                        </div>
                    </div>

                    <div class="room-card hidden hidden-bottom">
                        <img src="<?php echo URLROOT; ?>/assets/img/deluxe.jpg" alt="Deluxe Room" class="room-img">
                        <h3 class="top-label">DELUXE</h3>
                        <div class="room-content">
                            <h2 class="room-title">DELUXE</h2>
                            <p>The Deluxe Room offers spacious accommodation with all the essential amenities. It features air-conditioning, an LED TV with cable channels and in-house movies, plus a hot and cold shower.</p>
                            <button class="price-btn" onclick="openMappedModal('Deluxe', 'Deluxe')">
                                <span class="book-text">Select This Type</span>
                            </button>
                        </div>
                    </div>

                    <div class="room-card hidden hidden-bottom">
                        <img src="<?php echo URLROOT; ?>/assets/img/premium.jpg" alt="PREMIUM Room" class="room-img">
                        <h3 class="top-label">PREMIUM</h3>
                        <div class="room-content">
                            <h2 class="room-title">PREMIUM</h2>
                            <p>Perfect for travelers seeking a snug and cozy atmosphere. This room comes fully equipped with air-conditioning, an LED TV with cable channels and in-house movies, and a hot and cold shower.</p>
                            <button class="price-btn" onclick="openMappedModal('PREMIUM', 'Premium')">
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
                        <img src="<?php echo URLROOT; ?>/assets/img/sogo_aboutus.jpg" alt="Hotel Sogo Building">
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
                
                <form id="bookingForm" action="<?php echo URLROOT; ?>/pages/reserve" method="POST">
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
                            <option value="Family" id="option">Family</option>
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

        <?php if ($data['showReceipt']): ?>
            <?php 
                $res = $data['reservation']; 
                $date1 = new DateTime($res->checkin_date);
                $date2 = new DateTime($res->checkout_date);
                $days = $date1->diff($date2)->days;
                if($days < 1) $days = 1;

                // Simple rate calculation for display (same as in controller)
                $ratePerDay = $data['rates'][$res->room_capacity][$res->room_type] ?? 0;
                $initialAmount = $ratePerDay * $days;
                $totalPrice = $res->total_bill;
                $adjustmentAmount = abs($totalPrice - $initialAmount);
                $adjustmentLabel = "Adjustment";
                if ($res->mop == "Cash") {
                    if ($days >= 3 && $days <= 5) $adjustmentLabel = "10% Discount (3-5 Days)";
                    elseif ($days >= 6) $adjustmentLabel = "15% Discount (6+ Days)";
                    else $adjustmentLabel = "No add'l charge";
                } elseif ($res->mop == "Check") $adjustmentLabel = "5% Surcharge (Check)";
                elseif ($res->mop == "Credit Card") $adjustmentLabel = "10% Surcharge (Card)";
            ?>
            <div id="receiptModal" class="modal" style="display: block;">
                <div class="modal-content" style="text-align: center;">
                    <span class="close-btn" onclick="window.location.href='<?php echo URLROOT; ?>'">&times;</span>
                    
                    <img src="<?php echo URLROOT; ?>/assets/img/sogo_logo.jpg" alt="Logo" style="height: 60px;">
                    <h2 style="color: #a00000; margin: 10px 0;">Booking Receipt</h2>
                    
                    <div class="receipt-box">
                        <p><strong>Ref No:</strong> <?php echo $res->ref_no; ?></p>
                        <p><strong>Date Booked:</strong> <?php echo date("F j, Y"); ?></p>
                        <hr>
                        <p><strong>Guest:</strong> <?php echo $res->name; ?></p>
                        <p><strong>Capacity:</strong> <?php echo $res->room_capacity; ?></p>
                        <p><strong>Type:</strong> <?php echo $res->room_type; ?></p>
                        <p><strong>Duration:</strong> <?php echo $days; ?> Night(s)</p>
                        <p><strong>Check-in:</strong> <?php echo $res->checkin_date; ?></p>
                        <p><strong>Check-out:</strong> <?php echo $res->checkout_date; ?></p>
                        <hr>
                        <p><strong>Rate per Day:</strong> ₱<?php echo number_format($ratePerDay, 2); ?></p>
                        <p><strong>Subtotal:</strong> ₱<?php echo number_format($initialAmount, 2); ?></p>
                        <p><strong>Payment:</strong> <?php echo $res->mop; ?></p>
                        <p><strong>Adjustments:</strong> <?php echo $adjustmentLabel; ?> 
                        (<?php echo ($res->mop == "Cash" && $days >= 3) ? '-' : '+'; ?>₱<?php echo number_format($adjustmentAmount, 2); ?>)
                        </p>
                        <br>
                        <p style="font-size: 1.3rem; color: #a00000; font-weight: bold; text-align: right;">
                            TOTAL BILL: ₱<?php echo number_format($totalPrice, 2); ?>
                        </p>
                    </div>

                    <button class="submit-btn" onclick="window.print()" style="margin-top: 20px;">Print</button>
                    <button class="clear-btn" onclick="window.location.href='<?php echo URLROOT; ?>'" style="margin-top: 10px;">New Booking</button>
                </div>
            </div>
        <?php endif; ?>

        <script src="<?php echo URLROOT; ?>/assets/js/hotelsogoscript.js" defer></script>
    </body>
</html>
