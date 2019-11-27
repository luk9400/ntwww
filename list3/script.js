const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');

const width = 400;
const height = 400;

const len = 4;

let image = new Image();
image.src = './images/pic1.png';

for (let i = 0; i < len; i++) {
    d = width / len;
    sy = d * i;
    for (let j = 0; j < len; j++) {
        sx = d * j;
        context.drawImage(image, sx, sy, d, d, sx, sy, d, d);
    }    
}

console.log(image)
