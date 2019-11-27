const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');

let image = new Image();
image.src = './images/pic1.png';

const width = 400;
const height = 400;
const len = 4;
const d = width / len;
let puzzles = [];
let redPuzzle = { xPos: 0, yPos: 0 };

let mouseX = null;
let mouseY = null;

function init() {
    for (let i = 0; i < len; i++) {
        let sy = d * i;
        for (let j = 0; j < len; j++) {
            let sx = d * j;
            puzzles.push({ sx: sx, sy: sy, red: false});
            context.drawImage(image, sx, sy, d, d, sx, sy, d, d);
        }
    }

    //puzzles = shuffleArray(puzzles)
    puzzles[0].red = true;
}

function draw() {
    context.clearRect(0, 0, width, height);
    let xPos = 0;
    let yPos = 0;
    puzzles.forEach( puzzle => {
        puzzle.xPos = xPos;
        puzzle.yPos = yPos;
        context.drawImage(image, puzzle.sx, puzzle.sy, d, d, xPos, yPos, d, d);
        xPos += d;
        if (xPos >= width) {
            xPos = 0;
            yPos += d;
        }
    });

    context.fillStyle = 'red';
    context.fillRect(redPuzzle.xPos, redPuzzle.yPos, d, d);
}

function shuffleArray(o){
    for (let j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
    return o;
}

function movePuzzle(mouseX, mouseY) {
    puzzles.forEach( (puzzle, index) => {
        if ((mouseX < puzzle.xPos) || (mouseX > (puzzle.xPos + d)) || (mouseY < puzzle.yPos) || (mouseY > (puzzle.yPos + d))) {
            // no hit
        } else if (!puzzle.red) {
            // top
            if ((index - len) >= 0 && puzzles[index - len].red) {
                redPuzzle.xPos = puzzle.xPos;
                redPuzzle.yPos = puzzle.yPos;
                swap(puzzles, index, index - len);
                draw();
            } else
            // bottom
            if ((index + len) < (len * len) && puzzles[index + len].red) {
                redPuzzle.xPos = puzzle.xPos;
                redPuzzle.yPos = puzzle.yPos;
                swap(puzzles, index, index + len);
                draw();
            } else
            // right
            if (((index + 1) % len) != 0 && puzzles[index + 1].red) {
                redPuzzle.xPos = puzzle.xPos;
                redPuzzle.yPos = puzzle.yPos;
                swap(puzzles, index, index + 1);
                draw();
            } else
            // left
            if (((index - 1) % len) != (len - 1) && index != 0 && puzzles[index - 1].red) {
                redPuzzle.xPos = puzzle.xPos;
                redPuzzle.yPos = puzzle.yPos;
                swap(puzzles, index, index - 1);
                draw();
            }
        }
    });
}

function swap(arr, a, b) {
    let tmp = arr[b];
    arr[b] = arr[a];
    arr[a] = tmp; 
}

init();
draw();
canvas.addEventListener('click', e => {
    if(e.layerX || e.layerX == 0){
        mouseX = e.layerX - canvas.offsetLeft;
        mouseY = e.layerY - canvas.offsetTop;
    }
    else if(e.offsetX || e.offsetX == 0){
        mouseX = e.offsetX - canvas.offsetLeft;
        mouseY = e.offsetY - canvas.offsetTop;
    }

    movePuzzle(mouseX, mouseY);
});