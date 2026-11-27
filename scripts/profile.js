

async function get_profile() {
try {
    // 1. Fetch the data from the URL or local file path
    const response = await fetch("scripts/profile_get.php");

    // 2. Verify the HTTP request succeeded (status 200-299)
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    // 3. Parse the JSON body into a JavaScript object
    const data = await response.json();

    // 4. Process the retrieved data
    var this_response = new Data("something", data);

  } catch (error) {
    console.error("Failed to fetch profile data:", error);
  }
}

async function saveToDatabase(text, id) {
  try {
    const response = await fetch("scripts/save_profile_field.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id, text }),
    });

    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    const result = await response.json();
    return result;
  } catch (error) {
    console.error("Failed to save to database:", error);
    throw error;
  }
}

