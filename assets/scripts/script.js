// TravelCircle JavaScript functionality

document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for navigation links
    const navLinks = document.querySelectorAll('.nav a[href^="#"]');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                targetSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Hero section parallax effect
    const hero = document.querySelector('.hero');
    const heroImages = document.querySelectorAll('.hero-image img');
    
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;
        
        heroImages.forEach((img, index) => {
            const speed = 0.3 + (index * 0.1);
            img.style.transform = `translateY(${rate * speed}px)`;
        });
    });

    // Trip card animations
    const tripCards = document.querySelectorAll('.trip-card');
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    tripCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });

    // Destination card hover effects
    const destinationCards = document.querySelectorAll('.destination-card');
    
    destinationCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05) rotate(1deg)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) rotate(0deg)';
        });
    });

    // Story card interactions
    const storyCards = document.querySelectorAll('.story-card');
    
    storyCards.forEach(card => {
        card.addEventListener('click', function() {
            // Add a subtle animation when clicked
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });

    // Search functionality (if search bar is added later)
    function searchTrips(query) {
        const trips = document.querySelectorAll('.trip-card');
        const queryLower = query.toLowerCase();
        
        trips.forEach(trip => {
            const title = trip.querySelector('h3').textContent.toLowerCase();
            const description = trip.querySelector('p').textContent.toLowerCase();
            
            if (title.includes(queryLower) || description.includes(queryLower)) {
                trip.style.display = 'block';
                trip.style.animation = 'fadeIn 0.5s ease';
            } else {
                trip.style.display = 'none';
            }
        });
    }

    // Add CSS animation for fadeIn
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(style);

    // Mobile menu toggle (for future mobile navigation)
    function createMobileMenu() {
        const header = document.querySelector('.header');
        const nav = document.querySelector('.nav');
        
        if (window.innerWidth <= 768) {
            if (!document.querySelector('.mobile-menu-toggle')) {
                const toggle = document.createElement('button');
                toggle.className = 'mobile-menu-toggle';
                toggle.innerHTML = '<i class="fas fa-bars"></i>';
                toggle.style.cssText = `
                    display: block;
                    background: none;
                    border: none;
                    font-size: 24px;
                    color: #15AEAE;
                    cursor: pointer;
                `;
                
                header.appendChild(toggle);
                
                toggle.addEventListener('click', function() {
                    nav.classList.toggle('mobile-open');
                });
            }
        } else {
            const toggle = document.querySelector('.mobile-menu-toggle');
            if (toggle) {
                toggle.remove();
            }
            nav.classList.remove('mobile-open');
        }
    }

    // Initialize mobile menu
    createMobileMenu();
    window.addEventListener('resize', createMobileMenu);

    // Add mobile navigation styles
    const mobileStyles = document.createElement('style');
    mobileStyles.textContent = `
        @media (max-width: 768px) {
            .nav {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                transform: translateY(-100%);
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }
            
            .nav.mobile-open {
                transform: translateY(0);
                opacity: 1;
                visibility: visible;
            }
            
            .nav a {
                padding: 10px 0;
                border-bottom: 1px solid #f0f0f0;
            }
        }
    `;
    document.head.appendChild(mobileStyles);

    // Loading animation for images (avoid flash for cached images)
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        const reveal = () => { img.style.opacity = '1'; };

        img.style.transition = 'opacity 0.3s ease';

        if (img.complete && img.naturalWidth > 0) {
            reveal();
        } else {
            // Do not hide hero images underneath separators; start visible
            if (!img.closest('.hero')) {
                img.style.opacity = '0';
            }
            img.addEventListener('load', reveal, { once: true });
            img.addEventListener('error', reveal, { once: true });
            setTimeout(reveal, 2000);
        }
    });

    // Add scroll-to-top button
    const scrollToTopBtn = document.createElement('button');
    scrollToTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    scrollToTopBtn.className = 'scroll-to-top';
    scrollToTopBtn.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: #15AEAE;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        font-size: 18px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1000;
        box-shadow: 0 5px 15px rgba(21, 174, 174, 0.3);
    `;
    
    document.body.appendChild(scrollToTopBtn);
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.style.opacity = '1';
            scrollToTopBtn.style.visibility = 'visible';
        } else {
            scrollToTopBtn.style.opacity = '0';
            scrollToTopBtn.style.visibility = 'hidden';
        }
    });
    
    scrollToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Add hover effect for scroll-to-top button
    scrollToTopBtn.addEventListener('mouseenter', function() {
        this.style.background = '#0D8589';
        this.style.transform = 'scale(1.1)';
    });
    
    scrollToTopBtn.addEventListener('mouseleave', function() {
        this.style.background = '#15AEAE';
        this.style.transform = 'scale(1)';
    });

    // Notifications dropdown 
    const notifButton = document.getElementById('notifButton');
    const notifDropdown = document.getElementById('notifDropdown');
    const notifBadge = document.getElementById('notifBadge');

    function hideDropdown() {
        if (notifDropdown) notifDropdown.style.display = 'none';
        if (notifButton) notifButton.setAttribute('aria-expanded', 'false');
    }

    if (notifButton && notifDropdown) {
        notifButton.addEventListener('click', function(e) {
            e.stopPropagation();
            const isOpen = notifDropdown.style.display === 'block';
            notifDropdown.style.display = isOpen ? 'none' : 'block';
            notifButton.setAttribute('aria-expanded', String(!isOpen));
        });

        document.addEventListener('click', function(e) {
            if (!notifDropdown.contains(e.target) && e.target !== notifButton) {
                hideDropdown();
            }
        });
    }

    

    // Show login success toast if present
    const loginToast = document.getElementById('login-toast');
    if (loginToast) {
        // Defer to next frame so CSS transitions apply
        requestAnimationFrame(() => loginToast.classList.add('toast-show'));
        setTimeout(() => {
            loginToast.classList.remove('toast-show');
            setTimeout(() => loginToast.remove(), 300);
        }, 2500);
    }
});

// Function to handle trip exploration (called from PHP)
function exploreTrip(tripId) {
    // Add a loading animation
    const button = event.target;
    const originalText = button.textContent;
    button.textContent = 'Loading...';
    button.disabled = true;
    
    // Simulate API call or redirect
    setTimeout(() => {
        // In a real application, this would redirect to a trip details page
        alert(`Exploring trip ${tripId}! This would normally redirect to the trip details page.`);
        button.textContent = originalText;
        button.disabled = false;
    }, 1000);
}

// Function to filter trips by category
function filterTrips(category) {
    const tripCards = document.querySelectorAll('.trip-card');
    
    tripCards.forEach(card => {
        if (category === 'all' || card.dataset.category === category) {
            card.style.display = 'block';
            card.style.animation = 'fadeIn 0.5s ease';
        } else {
            card.style.display = 'none';
        }
    });
}

// Function to sort trips by price
function sortTrips(sortBy) {
    const tripsGrid = document.querySelector('.trips-grid');
    const tripCards = Array.from(document.querySelectorAll('.trip-card'));
    
    tripCards.sort((a, b) => {
        const priceA = parseInt(a.querySelector('.price').textContent.replace('$', ''));
        const priceB = parseInt(b.querySelector('.price').textContent.replace('$', ''));
        
        if (sortBy === 'price-low') {
            return priceA - priceB;
        } else if (sortBy === 'price-high') {
            return priceB - priceA;
        }
        return 0;
    });
    
    // Clear and re-append sorted cards
    tripsGrid.innerHTML = '';
    tripCards.forEach(card => {
        tripsGrid.appendChild(card);
    });
}

// Add keyboard navigation support
document.addEventListener('keydown', function(e) {
    // ESC key to close mobile menu
    if (e.key === 'Escape') {
        const nav = document.querySelector('.nav');
        nav.classList.remove('mobile-open');
    }
    
    // Arrow keys for navigation (if needed)
    if (e.key === 'ArrowDown' && e.ctrlKey) {
        e.preventDefault();
        window.scrollBy(0, 100);
    } else if (e.key === 'ArrowUp' && e.ctrlKey) {
        e.preventDefault();
        window.scrollBy(0, -100);
    }
});

// Performance optimization: Lazy loading for images
function lazyLoadImages() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Initialize lazy loading when DOM is ready
document.addEventListener('DOMContentLoaded', lazyLoadImages);
