document.addEventListener("DOMContentLoaded", () => {
    const shortLinks = document.querySelectorAll(".short-link");

    shortLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault(); 

            const parent = link.parentElement;
            const clickSpan = parent.querySelector(".click-count");
            const expires = clickSpan?.dataset.expires;
            const id = link.dataset.id;

            if (expires) {
                const expiryDate = new Date(expires);
                const now = new Date();
                if (now > expiryDate) {
                    alert(`This link has expired!\nExpired on: ${expiryDate.toLocaleString()}`);
                    return;
                }
            }

            fetch("update_click.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "id=" + encodeURIComponent(id)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    clickSpan.textContent = `This link has been clicked ${data.clicks} times.`;
                }
                window.open(link.href, "_blank");
            });
        });
    });
});
