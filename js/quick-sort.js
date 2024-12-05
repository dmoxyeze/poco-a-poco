// a quick sort function written in JS
let testArray = [4,6,2,1,3,9,5,7,8,0,10]

const quickSort = (arr) => {
  if (arr.length <= 1) return arr;
  let pivot = arr[0], leftArr = [], rightArr = [];
  for (let i = 1; i < arr.length; i++) {
    if (arr[i] < pivot) {
      leftArr.push(arr[i]);
    } else {
      rightArr.push(arr[i]);
    }
  }
  return [...quickSort(leftArr), pivot, ...quickSort(rightArr)];
};
console.log(quickSort(testArray));