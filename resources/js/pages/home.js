document.addEventListener('DOMContentLoaded', () => {
    const siteHeader = document.getElementById('siteHeader');
    const brandTitle = document.getElementById('brandTitle');
    const brandSubtitle = document.getElementById('brandSubtitle');
    const desktopNav = document.getElementById('desktopNav');
    const navLinks = document.querySelectorAll('.nav-link');
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
    const themedSections = document.querySelectorAll('[data-nav-theme]');
    const productDetailButtons = document.querySelectorAll('.product-detail-btn');
    const productModal = document.getElementById('productModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const modalBackdrop = document.getElementById('modalBackdrop');
    
    function applyNavbarTheme(theme) {
        const isDarkTheme = theme === 'dark';
    
        if (isDarkTheme) {
            brandTitle.classList.add('text-gold-100');
            brandTitle.classList.remove('text-ink-900');
            brandSubtitle.classList.add('text-gold-100/80');
            brandSubtitle.classList.remove('text-ink-500');
            desktopNav.classList.add('text-gold-100');
            desktopNav.classList.remove('text-ink-800');
            navLinks.forEach((link) => {
                link.classList.add('hover:text-gold-300');
                link.classList.remove('hover:text-primary-700');
            });
            menuBtn.classList.add('bg-white/90', 'text-primary-700');
            menuBtn.classList.remove('bg-primary-200', 'text-ink-900');
            mobileMenu.classList.add('text-white');
            mobileMenu.classList.remove('text-ink-800', 'bg-white/90');
            mobileNavLinks.forEach((link) => {
                link.classList.add('text-white', 'hover:bg-white/10');
                link.classList.remove('text-ink-800', 'hover:bg-ink-900/5');
            });
        } else {
            brandTitle.classList.add('text-ink-900');
            brandTitle.classList.remove('text-gold-100');
            brandSubtitle.classList.add('text-ink-500');
            brandSubtitle.classList.remove('text-gold-100/80');
            desktopNav.classList.add('text-ink-800');
            desktopNav.classList.remove('text-gold-100');
            navLinks.forEach((link) => {
                link.classList.add('hover:text-primary-700');
                link.classList.remove('hover:text-gold-300');
            });
            menuBtn.classList.add('bg-primary-200', 'text-ink-900');
            menuBtn.classList.remove('bg-white/90', 'text-primary-700');
            mobileMenu.classList.add('text-ink-800', 'bg-white/90');
            mobileMenu.classList.remove('text-white');
            mobileNavLinks.forEach((link) => {
                link.classList.add('text-ink-800', 'hover:bg-ink-900/5');
                link.classList.remove('text-white', 'hover:bg-white/10');
            });
        }
    }
    
    function updateNavbarState() {
        const scrollY = window.scrollY;
        let activeTheme = 'light';
        const probeY = 90;
    
        themedSections.forEach((section) => {
            const rect = section.getBoundingClientRect();
            if (rect.top <= probeY && rect.bottom >= probeY) {
                activeTheme = section.dataset.navTheme || 'light';
            }
        });
    
        applyNavbarTheme(activeTheme);
    
        siteHeader.classList.remove('border-primary-200', 'border-white/20', 'border-transparent');
        if (scrollY <= 0) {
            siteHeader.classList.add('border-transparent');
        } else {
            siteHeader.classList.add(activeTheme === 'dark' ? 'border-white/20' : 'border-primary-200');
        }
    }

	new Swiper('.gallerySwiper', {
        slidesPerView: 1,
		// loop: true,
		spaceBetween: 20,
		pagination: {
			el: '.gallerySwiper .swiper-pagination',
			clickable: true,
		},
        breakpoints: {
            1024: {
                slidesPerView: 4
            }
        }
	});
    
    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
    
    mobileNavLinks.forEach((link) => {
        link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
    });
    
    function openModal() {
        productModal.classList.remove('hidden');
        productModal.classList.add('flex');
        productModal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeModal() {
        productModal.classList.add('hidden');
        productModal.classList.remove('flex');
        productModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
    }
    
    productDetailButtons.forEach((button) => {
        button.addEventListener('click', openModal);
    });
    
    closeModalBtn.addEventListener('click', closeModal);
    modalBackdrop.addEventListener('click', closeModal);
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !productModal.classList.contains('hidden')) {
            closeModal();
        }
    });
    
    window.addEventListener('scroll', updateNavbarState);
    window.addEventListener('resize', updateNavbarState);
    updateNavbarState();
    
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    let current = 0;
    
    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('opacity-100', i === index);
            slide.classList.toggle('opacity-0', i !== index);
    
            dots[i].classList.toggle('w-7', i === index);
            dots[i].classList.toggle('w-2', i !== index);
            dots[i].classList.toggle('bg-gold-300', i === index);
            dots[i].classList.toggle('bg-white/40', i !== index);
        });
        current = index;
    }
    
    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => showSlide(i));
    });
    
    setInterval(() => {
        const next = (current + 1) % slides.length;
        showSlide(next);
    }, 5000);
    
    // Scroll reveal
    const revealEls = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('reveal-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });
        revealEls.forEach((el) => observer.observe(el));
    } else {
        revealEls.forEach((el) => el.classList.add('reveal-visible'));
    }
})
