var game_canvas = document.querySelector("#game_canvas");
var game_context = game_canvas.getContext("2d");

function draw_rect(x, y, width, height)
{
    game_context.beginPath();
    game_context.fillStyle = "cornflowerblue";
    //game_context.fillRect(x, y, width, height);
    game_context.fillText('', 100, 100);
    game_context.endPath();
}

var x = 1;

function Render()
{
    game_context.clearRect(0, 0, 500, 500);

    //x++;
    draw_rect(x, 10, 20, 20);
}


setInterval(Render, 10);

