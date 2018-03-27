<canvas id="granim-canvas" class="backgroundCanvas"></canvas>
<!-- Create a Granim instance -->
<script>
    var granimInstance = new Granim({
    element: '#granim-canvas',
    name: 'granim',
    opacity: [1, 1],
    states : {
        "default-state": {
            gradients: [
                ['#004D40', '#006064'],
                ['#01579B', '#0D47A1']
            ]
        }
    }
    });
</script>