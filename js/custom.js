// Global hexs
var hexs = [];

// Visually adds a new color and adds it to hexs array
function addColor() {
    var color = document.getElementById('hexcode').value;
    colorArray = color.split(',');
    for (i = 0; i < colorArray.length; ++i) {
        color = colorArray[i].replace(/\s/g, '');; // Pulls hex and strips spaces

        if (color.charAt(0) != '#') {
            color = "#" + color;
        }

        code = '<span class="badge" style="background-color: ' + color + ';">' + color + '</span> ';
        content = document.getElementById('colors').innerHTML;
        document.getElementById('colors').innerHTML = content + code;

        hexs.push(color);
    }
    document.getElementById('hexcode').value = "";
}

// Runs matching
function matcher() {
    // Build hexs array
    jsonArray = '[ ';
    for (i = 0; i < hexs.length; ++i) {
        jsonArray += '"' + hexs[i] + '"';
        if (i != hexs.length - 1) {
            jsonArray += ', ';
        }
    }
    jsonArray += ' ]';
    console.log(jsonArray);

    // Extract URL
    urlString = document.getElementById('url').value;
    console.log(urlString);

    // POST the data
    $.ajax({
        type: "POST",
        url: 'http://api.zitzasoft.com/api/palette_matcher/match',
        data: JSON.stringify({
            Hexs:jsonArray,
            URL:urlString
        }),
        dataType: 'json',
        contentType: "application/json",
        success: function(data)
        {
            console.log("Response: " + data["match"]);
        } 
    });
}
