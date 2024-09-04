/* Canvas */
const canvas = new fabric.Canvas("cd-canvas", { selection: false });
canvas.setDimensions({ width: 600, height: 600 });

fabric.Image.fromURL('/wp-content/plugins/thesis/app/assets/img/cd-mask.png', function (img) {
    img.set({ scaleX: canvas.width / img.width, scaleY: canvas.height / img.height, selectable: false });
    canvas.add(img)
})

canvas.on('object:moving', function (e) {
    const obj = e.target;

    // Check boundaries and adjust object position
    if (obj.left < 0) {
        obj.left = 0;
    }
    if (obj.top < 0) {
        obj.top = 0;
    }
    if (obj.left + obj.width * obj.scaleX > canvas.width) {
        obj.left = canvas.width - obj.width * obj.scaleX;
    }
    if (obj.top + obj.height * obj.scaleY > canvas.height) {
        obj.top = canvas.height - obj.height * obj.scaleY;
    }
});