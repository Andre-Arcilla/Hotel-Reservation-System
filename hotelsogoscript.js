document.addEventListener("DOMContentLoaded", () => {
    
    // 1. Navigation Highlighting Logic (Keep this)
    const sections = document.querySelectorAll("section");
    const navLinks = document.querySelectorAll(".nav-link");

    const observerOptions = {
        root: null,
        threshold: 0.5, 
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                navLinks.forEach((link) => link.classList.remove("active"));
                const activeLink = document.querySelector(`.nav-link[href="#${entry.target.id}"]`);
                if (activeLink) {
                    activeLink.classList.add("active");
                }
            }
        });
    }, observerOptions);

    sections.forEach((section) => observer.observe(section));


    // 2. --- NEW DATE VALIDATION LOGIC STARTS HERE ---
    // (This replaces your old dateInput code)
    const checkinInput = document.getElementById('checkinDate');
    const checkoutInput = document.getElementById('checkoutDate');

    if (checkinInput && checkoutInput) {
        // A. Set Check-in Minimum to TODAY (Prevents past dates)
        const today = new Date().toISOString().split('T')[0];
        checkinInput.setAttribute('min', today);
        
        // B. Disable checkout initially until user picks a check-in date
        checkoutInput.disabled = true;

        // C. Watch for changes on the Check-in field
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
    // --- DATE VALIDATION ENDS HERE ---


    // 3. Scroll Animation Logic (Keep this)
    const animationObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            }
        });
    });

    const hiddenElements = document.querySelectorAll('.hidden');
    hiddenElements.forEach((el) => animationObserver.observe(el));
}); 


// --- GLOBAL FUNCTIONS (Keep these as they are) ---

function openMappedModal(displayName, mappedType) {
    const modal = document.getElementById('bookingModal');
    
    // Update the visual display in the modal
    document.getElementById('displayRoomName').innerText = displayName;
    document.getElementById('displayMappedType').innerText = mappedType;
    
    // Update the HIDDEN input that PHP reads
    document.getElementById('hiddenRoomType').value = mappedType;
    
    modal.style.display = 'block';
    
    // Trigger CSS Animation
    const content = modal.querySelector('.modal-content');
    content.classList.remove('slide-in');
    void content.offsetWidth; // Reflow
    content.classList.add('slide-in');
}

function closeModal() {
    document.getElementById('bookingModal').style.display = 'none';
}

function clearForm() {
    document.getElementById('bookingForm').reset();
}

window.onclick = function(event) {
    const modal = document.getElementById('bookingModal');
    if (event.target == modal) {
        closeModal();
    }
}