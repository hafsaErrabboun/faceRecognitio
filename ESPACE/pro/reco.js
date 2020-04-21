const cv = require('opencv4nodejs');
const fs = require('fs');
const path = require('path');


const classifier = new cv.CascadeClassifier(cv.HAAR_FRONTALFACE_ALT2);
const getFaceImage = (grayImg) => {
  const faceRects = classifier.detectMultiScale(grayImg).objects;
  if (!faceRects.length) {
    throw new Error('failed to detect faces');
  }
  return grayImg.getRegion(faceRects[0]);
};

//get the path of the photo directory
const basePath = '../images_db';
const subjectsPath = path.resolve(basePath,'subjects');

const nameMappings = ['lizzo','hafsa','oumaima'];
//get the absolute path
const allFiles = fs.readdirSync(subjectsPath);


const images = allFiles
  // get absolute file path
  .map(file => path.resolve(subjectsPath, file))
  // read image
  .map(filePath => cv.imread(filePath))
  // face recognizer works with gray scale images
  .map(image => image.bgrToGray())
  // detect and extract face
  .map(getFaceImage)
  // face images must be equally sized
  .map(faceImg => faceImg.resize(100, 100));


const isTargeImage = (_, i) => allFiles[i].includes('3');
const isTrainingImage = (_, i) => !isTargeImage(_, i);
// use images 1 - 3 for training
const trainImages = images.filter(isTrainingImage);
// use images 4 for testing
const testImages = images.filter(isTargeImage);
// make labels
const labels = allFiles.filter(isTrainingImage)
  .map(file => nameMappings.findIndex(name => file.includes(name)));

const lbph = new cv.LBPHFaceRecognizer();
  lbph.train(trainImages, labels);

  const runPrediction = (recognizer) => {
    testImages.forEach((img) => {
      const result = recognizer.predict(img);
      console.log('predicted: %s, confidence: %s', nameMappings[result.label], result.confidence);
      cv.imshowWait('face', img);
      cv.destroyAllWindows();
    });
  };


console.log('lbph:');
runPrediction(lbph);

//  const eigen = new cv.EigenFaceRecognizer();
  //const fisher = new cv.FisherFaceRecognizer();

  //eigen.train(trainImages, labels);
  //fisher.train(trainImages, labels);
