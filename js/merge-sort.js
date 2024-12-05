// a quick sort function written in JS
let testArray = [4,6,2,1,3,9,5,7,8,0,10]
const mergeSort = (arr) => {
  if (arr.length <= 1) return arr;
  // get middle index
  let middle = Math.floor(arr.length / 2);
  // split array into two halves
  let leftArr = arr.slice(0, middle);
  let rightArr = arr.slice(middle);
  // merge the two halves
  return merge(mergeSort(leftArr), mergeSort(rightArr));
};

const merge = (left, right) => {
  let result = [];
  while (left.length && right.length) {
    if (left[0] < right[0]) {
      result.push(left.shift());
    } else {
      result.push(right.shift());
    }
  }
  result.push(...left, ...right);
  return result;
};

console.log(mergeSort(testArray));