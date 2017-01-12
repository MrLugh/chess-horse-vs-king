<?php

Class ChessPosition {
	public $index = null;
	public $cell = null;
	public $row = null;
	public $odd = null;
	public $status = null;
	public $who = null;

	function __construct($row,$cell,$index,$odd) {
		$this->row = $row;
		$this->cell = $cell;
		$this->index = $index;
		$this->odd = $odd;
		$this->status = 0;
	}
}