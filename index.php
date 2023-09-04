<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Avatar Thing Proof of Concept </title>
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

        .output {

        }
    </style>
    <script>
        async function submitForm() {
            const skinColor = document.getElementById("hiddenSkinColor").value;
            const eyeColor = document.getElementById("hiddenEyeColor").value;
            const hairColor = document.getElementById("hiddenHairColor").value;
            const hairVariant = document.querySelector('input[name="hairVariant"]:checked').value;
            const underGarmentVariant = document.querySelector('input[name="underGarmentVariant"]:checked').value;
            const imgElement = document.getElementById("overlayedImage");

            function validateHexColor(hexColor) {
                return /^([a-fA-F0-9]{6})$/.test(hexColor);
            }

            if (!validateHexColor(skinColor) || !validateHexColor(eyeColor) || !validateHexColor(hairColor)) {
                alert("Please choose three colors!!");
                return;
            }
            const url = `/base/compiler.php?skinColor=${skinColor}&eyeColor=${eyeColor}&hairVariant=${hairVariant}&hairColor=${hairColor}&underGarmentVariant=${underGarmentVariant}`;
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
            const colorBoxes = document.querySelectorAll('.' + type.toLowerCase() + '-box');
            colorBoxes.forEach(box => box.classList.remove('selected'));
            event.target.classList.add('selected');
        }
    </script>
</head>
<body>
<h1>Choose a skin & eye color.</h1>
<div class="content">
    <form onsubmit="event.preventDefault(); submitForm();">
        <h4>Choose a Skin Colors</h4>
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
        </div>
        <input type="hidden" id="hiddenSkinColor">
        <label for="customSkinColor">Custom: </label>
        <input type="color" id="customSkinColor" name="customSkinColor" onchange="setColor('Skin', this.value)">
        <br/>
        <h4>Choose an Eye Colors</h4>
        <div class="color-grid">
            <div class="color-box eye-box" style="background-color: #75d279;"
                 onclick="setColor('Eye', '#75d279', event)"></div>
            <div class="color-box eye-box" style="background-color: #5250da;"
                 onclick="setColor('Eye', '#5250da', event)"></div>
            <div class="color-box eye-box" style="background-color: #d74141;"
                 onclick="setColor('Eye', '#d74141', event)"></div>
            <div class="color-box eye-box" style="background-color: #d5b246;"
                 onclick="setColor('Eye', '#d5b246', event)"></div>
        </div>
        <input type="hidden" id="hiddenEyeColor">
        <label for="customEyeColor">Custom: </label>
        <input type="color" id="customEyeColor" name="customEyeColor" onchange="setColor('Eye', this.value)">
        <br/>
        <div class="hairSelector">
            <h4>Choose a hairstyle and color:</h4>
            <div>
                <input type="radio" id="hairVariant0" name="hairVariant" value="0" checked>
                <label for="hairVariant0">Bald</label>
            </div>
            <div>
                <input type="radio" id="hairVariant1" name="hairVariant" value="1">
                <label for="hairVariant1">Shaved</label>
            </div>
            <div>
                <input type="radio" id="hairVariant2" name="hairVariant" value="2">
                <label for="hairVariant2">Curly</label>
            </div>
        </div>
        <br/>
        <div class="color-grid">
            <div class="color-box hair-box" style="background-color: #d2bf75;"
                 onclick="setColor('Hair', '#d2bf75', event)"></div>
            <div class="color-box hair-box" style="background-color: #805934;"
                 onclick="setColor('Hair', '#805934', event)"></div>
            <div class="color-box hair-box" style="background-color: #a23939;"
                 onclick="setColor('Hair', '#a23939', event)"></div>
            <div class="color-box hair-box" style="background-color: #484842;"
                 onclick="setColor('Hair', '#484842', event)"></div>
            <div class="color-box hair-box" style="background-color: #c2c2c2;"
                 onclick="setColor('Hair', '#c2c2c2', event)"></div>
        </div>
        <input type="hidden" id="hiddenHairColor">
        <label for="customHairColor">Custom: </label>
        <input type="color" id="customHairColor" name="customHairColor" onchange="setColor('Hair', this.value)">
        <br/>
        <div class="UnderGarmentSelector">
            <h4>Choose an undergarment:</h4>
            <div>
                <input type="radio" id="underGarmentVariant1" name="underGarmentVariant" value="1" checked>
                <label for="underGarmentVariant1">Briefs</label>
            </div>
            <div>
                <input type="radio" id="underGarmentVariant2" name="underGarmentVariant" value="2">
                <label for="underGarmentVariant2">Boxers</label>
            </div>
        </div>
        <br/>
        <button type="submit">Submit</button>
    </form>
</div>
<div class="output"><img id="overlayedImage" alt="Overlayed Image"
                         src="base/compiler.php?hairVariant=2&hairColor=000000&skinColor=000000&eyeColor=000000&underGarmentVariant=2">
</div>
</body>
</html>

