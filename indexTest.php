<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Color Overlay</title>
    <style>
        .content {
            display: flex;
            position: fixed;
            margin: auto;
            left: 10%;

        }

        .color-grid {
            display: grid;
            grid-template-columns: 50px 50px 50px 50px;
            gap: 10px;
        }

        .color-box {
            width: 50px;
            height: 50px;
            border: 2px solid transparent;
        }

        .selected {
            border: 2px solid black;
        }
    </style>
    <script>

        async function submitForm() {
            const skinColor = document.getElementById("hiddenSkinColor").value;
            const eyeColor = document.getElementById("hiddenEyeColor").value;
            const imgElement = document.getElementById("overlayedImage");

            // Validate the color input (basic validation)
            function validateHexColor(hexColor) {
                return /^([a-fA-F0-9]{6})$/.test(hexColor);
            }

            if (!validateHexColor(skinColor) || !validateHexColor(eyeColor)) {
                alert("Please choose two colors!!");
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

        function setColor(type, color, event) {
            document.getElementById('hidden' + type + 'Color').value = color.replace('#', '');

            // Remove 'selected' class from all boxes of the same type
            const colorBoxes = document.querySelectorAll('.' + type.toLowerCase() + '-box');
            colorBoxes.forEach(box => box.classList.remove('selected'));

            // Add 'selected' class to the clicked box
            event.target.classList.add('selected');
        }
    </script>
</head>
<body>
<h1>Choose a skin & eye color.</h1>
<div class="content">
    <form onsubmit="event.preventDefault(); submitForm();">
        <h4>Predefined Skin Colors</h4>
        <div class="color-grid">
            <div class="color-box skin-box" style="background-color: #fae7d0;"
                 onclick="setColor('Skin', '#fae7d0', event)"></div>
            <div class="color-box skin-box" style="background-color: #dfc183;"
                 onclick="setColor('Skin', '#dfc183', event)"></div>
            <div class="color-box skin-box" style="background-color: #aa724b;"
                 onclick="setColor('Skin', '#aa724b', event)"></div>
            <div class="color-box skin-box" style="background-color: #feb186;"
                 onclick="setColor('Skin', '#feb186', event)"></div>
            <div class="color-box skin-box" style="background-color: #b98865;"
                 onclick="setColor('Skin', '#b98865', event)"></div>
            <div class="color-box skin-box" style="background-color: #7b4b2a;"
                 onclick="setColor('Skin', '#7b4b2a', event)"></div>
            <!-- Add more predefined colors -->
        </div>
        <input type="hidden" id="hiddenSkinColor">
        <label for="customSkinColor">Custom: </label>
        <input type="color" id="customSkinColor" name="customSkinColor" onchange="setColor('Skin', this.value)">
        <br/>

        <h4>Predefined Eye Colors</h4>
        <div class="color-grid">
            <div class="color-box eye-box" style="background-color: #75d279;"
                 onclick="setColor('Eye', '#75d279', event)"></div>
            <div class="color-box eye-box" style="background-color: #5250da;"
                 onclick="setColor('Eye', '#5250da', event)"></div>
            <div class="color-box eye-box" style="background-color: #d74141;"
                 onclick="setColor('Eye', '#d74141', event)"></div>
            <div class="color-box eye-box" style="background-color: #d5b246;"
                 onclick="setColor('Eye', '#d5b246', event)"></div>
            <div class="color-box eye-box" style="background-color: #a146d0;"
                 onclick="setColor('Eye', '#a146d0', event)"></div>
            <!-- Add more predefined colors -->
        </div>
        <input type="hidden" id="hiddenEyeColor">
        <label for="customEyeColor">Custom: </label>
        <input type="color" id="customEyeColor" name="customEyeColor" onchange="setColor('Eye', this.value)">
        <br/>

        <button type="submit">Submit</button>
    </form>
</div>
<!-- Image will be displayed here -->
<div class="output"><img id="overlayedImage" alt="Overlayed Image" src="base/compiler.php"></div>
</body>
</html>
