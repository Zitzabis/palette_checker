// Global hexs
var hexs = [];

// Visually adds a new color and adds it to hexs array
function addColor() {
    var color = document.getElementById('hexcode').value;
    colorArray = color.split(',');
    for (i = 0; i < colorArray.length; ++i) {
        color = colorArray[i].replace(/\s/g, ''); // Pulls hex and strips spaces
        // Only logs color if valid hex value
        if (isValidHex(color)) {
            if (color.charAt(0) != '#') {
                hexs.push(color);
                color = "#" + color;
            }
            else {
                hexs.push(color.substring(1));
            }

            code = '<span class="badge whiteOutline" style="background-color: ' + color + ';">' + color + '</span> ';
            content = document.getElementById('colors').innerHTML;
            document.getElementById('colors').innerHTML = content + code;
        }
    }
    document.getElementById('hexcode').value = "";
}

 /**
   * Validates hex value
   * @param  {String} color hex color value
   * @return {Boolean}
   */
  function isValidHex(color) {
    if(!color || typeof color !== 'string') return false;

    // Validate hex values
    if(color.substring(0, 1) === '#') color = color.substring(1);

    switch(color.length) {
      case 3: return /^[0-9A-F]{3}$/i.test(color);
      case 6: return /^[0-9A-F]{6}$/i.test(color);
      case 8: return /^[0-9A-F]{8}$/i.test(color);
      default: return false;
    }

    return false;
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
                document.getElementById('status').innerHTML = '<span class="badge bg-success whiteOutline">The skin matches the palette!</span>';
            else
                document.getElementById('status').innerHTML = '<span class="badge bg-danger whiteOutline">The skin does not match the palette.</span>';
        } 
    });
}
