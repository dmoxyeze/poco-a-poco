//a sample 3D array
const ARR_3D = [
  [1, 2, 3],
  [4, 5, 6],
  [7, 8, 9],
];

// a sample 1D array
const ARR = [1, 2, 3, 4, 5];

// rotate an array clockwise by k
const rotate = (arr, num) => {
  let newArr = [...arr];
  if (num > 0) {
    for (let index = 0; index < num; index++) {
      newArr.push(newArr.shift());
    }
  }
  return newArr;
};

//rotate a 1D array to the left or right given a number of times k
const rotateLeftorRight = (arr, k, direction) => {
  let newArr = [...arr];
  if (direction === "left") {
    return rotateLeft(newArr, k);
  } else {
    return rotateRight(newArr, k);
  }
};

// rotate an array to the left given a number of times k
const rotateLeft = (arr, k) => {
  let newArr = [...arr];
  if (k > 0) {
    for (let index = 0; index < k; index++) {
      newArr.unshift(newArr.pop());
    }
    return newArr;
  }
  return newArr;
};

// rotate an array to the right given a number of times k
const rotateRight = (arr, k) => {
  let newArr = [...arr];
  if (k > 0) {
    for (let index = 0; index < k; index++) {
      newArr.push(newArr.shift());
    }
    return newArr;
  }
  return;
};

// rotate 3d array
const rotate3d = (arr, num /* number of time to rotate */) => {
  let newArr = [...arr]; //make a copy of the original array

  let rotatedArr = []; // hold our rotated array
  if (num > 0) {
    for (let rotations = 0; rotations < num; rotations++) {
      for (let index = 0; index < newArr.length; index++) {
        let rotated = [];
        for (let i = newArr.length - 1; i >= 0; i--) {
          rotated.push(newArr[i][index]);
          rotatedArr[index] = [...rotated];
        }
      }
      // reassign rotatedArr to newArr in case we have another iteration
      newArr = [...rotatedArr];
    }
  }
  return newArr;
};

//uncoment to test
//console.log(rotate3d(ARR_3D, 3));
//console.log(rotateRight(ARR, 3));
//console.log(rotateLeft(ARR, 3));
