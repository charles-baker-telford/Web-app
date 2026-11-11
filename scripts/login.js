document.getElementById("login_form")?.addEventListener("submit", async (event) => {
    event.preventDefault();
    const formElement = event.target;
    const formData = new FormData(formElement)

    try {
        const response = await fetch("scripts/login.php", {
            method: "POST",
            body: formData
        });
        const result = await response.json();
        new Data('response', result);
    } catch (error) {
    console.error("request failed:", error)
    }
})

document.getElementById("register_form")?.addEventListener("submit", async (event) => {
    event.preventDefault();
    const formElement = event.target;
    const formData = new FormData(formElement)

    try {
        const response = await fetch("scripts/register.php", {
            method: "POST",
            body: formData
        });
        const result = await response.json();
        new Data('response', result);
    } catch (error) {
    console.error("request failed:", error)
    }
})