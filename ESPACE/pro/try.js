const fr = require('face-recognition');

const image = fr.loadImage('../images_db/subjects/john1.jpg');

const win = new fr.ImageWindow();

win.setImage(image);
win.addOverlay(rectangle);

fr.hitEnterToContinue();

const detector = fr.FaceDetector();
 const faceRectangles = detector.locateFa
