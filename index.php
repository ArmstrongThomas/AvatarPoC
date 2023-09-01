<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Color Overlay</title>
    <script>
        async function submitForm() {
            const skinColor = document.getElementById("skinColor").value;
            const eyeColor = document.getElementById("eyeColor").value;
            const imgElement = document.getElementById("overlayedImage");

            // Validate the color input (basic validation)
            function validateHexColor(hexColor) {
                return /^([a-fA-F0-9]{6})$/.test(hexColor);
            }

            if (!validateHexColor(skinColor) || !validateHexColor(eyeColor)) {
                alert("Please enter valid hex color codes.");
                return;
            }


            const url = `/base/compiler.php?skinColor=${skinColor}&eyeColor=${eyeColor}`;
            try {
                const response = await fetch(url);
                const blob = await response.blob();
                const imageURL = URL.createObjectURL(blob);
                imgElement.src = imageURL;
            } catch (error) {
                console.error("Error fetching image:", error);
            }
        }
    </script>
</head>
<body>
<h3>Choose a skin & eye color.</h3>
<form onsubmit="event.preventDefault(); submitForm();">
    <label for="skinColor">Enter Hex Color Code (e.g., fae7d0 or aa724b): </label>
    <input type="text" id="skinColor" name="skinColor" maxlength="6" required placeholder="SkinColor">
    <br/>
    <label for="eyeColor">Enter Hex Color Code (e.g., 4CAF50 or 211fd5): </label>
    <input type="text" id="eyeColor" name="eyeColor" maxlength="6" required placeholder="eyeColor">
    <button type="submit">Submit</button>
</form>

<!-- Image will be displayed here -->
<img id="overlayedImage" alt="Overlayed Image">
</body>
</html>
