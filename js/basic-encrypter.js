/*
    This is a function that works as a basic encrypter. On receiving a string, the function iterates over each letter in the string and returns
    a match in the English alphabet when counting backward or forward from the letter, depending on the (orient) passed, and to a degree(K) passed.
    When an orient of 1 is passed, it counts backward from the match to the degree(K) passed. When it is 0, it counts forward from the match to the
    degree(K) passed.
    Where any letter in the string is in uppercase, the returned encrypted letter must match the case.
    It takes in 3 parameters; 
  - A text to be encrypted
  - orient: determines whether the encryption shifts to the left or the right
  - K: determines the degree of the shift
*/
let alphabet = "abcdefghijklmnopqrstuvwxyz".split("");

function encrypter(iText, orient, k){
    let result = [];
    for(i = 0; i < iText.length; i++) {
        // check for match in alphabet
        let check = alphabet.findIndex(e => e == iText[i].toLowerCase());
        // check orient
        let shifted = doShift(orient, k, check)
        result.push(formatStr(iText[i], shifted))
    }
    return result.join("");
}
function genCharArray(charA, charZ) {
    var a = [], i = charA.charCodeAt(), j = charZ.charCodeAt();
    for (; i <= j; ++i) {
        a.push(String.fromCharCode(i));
    }
    return a;
}

function doShift(orient, k, index) {
    let position = 0;
    if(orient == 1 /* shift left*/){
            position = index - k
            if(position < 0){
                let match = alphabet.join("").slice(position).split("")[0]
                return match;
            }{
                return alphabet[position]
            }
        }else{
          
            // shift right
            position = parseInt(index) + parseInt(k)
            // check if position is greater than array length
            if(position >= alphabet.length) {
              let excess = position - alphabet.length
              return alphabet[excess]
            }else{
              return alphabet[position]
            }
        }
}

function formatStr(initialStr, finalStr) {
    return initialStr == initialStr.toLowerCase()? finalStr: finalStr.toUpperCase();
}
const iText = "password"
const k = "4"
const orient = 1
console.log(encrypter(iText,orient,k));
