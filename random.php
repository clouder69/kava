<?php
class detect {

	private $input;//zadany vstup
	private $coffee;//kaluze
	private $actual = 0;//aktualna kaluz

	/*
	 * Vyhodnotenie pola
	 */
	public function evaluation( $input ) {
		$this->input = $input;

		foreach( $this->input as $r => $r_val ) {

			foreach( $this->input[$r] as $c => $c_val) {

				if( $this->input[$r][$c] == 0 )//0 ignoruje
					continue;

				$this->around( $r, $c );//rekurzivne preveri okolie
				$this->actual++;	
			}	
		}
	}

	/*
	 * Prejde okolie daneho bodu
	 */
	private function around( $r, $c ) {
		$this->insert( $r, $c );

		for( $i = ( $r == 0 ) ? 0 : -1; $i <= 1; $i++ ) {//prejde okolie

			if( !isset($this->input[$r+$i]) )//ked sa dostane za posledny riadok
				break;

			for( $j = ( $c == 0 ) ? 0 : -1; $j <= 1; $j++ ) {

				if( !isset($this->input[$r+$i][$c+$j]) )//ked sa dostane za posledny stlpec
					break;

				if( $this->input[$r+$i][$c+$j] == 0 )//ak pole nie je poliate, ignoruje
					continue;

				$this->around( $r+$i, $c+$j );//preveri okolie aktualneho pola
			}
		}
	}

	/*
	 * Vlozi pole do kaluze
	 */
	private function insert( $r, $c ) {
		if(!isset($this->coffee[$this->actual]))
			$this->coffee[$this->actual] = array();

		$this->input[$r][$c] = 0;//prepiseme na nulu, nemusime to dalej uz specialne kontrolovat
		array_push( $this->coffee[$this->actual], array( 'r' => $r, 'c' => $c ) );
	}

	/*
	 * Vypise najvacsiu kaluz
	 */
	public function biggest() {
		$biggest = 0;

		foreach( $this->coffee as $d ) {
			if( count( $d ) > $biggest )
				$biggest = count( $d );
		}
		return $biggest;
	}

	/*
	 * Vypise pocet kaluzi
	 */
	public function countcoffee() {
		return count( $this->coffee );
	}
}

$table = array_fill(0, 10, array_fill(0, 10, 0));

foreach($table as $r => $i)
	foreach($i as $c => $j)
		$table[$r][$c] = rand(0,1);

?>

<h1>Úloha:</h1>
<p>Na vstupe je dvojrozmerné pole, ktoré obsahuje 0 a 1. Pole reprezentuje stôl, 0 znamená, že na stole nič nie je, 1 znamená, že na stole je rozliata káva.</p>
<p>Algoritmus: Napíšte algoritmus, ktorý nájde na stole najväčšiu kaluž a vypíše celkový počet kaluží. Za jednu kaluž možno považovať skupinu jednotiek, ktoré majú spoločnú hranu alebo vrchol (ak sa dotýkajú len diagonálne, môžete ich povazovať tiež za jednu kaluž)</p>
<p>Ďalšie informácie: Výhodou (nie však podmienkou) je objektové riešenie úlohy a najmä správny objektový návrh. Riešenie musí byť napísané v jazyku PHP.</p>
<br/>

<table cellspacing="0" border="0">
	<tbody>
		<?php foreach( $table as $r => $r_val ): ?>
		<tr>
			<?php foreach( $table[$r] as $c => $c_val ): ?>
			<td width="30" background="<?= $c_val ? 'coffee.jpg' : 'wood.jpg' ?>" height="30"><center<?php if($c_val) echo ' style="color:white;font-weight:bold;"'; ?>><?= $c_val; ?></center></td>
			<?php endforeach; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php

$detect = new detect;
$detect->evaluation( $table );
echo "Najvacsia kaluz ma ".$detect->biggest()." prvkov.<br>";
echo "Pocet kaluzi je ".$detect->countcoffee().".";

?>