<div class="row align-items-center flexContentMobile bg-dark" style="height:100%; border-radius: 10px;">
    <div class="text-center col">
        <div class="control-section">
			<h1>Animation</h1>
			<button id="animation_pause_resume" type="button" class="control">Pause / Resume</button>
			<div>
				<div class="control">
					<label><input type="radio" id="primary_animation_none" name="primary_animation" value="" checked> None</label>
					<label><input type="radio" id="primary_animation_idle" name="primary_animation" value="idle"> Idle</label>
					<label><input type="radio" id="primary_animation_walk" name="primary_animation" value="walk"> Walk</label>
					<label><input type="radio" id="primary_animation_run" name="primary_animation" value="run"> Run</label>
					<label><input type="radio" id="primary_animation_fly" name="primary_animation" value="fly"> Fly</label>
				</div>
				<label class="control">Speed: <input id="primary_animation_speed" type="number" value="1" step="0.1" size="3"></label>
			</div>
		</div>
        <hr>
        <div class="control-section">
			<h1>Skin Layers</h1>
			<table id="layers_table" class="table text-white">
				<thead>
					<tr>
						<th></th>
						<th>head</th>
						<th>body</th>
						<th>right arm</th>
						<th>left arm</th>
						<th>right leg</th>
						<th>left leg</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>inner</th>
						<td><input type="checkbox" data-layer="innerLayer" data-part="head" checked></td>
						<td><input type="checkbox" data-layer="innerLayer" data-part="body" checked></td>
						<td><input type="checkbox" data-layer="innerLayer" data-part="rightArm" checked></td>
						<td><input type="checkbox" data-layer="innerLayer" data-part="leftArm" checked></td>
						<td><input type="checkbox" data-layer="innerLayer" data-part="rightLeg" checked></td>
						<td><input type="checkbox" data-layer="innerLayer" data-part="leftLeg" checked></td>
					</tr>
					<tr>
						<th>outer</th>
						<td><input type="checkbox" data-layer="outerLayer" data-part="head" checked></td>
						<td><input type="checkbox" data-layer="outerLayer" data-part="body" checked></td>
						<td><input type="checkbox" data-layer="outerLayer" data-part="rightArm" checked></td>
						<td><input type="checkbox" data-layer="outerLayer" data-part="leftArm" checked></td>
						<td><input type="checkbox" data-layer="outerLayer" data-part="rightLeg" checked></td>
						<td><input type="checkbox" data-layer="outerLayer" data-part="leftLeg" checked></td>
					</tr>
				</tbody>
			</table>
		</div>
    </div>
    <div class="text-center col" style="margin: 2rem;">
        <canvas id="skin_preview_full"></canvas>
    </div>
</div>

                                
<script>
    const skinPartsFull = ["head", "body", "rightArm", "leftArm", "rightLeg", "leftLeg"];
    const skinLayersFull = ["innerLayer", "outerLayer"];
    const availableAnimationsFull = {
        idle: skinview3d.IdleAnimation,
        walk: skinview3d.WalkingAnimation,
        run: skinview3d.RunningAnimation,
        fly: skinview3d.FlyingAnimation
    };

    let skinViewerFull;
    let orbitControlFull;
    let rotateAnimationFull;
    let primaryAnimationFull;

    function reloadPanorama() {
        skinViewerFull.background = "black";
    }

    function initializeControls() {

        document.getElementById("animation_pause_resume").addEventListener("click", () => skinViewerFull.animations.paused = !skinViewerFull.animations.paused);


        for (const el of document.querySelectorAll('input[type="radio"][name="primary_animation"]')) {
            el.addEventListener("change", e => {
                if (rotateAnimationFull !== null) {
                    rotateAnimationFull.resetAndRemove();
                    rotateAnimationFull = null;
                }
                if (e.target.value !== "") {
                    rotateAnimationFull = skinViewerFull.animations.add(availableAnimations[e.target.value]);
                    rotateAnimationFull.speed = document.getElementById("primary_animation_speed").value;
                }
            });
        }
        document.getElementById("primary_animation_speed").addEventListener("change", e => {
            if (rotateAnimationFull !== null) {
                rotateAnimationFull.speed = e.target.value;
            }
        });

        for (const part of skinPartsFull) {
            for (const layer of skinLayersFull) {
                document.querySelector(`#layers_table input[type="checkbox"][data-part="${part}"][data-layer="${layer}"]`)
                    .addEventListener("change", e => skinViewerFull.playerObject.skin[part][layer].visible = e.target.checked);
            }
        }
    }
    initializeControls();
    (async function () {
        skinViewerFull = new skinview3d.FXAASkinViewer({
            canvas: document.getElementById("skin_preview_full")
        });
        orbitControlFull = skinview3d.createOrbitControls(skinViewerFull);
        rotateAnimationFull = null;
        rotateAnimationFull = null;

        skinViewerFull.width = 500;
        skinViewerFull.height = 600;
        skinViewerFull.fov = 70;
        skinViewerFull.animations.speed = 1;
        const primaryAnimationNameFull = document.querySelector('input[type="radio"][name="primary_animation"]:checked').value;
        if (primaryAnimationNameFull !== "") {
            rotateAnimationFull = skinViewerFull.animations.add(availableAnimations[primaryAnimationNameFull]);
            rotateAnimationFull.speed = document.getElementById("primary_animation_speed").value;
        }

        orbitControlFull.enableRotate = true;
        orbitControlFull.enableZoom = true;
        orbitControlFull.enablePan = false;
        for (const part of skinPartsFull) {
            for (const layer of skinLayersFull) {
                skinViewerFull.playerObject.skin[part][layer].visible =
                    document.querySelector(`#layers_table input[type="checkbox"][data-part="${part}"][data-layer="${layer}"]`).checked;
            }
        }
        await Promise.all([
            skinViewerFull.loadSkin("<?php echo "img/" .  $pollKey . "_" . $username. ".png"; ?>")
        ]);
        skinViewerFull.render();

        //reloadSkin();
        //reloadCape();
        reloadPanorama();
    })();
</script>