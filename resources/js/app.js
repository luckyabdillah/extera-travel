import axios from 'axios';
import './bootstrap';

window.axios = axios;

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
}
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';

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
        if (!siteHeader || !brandTitle || !brandSubtitle || !desktopNav) {
            return;
        }

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
            if (menuBtn) {
                menuBtn.classList.add('bg-white/90', 'text-primary-700');
                menuBtn.classList.remove('bg-primary-200', 'text-ink-900');
            }
            if (mobileMenu) {
                mobileMenu.classList.add('text-white');
                mobileMenu.classList.remove('text-ink-800', 'bg-white/90');
            }
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
            if (menuBtn) {
                menuBtn.classList.add('bg-primary-200', 'text-ink-900');
                menuBtn.classList.remove('bg-white/90', 'text-primary-700');
            }
            if (mobileMenu) {
                mobileMenu.classList.add('text-ink-800', 'bg-white/90');
                mobileMenu.classList.remove('text-white');
            }
            mobileNavLinks.forEach((link) => {
                link.classList.add('text-ink-800', 'hover:bg-ink-900/5');
                link.classList.remove('text-white', 'hover:bg-white/10');
            });
        }
    }

    function updateNavbarState() {
        if (!siteHeader) {
            return;
        }

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

    const gallerySwiper = document.querySelector('.gallerySwiper');
    if (gallerySwiper && typeof Swiper !== 'undefined') {
        new Swiper('.gallerySwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
                el: '.gallerySwiper .swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                1024: {
                    slidesPerView: 4,
                },
            },
        });
    }

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    mobileNavLinks.forEach((link) => {
        link.addEventListener('click', () => {
            if (mobileMenu) {
                mobileMenu.classList.add('hidden');
            }
        });
    });

    function openModal() {
        if (!productModal) {
            return;
        }
        productModal.classList.remove('hidden');
        productModal.classList.add('flex');
        productModal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        if (!productModal) {
            return;
        }
        productModal.classList.add('hidden');
        productModal.classList.remove('flex');
        productModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
    }

    productDetailButtons.forEach((button) => {
        button.addEventListener('click', openModal);
    });

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }
    if (modalBackdrop) {
        modalBackdrop.addEventListener('click', closeModal);
    }
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && productModal && !productModal.classList.contains('hidden')) {
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
        if (!slides.length || !dots.length) {
            return;
        }

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

    if (slides.length > 0 && dots.length > 0) {
        setInterval(() => {
            const next = (current + 1) % slides.length;
            showSlide(next);
        }, 5000);
    }

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

    initBlogEditors();
});

function initBlogEditors() {
    const blogForms = document.querySelectorAll('[data-blog-editor]');
    if (!blogForms.length || typeof Quill === 'undefined') {
        return;
    }

    blogForms.forEach((form) => {
        const editorContainer = form.querySelector('[data-blog-editor-container]');
        const hiddenInput = form.querySelector('[data-blog-editor-input]');
        const uploadUrl = form.dataset.uploadUrl;

        if (!editorContainer || !hiddenInput || !uploadUrl) {
            return;
        }

        const quill = new Quill(editorContainer, {
            theme: 'snow',
            modules: {
                toolbar: {
                    container: [
                        [{ header: [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['link', 'image', 'blockquote'],
                        ['clean'],
                    ],
                    handlers: {
                        image: () => {
                            const input = document.createElement('input');
                            input.type = 'file';
                            input.accept = 'image/*';
                            input.click();

                            input.addEventListener('change', async () => {
                                if (!input.files || !input.files[0]) {
                                    return;
                                }

                                await uploadBlogImage(quill, uploadUrl, input.files[0]);
                            }, { once: true });
                        },
                    },
                },
            },
        });

        if (hiddenInput.value) {
            quill.root.innerHTML = hiddenInput.value;
        }

        quill.root.addEventListener('paste', async (event) => {
            const clipboardItems = Array.from(event.clipboardData?.items || []);
            const imageItem = clipboardItems.find((item) => item.type.startsWith('image/'));

            if (!imageItem) {
                return;
            }

            const file = imageItem.getAsFile();
            if (!file) {
                return;
            }

            event.preventDefault();
            await uploadBlogImage(quill, uploadUrl, file);
        });

        form.addEventListener('submit', () => {
            const hasContent = quill.getText().trim().length > 0 || quill.root.querySelector('img');
            hiddenInput.value = hasContent ? quill.root.innerHTML : '';
        });
    });
}

async function uploadBlogImage(quill, uploadUrl, file) {
    const range = quill.getSelection(true) || { index: quill.getLength() };
    const formData = new FormData();
    formData.append('image', file);

    try {
        const response = await window.axios.post(uploadUrl, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        quill.insertEmbed(range.index, 'image', response.data.url);
        quill.setSelection(range.index + 1);
    } catch (error) {
        const message = error.response?.data?.message || error.response?.data?.errors?.image?.[0] || 'Gagal mengunggah gambar.';
        window.alert(message);
    }
}
