<?php
Class MyComplex {
	public $_R;
	public $_I;	
	public function __construct($r, $i) {
		$this->_R = $r;
		$this->_I = $i;
	}	
	public function __toString():string {
		if ($this->_I == 0.0) {
			return $this->_R;
		} elseif ($this->_I < 0.0) {
			return $this->_R . ' - ' . abs($this->_I) . 'i';
		} else {
			return $this->_R . ' + ' . $this->_I . 'i';
		}
	}	
	public function equals($num) {
		if (is_a($num, 'MyComplex')) {
			return ($num->r == $this->_R && $num->i == $this->_I);
		} else {
			return (floatval($num) == $this->_R && $this->_I == 0.0);
		}
	}	
	public function abs() {
		return sqrt($this->_R * $this->_R + $this->_I * $this->_I);
	}	
	public function arg() {
		return atan2($this->_I, $this->_R);
	}	
	public function neg() {
		return new MyComplex(-$this->_R, -$this->_I);
	}	
	public function conj() {
		return new MyComplex($this->_R, -$this->_I);
	}	
	public function inverse() {
		$denom = $this->_R * $this->_R + $this->_I * $this->_I;
		if ($denom == 0.0) {
			throw new Exception("Деление на ноль не 0 не допустимо #$this->_R * $this->_R + $this->_I * $this->_I=$denom#.");
		} else {
			return new MyComplex($this->_R / $denom, -$this->_I / $denom);
		}
	}	
	public function add($num) {
		if (is_a($num, 'MyComplex'))
			return new MyComplex($this->_R + $num->_R, $this->_I + $num->_R);
		else 
			return new MyComplex($this->_R + floatval($num), $this->_I);
	}	
	public function sub($num) {
		if (is_a($num, 'MyComplex'))
			return new MyComplex($this->_R - $num->_R, $this->_I - $num->_I);
		else 
			return new MyComplex($this->_R - floatval($num), $this->_I);
	}	
	public function mul($num) {
		if (is_a($num, 'MyComplex')) {
			return new MyComplex(
					$this->_R * $num->_R - $this->_I * $num->_I, 
					$this->_I * $num->_R + $this->_R * $num->_I);
		} else {
			$real = floatval($num);
			return new MyComplex($this->_R * $real, $this->_I * $real); 
		}
	}	
	public function div($num) {
		if (is_a($num, 'MyComplex')) {
			$denom = $num->_R * $num->_R + $num->_I * $num->_I;
			if ($denom == 0.0) {
				throw new Exception('Деление на ноль не 0 не допустимо.');
			} else {
				return new MyComplex(
						($this->_R * $num->_R + $this->_I * $num->_I) / $denom, 
						($this->_I * $num->_R - $this->_R * $num->_I) / $denom);
			}
		} else {
			$real = floatval($num);
			if ($real == 0.0) {
				throw new Exception('Деление на ноль не 0 не допустимо.');
			} else {
				return new MyComplex($this->_R / $real, $this->_I / $real);
			}
		}
	}	
	public function pow($num) {
		if ($this->_R == 0.0 && $this->_I = 0.0) {
			return new MyComplex(0.0, 0.0);
		} else {
			$logabs = log($this->abs());
			$arg = $this->arg();
			if (is_a($num, 'MyComplex')) {
				$pabs = exp($num->_R * $logabs - $num->_I * $arg);
				$parg = $num->_I * $logabs + $num->_R * $arg;
			} else {
				$real = floatval($num);
				$pabs = exp($real * $logabs);
				$parg = $real * $arg;
			}
			return new MyComplex($pabs * cos($parg), $pabs * sin($parg));
		}
	}	
	public function sqrt() {
		if ($this->_R == 0.0 && $this->_I == 0.0) {
			return new MyComplex(0.0, 0.0);
		} else {
			$abs = $this->abs();
			if ($this->_I < 0.0) {
				return new MyComplex(sqrt(($abs + $this->_R) / 2), -sqrt(($abs - $this->_R) / 2));
			} else {
				return new MyComplex(sqrt(($abs + $this->_R) / 2), sqrt(($abs - $this->_R) / 2));
			}
		}
	}
}
function sqrtExt($real, $forceComplex = false) {
	if ($real < 0.0) {
			return new MyComplex(0.0, sqrt(-$real));
	} else {
		if ($forceComplex) {
			return new MyComplex(sqrt($real), 0.0);
		} else {
			return sqrt($real);
		}
	}
}

function CreatecCmplex($r=0.0, $i = 0.0) {
	return new MyComplex($r, $i);
}
?>
<html>
<head>
<title>Комплексные числа</title>
<meta charset="utf-8">
</head>
<body>
<?php
$a0=CreatecCmplex();
$ai=CreatecCmplex(12.9);
$a1=CreatecCmplex(1.8,-8.9);
$a2=CreatecCmplex(-8.5,8.9);
$a3=CreatecCmplex(1.8,-1.7);
$a4=CreatecCmplex(5,5);
$o1=$a2->add($a3);
$o2=$a2->sub($a3);
$o3=$a2->div($a3);
$o4=$a2->pow($a3);
echo "$a0; $ai; $a1; $a2; $a3; $a4;<hr>";

echo "[$a2] + [$a3] = $o1<hr>[$a2] - [$a3] = $o2<hr>[$a2] / [$a3] = $o3<hr>[$a2] * [$a3] = $o4";
?>
<body>
<html>
