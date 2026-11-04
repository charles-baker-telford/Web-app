document.getElementById("login_form").addEventListener("submit", async (event) => {
            event.preventDefault();
            const formElement = event.target;
            const formData = new FormData(formElement)

            try {
                const response = await fetch("scripts/login.php", {
                    method: "POST",
                    body: formData
                });
                const result = await response.json();
                console.log(result);
            } catch (error) {
            console.error("request failed:", error)
            }
        })