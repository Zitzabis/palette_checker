<div id="rendered_imgs"></div>
<script>

        const configurations = [
            {
                skin: "<?php echo "img/" .  $skin['skin_id'] . ".png"; ?>",
                cape: null
            }
        ];

        (async function () {
            const skinViewer = new skinview3d.FXAASkinViewer({
                width: 300,
                height: 300,
                renderPaused: true
            });
            skinViewer.camera.rotation.x = -0.620;
            skinViewer.camera.rotation.y = 0.534;
            skinViewer.camera.rotation.z = 0.348;
            skinViewer.camera.position.x = 30;
            skinViewer.camera.position.y = 30.0;
            skinViewer.camera.position.z = 42.0;
            skinViewer.background = "black";
            for (const config of configurations) {
                await Promise.all([
                    skinViewer.loadSkin(config.skin)
                ]);
                skinViewer.render();
                const image = skinViewer.canvas.toDataURL();

                const imgElement = document.createElement("img");
                imgElement.src = image;
                imgElement.width = skinViewer.width;
                imgElement.height = skinViewer.height;
                document.getElementById("rendered_imgs").appendChild(imgElement);
            }

            skinViewer.dispose();
        })();

</script>