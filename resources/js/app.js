function toggleMenu() {
    document.querySelector('.nav-links')?.classList.toggle('open');
    document.querySelector('.nav-actions')?.classList.toggle('open');
}

document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const t = document.querySelector(a.getAttribute('href'));
        if (t) { e.preventDefault(); t.scrollIntoView({ behavior: 'smooth' }); }
    });
});

window.addEventListener('scroll', () => {
    const nav = document.querySelector('.navbar');
    if (nav) nav.style.boxShadow = window.scrollY > 10 ? '0 2px 16px rgba(0,0,0,.08)' : '';
});