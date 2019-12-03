const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');

// if (window.screen.orientation.type === "landscape-primary") {
//     canvas.width = (window.innerWidth) * 0.40;
// } else {
//     canvas.width = (window.innerWidth) * 0.8;
// }
// canvas.height = canvas.width;

let firstInit = true;
let image = new Image();
image.src = './images/pic1.jpg';

const width = image.naturalWidth;
const height = image.naturalHeight;
const canvasWidth = canvas.width;
let len = 4;
let sWidth = width / len;
let dWidth = canvas.width / len;
let puzzles = [];
let redPuzzle = { xPos: 0, yPos: 0, index: 0 };

function init() {
    let ratio = width / canvasWidth;
    for (let i = 0; i < len; i++) {
        let sy = dWidth * i;
        for (let j = 0; j < len; j++) {
            let sx = dWidth * j;
            puzzles.push({ sx: sx * ratio, sy: sy * ratio, red: false, hovered: false });
            context.drawImage(image, sx * ratio, sy * ratio, sWidth, sWidth, sx, sy, dWidth, dWidth);
        }
    }
    puzzles[0].red = true;
}

function draw() {
    context.clearRect(0, 0, canvasWidth, canvasWidth);
    let xPos = 0;
    let yPos = 0;
    puzzles.forEach(puzzle => {
        puzzle.xPos = xPos;
        puzzle.yPos = yPos;
        if (puzzle.hovered) {
            context.save();
            context.globalAlpha = 0.5;
        }
        context.drawImage(image, puzzle.sx, puzzle.sy, sWidth, sWidth, puzzle.xPos, puzzle.yPos, dWidth, dWidth);
        if (puzzle.hovered) {
            context.restore();
            puzzle.hovered = false;
        }
        xPos += dWidth;
        if (xPos >= canvasWidth) {
            xPos = 0;
            yPos += dWidth;
        }
    });

    context.fillStyle = '#ba2c59';
    context.fillRect(redPuzzle.xPos, redPuzzle.yPos, dWidth, dWidth);
}

function shuffle() {
    for (let i = 0; i < Math.pow(3, len); i++) {
    //for (let i = 0; i < 20; i++) {
        let dir = Math.floor(Math.random() * Math.floor(4));
        let idx = redPuzzle.index

        switch (dir) {
            case 0: { //top
                if ((idx - len) >= 0) {
                    redPuzzle.xPos = puzzles[idx - len].xPos;
                    redPuzzle.yPos = puzzles[idx - len].yPos;
                    redPuzzle.index -= len;
                    swap(puzzles, idx, idx - len);
                } else {
                    redPuzzle.xPos = puzzles[idx + len].xPos;
                    redPuzzle.yPos = puzzles[idx + len].yPos;
                    redPuzzle.index += len;
                    swap(puzzles, idx, idx + len);
                }
                break;
            }
            case 1: { //bottom
                if ((idx + len) < (len * len)) {
                    redPuzzle.xPos = puzzles[idx + len].xPos;
                    redPuzzle.yPos = puzzles[idx + len].yPos;
                    redPuzzle.index += len;
                    swap(puzzles, idx, idx + len);
                } else {
                    redPuzzle.xPos = puzzles[idx - len].xPos;
                    redPuzzle.yPos = puzzles[idx - len].yPos;
                    redPuzzle.index -= len;
                    swap(puzzles, idx, idx - len);
                }
                break;
            }
            case 2: { //right
                if ((idx + 1) % len != 0 && idx + 1 < len) {
                    redPuzzle.xPos = puzzles[idx + 1].xPos;
                    redPuzzle.yPos = puzzles[idx + 1].yPos;
                    redPuzzle.index += 1;
                    swap(puzzles, idx, idx + 1);
                } else {
                    redPuzzle.xPos = puzzles[idx - 1].xPos;
                    redPuzzle.yPos = puzzles[idx - 1].yPos;
                    redPuzzle.index -= 1;
                    swap(puzzles, idx, idx - 1);
                }
                break;
            }
            case 3: { //left
                if (((idx - 1) % len) != (len - 1) && idx != 0) {
                    redPuzzle.xPos = puzzles[idx - 1].xPos;
                    redPuzzle.yPos = puzzles[idx - 1].yPos;
                    redPuzzle.index -= 1;
                    swap(puzzles, idx, idx - 1);
                } else {
                    redPuzzle.xPos = puzzles[idx + 1].xPos;
                    redPuzzle.yPos = puzzles[idx + 1].yPos;
                    redPuzzle.index += 1;
                    swap(puzzles, idx, idx + 1);
                }
                break;
            }
            default: {
                break;
            }
        }
        // console.log("idx: " + redPuzzle.index);
        // console.log("x: " + redPuzzle.xPos);
        // console.log("y: " + redPuzzle.yPos);
    }

}

function movePuzzle(mouseX, mouseY) {
    puzzles.forEach((puzzle, index) => {
        if (mouseX > puzzle.xPos && mouseX < (puzzle.xPos + dWidth) && mouseY > puzzle.yPos && mouseY < (puzzle.yPos + dWidth)) {
            if (!puzzle.red) {
                if ((index - len) >= 0 && puzzles[index - len].red) { // top
                    redPuzzle.xPos = puzzle.xPos;
                    redPuzzle.yPos = puzzle.yPos;
                    redPuzzle.index = index;
                    swap(puzzles, index, index - len);
                } else if ((index + len) < (len * len) && puzzles[index + len].red) { // bottom
                    redPuzzle.xPos = puzzle.xPos;
                    redPuzzle.yPos = puzzle.yPos;
                    redPuzzle.index = index;
                    swap(puzzles, index, index + len);
                } else if (((index + 1) % len) != 0 && puzzles[index + 1].red) { // right
                    redPuzzle.xPos = puzzle.xPos;
                    redPuzzle.yPos = puzzle.yPos;
                    redPuzzle.index = index;
                    swap(puzzles, index, index + 1);
                } else if (((index - 1) % len) != (len - 1) && index != 0 && puzzles[index - 1].red) { // left
                    redPuzzle.xPos = puzzle.xPos;
                    redPuzzle.yPos = puzzle.yPos;
                    redPuzzle.index = index;
                    swap(puzzles, index, index - 1);
                }
                draw();
            }
        }
    });
}

function hoverPuzzle(mouseX, mouseY) {
    puzzles.forEach((puzzle, index) => {
        if (mouseX > puzzle.xPos && mouseX < (puzzle.xPos + dWidth) && mouseY > puzzle.yPos && mouseY < (puzzle.yPos + dWidth)) {
            if (!puzzle.red) {
                if ((index - len) >= 0 && puzzles[index - len].red) { // top
                    puzzle.hovered = true;
                } else if ((index + len) < (len * len) && puzzles[index + len].red) { // bottom
                    puzzle.hovered = true;
                } else if (((index + 1) % len) != 0 && puzzles[index + 1].red) { // right
                    puzzle.hovered = true;
                } else if (((index - 1) % len) != (len - 1) && index != 0 && puzzles[index - 1].red) { // left
                    puzzle.hovered = true;
                }
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

image.addEventListener('load', e => {
    if (firstInit) {
        init();
        draw();
        shuffle();
        draw();
        let idx = redPuzzle.index
        redPuzzle.xPos = puzzles[idx].xPos;
        redPuzzle.yPos = puzzles[idx].yPos;
        draw();
        firstInit = false
    }
});

canvas.addEventListener('click', e => {
    let rect = canvas.getBoundingClientRect();
    //let mouseX = e.clientX - rect.left;
    //let mouseY = e.clientY - rect.top;
    let mouseX = e.offsetX;
    let mouseY = e.offsetY;

    movePuzzle(mouseX, mouseY);
});

canvas.addEventListener('mousemove', e => {
    let rect = canvas.getBoundingClientRect();
    //let mouseXh = e.clientX - rect.left;
    //let mouseYh = e.clientY - rect.top;
    let mouseXh = e.offsetX;
    let mouseYh = e.offsetY;

    hoverPuzzle(mouseXh, mouseYh);
});

document.querySelectorAll('.gallery img').forEach(img => {
    img.addEventListener('click', e => {
        image.src = img.src;
        document.getElementById('hint').src = img.src;
        start();
    })
});

document.getElementById('btn').addEventListener('click', e => {
    len = parseInt(document.getElementById('len').value);
    start();
});

function start() {
    puzzles = [];
    redPuzzle = { xPos: 0, yPos: 0, index: 0 };
    sWidth = width / len;
    dWidth = canvas.width / len;
    init();
    draw();
    shuffle();
    draw();
    let idx = redPuzzle.index
    redPuzzle.xPos = puzzles[idx].xPos;
    redPuzzle.yPos = puzzles[idx].yPos;
    draw();
}

function loadImage(id) {
    let promise = new Promise((resolve, reject) => {
        let elem = document.querySelector(`.gallery :nth-child(${id})`);
        elem.src = `images/pic${id}.jpg`;
        elem.onload = () => { resolve(id) }
        elem.onerror = () => { reject(id) }
    })
}

Promise.all([loadImage(1), loadImage(2), loadImage(3), loadImage(4), loadImage(5), loadImage(6), loadImage(7), loadImage(8), loadImage(9), loadImage(10), loadImage(11), loadImage(12)]).then(() => {
    console.log("Images loaded")
}).catch(() => {
    console.log("Failed to load images");
});

