<?php

include_once 'ChessPosition.php';
include_once 'ChessPlayer.php';

Class Chess {

	CONST SIZE = 8;

	private $matrix = array();
	private $playing = false;
	private $turn = false;
	private $winner = false;
	private $traceCount = 0;
	private $players = array();

	private function reset() {
		$this->matrix = array();
		$this->traceCount = 0;
		$this->playing = false;
		$this->turn = 0;
		$this->winner = false;
	}

	public function addPlayer(ChessPlayer $player) {
		array_push($this->players, $player);
	}

	public function init() {
		$this->reset();
		$index = 0; $rowCnt = 0; $cellCnt; $odd = 1;
		for ($row=0;$row<self::SIZE;$row++) {
			$cellCnt = 0;
			for ($cell=0;$cell<self::SIZE;$cell++) {
				$position = new ChessPosition($rowCnt,$cellCnt,$index,$odd);
				array_push($this->matrix,$position);
				$odd = !$odd;
				$index++;
				$cellCnt++;
			}
			$rowCnt++;
			$odd = !$odd;
		}
	}

	public function getMatrix() {
		return $this->matrix;
	}

	public function isPlaying() {
		return $this->isPlaying;
	}

	public function getWinner() {
		return $this->winner;
	}

	public function getTraceCount() {
		return $this->traceCount;
	}

	public function play() {
		if (count($this->players) != 2) {
			throw new Exception('Sólo se permiten 2 jugadores');
		}
		$this->playing = true;
		$this->traceCount = count($this->players);
		$this->doPlay();
	}

	private function doPlay() {

		$who = $this->turn ? $this->players[1] : $this->players[0];
		$wait = $this->turn ? $this->players[0] : $this->players[1];
		$index = $who->move(self::SIZE);

		if ($index !== false) {
			$this->traceCount++;
			$current = $this->matrix[$index];
			$current->status = 1;
			$who->setCurrent($current);
			if ($current->index == $wait->getCurrent()->index) {
				$this->winner = $who;
			} else {
				$current->who = $who->name;
			}
		}

		if ($this->winner) {
			return;
		}

		$this->turn++;
		if ($this->turn >= count($this->players)) {
			$this->turn = 0;
		}

		$this->doPlay();
	}
}

?>