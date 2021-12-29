<!-- <canvas id="granim-canvas" class="backgroundCanvas"></canvas> -->
<canvas id="canvas" class="backgroundCanvas"></canvas>
<!-- Create a Granim instance -->
<!-- <script>
    var randomNum = Math.floor((Math.random() * 2) + 1);
    var palette = [
        [ ["#f0f9e8", "#bae4bc"], ["#bae4bc", "#7bccc4"], ["#7bccc4", "#0868ac"] ],
        [ ["#e9d7b8", "#e8c9b3"], ["#e8c9b3", "#c59ca4"], ["#c59ca4", "#a48d9e"], ["#a48d9e", "#606d94"], ["#606d94", "#e9d7b8"] ]
    ]

    var granimInstance = new Granim({
    element: '#granim-canvas',
    name: 'granim',
    opacity: [1, 1],
    states : {
        "default-state": {
            gradients: palette[randomNum]
        }
    }
    });
</script> -->

<?php

    if(session_id() == ''){
        session_start();
    }

    if (isset($_SESSION['animatedBackground'])) {
        if ($_SESSION['animatedBackground'] == true) {
            ?>
                <script>
                    
                    $( document ).ready(function() {
                    try {
                        window.requestAnimFrame = function()
                        {
                            return (
                                window.requestAnimationFrame       || 
                                window.webkitRequestAnimationFrame || 
                                window.mozRequestAnimationFrame    || 
                                window.oRequestAnimationFrame      || 
                                window.msRequestAnimationFrame     || 
                                function(/* function */ callback){
                                    window.setTimeout(callback, 1000 / 60);
                                }
                            );
                    }();

                    var canvas = document.getElementById('canvas'); 
                    var context = canvas.getContext('2d');

                    //get DPI
                    let dpi = window.devicePixelRatio || 1;
                    context.scale(dpi, dpi);
                    console.log(dpi);

                    function fix_dpi() {
                    //get CSS height
                    //the + prefix casts it to an integer
                    //the slice method gets rid of "px"
                    let style_height = +getComputedStyle(canvas).getPropertyValue("height").slice(0, -2);
                    let style_width = +getComputedStyle(canvas).getPropertyValue("width").slice(0, -2);

                    //scale the canvas
                    canvas.setAttribute('height', style_height * dpi);
                    canvas.setAttribute('width', style_width * dpi);
                    canvas.style.background = "white";
                    var element = document.getElementById("mainContent");
                    element.classList.add("bg-dark");
                    }

                        var palette = [
                            ["Zitzabis", ["#e9d7b8", "#e8c9b3", "#c59ca4", "#a48d9e", "#606d94"]],
                            ["Zitzabus", ["#f0f9e8", "#bae4bc", "#7bccc4", "#43a2ca", "#0868ac"]],
                            ["Zitzabiscuit", ["#bf5b1d", "#e48043", "#d6cdcd", "#84a7c4", "#547a99"]],
                            ["Zootzabis", ["#e2ebd3", "#c8e09f", "#add46a", "#62afa7", "#2d8078"]]
                        ]
                        var randomNum = Math.floor(Math.random() * palette.length);

                        document.getElementById("paletteCredit").innerHTML = '<font size="2">Node palette by: ' + palette[randomNum][0] + '</font>';

                        var particle_count = 70,
                            particles = [],
                            couleurs = palette[randomNum][1];
                        function Particle()
                        {

                            this.radius = Math.round((Math.random()*3)+5);
                            this.x = Math.floor((Math.random() * ((+getComputedStyle(canvas).getPropertyValue("width").slice(0, -2) * dpi) - this.radius + 1) + this.radius));
                            this.y = Math.floor((Math.random() * ((+getComputedStyle(canvas).getPropertyValue("height").slice(0, -2) * dpi) - this.radius + 1) + this.radius));
                            this.color = couleurs[Math.floor(Math.random()*couleurs.length)];
                            this.speedx = Math.round((Math.random()*201)+0)/100;
                            this.speedy = Math.round((Math.random()*201)+0)/100;

                            switch (Math.round(Math.random()*couleurs.length))
                            {
                                case 1:
                                this.speedx *= 1;
                                this.speedy *= 1;
                                break;
                                case 2:
                                this.speedx *= -1;
                                this.speedy *= 1;
                                break;
                                case 3:
                                this.speedx *= 1;
                                this.speedy *= -1;
                                break;
                                case 4:
                                this.speedx *= -1;
                                this.speedy *= -1;
                                break;
                            }
                                
                            this.move = function()
                            {
                                
                                context.beginPath();
                                context.globalCompositeOperation = 'source-over';
                                context.fillStyle   = this.color;
                                context.globalAlpha = 1;
                                context.arc(this.x, this.y, this.radius, 0, Math.PI*2, false);
                                context.fill();
                                context.closePath();

                                this.x = this.x + this.speedx;
                                this.y = this.y + this.speedy;
                                
                                if(this.x <= 0+this.radius)
                                {
                                    this.speedx *= -1;
                                }
                                if(this.x >= canvas.width-this.radius)
                                {
                                    this.speedx *= -1;
                                }
                                if(this.y <= 0+this.radius)
                                {
                                    this.speedy *= -1;
                                }
                                if(this.y >= canvas.height-this.radius)
                                {
                                    this.speedy *= -1;
                                }

                                for (var j = 0; j < particle_count; j++)
                                {
                                    var particleActuelle = particles[j],
                                        yd = particleActuelle.y - this.y,
                                        xd = particleActuelle.x - this.x,
                                        d  = Math.sqrt(xd * xd + yd * yd);

                                    if ( d < 200 )
                                    {
                                        context.beginPath();
                                        context.globalAlpha = (200 - d) / (200 - 0);
                                        context.globalCompositeOperation = 'destination-over';
                                        context.lineWidth = 1;
                                        context.moveTo(this.x, this.y);
                                        context.lineTo(particleActuelle.x, particleActuelle.y);
                                        context.strokeStyle = this.color;
                                        context.lineCap = "round";
                                        context.stroke();
                                        context.closePath();
                                    }
                                }
                            };
                        };
                        for (var i = 0; i < particle_count; i++)
                        {
                            fix_dpi();
                            var particle = new Particle();
                            particles.push(particle);
                        }


                        function animate()
                        {
                            fix_dpi();
                            context.clearRect(0, 0, canvas.width, canvas.height);
                            for (var i = 0; i < particle_count; i++)
                            {
                                particles[i].move();
                            }
                            requestAnimFrame(animate);
                        }
                        
                        

                    
                        animate(); 
                    } catch (e) {
                        console.log(e);
                    }
                });
                </script>
            <?php
        } else {
            ?>
                <script>
                    var element = document.getElementById("mainContent");
                    element.style.color = 'black';
                </script>
            <?php
        }
    }
?>