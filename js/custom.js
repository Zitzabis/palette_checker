// Global hexs
var hexs = [];

// Visually adds a new color and adds it to hexs array
function addColor() {
    var color = document.getElementById('hexcode').value;
    colorArray = color.split(',');
    for (i = 0; i < colorArray.length; ++i) {
        color = colorArray[i].replace(/\s/g, '');; // Pulls hex and strips spaces
        if (color.charAt(0) != '#') {
            hexs.push(color);
            color = "#" + color;
        }
        else {
            hexs.push(color.substring(1));
        }

        code = '<span class="badge" style="background-color: ' + color + ';">' + color + '</span> ';
        content = document.getElementById('colors').innerHTML;
        document.getElementById('colors').innerHTML = content + code;
    }
    document.getElementById('hexcode').value = "";
}

// Runs matching
function matcher() {
    object = JSON.stringify({
        Hexs: hexs,
        URL: document.getElementById('url').value
    })
    console.log("Send data: " + object);

    // POST the data
    $.ajax({
        type: "POST",
        url: 'http://api.zitzasoft.com/api/palette_matcher/match',
        data: object,
        dataType: 'json',
        contentType: "application/json",
        success: function(data)
        {
            console.log("Response: " + data["match"]);
            if (data["match"])
                document.getElementById('status').innerHTML = '<span class="badge bg-success">The skin matches the palette!</span>';
            else
                document.getElementById('status').innerHTML = '<span class="badge bg-danger">The skin does not match the palette.</span>';
        } 
    });
}
