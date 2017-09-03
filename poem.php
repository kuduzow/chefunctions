<?php 

/*
Зезаг ду бацалахь лепаш
Iуьйренца бецахи муьлуш
Ду иза хазалла дуьйцуш
Цул хаз бу сан даймохк буйьцуш
*/

// write function for split word on syllable

class Poem {
	private $listOfNouns = array();
	private $listOfVerbs = array();
	private $listOfToBeVerbs = array();

	private $fileWithListOfNouns = "nouns.txt";
	private $fileWithListOfVerbs = "verbs.txt";

	public function __construct() {
		mb_internal_encoding("UTF-8");

		$this->setListOfNouns();
		$this->setListOfVerbs();
		$this->setListOfToBeVerbs();
	}

	public function __toString() {
		//print_r($this->listOfVerbs);

		$s11 = $this->getRandomVerb();
		$s13 = trim($this->getRandomNoun());
		$s14 = $this->getRandomVerb();
		$s15 = $this->getRandomToBeVerb();

		$s21 = trim($this->getRandomNoun());
		//$s22 = $this->getRandomNoun();
		$s23 = $this->getRandomVerb();

		$s31 = $this->getRandomNoun();
		$s32 = trim($this->getRandomNoun());
		//$s33 = $this->findRhyme($s15, $this->listOfVerbs);
		$s33 = $this->getRandomToBeVerb();

		$s41 = trim($this->getRandomNoun());
		//$s42 = $this->getRandomNoun();
		$s43 = $this->findRhyme($s23, $this->listOfVerbs);

		$str = $s11 . " " . $s13 . " " . $s15 . 
		       "<br>" . 
		       $s21 . " " . $s23 . 
		       "<br>" . 
		       $s31 . " " . $s32 . " " . $s33 . 
		       "<br>" . 
		       $s41 . " " . $s43;

		return $str;

	}

	private function setListOfToBeVerbs() {
		$this->listOfToBeVerbs = array(
			"ву", "ду", "ю", "бу"
			);
	}

	private function getRandomToBeVerb() {
		return $this->listOfToBeVerbs[array_rand($this->listOfToBeVerbs)];
	}

	private function setListOfNouns() {
		$this->listOfNouns = file($this->fileWithListOfNouns);
	}

	private function setListOfVerbs() {
		$this->listOfVerbs = file($this->fileWithListOfVerbs);
	}

	private function getRandomNoun() {
		return $this->listOfNouns[array_rand($this->listOfNouns)];
	}

	private function getRandomVerb() {
		return $this->listOfVerbs[array_rand($this->listOfVerbs)];
	}

	private function findRhyme($word, $array) {
		shuffle($array);

		$word = trim($word);
		$endOfWord = $this->getEndOfTheWord($word);

		foreach ($array as $value) {
			if(preg_match("/$endOfWord\s?$/i", $this->getEndOfTheWord(trim($value)))) {
				return $value;
			}	
		}

		return $word;
	}

	private function getEndOfTheWord($word, $length = 3) {
		if(mb_strlen($word) > $length) {
			$endOfWord = mb_substr($word, 0 - $length);
		} 
		else {
			$endOfWord = $word;
		}

		return $endOfWord;
	}
}

$poem = new Poem();

echo $poem;