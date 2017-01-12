<?php

include_once 'ChessPosition.php';

Class ChessPlayer {
	public $name = false;
	public $movesCnt = 0;
	private $moves = array();
	private $initial = null;
	private $current = null;

	function __construct($name,$moves) {
		$this->name = $name;
		$this->moves = $moves;
	}

	public function reset() {
		$this->current = null;
		$this->initial = null;
	}

	public function getCurrent() {
		return $this->current;
	}

	public function setCurrent(ChessPosition $current) {
		$this->current = $current;
	}

	public function getInitial() {
		return $this->initial;
	}

	public function setInitial(ChessPosition $position) {
		$position->status = 1;
		$position->who = 'horse';
		$this->initial = $position;
		$this->current = $position;
		$this->movesCnt++;
	}

	public function getTotalMoves() {
		return $this->movesCnt;
	}

	public function move($size) {
		if (!$this->current) {
			throw new Exception($this->name+' requiere posición inicial');
		}
		$isValid = false;
		shuffle($this->moves);
		$currentMoves = $this->moves;
		$index = false;
		while(!$isValid && count($currentMoves)) {
			$mv = array_shift($currentMoves);
			$rM = $this->current->row+$mv[0];
			$cM = $this->current->cell+$mv[1];
			$index = $this->current->index+$mv[0]*$size + $mv[1];
			if ($rM > -1 && $rM < $size && $cM > -1 && $cM < $size && $index < $size * $size) {
				$isValid = true;
				$index = $this->current->index+$mv[0]*$size+$mv[1];
			}
		}
		$this->movesCnt++;
		return $index;
	}

}