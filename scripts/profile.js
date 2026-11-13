document.getElementById("profile")?.addEventListener("submit", async (event) => {
    event.preventDefault();
    const formElement = event.target;
    const formData = new FormData(formElement)

    try {
        const response = await fetch("scripts/profile.php", {
            method: "POST",
            body: formData
        });
        const result = await response.json();
        new Data('response', result);
    } catch (error) {
    console.error("request failed:", error)
    }
})

