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
        <title>Sogo Hotel — Admin</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            :root {
                --red:#D72638; --red-dark:#A81D2A; --red-glow:rgba(215,38,56,0.13);
                --bg:#F0F0F2; --card-bg:#FFFFFF; --border:#E8E8EF;
                --text-dark:#1A1A2E; --text-mid:#5A5A72; --text-light:#9898A8;
                --radius-sm:10px; --radius-md:14px; --radius-lg:20px;
                --shadow-sm:0 1px 4px rgba(26,26,46,0.07);
                --shadow-md:0 4px 20px rgba(26,26,46,0.12);
                --shadow-red:0 6px 20px rgba(215,38,56,0.28);
                --font:'DM Sans',sans-serif; --font-d:'DM Serif Display',serif;
                --sidebar-w:240px; --tr:0.22s cubic-bezier(.4,0,.2,1);
            }
            *{margin:0;padding:0;box-sizing:border-box;}
            html,body{height:100%;}
            body{font-family:var(--font);background:var(--bg);display:flex;height:100vh;overflow:hidden;color:var(--text-dark);}

            /* ── Sidebar ── */
            .sidebar{width:var(--sidebar-w);background:#fff;display:flex;flex-direction:column;border-right:1px solid var(--border);flex-shrink:0;z-index:20;}
            .logo-area{padding:22px 20px;display:flex;align-items:center;gap:12px;border-bottom:1px solid var(--border);}
            .logo-badge{width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,var(--red),var(--red-dark));display:flex;align-items:center;justify-content:center;box-shadow:var(--shadow-red);flex-shrink:0;}
            .logo-badge i{color:#fff;font-size:1rem;}
            .logo-text .brand{display:block;font-family:var(--font-d);font-size:1.05rem;color:var(--text-dark);}
            .logo-text .sub{display:block;font-size:0.62rem;font-weight:500;color:var(--text-light);letter-spacing:1.5px;text-transform:uppercase;}
            .nav-section{padding:16px 14px;flex:1;display:flex;flex-direction:column;gap:3px;}
            .nav-label{font-size:0.6rem;font-weight:700;color:var(--text-light);letter-spacing:2px;text-transform:uppercase;padding:0 8px;margin:10px 0 5px;}
            .nav-link{display:flex;align-items:center;gap:12px;padding:10px 14px;text-decoration:none;color:var(--text-mid);border-radius:var(--radius-sm);font-size:0.8rem;font-weight:600;transition:var(--tr);}
            .nav-icon{width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:0.85rem;transition:var(--tr);flex-shrink:0;}
            .nav-link:hover{color:var(--text-dark);background:var(--bg);}
            .nav-link.active{color:var(--red);background:var(--red-glow);}
            .nav-link.active .nav-icon{background:var(--red);color:#fff;box-shadow:var(--shadow-red);}
            .nav-link.active .nav-icon i{color:#fff;}
            .sidebar-footer{padding:14px;border-top:1px solid var(--border);}
            .user-pill{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:var(--radius-sm);background:var(--bg);}
            .user-avatar{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#ffcc00,#ff9900);display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;color:#fff;}
            .user-info .uname{font-size:0.78rem;font-weight:600;color:var(--text-dark);}
            .user-info .urole{font-size:0.63rem;color:var(--text-light);}

            /* ── Top Bar ── */
            .main-content{flex:1;display:flex;flex-direction:column;overflow:hidden;}
            .top-bar{background:#fff;padding:0 28px;height:60px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--border);flex-shrink:0;}
            .breadcrumb{font-size:0.72rem;color:var(--text-light);font-weight:500;}
            .breadcrumb span{color:var(--red);}
            .add-btn{display:flex;align-items:center;gap:7px;padding:9px 16px;background:var(--red);color:#fff;border:none;border-radius:var(--radius-sm);font-family:var(--font);font-size:0.78rem;font-weight:600;cursor:pointer;box-shadow:var(--shadow-red);transition:var(--tr);}
            .add-btn:hover{background:var(--red-dark);transform:translateY(-1px);}

            /* ── Page area ── */
            .page-area{flex:1;overflow-y:auto;padding:22px 28px;flex-basis:65%;}

            /* ── KPI Cards ── */
            .kpi-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:22px;}
            .kpi-card{background:#fff;border-radius:var(--radius-md);padding:20px 22px;display:flex;align-items:center;justify-content:space-between;box-shadow:var(--shadow-sm);border:1px solid var(--border);transition:var(--tr);position:relative;overflow:hidden;}
            .kpi-card::after{content:'';position:absolute;bottom:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--red),var(--red-dark));opacity:0;transition:var(--tr);}
            .kpi-card:hover{box-shadow:var(--shadow-md);transform:translateY(-2px);}
            .kpi-card:hover::after{opacity:1;}
            .kpi-label{font-size:0.63rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:var(--text-light);margin-bottom:6px;}
            .kpi-value{font-family:var(--font-d);font-size:2.6rem;color:var(--text-dark);line-height:1;}
            .kpi-sub{font-size:0.68rem;color:var(--text-light);margin-top:4px;}
            .kpi-icon-wrap{width:48px;height:48px;border-radius:13px;background:var(--bg);display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;}

            /* ── Dashboard two-col layout ── */
            .dash-row{display:grid;grid-template-columns:1fr 340px;gap:16px;}
            .section-title{font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:var(--text-light);margin-bottom:12px;}
            .activity-card{background:#fff;border-radius:var(--radius-md);padding:20px 22px;box-shadow:var(--shadow-sm);border:1px solid var(--border);}
            .activity-title{font-size:0.88rem;font-weight:700;color:var(--text-dark);margin-bottom:16px;}
            .occ-bar-wrap{margin-bottom:14px;}
            .occ-label{display:flex;justify-content:space-between;margin-bottom:5px;}
            .occ-label span{font-size:0.75rem;color:var(--text-mid);font-weight:500;}
            .occ-label .pct{font-weight:700;color:var(--text-dark);}
            .occ-bar{height:8px;background:var(--bg);border-radius:100px;overflow:hidden;}
            .occ-fill{height:100%;border-radius:100px;}
            .fill-red{background:linear-gradient(90deg,var(--red),var(--red-dark));}
            .fill-green{background:linear-gradient(90deg,#34D399,#059669);}
            .fill-amber{background:linear-gradient(90deg,#FCD34D,#D97706);}

            /* ── Notifications ── */
            .notif-card{background:#fff;border-radius:var(--radius-md);box-shadow:var(--shadow-sm);border:1px solid var(--border);overflow:hidden;}
            .notif-header{padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
            .notif-header-title{font-size:0.85rem;font-weight:700;color:var(--text-dark);}
            .notif-count{background:var(--red);color:#fff;font-size:0.6rem;font-weight:700;padding:2px 8px;border-radius:100px;transition:var(--tr);}
            .notif-list{max-height:270px;overflow-y:auto;}
            .notif-item{padding:12px 18px;display:flex;gap:11px;align-items:flex-start;border-bottom:1px solid var(--border);cursor:pointer;transition:background var(--tr);}
            .notif-item:last-child{border-bottom:none;}
            .notif-item:hover{background:#fafafa;}
            .notif-item.unread{background:#fff6f6;}
            .ndot{width:8px;height:8px;border-radius:50%;background:var(--red);margin-top:5px;flex-shrink:0;transition:background var(--tr);}
            .ndot.read{background:var(--border);}
            .notif-msg{font-size:0.77rem;color:var(--text-dark);font-weight:500;line-height:1.4;}
            .notif-time{font-size:0.64rem;color:var(--text-light);margin-top:2px;}

            /* ── Accordion ── */
            .list-stack{display:flex;flex-direction:column;gap:8px;}
            .acc-item{background:#fff;border-radius:var(--radius-md);box-shadow:var(--shadow-sm);border:1px solid var(--border);overflow:hidden;transition:box-shadow var(--tr);}
            .acc-item.open{box-shadow:var(--shadow-md);}
            .acc-header{padding:15px 20px;display:flex;justify-content:space-between;align-items:center;cursor:pointer;transition:background var(--tr);}
            .acc-header:hover{background:#fafafa;}
            .acc-left{display:flex;align-items:center;gap:14px;}
            .list-avatar{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;color:#fff;flex-shrink:0;}
            .av-red{background:linear-gradient(135deg,var(--red),var(--red-dark));}
            .av-slate{background:linear-gradient(135deg,#4A5568,#2D3748);}
            .av-teal{background:linear-gradient(135deg,#0694A2,#047481);}
            .av-amber{background:linear-gradient(135deg,#D97706,#B45309);}
            .list-name{font-size:0.85rem;font-weight:600;color:var(--text-dark);}
            .list-meta{font-size:0.7rem;color:var(--text-light);margin-top:2px;}
            .acc-right{display:flex;align-items:center;gap:10px;}
            .list-badge{font-size:0.62rem;font-weight:700;padding:3px 9px;border-radius:100px;text-transform:uppercase;letter-spacing:0.7px;}
            .badge-available{background:#ECFDF5;color:#059669;}
            .badge-occupied{background:#FEF2F2;color:#DC2626;}
            .badge-maintenance{background:#FFFBEB;color:#D97706;}
            .badge-pending{background:#FFF7ED;color:#C2410C;}
            .badge-approve{background:#ECFDF5;color:#059669;}
            .badge-canceled{background:#FEF2F2;color:#DC2626;}
            .badge-history{background:#EFF6FF;color:#2563EB;}
            .acc-chevron{color:var(--text-light);font-size:0.75rem;transition:transform var(--tr);}
            .acc-item.open .acc-chevron{transform:rotate(180deg);color:var(--red);}
            .acc-body{max-height:0;overflow:hidden;transition:max-height 0.38s cubic-bezier(.4,0,.2,1);}
            .acc-item.open .acc-body{max-height:600px;}
            .acc-inner{padding:4px 20px 18px;border-top:1px solid var(--border);}

            /* Detail grids */
            .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px 18px;margin-top:14px;}
            .detail-field label{display:block;font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--text-light);margin-bottom:3px;}
            .detail-field p{font-size:0.82rem;font-weight:500;color:var(--text-dark);}
            .col-full{grid-column:1/-1;}
            .detail-field.col-full p{color:var(--text-mid);line-height:1.6;font-weight:400;}
            .acc-actions{display:flex;gap:8px;margin-top:16px;padding-top:14px;border-top:1px solid var(--border);}
            .btn-edit{display:flex;align-items:center;gap:6px;padding:8px 16px;background:var(--red);color:#fff;border:none;border-radius:var(--radius-sm);font-family:var(--font);font-size:0.78rem;font-weight:600;cursor:pointer;box-shadow:var(--shadow-red);transition:var(--tr);}
            .btn-edit:hover{background:var(--red-dark);}
            .btn-ghost{display:flex;align-items:center;gap:6px;padding:8px 16px;background:var(--bg);color:var(--text-mid);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:var(--font);font-size:0.78rem;font-weight:600;cursor:pointer;transition:var(--tr);}
            .btn-ghost:hover{background:var(--border);}

            /* ── Booking Tabs ── */
            .booking-tabs-row{display:flex;gap:4px;margin-bottom:16px;background:#fff;padding:5px;border-radius:var(--radius-sm);border:1px solid var(--border);width:fit-content;}
            .b-tab{padding:7px 16px;font-size:0.73rem;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-light);text-decoration:none;border-radius:7px;transition:var(--tr);}
            .b-tab:hover{color:var(--text-dark);background:var(--bg);}
            .b-tab.active{background:var(--red);color:#fff;box-shadow:var(--shadow-red);}

            /* ── Modal ── */
            .modal-overlay{position:fixed;inset:0;background:rgba(26,26,46,0.45);backdrop-filter:blur(3px);z-index:100;display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity 0.25s;}
            .modal-overlay.show{opacity:1;pointer-events:all;}
            .modal{display:flex;flex-direction:column;justify-content:space-evenly;gap:20px;background:#fff;border-radius:var(--radius-lg);padding:28px;width:60%;height:50%;box-shadow:0 20px 60px rgba(26,26,46,0.2);transform:translateY(16px) scale(0.97);transition:transform 0.28s cubic-bezier(.4,0,.2,1);}
            .modal-overlay.show .modal{transform:translateY(0) scale(1);}
            .modal-header{display:flex;align-items:center;justify-content:space-between;}
            .modal-title{font-family:var(--font-d);font-size:1.2rem;color:var(--text-dark);}
            .modal-close{width:32px;height:32px;border-radius:8px;background:var(--bg);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-mid);font-size:0.85rem;transition:var(--tr);}
            .modal-close:hover{background:var(--border);color:var(--red);}
            .form-group{margin-bottom:14px;}
            .form-group label{display:block;font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--text-mid);margin-bottom:6px;}
            .form-input{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:var(--font);font-size:0.83rem;color:var(--text-dark);background:#fff;transition:border-color var(--tr),box-shadow var(--tr);outline:none;}
            .form-input:focus{border-color:var(--red);box-shadow:0 0 0 3px var(--red-glow);}
            select.form-input{cursor:pointer;}
            textarea.form-input{resize:vertical;min-height:80px;line-height:1.5;}
            .form-row{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;}
            .modal-footer{display:flex;gap:8px;justify-content:flex-end;margin-top:20px;padding-top:16px;border-top:1px solid var(--border);}

            /* Animations */
            @keyframes fadeUp{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}
            .kpi-card{animation:fadeUp .35s ease both;}
            .kpi-card:nth-child(1){animation-delay:.05s;}.kpi-card:nth-child(2){animation-delay:.1s;}.kpi-card:nth-child(3){animation-delay:.15s;}
            .acc-item{animation:fadeUp .3s ease both;}
            .acc-item:nth-child(1){animation-delay:.06s;}.acc-item:nth-child(2){animation-delay:.12s;}.acc-item:nth-child(3){animation-delay:.18s;}

            ::-webkit-scrollbar{width:4px;} ::-webkit-scrollbar-track{background:transparent;} ::-webkit-scrollbar-thumb{background:var(--border);border-radius:10px;}
        </style>
    </head>
    <body>
        <!-- ══ SIDEBAR ══ -->
        <aside class="sidebar">
            <div class="logo-area">
                <a href="<?php echo URLROOT; ?>" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 12px;">
                    <div class="logo-badge"><img style="width: 40px; height: 40px;" src="<?php echo URLROOT; ?>/assets/img/sogo_logo.jpg" alt="Sogo Hotel Logo"></div>
                    <div class="logo-text">
                        <span class="brand">Sogo Hotel</span>
                        <span class="sub">Admin Panel</span>
                    </div>
                </a>
            </div>
            <nav class="nav-section">
                <div class="nav-label">Main</div>
                <a href="<?php echo URLROOT; ?>/admin/index?page=dashboard" class="nav-link <?php echo $data['page']=='dashboard'?'active':'' ?>">
                    <div class="nav-icon"><i class="fa-solid fa-table-cells-large"></i></div> Dashboard
                </a>
                <a href="<?php echo URLROOT; ?>/admin/index?page=room" class="nav-link <?php echo $data['page']=='room'?'active':'' ?>">
                    <div class="nav-icon"><i class="fa-solid fa-key"></i></div> Rooms
                </a>
                <a href="<?php echo URLROOT; ?>/admin/index?page=booking" class="nav-link <?php echo $data['page']=='booking'?'active':'' ?>">
                    <div class="nav-icon"><i class="fa-solid fa-calendar-days"></i></div> Bookings
                </a>
            </nav>
        </aside>

        <!-- ══ MAIN ══ -->
        <main class="main-content">

            <header class="top-bar">
                <div class="breadcrumb">Admin / <span><?php echo ucfirst($data['page']) ?></span></div>
                <div>
                    <?php if($data['page']=='booking'): ?>
                        <button class="add-btn" onclick="openModal('modal-add-booking')"><i class="fa-solid fa-plus"></i> New Booking</button>
                    <?php endif; ?>
                </div>
            </header>

            <?php if (isset($_GET['status']) && $_GET['status'] == 'success' && isset($_GET['ref'])): ?>
                <div id="successBanner" class="page-area" style="padding: 20px; background: #ECFDF5; border: 1px solid #059669; border-radius: 8px; margin: 20px; color: #059669; flex-basis: 0%; position: relative;">
                    <span onclick="document.getElementById('successBanner').style.display='none'" style="position: absolute; top: 10px; right: 15px; cursor: pointer; font-size: 1.2rem; font-weight: bold; color: #059669;">&times;</span>
                    <h3 style="margin: 0 0 10px 0;"><i class="fa-solid fa-check-circle"></i> Booking Created Successfully!</h3>
                    <p style="margin: 0;">Reference Number: <strong><?php echo htmlspecialchars($_GET['ref']); ?></strong></p>
                </div>
            <?php endif; ?>

            <!-- ══════════ DASHBOARD ══════════ -->
            <?php if($data['page']=='dashboard'): ?>
            <div class="page-area">
                <div class="kpi-grid">
                    <div class="kpi-card">
                        <div>
                            <div class="kpi-label">Pending Reservations</div>
                            <div class="kpi-value"><?php echo count($data['reservations']); ?></div>
                            <div class="kpi-sub">Total bookings</div>
                        </div>
                        <div class="kpi-icon-wrap"><i class="fa-regular fa-calendar-check" style="color:var(--red)"></i></div>
                    </div>
                    <!-- Other KPI cards ... -->
                </div>
                <!-- Occupancy Overview ... -->
            </div>

            <!-- ══════════ ROOMS ══════════ -->
            <?php elseif($data['page']=='room'): ?>
            <div class="page-area">
                <div class="section-title">Room Categories</div>
                <div class="list-stack">

                    <div class="acc-item" id="acc-regency">
                        <div class="acc-header" onclick="toggleAcc('acc-regency')">
                            <div class="acc-left">
                                <div class="list-avatar av-red">RG</div>
                                <div><div class="list-name">Regency</div><div class="list-meta">8 rooms · ₱2,500/night</div></div>
                            </div>
                            <div class="acc-right">
                                <i class="fa-solid fa-chevron-down acc-chevron"></i>
                            </div>
                        </div>
                        <div class="acc-body"><div class="acc-inner">
                            <div class="detail-grid">
                                <div class="detail-field"><label>Room Type</label><p>Standard Double</p></div>
                                <div class="detail-field"><label>Floor</label><p>2nd – 3rd Floor</p></div>
                                <div class="detail-field"><label>Rate per night</label><p>₱2,500</p></div>
                                <div class="detail-field"><label>Max Guests</label><p>2 persons</p></div>
                                <div class="detail-field"><label>Bed Type</label><p>Queen Bed</p></div>
                                <div class="detail-field col-full"><label>Description</label><p>A cozy standard room with modern amenities, complimentary toiletries, air conditioning, flat-screen TV, and free Wi-Fi. Ideal for solo travelers or couples looking for a comfortable short stay.</p></div>
                            </div>
                        </div></div>
                    </div>

                    <div class="acc-item" id="acc-deluxe">
                        <div class="acc-header" onclick="toggleAcc('acc-deluxe')">
                            <div class="acc-left">
                                <div class="list-avatar av-slate">DX</div>
                                <div><div class="list-name">Deluxe</div><div class="list-meta">12 rooms · ₱3,500/night</div></div>
                            </div>
                            <div class="acc-right">
                                <i class="fa-solid fa-chevron-down acc-chevron"></i>
                            </div>
                        </div>
                        <div class="acc-body"><div class="acc-inner">
                            <div class="detail-grid">
                                <div class="detail-field"><label>Room Type</label><p>Superior Room</p></div>
                                <div class="detail-field"><label>Floor</label><p>4th – 6th Floor</p></div>
                                <div class="detail-field"><label>Rate per night</label><p>₱3,500</p></div>
                                <div class="detail-field"><label>Max Guests</label><p>3 persons</p></div>
                                <div class="detail-field"><label>Bed Type</label><p>King Bed</p></div>
                                <div class="detail-field col-full"><label>Description</label><p>A spacious superior room featuring a king-size bed, mini-bar, soaking tub, and panoramic city views. Perfect for guests seeking extra comfort and privacy during their stay.</p></div>
                            </div>
                        </div></div>
                    </div>

                    <div class="acc-item" id="acc-premium">
                        <div class="acc-header" onclick="toggleAcc('acc-premium')">
                            <div class="acc-left">
                                <div class="list-avatar av-teal">PM</div>
                                <div><div class="list-name">Premium</div><div class="list-meta">6 rooms · ₱5,000/night</div></div>
                            </div>
                            <div class="acc-right">
                                <i class="fa-solid fa-chevron-down acc-chevron"></i>
                            </div>
                        </div>
                        <div class="acc-body"><div class="acc-inner">
                            <div class="detail-grid">
                                <div class="detail-field"><label>Room Type</label><p>Executive Suite</p></div>
                                <div class="detail-field"><label>Floor</label><p>7th – 8th Floor</p></div>
                                <div class="detail-field"><label>Rate per night</label><p>₱5,000</p></div>
                                <div class="detail-field"><label>Max Guests</label><p>4 persons</p></div>
                                <div class="detail-field"><label>Bed Type</label><p>Twin King Beds</p></div>
                                <div class="detail-field col-full"><label>Description</label><p>Our top-tier executive suite with a private living area, jacuzzi, premium bath amenities, and a dedicated concierge. The ultimate luxury experience for distinguished guests.</p></div>
                            </div>
                        </div></div>
                    </div>

                </div>
            </div>

            <!-- ══════════ BOOKINGS ══════════ -->
            <?php elseif($data['page']=='booking'): ?>
            <div class="page-area">
                <div class="section-title"> Bookings</div>
                <div class="list-stack">

                    <?php foreach ($data['reservations'] as $item): ?>
                        <div class="acc-item" id="acc-<?php echo $item->id; ?>">
                            <div class="acc-header" onclick="toggleAcc('acc-<?php echo $item->id; ?>')">
                                <div class="acc-left">
                                    <div class="list-avatar av-amber">
                                        <?php
                                            $name = $item->name;
                                            $words = explode(' ', trim($name));
                                            $firstInitial = substr($words[0], 0, 1);
                                            $lastInitial = isset($words[1]) ? substr(end($words), 0, 1) : '';
                                            echo strtoupper($firstInitial . $lastInitial);
                                        ?>
                                    </div>
                                    <div>
                                        <div class="list-name"><?php echo $item->name; ?></div>
                                        <div class="list-meta"><?php echo $item->ref_no; ?></div>
                                    </div>
                                </div>
                                
                                <div class="acc-right">
                                    <span class="list-badge badge-<?php echo $item->status ?? 'pending' ?>"><?php echo ucfirst($item->status ?? 'pending') ?></span>
                                    <i class="fa-solid fa-chevron-down acc-chevron"></i>
                                </div>
                            </div>
                            <div class="acc-body"><div class="acc-inner">
                                <div class="detail-grid">
                                    <div class="detail-field"><label>Guest Name</label><p><?php echo $item->name; ?></p></div>
                                    <div class="detail-field"><label>Room Type</label><p><?php echo $item->room_type; ?></p></div>
                                    <div class="detail-field"><label>Check-in</label><p><?php echo date("F j, Y", strtotime($item->checkin_date)); ?></p></div>
                                    <div class="detail-field"><label>Check-out</label><p><?php echo date("F j, Y", strtotime($item->checkout_date)); ?></p></div>
                                    <div class="detail-field"><label>Total Amount</label><p style="color:var(--red);font-weight:700;">₱<?php echo number_format($item->total_bill, 2); ?></p></div>
                                    <div class="detail-field"><label>Payment</label><p><?php echo $item->mop; ?></p></div>
                                    <div class="detail-field"><label>Status</label>
                                        <div style="display: flex;gap: 10px;">
                                            <button class="btn-edit" style="background: #FFF7ED; color: #C2410C; box-shadow: none;" 
                                                    onclick="updateStatus(<?php echo $item->id; ?>, 'pending')">Pending</button>
                                            <button class="btn-edit" style="background: #FEF2F2; color: #DC2626; box-shadow: none;" 
                                                    onclick="updateStatus(<?php echo $item->id; ?>, 'canceled')">Cancelled</button>
                                            <button class="btn-edit" style="background: #ECFDF5; color: #059669; box-shadow: none;" 
                                                    onclick="updateStatus(<?php echo $item->id; ?>, 'approve')">Approved</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="acc-actions">
                                    <button class="btn-ghost" onclick="toggleAcc('acc-<?php echo $item->id; ?>')">Close</button>
                                    <button class="btn-edit" onclick="confirmDelete(<?php echo $item->id; ?>)">Delete Booking</button>
                                </div>
                            </div></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

        </main>

        <!-- ══ MODAL: New Booking ══ -->
        <div class="modal-overlay" id="modal-add-booking" onclick="closeOnOverlay(event,'modal-add-booking')">
            <div class="modal">
                <div class="modal-header">
                    <div class="modal-title">New Booking</div>
                    <button class="modal-close" onclick="closeModal('modal-add-booking')"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <form id="bookingForm" action="<?php echo URLROOT; ?>/pages/reserve" method="POST">
                    <input type="hidden" name="from_admin" value="1">
                    <!-- Admin booking can use the same reserve method for now -->
                    <div class="form-row">
                        <div class="form-group"><label>First Name</label><input class="form-input" type="text" name="first_name" required></div>
                        <div class="form-group"><label>Last Name</label><input class="form-input" type="text" name="last_name" required></div>
                        <div class="form-group"><label>Contact Number</label><input class="form-input" type="tel" name="contact" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>Email</label><input class="form-input" type="email" name="email"></div>
                        <div class="form-group"><label>Check-in Date</label><input class="form-input" type="date" id="checkinDate" name="checkin_date" required></div>
                        <div class="form-group"><label>Check-out Date</label><input class="form-input" type="date" id="checkoutDate" name="checkout_date" required></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>Room Type</label>
                            <select class="form-input" name="room_type" required>
                                <option value="" disabled selected>-- Select Room Type --</option>
                                <option value="Regency">Regency</option>
                                <option value="Deluxe">Deluxe</option>
                                <option value="Premium">Premium</option>
                            </select>
                        </div>
                        <div class="form-group"><label>Room Capacity</label>
                            <select class="form-input" name="room_capacity" required>
                                <option value="" disabled selected>-- Select Capacity --</option>
                                <option value="Single">Single</option>
                                <option value="Double">Double</option>
                                <option value="Family">Family</option>
                            </select>
                        </div>
                        <div class="form-group"><label>Payment Method</label>
                            <select class="form-input" name="payment_method" required>
                                <option value="" disabled selected>-- Select Payment --</option>
                                <option value="Cash">Cash</option>
                                <option value="Check">Check</option>
                                <option value="Credit Card">Credit Card</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn-ghost" onclick="closeModal('modal-add-booking')">Cancel</button>
                        <button class="btn-edit" type="submit"><i class="fa-solid fa-calendar-plus"></i> Create Booking</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            // Date validation for admin booking modal
            document.addEventListener("DOMContentLoaded", () => {
                const checkinInput = document.getElementById('checkinDate');
                const checkoutInput = document.getElementById('checkoutDate');

                if (checkinInput && checkoutInput) {
                    // Set Check-in Minimum to TODAY (Prevents past dates)
                    const today = new Date().toISOString().split('T')[0];
                    checkinInput.setAttribute('min', today);
                    
                    // Disable checkout initially until user picks a check-in date
                    checkoutInput.disabled = true;

                    // Watch for changes on the Check-in field
                    checkinInput.addEventListener('change', function() {
                        if (this.value) {
                            // Enable the checkout input
                            checkoutInput.disabled = false;

                            // Create a Date object from the selected check-in date
                            const selectedDate = new Date(this.value);
                            
                            // Add 1 Day to the selected date
                            selectedDate.setDate(selectedDate.getDate() + 1);
                            
                            // Format it back to YYYY-MM-DD for the HTML input
                            const nextDay = selectedDate.toISOString().split('T')[0];

                            // Set the Minimum Check-out date to be the Next Day
                            checkoutInput.setAttribute('min', nextDay);

                            // If the user previously picked a date that is now invalid, clear it
                            if (checkoutInput.value && checkoutInput.value < nextDay) {
                                checkoutInput.value = "";
                            }
                        } else {
                            // If they clear the check-in, disable check-out again
                            checkoutInput.disabled = true;
                            checkoutInput.value = "";
                        }
                    });
                }
            });

            function toggleAcc(id) {
                const el = document.getElementById(id);
                if(!el) return;
                const isOpen = el.classList.contains('open');
                el.closest('.list-stack').querySelectorAll('.acc-item').forEach(i => i.classList.remove('open'));
                if (!isOpen) el.classList.add('open');
            }

            function openModal(id) { document.getElementById(id).classList.add('show'); }
            function closeModal(id) { document.getElementById(id).classList.remove('show'); }
            function closeOnOverlay(e, id) { if (e.target === e.currentTarget) closeModal(id); }

            function openEditRoom(roomType, roomTypeDetail, rate, maxGuests, bedType, status, description) {
                alert('Edit Room feature coming soon!\n\nRoom: ' + roomType + '\nRate: ₱' + rate);
                // You can expand this to open a modal with form to update room details
            }

            function confirmDelete(id) {
                if (confirm("Are you sure you want to delete this booking?")) {
                    window.location.href = '<?php echo URLROOT; ?>/admin/delete/' + id;
                }
            }

            function updateStatus(id, newStatus) {
                fetch('<?php echo URLROOT; ?>/admin/update_status', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + id + '&status=' + encodeURIComponent(newStatus)
                })
                .then(() => window.location.reload())
                .catch(error => { console.error('Error:', error); alert("Failed to update status."); });
            }
        </script>
    </body>
</html>
