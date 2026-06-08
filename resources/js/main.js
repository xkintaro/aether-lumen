import Swiper from 'swiper/bundle';
import { Fancybox } from '@fancyapps/ui';
import { CountUp } from 'countup.js';
import AetherUI from './aether.js';
import AetherIcons from './aether-icons.js';

AetherUI.Icons = AetherIcons;
window.AetherUI = AetherUI;

document.addEventListener("DOMContentLoaded", () => {
    if (document.body && document.body.hasAttribute(`data-${AetherUI.config.prefix}-auto`)) {
        AetherUI.init();
    }

    const getStoredTheme = () => localStorage.getItem("theme") || "system";

    const checkIsDark = (theme) => {
        if (theme === "system") {
            return window.matchMedia("(prefers-color-scheme: dark)").matches;
        }
        return theme === "dark";
    };

    const initThemeToggle = () => {
        const toggleBtn = document.getElementById("theme-toggle-btn");
        const sunIcon = document.getElementById("icon-sun");
        const moonIcon = document.getElementById("icon-moon");

        if (!toggleBtn || !sunIcon || !moonIcon) return;

        const updateIcons = (isDark) => {
            if (isDark) {
                sunIcon.classList.remove("hidden");
                moonIcon.classList.add("hidden");
            } else {
                sunIcon.classList.add("hidden");
                moonIcon.classList.remove("hidden");
            }
        };

        const initialTheme = getStoredTheme();
        updateIcons(checkIsDark(initialTheme));

        toggleBtn.addEventListener("click", (e) => {
            e.preventDefault();
            const isDarkNow =
                document.documentElement.classList.contains("dark");
            const nextTheme = isDarkNow ? "light" : "dark";

            if (typeof AetherUI !== "undefined") {
                AetherUI.setTheme(nextTheme);
            }
        });

        document.addEventListener("aether:theme-change", (e) => {
            updateIcons(checkIsDark(e.detail.theme));
        });
    };

    const initAdvancedThemeButtons = () => {
        const buttons = document.querySelectorAll(".theme-btn");
        if (buttons.length === 0) return;

        const updateActiveState = (activeTheme) => {
            buttons.forEach((btn) => {
                const btnTheme = btn.getAttribute("data-aether-theme");
                btn.classList.remove("border-red-500");
                btn.classList.add("border-black");

                if (btnTheme === activeTheme) {
                    btn.classList.remove("border-black");
                    btn.classList.add("border-red-500");
                }
            });
        };

        updateActiveState(getStoredTheme());

        document.addEventListener("aether:theme-change", (e) => {
            updateActiveState(e.detail.theme);
        });
    };

    const initBackToTop = () => {
        const btn = document.getElementById("back-to-top");
        if (!btn) return;

        const toggleVisibility = () => {
            if (window.scrollY > 600) {
                btn.classList.remove(
                    "translate-y-20",
                    "opacity-0",
                    "invisible"
                );
            } else {
                btn.classList.add("translate-y-20", "opacity-0", "invisible");
            }
        };

        window.addEventListener("scroll", toggleVisibility, { passive: true });
        btn.addEventListener("click", () => {
            window.scrollTo({ top: 0, behavior: "smooth" });
        });

        toggleVisibility();
    };

    const initSmartBreadcrumbs = () => {
        const bar = document.getElementById("breadcrumbs-bar");
        if (!bar) return;

        const navbarHeight = 100;
        const delta = 20;
        let lastScrollTop = 0;

        window.addEventListener(
            "scroll",
            () => {
                const currentScroll =
                    window.scrollY || document.documentElement.scrollTop;

                if (currentScroll <= 0) {
                    bar.classList.remove("-translate-y-full", "opacity-0");
                    return;
                }

                if (Math.abs(lastScrollTop - currentScroll) <= delta) return;

                if (
                    currentScroll > lastScrollTop &&
                    currentScroll > navbarHeight
                ) {
                    bar.classList.add("-translate-y-full", "opacity-0");
                } else {
                    bar.classList.remove("-translate-y-full", "opacity-0");
                }

                lastScrollTop = currentScroll;
            },
            { passive: true }
        );
    };

    const initMarquee = () => {
        const track = document.getElementById("marquee-track");

        if (track) {
            const items = Array.from(track.children);

            items.forEach((item) => {
                const clone = item.cloneNode(true);
                clone.setAttribute("aria-hidden", "true");
                track.appendChild(clone);
            });
        }
    };

    const initCountUp = () => {
        const selector = '[data-countup]';
        const elements = document.querySelectorAll(selector);

        if (elements.length > 0) {
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const endValue = parseFloat(el.getAttribute('data-countup'));
                        const options = {
                            duration: 2.5,
                            separator: '.',
                            decimal: ',',
                            ...JSON.parse(el.getAttribute('data-countup-options') || '{}')
                        };

                        const countUp = new CountUp(el, endValue, options);

                        if (!countUp.error) {
                            countUp.start();
                        } else {
                            console.error(countUp.error);
                        }

                        observer.unobserve(el);
                    }
                });
            }, { threshold: 0.5 });

            elements.forEach(el => observer.observe(el));
        }
    };

    initThemeToggle();
    initAdvancedThemeButtons();
    initBackToTop();
    initSmartBreadcrumbs();
    initMarquee();
    initCountUp();
});

const swiper = new Swiper(".swiperMain", {
    loop: true,
    effect: "fade",
    speed: 500,
    fadeEffect: { crossFade: true },
    parallax: true,
    navigation: { nextEl: ".main-next", prevEl: ".main-prev" },
    keyboard: { enabled: true },
    pagination: { el: ".swiper-pagination", clickable: true },
    autoplay: { delay: 5000, disableOnInteraction: true },
});

const productSwiper = new Swiper(".swiperProducts", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    navigation: { nextEl: ".product-next", prevEl: ".product-prev" },
    breakpoints: {
        640: { slidesPerView: 2, spaceBetween: 30 },
        1024: { slidesPerView: 3, spaceBetween: 40 },
        1536: { slidesPerView: 4, spaceBetween: 60 },
    },
});

const certificateSwiper = new Swiper(".swiperCertificates", {
    slidesPerView: 2,
    spaceBetween: 20,
    loop: true,
    navigation: { nextEl: ".certificate-next", prevEl: ".certificate-prev" },
    breakpoints: {
        640: { slidesPerView: 3, spaceBetween: 30 },
        1536: { slidesPerView: 4, spaceBetween: 60 },
    },
});

Fancybox.bind("[data-fancybox]", {
    Carousel: { infinite: true, transition: "classic" },
    Thumbs: { autoStart: true, type: "classic" },
    Toolbar: {
        display: {
            left: ["infobar"],
            middle: [
                "zoomIn",
                "zoomOut",
                "rotateCCW",
                "rotateCW",
                "flipX",
                "flipY",
            ],
            right: ["slideshow", "thumbs", "fullscreen", "download", "close"],
        },
    },
    Images: { zoom: true, Panzoom: { maxScale: 4 } },
    Slideshow: { timeout: 3000 },
    Hash: true,
});