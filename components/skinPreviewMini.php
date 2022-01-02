<canvas id="skin_container<?php echo $skin['skin_id']; ?>"></canvas>
<script>
    const configurations<?php echo $skin['skin_id']; ?> = [
        {
            skin: "<?php echo "img/" .  $pollKey . "_" . $username. ".png"; ?>",
            cape: null
        }
    ];

    const skinParts<?php echo $skin['skin_id']; ?> = ["head", "body", "rightArm", "leftArm", "rightLeg", "leftLeg"];
    const skinLayers<?php echo $skin['skin_id']; ?> = ["innerLayer", "outerLayer"];
    const availableAnimations<?php echo $skin['skin_id']; ?> = {
        idle: skinview3d.IdleAnimation,
        walk: skinview3d.WalkingAnimation,
        run: skinview3d.RunningAnimation,
        fly: skinview3d.FlyingAnimation
    };

    let skinViewer<?php echo $skin['skin_id']; ?>;
    let orbitControl<?php echo $skin['skin_id']; ?>;
    let rotateAnimation<?php echo $skin['skin_id']; ?>;
    let primaryAnimation<?php echo $skin['skin_id']; ?>;

    //initializeControls();
    (async function () {
        skinViewer<?php echo $skin['skin_id']; ?> = new skinview3d.FXAASkinViewer({
            canvas: document.getElementById("skin_container<?php echo $skin['skin_id']; ?>")
        });
        orbitControl<?php echo $skin['skin_id']; ?> = skinview3d.createOrbitControls(skinViewer<?php echo $skin['skin_id']; ?>);
        rotateAnimation<?php echo $skin['skin_id']; ?> = null;
        primaryAnimation<?php echo $skin['skin_id']; ?> = null;

        skinViewer<?php echo $skin['skin_id']; ?>.width = 300;
        skinViewer<?php echo $skin['skin_id']; ?>.height = 300;
        skinViewer<?php echo $skin['skin_id']; ?>.fov = 70;
        skinViewer<?php echo $skin['skin_id']; ?>.animations.speed = 1;
        rotateAnimation<?php echo $skin['skin_id']; ?> = skinViewer<?php echo $skin['skin_id']; ?>.animations.add(skinview3d.RotatingAnimation);
        rotateAnimation<?php echo $skin['skin_id']; ?>.speed = 1;

        orbitControl<?php echo $skin['skin_id']; ?>.enableRotate = true;
        orbitControl<?php echo $skin['skin_id']; ?>.enableZoom = true;
        orbitControl<?php echo $skin['skin_id']; ?>.enablePan = false;

        await Promise.all([
            skinViewer<?php echo $skin['skin_id']; ?>.loadSkin(configurations<?php echo $skin['skin_id']; ?>[0].skin)
        ]);
        skinViewer<?php echo $skin['skin_id']; ?>.render();

        //reloadSkin();
        //reloadCape();
        skinViewer<?php echo $skin['skin_id']; ?>.background = "black";
    })();
</script>