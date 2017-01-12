<?php

include_once 'model/Chess.php';
include_once 'model/ChessPlayer.php';

if (count($argv) != 3) {
	echo "Parametros incorrectos!\n";
	echo "Pruebe: chess.php intPosInicial1 intPosInicial2\n";
	exit;
}

if ($argv[1] == $argv[2]) {
	echo "Parametros incorrectos!\n";
	echo "Las posiciones iniciales no pueden ser iguales!\n";
	exit;
}

$max = (Chess::SIZE * Chess::SIZE) -1;

if ($argv[1] < 0 || $argv[1] > $max ) {
	echo "intPosInicial1 incorrecta!\n";
	echo "Valores entre\n";
	echo printf("%d,%d\n",0,$max);
	exit;
}

if ($argv[2] < 0 || $argv[2] > $max ) {
	echo "intPosInicial2 incorrecta!\n";
	echo "Valores entre\n";
	echo printf("%d,%d\n",0,$max);
	exit;
}

$chess = new Chess();
$horse = new ChessPlayer('Horse',array(
	array(2,1),
	array(1,2),
	array(-1,2),
	array(-2,1),
	array(-2,-1),
	array(-1,-2),
	array(1,-2),
	array(2,-1)
));

$king = new ChessPlayer('King',array(
	array(1,0),
	array(1,1),
	array(0,1),
	array(-1,1),
	array(-1,0),
	array(-1,-1),
	array(0,-1),
	array(1,-1)
));

$chess->init();
$matrix = $chess->getMatrix();

$horse->setInitial($matrix[$argv[1]]);
$king->setInitial($matrix[$argv[2]]);

$chess->addPlayer($horse);
$chess->addPlayer($king);

$chess->play();

$winner = $chess->getWinner();

echo "\nWinner:";
echo $winner->name;
echo "\nMovimientos:";
echo $winner->getTotalMoves();
echo "\nTurnos de la partida:";
echo $chess->getTraceCount();
echo "\n";

?>