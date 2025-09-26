document.addEventListener("DOMContentLoaded", () => {
    const shortLinks = document.querySelectorAll(".short-link");

    shortLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            const parent = link.parentElement;
            const clickSpan = parent.querySelector(".click-count");
            const expires = clickSpan?.dataset.expires;

            if (expires) {
                const expiryDate = new Date(expires);
                const now = new Date();
                if (now > expiryDate) {
                    e.preventDefault(); 
                    alert(`This link has expired!\nExpired on: ${expiryDate.toLocaleString()}`);
                }
            }
        });
    });
});
